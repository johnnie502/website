<?php

namespace App\Http\Controllers;

use Agent;
use Auth;
use Flash;
use Lang;
use Markdown;
use App\Mail\AtYou;
use App\Mail\ReplyTopic;
use App\Models\User;
use App\Models\Wiki;
use League\HTMLToMarkdown\HtmlConverter;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;
use PHPHtmlParser\Dom;
use ViKon\Diff\Diff;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\WikiRequest;

class WikiController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'create', 'edit'
            ],
        ]);
        // Get user id while the user has logged.
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (Auth::check()) $this->authorize('view', $this->user, Wiki::class);
        $wikis = Wiki::paginate(20);
        return view('wiki.index', compact('wikis'));
    }

    public function create(Wiki $wiki)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $wiki);
        return view('wiki.create_and_edit', compact('wiki'));
    }

    public function store(WikiRequest $request)
    {
        if (Auth::check()) $this->authorize('create', $this->user, Wiki::class);
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
        // Create wiki.
        $wiki = Wiki::createWithInput([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $markdown,
            'redirect' => $request->input('redirect'),
            'template' => $request->input('template'),
        ]);
        $wiki->user = $this->user->id;
        $wiki->type = 1;
        $wiki->status = 1;
        $wiki->version += 1;
        $wiki->save();
        // User statics
        $this->user->point_count += 10;
        $this->user->wiki_count += 1;
        $this->user->save();
        // Update points.
        $point->user = $this->user->id;
        $point->type = 4;
        $point->point = 10;
        $point->total_points = $this->user->point_count;
        $point->got_at = Carbon::now();
        $point->save();
        // Add tag.
        $wiki->tag($request->input('categories'));
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.index');
    }

    public function show(Wiki $wiki, $wikis)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $wiki);
        // Get wiki via title.
        $wiki = Wiki::where('title', $wikis)->orderBy('version', 'desc')->firstOrFail();
        // Rediect
        if ($wiki->redirect > 0) {
        	    $wiki = Wiki::where('title', $wikis)
        	    	->where('redirect', $redirect)
        	    	->firstOrFail();
        	    return redirect()->route('wiki.show', $wikis);
        	}
        // Table of Contents.
        // Get dom from wiki contents.
        $toc = '';
        $dom = new Dom;
        $dom->loadStr(Markdown::parse($wiki->content), []);
        $html = $dom->outerHtml;
        // The toc being generated.
        $tree = [
            'h1' => $dom->find('h1')->text(),
            'h2' => $dom->find('h2')->text(),
            'h3' => $dom->find('h3')->text(),
            'h4' => $dom->find('h4')->text(),
            'h5' => $dom->find('h5')->text(),
            'h6' => $dom->find('h6')->text(),
        ];
        $wiki->toc = $toc;
        return view('wiki.show', compact('wiki'));
    }

    public function edit(Wiki $wiki)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $wiki);
        return view('wiki.create_and_edit', compact('wiki'));
    }

    public function update(WikiRequest $request, Wiki $wiki)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $wiki);
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
        // NOT update the wiki! save a new version.
        $wiki = Wiki::createWithInput([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $markdown,
            'redirect' => $request->input('redirect'),
            'template' => $request->input('template'),
        ]);
        $wiki->user = $this->user->id;
        $wiki->type = 1;
        $wiki->status = 1;
        $wiki->version += 1;
        $wiki->save();
        // User statics
        $this->user->point_count += 5;
        $this->user->save();
        // Update points.
        $point->user = $this->user->id;
        $point->type = 5;
        $point->point = 5;
        $point->total_points = $this->user->point_count;
        $point->got_at = Carbon::now();
        $point->save();
        // Update tag.
        $wiki->retag($request->input('categories'));
        // Show messages.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.show', $wiki->title);
    }

    public function destroy(Wiki $wiki)
    {
        if (Auth::check()) $this->authorize('delete', $this->user, $wiki);
        // Get user id.
        $this->user = Auth::user();
        $wiki = Wiki::where('title', $wiki->title)->get();
        // Set status = -1 to delete.
        $wiki->status = -1;
        $wiki->save();
        // Soft delete.
        $wiki->delete();
        // User statics.
        $this->user =  User::find($wiki->user);
        $this->user->topic_count -= 1;
        $this->user->save();
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.index');
    }

    public function Category($slug)
    {
        if (Auth::check()) $this->authorize('view', $this->user, Wiki::class);
        // Get category.
        // Display all topic of this slug.
        $wikis = Wiki::withAllTags($slug)->get();
        return view('wiki.categories', compact('wikis'));
    }

    public function history($wiki)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $wiki);
        // Get wiki via title.
        $wiki = Wiki::where('title', $wiki->title)->orderBy('version', 'desc')->get();
        return view('wiki.history', compact('wiki'));
    }

    public function diff(Wiki $wiki, $new, $old)
    {
    	if (Auth::check()) $this->authorize('view', $this->user, $wiki);
        $newContent = Wiki::where('title', $wiki->first()->title)
    		->where('version', $new)
    		->firstOrFail();
    	$oldContent = Wiki::where('title', $wiki->first()->title)
    		->where('version', $old)
    		->firstOrFail();
    	$diff = Diff::compare($oldContent, $newContent);
    	return view('wiki.diff', compact('wiki', 'diff'));
    }

    public function postStar(Wiki $wiki, $star)
    {
        if (Auth::check()) $this->authorize('vote', $this->user, $wiki);
        // Create/Update a wiki rating.
        $rating = [1, 2, 3, 4, 5];
        if (in_array($rating, $star)) {
            $wiki->rating([
                'rating' => $star
            ], $this->user);
        }
    }
    
    public function postUnstar(Wiki $wiki)
    {
        if (Auth::check()) $this->authorize('vote', $this->user, $wiki);
        $wiki->deleteRating($this->user->id);
    }
}