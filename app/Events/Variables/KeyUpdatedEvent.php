<?php

namespace App\Events\Variables;

use App\Models\App;
use App\Models\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KeyUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\App
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
     * @var \App\Models\Variable
     */
    public $variable;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\App $app
     * @param \App\Models\Variable $variable
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
