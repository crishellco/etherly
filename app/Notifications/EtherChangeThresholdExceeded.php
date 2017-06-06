<?php

namespace App\Notifications;

use App\Price;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EtherChangeThresholdExceeded extends Notification implements ShouldQueue
{
    use Queueable;

    const OVERVIEW_URL = 'https://www.cryptocompare.com/coins/eth/overview/USD';

    public $currentPrice;
    public $historicalPrice;
    public $percentChange;
    public $threshold;

    public function __construct(Price $currentPrice, Price $historicalPrice, $percentChange)
    {
        $this->currentPrice = $currentPrice;
        $this->historicalPrice = $historicalPrice;
        $this->percentChange = $percentChange;
    }

    public function via()
    {
        return ['mail', 'slack'];
    }

    public function toMail($user)
    {
        return (new MailMessage)
            ->greeting('ETH Change Threshold Exceeded')
            ->line("ETH price fluctuation has exceeded the threshold of change within the last 10 minutes.")
            ->line("Current Price: {$this->currentPrice->price}")
            ->line("Historical Price: {$this->historicalPrice->price}")
            ->line("Change: {$this->percentChange}%")
            ->line("Threshold: {$user->threshold}%")
            ->action('View On CryptoCompare', self::OVERVIEW_URL);
    }

    public function toSlack($user)
    {
        return (new SlackMessage)
            ->content('ETH Change Threshold Exceeded')
            ->attachment(function ($attachment) use ($user) {
                $attachment->title('View On CryptoCompare', self::OVERVIEW_URL)
                    ->fields([
                        'Current Price' => $this->currentPrice->price,
                        'Historical Price' => $this->historicalPrice->price,
                        'Change' => "{$this->percentChange}%",
                        'Threshold' => "{$user->threshold}%",
                    ]);
            });
    }
}
