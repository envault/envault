<?php

namespace App\Listeners\Variables;

use App\Events\Variables\ImportedEvent;
use Illuminate\Support\Str;

class LogImportListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Variables\ImportedEvent $event
     * @return void
     */
    public function handle(ImportedEvent $event)
    {
        $variableForm = Str::plural('variable', $event->count);
        $wasForm = $event->count > 2 ? 'was' : 'were';

        $event->app->log()->create([
            'action' => 'variables.imported',
            'description' => "{$event->count} {$variableForm} {$wasForm} imported to the {$event->app->name} app.",
        ]);
    }
}
