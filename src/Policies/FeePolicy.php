<?php

namespace Tipoff\Fees\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Fees\Models\Fee;
use Tipoff\Support\Contracts\Models\UserInterface;

class FeePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view fees') ? true : false;
    }

    public function view(UserInterface $user, Fee $fee): bool
    {
        return $user->hasPermissionTo('view fees') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create fees') ? true : false;
    }

    public function update(UserInterface $user, Fee $fee): bool
    {
        return $user->hasPermissionTo('update fees') ? true : false;
    }

    public function delete(UserInterface $user, Fee $fee): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Fee $fee): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Fee $fee): bool
    {
        return false;
    }
}
