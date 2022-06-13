<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    function index(){
        $posts = Post::get();
        return view('welcome',compact('posts'));
    }
}
