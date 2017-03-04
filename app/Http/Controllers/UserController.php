<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Image;
use Lang;
use App\Models\User;
use Md\MDAvatars;
use Intervention\Image\ImageManager;
use \Intervention\Image\AbstractFont as Font;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        if (Auth::check()) {
            // Only admin user can create or update users.
            $this->middleware('admin', ['except' => ['index', 'show']]);
        } else {
            // Register user.
            $this->middleware('guest', ['only' => 'create']);
        }
    }

    public function index()
    {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function create(User $user)
    {
        return view('users.create_and_edit', compact('user'));
    }

    public function store(UserRequest $request)
    {
        // Create an image manager instance with favored driver.
        //$manager = new ImageManager(['driver' => 'gd']);
        // To finally create image instances.
        //$img = $manager->canvas(800, 100, '#fff');
        // Create user.
        $user = User::createWithInput([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // Set trusted IP.
        $request->setTrustedProxies(['127.0.0.1']);
        $user->points = 20;
        $user->regip = $request->getClientIp();
        $user->save();
        // Save default avatar.
        $avatar = new MDAvatars($request->input('username'), 512);
        $avatar->Save(public_path('avatars/' . $user->id . '.png'), 512);
        $avatar->Free();
        // Send email.
        // Show message.
        Flash::success(Lang::get('global.register_successfully'));
        return redirect()->intended();
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.create_and_edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        // Update user.
        $user->updateWithInput($request->all());
        // Show messgae.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        // Ban the user.
        $user->status = -1;
        $user->save();
        // Soft delete.
        $user->delete();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('users.index');
    }

    public function home(User $user)
    {

    }

    public function profile(User $user)
    {
        
    }

    public function topics(User $user)
    {
        
    }

    public function replies(User $user)
    {
        
    }

    public function notifications(User $user)
    {
        
    }

    public function followers(User $user)
    {
        
    }

    public function followings(User $user)
    {
        
    }
}