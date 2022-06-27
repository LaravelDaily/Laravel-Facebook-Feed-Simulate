<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $users = collect(User::all('id')->modelKeys());

        return [
            'user_id'    => $users->random(),
            'post_text'  => $this->faker->paragraphs(rand(1, 5), true),
            'link_url'   => $this->faker->url(),
            'link_text'  => $this->faker->words(rand(1, 4), true),
//            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure(): PostFactory
    {
        return $this->afterCreating(function (Post $post) {
            if ($this->faker->boolean(20)) {
                $posts = collect(Post::all('id')->modelKeys());

                $post->update([
                    'post_id' => $posts->random(),
                ]);
            }
        });
    }
}
