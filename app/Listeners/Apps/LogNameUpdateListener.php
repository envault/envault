<?php

namespace App\Listeners\Apps;

use App\Events\Apps\NameUpdatedEvent;

class LogNameUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\NameUpdatedEvent $event
     * @return void
     */
    public function handle(NameUpdatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'name.updated',
            'description' => "The {$event->oldName} app was renamed to {$event->newName}.",
        ]);
    }
}
