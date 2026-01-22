<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Comment $comment)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user !== null;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }
}
