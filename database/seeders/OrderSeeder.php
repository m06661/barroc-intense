<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $orders = [
            [
                'customer_id' => 1, // Bert Dekkers
                'order_date' => '2025-01-15',
                'status' => 'quote',
                'priority' => 'medium',
                'total_amount' => 1299.50,
            ],
            [
                'customer_id' => 1,
                'order_date' => '2025-02-03',
                'status' => 'contract',
                'priority' => 'high',
                'total_amount' => 3299.00,
            ],
            [
                'customer_id' => 2, // CoffeeLab Breda
                'order_date' => '2025-01-28',
                'status' => 'delivery',
                'priority' => 'low',
                'total_amount' => 899.00,
            ],
            [
                'customer_id' => 3, // TechCorp BV
                'order_date' => '2025-02-10',
                'status' => 'invoice',
                'priority' => 'medium',
                'total_amount' => 199.99,
            ]
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
