<?php

namespace App\Listeners\Variables;

use App\Events\Variables\KeyUpdatedEvent;
use App\Notifications\VariableUpdatedNotification;

class NotifyOfVariableKeyUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\KeyUpdatedEvent $event
     * @return void
     */
    public function handle(KeyUpdatedEvent $event)
    {
        if ($event->app->notificationsEnabled()) {
            $event->app->notify(new VariableUpdatedNotification($event->variable));
        }
    }
}
