<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    public function run()
    {
        $users = collect(User::all('id')->modelKeys());
        $posts = collect(Post::all('id')->modelKeys());

        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 100000; $i++) {
            if ($i > 80000) {
                $parentComment = random_int(1, 79999);
            }

            $data[] = [
                'post_id'           => $posts->random(),
                'user_id'           => $users->random(),
                'comment_text'      => $faker->paragraphs(rand(1, 5), true),
                'parent_comment_id' => $parentComment ?? null,
                'created_at'        => now(),
            ];
        }

        $chunks = array_chunk($data, 5000);

        foreach ($chunks as $chunk) {
            PostComment::insert($chunk);
        }
    }
}
