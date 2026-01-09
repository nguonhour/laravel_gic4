<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    // Get all products
    public function index()
    {
        $this->authorize('viewAny', Product::class);
        // Gate::authorize('viewAny', Product::class);
        
        $products = Product::all();
        return response()->json($products);
    }

    // Create a new product
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Get a single product
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('view', $product);
        
        return response()->json($product);
    }

    // Update a product
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('update', $product);
        
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
        $this->authorize('delete', $product);
        
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
