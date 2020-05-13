<?php

namespace App\Listeners\Users;

use App\Events\Users\NameUpdatedEvent;

class LogNameUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\NameUpdatedEvent $event
     * @return void
     */
    public function handle(NameUpdatedEvent $event)
    {
        $event->user->log()->create([
            'action' => 'name.updated',
            'description' => "The user {$event->oldName} was renamed to {$event->newName}.",
        ]);
    }
}
