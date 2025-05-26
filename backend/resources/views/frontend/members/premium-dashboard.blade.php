@extends('layouts.members')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                Hello, {{ $user->name }} <span class="ml-2 text-sm bg-green-100 text-green-700 px-2 py-1 rounded-full">Premium</span>
            </h1>
            <p class="text-gray-600 text-sm">Access your premium dashboard features below.</p>
        </div>

        <!-- Edit Profile Button -->
        <button wire:click="$dispatch('open-edit-profile')"
            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg">
            Edit Profile
        </button>
    </div>

    <!-- Notification Bell Dropdown -->
    @include('frontend.members.partials.notification-bell', ['user' => $user])

    <!-- Premium Features -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
        <div class="bg-white shadow rounded-lg p-4 self-start">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Order Status</h2>
            <ul class="text-sm text-gray-600 space-y-1">
                @forelse($recentActivities as $order)
                    <li>
                        Order #{{ $order->id }} -
                        <span class="font-semibold">{{ ucfirst($order->status) }}</span>
                        <span class="text-xs text-gray-500">({{ $order->created_at->diffForHumans() }})</span>
                    </li>
                @empty
                    <li>No recent orders.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-700 text-lg font-semibold mb-2">Orders Chart</h2>
            @if ($hasChartData)
                {!! $chart->container() !!}
            @else
                <p class="text-sm text-gray-500">Not enough data to generate chart.</p>
            @endif
        </div>
    </div>

    <!-- Edit Profile Modal Component -->
    @livewire('edit-profile', ['user' => $user])
</div>
@endsection

@section('scripts')
    @if ($hasChartData)
        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}
    @endif
@endsection
