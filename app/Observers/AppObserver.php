<?php

namespace App\Observers;

use App\Models\App;

class AppObserver
{
    /**
     * Handle the app "deleted" event.
     *
     * @param \App\Models\App $app
     * @return void
     */
    public function deleted(App $app)
    {
        $app->setup_tokens()->delete();

        $app->variables()->delete();
    }

    /**
     * Handle the app "restored" event.
     *
     * @param \App\Models\App $app
     * @return void
     */
    public function restored(App $app)
    {
        $app->setup_tokens()->withTrashed()->where('deleted_at', '>=', $app->deleted_at)->get()->restore();

        $app->variables()->withTrashed()->where('deleted_at', '>=', $app->deleted_at)->get()->restore();
    }

    /**
     * Handle the app "force deleted" event.
     *
     * @param \App\Models\App $app
     * @return void
     */
    public function forceDeleted(App $app)
    {
        $app->log()->forceDelete();
    }
}
