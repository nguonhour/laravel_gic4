<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Audience;

class AudiencePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Audience $audience)
    {
        return true;
    }

    public function create(User $user)
    {
        // any authenticated user can subscribe (create audience)
        return $user !== null;
    }

    public function delete(User $user, Audience $audience)
    {
        // user who subscribed or admin can remove
        return $user->id === $audience->user_id || $user->hasRole('admin');
    }
}
