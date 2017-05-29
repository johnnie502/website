<?php

namespace App\Http\Controllers;

use Agent;
use Auth;
use Flash;
use Lang;
use App\Mail\AtYou;
use App\Mail\ReplyTopic;
use App\Models\Topic;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Node;
use App\Models\User;
use App\Models\Point;
use Carbon\Carbon;
use League\HTMLToMarkdown\HtmlConverter;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'create', 'edit', 'getUpVote', 'postUpvote', 'getDownVote', 'postDownvote'
            ],
        ]);
        $this->middleware('admin', ['only' => 'destory']);
        if (Auth::check()) {
            // Get user id.
            $this->user = Auth::user();
        }
    }

    public function index()
    {
        if (Auth::check()) {
            $this->authorize('view', $this->user, Topic::class);
        }
        $topics = Topic::orderBy('replied_at', 'desc')->paginate(20);
        return view('topics.index', compact('topics'));
    }

    public function create(Topic $topic)
    {
        $this->authorize('create', $this->user, $topic);
        // Get nodes list.
        $nodes = Node::all()->sortBy('name');
        return view('topics.create_and_edit', compact('nodes'));
    }

    public function store(TopicRequest $request)
    {
        $this->authorize('create', $this->user, Topic::class);
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
        // Create topic and post.
        $topic = Topic::createWithInput([
            'node' => $request->input('node'),
            'title' => $request->input('title'),
        ]);
        $topic->user = $this->user->id;
        $topic->node = $request->input('node');
        $topic->type = 1;
        $topic->status = 1;
        $topic->save();
        $post = Post::createWithInput([
            'content' => $markdown,
        ]);
        $post->user = $this->user->id;
        $post->topic = $topic->id;
        $post->type = 1;
        $post->status = 1;
        $post->save();
        // User statics
        $this->user->point_count -= 5;
        $this->user->topic_count += 1;
        $this->user->save();
        // Update points.
        $point = Point::class;
        $point->user = $this->user->id;
        $point->type = 2;
        $point->point = -5;
        $point->total_points = $this->user->point_count;
        $point->got_at = Carbon::now();
        $point->save();
        // Add tag.
        $topic->tag($request->input('tags'));
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.index');
    }

    public function show(Topic $topic)
    {
        if (Auth::check()) {
            $this->authorize('view', $this->user, $topic);
        }
        // Get nodes from topic's node id.
        // The view will display node's name and a link to slug.
        $node = Node::findOrFail($topic->node);
        // Get post content.
        $posts = Post::where('topic',  $topic->id)
                ->orderBy('post')
                ->get();
        return view('topics.show', compact('node', 'topic', 'posts'));
    }

    public function tags($slug)
    {
        if (Auth::check()) {
            $this->authorize('view', $this->user, Topic::class);
        }
        // Display all topic of this slug.
        $topics = Topic::withAllTags($slug)->get();
        return view('topics.tags', compact('topics'));
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $this->user, $topic);
        // Get nodes from topic's node id.
        // The view will display node's name and a link to slug.
        $node = Node::findOrFail($topic->node);
        // Get post content.
        $post = Post::where('topic',  $topic->id)->first();
        return view('topics.create_and_edit', compact('node', 'topic', 'post'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $this->user, $topic);
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
        // Update topic.
        $topic->updateWithInput([
            'title' => $request->input('title'),
        ]);
        // Update post.
        $post = $topic->posts->first();
        $post->update([
            'content' => $markdown,
        ]);
        // Update tags.
        $topic->retag($request->input('tags'));
        // Show messgae.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.show', $topic->id);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('delete', $this->user, $topic);
        // Set status = -1 to delete.
        $topic->status = -1;
        $topic->save();
        // Soft delete.
        $topic->delete();
        // User statics.
        $this->user->topic_count -= 1;
        $this->user->save();
        // Get node from topic's node id.
        $node = Node::find($topic->node);
        $node->topics -= 1;
        $node->save();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('topics.index');
    }

    public function postUpvote(Topic $topic)
    {
        $this->authorize('vote', $this->user, $topic);
        if ($this->user->hasVoted($topic)) {
            $this->user->cancelVote($topic);
        }
        // Down vote the topic.
        $this->user->downVote($topic);
    }

    public function postDownvote(Topic $topic)
    {
        $this->authorize('vote', $this->user, $topic);
        if ($this->user->hasVoted($topic)) {
            $this->user->cancelVote($topic);
        }
        // Down vote the topic.
        $this->user->downVote($topic);
    }
}
