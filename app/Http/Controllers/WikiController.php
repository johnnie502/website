<?php

namespace App\Http\Controllers;

use App\Models\Wiki;
use League\HTMLToMarkdown\HtmlConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WikiRequest;

class WikiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
            'node' => $request->input('node'),
            'title' => $request->input('title'),
            'content' => $markdown,
            'redirect' => $request->input('redirect');
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
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wikis.index');
    }

    public function show(Wiki $wiki)
    {
        // Get wiki via name.
        $wiki = Wiki::where('name', $wiki)->orderBy('version', 'desc')->firstOrFail();
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
            'node' => $request->input('node'),
            'title' => $request->input('title'),
            'content' => $markdown,
            'redirect' => $request->input('redirect');
        ]);
        $wiki->user = $user->id;
        $wiki->type = 1;
        $wiki->status = 1;
        $wiki->version += 1;
        $wiki->save();
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
        // Get node from topic's node id.
        $node = Node::find($wiki->node);
        $node->wikis -= 1;
        $node->save();
        
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('wiki.index');
    }

    public function diff()
    {

    }
}