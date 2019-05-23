<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\ProductCategories;
use App\Model\Master\Products;
use CategoryDetail;
use DB;
class productCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('product_categories')
        ->get();
  
        return view('admin.category.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategories::get();
        return view('admin.category.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $categories = new ProductCategories;
        $categories->category_name = $request->category_name;
        $categories->created_at = date('Y-m-d H:i:s');
        $categories->updated_at = date('Y-m-d H:i:s');
        $categories->is_deleted = 0;
        $categories->save();

        $categories = ProductCategories::get();
        return redirect('/admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = ProductCategories::find($id);

        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activate($id)
    {
        $products = Products::find($id);
        $products->is_deleted = 0;
        $products->save();
        return redirect("/admin/product")->with("alert-success", "Berhasil Mengaktifkan product");
    }
}
