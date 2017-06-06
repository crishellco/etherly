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
    const DEFAULT_PERCENT_CHANGE_THRESHOLD = 1;
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
            $percentChange = round(($currentPrice->price - $historicalPrice->price) / $currentPrice->price * 100, 2);
            if(abs($percentChange) >= (float) $user->threshold) {
                $thresholdExceeded = true;
                break;
            }
        }

        if($thresholdExceeded) {
            $user->notify(new EtherChangeThresholdExceeded(
                $currentPrice,
                $historicalPrice,
                $percentChange));

            $user->storeNotification($currentPrice->id, $historicalPrice->id, $percentChange);
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