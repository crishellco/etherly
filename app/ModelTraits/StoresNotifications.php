<?php

namespace App\ModelTraits;

use App\Notification;

trait StoresNotifications
{

    public function storeNotification($currentPriceId, $historicalPriceId, $priceChange, $percentChange)
    {
        $notification = Notification::make([
            'current_price_id' => $currentPriceId,
            'historical_price_id' => $historicalPriceId,
            'percent_change' => $percentChange,
            'price_change' => $priceChange,
            'threshold_percent' => $this->threshold_percent,
            'threshold_price' => $this->threshold_price,
        ]);

        $this->notifications()->save($notification);
    }
}