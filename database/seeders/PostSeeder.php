<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $users = User::all('id')->pluck('id');

        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 10000; $i++) {
            $data[] = [
                'user_id'    => $users->random(),
                'post_text'  => $faker->paragraphs(rand(1, 5), true),
                'link_url'   => $faker->boolean() ? $faker->url() : null,
                'link_text'  => $faker->words(rand(1, 4), true),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now', 'Europe/Vilnius'),
            ];
        }

        $chunks = array_chunk($data, 100);

        foreach ($chunks as $chunk) {
            Post::insert($chunk);
        }

        Post::chunk(200, function ($posts) use ($faker) {
            foreach ($posts as $post) {
                if ($faker->boolean(20)) {
                    $posts = Post::where('id', '!=', $post->id)->inRandomOrder()->first();

                    $post->update([
                        'post_id' => $posts->id,
                    ]);
                }
            }
        });
    }
}
