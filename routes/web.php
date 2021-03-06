<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------x-------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/','ShopController@index')->name('shop.home');
Route::get('/product','ShopController@products');
Route::get('/product/{slug}','ShopController@product');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('shop.auth.login');
Route::get('/register', 'Auth\LoginController@showRegisterForm')->name('shop.auth.register');
Route::post('/register', 'Auth\LoginController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('shop.auth.logout');
Route::get('/cart', 'ShopController@cart')->name('shop.cart');
Route::get('/checkout', 'ShopController@checkout')->name('shop.checkout');
Route::get('/transaction','ShopController@transaction')->name('sho.transaction');
Route::get('/notification', 'ShopController@notification');

Route::get('/user/verify/{token}', 'Auth\LoginController@verifyUser');
Route::get('/test','TestNotificationController@test');
Route::prefix('api')->group(function(){

  Route::prefix('categories')->group(function(){
    Route::get('/','CategoriesController@getAll');
  });

  

  Route::prefix('product')->group(function(){
    
    Route::get('/','ProductController@getAll');
    Route::get('/min','ProductController@getMinPrices');
    Route::get('/max','ProductController@getMaxPrices');
  });

  Route::prefix('cart')->group(function(){
    Route::get('/count','CartController@getCountCart');
    Route::post('/','CartController@addCart');
    Route::get('/','CartController@getCart');
    Route::patch('/','CartController@update');
    Route::delete('/','CartController@delete');
  });

  Route::prefix('rajaongkir')->group(function(){
    Route::get('/province','RajaOngkirController@getProvince');
    Route::get('/city','RajaOngkirController@getCity');
    Route::get('/province/{id}/city','RajaOngkirController@getCityByProvinceId');
    Route::post('/cost','RajaOngkirController@getCost');
  });

  Route::prefix('courier')->group(function(){
    Route::get('/','CourierController@getAll');
  });

  Route::prefix('transaction')->group(function(){
    Route::post('/','TransactionController@submitTransaction');
    Route::get('/','TransactionController@getAllTransactionByUser');
    Route::get('/all','TransactionController@getAllTransaction');
    Route::post('/proff','TransactionController@uploadProof');
    Route::post('/{id}/confirm','TransactionController@confirmTransaction');
    Route::get('/{id}/details','TransactionController@getDetails');
    Route::post('/changestatus','TransactionController@changeStatus');
  });

  Route::prefix('report')->group(function(){
    Route::get('/monthly','ReportController@getReportMonthly');
    Route::get('/','UserNotificationController@getAllUnread');
  });

  Route::prefix('notification')->group(function(){
    Route::get('/count','UserNotificationController@getUnreadCount');
    Route::get('/','UserNotificationController@getAll');
    Route::get('/count/admin','AdminNotificationController@getUnreadCount');
    Route::get('/admin','AdminNotificationController@getAll');
  });

  Route::prefix('response')->group(function(){
    Route::post('/','ResponseController@postResponse');
  });

  Route::prefix('review')->group(function(){
    Route::post('/','ReviewController@saveReview');
    Route::get('/','ReviewController@getAll');
    Route::get('/product/{id}','ReviewController@getProductReview');
  });
});

Route::prefix('admin')->group(function () {
  Route::get('/', function(){
    return redirect('/admin/dashboard/');
  })->name('admin.dashboard');
  Route::resource('/product-images', 'productImageController');
  Route::get('/product','ProductController@index')->name('admin.product');
  Route::post('/product/add','ProductController@store')->name('admin.add.store');
  Route::get('/product/add','ProductController@create')->name('admin.add');
  Route::get('/product/{id}/edit','ProductController@edit');
  route::put('/product/{id}', 'ProductController@update');
  Route::delete('/product/deactivate/{id}', 'ProductController@destroy');
  route::get('/product/{id}/activate', 'ProductController@activate'); 

  route::get('/discounts', 'DiscountController@index')->name('admin.discount');
  route::post('/discounts/add','DiscountController@store')->name('admin.discount.add.storee');
  route::get('/discounts/add', 'DiscountController@create')->name('admin.discount.add');
  route::get('/discounts/{id}/edit', 'DiscountController@edit');
  route::put('/discounts/{id}', 'DiscountController@update');
  Route::delete('/discounts/{id}', 'DiscountController@destroy');

  route::get('/categories', 'CategoriesController@index')->name('admin.categories');
  route::post('/categories/add','CategoriesController@store')->name('admin.categories.add.storee');
  route::get('/categories/add', 'CategoriesController@create')->name('admin.categories.add');
  route::get('/categories/{id}/edit', 'CategoriesController@edit');
  route::put('/categories/{id}', 'CategoriesController@update');
  Route::delete('/categories/deactivate/{id}', 'CategoriesController@destroy');
  route::get('categories/{id}/activate', 'CategoriesController@activate');

  route::get('/courier', 'CourierController@index')->name('admin.courier');
  route::post('/courier/add','CourierController@store')->name('admin.courier.add.storee');
  route::get('/courier/add', 'CourierController@create')->name('admin.courier.add');
  route::get('/courier/{id}/edit', 'CourierController@edit');
  route::put('/courier/{id}', 'CourierController@update');
  Route::delete('/courier/deactivate/{id}', 'CourierController@destroy');
  route::get('courier/{id}/activate', 'CourierController@activate');
  Route::get('/response','AdminController@response')->name('admin.response');
  Route::get('transaction', 'AdminController@transaction')->name('admin.transaction');
  Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
  route::get('/notification', 'AdminController@notification')->name('admin.notification');
  Route::get('register', 'AdminController@create')->name('admin.register');
  Route::post('register', 'AdminController@store')->name('admin.register.store');
  Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');
  Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
  Route::get('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
});