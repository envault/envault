<?php

namespace App\Policies;

use App\User;
use App\Variable;
use Illuminate\Auth\Access\HandlesAuthorization;

class VariablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Variable $variable
     * @return mixed
     */
    public function delete(User $user, Variable $variable)
    {
        return $user->isAdminOrOwner() || $user->isAppAdmin($variable->app);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Variable $variable
     * @return mixed
     */
    public function update(User $user, Variable $variable)
    {
        return $user->isAdminOrOwner() || $user->isAppAdmin($variable->app);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Variable $variable
     * @return mixed
     */
    public function view(User $user, Variable $variable)
    {
        return $user->isAdminOrOwner() || $user->isAppCollaborator($variable->app);
    }
}
