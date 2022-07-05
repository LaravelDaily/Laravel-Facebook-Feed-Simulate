<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\PostComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCommentFactory extends Factory
{
    public function definition(): array
    {
//        $posts = Post::all('id');
//        $users = User::all('id');

        return [
//            'post_id'      => random_int(1, 10000),
            'user_id'      => random_int(1, 1000),
            'comment_text' => $this->faker->paragraphs(rand(1, 5), true),
        ];
    }

    public function configure(): PostCommentFactory
    {
        return $this->afterCreating(function (PostComment $comment) {
            if ($this->faker->boolean(35)) {
                $comments = PostComment::where('id', '!=', $comment->id)->inRandomOrder()->first();

                $comment->update([
                    'parent_comment_id' => $comments->id,
                ]);
            }
        });
    }
}
