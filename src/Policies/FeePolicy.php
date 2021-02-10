<?php

namespace Tipoff\Fees\Policies;

use Tipoff\Fees\Models\Fee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view fees') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Fee  $fee
     * @return mixed
     */
    public function view(User $user, Fee $fee)
    {
        return $user->hasPermissionTo('view fees') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fees') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Fee  $fee
     * @return mixed
     */
    public function update(User $user, Fee $fee)
    {
        return $user->hasPermissionTo('update fees') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Fee  $fee
     * @return mixed
     */
    public function delete(User $user, Fee $fee)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Fee  $fee
     * @return mixed
     */
    public function restore(User $user, Fee $fee)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Fee  $fee
     * @return mixed
     */
    public function forceDelete(User $user, Fee $fee)
    {
        return false;
    }
}
