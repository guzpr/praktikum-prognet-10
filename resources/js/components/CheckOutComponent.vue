<template>
    <div>
        {{shippingCost}}
        <div class="bg-light py-3">
        <div class="container">
            <div class="row">
            <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
            </div>
        </div>
        </div>

        <div class="site-section"> 

            <div class="container">
                <div v-if="loading" class="my-5">
                    <loading-component></loading-component>
                </div>
                <template v-else>
                    <h3 class="my-2">Checkout</h3>
                    <div class="row mb-5" v-if="cart.length>0">
                        <div class="col-6">
                            <h5 class="mt-4">Item Details</h5>
                            <hr/>
                            <div class="col-12 my-2 rounded p-2" v-for="item in cart" :key="item.id">
                                <div class="row">
                                    <div class="col-3">
                                        <img style='height: 100%; width: 100%; object-fit: contain' :src="item.products.image[0].image_name" alt="">
                                    </div>
                                    <div class="col-9">
                                        <h6>{{item.products.product_name}}</h6>
                                        <h6 style="color:#7971EA">{{translateThousand(item.products.price)}}</h6>
                                        <h6 class="my-2">{{item.qty}} item(s) : {{formatWeight(item.qty * item.products.weight) }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <h5>Total weight : {{formatWeight(totalWeight)}}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mt-4">Shipping Details</h5>
                            <hr/>
                            <div class="row">
                                <b-form-group
                                    label="Address* :" class="col-12"
                                >
                                    <b-form-input
                                        id="input-live"
                                        v-model="form.address"
                                        placeholder="Enter your address"
                                        trim
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    label="Province* :" class="col-6"
                                >
                                    <multiselect 
                                    track-by="province_id" 
                                    label="province" 
                                    v-model="provinceSelected" 
                                    :options="province"
                                    :allow-empty="false"
                                    :showLabels="false"
                                    :loading="isProvinceLoading"
                                    @input="getCities"
                                    ></multiselect>
                                </b-form-group>
                                <b-form-group
                                    label="City* :" class="col-6"
                                >
                                    <multiselect 
                                    track-by="city_id" 
                                    label="city_name" 
                                    v-model="citySelected" 
                                    :options="cities"
                                    :disabled="isCitiesDisabled"
                                    :loading="isCitiesLoading"
                                    ></multiselect>
                                </b-form-group>
                                <b-form-group class="col-12" label="Courier : ">
                                    <b-form-radio-group class="ml-3" v-model="courierSelected">
                                            <b-form-radio class="col-4"  v-for="courier in courier" :key="courier.id" :value="courier">{{courier.courier_name}}</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                                <b-form-group
                                    label="Packet* :" class="col-12"
                                    description="Please select city and courier first"
                                >
                                    <multiselect 
                                    v-model="packetSelected" 
                                    :options="packetOptions"
                                    :disabled="isPacketDisabled"
                                    :loading="isPacketLoading"
                                    track-by="service"
                                    :custom-label="packetName" 
                                    ></multiselect>
                                </b-form-group>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-else>
                        <div class="col-12 text-center" >
                            <img src="/img/no_cart.svg"  width="300" height="300" alt="">
                            <h3 class="my-2">There is currently no item in your cart</h3>
                        </div>
                    </div>
                </template>

                <div class="row">
                    <div class="col-md-5">
                        <div class="row mb-5">
                        <div class="col-md-6">
                            <button @click.prevent="redirectHome" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button>
                        </div>
                        </div>
                        
                    </div>
                    <div class="col-md-7 pl-5" v-if="cart.length>0">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <span class="text-black">Item total price :</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"> {{translateThousand(totalPrice)}}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-black">Shipping total cost :</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"> {{translateThousand(packetSelected ? packetSelected.cost[0].value : 0 )}}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-black">Estimated time :</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"> {{packetSelected ? packetSelected.cost[0].etd : '-'}} days</strong>
                                    </div>
                                    <div class="col-md-6 my-3">
                                        <span class="text-black">Sub Total :</span>
                                    </div>
                                    <div class="col-md-6 text-right my-3">
                                        <strong class="text-black"> {{translateThousand(totalPrice + (packetSelected ? packetSelected.cost[0].value : 0 ))}}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                            <button @click.prevent="postTransaction" :disabled="isPayDisabled" class="btn btn-primary btn-lg py-3 btn-block">Pay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert';
import { debounce } from "debounce";
import { EventBus } from '../event-bus.js';
import LoadingComponent from './LoadingComponent';
import Multiselect from 'vue-multiselect'

export default {
    components:{
        LoadingComponent,Multiselect  
    },
    data(){
        return{
            courier:[],
            courierSelected:null,
            cart:[],
            loading:true,
            province:[],
            provinceSelected:null,
            cities:[],
            citySelected:null,
            test:null,
            form:{
                address:null,
                regency:null,
                city:null,
                total:null,
                shippingCost:null,
                subTotal:null,
                courier:null,
                cart:null
            },
            packetOptions:[],
            packetSelected:null,
            shippingPrice:false,
            isCitiesDisabled:false,
            isCitiesLoading:false,
            isPacketDisabled:false,
            isPacketLoading:false,
            isProvinceLoading:true,
            isGetPacket:false
        }
    },
    mounted(){
        this.loadCart()
        axios.get('/api/rajaongkir/province').then(res=>{
            this.province = res.data.rajaongkir.results;
            this.isProvinceLoading = false;
        });
        axios.get('/api/courier').then(res=>{
            this.courier = res.data;
        });
    },
    methods:{
        translateThousand(price){
            return `Rp ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        },
        remove(item){
            swal({
                title: 'Peringatan!',
                text: 'Apakah anda yakin untuk menghapus cart?',
                icon: "warning",
                buttons: {
                    cancel: "Cancel",
                    confirm: {
                        text: "Ya,hapus",
                        value: true,
                        closeModal: false,
                    }
                },
                dangerMode: true,
            })
            .then(val => {
                item._method = 'delete';
                return axios.post('/api/cart',item)
            })
            .then(results => {
                swal({
                    icon:"success",
                    title: "Success!",
                    text: "Berhasil menghapus cart",
                });
                console.log(results);
                this.loadCart();
            })
            .catch(err=>{
                console.log(err.response)
            })
        },
        loadCart(){
            this.loading = true;
            axios.get('/api/cart').then(res=>{
                this.cart = res.data;
                this.loading = false;
            })
        },
        getCities(value){
            this.citySelected = null;
            this.isCitiesLoading = true;
            this.isCitiesDisabled = true;
            axios.get(`/api/rajaongkir/province/${value.province_id}/city`).then(res=>{
                this.cities = res.data.rajaongkir.results;
                this.isCitiesLoading = false;
                this.isCitiesDisabled = false;
            })
        },
        formatWeight(weight) {
            if(weight < 1000) return weight + " g";
            else return (weight / 1000).toFixed(1) + " kg";
        },
        getCost(){
            this.isPacketDisabled = true;
            this.isPacketLoading = true;
            this.packetSelected = null;
            this.packetOptions = [];  
            let data = {
                "destination":this.citySelected.city_id,
                "courier":this.courierSelected.courier,
                "weight":this.totalWeight
            }
            axios.post('/api/rajaongkir/cost',data).then(res=>{
                this.packetOptions = res.data.rajaongkir.results[0].costs;
                this.isPacketDisabled = false;
                this.isPacketLoading = false;
            })
            .catch(err=>{
                console.log(err.response)
            })
        },
        packetName(val){
            return `${val.description} (${val.service}) ${this.translateThousand(val.cost[0].value)}`            
        },
        postTransaction(){
            this.form.regency = this.provinceSelected.province_id;
            this.form.city = this.citySelected.city_id;
            this.form.shippingCost = this.packetSelected.cost[0].value;
            this.form.courier = this.courierSelected.id;
            this.form.subTotal = this.totalPrice + this.packetSelected.cost[0].value;
            this.form.total = this.totalPrice;
            this.form.cart = this.cart;
            axios.post('/api/transaction',this.form).then(res=>{
                console.log(res);
            }).catch(err=>{
                console.log(err.response)
            })
        }
    },
    computed:{
        totalPrice(){
            return this.cart.reduce((sum,val)=>{
                return sum + val.products.price * val.qty
            },0)
        },
        shippingCost(){
            if(this.courierSelected != null && this.citySelected != null){
                this.isGetPacket = true;
            } else {
                this.isGetPacket = false;
            }
        },
        isPayDisabled(){
            return (this.courierSelected == null || this.citySelected == null || this.provinceSelected == null || 
            this.packetSelected == null || this.form.address == null)
        },
        totalWeight(){
            return this.cart.reduce((sum,val)=>{
                return sum + val.products.weight * val.qty
            },0)
        }
        
    },
    watch: {
        isGetPacket:{
            handler:function(val){
                if(val == true)
                    this.getCost();
            }
        },
        courierSelected:{
            handler:function(val){
                this.isGetPacket = false;
            }
        },
        citySelected:{
            handler:function(val){
                this.isGetPacket = false;
            }
        },
    }
}
</script>

<style>
.cover {
  object-fit: cover;
}
.rounded {
    border-radius: 25px;
    border-style: solid;
    border-color: #DFDFDF;
    border-width: thin;
}
</style>
