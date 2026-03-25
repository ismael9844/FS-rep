<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PartnerRequestResponded extends Notification
{
    public $partnerRequest;
    public $status;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Partner  $partnerRequest
     * @param  string  $status
     * @return void
     */
    public function __construct($partnerRequest, $status)
    {
        $this->partnerRequest = $partnerRequest;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Tu peux envoyer des notifications par e-mail et les stocker dans la base de données
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Partner Request Status Updated')
                    ->line('Your partnership request has been ' . $this->status . '.')
                    ->action('View Request', url('/partners/' . $this->partnerRequest->id))
                    ->line('Thank you for your cooperation!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your partnership request has been ' . $this->status . '.',
            'partner_id' => $this->partnerRequest->id,
            'status' => $this->status,
        ];
    }
}