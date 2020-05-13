<?php

namespace App\Listeners\Variables;

use App\Events\Variables\ValueUpdatedEvent;
use App\Notifications\VariableUpdatedNotification;

class NotifyOfVariableValueUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\ValueUpdatedEvent $event
     * @return void
     */
    public function handle(ValueUpdatedEvent $event)
    {
        if ($event->app->notificationsEnabled()) {
            $event->app->notify(new VariableUpdatedNotification($event->variable));
        }
    }
}
