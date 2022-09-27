<?php

namespace Modules\Common\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class NotificationController extends Controller
{

    public function markAllAsRead()
    {
         auth()->user()->unreadNotifications->markAsRead();
         return back();
    }

}
