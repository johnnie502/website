<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Image;
use Lang;
use Mail;
use App\Jobs\LogoffUser;
use App\Jobs\SendEmail;
use App\Mail\RegisterConfirm;
use App\Models\User;
use Carbon\Carbon;
use Md\MDAvatars;
use Intervention\Image\ImageManager;
use \Intervention\Image\AbstractFont as Font;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        if ($request->user()) {
            // Only admin user can create or update users.
            $this->middleware(
                'admin', ['except' => [
                    'index', 'show', 'profile', 'notifications', 'getFollow', 'postFollow', 'getUnfollow', 'postUnfollow'
                ],
            ]);
        } else {
            // Register user.
            $this->middleware('guest', ['only' => 'create']);
        }
        // Get user id while the user has logged.
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (Auth::check()) $this->authorize('view', $this->user, User::class);
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function create(User $user)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $user);
        return view('users.create_and_edit', compact('user'));
    }

    public function store(UserRequest $request)
    {
        // Create an image manager instance with favored driver.
        //$manager = new ImageManager(['driver' => 'gd']);
        // To finally create image instances.
        //$img = $manager->canvas(800, 100, '#fff');
        // Create user.
        if (Auth::check()) $this->authorize('create', $this->user, User::class);
        $user = User::createWithInput([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // Set trusted IP.
        $request->setTrustedProxies(['127.0.0.1']);
        $user->type = 1;
        $user->point_count = 20;
        $user->regip = $request->getClientIp();
        $user->save();
        // Save default avatar.
        $avatar = new MDAvatars($request->input('username'), 512);
        $avatar->Save(public_path('avatars/' . $user->id . '.png'), 512);
        $avatar->Free();
        // Send email.
        Mail::to($request->user())
            ->send(new RegisterConfirm($user));
        // Show message.
        Flash::success(Lang::get('global.register_successfully'));
        return redirect()->intended();
    }

    public function show(User $user)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $user);
        $user = User::where('username', $user)->firstOrFail();
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $user);
        $user = User::where('username', $user)->firstOrFail();
        return view('users.create_and_edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $user);
        // Update user.
        $user->updateWithInput([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // Update avatar.
        if ($request->has('avatar')) {
            $request->file('avatar')->storeAs('avatars/', $request->user()->id, 'public');
        }
        // Show messgae.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('users.show', $user->username);
    }

    public function destroy(User $user)
    {
        if (Auth::check()) $this->authorize('delete', $this->user, $user);
        // Ban the user.
        $user->status = -1;
        $user->save();
        // Soft delete.
        $user->delete();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('users.index');
    }

    public function postFollow(User $user)
    {
        if (Auth::check()) $this->authorize('follow', $this->user, $user);
        if ($this->user->id == $user->id) {
            Flash::error('不能关注自己');
            return back();
        }
        // Follow user.
        $thi->user->follow($user->id);
    }

    public function postUnfollow(User $user)
    {
        if (Auth::check()) $this->authorize('follow', $this->user, $user);
        if ($this->user->id == $user->id) {
            Flash::error('不能取消关注自己');
            return back();
        }
        // Unfollow user.
        if ($this->user->isFollowing($user->id)) {
            $this->user->unfollow($user->id);
        }
    }

    public function logoff(User $user)
    {
        // Logoff user.
        $job = (new LogoffUser($user))
                    ->delay(Carbon::now()->addMonth());
        dispath($job);
    }

    public function restore(User $user)
    {
        // Restore user.
        dispatch(new RestoreUser($user));
    }
}