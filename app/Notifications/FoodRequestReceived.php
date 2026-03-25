<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FoodRequestReceived extends Notification
{
    use Queueable;

    public $foodRequest;

    public function __construct($foodRequest)
    {
        $this->foodRequest = $foodRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You received a new food request from ' . $this->foodRequest->organization->name,
            'food_request_id' => $this->foodRequest->id,
        ];
    }
}
