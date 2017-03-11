<?php

namespace App\Http\Controllers;

use Flash;
use Lang;
use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NodeRequest;

class NodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $nodes = Node::paginate(20);
        return view('nodes.index', compact('nodes'));
    }

    public function create(Node $node)
    {
        return view('nodes.create_and_edit', compact('node'));
    }

    public function store(NodeRequest $request)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->can('create')) {
             // Create node.
            Node::createWithInput($request->all());
            // Show message.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('nodes.index');
        }
    }

    public function show(Node $node)
    {
        return view('nodes.show', compact('node'));
    }

    public function edit(Node $node)
    {
        return view('nodes.create_and_edit', compact('node'));
    }

    public function update(NodeRequest $request, Node $node)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->can('update', $node)) {
             // Update node.
            $node->updateWithInput($request->all());
            // Show messgae.
            Flash::success(Lang::get('global.operation_successfully'));
            return redirect()->route('nodes.index');
        }
    }

    public function destroy(Node $node)
    {
        // Get user id.
        $user = Auth::user();
        if ($user->can('destroy', $node)) {
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
}
