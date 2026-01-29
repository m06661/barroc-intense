<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerMissingInfo extends Notification
{
    use Queueable;

    public function __construct(
        public Customer $customer,
        public array $missingFields
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $fieldLabels = [
            'email' => 'E-mailadres',
            'iban' => 'IBAN',
            'contract_type' => 'Contracttype',
        ];

        $missingLabels = array_map(
            fn($field) => $fieldLabels[$field] ?? $field,
            $this->missingFields
        );

        return (new MailMessage)
            ->subject('⚠️ Klantgegevens zijn onvolledig')
            ->greeting('Hallo ' . $notifiable->name)
            ->line("De klant **{$this->customer->name}** mist verplichte informatie:")
            ->line("")
            ->line("**Ontbrekende velden:**")
            ->line(implode(', ', $missingLabels))
            ->line("")
            ->line("Vul deze gegevens alstublieft in voordat Finance het kan verwerken.")
            ->action('Bewerk klantgegevens', route('customers.edit', $this->customer))
            ->line("Dit bericht is automatisch gegenereerd door het systeem.");
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Ontbrekende gegevens: ' . $this->customer->name,
            'message' => "Klant mist velden: " . implode(', ', $this->missingFields),
            'customer_id' => $this->customer->id,
            'type' => 'customer_incomplete',
            'missing_fields' => $this->missingFields,
        ];
    }
}
