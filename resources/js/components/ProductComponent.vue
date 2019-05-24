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
                <button class="btn btn-outline-primary" :disabled="qty == 0" @click="qty--" type="button">&minus;</button>
              </div>
              <input type="text" class="form-control text-center" :value="qty" placeholder="">
              <div class="input-group-append">
                <button class="btn btn-outline-primary" @click="qty ++" type="button">&plus;</button>
              </div>
              <div class="my-2">
                <star-rating inline :star-size="25" read-only :show-rating="false" :increment="0.5" v-model="product.product_rate"></star-rating>                        
              </div>
            </div>

            </div>
            <p><a href="" @click.prevent="postItem" class="buy-now btn btn-sm btn-primary">Add To Cart</a></p>
            <p><a href="" v-if="review == 0" @click.prevent="reviewItem" class="buy-now btn btn-sm btn-warning">Review Item</a></p>

          </div>
        </div>
            <div class="row justify-content-center">
              <div class="col-md-12 site-section-heading text-center pt-4">
                <h2>Products Review</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-12 my-4  p-2"  v-for="review in productReview" :key="review.id" >
                      <div class="col-12 rounded p-2" >
                        <div class="row">
                          <div class="col-4">
                            <star-rating inline :star-size="25" read-only :show-rating="false" :increment="0.5" v-model="review.rate"></star-rating>                        
                            <h6 class="mt-4"> Review by : <span style="font-weight:700">{{review.user.name}}</span></h6>
                            <h6>"{{review.content}}"</h6>
                          </div>
                        </div>
                      </div>

                      <div class="col-11 mt-2 ml-auto rounded p-2" v-if="review.response">
                        <div class="row">
                          <div class="col-4">
                              <h6 class="mt-4"><span style="font-weight:700">Admin response :</span></h6>
                              <h6>
                                {{review.response.content}}
                              </h6>
                          </div>
                        </div>
                      </div>
                      
              </div>
            </div>        
        <modal name="review"  :height="'auto'" :adaptive="true"  :scrollable="true">
          
              <review-component @finished="finishReview" :product="product"></review-component>

        </modal>
    </div>
</template>

<script>
    import carousel from 'vue-owl-carousel'
    import { EventBus } from '../event-bus.js';
    import StarRating from 'vue-star-rating'
    import ReviewComponent from './ReviewComponent';
    export default {
        props:['product','review'],
        components: { carousel,StarRating },
        mounted() {
          this.loadReview();
        },
        data(){
            return {
              qty:1,
              productReview:[]
            }
        },
        computed:{
            translateThousand(){
                    return this.product.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }, 
        },
        methods:{
          postItem(){
            axios.post('/api/cart',{id:this.product.id,qty:this.qty}).then(res=>{
                console.log(res);
            })
            .catch(err=>{
                console.log(err.response)
            })
            EventBus.$emit('addCart',qty); 
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
          },
          reviewItem(){
            this.$modal.show('review');
          },
          finishReview(){
            this.$modal.hide('review');
            swal('Success !','Your review has been submited','success');
            this.review = 1;
          },
          loadReview(){
            this.productReview.length = 0;
            axios.get(`/api/review/product/${this.product.id}`).then(res=>{
              this.productReview = res.data;
            })
          }
        }
    }
</script>
