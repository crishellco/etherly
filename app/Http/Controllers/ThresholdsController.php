<?php

namespace App\Http\Controllers;

use App\Threshold;
use Illuminate\Http\Request;

class ThresholdsController extends Controller
{
    public function index()
    {
        return view('thresholds.index', ['thresholds' => auth()->user()->thresholds]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'minutes' => 'required|numeric',
            'percent' => 'nullable|required_if:price,""|numeric',
            'price' => 'nullable|required_if:percent,""|numeric',
        ]);

        auth()->user()->thresholds()->save(Threshold::make($request->only(['minutes', 'percent', 'price'])));

        flash('Threshold created.')->important();

        return redirect('thresholds');
    }

    public function destroy(Threshold $threshold)
    {
        if($threshold->user_id !== auth()->id()) {
            flash('Threshold not found.')->error()->important();

            return redirect('thresholds');
        }

        $threshold->delete();

        flash('Threshold deleted.')->important();

        return redirect('thresholds');
    }
}
