<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'price'
    ];

    public function inRange($start, $stop)
    {
        return ($this->price >= $start && $this->price <= $stop)
            || ($this->price >= $stop && $this->price <= $start);
    }

    public function surpassed(Price $current, Price $last)
    {
        $direction = $current->price > $last->price ? 'above' : 'below';

        return $direction === $this->direction && $this->inRange($current->price, $last->price);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
