<?php

namespace App\Observers;

use App\Price;

class PriceObserver
{
    public function created(Price $price)
    {
        $price->calculatePreviousPrice();
    }
}