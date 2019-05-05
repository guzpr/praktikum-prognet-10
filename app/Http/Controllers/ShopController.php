<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Products;
class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index(){
        return view('shop.index');
    }

    public function products(){
        $products = Products::with('image')->get();
        if(sizeof($products)>0){
            return view('shop.product')->with('data',$products);
        }
        return abort(404);
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
    
}
