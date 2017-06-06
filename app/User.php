<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'notifications_enabled',
        'password',
        'slack_webhook',
        'threshold',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function routeNotificationForSlack()
    {
        return $this->slack_webhook;
    }

    public function storeNotification($currentPriceId, $historicalPriceId, $percentChange)
    {
        $notification = Notification::make([
            'current_price_id' => $currentPriceId,
            'historical_price_id' => $historicalPriceId,
            'percent_change' => $percentChange,
            'threshold' => $this->threshold,
        ]);

        $this->notifications()->save($notification);
    }
}
