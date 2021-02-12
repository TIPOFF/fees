<?php

declare(strict_types=1);

namespace Tipoff\Waivers\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Fees\Models\Fee;

class SignaturePolicy
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
        return false;
    }

    public function update(UserInterface $user, Fee $fee): bool
    {
        return false;
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
