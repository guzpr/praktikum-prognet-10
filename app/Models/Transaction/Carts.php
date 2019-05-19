<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    public function products(){
        return $this->belongsTo('App\Models\Master\Products','product_id','id');
    }
}
