<?php

namespace App\Listeners\Users;

use App\Events\Users\EmailUpdatedEvent;

class LogEmailUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\EmailUpdatedEvent $event
     * @return void
     */
    public function handle(EmailUpdatedEvent $event)
    {
        $event->user->log()->create([
            'action' => 'email.updated',
            'description' => "The email for {$event->user->full_name} was updated from {$event->oldEmail} to {$event->newEmail}.",
        ]);
    }
}
