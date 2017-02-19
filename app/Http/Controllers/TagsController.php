<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function show($slug)
    {
    	// Display all topic of this slug.
    	$topics = Topic::withAllTags($slug);
    	return view('tags.show', compact('topics'));
    }
}
