<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsGerant
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'GERANT') {
            return $next($request);
        }

        abort(403, 'Accès refusé. Vous n\'êtes pas un gérant.');
    }
}
