<template>
    <div class="container">
        <div class="row">
          <div class="col-md-6">
                <carousel :margin="20" :items="1" :autoplay="true" :nav="false">

                    <img v-for="(image,index) in product.image" :key="index" :src="image.image_name" :alt="'Product Image'" class="img-fluid" />

                </carousel>

          </div>
          <div class="col-md-6">
            <h2 class="text-black">{{product.product_name}}</h2>
            <p>{{product.description}}</p>
            <p><strong class="text-primary h4">Rp. {{translateThousand}}</strong></p>
            <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 120px;">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
              </div>
              <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
              <div class="input-group-append">
                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
              </div>
            </div>

            </div>
            <p><a href="cart.html" class="buy-now btn btn-sm btn-primary">Add To Cart</a></p>

          </div>
        </div>
      </div>
</template>

<script>
    import carousel from 'vue-owl-carousel'

    export default {
        props:['product'],
        components: { carousel },
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {

            }
        },
        computed:{
            translateThousand(){
                    return this.product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }
    }
</script>
