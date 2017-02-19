<?php

namespace App\Http\Controllers;

use App\Models\Wiki;
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
		$wikis = Wiki::paginate();
		return view('wikis.index', compact('wikis'));
	}

	public function create(Wiki $wiki)
	{
		return view('wikis.create_and_edit', compact('wiki'));
	}

	public function store(WikiRequest $request)
	{
		Wiki::createWithInput($request->all());
		return redirect()->route('wikis.index')->with('message', 'Item created successfully.');
	}

	public function show(Wiki $wiki)
	{
		return view('wikis.show', compact('wiki'));
	}

	public function edit(Wiki $wiki)
	{
		return view('wikis.create_and_edit', compact('wiki'));
	}

	public function update(WikiRequest $request, Wiki $wiki)
	{
		$this->authorize('update', $wiki);
		$wiki->updateWithInput($request->all());

		return redirect()->route('wikis.index')->with('message', 'Item updated successfully.');
	}

	public function destroy(Wiki $wiki)
	{
		$this->authorize('destroy', $wiki);
		$wiki->delete();

		return redirect()->route('wikis.index')->with('message', 'Item deleted successfully.');
	}
}