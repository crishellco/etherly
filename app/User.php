<?php

namespace App;

use App\ModelTraits\StoresNotifications;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, StoresNotifications;

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
}
