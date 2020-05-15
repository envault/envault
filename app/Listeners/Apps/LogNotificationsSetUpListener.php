<?php

namespace App\Listeners\Apps;

use App\Events\Apps\NotificationsSetUpEvent;

class LogNotificationsSetUpListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\NotificationsSetUpEvent $event
     * @return void
     */
    public function handle(NotificationsSetUpEvent $event)
    {
        $event->app->log()->create([
            'action' => 'notifications.set-up',
            'description' => "The {$event->app->name} app's notification settings were updated.",
        ]);
    }
}
