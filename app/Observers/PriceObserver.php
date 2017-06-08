<?php

namespace App\Observers;

use App\Events\EtherPriceUpdated;
use App\Price;

class PriceObserver
{
    public function created(Price $price)
    {
        $price->calculatePreviousPrice();
        event(new EtherPriceUpdated);
    }
}