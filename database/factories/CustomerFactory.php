<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'contact_person' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'iban' => $this->faker->iban(),    // Generates a random IBAN
            'contract_type' => $this->faker->randomElement(['Monthly', 'Annual', 'Pay-as-you-go']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
        ];
    }
}
