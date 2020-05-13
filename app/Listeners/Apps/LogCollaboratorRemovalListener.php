<?php

namespace App\Listeners\Apps;

use App\Events\Apps\CollaboratorRemovedEvent;

class LogCollaboratorRemovalListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\CollaboratorRemovedEvent $event
     * @return void
     */
    public function handle(CollaboratorRemovedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'collaborator.removed',
            'description' => "{$event->collaborator->full_name} ({$event->collaborator->email}) was removed as a collaborator from the {$event->app->name} app.",
        ]);
    }
}
