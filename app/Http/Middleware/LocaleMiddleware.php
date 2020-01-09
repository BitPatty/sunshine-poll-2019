<?php

namespace App\Http\Middleware;

use Closure;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        \Illuminate\Support\Facades\App::setLocale(env('POLL_LOCALE'));
        return $next($request);
    }


}
