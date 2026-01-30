@extends('layouts.app')

@section('content')
<div class="relative h-[20vh] bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center">
        <h1 class="text-white text-3xl md:text-4xl font-bold">Shopping Cart</h1>
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
            <span class="text-gray-800">Cart</span>
        </nav>
    </div>
</div>

<!-- Cart Section -->
<section class="py-12 px-4 md:px-20 bg-white min-h-[60vh]">
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

        @if($cart && $cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold">Cart Items ({{ $cart->items_count }})</h2>
                        </div>
                        
                        <div class="divide-y">
                            @foreach($cart->items as $item)
                                <div class="p-4 flex flex-col sm:flex-row gap-4" id="cart-item-{{ $item->id }}">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-24 h-24 object-cover rounded-lg">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-lg">
                                                <span class="text-gray-400 text-xs">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <a href="{{ route('product.show', $item->product->slug) }}" 
                                                   class="font-semibold text-gray-800 hover:text-pink-600">
                                                    {{ $item->product->name }}
                                                </a>
                                                @if($item->variant)
                                                    <p class="text-sm text-gray-500">Size: {{ $item->variant->quantity }}</p>
                                                @endif
                                                
                                                <!-- Price -->
                                                <div class="mt-1">
                                                    @if($item->has_discount)
                                                        <span class="text-pink-600 font-semibold">₦{{ number_format($item->unit_price, 2) }}</span>
                                                        <span class="text-sm text-gray-400 line-through ml-2">₦{{ number_format($item->original_price, 2) }}</span>
                                                    @else
                                                        <span class="text-gray-900 font-semibold">₦{{ number_format($item->unit_price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Remove Button -->
                                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Quantity & Subtotal -->
                                        <div class="flex items-center justify-between mt-3">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-gray-300 rounded">
                                                    <button type="button" onclick="updateQuantity(this, -1)" class="px-3 py-1 hover:bg-gray-100">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" 
                                                           class="w-12 text-center border-x border-gray-300 py-1 focus:outline-none text-sm">
                                                    <button type="button" onclick="updateQuantity(this, 1)" class="px-3 py-1 hover:bg-gray-100">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                <button type="submit" class="text-sm text-pink-600 hover:underline">Update</button>
                                            </form>
                                            
                                            <span class="font-semibold text-gray-900">
                                                ₦{{ number_format($item->total_price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Clear Cart -->
                        <div class="p-4 border-t bg-gray-50">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i> Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border sticky top-24">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold">Order Summary</h2>
                        </div>
                        
                        <div class="p-4 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>₦{{ number_format($cart->subtotal, 2) }}</span>
                            </div>
                            
                            <!-- Applied Coupon/Promo -->
                            @php
                                $appliedCoupon = session('applied_coupon');
                                $appliedPromo = session('applied_promo');
                            @endphp
                            
                            @if($appliedPromo)
                                <div class="flex justify-between text-green-600 bg-green-50 p-2 rounded">
                                    <span>
                                        <i class="fas fa-gift mr-1"></i> Winning Code: {{ $appliedPromo['code'] }}
                                    </span>
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex justify-between text-green-600 font-semibold">
                                    <span>Discount (100%)</span>
                                    <span>-₦{{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                            @elseif($appliedCoupon)
                                <div class="flex justify-between text-green-600 bg-green-50 p-2 rounded">
                                    <span>
                                        <i class="fas fa-tag mr-1"></i> Coupon: {{ $appliedCoupon['code'] }}
                                    </span>
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex justify-between text-green-600 font-semibold">
                                    <span>Discount</span>
                                    <span>-₦{{ number_format($appliedCoupon['discount'], 2) }}</span>
                                </div>
                            @endif
                            
                            <!-- Shipping -->
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span>{{ $appliedPromo ? 'FREE' : 'Calculated at checkout' }}</span>
                            </div>
                            
                            <hr>
                            
                            <!-- Total -->
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                @php
                                    $total = $cart->subtotal;
                                    if ($appliedPromo) {
                                        $total = 0;
                                    } elseif ($appliedCoupon) {
                                        $total -= $appliedCoupon['discount'];
                                    }
                                @endphp
                                <span class="text-pink-600">₦{{ number_format(max(0, $total), 2) }}</span>
                            </div>
                            
                            <!-- Coupon Code Form -->
                            @if(!$appliedCoupon && !$appliedPromo)
                                <div class="border-t pt-4 mt-4">
                                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="space-y-2">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700">Have a coupon?</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="coupon_code" placeholder="Enter coupon code" 
                                                   class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                                                Apply
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Promo Code Form -->
                                <div class="border-t pt-4 mt-4">
                                    <form action="{{ route('cart.promo.apply') }}" method="POST" class="space-y-2">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-gift text-purple-500 mr-1"></i> Have a winning promo code?
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text" name="promo_code" placeholder="Enter winning code" 
                                                   class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded text-sm hover:bg-purple-700">
                                                Apply
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            
                            <!-- Checkout Button -->
                            <a href="{{ route('checkout.index') }}" 
                               class="block w-full bg-pink-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-pink-700 transition-colors mt-4">
                                Proceed to Checkout
                            </a>
                            
                            <!-- Continue Shopping -->
                            <a href="{{ route('shop.index') }}" class="block text-center text-gray-600 hover:text-pink-600 text-sm mt-2">
                                <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600">Your cart is empty</h3>
                <p class="text-gray-500 mt-2">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="inline-block mt-6 bg-pink-600 text-white px-8 py-3 rounded-lg hover:bg-pink-700 transition-colors">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</section>

<hr>

<script>
    function updateQuantity(button, change) {
        const input = button.parentElement.querySelector('input[name="quantity"]');
        const currentValue = parseInt(input.value);
        const max = parseInt(input.getAttribute('max'));
        const newValue = currentValue + change;
        
        if (newValue >= 1 && newValue <= max) {
            input.value = newValue;
        }
    }
</script>
@endsection
