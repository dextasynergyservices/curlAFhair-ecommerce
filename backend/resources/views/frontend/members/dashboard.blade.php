@extends('layouts.members')

@section('content')
<div class="min-h-screen bg-pink-50 py-12">
    <div class="max-w-lg mx-auto px-4">
        
        <!-- Loyalty Account Card -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            
            <!-- Crown & Title -->
            <div class="text-center mb-8">
                <div class="text-5xl mb-4">👑</div>
                <h1 class="text-3xl font-bold text-pink-400">Loyalty Account</h1>
            </div>
            
            <!-- Member Info Card -->
            <div class="bg-pink-50 rounded-2xl p-6 mb-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Member Name</span>
                        <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Member ID</span>
                        <span class="font-semibold text-gray-800">AF{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Member Since</span>
                        <span class="font-semibold text-gray-800">{{ $user->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Total Points Card -->
            <div class="bg-pink-400 rounded-2xl p-8 mb-6 text-center text-white">
                <p class="text-sm uppercase tracking-wider mb-2">Total Points</p>
                <p class="text-6xl font-bold mb-2">{{ number_format($user->loyalty_points ?? 0) }}</p>
                <p class="text-sm opacity-90">Keep earning to unlock rewards!</p>
            </div>
            
            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <a href="{{ route('member.rewards.redeem') }}" 
                   class="bg-pink-400 text-white text-center py-3 px-6 rounded-full font-semibold hover:bg-pink-500 transition-colors">
                    Redeem
                </a>
                <a href="{{ route('member.points.history') }}" 
                   class="border-2 border-pink-400 text-pink-400 text-center py-3 px-6 rounded-full font-semibold hover:bg-pink-50 transition-colors">
                    History
                </a>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-pink-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-pink-400">{{ $user->orders->count() }}</p>
                    <p class="text-xs text-gray-600">Orders</p>
                </div>
                <div class="bg-pink-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-pink-400">{{ $user->savedItems->count() }}</p>
                    <p class="text-xs text-gray-600">Saved</p>
                </div>
                <div class="bg-pink-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-pink-400">{{ $user->wishlists->count() }}</p>
                    <p class="text-xs text-gray-600">Wishlist</p>
                </div>
            </div>
            
            <!-- How to Earn Points -->
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-center">💡 How to Earn Points</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-center gap-3">
                        <span class="bg-pink-100 text-pink-500 rounded-full w-8 h-8 flex items-center justify-center font-bold">1</span>
                        <span>Earn 1 point for every ₦100 spent</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="bg-pink-100 text-pink-500 rounded-full w-8 h-8 flex items-center justify-center font-bold">2</span>
                        <span>Get 50 bonus points on your birthday</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="bg-pink-100 text-pink-500 rounded-full w-8 h-8 flex items-center justify-center font-bold">3</span>
                        <span>Refer a friend and earn 100 points</span>
                    </li>
                </ul>
            </div>
            
        </div>
        
        <!-- Recent Activity -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🔔 Recent Activity</h2>
            <div class="space-y-3">
                @forelse ($user->notifications->take(5) as $notification)
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No recent activity</p>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection

