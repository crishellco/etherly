<?php

namespace App\Http\Middleware;

use Closure;

class Developer
{
    public function handle($request, Closure $next)
    {
        if(!developer()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
