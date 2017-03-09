<?php

namespace App\Http\Controllers;

use Auth;
use Flash;
use Lang;
use Searchy;
use App\Models\Point;
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
        // Get user.
        $user = Auth::user();
        $points= Point::where('user', $user->id)->orderBy('got_at', 'desc')->get();
        return view('sign', compact('points'));
    }

    public function postSign(Request $request)
    {
        // Get user.
        $user = Auth::user();
        $point= Point::where('user', $user->id)->orderBy('got_at', 'desc')->first();
        if ($point) {
            if (Carbon::createFromFormat('Y-m-d H:i:s', $point->got_at)->isToday()) {
                Flash::error('You have already signed at today!');
                return back();
            } else if (Carbon::createFromFormat('Y-m-d H:i:s', $point->got_at)->isYesterday()) {
                $user->signed += 1;
            } else {
                $user->signed = 1;
            }
        } else {
            $user->signed = 1;
        }
        $point= Point::create();
        // Random points.
        $get_point = random_int(1, 10);
        $point->user = $user->id;
        $point->type = 1;
        $point->points = $get_point;
        $point->got_at = Carbon::now();
        $point->save();
        // Update user points
        if ($user->signed % 10 == 0) {
            $user->points += $user->signed;
        }
        $user->points += $get_point;
        $user->save();
        // Show messages.
        Flash::success(Lang::get('global.operation_successfully'));
        return redirect()->route('sign');
    }
}