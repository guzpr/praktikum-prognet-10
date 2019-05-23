<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Courier;
class CourierController extends Controller
{
    public function getAll(){
        return Courier::all();
    }

    public function index()
    {
        $courier = Courier::get();
  
        return view('admin.courier.list',compact('courier'));
    }

    public function create()
    {
        return view('admin.courier.add');
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $courier = new courier;
        $courier->courier = $request->courier;
        $courier->created_at = date('Y-m-d H:i:s');
        $courier->updated_at = date('Y-m-d H:i:s');
        $courier->is_deleted = 0;
        $courier->save();

        return redirect("/admin/courier/");
    }

    public function edit($id)
    {
        $courier = courier::find($id);
        return view('admin.courier.edit',compact('courier'));
    }

    public function update(Request $request, $id)
    {
        
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $courier = courier::find($id);
        $courier->courier = $request->courier;
        $courier->updated_at = date('Y-m-d H:i:s');
        $courier->save();

        return redirect("/admin/courier");
    }

    public function destroy($id)
    {
        $courier = courier::find($id);
        $courier->is_deleted = 1;
        $courier->save();
        
        return redirect("/admin/courier")->with("alert-success", "Berhasil menonaktifkan categories");
    }

    public function activate($id)
    {
        $courier = courier::find($id);
        $courier->is_deleted = 0;
        $courier->save();
        return redirect("/admin/courier")->with("alert-success", "Berhasil Mengaktifkan product");
    }

}
