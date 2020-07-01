<?php

namespace App\Observers;

use App\Models\LogEntry;

class LogEntryObserver
{
    /**
     * Handle the log entry "created" event.
     *
     * @param \App\Models\LogEntry $logEntry
     * @return void
     */
    public function created(LogEntry $logEntry)
    {
        if (user()) {
            $logEntry->user()->associate(user());

            $logEntry->save();
        }
    }
}
