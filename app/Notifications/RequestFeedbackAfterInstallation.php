<?php

namespace App\Notifications;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RequestFeedbackAfterInstallation extends Notification
{
    use Queueable;

    public function __construct(public Feedback $feedback)
    {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $feedbackUrl = url(route('feedback.create', $this->feedback->id, false));

        $technicianName = $this->feedback->technician?->name ?? 'Onze technicus';
        $machineType = $this->feedback->machine?->type ?? 'uw machine';
        $serialNumber = $this->feedback->machine?->serial_number ?? 'N/A';

        $message = (new MailMessage)
            ->subject('⭐ Uw feedback - Help ons beter te worden!')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Hartelijk dank voor het vertrouwen in onze service!')
            ->line("")
            ->line('Wij hebben zojuist de volgende machine bij u geplaatst:')
            ->line("**Machine:** {$machineType}")
            ->line("**Serienummer:** {$serialNumber}")
            ->line("**Technicus:** {$technicianName}")
            ->line("")
            ->line('Wij zouden graag uw feedback ontvangen. Dit helpt ons om onze service continu te verbeteren.')
            ->action('Geef feedback', $feedbackUrl)
            ->line("")
            ->line('Uw mening is voor ons erg belangrijk!')
            ->line('Dit bericht is automatisch gegenereerd door het systeem.');

        return $message;
    }
}
