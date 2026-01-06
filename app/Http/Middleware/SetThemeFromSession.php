<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetThemeFromSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        config(['app.theme' => 'theme1']);

        return $next($request);
    }
}
