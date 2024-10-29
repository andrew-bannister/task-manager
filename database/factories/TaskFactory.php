<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\Type;
use App\Models\User;
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
            'title' => fake()->text(30),
            'label' => fake()->text(10),
            'description' => fake()->realText(250),
            'user_id' => User::factory(),
            'type_id' => Type::factory(),
            'status_id' => Status::factory(),
        ];
    }
}
