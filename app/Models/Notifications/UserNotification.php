<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
class UserNotification extends DatabaseNotification
{
    protected $table = 'user_notifications';

}
