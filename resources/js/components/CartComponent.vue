<template>
    <div>
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
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
                        <form class="col-md-12" method="post" >
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
                        </form>
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

export default {
    component:{
        LoadingComponent
    },
    data(){
        return{
            cart:[],
            loading:true
        }
    },
    mounted(){
        this.loadCart();
    },
    methods:{
        translateThousand(price){
            return `Rp ${price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
        },
        remove(item){
            swal({
                title: 'Warning!',
                text: 'Are you sure to delete this item?',
                icon: "warning",
                buttons: {
                    cancel: "Cancel",
                    confirm: {
                        text: "Yes,delete",
                        value: true,
                        closeModal: false,
                    }
                },
                dangerMode: true,
            })
            .then(val => {
                if (!val) throw null
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
                if (err) {
                    swal("Error!", "Error on deleting cart", "error");
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            })
        },
        getDiscount(){
            this.cart = this.cart.map(cart=>{
                console.log(cart);
                if(cart.products.discount.length > 0 ){
                    cart.products.price = cart.products.price - (cart.products.price * cart.products.discount[0].percentage / 100 )
                }
                return cart;
            })
            console.log(this.cart);
        },
        loadCart(){
            this.loading = true;
            axios.get('/api/cart').then(res=>{
                this.cart = res.data;
                this.loading = false;
                this.getDiscount();
            })
        },
        redirectHome(){
            window.location.href = '/product';
        },
        emitBus(qtyAfter,qtyBefore,item){
            EventBus.$emit('addCart',qtyAfter-qtyBefore); 
            item.qty = qtyAfter;
        },
        changeQuantity:debounce(function(item){
            item._method = 'patch';
            axios.post('/api/cart',item).then(res=>{
                console.log(res);
            })
        },1000)
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

</style>
