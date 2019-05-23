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

    public function getAllUnread(){
        $user = Auth::guard('user')->user();
        $unread = $user->unreadNotifications;
        // $user->unreadNotifications->markAsRead();
        return $user->unreadNotifications ;
    }
}
