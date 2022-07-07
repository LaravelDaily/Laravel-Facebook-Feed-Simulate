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
        $posts = collect(Post::all('id')->modelKeys());
        $users = collect(User::all('id')->modelKeys());

        $data = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($i=0; $i < 100; $i++) {
            for ($i = 0; $i < 10000; $i++) {
                $data[] = [
                    'user_id'       => $users->random(),
                    'markable_type' => 'App\Models\Post',
                    'markable_id'   => $posts->random(),
                    'value'         => $reactions[array_rand($reactions)],
                ];
            }

            foreach ($data as $reaction) {
                Reaction::insert($reaction);
            }

            $data = [];
        }
    }
}
