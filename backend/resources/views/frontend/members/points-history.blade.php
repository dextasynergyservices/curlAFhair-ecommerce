@extends('layouts.members')

@section('content')
<div class="min-h-screen bg-pink-50 py-12">
    <div class="max-w-lg mx-auto px-4">
        
        <!-- Header -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-6">
            <div class="text-center mb-6">
                <a href="{{ route('dashboard') }}" class="inline-block text-pink-400 mb-4">
                    ← Back to Dashboard
                </a>
                <div class="text-5xl mb-4">📊</div>
                <h1 class="text-3xl font-bold text-pink-400">Points History</h1>
                <p class="text-gray-500 mt-2">Track your points activity</p>
            </div>
            
            <!-- Current Points -->
            <div class="bg-pink-400 rounded-2xl p-6 text-white text-center">
                <p class="text-sm uppercase tracking-wider mb-1">Current Balance</p>
                <p class="text-4xl font-bold">{{ number_format($user->loyalty_points ?? 0) }}</p>
                <p class="text-sm opacity-80 mt-1">points</p>
            </div>
        </div>
        
        <!-- Points Summary -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow p-4 text-center">
                <p class="text-2xl font-bold text-green-500">+{{ number_format($user->loyalty_points ?? 0) }}</p>
                <p class="text-sm text-gray-500">Total Earned</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 text-center">
                <p class="text-2xl font-bold text-red-400">-0</p>
                <p class="text-sm text-gray-500">Total Redeemed</p>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Transaction History</h2>
            
            <div class="space-y-4">
                @if(($user->loyalty_points ?? 0) > 0)
                    <!-- Sample transactions - in real app, these would come from a points_transactions table -->
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">Welcome Bonus</p>
                                <p class="text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="text-green-500 font-bold">+100</span>
                        </div>
                    </div>
                    
                    @foreach($user->orders->take(5) as $order)
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">Order #{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="text-green-500 font-bold">+{{ floor($order->total / 100) }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="text-4xl mb-4">🛒</div>
                        <p class="text-gray-500">No points activity yet</p>
                        <p class="text-sm text-gray-400 mt-2">Start shopping to earn points!</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-pink-400 text-white px-6 py-2 rounded-full font-semibold hover:bg-pink-500 transition-colors">
                            Shop Now
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- How Points Work -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">How Points Work</h2>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start gap-3">
                    <span class="text-pink-400">✓</span>
                    <span>Earn 1 point for every ₦100 spent on orders</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-pink-400">✓</span>
                    <span>Points are added after order completion</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-pink-400">✓</span>
                    <span>Points never expire as long as your account is active</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-pink-400">✓</span>
                    <span>Redeem points for discounts on future orders</span>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
