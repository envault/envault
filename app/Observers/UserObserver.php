<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        $user->log()->forceDelete();
    }
}
