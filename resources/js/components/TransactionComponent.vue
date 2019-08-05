<template>
    <div>
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Transaction</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <h3 class="my-2">My Transaction</h3>
                <div v-if="loading" class="my-5">
                    <loading-component></loading-component>
                </div>
                <template v-else>
                    <div class="row mb-5" v-if="transaction.length>0">
                        <div class="col-12 my-2" v-for="item in transaction" :key="item.id">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="card-text"  style="font-weight:700">{{parseDate(item.created_at)}}</h6>
                                        </div>
                                        <div class="col-6 text-right">
                                            <h6 class="text-right badge" :class="{'badge-warning':item.status == 'unverified' || item.status == 'pending','badge-primary':item.status == 'verified','badge-danger':item.status == 'expired','badge-success':item.status =='success','badge-info':item.status =='delivered'}"  style="text-transform:capitalize">{{item.status}}</h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row border-between">
                                        <div class="col-3">
                                            <div class="timeout" v-if="item.status == 'unverified'">
                                                <strong><p style="color:#DF2935;font-weight:700">Time left for proof of payment upload:</p></strong>
                                                <Countdown :end="countdown(item.timeout)"></Countdown>
                                            </div>
                                            <div class="pending" v-if="item.status == 'pending'">
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img src="/img/time.svg"  width="60" height="60" alt="">
                                                        <h6 class="my-2">Please wait for admin to verify your proof of payment</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="verified" v-if="item.status == 'verified'">
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img src="/img/success.svg" style="color:#5a50e5"  width="60" height="60" alt="">
                                                        <h6 class="my-2">Your proof of payment has been verified by admin. <br> Please wait for our delivery</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="delivered" v-if="item.status == 'delivered'">
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img src="/img/present.svg" style="color:#5a50e5"  width="60" height="60" alt="">
                                                        <h6 class="my-2">Your item has been delivered to your address</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="success" v-if="item.status == 'success'">
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img src="/img/like.svg" style="color:#5a50e5"  width="60" height="60" alt="">
                                                        <h6 class="my-2">Thanks for trusting us! Please give our item a review</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="success" v-if="item.status == 'expired'">
                                                <div class="row">
                                                    <div class="col-12 text-center my-3">
                                                        <img src="/img/close.svg" style="color:#5a50e5"  width="60" height="60" alt="">
                                                        <h6 class="my-2">Your transaction has been expired</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="row">
                                                <div class="col-4">
                                                    Product total <br>
                                                    <span class="price">{{translateThousand(item.total)}}</span>
                                                </div>
                                                <div class="col-4">
                                                    Shipping cost <br>
                                                    <span class="price">{{translateThousand(item.shipping_cost)}}</span>
                                                </div>
                                                <div class="col-4">
                                                    Address:
                                                    <br>
                                                    <span class="price">{{item.address}}</span>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <button @click="seeDetails(item.id)" class="btn btn-outline-primary btn-sm btn-block">See product details</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                
                                                <div class="col-12 text-right">
                                                    Transaction total:
                                                    <br>
                                                    <span class="price" style="font-size:1.5rem">{{translateThousand(item.sub_total)}}</span>
                                                </div>
                                                <div class="col-12 text-right mt-2" v-if="item.status == 'unverified' ">
                                                    <transition-group name="slide-fade">
                                                        <button @click="showUploadImage(item.id)" :key="item.id + 2" v-if="transactionSelected != item.id " class="btn btn-outline-primary btn-sm btn-block float-right">Upload proof</button>
                                                        <upload-file-component @error="errorUpload" @loadingFinished="successUpload" @progress="cancelButtton = true" :key="transactionSelected" v-if="transactionSelected == item.id" :id="item.id"></upload-file-component>
                                                        <button @click="transactionSelected = null" :disabled="cancelButtton" :key="item.id + 1" v-if="transactionSelected == item.id" class="btn btn-outline-danger btn-sm btn-block float-right">Cancel</button>
                                                    </transition-group>
                                                </div>
                                                <div class="col-12 text-right mt-2" v-if="item.status == 'delivered' ">
                                                        <button @click="confirmTransaction(item.id)" class="btn btn-outline-primary btn-sm btn-block float-right">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-else>
                        <div class="col-12 text-center" >
                            <img src="/img/no_payment.svg"  width="300" height="300" alt="">
                            <h3 class="my-2">You don't have any transaction currently </h3>
                        </div>
                    </div>
                </template>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-5">
                        <div class="col-md-6">
                            <a href="/product">
                                <button class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button>                    
                            </a>
                        </div>
                        </div>
                        
                    </div>
                </div>
                

            </div>
        </div>

        <modal name="detail"  :height="'auto'" :adaptive="true"  :scrollable="true">
            <div class="row m-2">
                <h4 class="my-2">Product Details</h4>
                <div class="col-12 my-2" v-for="item in detail" :key="item.id">
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
                <hr>
            </div>
        </modal>
    </div>
</template>

<script>
import swal from 'sweetalert';
import LoadingComponent from './LoadingComponent'
import Countdown from './Countdown'
import { format } from 'date-fns'
import UploadFileComponent from "./UploadFileComponent"

export default {
    components: { Countdown, UploadFileComponent },
    data(){
        return{
            loading:true,
            transaction:[],
            transactionSelected:null,
            cancelButtton:false,
            detail:[],
        }
    },
    mounted(){
        this.loadTransaction();
    },
    methods:{
        parseDate(date){
            return format(date,"MMMM DD, YYYY")
        },
        countdown(date){
            var ea = format(date,"MMMM DD, YYYY").toString();
            return ea;
        },
        translateThousand(price){
            return `Rp ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        },
        showUploadImage(id){
            this.transactionSelected = id;
        },
        loadTransaction(){
                this.transactionSelected = true;
                this.loading = true;
                this.transaction.length = 0;
                axios.get('/api/transaction').then(res=>{
                    this.transaction = res.data
                    this.loading = false;
                })
        },
        successUpload(){
            this.cancelButtton = false;
            swal("Success!","Successfully upload proof of payment! Please wait admin to verified your proof of payment","success");
            this.loadTransaction();
        },
        confirmTransaction(id){
             swal({
                title: 'Warning!',
                text: 'Are you sure to confirm this transaction?',
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
                return axios.post(`/api/transaction/${id}/confirm`)
            })
            .then(results => {
                swal({
                    icon:"success",
                    title: "Success!",
                    text: "Successfuly confirm transaction",
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
        errorUpload(error){
            this.transactionSelected = null;
            this.cancelButtton = false;
            if(error.status == '404'){
                swal('Error!','Your time for uploading your proof of payment has passed!','error');
            } else {
                swal('Error!','Failed to upload proof of payment','error');
            }
        }
    },

}
</script>

<style>
    .digit{
        color:#DF2935
    }
    .text{
        color:#DF2935
    }
    .border-between > [class*='col-']:before {
        background: #e3e3e3;
        bottom: 0;
        content: " ";
        left: 0;
        position: absolute;
        width: 1px;
        top: 0;
    }

    .border-between > [class*='col-']:first-child:before {
        display: none;
    }

    .price{
        font-size: 1.2rem;
        color:#5a50e5;
        font-weight: 700;

    }

    .slide-fade-enter-active {
    transition: all .3s ease;
    }
    .slide-fade-leave-active {
    transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translatey(10px);
    opacity: 0;
    }

    .swal-text{
        text-align: center
    }
    
</style>
