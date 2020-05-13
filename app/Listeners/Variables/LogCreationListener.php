<?php

namespace App\Listeners\Variables;

use App\Events\Variables\CreatedEvent;

class LogCreationListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\CreatedEvent $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'variable.created',
            'description' => "The variable {$event->variable->key} was added to the {$event->app->name} app.",
        ]);
    }
}
