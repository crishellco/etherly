<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ]);

        $updates = $request->only(
            [
                'name',
                'slack_webhook',
                'via_email',
                'via_slack',
            ]
        );

        $updates['via_email'] = $request->has('via_email') ? true : false;
        $updates['via_slack'] = $request->has('via_slack') ? true : false;

        auth()->user()->update($updates);
        flash('Settings updated.')->important();

        return redirect('settings');
    }
}
