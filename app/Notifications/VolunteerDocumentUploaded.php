<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VolunteerDocumentUploaded extends Notification
{
    use Queueable;

    protected $volunteer;
    protected $path;

    public function __construct($volunteer, $path)
    {
        $this->volunteer = $volunteer;
        $this->path = $path;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = url("/admin/volunteers/{$this->volunteer->id}/verify"); // admin page
        return (new MailMessage)
            ->subject("New volunteer document uploaded")
            ->line("A volunteer ({$this->volunteer->user->name}) uploaded an official document.")
            ->action('Review document', $url)
            ->line('Please review and approve or decline.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'volunteer_id' => $this->volunteer->id,
            'volunteer_name' => $this->volunteer->user->name,
            'document_path' => $this->path,
            'message' => "{$this->volunteer->user->name} uploaded a verification document.",
        ];
    }
}
