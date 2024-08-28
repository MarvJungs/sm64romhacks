<?php

namespace App\Policies;

use App\Models\Cheat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CheatPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cheat $cheat): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cheat $cheat): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cheat $cheat): bool
    {
        return $this->delete($user, $cheat);
    }
}
