<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{  
    public function product()
    {
        return $this->belongsToMany('App\Models\Master\Products','product_category_details','category_id','product_id');
    }
}
