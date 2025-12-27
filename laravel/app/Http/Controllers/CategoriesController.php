<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
class CategoriesController extends Controller
{
    // Get all categories
    public function index()
    {
        $categories = Categories::all();
        return response()->json($categories);
    }

    // Create a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // abort_unless(auth()->user()->can('categories.create'), 403);
        abort_unless(request()->user()->can(abilities: 'categories.create'), 403);


        $category = Categories::create($validated);
        return response()->json($category, 201);
    }

    // Get a single category
    public function show($categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        return response()->json($category);
    }

    // Update a category
    public function update(Request $request, $categoryId)
    {
        $category = Categories::findOrFail($categoryId);
        
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
