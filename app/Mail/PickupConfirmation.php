<?php

namespace App\Mail;

use App\Models\Pickup;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PickupConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $pickup;
    public $donation;
    public $receiver;
    public $confirmationToken;

    public function __construct(Pickup $pickup, Donation $donation, User $receiver, string $confirmationToken)
    {
        $this->pickup = $pickup;
        $this->donation = $donation;
        $this->receiver = $receiver;
        $this->confirmationToken = $confirmationToken;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Pickup Request - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pickup-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}