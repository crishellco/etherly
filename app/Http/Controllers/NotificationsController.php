<?php

namespace App\Http\Controllers;

class NotificationsController extends Controller
{
    public function all()
    {
        return auth()->user()->notifications;
    }

    public function index()
    {
        return view('notifications.index');
    }
}
