<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Threshold extends Model
{
    protected $fillable = [
        'minutes',
        'percent',
        'price',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
