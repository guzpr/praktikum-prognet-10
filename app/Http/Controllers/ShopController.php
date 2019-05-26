<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Products;
use App\Models\Master\ProductCategories;
use App\Models\Transaction\ProductReview as Review;
use App\Models\Transaction\TransactionDetails as Details;

use Auth;
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
        return view('shop.product');
    }

    public function product($slug){
        $product = Products::where('slug',$slug)->with('image')->with('discount')->first();
        $isReviewed = 0;
        $productReview = Review::where('user_id',Auth::guard('user')->id())
        ->where('product_id',$product->id)
        ->get();
        $productBought = Details::join('transactions','transaction_id','transactions.id')
        ->where('user_id',Auth::guard('user')->id())
        ->where('product_id',$product->id)
        ->get();
        if(sizeof($productBought) > 0) {
            $isReviewed = 0;
        }
        if(sizeof($productReview) > 0 || sizeof($productBought) == 0){
            $isReviewed = 1;
        };
        if($product){
            return view('shop.productSingle')->with('data',$product)->with('review',$isReviewed);
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
