<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EtherPrice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'EtherPrice';
    }
}