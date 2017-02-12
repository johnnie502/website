<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Flash;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // The user is login?
        if (Auth::check()) {
            $user = Auth::user();
            // The user is admin?
            if ($user->type < 4) {
                Flash::error('You don\'t have permission.');
                return back()->withInput();
            }
        } else {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
