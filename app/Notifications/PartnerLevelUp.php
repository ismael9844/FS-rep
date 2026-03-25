<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Partner;

class PartnerLevelUp extends Notification
{
    use Queueable;

    protected int $level;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 You’ve Leveled Up!')
            ->greeting("Congratulations {$notifiable->name},")
            ->line("You’ve reached Level {$this->level}, thanks to your incredible support through donations.")
            ->line('Thank you for being a valuable partner in our mission!')
            ->action('View Your Dashboard', url('/dashboard'))
            ->line('Keep going — every donation counts!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "You’ve reached {$this->level}! Thank you for your generosity.",
            'level'   => $this->level,
        ];
    }
}
