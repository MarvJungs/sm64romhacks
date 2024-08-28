<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Version;
use Illuminate\Auth\Access\Response;

class VersionPolicy
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
    public function update(User $user, Version $version): bool
    {
        $authors = $version->authors->toArray();
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
    public function delete(User $user, Version $version): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Version $version): bool
    {
        return $this->delete($user, $version);
    }
}
