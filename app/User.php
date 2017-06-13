<?php

namespace App;

use App\ModelTraits\StoresNotifications;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, StoresNotifications;

    protected $fillable = [
        'email',
        'name',
        'password',
        'slack_webhook',
        'threshold_percent',
        'threshold_price',
        'via_email',
        'via_slack',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function notifications()
    {
        return $this
            ->hasMany(Notification::class)
            ->orderBy('created_at', 'desc');
    }

    public function notificationsEnabled()
    {
        return $this->via_email || $this->via_slack;
    }

    public function routeNotificationForSlack()
    {
        return $this->slack_webhook;
    }

    public function thresholds()
    {
        return $this->hasMany(Threshold::class);
    }
}
