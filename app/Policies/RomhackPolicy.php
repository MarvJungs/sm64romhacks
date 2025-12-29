<?php

namespace App\Policies;

use App\Models\Romhack;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RomhackPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Romhack $romhack): bool
    {
        return true;
    }

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
    public function update(User $user, Romhack $romhack): bool
    {
        $firstVersion = $romhack->versions()->orderBy('releasedate')->first();
        $authors = $firstVersion->authors()->pluck('user_id');
        return $authors->contains($user->id) || $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can set the Romhack has Megapack viable
     */
    public function megapack(User $user): bool
    {
        return $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Romhack $romhack): bool
    {
        $firstVersion = $romhack->versions()->orderBy('releasedate')->first();
        $authors = $firstVersion->authors()->pluck('user_id');
        return $authors->contains($user->id) || $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Romhack $romhack): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Romhack $romhack): bool
    {
        $firstVersion = $romhack->versions()->orderBy('releasedate')->first();
        $authors = $firstVersion->authors()->pluck('user_id');
        return $authors->contains($user->id) || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    public function createVersion(User $user, Romhack $romhack)
    {
        $firstVersion = $romhack->versions()->orderBy('releasedate')->first();
        $authors = $firstVersion->authors()->pluck('user_id');
        return $authors->contains($user->id) || $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    public function verify(User $user, Romhack $romhack)
    {
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    public function reject(User $user, Romhack $romhack)
    {
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }
}
