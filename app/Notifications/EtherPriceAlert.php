<?php

namespace App\Notifications;

use App\Alert;
use App\Price;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EtherPriceAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $alert;
    public $currentPrice;
    public $lastPrice;

    public function __construct(Alert $alert, Price $currentPrice, Price $lastPrice)
    {
        $this->alert = $alert;
        $this->currentPrice = $currentPrice;
        $this->lastPrice = $lastPrice;
    }

    public function via($user)
    {
        $methods = [];

        if($user->via_mail) {
            $methods[] = 'mail';
        }

        if($user->via_slack) {
            $methods[] = 'slack';
        }

        return $methods;
    }

    public function toMail()
    {
        $formattedPrice = number_format($this->currentPrice->price, 2);

        return (new MailMessage)
            ->greeting("ETH (\${$formattedPrice}) Price Alert")
            ->line("ETH price reached \${$formattedPrice}")
            ->action('View On Etherly', config('app.url'));
    }

    public function toSlack()
    {
        $formattedPrice = number_format($this->currentPrice->price, 2);

        return (new SlackMessage)
            ->content("ETH price reached \${$formattedPrice}");
    }
}
