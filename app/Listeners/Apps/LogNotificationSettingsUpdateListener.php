<?php

namespace App\Listeners\Apps;

use App\Events\Apps\NotificationSettingsUpdatedEvent;

class LogNotificationSettingsUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\NotificationSettingsUpdatedEvent $event
     * @return void
     */
    public function handle(NotificationSettingsUpdatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'notifications.updated',
            'description' => "The {$event->app->name} app's notification settings were updated.",
        ]);
    }
}
