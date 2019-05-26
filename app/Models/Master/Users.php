<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Models\Notifications\UserNotification;
class Users extends Authenticatable 
{

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function review(){
        return $this->hasMany('App\Models\Transaction\ProductReview','user_id','id'); 
    }

    public function transaction(){
        return $this->hasMany('App\Models\Transaction\Transaction','user_id','id'); 
    }

    public function notifications()
    {
        return $this->morphMany(UserNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
}
