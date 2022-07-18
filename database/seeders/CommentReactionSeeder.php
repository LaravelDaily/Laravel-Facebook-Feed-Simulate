<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\PostComment;
use Illuminate\Database\Seeder;

class CommentReactionSeeder extends Seeder
{
    public function run()
    {
        $comments = collect(PostComment::all('id')->modelKeys());
        $users = collect(User::all('id')->modelKeys());

        $data = [];

        $reactions = config('markable.allowed_values.reaction');

        for ($r = 0; $r < 100; $r++) {
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

                Post::where('id', $reaction['markable_id'])->increment('post_comments_reactions_count');
            }

            $data = [];
        }
    }
}
