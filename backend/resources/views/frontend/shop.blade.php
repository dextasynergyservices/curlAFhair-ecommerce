@extends('layouts.app')

@section('content')
<div class="relative w-full bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}'); min-height: 500px;">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center md:px-10 px-10" style="padding-top: 50px;">
        <h1 class="text-white text-4xl md:text-5xl font-bold mb-4">Our Shop</h1>
        <p class="text-gray-200 text-lg max-w-xl">Discover our amazing collection of hair care products</p>
    </div>
</div>

<!-- Shop Section -->
<section class="py-12 px-4 md:px-20 bg-white">
    <div class="container mx-auto max-w-7xl">
        <!-- Header & Filters -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <h1 class="text-2xl font-semibold">
                <span class="font-bold text-black">Shop</span> 
                <span class="text-gray-600">| buy our moisturising solution</span>
            </h1>
            
            <!-- Filters -->
            <form action="{{ route('shop.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                <!-- Search -->
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search products..." 
                           class="border border-gray-300 rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </button>
                </div>
                
                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Sort -->
                <select name="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                </select>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('product.show', $product->slug) }}" class="block relative">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden aspect-square">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-lg">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if($product->is_discounted && $product->discount_price)
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    @endif
                                    @if($product->is_promo_product)
                                        <span class="bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            PROMO
                                        </span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            FEATURED
                                        </span>
                                    @endif
                                    @if(!$product->in_stock)
                                        <span class="bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded">
                                            OUT OF STOCK
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Quick Add Button -->
                                <div class="absolute bottom-3 left-0 right-0 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" 
                                                class="w-full bg-black text-white py-2 rounded-lg hover:bg-pink-600 transition-colors {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ !$product->in_stock ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Product Info -->
                        <div class="p-4">
                            <a href="{{ route('product.show', $product->slug) }}" class="block">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <p class="text-gray-500 text-sm mt-1">{{ $product->category }}</p>
                            
                            <!-- Price -->
                            <div class="mt-2 flex items-center gap-2">
                                @if($product->is_discounted && $product->discount_price)
                                    <span class="text-lg font-bold text-pink-600">₦{{ number_format($product->discount_price, 2) }}</span>
                                    <span class="text-sm text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            
                            <!-- Variants -->
                            @if($product->variants->count() > 0)
                                <div class="mt-2 text-sm text-gray-500">
                                    @foreach($product->variants->take(2) as $variant)
                                        <span class="inline-block mr-2">
                                            {{ $variant->quantity }}:
                                            @if($variant->is_discounted && $variant->discount_price)
                                                <span class="text-pink-600">₦{{ number_format($variant->discount_price, 2) }}</span>
                                            @else
                                                ₦{{ number_format($variant->price, 2) }}
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600">No products found</h3>
                <p class="text-gray-500 mt-2">Try adjusting your search or filter to find what you're looking for.</p>
            </div>
        @endif
    </div>
</section>

<hr>
@endsection
