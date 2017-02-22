<?php

namespace App\Http\Controllers;

use zgldh\UploadManager\UploadManager;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        $file = $request->file('avatar');
        $manager = UploadManager::getInstance();
        $upload = $manager->upload($file);
        $upload->save();
        return $upload;
    }
}
