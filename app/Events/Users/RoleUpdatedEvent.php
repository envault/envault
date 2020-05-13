<?php

namespace App\Events\Users;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $newRole;

    /**
     * @var string
     */
    public $oldRole;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
     * @param string $oldRole
     * @param string $newRole
     * @return void
     */
    public function __construct(User $user, $oldRole, $newRole)
    {
        $this->newRole = $newRole;
        $this->oldRole = $oldRole;
        $this->user = $user;
    }
}
