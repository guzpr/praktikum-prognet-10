<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Users;
use App\Notifications\UserNotification;
use App\Models\Transaction\Transaction;
use Notification;
use Auth;
class TestNotificationController extends Controller
{
    public function test(){
        $user = Auth::guard('user')->user();
        $trs = Transaction::find(6);
        $trsBefore = $trs->status;
        $trs->status = 'delivered';
        $trs->save();
        Notification::send($user, new UserNotification($trsBefore,$trs));
        return $user->unreadNotifications ;
    }
}
