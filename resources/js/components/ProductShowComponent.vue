<template>
    <div class="row mb-5">
        <div  v-for="(product,index) in data" :key="index" class="col-sm-6 col-lg-4 mb-4" >
            <div class="block-4 text-center border">
                <figure class="block-4-image">
                <a :href="`/product/${product.slug}`"><img :src="product.image[0].image_name" alt="Image placeholder" class="img-fluid"></a>
                </figure>
                <div class="block-4-text p-4">
                <h3><a href="shop-single.html">{{product.product_name}}</a></h3>
                <p class="mb-0">{{product.description}}</p>
                <p class="text-primary font-weight-bold">Rp. {{translateThousand(product.price)}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['data'],
    data(){
        return {

        }
    },
    methods:{
        translateThousand(price){
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
}
</script>

<style>

</style>
