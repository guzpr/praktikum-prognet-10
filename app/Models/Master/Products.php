<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function image(){
        return $this->hasMany('App\Models\Master\ProductImage');        
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Master\ProductCategories','product_category_details','product_id','category_id');
    }

    public function carts(){
        return $this->hasMany('App\Models\Transaction\Carts','product_id','id');
    }

}
