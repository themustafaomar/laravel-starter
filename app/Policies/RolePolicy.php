<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function assignRoles(User $user): bool
    {
        return $user->hasPermissionTo('assign roles');
    }
}
