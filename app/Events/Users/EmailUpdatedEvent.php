<?php

namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $newEmail;

    /**
     * @var string
     */
    public $oldEmail;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $oldEmail, $newEmail)
    {
        $this->newEmail = $newEmail;
        $this->oldEmail = $oldEmail;
        $this->user = $user;
    }
}
