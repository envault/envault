<?php

namespace App\Listeners\Variables;

use App\Events\Variables\ImportedEvent;
use App\Notifications\VariablesImportedNotification;

class NotifyOfVariableImportListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\ImportedEvent $event
     * @return void
     */
    public function handle(ImportedEvent $event)
    {
        if ($event->app->notificationsEnabled()) {
            $event->app->notify(new VariablesImportedNotification($event->count));
        }
    }
}
