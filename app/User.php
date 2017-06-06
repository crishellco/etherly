<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'notifications_enabled', 'password', 'slack_webhook', 'threshold'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function routeNotificationForSlack()
    {
        return $this->slack_webhook;
    }
}
