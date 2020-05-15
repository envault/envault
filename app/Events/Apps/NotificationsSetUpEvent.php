<?php

namespace App\Events\Apps;

use App\App;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationsSetUpEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * Create a new event instance.
     *
     * @param \App\App $app
     * @return void
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }
}
