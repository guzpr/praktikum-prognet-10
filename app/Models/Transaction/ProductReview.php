<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\Master\Users','user_id','id');
    }

    public function response(){
        return $this->hasOne('App\Models\Transaction\Response','review_id','id');
    }
}
