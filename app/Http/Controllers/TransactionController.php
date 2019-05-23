<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetails;
use Carbon\Carbon;
use Auth;
use App\Models\Transaction\Carts;

class TransactionController extends Controller
{
    public function submitTransaction(Request $request){
        $trs = new Transaction;
        $trs->timeout = Carbon::now()->addDay();
        $trs->address = $request->address;
        $trs->regency = $request->regency;
        $trs->city = $request->city;
        $trs->total = $request->total;
        $trs->shipping_cost = $request->shippingCost;
        $trs->sub_total = $request->subTotal;
        $trs->user_id = Auth::guard('user')->id();
        $trs->courier_id = $request->courier;
        $trs->status = 'unverified';
        $trs->save();
        for($i = 0 ; $i < sizeof($request->cart) ;$i++){
            $cart = Carts::find($request->cart[$i]['id']);
            $details = new TransactionDetails;
            $details->transaction_id = $trs->id;
            $details->product_id = $request->cart[$i]['product_id'];
            $details->qty = $request->cart[$i]['qty'];
            $details->selling_price = $request->cart[$i]['products']['price'] * $request->cart[$i]['qty'];
            $details->save();
            $cart->status = 'checkedout';
            $cart->save();

        }
    }

    public function getAllTransaction(){
        $trs = Transaction::where('user_id',Auth::guard('user')->id())->get();
        return $trs;
    }
}
