@extends('layouts.members')

@section('content')
<div class="container mx-auto px-4 py-8"> <br><br><br><br><br><br>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                Welcome, {{ $user->name }}
            </h1>
            <p class="text-gray-600 text-sm">Your Member Dashboard</p>
        </div>
    </div>

    <!-- Notification Bell Dropdown -->
    @include('frontend.members.partials.notification-bell', ['user' => $user])

    <!-- Dashboard Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <div class="bg-white shadow rounded-lg p-4 self-start min-h-[120px]">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Profile</h2>
            <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
            <p class="text-sm text-gray-600">Joined: {{ $user->created_at->format('M d, Y') }}</p>
             <!-- Edit Profile Button -->
            {{-- <button wire:click="$set('showEditModal', true)" class="btn btn-primary">Edit Profile</button> --}}

            <!-- Modal -->
            {{-- @if($showEditModal)
                <div x-data x-show="$wire.showEditModal" x-cloak class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                        @livewire('edit-profile', ['user' => auth()->user()])
                    </div>
                </div>
            @endif --}}
        </div>

        <div class="bg-white shadow rounded-lg p-4 min-h-[120px]">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Order History</h2>
            <ul class="text-sm text-gray-600 space-y-1">
                @forelse($orders as $order)
                    <li>
                        Order #{{ $order->id }} -
                        <span class="font-semibold">{{ ucfirst($order->status) }}</span>
                        <span class="text-xs text-gray-500">({{ $order->created_at->diffForHumans() }})</span>
                    </li>
                @empty
                    <li>No orders yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white shadow rounded-lg p-4 min-h-[120px]">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Wishlist</h2>
            <p class="text-sm text-gray-600">Items: {{ $wishlist->count() }}</p>
        </div>

        <div class="bg-white shadow rounded-lg p-4 min-h-[120px]">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Saved Items</h2>
            <p class="text-sm text-gray-600">Items: {{ $savedItems->count() }}</p>
        </div>
    </div>

    <!-- Edit Profile Modal Component -->
    @livewire('edit-profile', ['user' => $user])
</div>
@endsection
