<?php

namespace App\Mail;

use App\Models\PlaceRequest;
use App\Models\Place;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceRequestAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $placeRequest;
    public $place;

    public function __construct(PlaceRequest $placeRequest, Place $place)
    {
        $this->placeRequest = $placeRequest;
        $this->place = $place;
    }

    public function build()
    {
        return $this->subject('Place Request Approved - ' . $this->place->title)
                    ->view('emails.place-request-accepted');
    }
}