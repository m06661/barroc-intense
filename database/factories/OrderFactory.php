<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(), // maakt automatisch een klant
            'order_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['quote', 'contract', 'delivery', 'invoice']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'total_amount' => $this->faker->randomFloat(2, 50, 5000), // bedrag tussen 50 en 5000
        ];
    }
}
