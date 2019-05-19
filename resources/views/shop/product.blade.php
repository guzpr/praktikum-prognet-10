<!DOCTYPE html>
<html lang="en">
  <head>
          @include('shop.meta.head')
  </head>
  <body>
  
  <div class="site-wrap" id="app">
    @include('shop.includes.navbar')

    <product-gallery></product-gallery>
    @include('shop.includes.footer')
  </div>

    @include('shop.meta.script')
    
  </body>
</html>