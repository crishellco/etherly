<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'current_price_id',
        'historical_price_id',
        'price_change',
        'percent_change',
        'threshold_percent',
        'threshold_price',
    ];
}
