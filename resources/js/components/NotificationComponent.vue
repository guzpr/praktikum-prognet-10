<template>
    <div>
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Notification</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <h3 class="my-2">My Notification</h3>
                <div v-if="loading" class="my-5">
                    <loading-component></loading-component>
                </div>
                <div class="row">
                    <div class="col-12 my-2" v-for="notif in notification" :key="notif.id">
                        <a href="/transaction"><div class="alert alert-primary" role="alert">
                            Your transaction at {{parseDate(notif.data.date)}} has changed it status from <span style="font-weight:700;text-transform:capitalize"> {{notif.data.status_before}} 
                                </span> to <span style="font-weight:700;text-transform:capitalize"> {{notif.data.status_after}}</span>
                        </div>
                        </a>

                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from './LoadingComponent';
import { format } from 'date-fns'

export default {
    component:{
        LoadingComponent
    },
    data(){
        return{
            notification:[],
            loading:true
        }
    },
    mounted(){
        this.loading = true;
        axios.get('/api/notification/').then(res=>{
            this.notification = res.data;
            this.loading = false
        })
    },
    methods:{
        parseDate(date){
            return format(date,"DD MMMM YYYY")
        },
    }
}
</script>

<style>

</style>
