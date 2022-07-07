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
            Storage::makeDirectory('public/' . $post->id);

            Storage::copy('post.jpg', 'public/' . $post->id . '/640.jpeg');

            Media::create([
                'model_type'            => 'App\Models\Post',
                'model_id'              => $post->id,
                'collection_name'       => 'posts',
                'uuid'                  => Str::uuid(),
                'name'                  => '640',
                'file_name'             => '640.jpeg',
                'mime_type'             => 'image/jpeg',
                'disk'                  => 'public',
                'conversions_disk'      => 'public',
                'size'                  => Storage::size('public/' . $post->id . '/640.jpeg'),
                'manipulations'         => '[]',
                'custom_properties'     => '[]',
                'responsive_images'     => '[]',
                'order_column'          => 1,
                'generated_conversions' => ['posts' => true],
            ]);
        }
    }
}
