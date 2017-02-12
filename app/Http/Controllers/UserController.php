<?php

namespace App\Http\Controllers;

use App\Models\User;
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
		User::createWithInput($request->all());
		return redirect()->route('users.index')->with('message', 'Item created successfully.');
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
		$user->updateWithInput($request->all());

		return redirect()->route('users.index');
	}

	public function destroy(User $user)
	{
		$this->authorize('destroy', $user);
		$user->delete();

		return redirect()->route('users.index');
	}
}
