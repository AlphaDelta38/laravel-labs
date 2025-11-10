<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            "body" => $this->faker->sentence(),
            "created_at" => $this->faker->dateTime(),
            "updated_at" => $this->faker->dateTime(),
        ];
    }
}
