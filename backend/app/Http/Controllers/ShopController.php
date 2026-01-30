<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page with all active products
     */
    public function index(Request $request)
    {
        $query = Product::with('variants')->active();

        // Category filter
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(10);
        $categories = Product::active()->distinct()->pluck('category');

        return view('frontend.shop', compact('products', 'categories'));
    }

    /**
     * Display the product detail page
     */
    public function show($slug)
    {
        $product = Product::with('variants')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::with('variants')
            ->active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }

    /**
     * Display the landing page with featured products
     */
    public function landing()
    {
        $featuredProducts = Product::with('variants')
            ->active()
            ->featured()
            ->limit(6)
            ->get();

        $latestProducts = Product::with('variants')
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $promoProducts = Product::with('variants')
            ->active()
            ->promo()
            ->limit(3)
            ->get();

        return view('frontend.landing', compact('featuredProducts', 'latestProducts', 'promoProducts'));
    }
}
