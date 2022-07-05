<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $users = User::all('id');

        return [
            'user_id'    => $users->random(),
            'post_text'  => $this->faker->paragraphs(rand(1, 5), true),
            'link_url'   => $this->faker->url(),
            'link_text'  => $this->faker->words(rand(1, 4), true),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now', 'Europe/Vilnius'),
            'updated_at' => now(),
        ];
    }

    public function configure(): PostFactory
    {
        return $this->afterCreating(function (Post $post) {
            if ($this->faker->boolean(20)) {
                $posts = Post::inRandomOrder()->first();

                $post->update([
                    'post_id' => $posts->id,
                ]);
            }
        });
    }
}
