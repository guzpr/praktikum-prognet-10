<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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

    public function transactionDetails(){
        return $this->hasMany('App\Models\Transaction\TransactionDetail','product_id','id');
    }

    public function discount(){
        return $this->hasMany('App\Models\Transaction\Discount','id_product','id')->whereDate('start','<=',Carbon::now())->whereDate('end','>',Carbon::now());
    }

}
