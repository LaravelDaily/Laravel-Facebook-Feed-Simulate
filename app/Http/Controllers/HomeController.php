<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = auth()->user()->followersPosts()
            ->with(['media', 'user.media', 'reactions', 'popularComment.popularReply'])
            ->withCount(['reactions', 'comments', 'sharedPost'])
            ->whereDate('posts.created_at', '>=', now()->subDays(7))
            ->get();

//        dd($posts);

        return view('home', compact('posts'));
    }
}
