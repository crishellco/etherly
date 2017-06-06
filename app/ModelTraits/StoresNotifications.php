<?php

namespace App\ModelTraits;

use App\Notification;

trait StoresNotifications
{

    public function storeNotification($currentPriceId, $historicalPriceId, $percentChange)
    {
        $notification = Notification::make([
            'current_price_id' => $currentPriceId,
            'historical_price_id' => $historicalPriceId,
            'percent_change' => $percentChange,
            'threshold' => $this->threshold,
        ]);

        $this->notifications()->save($notification);
    }
}