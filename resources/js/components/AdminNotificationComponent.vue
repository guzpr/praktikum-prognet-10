<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="site-section">
                    <div class="container">
                        <h3 class="my-2">My Notification</h3>
                        <div v-if="loading" class="my-5">
                            <loading-component></loading-component>
                        </div>
                        <div class="row">
                            <div class="col-12 my-2" v-for="notif in notification" :key="notif.id">
                                <a href="/admin/transaction">
                                <div class="alert alert-primary" role="alert">
                                    There is new transaction at {{parseDate(notif.created_at)}} 
                                </div>
                                </a>

                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from './LoadingComponent';
import { format } from 'date-fns'
import { EventBus } from '../event-bus.js';

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
        axios.get('/api/notification/admin').then(res=>{
            this.notification = res.data;
            this.loading = false;
            EventBus.$emit('loadNotif'); 
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
