<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Carts;
use Illuminate\Support\Facades\Auth;
use RajaOngkir;

class CartController extends Controller
{
    public function getCountCart(){
        
        return Carts::where('status','notyet')
        ->where('user_id',Auth::guard('user')->id())
        ->sum('qty') 
        ;
    }

    public function addCart(Request $request){
        $userCart = Carts::where('status','notyet')
        ->where('user_id',Auth::guard('user')->id())
        ->where('product_id',$request->id)
        ->first();
        if(!empty($userCart)){
            $userCart->qty = $userCart->qty + 1;
            $userCart->save();
        } else {
            $cart = new Carts;
            $cart->user_id = Auth::guard('user')->id();
            $cart->product_id = $request->id;
            $cart->qty = 1;
            $cart->status = 'notyet';
            $cart->save();
        }
        

    }

    public function getCart(Request $request){
        return Carts::where('status','notyet')
        ->where('user_id',Auth::guard('user')->id())
        ->with('products')
        ->with('products.image')
        ->get();
    }

    public function update(Request $request){
        $cart = Carts::find($request->id);
        $cart->qty = $request->qty;
        $cart->save();
        return $cart;
    }

    public function delete(Request $request){
        $cart = Carts::find($request->id);
        $cart->delete();
        return $cart;
    }
}
