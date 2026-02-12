<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technician>
 */
class TechnicianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'region' => fake()->randomElement([
                'Noord', 'Zuid', 'Oost', 'West', 'Centraal',
            ]),
        ];
    }
}
