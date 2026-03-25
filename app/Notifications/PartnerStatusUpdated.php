<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Partner;

class PartnerStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Partner $partner) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Partner Status Updated')
            ->greeting("Hello {$notifiable->name},")
            ->line("The status of your organization '{$this->partner->name}' has been changed to '{$this->partner->status}'.")
            ->line('Thank you for being a part of our platform!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'partner_id' => $this->partner->id,
            'status' => $this->partner->status,
            'message' => "Your organization status was updated to '{$this->partner->status}'."
        ];
    }
}
