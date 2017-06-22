<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use App\Mail\AtYou;
use App\Mail\ReplyTopic;
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
    protected $user;

    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'create', 'edit'
            ],
        ]);
        $this->middleware('admin', ['only' => 'destory']);
        // Get user id while the user has logged.
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    public function create(Comment $comment)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $comment);
        return view('comments.create_and_edit', compact('comment'));
    }

    public function store(CommentRequest $request)
    {
        if (Auth::check()) $this->authorize('create', $this->user, Comment::class);
        if ($this->user->point_count < 1) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
        // Convert HTML topic content to markdown.
        $markdown = (new HtmlConverter())->convert($request->input('content'));
        // Fix the contents.
        $markdown = (new CopyWritingCorrectService())->correct($markdown);
        $comment = Comment::createWithInput([
            'content' => $markdown,
        ]);
        // User statics
        $this->user->point_count -= 1;
        $this->user->save();
        // Update points.
        $point->user = $this->user->id;
        $point->type = 6;
        $point->point = -1;
        $point->total_points = $this->user->point_count;
        $point->got_at = Carbon::now();
        $point->save();
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('comments.index');
    }

    public function show(Comment $comment)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $comment);
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $comment);
        return view('comments.create_and_edit', compact('comment'));
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $comment);
        // Convert HTML topic content to markdown.
        $markdown = (new HtmlConverter())->convert($request->input('content'));
        // Fix the contents.
        $markdown = (new CopyWritingCorrectService())->correct($markdown);
        $comment->updateWithInput([
            'content' => $markdown,
        ]);
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('comments.index');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::check()) $this->authorize('delete', $this->user, $comment);
        $comment->delete();
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('comments.index');
    }
}