<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Flash;
use Lang;
use Session;
use Socialite;
use Storage;
use URL;
use Md\MDAvatars;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $registerView = 'auth.register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
    }

    public function postRegister(UserRequest $request)
    {   
        //注册表单验证
        $validator = Validator::make($request->all(), [
            'username' => 'bail|required|min:5|max:30|unique:users',
            'email' => 'bail|required|email|min:5|max:30|unique:users',
            'password' => 'bail|required|min:8|max:50',
        ]);
        
        //表单验证失败提示
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            if (count($errors) > 0) {
                Flash::error(implode('<br>', $errors));
            }
            return back()->withInput();
        }

        // Create user.
        $this->create($request->all());
        User::points = 20;
        User::regip = $request->ip();
        User::save();

        // Save default avatar.
        $avatar = new MDAvatars($request->input('username'), 512);
        $avatar->Save(public_path('avatars/' . $user->id . '.png'), 256);
        $avatar->Free();
        
        // Send email.
        Flash::success('注册用户成功，请在电子邮件中确认账号');
        return redirect()->intended();
    }

    /**
     * 将用户重定向到OAuth认证页面
     */
    public function redirectToProvider($driver)
    {
        //oauth方式
        if (in_array($driver, [
            'facebook', 'github', 'google', 'qq', 'twitter', 'weibo', 'weixin'
        ])) {
            return Socialite::driver($driver)->redirect();
        } else {
            return false;
        }
    }

    /**
     * 从OAuth获取认证用户信息
     */
    public function handleProviderCallback($driver)
    {
        //oauth方式
        if (in_array($driver, [
            'facebook', 'github', 'google', 'qq', 'twitter', 'weibo', 'weixin'
        ])) {
            $user = Socialite::driver($driver)->user();
        } else {
            return false;
        }

        //通过oauth登录
        $oauth = User::oauth($driver, $user->id);
        if (!$oauth) {
            //如果用户已经存在
            if (!empty(User::where('username', $user->name)->first())) {
                Flash::error("用户名已经存在");
                return redirect(URL::route('login'))
                            ->withInput();
            } else if (!empty(User::where('email', $user->email)->first())) {
                Flash::error("邮箱已经存在");
                return redirect(URL::route('login'))
                            ->withInput();
            }
            
            //创建用户
            User::create([
                'driver' => $driver,
                'oauth' => $user->id,
                'username' => $user->name,
                'email' => $user->email,
                'password' => '',
            ]);
            User::points = 20;
            User::regip = $request->ip();
            User::save();
            $userid = User::where('username', $user->name)->first()->id;

            //保存头像
            $client = new Client(['verify' => false]);
            $response = $client->get($user->avatar, ['save_to' => public_path('avatars/' . $userid . '.png')]);
        }

        //以ID登录
        Auth::loginUsingId($userid);
        Flash::success('认证用户成功');
        return redirect()->intended();
    }
}
