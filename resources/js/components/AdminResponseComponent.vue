<template>
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1 m-b-25">Review</h2>
            </div>
            <div class="table-responsive table--no-card m-b-40">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Content</th>
                                    <th>Rating</th>
                                    <th>Response</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rating in reviews" :key="rating.id">
                                    <th>
                                        {{rating.user.name}}
                                    </th>
                                    <th>
                                        {{rating.product.product_name}}
                                    </th>
                                    <th>
                                        {{rating.content}}
                                    </th>
                                    <th>
                                        <star-rating inline :star-size="25" read-only :show-rating="false" :increment="0.5" v-model="rating.rate"></star-rating>                        
                                    </th>
                                    <th>
                                        {{rating.response ? rating.response.content : '-'}}
                                    </th>
                                    <th>
                                        <button   class="btn btn-outline-primary"  @click="showResponseModal(rating)" type="button"><i class="fas fa-edit"></i></button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
            </div>
        </div>
        <modal name="response"  :height="'auto'" :adaptive="true"  :scrollable="true">
          
             <div class="row m-5">
                <div class="col-12 text-center">
                    <div class="form-group mt-4">
                        <label for="exampleFormControlTextarea1">Your Response</label>
                        <textarea class="form-control" v-model="response" rows="3"></textarea>
                    </div> 
                    <p><button @click.prevent="postResponse" class="buy-now btn btn-sm btn-warning">Post Response</button></p>
                </div>
            </div>     

        </modal>
    </div>
    
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
    components:{
        StarRating
    },
    data(){
        return {
            reviews:[],
            reviewSelected:null,
            response:null
        }
    },
    mounted(){
        this.loadReview();
    },
    methods:{
        showResponseModal(review){
            this.reviewSelected = review;
            this.response = review.response ? review.response.content : null;
            this.$modal.show('response');
        },
        postResponse(){
            console.log(this.response);
            axios.post('/api/response',{
                response:this.response,
                review_id:this.reviewSelected.id
            }).then(res=>{
                console.log(res);
                this.$modal.hide('response');
                swal('Success!','Successfuly posting response!','success');
                this.loadReview();
            }).catch(err=>{
                console.log(err.response)
                swal('Error!','Error on posting response','error');
            })
        },
        loadReview(){
            this.reviews.length = 0;
            axios.get('/api/review/').then(res=>{
                this.reviews = res.data;
            })
        }
    }
}
</script>

<style>

</style>
