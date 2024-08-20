<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Question;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload()
    {
        $post = new Question();
        $post->id = 0;
        $post->exists = true;
        $image = $post->addMediaFromRequest('upload')->toMediaCollection('images');
            
            
        return response()->json([
            'url' => $image->getUrl()
        ]);
    }
}
