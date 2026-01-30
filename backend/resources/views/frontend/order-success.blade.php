@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 md:px-20">
    <div class="max-w-2xl mx-auto">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Order Placed Successfully!</h1>
            <p class="text-gray-600 mt-2">Thank you for your purchase. Your order has been received.</p>
        </div>
        
        <!-- Order Details Card -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="bg-pink-600 text-white p-4">
                <div class="flex justify-between items-center">
                    <span class="font-semibold">Order #{{ $order->order_number }}</span>
                    <span class="text-sm">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Order Status -->
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <p class="font-semibold {{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($order->payment_status) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Status</p>
                        <p class="font-semibold text-gray-800">{{ ucfirst($order->status) }}</p>
                    </div>
                </div>
                
                @if($order->is_promo_order)
                    <div class="bg-purple-50 border border-purple-200 text-purple-800 p-4 rounded-lg">
                        <p class="font-semibold"><i class="fas fa-gift mr-2"></i>Promo Order</p>
                        <p class="text-sm mt-1">This order was placed using a winning promo code. Congratulations!</p>
                    </div>
                @endif
                
                <!-- Order Items -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Order Items</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center py-2 border-b last:border-0">
                                <div>
                                    <p class="font-medium">{{ $item->product_name }}</p>
                                    @if($item->variant_name)
                                        <p class="text-sm text-gray-500">{{ $item->variant_name }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="font-medium">₦{{ number_format($item->total_price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Price Summary -->
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>₦{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span>-₦{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>{{ $order->shipping_fee > 0 ? '₦' . number_format($order->shipping_fee, 2) : 'FREE' }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                        <span>Total</span>
                        <span class="text-pink-600">₦{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Shipping Address</h3>
                    <div class="text-gray-600">
                        <p>{{ $order->full_name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->city }}, {{ $order->state }}</p>
                        <p>{{ $order->country }}</p>
                        <p>Phone: {{ $order->phone }}</p>
                        <p>Email: {{ $order->email }}</p>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Payment Method</h3>
                    <p class="text-gray-600 capitalize">{{ $order->payment_method }}</p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
            </a>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors">
                <i class="fas fa-user mr-2"></i> View My Orders
            </a>
        </div>
        
        <!-- Email Notification -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>A confirmation email has been sent to <strong>{{ $order->email }}</strong></p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</div>
@endsection
