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
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Version $version): bool
    {
        return $version->authors()->pluck('user_id')->contains($user->id) || $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Version $version): bool
    {
        return $version->authors()->pluck('user_id')->contains($user->id) || $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }
}
