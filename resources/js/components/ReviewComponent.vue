<template>
    <div class="row m-5">
        <div class="col-12 text-center">
            <star-rating inline :star-size="50" :show-rating="false" :increment="0.5" v-model="form.rating"></star-rating>
            <div class="form-group mt-4">
                <label for="exampleFormControlTextarea1">Your review</label>
                <textarea class="form-control" v-model="form.content" rows="3"></textarea>
            </div> 
            <p><a href="" @click.prevent="postReview" class="buy-now btn btn-sm btn-warning">Review Item</a></p>
        </div>
    </div>                  
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
    components:{
        StarRating
    },
    props:{
        product:{
            type:Object
        }
    },
    data(){
        return{
            form:{
                rate:null,
                content:null,
                productId:this.product.id
            }
        }
    },
    methods:{
        postReview(){
            axios.post('/api/review',this.form).then(res=>{
                console.log(res.data);
                this.$emit('finished')
            }).catch(err=>{
                console.log(err.response);
            })
        }
    }
}
</script>

<style>

</style>
