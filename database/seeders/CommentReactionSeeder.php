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
        $comments = collect(PostComment::all('id')->modelKeys());
        $users = collect(User::all('id')->modelKeys());

        $faker = \Faker\Factory::create();
        $data = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($i = 0; $i < 1000000; $i++) {
            $data[] = [
                'user_id'       => $users->random(),
                'markable_type' => 'App\Models\PostComment',
                'markable_id'   => $comments->random(),
                'value'         => $reactions[array_rand($reactions)],
            ];
        }

        $chunks = array_chunk($data, 10000);

        foreach ($chunks as $chunk) {
            Reaction::insert($chunk);
        }
    }
}
