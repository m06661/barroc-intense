<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        Customer::factory()->count(50)->create();

        $Admin = User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);


        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'finance']);
        Role::create(['name' => 'sales']);
        Role::create(['name' => 'inkoop']);
        Role::create(['name' => 'maintenance']);


        $Admin->assignRole('Admin');
    }
}
