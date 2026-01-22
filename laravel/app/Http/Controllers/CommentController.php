<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CommentController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Comment::class);
        $q = Comment::with('user','commentable');
        if ($search = $request->query('search')) {
            $q->where('name', 'like', "%{$search}%");
        }
        return response()->json($q->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);

        $data = $request->validate([
            'name' => 'required|string',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $comment = Comment::create($data);
        return response()->json($comment->load('user','commentable'), 201);
    }

    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);
        return response()->json($comment->load('user','commentable'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $comment->update($request->only('name'));
        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'deleted']);
    }
}
