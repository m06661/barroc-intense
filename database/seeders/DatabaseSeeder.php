<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Customer;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === USERS (FACTORIES) ===
        User::factory(2)->create();

        // === CUSTOMERS + ORDERS (JOUW NIEUWE SEEDERS) ===
        $this->call([
            CustomerSeeder::class,
            OrderSeeder::class,
        ]);
        Customer::factory()->count(50)->create();

        // === ADMIN USER ===
        $Admin = User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);

        // === ROLES ===
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'finance']);
        Role::create(['name' => 'sales']);
        Role::create(['name' => 'inkoop']);
        Role::create(['name' => 'maintenance']);

        $Admin->assignRole('Admin');
    }
}
