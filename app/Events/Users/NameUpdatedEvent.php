<?php

namespace App\Events\Users;

use App\User;
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
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
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
