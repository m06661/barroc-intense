<?php

namespace App\Observers;

use App\Models\Machine;
use App\Models\Feedback;
use App\Notifications\RequestFeedbackAfterInstallation;

class MachineObserver
{
    /**
     * Handle the Machine "updated" event.
     * Trigger feedback request wanneer machine status op 'installed' gezet wordt
     */
    public function updated(Machine $machine): void
    {
        // Check of status gewijzigd is naar 'installed'
        if ($machine->isDirty('status') && $machine->status === 'installed') {
            $this->requestFeedback($machine);
        }
    }

    /**
     * Stuur feedback request naar klant
     */
    private function requestFeedback(Machine $machine): void
    {
        // Get customer
        $customer = $machine->customer;
        if (!$customer || !$customer->email) {
            return;
        }

        // Zorg dat we maar 1 feedback request per machine sturen
        $existingFeedback = Feedback::where('machine_id', $machine->id)
            ->where('customer_id', $customer->id)
            ->first();

        if ($existingFeedback) {
            // Feedback already requested or exists
            return;
        }

        // Maak feedback record aan
        $feedback = Feedback::create([
            'customer_id' => $customer->id,
            'machine_id' => $machine->id,
            'technician_id' => null, // Kan je later vullen vanuit maintenance
            'feedback_requested_at' => now(),
        ]);

        // Stuur notificatie
        $customer->notify(new RequestFeedbackAfterInstallation($feedback));
    }
}
