<?php

namespace App\Events\Apps;

use App\Models\App;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollaboratorRemovedEvent
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
     * Create a new event instance.
     *
     * @param \App\Models\App $app
     * @param \App\Models\User $collaborator
     * @return void
     */
    public function __construct(App $app, User $collaborator)
    {
        $this->app = $app;
        $this->collaborator = $collaborator;
    }
}
