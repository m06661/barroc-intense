<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    protected $model = Machine::class;
    public function installed(): static
    {
        return $this->state(fn () => [
            'status' => 'installed',
            'installed_at' => now(),
        ]);
    }

    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->value('id')
                ?? Customer::factory(),

            'serial_number' => strtoupper(
                $this->faker->unique()->bothify('SN-####-????')
            ),

            'type' => $this->faker->randomElement([
                'Espresso Machine',
                'Coffee Grinder',
                'Bean Roaster',
                'Filter Machine',
            ]),

            'location' => $this->faker->optional()->city(),

            'installed_at' => $this->faker->optional()->date(),

            'status' => $this->faker->randomElement([
                'installed',
                'active',
                'maintenance',
                'inactive',
            ]),

        ];
    }
}
