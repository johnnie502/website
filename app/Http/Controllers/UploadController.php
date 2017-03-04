<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadAvatar(Request $request)
    {
    	// Update avatar.
         $path = $request->file('avatar')->storeAs('avatars/', $request->user()->id, 'public');
         return $path;
    }
}
