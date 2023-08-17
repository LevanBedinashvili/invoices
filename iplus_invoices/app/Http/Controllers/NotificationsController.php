<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Notification;

class NotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware(RoleMiddleware::class . ':1');
    }
    public function mark_as_seen()
    {
        $notification = Notification::where('is_seen', '0')->get();

        if($notification) {
            for($i = 1; $i <= $notification->count(); $i++) {
                $notification_change_status = Notification::where('is_seen', '0')->first();
                $notification_change_status->is_seen = 1;
                $notification_change_status->save();
            }
        }
        return back();
    }
}
