<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetails;
use Carbon\Carbon;
use Auth;
use App\Models\Transaction\Carts;
use Storage;
use App\Models\Master\Products;
use App\Models\Master\Admin;
use App\Notifications\NewTransactionNotification;
use App\Models\Master\Users;
use App\Notifications\TransactionStatusNotification;
use Notification;

class TransactionController extends Controller
{
    public function submitTransaction(Request $request){
        $trs = new Transaction;
        $trs->timeout = Carbon::now()->addDay(2);
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
            $product = Products::find($request->cart[$i]['product_id']);
            $details = new TransactionDetails;
            $details->transaction_id = $trs->id;
            $details->product_id = $request->cart[$i]['product_id'];
            $details->qty = $request->cart[$i]['qty'];
            $details->selling_price = $request->cart[$i]['products']['price'] * $request->cart[$i]['qty'];
            if(sizeof($request->cart[$i]['products']['discount']) > 0)
            $details->discount = $request->cart[$i]['products']['discount'][0]['percentage'];
            $details->save();
            $cart->status = 'checkedout';
            $cart->save();
            $product->stock = $product->stock - 1;
            $product->save();
        }
        $admin = Admin::find(1);
        Notification::send($admin, new NewTransactionNotification($trs));
    }

    public function getAllTransactionByUser(){
        $trs = Transaction::where('user_id',Auth::guard('user')->id())->get();
        return $trs;
    }

    public function getAllTransaction(){
        return Transaction::with('courier')->with('user')->get();
    }

    public function uploadProof(Request $request){
        $file = $request->file('file');
        $trs = Transaction::find($request->id);
        $diff = Carbon::parse($trs->timeout)->diffInDays(Carbon::now());
        if( $diff > 0 ){
            abort(404);
        }
        if(!empty($trs->proof_of_payment)){
            Storage::disk('public_uploads')->delete($trs->proof_of_payment);
        }
        $path = Storage::disk('public_uploads')->put('',$file);
        $trs->proof_of_payment = $path;
        $trs->status = 'pending';
        $trs->save(); 
        return $path;
    }

    public function confirmTransaction($id){
        $trs = Transaction::find($id);
        $trs->status = 'success';
        $trs->save(); 
    }

    public function getDetails($id){
        return TransactionDetails::where('transaction_id',$id)
        ->with('products')
        ->with('products.image')
        ->get();
    }

    public function changeStatus(Request $request){
        $user = Users::find($request->user_id);
        $trs = Transaction::find($request->transaction_id);
        $trsBefore = $trs->status;
        $trs->status = $request->status;
        $trs->save();
        Notification::send($user, new TransactionStatusNotification($trsBefore,$trs));
    }
}
