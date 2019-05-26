<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AdminNotificationController extends Controller
{
    public function getUnreadCount(){
        $user = Auth::guard('admin')->user();
        return sizeof($user->unreadNotifications) ;
    }

    public function getAll(){
        $user = Auth::guard('admin')->user();
        $user->unreadNotifications->markAsRead();
        return $user->notifications ;
    }

}
