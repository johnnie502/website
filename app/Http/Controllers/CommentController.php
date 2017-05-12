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
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

    public function create(Comment $comment)
    {
        return view('comments.create_and_edit', compact('comment'));
    }

    public function store(CommentRequest $request)
    {
        $comment = new Comment();
         // Get user id.
        $user = Auth::user();
        if ($user->can('create', $comment)) {
           // Get user id.
            $user = Auth::user();
            if ($user->point_count < 1) {
                Flash::error('Your points are not enough');
                return back()->withInput();
            }
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // Fix the contents.
            $markdown = CopyWritingCorrectService::correct($markdown);
            $comment = Comment::createWithInput([
                'content' => $markdown,
            ]);
            // User statics
            $user->point_count -= 1;
            $user->save();
            // Update points.
            $point->user = $user->id;
            $point->type = 6;
            $point->point = -1;
            $point->total_points = $user->point_count;
            $point->got_at = Carbon::now();
            $point->save();
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('comments.index');
        } else {
            return response(view('errors.403'), 403);
        }
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
         // Get user id.
        $user = Auth::user();
        if ($user->can('update', $comment)) {
           // Get user id.
            $user = Auth::user();
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // Fix the contents.
            $markdown = CopyWritingCorrectService::correct($markdown);
            $comment->updateWithInput([
                'content' => $markdown,
            ]);
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('comments.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function destroy(Comment $comment)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('delete', $comment)) {
            $comment->delete();
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('comments.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }
}