<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
