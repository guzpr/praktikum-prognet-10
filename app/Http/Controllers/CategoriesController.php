<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\ProductCategories;
class CategoriesController extends Controller
{
    public function getAll(){
        return ProductCategories::withCount(['product' => function($q){
            $q->where('is_deleted',0);
        }])->get();
    }
}
