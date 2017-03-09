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
        $user->points += 10;
        $user->wikis += 1;
        $user->save();
        // Add tag.
        $wiki->tag($request->input('categories'));
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.index');
    }

    public function show(Wiki $wiki, $redirect = 0)
    {
        // Get wiki via name.
        $wiki = Wiki::where('name', $wiki->name)->orderBy('version', 'desc')->firstOrFail();
        // Rediect
        if ($redirect > 0) {
        	    $wiki = Wiki::where('name', $wiki->name)
        	    	->where('redirect', $redirect)
        	    	->firstOrFail();
        	    return redirect()->route('wiki.show', $wiki->name);
        	}
        return view('wiki.show', compact('wiki'));
    }

    public function edit(Wiki $wiki)
    {
        return view('wiki.create_and_edit', compact('wiki'));
    }

    public function update(WikiRequest $request, Wiki $wiki)
    {
        $this->authorize('update', $wiki);
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
        // Update tag.
        $wiki->retag($request->input('categories'));
        // Show messages.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.show', $wiki->name);
    }

    public function destroy(Wiki $wiki)
    {
        $this->authorize('destroy', $wiki);
        $wiki = Wiki::where('name', $wiki)->get();
        // Set status = -1 to delete.
        $wiki->status = -1;
        $wiki->save();
        // Soft delete.
        $wiki->delete();
        // User statics.
        $user =  User::find($wiki->user);
        $user->topics -= 1;
        $user->save();
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.index');
    }

    public function history($name)
    {
        // Get wiki via name.
        $wiki = Wiki::where('name', $name)->orderBy('version', 'desc')->get();
        return view('wiki.history', compact('wiki'));
    }

    public function diff(Wiki $wiki, $new, $old)
    {
    	$newContent = Wiki::where('name', $wiki)
    		->where('version', $new)
    		->firstOrFail();
    	$oldContent = Wiki::where('name', $wiki)
    		->where('version', $old)
    		->firstOrFail();
    	$diff = Diff::compare($oldContent, $newContent);
    	return view('wiki.diff', compact('wiki', 'diff'));
    }
}