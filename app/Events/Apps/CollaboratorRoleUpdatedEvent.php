<?php

namespace App\Events\Apps;

use App\App;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaboratorRoleUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var \App\User
     */
    public $collaborator;

    /**
     * @var string
     */
    public $newRole;

    /**
     * @var string
     */
    public $oldRole;

    /**
     * Create a new event instance.
     *
     * @param \App\App $app
     * @param \App\User $collaborator
     * @param string $oldRole
     * @param string $newRole
     * @return void
     */
    public function __construct(App $app, User $collaborator, $oldRole, $newRole)
    {
        $this->app = $app;
        $this->collaborator = $collaborator;
        $this->newRole = $newRole;
        $this->oldRole = $oldRole;
    }
}
