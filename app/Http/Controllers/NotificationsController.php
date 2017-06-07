<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('notifications.index', ['notifications' => Auth::user()->notifications]);
    }
}
