<?php

namespace Database\Seeders;

use App\Models\PostComment;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    public function run()
    {
        PostComment::factory(100000)->create();
    }
}
