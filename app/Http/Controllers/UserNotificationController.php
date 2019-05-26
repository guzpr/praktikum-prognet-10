<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Users;
use Auth;
class UserNotificationController extends Controller
{
    public function getUnreadCount(){
        $user = Auth::guard('user')->user();
        return sizeof($user->unreadNotifications) ;
    }

    public function getAll(){
        $user = Auth::guard('user')->user();
        $user->unreadNotifications->markAsRead();
        return $user->notifications ;
    }
}
