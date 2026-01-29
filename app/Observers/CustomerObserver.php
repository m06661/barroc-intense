<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;
use App\Notifications\NewCustomerForFinance;
use App\Notifications\CustomerMissingInfo;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        // 1. Stuur notificatie naar Finance team
        $this->notifyFinanceTeam($customer);

        // 2. Controleer op ontbrekende velden
        $this->checkMissingFields($customer);
    }

    /**
     * Stuur notificatie naar alle Finance medewerkers
     */
    private function notifyFinanceTeam(Customer $customer): void
    {
        $financeUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Finance');
        })->get();

        foreach ($financeUsers as $user) {
            $user->notify(new NewCustomerForFinance($customer));
        }
    }

    /**
     * Controleer verplichte velden en notificeer Sales bij ontbrekende info
     */
    private function checkMissingFields(Customer $customer): void
    {
        $requiredFields = ['email', 'iban', 'contract_type'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (empty($customer->$field)) {
                $missingFields[] = $field;
            }
        }

        // Als velden ontbreken, notificeer het Sales team
        if (!empty($missingFields)) {
            $salesUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'Sales');
            })->get();

            foreach ($salesUsers as $user) {
                $user->notify(new CustomerMissingInfo($customer, $missingFields));
            }
        }
    }
}
