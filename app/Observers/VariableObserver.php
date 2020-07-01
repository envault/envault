<?php

namespace App\Observers;

use App\Models\Variable;

class VariableObserver
{
    /**
     * Handle the variable "deleted" event.
     *
     * @param \App\Models\Variable $variable
     * @return void
     */
    public function deleted(Variable $variable)
    {
        $variable->versions()->delete();
    }

    /**
     * Handle the variable "restored" event.
     *
     * @param \App\Models\Variable $variable
     * @return void
     */
    public function restored(Variable $variable)
    {
        $variable->versions()->withTrashed()->where('deleted_at', '>=', $variable->deleted_at)->get()->restore();
    }
}
