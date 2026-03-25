<?php

namespace App\Notifications;

use App\Models\Donation;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VolunteerSignedUp extends Notification
{
    use Queueable;

    protected User $volunteerUser;
    protected Donation $donation;
    protected Volunteer $volunteerProfile;

    public function __construct(User $volunteerUser, Donation $donation)
    {
        $this->volunteerUser   = $volunteerUser;
        $this->donation        = $donation;
        $this->volunteerProfile = $volunteerUser->volunteerProfile; // Assure-toi que cette relation existe
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Volunteer for Your Donation')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("{$this->volunteerUser->name} has just volunteered to distribute your donation of “{$this->donation->category}”.")
            ->line("Information of the volunteer:")
            ->line("Phone: {$this->volunteerProfile->phone}")
            ->line("Skills: {$this->volunteerProfile->skills}")
            ->line("Availability: {$this->volunteerProfile->availability}")
            ->action('View Donation', url("/donations/{$this->donation->id}"))
            ->line('Thank you for helping reduce food waste!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'volunteer_id'    => $this->volunteerUser->id,
            'volunteer_phone' => $this->volunteerProfile->phone,
            'volunteer_skills' => $this->volunteerProfile->skills,
            'volunteer_availability' => $this->volunteerProfile->availability,

            'donation_id'     => $this->donation->id,
            'donation_category' => $this->donation->category,
            'message'         => "{$this->volunteerUser->name} (phone: {$this->volunteerProfile->phone}) volunteered for your donation.",
        ];
    }
}
