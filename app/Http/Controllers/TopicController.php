<?php

namespace App\Http\Controllers;

use Auth;
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
        $nodes = Node::all();
        return view('topics.create_and_edit', compact('nodes', 'topic'));
    }

    public function store(TopicRequest $request)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->points < 2) {
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
            'content' => $markdown,
        ]);
        $post->user = $user->id;
        $post->topic = $topic->id;
        $post->save();
        // User statics
        $user->points -= 2;
        $user->topics += 1;
        $user->save();
        // Add tag.
        $topic->tag($request->input('tags'));
        // Show message.
        Flash::success('Item created successfully.');
        return redirect()->route('topics.index');
    }

    public function show(Topic $topic)
    {
         // Get nodes from topic's node id.
         // The view will display node's name and a link to slug.
         $node = Node::findOrFail($topic->node);
         // Get post content.
         $post = Post::where('topic',  $topic->id)->first();
        return view('topics.show', compact('node', 'topic', 'post'));
    }

    public function tags($slug)
    {
        // Display all topic of this slug.
        $topics = Topic::withAllTags($slug);
        return view('topics.tags', compact('topics'));
    }

    public function edit(Topic $topic)
    {
        // Get nodes from topic's node id.
        // The view will display node's name and a link to slug.
        $node = Node::findOrFail($topic->node);
        // Get post content.
        $post = Post::where('topic',  $topic->id)->first();
        return view('topics.create_and_edit', compact('node', 'topic', 'post'));
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
        // Update post.
        $post = Post::where('topic', $topic->id)->first();
        $post->updateWithInput([
            'content' => $markdown,
        ]);
        // Update tags.
        $topic->retag($request->input('tags'));
        // Show messgae.
        Flash::success('Item updated successfully.');
        return redirect()->route('topics.show', $topic->id);
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
