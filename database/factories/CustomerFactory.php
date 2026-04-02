<?php

namespace Database\Factories;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commune = Commune::inRandomOrder()->first();

        return [
            'name'         => $this->faker->company,
            'contact_name' => $this->faker->name,
            'phone'        => $this->faker->unique()->regexify('0[567][0-9]{8}'),
            'email'        => $this->faker->unique()->safeEmail,
            'nif'          => $this->faker->numerify('###############'),
            'wilaya_id'    => $commune?->wilaya_id,
            'commune_id'   => $commune?->id,
            'address'      => $this->faker->streetAddress,
            'created_by'   => 1,
        ];
    }
}
