<?php

namespace App\Http\Controllers;

use Auth;
use FLash;
use Lang;
use Notifynder;        
use App\Models\Post;
use App\Models\User;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

    public function index()
    {
        $posts = Post::paginate(20);
        return view('posts.index', compact('posts'));
    }

    public function create(Post $post)
    {
        return view('posts.create_and_edit', compact('post'));
    }

    public function store(PostRequest $request)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->point < 1) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        // Create post.
        $post = Post::createWithInput([
            'content' => $markdown,
            //'replyto' => $request->input('title'),
         ]);
        $post->user = $user->id;
        $post->topic = $topic->id;
        $post->type = 1;
        $post->status = 1;
        $post->save();
        // User statics
        $user->point -= 1;
        $user->replies += 1;
        $user->save();
        // Send notification.
        if ($post->topics->user->id != $user->id) {
            // Reply notification.
            Notifynder::category('user.reply')
                ->from($user->username)
                ->to($post->topics->users->username)
                ->url(route('topics.show', $post->topics->id))
                ->send();            
        }
        // @ notification.
        $atList = [];
        preg_match_all('\@([a-zA-Z0-9\x80-\xff\-_]{3,20}) ', $content, $atList, PREG_PATTERN_ORDER);
        $atList = array_unique($atList[1]);
        // Get user list.
        $userList = User::whereIn('username', $atList[])->get();
        foreach ($userList as $at) {
            // Don't at self.
            if ($at != $user->username) {
                // Replace username to markdown links.
                $at = str_replace($user->username, '[@' . $user->username . '](' . route('users.show', $user->id) . ')', $at);
                // @ notification.
                Notifynder::category('user.at')
                    ->from($user->username)
                    ->to($at)
                    ->url(route('topics.show', $post->topics->id))
                    ->send();
            }
        }
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.create_and_edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($markdown);
        // Update post.
        $post->updateWithInput($request->input('content'));
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        // Set status = -1 to delete.
        $post->status = -1;
        $post->save();
        // Soft delete.
        $post->delete();
        // User statics.
        $user =  User::find($topic->user);
        $user->replies -= 1;
        $user->save();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('posts.index');
    }
}
