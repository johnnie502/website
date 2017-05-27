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
        $this->middleware('auth', ['only' => ['create', 'edit', 'getUpVote', 'postUpvote', 'getDownVote', 'postDownvote']]);
        $this->middleware('admin', ['only' => 'destory']);
    }

    public function index()
    {
        $topics = Topic::orderBy('replied_at', 'desc')->paginate(20);
        $topic = new Topic();
        return view('topics.index', compact('topics', 'topic'));
    }

    public function create(Topic $topic)
    {
        // Get nodes list.
        $nodes = Node::all()->sortBy('name');
        return view('topics.create_and_edit', compact('nodes'));
    }

    public function store(TopicRequest $request)
    {
         // Get user id.
        $user = Auth::user();
        $topic = new Topic();
        if ($user->can('create',$topic)) {
           // Get user id.
            $user = Auth::user();
           // Convert HTML topic content to markdown.
            if (Agent::isPhone()) {
                // Editor.md
                $markdown = $request->input('content');
            } else {
                // Ueditor
                $converter = new HtmlConverter();
                $markdown = $converter->convert($request->input('content'));
            }
            // Fix the contents.
            $markdown = (new CopyWritingCorrectService())->correct($markdown);
            // Create topic and post.
            $topic = Topic::createWithInput([
                'node' => $request->input('node'),
                'title' => $request->input('title'),
            ]);
            $topic->user = $user->id;
            $topic->node = $request->input('node');
            $topic->type = 1;
            $topic->status = 1;
            $topic->save();
            $post = Post::createWithInput([
                'content' => $markdown,
            ]);
            $post->user = $user->id;
            $post->topic = $topic->id;
            $post->type = 1;
            $post->status = 1;
            $post->save();
            // User statics
            $user->point_count -= 5;
            $user->topic_count += 1;
            $user->save();
            // Update points.
            $point = new Point();
            $point->user = $user->id;
            $point->type = 2;
            $point->point = -5;
            $point->total_points = $user->point_count;
            $point->got_at = Carbon::now();
            $point->save();
            // Add tag.
            $topic->tag($request->input('tags'));
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('topics.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function show(Topic $topic)
    {
         // Get nodes from topic's node id.
         // The view will display node's name and a link to slug.
         $node = Node::findOrFail($topic->node);
         // Get post content.
         $posts = Post::where('topic',  $topic->id)
                ->orderBy('post')
                ->get();
        $post = new Post();
        $comment = new Comment();
        return view('topics.show', compact('node', 'topic', 'posts', 'post', 'comment'));
    }

    public function tags($slug)
    {
        // Display all topic of this slug.
        $topics = Topic::withAllTags($slug)->get();
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
         // Get user id.
        $user = Auth::user();
        if ($user->can('update', $topic)) {
           // Convert HTML topic content to markdown.
            if (Agent::isPhone()) {
                // Editor.md
                $markdown = $request->input('content');
            } else {
                // Ueditor
                $converter = new HtmlConverter();
                $markdown = $converter->convert($request->input('content'));
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
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function destroy(Topic $topic)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('delete', $topic)) {
           // Set status = -1 to delete.
            $topic->status = -1;
            $topic->save();
            // Soft delete.
            $topic->delete();
            // User statics.
            $user->topic_count -= 1;
            $user->save();
            // Get node from topic's node id.
            $node = Node::find($topic->node);
            $node->topics -= 1;
            $node->save();
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('topics.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function getUpvote(User $user, Topic $topic)
    {
    	// Get user id.
        $user = Auth::user();
        if ($user->can('vote', $topic)) {
            if ($user->hasVoted($topic)) {
                $user->cancelVote($topic);
            }
            // Up vote the topic.
            $user->upVote($topic);
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function postDownvote(User $user, Topic $topic)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->can('vote', $topic)) {
            if ($user->hasVoted($topic)) {
                $user->cancelVote($topic);
            }
            // Down vote the topic.
            $user->downVote($topic);
        } else {
            return response(view('errors.403'), 403);
        }
    }
}
