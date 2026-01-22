<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;

class AuthorPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Author $author)
    {
        return true;
    }

    public function create(User $user)
    {
        // Any authenticated user can create an author (and its user account)
        return $user !== null;
    }

    public function update(User $user, Author $author)
    {
        // Only the linked user or admin may update
        return $user->id === $author->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Author $author)
    {
        return $user->id === $author->user_id || $user->hasRole('admin');
    }
}
