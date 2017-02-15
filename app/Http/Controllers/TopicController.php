<?php

namespace App\Http\Controllers;

use Flash;
use Lang;
use App\Models\Topic;
use App\Models\Post;
use App\Models\Node;
use App\Models\User;
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
        // Get nodes list.
        $nodes = Node::fetchAll();
        return view('topics.create_and_edit', compact('topic', 'nodes'));
    }

    public function store(TopicRequest $request)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->point < 2) {
            Flash::error('Your points are not enough');
            return back()->withInput();
        }
        // Convert HTML topic content to markdown.
        $converter = new HtmlConverter();
        $markdown = $converter->convert($request->input('content'));
        // Create topic and post.
        $topic = Topic::createWithInput([
            'node' => $request->input('node'),
            'title' => $request->input('title'),
        ]);
        $topic->user = $user->id;
        $topic->save();
        $post = Post::createWithInput([
            'title' => $request->input('title'),
            'content' => $markdown,
        ]);
        $post->user = $user->id;
        $post->post = 1;
        $post->save();
        // User statics
        $user->point -= 2;
        $user->topics += 1;
        $user->save();
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
        // Get nodes from topic's node id.
        // The view will display node's name and slug.
        $node = Node::find($topic->node);
        return view('topics.create_and_edit', compact('topic'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
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
        // User statics.
        $user =  User::find($topic->user);
        $user->topics -= 1;
        $user->save();
        // Get node from topic's node id.
        $node = Node::find($topic->node);
        $node->topics -= 1;
        $node->save();
        // Show message.
        Flash::success('Item deleted successfully.');
        return redirect()->route('topics.index');
    }
}
