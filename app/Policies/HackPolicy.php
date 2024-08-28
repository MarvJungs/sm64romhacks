<?php

namespace App\Policies;

use App\Models\Hack;
use App\Models\User;

class HackPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hack $hack): bool
    {
        $versions = $hack->versions->sortBy('releasedate');
        $authors = $versions->first()->authors->toArray();
        foreach ($authors as $author) {
            if ($author['user_id'] == $user->id) {
                return true;
            }
        }
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hack $hack): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hack $hack): bool
    {
        return $this->delete($user, $hack);
    }
}
