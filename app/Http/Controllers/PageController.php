<?php

namespace App\Http\Controllers;

use Searchy;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function about()
    {
    	return view('about');
    }

    public function search()
    {
    	// return view('search');
    }

    public function postSearch(SearchRequest $request)
    {
        // Use Searchy.
        $users = Searchy::users('username')->query($query)->get();
        $topics = Searchy::topics('title')->query($query)->get();
        $posts = Searchy::posts('content')->query($query)->get();
        $wikis = Searchy::wikis(['title', 'content'])->query($query)->get();
        // Return search results.
        return view('search', compact('users', 'topics', 'posts', 'wikis'));
    }

    public function searchResult($query)
    {
        
    }
}