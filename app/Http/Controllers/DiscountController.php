<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Discount;
use App\Models\Master\Products;

class DiscountController extends Controller
{
    public function index()
    {
        $Discount = Discount::get();
        $products = Products::join('discounts','products.id','=','discounts.id_product')->get();
  
        return view('admin.discount.list',compact('Discount','products'));
    }

    public function create()
    {
        $products = Products::get();
        return view('admin.discount.add',compact('products'));
    }

    public function store(Request $request)
    {
        $discounts = new Discount;
        $discounts->id_product = $request->id_product;
        $discounts->percentage = $request->percentage;
        $discounts->start = $request->start;
        $discounts->end = $request->end;
        $discounts->created_at = date('Y-m-d H:i:s');
        $discounts->updated_at = date('Y-m-d H:i:s');
        $discounts->save();

        return redirect("/admin/discounts/");
    }

    public function edit($id)
    {
        $products = Products::get();
        $Discounts = Discount::find($id);
        return view('admin.discount.edit',compact('Discounts', 'products'));
    }

    public function update(Request $request, $id)
    {
        
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $discounts = Discount::find($id);
        $discounts->id_product = $request->id_product;
        $discounts->percentage = $request->percentage;
        $discounts->start = $request->start;
        $discounts->end = $request->end;
        $discounts->created_at = date('Y-m-d H:i:s');
        $discounts->updated_at = date('Y-m-d H:i:s');
        $discounts->save();

        return redirect("/admin.discount");
    }

    public function destroy($id)
    {
        $Discount = Discount::find($id);
        $Discount->delete();
        return redirect("/admin/discounts");
    }
}
