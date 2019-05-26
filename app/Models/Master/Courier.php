<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    public function transaction(){
        return $this->hasMany('App\Models\Transaction\Transaction','courier_id','id'); 
    }
}
