<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
class CategoriesController extends Controller
{
    use AuthorizesRequests;
    // Get all categories
    public function index()
    {
        $this->authorize('viewAny', Categories::class);
        
        $categories = Categories::all();
        return response()->json($categories);
    }

    // Create a new category
    public function store(Request $request)
    {
        $this->authorize('create', Categories::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Categories::create($validated);
        return response()->json($category, 201);
    }

    // Get a single category
    public function show($categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        $this->authorize('view', $category);
        
        return response()->json($category);
    }

    // Update a category
    public function update(Request $request, $categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    // Delete a category
    public function destroy($categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        $this->authorize('delete', $category);
        
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    // Get all products for a specific category
    public function products($categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        $products = $category->products;
        return response()->json($products);
    }
}
