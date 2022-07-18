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
        $counts = [];

        for ($r=0; $r < 10; $r++) {
            for ($i = 0; $i < 10000; $i++) {
                /*if ($r = 9) {
                    $parentComment = random_int(1, 69999);
                }*/

                $data[] = [
                    'post_id'           => $posts->random(),
                    'user_id'           => $users->random(),
                    'comment_text'      => $faker->paragraphs(rand(1, 5), true),
                    'parent_comment_id' => null,
                    'created_at'        => now(),
                ];
            }

            foreach ($data as $value) {
                PostComment::insert($value);

                if (array_key_exists($value['post_id'], $counts)) {
                    $counts[$value['post_id']]++;
                } else {
                    $counts[$value['post_id']] = 1;
                }
            }

            $data = [];
        }

        foreach ($counts as $key => $count) {
            Post::where('id', $key)->update(['comments_count' => $count]);
        }
    }
}
