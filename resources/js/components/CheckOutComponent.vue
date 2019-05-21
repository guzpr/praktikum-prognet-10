<template>
    <div>
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
                    <div class="row mb-5" v-if="cart.length>0">
                        <div class="col-12">
                            <h3 class="my-2">Checkout</h3>
                            <h5 class="mt-4">Shipping Details</h5>
                            <hr/>
                            <div class="row">
                                <b-form-group
                                    label="Address:" class="col-12"
                                >
                                    <b-form-input
                                        id="input-live"
                                        v-model="form.name"
                                        placeholder="Enter your address"
                                        trim
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    label="Province:" class="col-6"
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
                                    label="City:" class="col-6"
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
                                    <b-form-radio-group class="ml-3" v-model="form.courierId">
                                            <b-form-radio class="col-3"  v-for="courier in courier" :key="courier.id" :value="courier">{{courier.courier_name}}</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="mt-4">Item Details</h5>
                            <hr/>
                        </div>
                        <!-- <form class="col-md-12" method="post" >
                            <div class="site-blocks-table">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in cart" :key="index">
                                    <td class="product-thumbnail">
                                        <div class="col-12">
                                                <img :src="item.products.image[0].image_name" :alt="'Product Image'" class="img-fluid" />
                                        </div>
                                    </td>
                                    <td class="product-name">
                                    <h2 class="h5 text-black">{{item.products.product_name}}</h2>
                                    </td>
                                    <td>{{translateThousand(item.products.price)}}</td>
                                    <td>
                                    <div class="input-group mb-3" style="max-width: 120px;">
                                        <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary js-btn-minus" :disabled="item.qty == 0" type="button" @click="item.qty --; emitBus(-1,0); changeQuantity(item)">&minus;</button>
                                        </div>
                                        <input type="text" class="form-control text-center" min="0" :value="item.qty" @change="emitBus($event.target.value,item.qty,item);changeQuantity(item)" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-primary js-btn-plus" @click="item.qty ++ ;changeQuantity(item);emitBus(1,0)" type="button">&plus;</button>
                                        </div>
                                    </div>

                                    </td>
                                    <td>{{translateThousand(item.products.price * item.qty)}}</td>
                                    <td><a href="#" @click.prevent="remove(item)" class="btn btn-primary btn-sm">X</a></td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </form> -->
                        <div class="row my-2 rounded p-2" v-for="product in cart" :key="product.id">
                            <div class="col-3">
                                <img style='height: 100%; width: 100%; object-fit: contain' :src="product.products.image[0].image_name" alt="">
                            </div>
                            <div class="col-9">
                                Some quick example text to build on the card and make up the bulk of the card's content.
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
                    <div class="col-md-6">
                        <div class="row mb-5">
                        <div class="col-md-6">
                            <button @click.prevent="redirectHome" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button>
                        </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6 pl-5" v-if="cart.length>0">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <span class="text-black">Total</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black">{{translateThousand(totalPrice)}}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="/checkout">
                                            <button class="btn btn-primary btn-lg py-3 btn-block">Proceed To Checkout</button>
                                        </a>
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
            cart:[],
            loading:true,
            province:[],
            provinceSelected:null,
            cities:[],
            citySelected:null,
            form:{
                address:null,
                regency:null,
                city:null,
                total:null,
                shippingCost:null,
                subTotal:null,
                courierId:null,
            },
            isCitiesDisabled:false,
            isCitiesLoading:false,
            isProvinceLoading:true
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
        })
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
        }
    },
    computed:{
        totalPrice(){
            return this.cart.reduce((sum,val)=>{
                return sum + val.products.price * val.qty
            },0)
        }
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
