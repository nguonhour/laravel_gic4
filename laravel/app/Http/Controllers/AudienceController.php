<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AudienceController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Audience::class);
        return response()->json(Audience::with('user','article')->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Audience::class);

        $data = $request->validate([
            'name' => 'required|string',
            'article_id' => 'required|integer|exists:articles,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $aud = Audience::create($data);
        return response()->json($aud->load('user','article'), 201);
    }

    public function show(Audience $audience)
    {
        $this->authorize('view', $audience);
        return response()->json($audience->load('user','article','comments'));
    }

    public function destroy(Audience $audience)
    {
        $this->authorize('delete', $audience);
        $audience->delete();
        return response()->json(['message' => 'deleted']);
    }
}
