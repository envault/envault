<?php

namespace App\Listeners\Variables;

use App\Events\Variables\KeyUpdatedEvent;

class LogKeyUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\KeyUpdatedEvent $event
     * @return void
     */
    public function handle(KeyUpdatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'variable.key.updated',
            'description' => "The {$event->oldKey} variable was renamed to {$event->newKey} for the {$event->app->name} app.",
        ]);
    }
}
