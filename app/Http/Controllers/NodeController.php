<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Http\response;
use App\Http\Controllers\Controller;
use App\Http\Requests\NodeRequest;

class NodeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('admin', [
            'except' => [
                'index', 'show'
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
        if (Auth::check()) $this->authorize('view', $this->user, $node);
        $nodes = Node::paginate(20);
        return view('nodes.index', compact('nodes'));
    }

    public function create(Node $node)
    {
        if (Auth::check()) $this->authorize('create', $this->user, $node);
        return view('nodes.create_and_edit', compact('node'));
    }

    public function store(NodeRequest $request)
    {
        if (Auth::check()) $this->authorize('create', $this->user, Node::class);
        // Create node.
        Node::createWithInput([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'type' => $request['type'],
            'parent' => $request['parent'],
            'description' => $request['description'],
        ]);
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('nodes.index');
    }

    public function show(Node $node)
    {
        if (Auth::check()) $this->authorize('view', $this->user, $node);
        return view('nodes.show', compact('node'));
    }

    public function edit(Node $node)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $node);
        return view('nodes.create_and_edit', compact('node'));
    }

    public function update(NodeRequest $request, Node $node)
    {
        if (Auth::check()) $this->authorize('update', $this->user, $node);
        // Update node.
        $node->updateWithInput([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'description' => $request['description'],
        ]);
        // Show messgae.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('nodes.index');
    }

    public function destroy(Node $node)
    {
        if (Auth::check()) $this->authorize('delete', $this->user, $node);
        // Set status = -1 is deleted.
        $node->status = -1;
        $node->save();
        // Soft delete.
        $node->delete();
        // Show message.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('nodes.index');
    }
}
