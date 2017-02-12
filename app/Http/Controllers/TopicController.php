<?php

namespace App\Http\Controllers;

use Flash;
use Lang;
use App\Models\Topic;
use App\Models\Post;
use App\Models\Node;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

    public function index()
    {
        $topics = Topic::paginate(20);
        return view('topics.index', compact('topics'));
    }

    public function create(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
    }

    public function store(TopicRequest $request)
    {
        // Get user id.
        $user = Auth::user();
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        // Create topic and post.
        Topic::createWithInput([
            'node' => $request->input('node'),
            'title' => $request->input('title'),
        ]);
        Topic::user = $user->id;
        Topic::save();
        Post::createWithInput([
            'title' => $request->input('title'),
            'content' => $markdown,
        ]);
        Post::user = $user->id;
        Post::post = 1;
        Post::save();
        // Add tag.
        Topic::tag($request->input('tags'));
        // Show message.
        Flash::success('Item created successfully.');
        return redirect()->route('topics.index');
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        // Get user id.
        $user = Auth::user();
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        // Update topic.
        $topic->updateWithInput([
            'title' => $request->input('title'),
            'content' => $markdown,
        ]);
        // Update tags.
        $topic->retag($request->input('tags'));
        // Show messgae.
        Flash::success('Item updated successfully.');
        return redirect()->route('topics.index');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        // Set status = -1 to delete.
        $topic->status = -1;
        $topic->save();
        // Soft delete.
        $topic->delete();
        // Show message.
        Flash::success('Item deleted successfully.');
        return redirect()->route('topics.index');
    }
}
