<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NodeRequest;

class NodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$nodes = Node::paginate();
		return view('nodes.index', compact('nodes'));
	}

	public function create(Node $node)
	{
		return view('nodes.create_and_edit', compact('node'));
	}

	public function store(NodeRequest $request)
	{
		Node::createWithInput($request->all());
		return redirect()->route('nodes.index')->with('message', 'Item created successfully.');
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
		$this->authorize('update', $node);
		$node->updateWithInput($request->all());

		return redirect()->route('nodes.index')->with('message', 'Item updated successfully.');
	}

	public function destroy(Node $node)
	{
		$this->authorize('destroy', $node);
		$node->delete();

		return redirect()->route('nodes.index')->with('message', 'Item deleted successfully.');
	}
}