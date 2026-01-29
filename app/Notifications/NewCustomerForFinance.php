<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewCustomerForFinance extends Notification
{
    use Queueable;

    public function __construct(public Customer $customer) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎯 Nieuwe klant wacht op verwerking')
            ->greeting('Hallo ' . $notifiable->name)
            ->line("Een nieuwe klant is zojuist ingevoerd in het systeem:")
            ->line("**Klantnaam:** {$this->customer->name}")
            ->line("**Email:** {$this->customer->email}")
            ->line("**Telefoonnummer:** {$this->customer->phone}")
            ->line("")
            ->line("Controleer alstublieft of alle gegevens compleet zijn voordat je verdergaat met facturatie.")
            ->action('Bekijk klantgegevens', route('customers.show', $this->customer))
            ->line("Dit bericht is automatisch gegenereerd door het systeem.");
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nieuwe klant: ' . $this->customer->name,
            'message' => "Klant {$this->customer->name} is zojuist door Sales ingevoerd.",
            'customer_id' => $this->customer->id,
            'type' => 'customer_created',
        ];
    }
}
