<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{

    public function viewAny(User $user)
    {
        return $user->hasRole('owner');
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user?->id || $user->hasRole('moderator') || $user->hasRole('admin');
    }

    public function rate(User $user, Comment $comment)
    {
        return $user->id != $comment->user?->id;
    }
}
