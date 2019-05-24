<template>
        <div class="col-md-3 order-1 mb-5 mb-md-0">

            <div class="border p-4 rounded mb-4">
            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
            <ul class="list-unstyled mb-0">
                <li class="mb-1">
                    <a href="" @click.prevent="assignCategory(null)" class="d-flex">
                        <span>All</span> 
                        <span class="text-black ml-auto">({{allProductCount}})</span>
                    </a> 
                </li>
                <li v-for="(category,index) in categories" :key="index" class="mb-1">
                    <a href="" @click.prevent="assignCategory(category.category_name)" class="d-flex">
                        <span>{{category.category_name}}</span> 
                        <span class="text-black ml-auto">({{category.product_count}})</span>
                    </a> 
                </li>
            </ul>
            </div>

            <div class="border p-4 rounded mb-5">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                <vue-slider v-if="price.length > 0" :tooltipPlacement="'bottom'" @change="assignPrice" :tooltip="'always'" :interval="1000" v-model="price" :min="minPrices" :max="maxPrices" :lazy="true" :tooltip-formatter="val => `Rp. ${translateThousand(val)}`" ></vue-slider>
              </div>

            </div>

        </div>
</template>

<script>
import { mapMutations } from 'vuex'
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'

export default {
    components: {
        VueSlider
    },
    data(){
        return {
            categories:[],
            price:[],
            minPrices:null,
            maxPrices:null,
        }
    },
    mounted(){
        Promise.all([axios.get('/api/categories/'),
                    axios.get('/api/product/max'),
                    axios.get('/api/product/min')])
                .then(res=>{
                    this.categories = res[0].data;
                    this.maxPrices = res[1].data;
                    this.price[1] = res[1].data;
                    this.minPrices = res[2].data;
                    this.price[0] = res[2].data; 
                    var initialValue = 0;
                });
    },
    
    methods:{
        ...mapMutations([
            'assignCategory', 
            'assignPrice'
        ]),
        translateThousand(price){
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
    computed:{
        allProductCount(){
            var val = 0;
            return this.categories.length == 0 ? 0 : this.categories.reduce((sum,obj)=>{
                return sum + obj.product_count;
            },val)
        }
    }

}
</script>

<style>

</style>
