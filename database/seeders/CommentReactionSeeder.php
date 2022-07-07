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

        $data = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($i = 0; $i < 100; $i++) {
            for ($i = 0; $i < 10000; $i++) {
                $data[] = [
                    'user_id'       => $users->random(),
                    'markable_type' => 'App\Models\PostComment',
                    'markable_id'   => $comments->random(),
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
