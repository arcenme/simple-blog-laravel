<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $emails = ['hello@arcen.me', 'john@gmail.com', 'albert@gmail.com'];
        $random = mt_rand(0, 6);

        return [
            'name' => fake()->name(),
            'email' => $random >= 3 ? fake()->safeEmail() : $emails[$random],
            'content' => $this->faker->text(mt_rand(50, 255)),
            'blog_id' => mt_rand(1, 50),
        ];
    }
}
