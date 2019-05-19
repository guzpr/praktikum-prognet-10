<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Products;
class ProductController extends Controller
{
    public function getBySlug($slug){
        return Products::where('slug',$slug)->with('image')->get();
    }

    public function getAll(){
        return Products::with('image')->with('categories')->get();
    }

    public function getMaxPrices(){
       return Products::max('price');
    }

    public function getMinPrices(){
        return Products::min('price');
    }
}
