<?php

namespace App\Services;

use App\Notifications\EtherChangeThresholdExceeded;
use App\Price;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Zttp\Zttp;

class EtherPriceService
{
    const PAST_DATA_THRESHOLD_MINUTES = 10;

    public function analyzePrice()
    {
        $currentPrice = $this->getCurrentPrice();
        $historicalPrices = $this->getHistoricalPrices();

        User::all()->each(function(User $user) use ($currentPrice, $historicalPrices) {
            if($user->notifications_enabled) {
                $this->analyzePriceByUser($user, $currentPrice, $historicalPrices);
            }
        });
    }

    protected function analyzePriceByUser(User $user, Price $currentPrice, Collection $historicalPrices)
    {
        $thresholdExceeded = false;

        foreach($historicalPrices as $historicalPrice) {
            $priceChange = $currentPrice->price - $historicalPrice->price;
            $percentChange = $priceChange / $currentPrice->price * 100;

            $priceThresholdExceeded = $user->threshold_price && (abs($priceChange) > $user->threshold_price);
            $percentThresholdExceeded = $user->threshold_percent && (abs($percentChange) > $user->threshold_percent);

            if($priceThresholdExceeded || $percentThresholdExceeded) {
                $thresholdExceeded = true;
                break;
            }
        }

        if($thresholdExceeded) {
            $user->notify(new EtherChangeThresholdExceeded(
                $currentPrice,
                $historicalPrice,
                $priceChange,
                $percentChange));

            $user->storeNotification($currentPrice->id, $historicalPrice->id, $priceChange, $percentChange);
        }
    }

    protected function getCurrentPrice()
    {
        $response = Zttp::get(config('api.prices.eth_usd'))->json();
        $price = array_get($response, 'USD');

        return Price::create(compact('price'));
    }

    protected function getHistoricalPrices()
    {
        return Price::where('created_at', '>=', Carbon::now()->subMinutes(self::PAST_DATA_THRESHOLD_MINUTES))
            ->orderBy('created_at', 'desc')
            ->get();
    }

}