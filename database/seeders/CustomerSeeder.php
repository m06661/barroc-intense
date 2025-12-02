<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name' => 'Bert Dekkers',
                'address' => 'Dorpsstraat 12, Roosendaal',
                'contact_person' => 'Bert Dekkers',
                'email' => 'bert@example.com',
                'phone' => '0612345678',
                'iban' => 'NL91ABNA0417164300',
                'contract_type' => 'contract',
                'status' => 'active',
            ],
            [
                'name' => 'CoffeeLab Breda',
                'address' => 'Stationsstraat 88, Breda',
                'contact_person' => 'Mila Jansen',
                'email' => 'info@coffeelab.test',
                'phone' => '0687654321',
                'iban' => 'NL12RABO0312345678',
                'contract_type' => 'contract',
                'status' => 'active',
            ],
            [
                'name' => 'TechCorp BV',
                'address' => 'Innovatiepark 101, Eindhoven',
                'contact_person' => 'Tom van Vliet',
                'email' => 'support@techcorp.com',
                'phone' => '0622334455',
                'iban' => 'NL55INGB0001234567',
                'contract_type' => 'quote',
                'status' => 'new',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
