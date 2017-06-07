<?php

if (! function_exists('developer')) {
    function developer()
    {
        return collect(config('admin.developers', []))
            ->contains(data_get(auth()->user(), 'email'));
    }
}