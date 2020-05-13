<?php

namespace App\Events\Apps;

use App\App;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaboratorAddedEvent
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
     * Create a new event instance.
     *
     * @param \App\App $app
     * @param \App\User $collaborator
     * @return void
     */
    public function __construct(App $app, User $collaborator)
    {
        $this->app = $app;
        $this->collaborator = $collaborator;
    }
}
