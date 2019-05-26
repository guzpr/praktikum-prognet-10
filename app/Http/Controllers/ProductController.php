<?php

namespace App\Http\Controllers;

use DB;

use App\ProductImage;
use App\CategoryDetail;
use App\Models\Master\Products;
use App\Models\Master\ProductCategories;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;
class ProductController extends Controller
{
    public function getBySlug($slug){
        return Products::where('slug',$slug)->with('image')->get();
    }

    public function getAll(){
        return Products::with('image')->with('categories')->with('discount')->get();
    }

    public function getMaxPrices(){
       return Products::max('price');
    }

    public function getMinPrices(){
        return Products::min('price');
    }

    public function index()
    {
        $productsjoin = DB::table('product_category_details')
        ->join('products','product_category_details.product_id','=','products.id')
        ->join('product_categories','product_category_details.category_id','=','product_categories.id')
        ->get();

        $productImages = ProductImage::get();
        $products = Products::get();
        $discounts = Products::join('discounts','products.id','=','discounts.id_product')->get();
        
        return view("admin.product.list", compact('discounts','productsjoin',"products",'detail','item','productImages','productCategory','CategoryDetail'));

    }

    public function create()
    {
        $category = ProductCategories::get();
        return view("admin.product.add",compact('category'));
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'  => 'required',
        //     'price'         => 'required',
        //     'description'   => 'required',
        //     'stock'         => 'required',
        //     'weight'        => 'required',
        // ]);
        
        $produks = new Products;
        $produks->product_name = $request->product_name;
        $produks->price = $request->price;
        $produks->description = $request->description;
        $produks->product_rate = 0;
        $produks->created_at = date('Y-m-d H:i:s');
        $produks->updated_at = date('Y-m-d H:i:s');
        $produks->stock = $request->stock;
        $produks->weight = $request->weight;
        $produks->save();
        
        $get_id_product = Products::select('id')
        ->orderBy('id','DESC')
        ->first();
        foreach($request->category_id as $category){
            $category_details = new CategoryDetail;
            $category_details->product_id = $get_id_product->id;
            $category_details->category_id = $category;
            $category_details->created_at = date('Y-m-d H:i:s');
            $category_details->updated_at = date('Y-m-d H:i:s');
            $category_details->save();
        }
        if($request->hasfile('image'))
        {
            $current_timestamp = Carbon::now()->timestamp;
            $i = 1;
            foreach($request->file('image') as $file)
            {
                
                    $name=$file->getClientOriginalName();
                    $path = 'files/'. $name;
                    if(File::exists($path)) {
                        $name = $current_timestamp.$file->getClientOriginalName();
                        $path = 'files/'. $name;
                    }
                    
                    $file->move(public_path().'/files/', $name);

                    $image = new ProductImage;
                    $image->products_id = $get_id_product->id;
                    $image->image_name=$path;
                    $image->save();
                $i++;    
            }
            
        }

        $products = Products::get();
        return redirect('/admin/product/');
    }

    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    public function edit($id)
    {
        $category = ProductCategories::get();
        $category_details = CategoryDetail::where('product_category_details.product_id',$id)->get();
        $products = Products::find($id);
        return view("admin.product.edit", compact("products",'category','category_details'));
    }

    public function update(Request $request, $id)
    {
        $produks = Products::find($id);
        $produks->product_name = $request->product_name;
        $produks->price = $request->price;
        $produks->description = $request->description;
        // $produks->product_rate = $request->product_rate;
        $produks->updated_at = date('Y-m-d H:i:s');
        $produks->stock = $request->stock;
        $produks->weight = $request->weight;
        $produks->save();
        foreach($request->category_id as $category){
            $category_details = CategoryDetail::where('product_id',$id);
            $category_details->delete();
        }

        foreach($request->category_id as $category){
            $category_details = new CategoryDetail;
            $category_details->product_id = $id;
            $category_details->category_id = $category;
            $category_details->created_at = date('Y-m-d H:i:s');
            $category_details->updated_at = date('Y-m-d H:i:s');
            $category_details->save();
        }
        return redirect("/admin/product");
    }

    public function destroy($id)
    {
        $products = Products::find($id);
        $products->is_deleted = 1;
        $products->save();
        return redirect("/admin/product")->with("alert-success", "Berhasil menonaktifkan product");
    }

    public function activate($id)
    {
        $products = Products::find($id);
        $products->is_deleted = 0;
        $products->save();
        return redirect("/admin/product")->with("alert-success", "Berhasil Mengaktifkan product");
    }
}
