<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PostComment;
use Illuminate\Database\Seeder;
use Maize\Markable\Models\Reaction;

class CommentReactionSeeder extends Seeder
{
    public function run()
    {
        $posts = PostComment::all('id');
        $users = User::all('id');

        $reactions = config('markable.allowed_values.reaction');

        for ($i = 1; $i < 100000; $i++) {
            Reaction::add($posts->random(), $users->random(), $reactions[array_rand($reactions)]);
        }
    }
}
