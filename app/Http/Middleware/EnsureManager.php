<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureManager
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (optional(auth()->user())->role !== 'manager') {
            abort(403, 'غير مصرح: هذه الصفحة للمدير فقط');
        }
        return $next($request);
    }
}
