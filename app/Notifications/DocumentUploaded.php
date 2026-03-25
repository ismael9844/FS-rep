<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentUploaded extends Notification
{
    use Queueable;

    protected $user;
    protected $documentPath;

    public function __construct($user, $documentPath)
    {
        $this->user = $user;
        $this->documentPath = $documentPath;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Document Uploaded')
            ->greeting('Hello Admin,')
            ->line("{$this->user->name} has uploaded a new document.")
            ->action('View Document', url("/storage/{$this->documentPath}"))
            ->line('Please review it.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'document_path' => $this->documentPath,
            'message' => "{$this->user->name} uploaded a new document.",
        ];
    }
}
