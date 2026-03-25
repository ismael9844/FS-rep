<?php

namespace App\Mail;

use App\Models\Volunteer;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $volunteer;
    public $donation;
    public $volunteerUser;
    public $confirmationToken;

    public function __construct(Volunteer $volunteer, Donation $donation, User $volunteerUser, string $confirmationToken)
    {
        $this->volunteer = $volunteer;
        $this->donation = $donation;
        $this->volunteerUser = $volunteerUser;
        $this->confirmationToken = $confirmationToken;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Volunteer Request - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteer-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}