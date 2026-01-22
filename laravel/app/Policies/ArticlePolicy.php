<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Article $article)
    {
        return true;
    }

    public function create(User $user)
    {
        // only users who are authors may create articles
        return $user->author()->exists() || $user->hasRole('admin');
    }

    public function update(User $user, Article $article)
    {
        return ($user->author && $article->author_id === $user->author->id) || $user->hasRole('admin');
    }

    public function delete(User $user, Article $article)
    {
        return ($user->author && $article->author_id === $user->author->id) || $user->hasRole('admin');
    }
}
