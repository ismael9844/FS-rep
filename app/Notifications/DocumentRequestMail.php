<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentRequestMail extends Notification
{
    use Queueable;

    protected $model;
    protected $token;
    protected $note;

    public function __construct($model, $token, $note = null)
    {
        $this->model = $model;
        $this->token = $token;
        $this->note = $note;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = url("/documents/upload?token={$this->token}");

        $mail = (new MailMessage)
            ->subject('Please upload requested documents')
            ->greeting("Hello {$notifiable->name},")
            ->line('An admin requested additional documents from you.');

        if ($this->note) {
            $mail->line("Note: {$this->note}");
        }

        $mail->action('Upload documents', $url)
             ->line('This link expires in 7 days and can be used once.');

        return $mail;
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Document request sent',
            'token' => $this->token,
        ];
    }
}
