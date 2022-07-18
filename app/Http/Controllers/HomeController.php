<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maize\Markable\Models\Reaction;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = auth()->user()->followersPosts()
            ->with([
                'media',
                'user' => [
                    'media'
                ],
                'reactions',
                'popularComment' => [
                    'popularReply'
                ]
            ])
            ->whereDate('posts.created_at', '>=', now()->subDays(7))
            ->orderByDesc(
                DB::raw('post_reactions_count + (shared_post_count * 3) + (comments_count * 2) + post_comments_reactions_count + (CASE WHEN media_count > 0 THEN 10 ELSE 0 END)')
            )
            ->take(10)
            ->get();

        return view('home', compact('posts'));
    }
}
