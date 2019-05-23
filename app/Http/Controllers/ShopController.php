<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Products;
use App\Models\Master\ProductCategories;
class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user')->except(['index', 'products','product']);
    }

    public function index(){
        return view('shop.index');
    }

    public function products(){
        return view('shop.product');
    }

    public function product($slug){
        $product = Products::where('slug',$slug)->with('image')->first();
        if($product){
            return view('shop.productSingle')->with('data',$product);
        }
        return abort(404);
    }

    public function cart(){
        return view('shop.cart');
    }

    public function transaction(){
        return view('shop.transaction');
    }

    public function checkout(){
        return view('shop.checkout');
    }

    public function notification(){
        return view('shop.notification');
    }
    
}
