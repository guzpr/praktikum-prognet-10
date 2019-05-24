<template>
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">

            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="/" class="js-logo-clone">Shoppers</a>
              </div>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu js-clone-nav d-none d-md-block">
                      <li>
                        <a href="/notification" class="site-cart">
                          <span class="icon icon-bell"></span>
                          <span v-if="notificationCount>0" class="count">{{notificationCount}}</span>
                        </a>
                      </li> 
                      <li class="has-children">
                        <span class="icon icon-person">
                        </span>
                        <ul class="dropdown">
                          <li><a href="/transaction">My Transaction</a></li>
                          <li><a href="/logout">Logout</a></li>
                        </ul>
                      </li>
                      <li>
                        <a href="/cart" class="site-cart">
                          <span class="icon icon-shopping_cart"></span>
                          <span v-if="count>0" class="count">{{count}}</span>
                        </a>
                      </li> 
                      
                    </ul>
                </nav>
              </div> 
            </div>

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li>
              <a href="/">Home</a>
            </li>
            <li><a href="/product">All Product</a></li>
          </ul>
        </div>
      </nav>
    </header>
</template>

<script>
import { EventBus } from '../event-bus.js';

export default {
  
    data(){
        return {
            categories:[],
            count:null,
            notificationCount:null
        }
    },
    methods:{

    },
    mounted(){
      EventBus.$on('addCart', qty => {
        this.count = this.count + qty;
      });
        axios.get('/api/categories/').then(res=>{
            this.categories = res.data;
        });
        axios.get('/api/cart/count').then(res=>{
          this.count = res.data
        });
        axios.get('/api/notification/count').then(res=>{
          this.notificationCount = res.data;
        })
    }
}
</script>

<style>

</style>
