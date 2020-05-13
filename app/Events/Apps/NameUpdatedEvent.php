<?php

namespace App\Events\Apps;

use App\App;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NameUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var string
     */
    public $newName;

    /**
     * @var string
     */
    public $oldName;

    /**
     * Create a new event instance.
     *
     * @param \App\App $app
     * @param string $oldName
     * @param string $newName
     * @return void
     */
    public function __construct(App $app, $oldName, $newName)
    {
        $this->app = $app;
        $this->newName = $newName;
        $this->oldName = $oldName;
    }
}
