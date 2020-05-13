<?php

namespace App\Listeners\Users;

use App\Events\Users\CreatedEvent;

class LogCreationListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\CreatedEvent $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
        $event->user->log()->create([
            'action' => 'created',
            'description' => "{$event->user->full_name} ({$event->user->email}) was added as a user.",
        ]);
    }
}
