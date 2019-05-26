<template>
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1 m-b-25">Transaction</h2>
            </div>
            <div class="table-responsive table--no-card m-b-40">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Address</th>
                                    <th>Regency</th>
                                    <th>City</th>
                                    <th>Total</th>
                                    <th>Shipping Cost</th>
                                    <th>Sub Total</th>
                                    <th>Detail</th>
                                    <th>User</th>
                                    <th>Courier</th>
                                    <th>Proff of Payment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in transaction" :key="transaction.id">
                                    <td>
                                        {{parseDate(transaction.created_at)}}
                                    </td>
                                    <td>
                                        {{transaction.address}}
                                    </td>
                                    <td>
                                        {{transaction.regency_province ? transaction.regency_province : 'Loading ...'}}
                                    </td>
                                    <td>
                                        {{transaction.regency_city ? transaction.regency_city : 'Loading ...'}}
                                    </td>
                                    <td>
                                        {{translateThousand(transaction.total)}}
                                    </td>
                                    <td>
                                        {{translateThousand(transaction.shipping_cost)}}
                                    </td>
                                    <td>
                                        {{translateThousand(transaction.sub_total)}}
                                    </td>
                                    <td>
                                        <button @click="seeDetails(transaction.id)"  class="btn btn-outline-primary"  type="button"><i class="fas fa-search"></i></button>
                                    </td>
                                    <td>
                                        {{transaction.user.name}}
                                    </td>
                                    <td>
                                        {{transaction.courier.courier_name}}
                                    </td>
                                    <td>
                                        <a v-if="transaction.proof_of_payment" target="_blank" :href="`/files/${transaction.proof_of_payment}`">Proff of payment</a>
                                        <p v-else> None </p>
                                    </td>
                                    <td>
                                        {{transaction.status}}
                                    </td>
                                    <td>
                                        <button v-if="transaction.status=='pending' || transaction.status=='verified' " class="btn btn-outline-primary"  @click="changeStatus(transaction)" type="button"><i class="fas" :class="{'fa-check':transaction.status=='pending','fa-truck-moving':transaction.status=='verified'}"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
            </div>
        </div>
        <modal name="detail"  :height="'auto'" :adaptive="true"  :scrollable="true">
            <div class="row m-2">
                <h4 class="my-2">Product Details</h4>
                <div class="col-12 my-2" v-for="item in detail" :key="item.id">
                    <div class="row">
                        <div class="col-3">
                            <img style='height: 100%; width: 100%; object-fit: contain' :src="`/${item.products.image[0].image_name}`" alt="">
                        </div>
                        <div class="col-9">
                            <h6>{{item.products.product_name}}</h6>
                            <h6 style="color:#7971EA">{{translateThousand(item.products.price)}}</h6>
                            <h6 class="my-2">{{item.qty}} item(s) : {{formatWeight(item.qty * item.products.weight) }}</h6>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </modal>
    </div>
</template>

<script>
import { format } from 'date-fns'

export default {
    mounted(){
        this.loadTransaction()
    },
    methods:{
        parseDate(date){
            return format(date,"DD MMMM YYYY")
        },
        translateThousand(price){
              return `Rp. ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        },
        changeStatus(transaction){
            var status;
            if(transaction.status == 'pending'){
                status = 'verified'
            }
            if(transaction.status == 'verified'){
                status = 'delivered'
            }
            swal({
                title: 'Warning!',
                text: `Are you sure to change this transaction status from ${transaction.status} to ${status}?`,
                icon: "warning",
                buttons: {
                    cancel: "Cancel",
                    confirm: {
                        text: "Yes,confirm",
                        value: true,
                        closeModal: false,
                    }
                },
                dangerMode: true,
            }).then(val => {
                if (!val) throw null
                return axios.post('/api/transaction/changestatus',{
                    transaction_id:transaction.id,
                    user_id:transaction.user.id,
                    status:status
                })
            })
            .then(results => {
                swal({
                    icon:"success",
                    title: "Success!",
                    text: "Successfuly change transaction status",
                });
                this.loadTransaction();
            })
            .catch(err=>{
                 if (err) {
                    swal("Error!", "Error on confirming transaction", "error");
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            })
            
        },
        seeDetails(id){
            axios.get(`/api/transaction/${id}/details`).then(res=>{
                this.detail = res.data;
                this.loading = false;
                this.$modal.show('detail')
            })
        },
        formatWeight(weight) {
            if(weight < 1000) return weight + " g";
            else return (weight / 1000).toFixed(1) + " kg";
        },
        loadTransaction(){
            var transaction = axios.get('/api/transaction/all').then(res=>{
                this.transaction = res.data;
            })
            transaction.then(_=>{
                axios.get('/api/rajaongkir/province').then(res=>{
                    this.regency = res.data.rajaongkir.results;
                    this.transaction = this.transaction.map(transaction=>{
                        var regency = this.regency.find(province=>{
                            return province.province_id == transaction.regency
                        })
                        transaction.regency_province = regency.province;
                        return transaction;
                    })
                })
            })
            transaction.then(_=>{
                axios.get('/api/rajaongkir/city').then(res=>{
                    this.city = res.data.rajaongkir.results;
                    this.transaction = this.transaction.map(transaction=>{
                        var city = this.city.find(city=>{
                            return city.city_id == transaction.city
                        })
                        transaction.regency_city = city.city_name;
                        return transaction;
                    })
                })
            });
        }
    },
    data(){
        return{
            transaction:[],
            regency:[],
            city:[],
            detail:null
        }
    },
}
</script>

<style>

</style>
