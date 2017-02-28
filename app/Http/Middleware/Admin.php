<?php

namespace App\Http\Middleware;

use Auth;
use Flash;
use Closure;

class AdminAuth
{

    public function handle($request, Closure $next)
    {
        // The user is login?
        if (!Auth::user()->type < 4) {
            // Not Admin.
            Flash::error('You don\'t have permission.');
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
