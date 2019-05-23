<template>
<div>
    <div v-if="loading">
        <loading-component></loading-component>
    </div>
    <div v-else class="row mb-5">
            <div v-for="(product,index) in filteredProducts" :key="index" class="col-sm-6 col-lg-4 mb-4" >
                <div class="block-4 text-center border">
                    <figure class="block-4-image">
                    <a :href="`/product/${product.slug}`"><img :src="product.image[0].image_name" alt="Image placeholder" class="img-fluid"></a>
                    </figure>
                    <div class="block-4-text p-4">
                    <h3><a :href="`${product.slug}`">{{product.product_name}}</a></h3>
                    <p class="mb-0">{{product.description}}</p>
                    <p class="text-primary font-weight-bold">Rp. {{translateThousand(product.price)}}</p>
                    <star-rating inline :star-size="25" read-only :show-rating="false" :increment="0.5" v-model="product.product_rate"></star-rating>                        
                    </div>
                    <div class="col-12 text-center mb-2">
                        <div @click.prevent="addToCart(product)" class="btn btn-sm btn-primary">Add to Cart</div>
                    </div>
                </div>
                <div class="col-12">
                </div>
            </div>
    </div>

</div>
</template>

<script>
import StarRating from 'vue-star-rating'
import { EventBus } from '../event-bus.js';
import LoadingComponent from './LoadingComponent';

export default {
    components: {
        StarRating,LoadingComponent
    },
    data(){
        return {
            products:[],
            rating:2.5,
            loading:true
        }
    },
    mounted(){
        axios.get('/api/product/').then(res=>{
            this.products = res.data;
            this.loading = false;
        })
    },
    methods:{
        translateThousand(price){
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        addToCart(product){
            axios.post('/api/cart',{id:product.id}).then(res=>{
                console.log(res);
            })
            .catch(err=>{
                console.log(err.response)
            })
            EventBus.$emit('addCart',1); 
            this.$toasted.show('Item Added to Cart! ',{
                    icon : {
                        name : 'check'
                    },
                    action : [
                        {
                            text : 'Close',
                            onClick : (e, toastObject) => {
                                toastObject.goAway(0);
                            }
                        },
                    ]
            })

        }
    },
    computed:{
         filteredProducts(){
             if(!this.$store.state.category && this.$store.state.price.length == 0 ) return this.products;
             return this.products.filter(obj=>obj.categories.some(el=> this.$store.state.category == null ? true : el.category_name == this.$store.state.category ))
             .filter(obj=> this.$store.state.price.length == 0 ? true : obj.price>=this.$store.state.price[0] && obj.price <= this.$store.state.price[1]);
        }
    }
}
</script>

<style>
.btn:active {
  transform: translateY(4px)!important;
}
</style>
