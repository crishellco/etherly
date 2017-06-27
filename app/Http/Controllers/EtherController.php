<?php

namespace App\Http\Controllers;

use App\Price;
use App\Services\EtherPriceService;
use Illuminate\Support\Facades\Cache;

class EtherController extends Controller
{
    public function index()
    {
        return Cache::get(EtherPriceService::CANDLESTICK_GRAPH_CACHE_KEY, []);
    }
}
