<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ArticleController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Article::class);
        return response()->json(Article::with('author','audiences')->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

        $data = $request->validate([
            'name' => 'required|string',
            'author_id' => 'required|integer|exists:authors,id',
        ]);

        $article = Article::create($data);
        return response()->json($article->load('author'), 201);
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);
        return response()->json($article->load('author','audiences','comments'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->only('name'));
        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return response()->json(['message' => 'deleted']);
    }
}
