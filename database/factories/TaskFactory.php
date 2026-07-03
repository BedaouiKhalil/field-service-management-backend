<?php

namespace Database\Factories;

use App\Constants\Roles;
use App\Enums\TaskStatus;
use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $status = $this->faker->randomElement(TaskStatus::values());

        $startedAt = $this->faker->optional()->dateTimeBetween('-1 month', 'now');

        $completedAt = null;

        if ($status === TaskStatus::COMPLETED->value && $startedAt) {
            $completedAt = $this->faker->dateTimeBetween($startedAt, 'now');
        }

        $techinician = User::role(Roles::TECHNICIAN)->inRandomOrder()->first();

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'customer_id' => Customer::factory(),
            'technician_id' => $techinician?->id ?? User::factory(),
            'status' => $status,
            'completed_at' => $completedAt,
            'created_by' => User::inRandomOrder()->first()?->id,
            'updated_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
