<?php

namespace App\Http\Controllers;

use Auth;
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
        if ($user == $topic->user) {
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            $topic->updateWithInput([
                'title' => $request->input('title'),
                'content' => $markdown,
            ]);
            $topic->retag($request->input('tags'));
            Flash::success('Item updated successfully.');
        } else {
            Flash::error('You don\'t have permission.');
        }
        return redirect()->route('topics.index');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->update(['status' => -1]);
        $topic->delete();
        Flash::success('Item deleted successfully.');
        return redirect()->route('topics.index');
    }
}
