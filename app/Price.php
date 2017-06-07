<?php

namespace App;

use App\Facades\EtherPrice;
use App\Observers\PriceObserver;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'percent_change',
        'price',
        'price_change',
    ];

    public static function boot()
    {
        parent::boot();

        self::observe(PriceObserver::class);
    }

    public function calculatePreviousPrice()
    {
        $previous = $this->getPreviousPrice();

        if(!$previous) {
            return;
        }

        $this->update([
            'percent_change' => sprintf('%0.2f', EtherPrice::calculatePercentChange($this, $previous)),
            'price_change' => sprintf('%0.2f', EtherPrice::calculatePriceChange($this, $previous)),
        ]);
    }

    protected function getPreviousPrice()
    {
        return Price::where('created_at', '<', $this->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
