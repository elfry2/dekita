<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(48),
            'content' => fake()->realText(),
            'is_completed' => (boolean) rand(0, 1),
            'due_date'
            => date('Y-m-d H:i:s', rand(strtotime('yesterday'), strtotime('+7 days'))),
            'user_id' => 1,
        ];
    }
}
