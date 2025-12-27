<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // abort_unless(auth()->user()->can(abilities: 'products.create'), 403);
        abort_unless(request()->user()->can(abilities: 'products.create'), 403);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Get a single product
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return response()->json($product);
    }

    // Update a product
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    // Delete a product
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
