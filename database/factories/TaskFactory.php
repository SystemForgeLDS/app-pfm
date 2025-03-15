<?php

namespace Database\Factories;

use App\Constants\UserRoles;
use App\Models\Project;
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
        $completed = random_int(0, 1);

        if ($completed) {
            $real_hour = fake()->randomNumber(1);
        }
        else {
            $real_hour = null;
        }

        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->paragraph(10),
            'value' => fake()->randomNumber(3),
            'predicted_hour' => fake()->randomNumber(1),
            'completed' => $completed,
            'real_hour' => $real_hour,
            'user_id' => User::where("type", UserRoles::PARTNER)->pluck('id')->random(),
            'project_id' => Project::pluck('id')->random()
        ];
    }
}
