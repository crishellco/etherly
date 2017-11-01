<?php

namespace App\Services;

use App\Alert;
use App\Notifications\EtherChangeThresholdExceeded;
use App\Notifications\EtherPriceAlert;
use App\Price;
use App\Threshold;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Zttp\Zttp;

class EtherPriceService
{
    const CANDLESTICK_GRAPH_CACHE_KEY = 'graph.candlestick';
    const GRAPH_CACHE_LENGTH = 10;
    const PAST_DATA_THRESHOLD_MINUTES = 10;

    public function analyzePrice()
    {
        $currentPrice = $this->getCurrentPrice();
        $historicalPrices = $this->getHistoricalPrices();
        $this->cacheGraphData();

        User::all()->each(function(User $user) use ($currentPrice, $historicalPrices) {
            if($user->notificationsEnabled()) {
                $this->analyzePriceByUser($user, $currentPrice, $historicalPrices);
            }
        });
    }

    protected function analyzePriceByUser(User $user, Price $currentPrice, Collection $historicalPrices)
    {
        $notifiableThreshold = null;
        $historicalPrice = 0;
        $priceChange = 0;
        $percentChange = 0;
        $lastPrice = $historicalPrices->first();

        /**
         * Alerts
         */
        $user->alerts
            ->filter(function(Alert $alert) use ($currentPrice, $lastPrice) {
                return $alert->surpassed($currentPrice, $lastPrice);
            })
            ->each(function(Alert $alert) use ($user, $currentPrice, $lastPrice) {
                $user->notify(new EtherPriceAlert($alert, $currentPrice, $lastPrice));
            });

        /**
         * Thresholds
         */
        foreach($historicalPrices as $historicalPrice) {
            $priceChange = $this->calculatePriceChange($currentPrice, $historicalPrice);
            $percentChange = $this->calculatePercentChange($currentPrice, $historicalPrice);

            $notifiableThreshold = $user->thresholds
                ->first(function(Threshold $threshold) use ($currentPrice, $historicalPrice) {
                    $threshold->exceeded($currentPrice, $historicalPrice);
                });

            if($notifiableThreshold) {
                break;
            }
        }

        if($notifiableThreshold) {
            $user->notify(new EtherChangeThresholdExceeded(
                $notifiableThreshold,
                $currentPrice,
                $historicalPrice,
                $priceChange,
                $percentChange
            ));

            $user->storeNotification($currentPrice->id, $historicalPrice->id, $priceChange, $percentChange);
        }
    }

    public function cacheGraphData()
    {
        $allData = Price::orderBy('created_at')
            ->get()
            ->map(function($price) {
                return [
                    'created_at' => $price->created_at->timestamp * 1000,
                    'price' => (float) $price->price
                ];
            });

        $candlestickData = collect($allData)
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

        Cache::put(self::CANDLESTICK_GRAPH_CACHE_KEY, $candlestickData, self::GRAPH_CACHE_LENGTH);
    }

    public function calculatePercentChange(Price $current, Price $historical)
    {
        return $this->calculatePriceChange($current, $historical) / $current->price * 100;
    }

    public function calculatePriceChange(Price $current, Price $historical)
    {
        return $current->price - $historical->price;
    }

    public function getCurrentPrice()
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