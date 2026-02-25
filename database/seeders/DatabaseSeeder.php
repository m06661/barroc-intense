<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Machine;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === ROLES (eerst aanmaken) ===
        $roles = [
            'Admin',
            'finance',
            'sales',
            'inkoop',
            'maintenance', // <- technicians
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // === ADMIN USER ===
        $admin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('secret'),
            ]
        );
        $admin->assignRole('Admin');

        // === TECHNICIANS (Users met maintenance role) ===
        User::factory()
            ->count(8)
            ->technician()
            ->create()
            ->each(fn (User $u) => $u->assignRole('maintenance'));

        // === OVERIGE USERS (optioneel) ===
        User::factory()
            ->count(10)
            ->create();

        // === CUSTOMERS + ORDERS ===
        $this->call([
            TechnicianSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
        ]);

        Customer::factory()->count(50)->create();
        Order::factory()->count(10)->create();

        Machine::factory()->count(30)->installed()->create();
    }
}
