<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        // show all products
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Create a product
    public function create()
    {
        return view('admin.products.create');
    }

    // Store a new product
    public function store(Request $request)
    {
        // Validate and create product logic
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public'); // stores in storage/app/public/products
        $validatedData['image'] = $path;
    }

        Product::create($validatedData);

        // Redirect to product list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // Show edit form for a product
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        // Validate and update product logic
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|string|max:255',
            'stock' => 'required|numeric',
        ]);

        // Update the product data
        $product->update($validatedData);

        // Redirect to product list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // Toogle Product
    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product status updated successfully!');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
