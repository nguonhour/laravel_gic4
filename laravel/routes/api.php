<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Categories;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\CommentController;

// Force JSON responses for all API routes
Route::middleware('api')->group(function () {

// POST /api/login → returns access token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = $request->user();
    $token = $user->createToken('mobile')->accessToken;

    return response()->json(['token' => $token]);
});

// Protected API routes
Route::middleware('auth:api')->group(function () {
    // GET /api/me → returns user + roles
    Route::get('/me', function (Request $request) {
        return $request->user()->load('roles.permissions');
    });

    // Category Routes
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::get('/categories/{categoryId}', [CategoriesController::class, 'show']);
    Route::patch('/categories/{categoryId}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{categoryId}', [CategoriesController::class, 'destroy']);
    Route::get('/categories/{categoryId}/products', [CategoriesController::class, 'products']);

    // Product Routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{productId}', [ProductController::class, 'show']);
    Route::patch('/products/{productId}', [ProductController::class, 'update']);
    Route::delete('/products/{productId}', [ProductController::class, 'destroy']);

    // Teacher exercise routes: authors, articles, audiences, comments
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    Route::patch('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);
    Route::patch('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

    Route::get('/audiences', [AudienceController::class, 'index']);
    Route::post('/audiences', [AudienceController::class, 'store']);
    Route::get('/audiences/{audience}', [AudienceController::class, 'show']);
    Route::delete('/audiences/{audience}', [AudienceController::class, 'destroy']);

    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{comment}', [CommentController::class, 'show']);
    Route::patch('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // PATCH /api/categories/{id}/status → assigned staff only (policy)
    Route::patch('/categories/{category}/status', function (Request $request, Categories $category) {
        Gate::authorize('updateStatus', $category);

        $category->update(['status' => $request->status]);
        return response()->json(['message' => 'Status updated']);
    });
});

}); // End of api middleware group
