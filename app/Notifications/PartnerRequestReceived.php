<?php
namespace App\Notifications;

use App\Models\PartnerRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PartnerRequestReceived extends Notification
{
    use Queueable;

    protected $partnerRequest;

    public function __construct(PartnerRequest $partnerRequest)
    {
        $this->partnerRequest = $partnerRequest;
    }

    /**
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Choisir les canaux de notification (mail et base de données)
    }

    /**
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Partner Request')
            ->greeting('Hello!')
            ->line('You have received a new partner request.')
            ->action('View Request', url('/partner-requests/'.$this->partnerRequest->id))
            ->line('Thank you for using our application!');
    }

    /**
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'You have received a new partner request from ' . $this->partnerRequest->user->name,
            'request_id' => $this->partnerRequest->id,
        ];
    }
}
