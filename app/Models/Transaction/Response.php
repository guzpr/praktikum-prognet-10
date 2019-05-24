<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public function review(){
        return $this->hasOne('App\Models\Transaction\Review');
    }

}
