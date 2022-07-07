<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserSeeder extends Seeder
{
    public function run()
    {
        file_put_contents(storage_path('app/avatar.jpg'), file_get_contents('https://picsum.photos/50/50'));

        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'name'              => $faker->name(),
                'email'             => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'verified_at'       => $faker->boolean(35) ? now() : null,
            ];
        }

        $chunks = array_chunk($data, 100);

        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }

        User::chunkById(100, function ($users) {
            $users->each(function ($user) {
                Storage::makeDirectory('public/' . $user->id);

                Storage::copy('avatar.jpg', 'public/' . $user->id . '/50.jpeg');

                Media::create([
                    'model_type'            => 'App\Models\User',
                    'model_id'              => $user->id,
                    'collection_name'       => 'avatar',
                    'uuid'                  => Str::uuid(),
                    'name'                  => '50',
                    'file_name'             => '50.jpeg',
                    'mime_type'             => 'image/jpeg',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => Storage::size('public/' . $user->id . '/50.jpeg'),
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 1,
                    'generated_conversions' => ['avatar' => true],
                ]);
            });
        });
    }
}
