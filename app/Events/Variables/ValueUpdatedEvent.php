<?php

namespace App\Events\Variables;

use App\Models\App;
use App\Models\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ValueUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var \App\Models\Variable
     */
    public $variable;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\App $app
     * @param \App\Models\Variable $variable
     * @return void
     */
    public function __construct(App $app, Variable $variable)
    {
        $this->app = $app;
        $this->variable = $variable;
    }
}
