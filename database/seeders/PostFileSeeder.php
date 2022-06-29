<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostFileSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::inRandomOrder()->take(1000)->get();

        foreach ($posts as $post) {
            $fileUrl = 'https://picsum.photos/640/480';

            $post->addMediaFromUrl($fileUrl)->toMediaCollection('posts');
        }
    }
}
