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

            'variants' => 'nullable|array',  // Variants are now optional
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|string|max:255',
            'variants.*.is_discounted' => 'nullable|boolean',
            'variants.*.discount_price' => 'nullable|numeric',
        ]);

        // Check if a product with the same name exists in the same category
        $existingProduct = Product::where('name', $request->name)
            ->where('category', $request->category)
            ->first();

        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product already added in this category!')->withInput();
        }

        // Create the product
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'category' => $validatedData['category'],
            'quantity' => $validatedData['quantity'],
            'stock' => $validatedData['stock'],
            'description' => $validatedData['description'] ?? null,
        ]);

        // Handle image upload if available
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = basename($imagePath);
            $product->save();
        }

        // Handle variants if provided
        if (!empty($validatedData['variants'])) {
            foreach ($validatedData['variants'] as $variant) {
                $product->variants()->create([
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'is_discounted' => $variant['is_discounted'] ?? false,
                    'discount_price' => $variant['discount_price'] ?? null,
                ]);
            }
        }

        // Redirect to product list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }


    // Show edit form for a product
    public function edit(Product $product)
    {
        $product->load('variants');
        return view('admin.products.edit', compact('product'));
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'variants' => 'nullable|array',
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|string|max:255',
            'variants.*.is_discounted' => 'nullable|boolean',
            'variants.*.discount_price' => 'nullable|numeric',
        ]);

        // Update product fields
        $product->update($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = basename($imagePath);
            $product->save();
        }

        // Handle variants (update existing, create new)
        $variantData = $request->input('variants', []);
        $existingVariantIds = collect($variantData)->pluck('id')->filter()->all();

        // Delete variants that were removed in the form
        $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

        foreach ($variantData as $variant) {
            if (isset($variant['id'])) {
                // Update existing variant
                $product->variants()->where('id', $variant['id'])->update([
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'is_discounted' => $variant['is_discounted'] ?? false,
                    'discount_price' => $variant['discount_price'] ?? null,
                ]);
            } else {
                // Create new variant
                $product->variants()->create([
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'is_discounted' => $variant['is_discounted'] ?? false,
                    'discount_price' => $variant['discount_price'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
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

    public function checkDiscount(Product $product)
    {
        $hasDiscount = $product->variants()->where('is_discounted', true)->exists();

        if ($hasDiscount) {
            return redirect()->back()->with('success', 'Discount is active for this product!');
        } else {
            return redirect()->back()->with('info', 'No discount currently active for this product.');
        }
    }
}
