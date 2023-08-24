<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        $get_all_notifications = Notification::orderBy('id', 'desc')->get();
        return view("dashboard", compact('get_all_notifications'));
    }
}
