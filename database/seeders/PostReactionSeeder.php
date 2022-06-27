<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Maize\Markable\Models\Reaction;

class PostReactionSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all('id');
        $users = User::all('id');

        $reactions = config('markable.allowed_values.reaction');

        for ($i = 1; $i < 100000; $i++) {
            Reaction::add($posts->random(), $users->random(), $reactions[array_rand($reactions)]);
        }
    }
}
