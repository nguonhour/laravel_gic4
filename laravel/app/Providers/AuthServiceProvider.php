<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Author;
use App\Models\Article;
use App\Models\Audience;
use App\Models\Comment;
use App\Policies\AuthorPolicy;
use App\Policies\ArticlePolicy;
use App\Policies\AudiencePolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Author::class, AuthorPolicy::class);
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Audience::class, AudiencePolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
