<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Flash;
use Lang;
use Session;
use Socialite;
use Storage;
use URL;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $maxLoginAttempts;
    protected $lockoutTime = 1800;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        // Get number of attempts to login.
        if ($this->hasTooManyLoginAttempts($request)) {
            Flash::error(Lang::get('auth.throttle'));
            return back()->withInput();
        }
        // Get request.
        $username = $request->input('username');
        $password = $request->input('password');
        $remeber = $request->input('remember');
        // Manually validation login request.
        $this->validate($request, [
            'username' => 'bail|required|min:5|max:30',
            'password' => 'bail|required|min:8|max:50|case_diff|numbers|letters|symbols',
        ]);
        // Determine whether is email or username login.
        $type = filter_var($username, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
        // Login attempts.
        if ($type == 'email') {
            if (Auth::attempt(['email' => $username, 'password' => $password], $request->has('remember'))) {
                // update logon ip.
                $user = User:: where('email', $username)->first();
                $user->lastip = $request->getClientIp();
                $user->save();
                Flash::success(Lang::get('global.login_successfully'));
                return redirect()->intended();
            } else {
                Flash::error(Lang::get('auth.failed'));
                return back()->withInput();
            }
        } else if (Auth::attempt(['username' => $username, 'password' => $password], $request->has('remember'))) {
            // update login ip.
            $user = User:: where('username', $username)->first();
            $user->lastip = $request->getClientIp();
            $user->save();
            Flash::success(Lang::get('global.login_successfully'));
            return redirect()->intended();
        } else {
            Flash::error(Lang::get('auth.failed'));
            return back()->withInput();
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        if (Auth::check()) {
            Auth::logout();
            Flash::success(Lang::get('global.logout_successfully'));
        }
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
