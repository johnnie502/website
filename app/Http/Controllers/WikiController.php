<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use App\Models\User;
use App\Models\Wiki;
use League\HTMLToMarkdown\HtmlConverter;
use ViKon\Diff\Diff;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\WikiRequest;

class WikiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit']]);
    }

    public function index()
    {
        $wikis = Wiki::paginate(20);
        return view('wiki.index', compact('wikis'));
    }

    public function create(Wiki $wiki)
    {
        return view('wiki.create_and_edit', compact('wiki'));
    }

    public function store(WikiRequest $request)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('create')) {
           // Get user id.
            $user = Auth::user();
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // Create wiki.
            $wiki = Wiki::createWithInput([
                'title' => $request->input('title'),
                'content' => $markdown,
                //'redirect' => $request->input('redirect'),
            ]);
            $wiki->user = $user->id;
            $wiki->type = 1;
            $wiki->status = 1;
            $wiki->version += 1;
            $wiki->save();
            // User statics
            $user->point_count += 10;
            $user->wiki_count += 1;
            $user->save();
            // Update points.
            $point->user = $user->id;
            $point->type = 4;
            $point->point = 10;
            $point->total_points = $user->point_count;
            $point->got_at = Carbon::now();
            $point->save();
            // Add tag.
            $wiki->tag($request->input('categories'));
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('wiki.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function show(Wiki $wiki, $wikis)
    {
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
        
        return view('wiki.show', compact('wiki'));
    }

    public function edit(Wiki $wiki)
    {
        return view('wiki.create_and_edit', compact('wiki'));
    }

    public function update(WikiRequest $request, Wiki $wiki)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('update', $wiki)) {
           // Get user id.
            $user = Auth::user();
            // Convert HTML topic content to markdown.
            $converter = new HtmlConverter();
            $markdown = $converter->convert($request->input('content'));
            // NOT update the wiki! save a new version.
            $wiki = Wiki::createWithInput([
                'title' => $request->input('title'),
                'content' => $markdown,
                'redirect' => $request->input('redirect'),
            ]);
            $wiki->user = $user->id;
            $wiki->type = 1;
            $wiki->status = 1;
            $wiki->version += 1;
            $wiki->save();
            // User statics
            $user->point_count += 5;
            $user->save();
            // Update points.
            $point->user = $user->id;
            $point->type = 5;
            $point->point = 5;
            $point->total_points = $user->point_count;
            $point->got_at = Carbon::now();
            $point->save();
            // Update tag.
            $wiki->retag($request->input('categories'));
            // Show messages.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('wiki.show', $wiki->title);
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function destroy(Wiki $wiki)
    {
         // Get user id.
        $user = Auth::user();
        if ($user->can('delete', $wiki)) {
           $wiki = Wiki::where('title', $wiki->title)->get();
            // Set status = -1 to delete.
            $wiki->status = -1;
            $wiki->save();
            // Soft delete.
            $wiki->delete();
            // User statics.
            $user =  User::find($wiki->user);
            $user->topic_count -= 1;
            $user->save();
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('wiki.index');
        } else {
            return response(view('errors.403'), 403);
        }
    }

    public function Category($slug)
    {
        // Get category.
        // Display all topic of this slug.
        $wikis = Wiki::withAllTags($slug)->get();
        return view('wiki.categories', compact('wikis'));
    }

    public function history($title)
    {
        // Get wiki via title.
        $wiki = Wiki::where('title', $title)->orderBy('version', 'desc')->get();
        return view('wiki.history', compact('wiki'));
    }

    public function diff(Wiki $wiki, $new, $old)
    {
    	$newContent = Wiki::where('title', $wiki->first()->title)
    		->where('version', $new)
    		->firstOrFail();
    	$oldContent = Wiki::where('title', $wiki->first()->title)
    		->where('version', $old)
    		->firstOrFail();
    	$diff = Diff::compare($oldContent, $newContent);
    	return view('wiki.diff', compact('wiki', 'diff'));
    }
}