<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdminOrOwner();
    }

    /**
     * Determine whether the user can create variables for the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function createVariable(User $user, App $app)
    {
        return $user->isAdminOrOwner() || $user->isAppAdmin($app);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function delete(User $user, App $app)
    {
        return $user->isAdminOrOwner();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function forceDelete(User $user, App $app)
    {
        return $user->isOwner();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function restore(User $user, App $app)
    {
        return $user->isAdminOrOwner();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function update(User $user, App $app)
    {
        return $user->isAdminOrOwner();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\App $app
     * @return mixed
     */
    public function view(User $user, App $app)
    {
        return $user->isAdminOrOwner() || $user->isAppCollaborator($app);
    }

    /**
     * Determine whether the user can view all models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->isAdminOrOwner();
    }
}
