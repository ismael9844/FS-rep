<?php

namespace App\Mail;

use App\Models\Place;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceRequestRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    public function build()
    {
        return $this->subject('Place Request Update - ' . $this->place->title)
                    ->view('emails.place-request-rejected');
    }
}