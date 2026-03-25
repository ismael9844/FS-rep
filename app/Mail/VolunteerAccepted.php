<?php

namespace App\Mail;

use App\Models\Volunteer;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $volunteer;
    public $donation;

    public function __construct(Volunteer $volunteer, Donation $donation)
    {
        $this->volunteer = $volunteer;
        $this->donation = $donation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Volunteer Request Accepted! - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteer-accepted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}