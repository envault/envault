<?php

namespace App\Events\Users;

use App\Models\User;
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
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
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
