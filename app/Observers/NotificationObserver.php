<?php

namespace App\Observers;

use App\Events\NotificationsUpdated;
use App\Notification;

class NotificationObserver
{
    public function created(Notification $notification)
    {
        event(new NotificationsUpdated($notification->user));
    }
}