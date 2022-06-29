<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = auth()->user()->followersPosts()->get();

//        dd($posts);

        return view('home', compact('posts'));
    }
}