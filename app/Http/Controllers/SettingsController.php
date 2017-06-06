<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'slack_webhook' => 'nullable|url',
            'threshold' => 'required|numeric'
        ]);

        $updates = $request->only(
            ['name', 'notifications_enabled', 'slack_webhook', 'threshold']
        );

        $updates['notifications_enabled'] = $request->has('notifications_enabled') ? true : false;

        Auth::user()->update($updates);
        flash('Settings updated.')->important();

        return redirect('settings');
    }
}
