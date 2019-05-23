<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\ProductCategories;
use DB;
class CategoriesController extends Controller
{
    public function getAll(){
        return ProductCategories::withCount(['product' => function($q){
            $q->where('is_deleted',0);
        }])->get();
    }

    public function index()
    {
        $categories = DB::table('product_categories')
        ->get();
  
        return view('admin.category.list',compact('categories'));
    }

    public function create()
    {
        return view('admin.category.add');
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $categories = new ProductCategories;
        $categories->category_name = $request->category_name;
        $categories->created_at = date('Y-m-d H:i:s');
        $categories->updated_at = date('Y-m-d H:i:s');
        $categories->is_deleted = 0;
        $categories->save();

        return redirect("/admin/categories/");
    }

    public function edit($id)
    {
        $categories = ProductCategories::find($id);
        return view('admin.category.edit',compact('categories'));
    }

    public function update(Request $request, $id)
    {
        
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $categories = ProductCategories::find($id);
        $categories->category_name = $request->category_name;
        $categories->updated_at = date('Y-m-d H:i:s');
        $categories->save();

        return redirect("/admin/categories");
    }

    public function destroy($id)
    {
        $categories = ProductCategories::find($id);
        $categories->is_deleted = 1;
        $categories->save();
        
        return redirect("/admin/categories")->with("alert-success", "Berhasil menonaktifkan categories");
    }

    public function activate($id)
    {
        $categories = ProductCategories::find($id);
        $categories->is_deleted = 0;
        $categories->save();
        return redirect("/admin/categories")->with("alert-success", "Berhasil Mengaktifkan product");
    }


}
