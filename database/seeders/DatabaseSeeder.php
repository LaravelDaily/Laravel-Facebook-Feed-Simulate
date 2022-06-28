<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UserFallowsSeeder::class,
            PostSeeder::class,
            PostCommentSeeder::class,
            PostReactionSeeder::class,
            CommentReactionSeeder::class,
            PostFileSeeder::class,
        ]);
    }
}
