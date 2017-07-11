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
        if ($request->user() || Auth::check()) {
            if (Auth::user()->hasRole()) {
                if (Auth::user()->type >= 4) {
                    return $next($request);
                }
            }
        }
        Auth::logout();
        return redirect('login');
    }
}
