<template>
    <div>
        <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section" >
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="float-md-left mb-4"><h2 class="text-black h5">Shop All</h2></div>
              </div>
            </div>

            <product-show-component></product-show-component>
            
          </div>

            <categories-filter-component></categories-filter-component>

            

        </div>
        
      </div>
    </div>

    </div>
</template>

<script>
import ProductShowComponent from './ProductShowComponent';
import CategoriesFilterComponent from './CategoriesFilterComponent';
export default {
    components:{ProductShowComponent,CategoriesFilterComponent}
    

}
</script>

<style>

</style>
