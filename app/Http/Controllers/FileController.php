<?php

namespace App\Http\Controllers;

use Flash;
use Lang;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $files = File::paginate(20);
        return view('files.index', compact('files'));
    }

    public function create(File $file)
    {
        return view('files.create_and_edit', compact('file'));
    }

    public function store(FileRequest $request)
    {
        // Create file.
        File::createWithInput($request->all());
        // Show message.
        Flash::success('Item created successfully.');
        return redirect()->route('files.index');
    }

    public function show(File $file)
    {
        return view('files.show', compact('file'));
    }

    public function edit(File $file)
    {
        return view('files.create_and_edit', compact('file'));
    }

    public function update(FileRequest $request, File $file)
    {
        $this->authorize('update', $file);
        // Update file.
        $file->updateWithInput($request->all());
        // Show message.
        Flash::success('Item updated successfully.');
        return redirect()->route('files.index');
    }

    public function destroy(File $file)
    {
        $this->authorize('destroy', $file);
        // Set status = -1 to delete.
        $file->status = 1;
        $file->save();
        // Soft delete.
        $file->delete();
        // Show message.
        Flash::success('Item created successfully.');
        return redirect()->route('files.index');
    }
}
