<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = mt_rand(1, 3);
        return [
            'title' => $this->faker->text(mt_rand(50, 100)),
            'slug' => $this->faker->slug(7),
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(mt_rand(5, 10))) . '</p>',
            'thumbnail' => $this->faker->image(null, 640, 480),
            'created_by' => $user,
            'updated_by' => $user,
        ];
    }
}
