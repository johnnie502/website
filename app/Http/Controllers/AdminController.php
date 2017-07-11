<?php

namespace App\Http\Controllers;

use Config;
use Crypt;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
    	if ($request->user()) {
	        // Only admin user can login.
	        $this->middleware('admin');
	    } else {
	    	$this->middleware('auth');
	    }
        // Get user id while the user has logged.
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    public function postLogin(Request $request)
    {
    	$str = !empty(Config('site.encstr')) ? Config('site.encstr') : 'The quick brown fox jumps over the lazy dog';
    	$encrypted = Crypt::encryptString($str);
    }

    public function adminRequire(Request $request
    	)
    {

    }
}
