<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
		Comment::createWithInput($request->all());
		return redirect()->route('comments.index')->with('message', 'Item created successfully.');
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
		$comment->updateWithInput($request->all());

		return redirect()->route('comments.index')->with('message', 'Item updated successfully.');
	}

	public function destroy(Comment $comment)
	{
		$this->authorize('destroy', $comment);
		$comment->delete();

		return redirect()->route('comments.index')->with('message', 'Item deleted successfully.');
	}
}