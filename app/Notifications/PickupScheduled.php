<?php

namespace App\Notifications;

use App\Models\Pickup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PickupScheduled extends Notification
{
    use Queueable;

    protected User   $volunteer;
    protected Pickup $pickup;

    /**
     * @param  User   $volunteer  L’utilisateur qui a planifié le pickup
     * @param  Pickup $pickup     L’entité Pickup créée
     */
    public function __construct(User $volunteer, Pickup $pickup)
    {
        $this->volunteer = $volunteer;
        $this->pickup    = $pickup;
    }

    /**
     * Détermine les canaux de notification.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pickup Scheduled for Your Donation')
            ->greeting("Hello,")
            ->line("{$this->volunteer->name} has scheduled a pickup for your donation (#{$this->pickup->donation_id}).")
            ->line("Date & Time: {$this->pickup->scheduled_at->format('Y-m-d H:i')}")
            ->line("Notes from receiver: {$this->pickup->notes}")
            ->action('View Donation', url("/donations/{$this->pickup->donation_id}"))
            ->line('Thank you for helping reduce food waste!');
    }


    public function toDatabase(object $notifiable): array
    {
        return [
            'volunteer_id'    => $this->volunteer->id,
            'volunteer_name'  => $this->volunteer->name,
            'donation_id'     => $this->pickup->donation_id,
            'scheduled_at'    => $this->pickup->scheduled_at->toDateTimeString(),
            'notes'           => $this->pickup->notes,
            'message'         => "{$this->volunteer->name} scheduled a pickup for donation #{$this->pickup->donation_id}.",
        ];
    }
}
