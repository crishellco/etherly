<?php

namespace App\Notifications;

use App\Price;
use App\Threshold;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EtherChangeThresholdExceeded extends Notification implements ShouldQueue
{
    use Queueable;

    public $threshold;
    public $currentPrice;
    public $historicalPrice;
    public $percentChange;
    public $priceChange;

    public function __construct(
        Threshold $threshold,
        Price $currentPrice,
        Price $historicalPrice,
        $percentChange,
        $priceChange
    ) {
        $this->threshold = $threshold;
        $this->currentPrice = $currentPrice;
        $this->historicalPrice = $historicalPrice;
        $this->percentChange = $percentChange;
        $this->priceChange = number_format($priceChange, 2);
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
        return (new MailMessage)
            ->greeting('ETH Change Threshold Exceeded')
            ->line("ETH price fluctuation has exceeded the threshold of change within the last 10 minutes.")
            ->line("Current Price: {$this->currentPrice->price}")
            ->line("Historical Price: {$this->historicalPrice->price}")
            ->line("Change: \${$this->priceChange} ({$this->percentChange}%)")
            ->line("Threshold: \${$this->threshold->price} ({$this->threshold->percent}%)")
            ->action('View On Etherly', config('app.url'));
    }

    public function toSlack()
    {
        return (new SlackMessage)
            ->content('ETH Change Threshold Exceeded')
            ->attachment(function ($attachment) {
                $attachment->title('View On Etherly', config('app.url'))
                    ->fields([
                        'Current Price' => $this->currentPrice->price,
                        'Historical Price' => $this->historicalPrice->price,
                        'Change' => "\${$this->priceChange} ({$this->percentChange}%)",
                        'Threshold' => "\${$this->threshold->price} ({$this->threshold->percent}%)",
                    ]);
            });
    }
}
