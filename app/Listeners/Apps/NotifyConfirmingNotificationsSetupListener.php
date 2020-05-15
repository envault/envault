<?php

namespace App\Listeners\Apps;

use App\Events\Apps\NotificationsSetUpEvent;
use App\Notifications\AppNotificationsSetUpNotification;

class NotifyConfirmingNotificationsSetupListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\NotificationsSetUpEvent $event
     * @return void
     */
    public function handle(NotificationsSetUpEvent $event)
    {
        $event->app->notify(new AppNotificationsSetUpNotification());
    }
}
