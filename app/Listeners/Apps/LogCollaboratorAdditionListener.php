<?php

namespace App\Listeners\Apps;

use App\Events\Apps\CollaboratorAddedEvent;

class LogCollaboratorAdditionListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\CollaboratorAddedEvent $event
     * @return void
     */
    public function handle(CollaboratorAddedEvent $event)
    {
        $event->app->log()->create([
            'action' => 'collaborator.added',
            'description' => "{$event->collaborator->full_name} ({$event->collaborator->email}) was added as a collaborator to the {$event->app->name} app.",
        ]);
    }
}
