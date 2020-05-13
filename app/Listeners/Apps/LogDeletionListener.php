<?php

namespace App\Listeners\Apps;

use App\Events\Apps\DeletedEvent;

class LogDeletionListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\DeletedEvent $event
     * @return void
     */
    public function handle(DeletedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'deleted',
            'description' => "The {$event->app->name} app was deleted.",
        ]);
    }
}
