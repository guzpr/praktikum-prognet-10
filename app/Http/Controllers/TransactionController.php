<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetails;
use Carbon\Carbon;
use Auth;
use App\Models\Transaction\Carts;
use Storage;
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
}
