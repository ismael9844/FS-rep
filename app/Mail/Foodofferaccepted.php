<?php

namespace App\Mail;

use App\Models\FoodRequestDonation;
use App\Models\FoodRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FoodOfferAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $foodOffer;
    public $foodRequest;

    public function __construct(FoodRequestDonation $foodOffer, FoodRequest $foodRequest)
    {
        $this->foodOffer = $foodOffer;
        $this->foodRequest = $foodRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Food Offer Accepted! - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.food-offer-accepted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}