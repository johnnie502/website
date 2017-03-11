<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use Notifynder; 
use App\Models\Point;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

    public function create(Topic $topic, Post $post)
    {
        return view('topics.create_and_edit', compact('topic', 'post'));
    }

    public function store(PostRequest $request, Topic $topic)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->can('create')) {
            if ($user->points < 1) {
                Flash::error('Your points are not enough');
                return back()->withInput();
            }
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // @ notification.
            $atList = [];
            preg_match_all('\@([a-zA-Z0-9\x80-\xff\-_]{3,20}) ', $markdown, $atList, PREG_PATTERN_ORDER);
            $atList = array_unique($atList[1]);
            // Get user list.
            $userList = User::whereIn('username', $atList[])->get();
            foreach ($userList as $at) {
                // Don't at self.
                if ($at != $user->username) {
                    // Replace username to markdown links.
                    $markdown = str_replace($at, '[@' . $at . '](' . route('users.show', $user->id) . ')', $markdown);
                    // @ notification.
                    Notifynder::category('user.at')
                        ->from($user->username)
                        ->to($at)
                        ->url(route('topics.show', $topic->id))
                        ->send();
                    $atUser = User::where('username', $at)->first();
                    if ($atUser) {
                        $atUser->notifications += 1;
                        $atUser->save();
                    }
                }
            }
            // Create post.
            $post = Post::createWithInput([
                'content' => $markdown,
             ]);
            // Topics
            $topic->replies += 1;
            $topic->last_reply = $user->id;
            $topic->replied_at = Carbon::now ();
            $topic->save();
            // Save post.
            $post->user = $user->id;
            $post->topic = $topic->id;
            $post->post = $topic->replies;
            $post->type = 1;
            $post->status = 1;
            $post->save();
            // User statics
            $user->points -= 3;
            $user->replies += 1;
            $user->save();
            // Update points.
            $point->user = $user->id;
            $point->type = 3;
            $point->points = 3;
            $point->total_points = $user->points;
            $point->got_at = Carbon::now();
            $point->save();
            // Send notification.
            if ($topic->users->id != $user->id) {
                // Reply notification.
                $toUser = $topic->users->first();
                Notifynder::category('user.reply')
                    ->from($user->username)
                    ->to($toUser->username)
                    ->url(route('topics.show', $topic->id))
                    ->send(); 
                $toUser->notifications += 1;
                $toUser->save();
            }
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('topics.show', $topic->id);
        }
    }

    public function show(Topic $topic, Post $post)
    {
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
        return view('topics.create_and_edit', compact('topic', 'post'));
    }

    public function update(PostRequest $request, Topic $topic, Post $post)
    {
     // Get user id.
        $user = Auth::user();
        if ($user->can('update', $post)) {
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // Update post.
            $post->updateWithInput([
                'content' => $request->input('content')
            ]);
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('topics.show', $topic->id);
        }
    }

    public function destroy(Topic $topic, Post $post)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('destroy', $post)) {
           // Set status = -1 to delete.
            $post->status = -1;
            $post->save();
            // Soft delete.
            $post->delete();
            // Topic
            $topic->replies -= 1;
            $topic->save();
            // User statics.
            $user->replies -= 1;
            $user->save();
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('topics.show', $topic->id);
        }
    }
}
