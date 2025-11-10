<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
/**
  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
  */
class TaskFactory extends Factory
{
  protected $model = Task::class;
  /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */
  public function definition(): array
  {
    return [
      "title" => $this->faker->sentence(6),
      "description" => $this->faker->sentence(),
      "status" => $this->faker->randomElement(['todo', 'in_progress', 'done']),
      "priority" => $this->faker->randomElement(['low', 'medium', 'high']),
      "due_date" => $this->faker->date(),
      "created_at" => $this->faker->dateTime(),
      "updated_at" => $this->faker->dateTime(),
    ];
  }
}
