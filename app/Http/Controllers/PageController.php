<?php

namespace App\Http\Controllers;

use Auth;
use FLash;
use Lang;
use Searchy;
use App\Models\Signed;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'sign', 'postSign']);
    }

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

    public function sign()
    {
        return view('sign');
    }

    public function postSign(Request $request)
    {
        // Get user.
        $user = Auth::user();
        $signed = Signed::where('user', $user->id)->orderBy('time', 'desc')->first();
        if ($signed) {
            if ($signed->time->isToday()) {
                Flash::error('You have already signed at today!');
                return back();
            }
        }
        $signed = Signed::create();
        // Random points.
        $points = random_int(1, 10);
        $signed->user = $user->id;
        $signed->points = $points;
        $signed->time = Carbon::now();
        $signed->continuous += 1;
        $signed->save();
        // Update user points
        if ($signed->continuous % 10 == 0) {
            $user->points += $signed->continuous;
        }
        $user->points += $points;
        $user->save();
        // Show messages.
        Flash::success(Lang::get('global.register_successfully'));
        return redirect()->intended();
    }
}