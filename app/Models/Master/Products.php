<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function image(){
        return $this->hasMany('App\Models\Master\ProductImage');        
    }

}
