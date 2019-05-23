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
                                            <h6 class="text-right badge" :class="{'badge-warning':item.status == 'unverified','badge-primary':item.status == 'verified','badge-danger':item.status == 'expired','badge-success':item.status =='success','badge-info':item.status =='delivered'}"  style="text-transform:capitalize">{{item.status}}</h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row border-between">
                                        <div class="col-4">
                                            <div class="timeout" v-if="item.status == 'unverified'">
                                                <strong><p style="color:#DF2935;font-weight:700">Time left for proff of payment upload:</p></strong>
                                                <Countdown :deadline="parseDate(item.timeout)"></Countdown>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    Product total <br>
                                                    <span class="price">{{translateThousand(item.total)}}</span>
                                                </div>
                                                <div class="col-6">
                                                    Shipping cost <br>
                                                    <span class="price">{{translateThousand(item.shipping_cost)}}</span>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <button class="btn btn-outline-primary btn-sm btn-block">See product details</button>
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
                                                <div class="col-12 text-right mt-2">
                                                    <button v-if="item.status == 'unverified'" class="btn btn-outline-primary btn-sm btn-block float-right">Upload proff</button>
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
                            <h3 class="my-2">You don't have transaction currently </h3>
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

        
    </div>
</template>

<script>
import LoadingComponent from './LoadingComponent'
import Countdown from 'vuejs-countdown'
import { format } from 'date-fns'

export default {
    components: { Countdown },
    data(){
        return{
            loading:true,
            transaction:[]
        }
    },
    mounted(){
        axios.get('/api/transaction').then(res=>{
            this.transaction = res.data
            this.loading = false;
        })
    },
    methods:{
        parseDate(date){
            console.log(format(date,"DD MMMM YYYY"))
            return format(date,"DD MMMM YYYY")
        },
        translateThousand(price){
            return `Rp ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        },
    }
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
    
</style>
