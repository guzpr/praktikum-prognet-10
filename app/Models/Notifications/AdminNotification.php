<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
class AdminNotification extends DatabaseNotification
{
    protected $table = 'admin_notifications';

}