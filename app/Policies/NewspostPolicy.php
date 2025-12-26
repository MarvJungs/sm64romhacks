<?php

namespace App\Policies;

use App\Models\Newspost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewspostPolicy
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
    public function view(User $user, Newspost $newspost): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('owner') || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Newspost $newspost): bool
    {
        return $user->id === $newspost->user_id || $user->hasRole('owner');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Newspost $newspost): bool
    {
        return $user->id === $newspost->user_id || $user->hasRole('owner');
    }
}
