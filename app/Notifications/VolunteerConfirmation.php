<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class VolunteerConfirmation extends Notification
{
    use Queueable;

    protected Donation $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You’ve Volunteered Successfully!')
            ->greeting("Hello {$notifiable->name},")
            ->line("Thank you for volunteering for the donation “{$this->donation->title}”. Here are the details:")
            ->line("• City: {$this->donation->city}")
            ->line("• Available from: {$this->donation->available_from}")
            ->line("• Available until: {$this->donation->available_to}")
            ->when($this->donation->volunteer_note, function($mail) {
                $mail->line("• Note from donor: {$this->donation->volunteer_note}");
            })
            ->line("Donor contact:")
            ->line("• Name: {$this->donation->user->name}")
            ->line("• Email: {$this->donation->user->email}")
            ->action('View Donation', url("/donations/{$this->donation->id}"))
            ->line('We appreciate your help!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'donation_id'     => $this->donation->id,
            'title'           => $this->donation->title,
            'city'            => $this->donation->city,
            'available_from'  => Carbon::parse($this->donation->available_from)->toDateTimeString(),
            'available_to'    => Carbon::parse($this->donation->available_to)->toDateTimeString(),
            'volunteer_note'  => $this->donation->volunteer_note,
            'donor_name'      => $this->donation->user->name,
            'donor_email'     => $this->donation->user->email,
            'message' => "You’ve volunteered for “{$this->donation->title}” in {$this->donation->city}.\n" .
                        "Distribution will take place from {$this->donation->available_from} to {$this->donation->available_to}.\n" .
                        "Donor: {$this->donation->user->name} can be contacted at ({$this->donation->user->email})\n" .
                        "Note from the donor: {$this->donation->volunteer_note}",
        ];
    }
}
