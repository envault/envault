<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id != $model->id && ($user->isOwner() || ($user->isAdminOrOwner() && ! $model->isAdminOrOwner()));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->isOwner() || ($user->isAdminOrOwner() && ! $model->isAdminOrOwner());
    }

    /**
     * Determine whether the user can update the model's role.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function updateRole(User $user, User $model)
    {
        return $user->id != $model->id && $user->isOwner();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->isAdminOrOwner();
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdminOrOwner();
    }
}
