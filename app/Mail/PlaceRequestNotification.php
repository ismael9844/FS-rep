<?php

namespace App\Mail;

use App\Models\PlaceRequest;
use App\Models\Place;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $placeRequest;
    public $place;
    public $requester;
    public $token;

    public function __construct(PlaceRequest $placeRequest, Place $place, User $requester, $token)
    {
        $this->placeRequest = $placeRequest;
        $this->place = $place;
        $this->requester = $requester;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('New Place Request - ' . $this->place->title)
                    ->view('emails.place-request-notification');
    }
}