<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Sponsorship;

class SponsorshipRequested extends Notification
{
    use Queueable;

    protected Sponsorship $sponsorship;

    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    public function via($notifiable)
    {
        // This will now be sent only to the partner who created the request
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $tier      = $this->sponsorship->tier;
        $price     = number_format($tier->price, 2);
        $paypalUrl = "https://www.paypal.com/myaccount/profile/";

        return (new MailMessage)
            ->subject("Please complete your sponsorship payment")
            ->greeting("Hello {$notifiable->name},")
            ->line("Thank you for choosing the “{$tier->name}” sponsorship tier at **€{$price}**.")
            ->line('To activate your sponsorship, please complete your payment by clicking the button below:')
            ->action('Pay €' . $price . ' via PayPal', $paypalUrl)
            ->line('Once we receive your payment, your sponsorship will go live. Thank you for supporting our platform!');
    }
}
