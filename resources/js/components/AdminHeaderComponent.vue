<template>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">

                </form>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu">
                            <a href="/admin/notification">
                            <i class="zmdi zmdi-notifications"></i>
                            <span v-if="count > 0" class="quantity">{{count}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-dropdown__footer">
                            <a href="/admin/logout">
                                <i class="zmdi zmdi-power"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from '../event-bus.js';

export default {
    data(){
        return {
            count:null
        }
    },
    mounted(){
        EventBus.$on('loadNotif',_ => {
            this.loadCount()
        });
        this.loadCount();
    },
    methods:{
        loadCount(){
            this.count = null;
            axios.get('/api/notification/count/admin').then(res=>{
                this.count = res.data;
                console.log(this.count);
            })
        }
    }
}
</script>

<style>

</style>
