@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Welcome Card -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-6">
            <div class="text-center mb-6">
                <div class="text-5xl mb-4">👋</div>
                <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 mt-2">Manage your account and orders</p>
            </div>
            
            <!-- Account Info -->
            <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Email</span>
                        <span class="font-semibold text-gray-800">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Account Type</span>
                        <span class="font-semibold text-gray-800 capitalize">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Member Since</span>
                        <span class="font-semibold text-gray-800">{{ Auth::user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Upgrade Banner -->
            <div class="bg-gradient-to-r from-pink-400 to-pink-500 rounded-2xl p-6 text-white text-center">
                <p class="text-lg font-semibold mb-2">🌟 Become a Member!</p>
                <p class="text-sm opacity-90 mb-4">Unlock exclusive rewards, earn points on every purchase, and get special discounts.</p>
                <a href="{{ route('shop.index') }}" class="inline-block bg-white text-pink-500 px-6 py-2 rounded-full font-semibold hover:bg-pink-50 transition-colors">
                    Start Shopping
                </a>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <p class="text-3xl font-bold text-gray-800">{{ $orders->count() }}</p>
                <p class="text-gray-500">Orders</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <p class="text-3xl font-bold text-gray-800">{{ $savedItems->count() }}</p>
                <p class="text-gray-500">Saved Items</p>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📦 Recent Orders</h2>
            <div class="space-y-3">
                @forelse ($orders->take(5) as $order)
                    <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">Order #{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">₦{{ number_format($order->total, 2) }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No orders yet. Start shopping!</p>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Notifications -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🔔 Notifications</h2>
            <div class="space-y-3">
                @forelse ($notifications->take(5) as $note)
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm text-gray-700">{{ $note->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No notifications yet</p>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection

