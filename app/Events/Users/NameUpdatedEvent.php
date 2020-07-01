<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NameUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $newName;

    /**
     * @var string
     */
    public $oldName;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param string $newName
     * @param string $oldName
     * @return void
     */
    public function __construct(User $user, $oldName, $newName)
    {
        $this->newName = $newName;
        $this->oldName = $oldName;
        $this->user = $user;
    }
}
