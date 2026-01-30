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
                <div class="text-5xl mb-4">🎁</div>
                <h1 class="text-3xl font-bold text-pink-400">Redeem Rewards</h1>
                <p class="text-gray-500 mt-2">Use your points to unlock exclusive rewards</p>
            </div>
            
            <!-- Current Points -->
            <div class="bg-pink-400 rounded-2xl p-6 text-white text-center mb-6">
                <p class="text-sm uppercase tracking-wider mb-1">Your Points</p>
                <p class="text-4xl font-bold">{{ number_format($user->loyalty_points ?? 0) }}</p>
            </div>
        </div>
        
        <!-- Available Rewards -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Available Rewards</h2>
            
            <div class="space-y-4">
                <!-- Reward 1 -->
                <div class="border border-gray-200 rounded-2xl p-4 flex justify-between items-center {{ ($user->loyalty_points ?? 0) >= 500 ? 'bg-white' : 'bg-gray-50 opacity-60' }}">
                    <div>
                        <h3 class="font-semibold text-gray-800">₦500 Off</h3>
                        <p class="text-sm text-gray-500">500 points</p>
                    </div>
                    <button class="bg-pink-400 text-white px-4 py-2 rounded-full text-sm font-semibold {{ ($user->loyalty_points ?? 0) >= 500 ? 'hover:bg-pink-500' : 'cursor-not-allowed' }}" 
                            {{ ($user->loyalty_points ?? 0) < 500 ? 'disabled' : '' }}>
                        Redeem
                    </button>
                </div>
                
                <!-- Reward 2 -->
                <div class="border border-gray-200 rounded-2xl p-4 flex justify-between items-center {{ ($user->loyalty_points ?? 0) >= 1000 ? 'bg-white' : 'bg-gray-50 opacity-60' }}">
                    <div>
                        <h3 class="font-semibold text-gray-800">₦1,000 Off</h3>
                        <p class="text-sm text-gray-500">1,000 points</p>
                    </div>
                    <button class="bg-pink-400 text-white px-4 py-2 rounded-full text-sm font-semibold {{ ($user->loyalty_points ?? 0) >= 1000 ? 'hover:bg-pink-500' : 'cursor-not-allowed' }}"
                            {{ ($user->loyalty_points ?? 0) < 1000 ? 'disabled' : '' }}>
                        Redeem
                    </button>
                </div>
                
                <!-- Reward 3 -->
                <div class="border border-gray-200 rounded-2xl p-4 flex justify-between items-center {{ ($user->loyalty_points ?? 0) >= 2500 ? 'bg-white' : 'bg-gray-50 opacity-60' }}">
                    <div>
                        <h3 class="font-semibold text-gray-800">₦3,000 Off</h3>
                        <p class="text-sm text-gray-500">2,500 points</p>
                    </div>
                    <button class="bg-pink-400 text-white px-4 py-2 rounded-full text-sm font-semibold {{ ($user->loyalty_points ?? 0) >= 2500 ? 'hover:bg-pink-500' : 'cursor-not-allowed' }}"
                            {{ ($user->loyalty_points ?? 0) < 2500 ? 'disabled' : '' }}>
                        Redeem
                    </button>
                </div>
                
                <!-- Reward 4 -->
                <div class="border border-gray-200 rounded-2xl p-4 flex justify-between items-center {{ ($user->loyalty_points ?? 0) >= 5000 ? 'bg-white' : 'bg-gray-50 opacity-60' }}">
                    <div>
                        <h3 class="font-semibold text-gray-800">Free Product (Up to ₦10,000)</h3>
                        <p class="text-sm text-gray-500">5,000 points</p>
                    </div>
                    <button class="bg-pink-400 text-white px-4 py-2 rounded-full text-sm font-semibold {{ ($user->loyalty_points ?? 0) >= 5000 ? 'hover:bg-pink-500' : 'cursor-not-allowed' }}"
                            {{ ($user->loyalty_points ?? 0) < 5000 ? 'disabled' : '' }}>
                        Redeem
                    </button>
                </div>
                
                <!-- Reward 5 -->
                <div class="border border-pink-300 rounded-2xl p-4 flex justify-between items-center bg-pink-50 {{ ($user->loyalty_points ?? 0) >= 10000 ? '' : 'opacity-60' }}">
                    <div>
                        <h3 class="font-semibold text-pink-600">🌟 VIP Status + ₦20,000 Credit</h3>
                        <p class="text-sm text-gray-500">10,000 points</p>
                    </div>
                    <button class="bg-pink-500 text-white px-4 py-2 rounded-full text-sm font-semibold {{ ($user->loyalty_points ?? 0) >= 10000 ? 'hover:bg-pink-600' : 'cursor-not-allowed' }}"
                            {{ ($user->loyalty_points ?? 0) < 10000 ? 'disabled' : '' }}>
                        Redeem
                    </button>
                </div>
            </div>
            
            <!-- Info -->
            <div class="mt-6 bg-gray-50 rounded-xl p-4">
                <p class="text-sm text-gray-600 text-center">
                    💡 Rewards are applied as discount codes to your next order
                </p>
            </div>
        </div>
        
    </div>
</div>
@endsection
