<?php

namespace App\Listeners\Apps;

use App\Events\Apps\CollaboratorRoleUpdatedEvent;

class LogCollaboratorRoleUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Apps\CollaboratorRoleUpdatedEvent $event
     * @return void
     */
    public function handle(CollaboratorRoleUpdatedEvent $event)
    {
        $newRoleName = $event->newRole ?: 'collaborator';
        $oldRoleName = $event->oldRole ?: 'collaborator';

        $event->app->log()->create([
            'action' => 'collaborator.role.updated',
            'description' => "The user {$event->collaborator->full_name} ({$event->collaborator->email}) was updated from {$oldRoleName} to {$newRoleName} for the {$event->app->name} app.",
        ]);
    }
}
