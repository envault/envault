<?php

namespace App\Events\Variables;

use App\Models\App;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var int
     */
    public $count;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\App $app
     * @param int $count
     * @return void
     */
    public function __construct(App $app, $count)
    {
        $this->app = $app;
        $this->count = $count;
    }
}
