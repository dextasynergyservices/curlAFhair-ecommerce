@extends('layouts.app')

@section('content')
<div class="relative h-[20vh] bg-cover bg-center" style="background-image: url('{{ asset('images/shop.jpeg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center">
        <h1 class="text-white text-3xl md:text-4xl font-bold">Checkout</h1>
    </div>
</div>

<!-- Breadcrumb -->
<div class="bg-gray-50 py-3 px-4 md:px-20">
    <div class="max-w-6xl mx-auto">
        <nav class="text-sm">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-pink-600">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-pink-600">Cart</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-800">Checkout</span>
        </nav>
    </div>
</div>

<!-- Checkout Section -->
<section class="py-12 px-4 md:px-20 bg-gray-50 min-h-[60vh]">
    <div class="max-w-6xl mx-auto">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Shipping & Payment Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-xl font-semibold mb-6 flex items-center">
                            <span class="w-8 h-8 bg-pink-600 text-white rounded-full flex items-center justify-center text-sm mr-3">1</span>
                            Shipping Information
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->name ?? '') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+234..."
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                <input type="text" name="address" value="{{ old('address') }}" required
                                       placeholder="House number, street name"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('address') border-red-500 @enderror">
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="city" value="{{ old('city') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                <select name="state" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 @error('state') border-red-500 @enderror">
                                    <option value="">Select State</option>
                                    <option value="Abia" {{ old('state') == 'Abia' ? 'selected' : '' }}>Abia</option>
                                    <option value="Adamawa" {{ old('state') == 'Adamawa' ? 'selected' : '' }}>Adamawa</option>
                                    <option value="Akwa Ibom" {{ old('state') == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                    <option value="Anambra" {{ old('state') == 'Anambra' ? 'selected' : '' }}>Anambra</option>
                                    <option value="Bauchi" {{ old('state') == 'Bauchi' ? 'selected' : '' }}>Bauchi</option>
                                    <option value="Bayelsa" {{ old('state') == 'Bayelsa' ? 'selected' : '' }}>Bayelsa</option>
                                    <option value="Benue" {{ old('state') == 'Benue' ? 'selected' : '' }}>Benue</option>
                                    <option value="Borno" {{ old('state') == 'Borno' ? 'selected' : '' }}>Borno</option>
                                    <option value="Cross River" {{ old('state') == 'Cross River' ? 'selected' : '' }}>Cross River</option>
                                    <option value="Delta" {{ old('state') == 'Delta' ? 'selected' : '' }}>Delta</option>
                                    <option value="Ebonyi" {{ old('state') == 'Ebonyi' ? 'selected' : '' }}>Ebonyi</option>
                                    <option value="Edo" {{ old('state') == 'Edo' ? 'selected' : '' }}>Edo</option>
                                    <option value="Ekiti" {{ old('state') == 'Ekiti' ? 'selected' : '' }}>Ekiti</option>
                                    <option value="Enugu" {{ old('state') == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                                    <option value="FCT" {{ old('state') == 'FCT' ? 'selected' : '' }}>FCT</option>
                                    <option value="Gombe" {{ old('state') == 'Gombe' ? 'selected' : '' }}>Gombe</option>
                                    <option value="Imo" {{ old('state') == 'Imo' ? 'selected' : '' }}>Imo</option>
                                    <option value="Jigawa" {{ old('state') == 'Jigawa' ? 'selected' : '' }}>Jigawa</option>
                                    <option value="Kaduna" {{ old('state') == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <option value="Kano" {{ old('state') == 'Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Katsina" {{ old('state') == 'Katsina' ? 'selected' : '' }}>Katsina</option>
                                    <option value="Kebbi" {{ old('state') == 'Kebbi' ? 'selected' : '' }}>Kebbi</option>
                                    <option value="Kogi" {{ old('state') == 'Kogi' ? 'selected' : '' }}>Kogi</option>
                                    <option value="Kwara" {{ old('state') == 'Kwara' ? 'selected' : '' }}>Kwara</option>
                                    <option value="Lagos" {{ old('state') == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Nasarawa" {{ old('state') == 'Nasarawa' ? 'selected' : '' }}>Nasarawa</option>
                                    <option value="Niger" {{ old('state') == 'Niger' ? 'selected' : '' }}>Niger</option>
                                    <option value="Ogun" {{ old('state') == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                                    <option value="Ondo" {{ old('state') == 'Ondo' ? 'selected' : '' }}>Ondo</option>
                                    <option value="Osun" {{ old('state') == 'Osun' ? 'selected' : '' }}>Osun</option>
                                    <option value="Oyo" {{ old('state') == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Plateau" {{ old('state') == 'Plateau' ? 'selected' : '' }}>Plateau</option>
                                    <option value="Rivers" {{ old('state') == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Sokoto" {{ old('state') == 'Sokoto' ? 'selected' : '' }}>Sokoto</option>
                                    <option value="Taraba" {{ old('state') == 'Taraba' ? 'selected' : '' }}>Taraba</option>
                                    <option value="Yobe" {{ old('state') == 'Yobe' ? 'selected' : '' }}>Yobe</option>
                                    <option value="Zamfara" {{ old('state') == 'Zamfara' ? 'selected' : '' }}>Zamfara</option>
                                </select>
                                @error('state')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <select name="country" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                    <option value="Nigeria" selected>Nigeria</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea name="notes" rows="3" placeholder="Any special instructions for delivery..."
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-xl font-semibold mb-6 flex items-center">
                            <span class="w-8 h-8 bg-pink-600 text-white rounded-full flex items-center justify-center text-sm mr-3">2</span>
                            Payment Method
                        </h2>
                        
                        <div class="space-y-4">
                            @forelse($paymentMethods as $key => $method)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors payment-option">
                                    <input type="radio" name="payment_method" value="{{ $key }}" class="mr-4" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium">{{ $method['name'] }}</span>
                                            @if($key === 'paystack')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/Paystack_Logo.png" alt="Paystack" class="h-6">
                                            @elseif($key === 'paypal')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-6">
                                            @elseif($key === 'stripe')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" class="h-6">
                                            @elseif($key === 'bank_transfer')
                                                <span class="text-2xl">🏦</span>
                                            @elseif($key === 'cod')
                                                <span class="text-2xl">💵</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">{{ $method['description'] }}</p>
                                    </div>
                                </label>
                            @empty
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-700 text-sm">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        No payment methods are currently available. Please contact support.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                        
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border sticky top-24">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold">Order Summary</h2>
                        </div>
                        
                        <div class="p-4">
                            <!-- Cart Items -->
                            <div class="space-y-4 max-h-60 overflow-y-auto">
                                @foreach($cart->items as $item)
                                    <div class="flex gap-3">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">No Img</span>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="font-medium text-sm">{{ $item->product->name }}</p>
                                            @if($item->variant)
                                                <p class="text-xs text-gray-500">{{ $item->variant->quantity }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x ₦{{ number_format($item->unit_price, 2) }}</p>
                                        </div>
                                        <span class="font-medium text-sm">₦{{ number_format($item->total_price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr class="my-4">
                            
                            <!-- Pricing -->
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>₦{{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($appliedPromo)
                                    <div class="flex justify-between text-green-600 bg-green-50 p-2 rounded -mx-2">
                                        <span><i class="fas fa-gift mr-1"></i> Promo: {{ $appliedPromo['code'] }}</span>
                                        <span>-₦{{ number_format($discount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-purple-600 font-semibold">
                                        <span>🎉 FREE ORDER!</span>
                                    </div>
                                @elseif($appliedCoupon)
                                    <div class="flex justify-between text-green-600 bg-green-50 p-2 rounded -mx-2">
                                        <span><i class="fas fa-tag mr-1"></i> {{ $appliedCoupon['code'] }}</span>
                                        <span>-₦{{ number_format($discount, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span>{{ $shippingFee > 0 ? '₦' . number_format($shippingFee, 2) : 'FREE' }}</span>
                                </div>
                                
                                <hr>
                                
                                <div class="flex justify-between text-xl font-bold">
                                    <span>Total</span>
                                    <span class="text-pink-600">₦{{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            <!-- Place Order Button -->
                            <button type="submit" 
                                    class="w-full bg-pink-600 text-white py-4 rounded-lg font-semibold hover:bg-pink-700 transition-colors mt-6"
                                    id="placeOrderBtn">
                                <i class="fas fa-lock mr-2"></i> Place Order
                            </button>
                            
                            <p class="text-xs text-gray-500 text-center mt-4">
                                By placing your order, you agree to our Terms & Conditions and Privacy Policy.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<hr>

<script>
    // Highlight selected payment option
    document.querySelectorAll('.payment-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('border-pink-500', 'bg-pink-50');
            });
            if (this.checked) {
                this.closest('.payment-option').classList.add('border-pink-500', 'bg-pink-50');
            }
        });
    });
    
    // Trigger on page load for default selected
    document.querySelector('.payment-option input[type="radio"]:checked')?.closest('.payment-option').classList.add('border-pink-500', 'bg-pink-50');
    
    // Form submission
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        document.getElementById('placeOrderBtn').disabled = true;
        document.getElementById('placeOrderBtn').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
    });
</script>
@endsection
