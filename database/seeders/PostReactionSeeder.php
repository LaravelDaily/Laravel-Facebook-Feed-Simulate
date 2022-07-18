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

        $counts = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($r=0; $r < 100; $r++) {
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

                if (array_key_exists($reaction['markable_id'], $counts)) {
                    $counts[$reaction['markable_id']]++;
                } else {
                    $counts[$reaction['markable_id']] = 1;
                }
            }

            $data = [];
        }

        foreach ($counts as $key => $count) {
            Post::where('id', $key)->update(['post_reactions_count' => $count]);
        }
    }
}
