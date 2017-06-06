<?php

namespace App\Http\Controllers;

use App\Price;

class EtherController extends Controller
{
    public function index()
    {
        $data = Price::orderBy('created_at')
            ->get()
            ->map(function($price) {
                return [
                    'created_at' => $price->created_at->timestamp * 1000,
                    'price' => (float) $price->price
                ];
            });

        return collect($data)
            ->chunk(5)
            ->map(function($group) {
                $prices = collect($group->pluck('price'));
                return [
                    array_get($group->first(), 'created_at'),
                    array_get($group->first(), 'price'),
                    $prices->max(),
                    $prices->min(),
                    array_get($group->last(), 'price'),
                ];
            });
    }
}
