<?php

namespace App\Listeners\Users;

use App\Events\Users\SignedInEvent;

class LogSignInListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\SignedInEvent $event
     * @return void
     */
    public function handle(SignedInEvent $event)
    {
        $event->user->log()->create([
            'action' => 'authenticated',
            'description' => "{$event->user->full_name} ({$event->user->email}) signed in.",
        ]);
    }
}
