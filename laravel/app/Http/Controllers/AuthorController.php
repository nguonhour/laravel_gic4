<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AuthorController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Author::class);
        return response()->json(Author::with('user','articles')->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Author::class);

        $request->validate([
            'name' => 'required|string',
            'user.email' => 'required|email',
            'user.name' => 'required|string',
            'user.password' => 'required|string',
        ]);

        $uData = $request->input('user');
        $user = User::firstOrCreate(['email' => $uData['email']], [
            'name' => $uData['name'],
            'password' => bcrypt($uData['password']),
        ]);

        $author = Author::create(['name' => $request->name, 'user_id' => $user->id]);
        return response()->json($author->load('user'), 201);
    }

    public function show(Author $author)
    {
        $this->authorize('view', $author);
        return response()->json($author->load('user','articles'));
    }

    public function update(Request $request, Author $author)
    {
        $this->authorize('update', $author);
        $author->update($request->only('name'));
        return response()->json($author);
    }

    public function destroy(Author $author)
    {
        $this->authorize('delete', $author);
        $author->delete();
        return response()->json(['message' => 'deleted']);
    }
}
