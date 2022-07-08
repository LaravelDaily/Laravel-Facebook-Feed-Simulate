<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostFileSeeder extends Seeder
{
    public function run()
    {
        file_put_contents(storage_path('app/post.jpg'), file_get_contents('https://picsum.photos/640/640'));

        $posts = Post::inRandomOrder()->take(1000)->get();

        foreach ($posts as $post) {
            $post->addMedia(storage_path('app/post.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('posts');
        }
    }
}
