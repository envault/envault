<?php

namespace App\Listeners\Users;

use App\Events\Users\RoleUpdatedEvent;

class LogRoleUpdateListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Users\RoleUpdatedEvent $event
     * @return void
     */
    public function handle(RoleUpdatedEvent $event)
    {
        $newRoleName = $event->newRole ?: 'user';
        $oldRoleName = $event->oldRole ?: 'user';

        $event->user->log()->create([
            'action' => 'role.updated',
            'description' => "The user {$event->user->full_name} ({$event->user->email}) was updated from {$oldRoleName} to {$newRoleName}.",
        ]);
    }
}
