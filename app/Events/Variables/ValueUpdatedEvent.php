<?php

namespace App\Events\Variables;

use App\App;
use App\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ValueUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var \App\Variable
     */
    public $variable;

    /**
     * Create a new event instance.
     *
     * @param \App\App $app
     * @param \App\Variable $variable
     * @return void
     */
    public function __construct(App $app, Variable $variable)
    {
        $this->app = $app;
        $this->variable = $variable;
    }
}
