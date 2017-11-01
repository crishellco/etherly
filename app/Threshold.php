<?php

namespace App;

use App\Facades\EtherPrice;
use Illuminate\Database\Eloquent\Model;

class Threshold extends Model
{
    protected $fillable = [
        'minutes',
        'percent',
        'price',
    ];

    public function exceeded(Price $current, Price $past)
    {
        $priceChange = EtherPrice::calculatePriceChange($current, $past);
        $percentChange = EtherPrice::calculatePercentChange($current, $past);
        $priceThresholdExceeded = $this->price && (abs($priceChange) > $this->price);
        $percentThresholdExceeded = $this->percent && (abs($percentChange) > $this->percent);

        return $priceThresholdExceeded || $percentThresholdExceeded;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
