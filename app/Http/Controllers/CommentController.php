<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

	public function index()
	{
		$comments = Comment::paginate();
		return view('comments.index', compact('comments'));
	}

	public function create(Comment $comment)
	{
		return view('comments.create_and_edit', compact('comment'));
	}

	public function store(CommentRequest $request)
	{
		// Get user id.
        $user = Auth::user();
        if ($user->point < 1) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
		$comment = Comment::createWithInput($request->all());
		return redirect()->route('comments.index');
	}

	public function show(Comment $comment)
	{
		return view('comments.show', compact('comment'));
	}

	public function edit(Comment $comment)
	{
		return view('comments.create_and_edit', compact('comment'));
	}

	public function update(CommentRequest $request, Comment $comment)
	{
		$this->authorize('update', $comment);
		$comment->updateWithInput([
		    'content' => $request->input('content')
		]);

		return redirect()->route('comments.index');
	}

	public function destroy(Comment $comment)
	{
		$this->authorize('destroy', $comment);
		$comment->delete();

		return redirect()->route('comments.index');
	}
}