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

class PickupScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $pickup;
    public $donation;
    public $receiver;

    public function __construct(Pickup $pickup, Donation $donation, User $receiver)
    {
        $this->pickup = $pickup;
        $this->donation = $donation;
        $this->receiver = $receiver;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pickup Scheduled - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pickup-scheduled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}