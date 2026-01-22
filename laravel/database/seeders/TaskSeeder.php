<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Audience;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Create author users
        $sokUser = User::firstOrCreate(['email' => 'sok@example.test'], [
            'name' => 'sok123',
            'password' => Hash::make('password'),
        ]);

        $saoUser = User::firstOrCreate(['email' => 'sao@example.test'], [
            'name' => 'sao',
            'password' => Hash::make('password'),
        ]);

        $daraUser = User::firstOrCreate(['email' => 'dara@example.test'], [
            'name' => 'd.dara',
            'password' => Hash::make('password'),
        ]);

        // Create audience users
        $veasna = User::firstOrCreate(['email' => 'veasna@example.test'], ['name' => 'veasna', 'password' => Hash::make('password')]);
        $samnang = User::firstOrCreate(['email' => 'samnang@example.test'], ['name' => 'samnang', 'password' => Hash::make('password')]);
        $ratana = User::firstOrCreate(['email' => 'ratana@example.test'], ['name' => 'ratana', 'password' => Hash::make('password')]);

        // Authors
        $sok = Author::firstOrCreate(['user_id' => $sokUser->id], ['name' => 'Sok']);
        $sao = Author::firstOrCreate(['user_id' => $saoUser->id], ['name' => 'Sao']);
        $dara = Author::firstOrCreate(['user_id' => $daraUser->id], ['name' => 'Dara']);

        // Articles
        $a1 = Article::firstOrCreate(['name' => 'Climate changes in the last 3 years', 'author_id' => $sok->id]);
        $a2 = Article::firstOrCreate(['name' => 'Global warming is in its critical stage', 'author_id' => $sok->id]);
        $a3 = Article::firstOrCreate(['name' => 'Computers in the next generation', 'author_id' => $sao->id]);
        $a4 = Article::firstOrCreate(['name' => 'Quantum computers, is it coming?', 'author_id' => $sao->id]);
        $a5 = Article::firstOrCreate(['name' => 'Chemistry in nature form', 'author_id' => $dara->id]);
        $a6 = Article::firstOrCreate(['name' => 'The origin of water', 'author_id' => $dara->id]);

        // Audiences (subscriptions) - create audience rows pointing to article and user
        Audience::firstOrCreate(['article_id' => $a3->id, 'user_id' => $samnang->id], ['name' => 'Samnang']);
        Audience::firstOrCreate(['article_id' => $a5->id, 'user_id' => $samnang->id], ['name' => 'Samnang']);
        Audience::firstOrCreate(['article_id' => $a6->id, 'user_id' => $samnang->id], ['name' => 'Samnang']);

        Audience::firstOrCreate(['article_id' => $a1->id, 'user_id' => $veasna->id], ['name' => 'Veasna']);
        Audience::firstOrCreate(['article_id' => $a6->id, 'user_id' => $veasna->id], ['name' => 'Veasna']);
        Audience::firstOrCreate(['article_id' => $a4->id, 'user_id' => $veasna->id], ['name' => 'Veasna']);

        Audience::firstOrCreate(['article_id' => $a1->id, 'user_id' => $ratana->id], ['name' => 'Ratana']);
        Audience::firstOrCreate(['article_id' => $a2->id, 'user_id' => $ratana->id], ['name' => 'Ratana']);

        // Comments examples
        Comment::firstOrCreate([
            'commentable_type' => Article::class,
            'commentable_id' => $a1->id,
            'user_id' => $sokUser->id,
        ], ['name' => 'Thank you to all the subscribers']);

        Comment::firstOrCreate([
            'commentable_type' => Author::class,
            'commentable_id' => $sao->id,
            'user_id' => $samnang->id,
        ], ['name' => 'Your article is amazing']);

        Comment::firstOrCreate([
            'commentable_type' => Audience::class,
            'commentable_id' => 1,
            'user_id' => $saoUser->id,
        ], ['name' => 'Welcome to read my article']);

        Comment::firstOrCreate([
            'commentable_type' => Article::class,
            'commentable_id' => $a4->id,
            'user_id' => $veasna->id,
        ], ['name' => "I can't wait this thing happening"]);

        $this->command->info('TaskSeeder: authors, articles, audiences and comments created.');
    }
}
