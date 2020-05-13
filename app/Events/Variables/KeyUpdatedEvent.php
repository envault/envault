<?php

namespace App\Events\Variables;

use App\App;
use App\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KeyUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var string
     */
    public $newKey;

    /**
     * @var string
     */
    public $oldKey;

    /**
     * @var \App\Variable
     */
    public $variable;

    /**
     * Create a new event instance.
     *
     * @param \App\App $app
     * @param \App\Variable $variable
     * @param string $oldKey
     * @param string $newKey
     * @return void
     */
    public function __construct(App $app, Variable $variable, $oldKey, $newKey)
    {
        $this->app = $app;
        $this->newKey = $newKey;
        $this->oldKey = $oldKey;
        $this->variable = $variable;
    }
}
