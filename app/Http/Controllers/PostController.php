<?php

namespace App\Http\Controllers;

use FLash;
use Lang;
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
        $post->topic = ;
        $post->save();
        // User statics
        $user->point -= 21;
        $user->replies += 1;
        $user->save();
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
