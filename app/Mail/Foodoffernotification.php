<?php

namespace App\Mail;

use App\Models\FoodRequestDonation;
use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FoodOfferNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $foodOffer;
    public $foodRequest;
    public $contributor;
    public $confirmationToken;

    public function __construct(FoodRequestDonation $foodOffer, FoodRequest $foodRequest, User $contributor, string $confirmationToken)
    {
        $this->foodOffer = $foodOffer;
        $this->foodRequest = $foodRequest;
        $this->contributor = $contributor;
        $this->confirmationToken = $confirmationToken;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Food Contribution Offer - FoodShare',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.food-offer-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}