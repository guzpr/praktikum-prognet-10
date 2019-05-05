<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Products;
class ProductController extends Controller
{
    public function getBySlug($slug){
        return Products::where('slug',$slug)->with('image')->get();
    }
}
