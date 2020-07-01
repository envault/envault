<?php

namespace App\Events\Apps;

use App\Models\App;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaboratorRoleUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var \App\Models\User
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
     * @param \App\Models\App $app
     * @param \App\Models\User $collaborator
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
