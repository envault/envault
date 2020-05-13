<?php

namespace App\Listeners\Variables;

use App\Events\Variables\ValueUpdatedEvent;

class LogValueUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\ValueUpdatedEvent $event
     * @return void
     */
    public function handle(ValueUpdatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'variable.value.updated',
            'description' => "The value of the {$event->variable->key} variable was updated for the {$event->app->name} app.",
        ]);
    }
}
