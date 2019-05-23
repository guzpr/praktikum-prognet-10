
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex';
import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    iconPack: 'fontawesome' // set your iconPack, defaults to material. material|fontawesome|custom-class
})
import BootstrapVue from 'bootstrap-vue'
import VueAxios from 'vue-axios'
import axios from 'axios'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import VModal from 'vue-js-modal'

Vue.use(BootstrapVue)
Vue.use(VueAxios, axios);

Vue.use(VModal)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.use(Vuex)
Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('product-show-component', require('./components/ProductShowComponent.vue').default);
Vue.component('categories-filter-component', require('./components/CategoriesFilterComponent.vue').default);
Vue.component('product-gallery', require('./components/ProductGallery.vue').default);
Vue.component('nav-component', require('./components/NavComponent.vue').default);
Vue.component('cart-component', require('./components/CartComponent.vue').default);
Vue.component('loading-component', require('./components/LoadingComponent.vue').default);
Vue.component('checkout-component', require('./components/CheckOutComponent.vue').default);
Vue.component('transaction-component', require('./components/TransactionComponent.vue').default)
Vue.use(Toasted)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const store = new Vuex.Store({
     state: {
         category:null,
         price:[]
     },
     mutations: {
         assignCategory(state,category) {
             state.category = category;
         },
         assignPrice(state,price){
             state.price.length = 0;
             state.price = price;
         }
     },
     
 })

const app = new Vue({
    el: '#app',
    store,
});
