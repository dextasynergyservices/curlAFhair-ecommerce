@extends('layouts.app')

@section('content')
<div class="relative w-full bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}'); min-height: 300px;">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center" style="padding-top: 60px;">
        <h1 class="text-white text-3xl md:text-4xl font-bold">{{ $product->name }}</h1>
    </div>
</div>

<!-- Breadcrumb -->
<div class="bg-gray-50 py-3 px-4 md:px-20">
    <div class="max-w-6xl mx-auto">
        <nav class="text-sm">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-pink-600">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-pink-600">Shop</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<section class="py-12 px-4 md:px-20 bg-white">
    <div class="max-w-6xl mx-auto">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div>
                <div class="relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="rounded-lg w-full h-[500px] object-cover" 
                             id="mainImage">
                    @else
                        <div class="w-full h-[500px] bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-400 text-xl">No Image Available</span>
                        </div>
                    @endif
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->is_discounted && $product->discount_price)
                            <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded">
                                -{{ $product->discount_percentage }}% OFF
                            </span>
                        @endif
                        @if($product->is_promo_product)
                            <span class="bg-purple-500 text-white text-sm font-bold px-3 py-1 rounded">
                                PROMO ITEM
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col space-y-6">
                <div>
                    <span class="text-sm text-pink-600 font-medium">{{ $product->category }}</span>
                    <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">SKU: {{ $product->sku }}</p>
                </div>

                <!-- Price -->
                <div class="border-b pb-6">
                    @if($product->is_discounted && $product->discount_price)
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-bold text-pink-600">₦{{ number_format($product->discount_price, 2) }}</span>
                            <span class="text-xl text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                            <span class="bg-red-100 text-red-600 text-sm font-semibold px-2 py-1 rounded">
                                Save ₦{{ number_format($product->price - $product->discount_price, 2) }}
                            </span>
                        </div>
                    @else
                        <span class="text-3xl font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="flex items-center gap-2">
                    @if($product->in_stock)
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-green-600 font-medium">In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="text-red-600 font-medium">Out of Stock</span>
                    @endif
                </div>

                <!-- Description -->
                <div>
                    <h3 class="font-semibold text-lg mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description ?? 'No description available for this product.' }}
                    </p>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Variants Selection -->
                    @if($product->variants->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Size/Variant</label>
                            <select name="variant_id" id="variantSelect" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                <option value="">Default ({{ $product->quantity }})</option>
                                @foreach($product->variants as $variant)
                                    <option value="{{ $variant->id }}" 
                                            data-price="{{ $variant->is_discounted && $variant->discount_price ? $variant->discount_price : $variant->price }}"
                                            data-original-price="{{ $variant->price }}"
                                            data-discounted="{{ $variant->is_discounted && $variant->discount_price ? 'true' : 'false' }}">
                                        {{ $variant->quantity }} - 
                                        @if($variant->is_discounted && $variant->discount_price)
                                            ₦{{ number_format($variant->discount_price, 2) }} 
                                            (was ₦{{ number_format($variant->price, 2) }})
                                        @else
                                            ₦{{ number_format($variant->price, 2) }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center border border-gray-300 rounded-lg w-fit">
                            <button type="button" onclick="decrementQuantity()" class="px-4 py-3 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="w-16 text-center border-x border-gray-300 py-3 focus:outline-none">
                            <button type="button" onclick="incrementQuantity()" class="px-4 py-3 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" 
                            class="w-full bg-black text-white py-4 rounded-lg font-semibold hover:bg-pink-600 transition-colors {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ !$product->in_stock ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart mr-2"></i>
                        {{ $product->in_stock ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                </form>

                <!-- Additional Info -->
                <div class="border-t pt-6 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-truck text-pink-600"></i>
                        <span>Free shipping on orders over ₦50,000</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-undo text-pink-600"></i>
                        <span>30-day return policy</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-pink-600"></i>
                        <span>Secure payment</span>
                    </div>
                </div>

                <!-- Share -->
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">Share:</span>
                    <a href="#" class="text-gray-400 hover:text-pink-600"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-600"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-600"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-600"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-12 px-4 md:px-20 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold mb-8">Related Products</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('product.show', $relatedProduct->slug) }}" class="block">
                        <div class="relative overflow-hidden aspect-square">
                            @if($relatedProduct->image)
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-full object-cover rounded-t-lg group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                            
                            @if($relatedProduct->is_discounted && $relatedProduct->discount_price)
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    -{{ $relatedProduct->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <a href="{{ route('product.show', $relatedProduct->slug) }}" class="block">
                            <h3 class="font-semibold text-gray-800 hover:text-pink-600 transition-colors">
                                {{ $relatedProduct->name }}
                            </h3>
                        </a>
                        <p class="text-gray-500 text-sm mt-1">{{ $relatedProduct->category }}</p>
                        
                        <div class="mt-2 flex items-center gap-2">
                            @if($relatedProduct->is_discounted && $relatedProduct->discount_price)
                                <span class="font-bold text-pink-600">₦{{ number_format($relatedProduct->discount_price, 2) }}</span>
                                <span class="text-sm text-gray-400 line-through">₦{{ number_format($relatedProduct->price, 2) }}</span>
                            @else
                                <span class="font-bold text-gray-900">₦{{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<hr>

<script>
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        const currentValue = parseInt(input.value);
        if (currentValue < max) {
            input.value = currentValue + 1;
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
</script>
@endsection
