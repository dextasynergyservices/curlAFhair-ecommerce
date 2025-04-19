{{-- <x-app-layout> --}}
    {{-- @extends('layouts.app')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
                <p class="text-black">I am a Dashboard</p>
            </div>
        </div>
    </div> --}}
{{-- </x-app-layout> --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Welcome, {{ Auth::user()->name }}</h1>

    <!-- Notifications -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Recent Notifications</h2>
        <ul class="bg-white shadow-md rounded-lg p-4 space-y-2">
            @forelse ($notifications as $note)
                <li class="text-sm text-gray-700">{{ $note->message }}</li>
            @empty
                <li class="text-sm text-gray-500">No notifications yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Orders -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Recent Orders</h2>
        <ul class="bg-white shadow-md rounded-lg p-4 space-y-2">
            @forelse ($orders as $order)
                <li class="text-sm text-gray-700">
                    Order #{{ $order->order_number }} - ${{ $order->total }} - {{ $order->status }}
                </li>
            @empty
                <li class="text-sm text-gray-500">No orders yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Saved Items -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Saved Items</h2>
        <ul class="bg-white shadow-md rounded-lg p-4 space-y-2">
            @forelse ($savedItems as $item)
                <li class="text-sm text-gray-700">{{ $item->item_name }} ({{ $item->item_sku }})</li>
            @empty
                <li class="text-sm text-gray-500">No saved items yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Wishlist -->
    <div>
        <h2 class="text-xl font-semibold mb-2">Wishlist</h2>
        <ul class="bg-white shadow-md rounded-lg p-4 space-y-2">
            @forelse ($wishlists as $wish)
                <li class="text-sm text-gray-700">{{ $wish->item_name }} ({{ $wish->item_sku }})</li>
            @empty
                <li class="text-sm text-gray-500">No items in wishlist yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

