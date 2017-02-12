<?php

namespace App\Http\Controllers;

use Flash;
use Lang;
use App\Models\User;
use Md\MDAvatars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
        // Create user.
        User::createWithInput(
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        User::points = 20;
        User::regip = $request->ip();
        User::save();
        // Save default avatar.
        $avatar = new MDAvatars($request->input('username'), 512);
        $avatar->Save(public_path('avatars/' . $user->id . '.png'), 256);
        $avatar->Free();
        // Show message.
        Flash::success('Item created successfully.');
        return redirect()->route('users.index');
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
        Flash::success('');
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
        Flash::success('Item deleted successfully.');
        return redirect()->route('users.index');
    }
}
