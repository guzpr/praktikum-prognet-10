<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\ProductReview as Review;
use App\Models\Master\Products;
use Auth;

class ReviewController extends Controller
{
   public function saveReview(Request $request){
       $review = new Review;
       $review->product_id = $request->productId;
       $review->user_id = Auth::guard('user')->id();
       $review->content = $request->content;
       $review->rate = $request->rating;
       $review->save();
       $reviewProduct = Review::where('product_id',$request->productId);
       $reviewcount = $reviewProduct->sum('rate') / $reviewProduct->count('rate') ;
       $product = Products::find($request->productId);
       $product->product_rate = $reviewcount;
       $product->save();
       return $request;
   }

   public function getProductReview($id){
       return Review::where('product_id',$id)->with('user')->with('response')->get();
   }

   public function getAll(){
       return Review::with('product')->with('user')->with('response')->get();
   }
}
