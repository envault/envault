<?php

namespace App\Listeners\Variables;

use App\Events\Variables\DeletedEvent;

class LogDeletionListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\DeletedEvent $event
     * @return void
     */
    public function handle(DeletedEvent $event)
    {
        $event->variable->app->log()->create([
            'action' => 'variable.deleted',
            'description' => "The variable {$event->variable->key} was removed from the {$event->app->name} app.",
        ]);
    }
}
