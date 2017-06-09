<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'price'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
