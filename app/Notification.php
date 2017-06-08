<?php

namespace App;

use App\Observers\NotificationObserver;
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

    protected $with = [
        'currentPrice',
        'historicalPrice',
    ];

    public static function boot()
    {
        parent::boot();

        self::observe(NotificationObserver::class);
    }

    public function currentPrice()
    {
        return $this->belongsTo(Price::class, 'current_price_id');
    }

    public function historicalPrice()
    {
        return $this->belongsTo(Price::class, 'historical_price_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
