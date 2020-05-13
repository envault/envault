<?php

namespace App\Listeners\Apps;

use App\Events\Apps\CreatedEvent;

class LogCreationListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\CreatedEvent $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'created',
            'description' => "The {$event->app->name} app was created.",
        ]);
    }
}
