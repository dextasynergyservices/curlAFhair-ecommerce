<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        // show all products
        $products = Product::with('variants')->orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    // Create a product
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    // Store a new product
    public function store(Request $request)
    {
        // Validate and create product logic
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'is_discounted' => 'boolean',
            'category' => 'required|string|max:255',
            'custom_category' => 'nullable|string|max:255',
            'quantity' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'is_promo_product' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'variants' => 'nullable|array',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|string|max:255',
            'variants.*.is_discounted' => 'nullable|boolean',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
        ]);

        // Handle custom category - if user selected "_custom", use the custom_category value
        $categoryName = $validatedData['category'];
        if ($categoryName === '_custom' && !empty($validatedData['custom_category'])) {
            $categoryName = trim($validatedData['custom_category']);
            
            // Create the category if it doesn't exist
            $existingCategory = Category::where('name', $categoryName)->first();
            if (!$existingCategory) {
                Category::create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        // Check if a product with the same name exists in the same category
        $existingProduct = Product::where('name', $request->name)
            ->where('category', $categoryName)
            ->first();

        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product already added in this category!')->withInput();
        }

        // Create the product
        $product = Product::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'sku' => 'PRD-' . strtoupper(Str::random(8)),
            'price' => $validatedData['price'],
            'discount_price' => $validatedData['discount_price'] ?? null,
            'is_discounted' => $request->has('is_discounted'),
            'category' => $categoryName,
            'quantity' => $validatedData['quantity'],
            'stock' => $validatedData['stock'],
            'description' => $validatedData['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : true, // Default active
            'is_promo_product' => $request->has('is_promo_product'),
            'is_featured' => $request->has('is_featured'),
        ]);

        // Handle image upload if available
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
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
        $categories = Category::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'is_discounted' => 'boolean',
            'category' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_promo_product' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'variants' => 'nullable|array',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|string|max:255',
            'variants.*.is_discounted' => 'nullable|boolean',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
        ]);

        // Update product fields
        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'is_discounted' => $request->has('is_discounted'),
            'category' => $validated['category'],
            'quantity' => $validated['quantity'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
            'is_promo_product' => $request->has('is_promo_product'),
            'is_featured' => $request->has('is_featured'),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
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


    // Toggle Product Status
    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product status updated successfully!');
    }

    // Toggle Featured Status
    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Featured status updated!');
    }

    // Toggle Promo Status
    public function togglePromo(Product $product)
    {
        $product->is_promo_product = !$product->is_promo_product;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Promo status updated!');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function checkDiscount(Product $product)
    {
        $hasVariantDiscount = $product->variants()->where('is_discounted', true)->exists();
        $hasProductDiscount = $product->is_discounted && $product->discount_price;

        if ($hasProductDiscount || $hasVariantDiscount) {
            return redirect()->back()->with('success', 'Discount is active for this product!');
        } else {
            return redirect()->back()->with('info', 'No discount currently active for this product.');
        }
    }
}
