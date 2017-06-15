<?php

namespace App\Http\Controllers;

use Agent;
use Auth;
use Flash;
use Lang;
use Notification;
use App\Mail\AtYou;
use App\Mail\ReplyTopic;
use App\Models\Point;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use League\HTMLToMarkdown\HtmlConverter;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'create', 'edit', 'getUpvote', 'postUpvote', 'getDownvote', 'postDownvote'
            ],
        ]);
        $this->middleware('admin', ['only' => 'destory']);
        // Get user id while the user has logged.
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    public function create(Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $post);
        return view('topics.create_and_edit', compact('topic', 'post'));
    }

    public function store(PostRequest $request, Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $post);
        if ($this->user->point_count < 3) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
        // Convert HTML topic content to markdown.
        if (Agent::isPhone()) {
            // Editor.md
            $markdown = $request->input('content');
        } else {
            // Ueditor
            $markdown = (new HtmlConverter())->convert($request->input('content'));
        }
        // Fix the contents.
        $markdown = (new CopyWritingCorrectService())->correct($markdown);
        // @ notification.
        $atList = [];
        preg_match_all('/@([a-zA-Z0-9\x80-\xff\-_]{3,20}) /', $markdown, $atList, PREG_PATTERN_ORDER);
        $atList = array_unique($atList[1]);
        // Get user list.
        $this->userList = User::whereIn('username', $atList)->get();
        foreach ($this->userList as $at) {
            // Don't at self.
            if ($at != $this->user->username) {
                // Replace username to markdown links.
                $markdown = str_replace($at, '[@' . $at . '](' . route('users.show', $this->user->id) . ')', $markdown);
                // At notification.
                Notification::send($at, new At($topic->id, $post->id));
                $atUser = User::where('username', $at)->first();
                if ($atUser) {
                    $atUser->notification_count += 1;
                    $atUser->save();
                }
            }
        }
        // Create post.
        $post = Post::createWithInput([
            'content' => $markdown,
        ]);
        // Topics
        $topic->reply_count += 1;
        $topic->lastreply = $this->user->id;
        $topic->replied_at = Carbon::now ();
        $topic->save();
        // Save post.
        $post->content = $markdown;
        $post->user = $this->user->id;
        $post->topic = $topic->id;
        $post->post = $topic->reply_count;
        $post->type = 1;
        $post->status = 1;
        $post->save();
        // User statics
        $this->user->point_count -= 3;
        $this->user->reply_count += 1;
        $this->user->save();
        // Update points.
        $point = Point::class;
        $point->user = $this->user->id;
        $point->type = 3;
        $point->point = 3;
        $point->total_points = $this->user->point_count;
        $point->got_at = Carbon::now();
        $point->save();
        // Send notification.
        if ($topic->users->id != $this->user->id) {
            // Reply notification.
            $toUser = $topic->users->first();
            Notifynder::category('user.reply')
                ->from($this->user->username)
                ->to($toUser->username)
                ->url(route('topics.show', $topic->id))
                ->send(); 
            $toUser->notification_count += 1;
            $toUser->save();
        }
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.show', $topic->id);
    }

    public function show(Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $post);
        if ($post->id > 0) {
            $posts = Post::where('topic', $topic->id)
                ->whereIn('post', [0, $post->id])
                ->firstOrFail();
        } else {
            $posts = Post::where('topic', $topic->id)
                ->where('post', 0)
                ->firstOrFail();
        }
        return view('topics.show', compact('topic', 'posts'));
    }

    public function edit(Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $post);
        return view('topics.create_and_edit', compact('topic', 'post'));
    }

    public function update(PostRequest $request, Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $post);
        // Convert HTML topic content to markdown.
        if (Agent::isPhone()) {
            // Editor.md
            $markdown = $request->input('content');
        } else {
            // Ueditor
            $markdown = (new HtmlConverter())->convert($request->input('content'));
        }
        // Fix the contents.
        $markdown = (new CopyWritingCorrectService())->correct($markdown);
        // Update post.
        $post->updateWithInput([
            'content' => $markdown
        ]);
        $post->edit_count += 1;
        $post->save();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.show', $topic->id);
    }

    public function destroy(Topic $topic, Post $post)
    {
        if (Auth::check()) $this->authorize('delete', $this->user, $post);
        // Set status = -1 to delete.
        $post->status = -1;
        $post->save();
        // Soft delete.
        $post->delete();
        // Topic
        $topic->reply_count -= 1;
        $topic->save();
        // User statics.
        $this->user->reply_count -= 1;
        $this->user->save();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.show', $topic->id);
    }

    public function postUpvote(Post $post)
    {
    	if (Auth::check()) $this->authorize('vote', $this->user, $post);
        if ($this->user->hasVoted($post)) {
            $this->user->cancelVote($post);
        }
        // Up vote the post.
        $this->user->upVote($post);
    }

    public function postDownvote(Post $post)
    {
        if (Auth::check()) $this->authorize('vote', $this->user, $post);
        if ($this->user->hasVoted($post)) {
            $this->user->cancelVote($post);
        }
        // Down vote the post.
        $this->user->downVote($post);
    }
}