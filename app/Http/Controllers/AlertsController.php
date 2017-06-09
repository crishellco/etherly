<?php

namespace App\Http\Controllers;

use App\Alert;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    public function index()
    {
        return view('alerts.index', ['alerts' => auth()->user()->alerts]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'direction' => 'required|in:above,below',
            'price' => 'required|numeric',
        ]);

        auth()->user()->alerts()->save(Alert::make($request->only(['direction', 'price'])));

        flash('Alert created.')->important();

        return redirect('alerts');
    }

    public function destroy(Alert $alert)
    {
        if($alert->user_id !== auth()->id()) {
            flash('Alert not found.')->error()->important();

            return redirect('alerts');
        }

        $alert->delete();

        flash('Alert deleted.')->important();

        return redirect('alerts');
    }
}
