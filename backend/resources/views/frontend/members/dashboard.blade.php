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

@extends('layouts.members')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16"> <br><br><br>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-8 text-center">Welcome, {{ $user->name }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Info -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">👤 Profile Info</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
            </div>

            <!-- Orders -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">📦 Order History</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">You have {{ $user->orders->count() }} orders</p>
            </div>

            <!-- Saved Items -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">💾 Saved Items</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->savedItems->count() }} saved items</p>
            </div>

            <!-- Wishlist -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">📝 Wishlist</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->wishlists->count() }} wishlisted items</p>
            </div>

            <!-- Notifications -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center md:col-span-3">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">🔔 Notifications</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->notifications->count() }} notifications</p>
            </div>
        </div>
    </div>
@endsection

