<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\Master\Users','user_id','id');
    }

    public function courier(){
        return $this->belongsTo('App\Models\Master\Courier','courier_id','id');
    }
}
