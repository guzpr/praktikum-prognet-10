<!DOCTYPE html>
<html lang="en">
  <head>
    @include('shop.meta.head')
  </head>
  <body>
  
  <div class="site-wrap" id="app">
        @include('shop.includes.navbar')


    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Product</strong></div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <product-component  :product="{{$data}}" :review="{{$review}}"></product-component>
    </div>

   

    

        @include('shop.includes.footer')

  </div>

  @include('shop.meta.script')
    
  </body>
</html>