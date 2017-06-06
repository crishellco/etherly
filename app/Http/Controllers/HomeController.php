<?php

namespace App\Http\Controllers;

use App\Price;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Price::all()->map(function($price) {
            return [
                $price->created_at->timestamp * 1000, // Milliseconds
                (float) $price->price,
            ];
        });

        return view('home', compact('data'));
    }

}
