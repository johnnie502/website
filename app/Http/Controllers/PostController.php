<?php

namespace App\Http\Controllers;

use FLash;
use Lang;
use App\Models\Post;
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
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        // Create post.
        Post::createWithInput([
            'title' => $request->input('title'),
            'content' => $markdown,
        ]);
        Post::user = $user->id;
        Post::post = 1;
        Post::save();
        // Show message.
        Flash::success('Item created successfully.');
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
        Flash::success('Item updated successfully.');
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
        // Show message.
        Flash::success('Item deleted successfully.');
        return redirect()->route('posts.index');
    }
}
