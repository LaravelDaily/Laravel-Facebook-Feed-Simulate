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

        $faker = \Faker\Factory::create();
        $data = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($i = 0; $i < 1000000; $i++) {
            $data[] = [
                'user_id'       => $users->random(),
                'markable_type' => 'App\Models\Post',
                'markable_id'   => $posts->random(),
                'value'         => $reactions[array_rand($reactions)],
            ];
        }

        $chunks = array_chunk($data, 10000);

        foreach ($chunks as $chunk) {
            Reaction::insert($chunk);
        }
    }
}
