<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('developer')) {
    function developer()
    {
        return collect(config('admin.developers', []))
            ->contains(data_get(Auth::user(), 'email'));
    }
}