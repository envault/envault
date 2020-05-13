<?php

namespace App\Listeners\Users;

use App\Events\Users\DeletedEvent;

class LogDeletionListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\DeletedEvent $event
     * @return void
     */
    public function handle(DeletedEvent $event)
    {
        $event->user->log()->create([
            'action' => 'deleted',
            'description' => "{$event->user->full_name} ({$event->user->email}) was removed as a user.",
        ]);
    }
}
