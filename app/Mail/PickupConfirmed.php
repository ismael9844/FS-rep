<?php

namespace App\Mail;

use App\Models\Pickup;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PickupConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $pickup;
    public $donation;

    public function __construct(Pickup $pickup, Donation $donation)
    {
        $this->pickup = $pickup;
        $this->donation = $donation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pickup Confirmed! - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pickup-confirmed',
        );
    }
}