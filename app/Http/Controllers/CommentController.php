<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use App\Models\Comment;
use App\Models\Point;
use App\Models\Post;
use App\Models\Topic;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit']]);
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
        $this->authorize('create');
        // Get user id.
        $user = Auth::user();
        if ($user->points < 1) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        $comment = Comment::createWithInput([
                'content' => $markdown,
            ]);
        // User statics
        $user->points -= 1;
        $user->save();
        // Update points.
        $point->user = $user->id;
        $point->type = 6;
        $point->points = -1;
        $point->total_points = $user->points;
        $point->got_at = Carbon::now();
        $point->save();
        Flash::success(Lang::get('global.operation_successfully'));
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
        // Get user id.
        $user = Auth::user();
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        $comment->updateWithInput([
            'content' => $markdown,
        ]);
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('comments.index');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);
        $comment->delete();

        return redirect()->route('comments.index');
    }
}