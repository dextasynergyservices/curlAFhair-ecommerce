@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">User Details: {{ $user->name }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
                ← Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-center mb-4">
                @if($user->profile_photo_path)
                    <img class="h-24 w-24 rounded-full mx-auto object-cover" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    <div class="h-24 w-24 rounded-full bg-pink-600 flex items-center justify-center text-white text-3xl font-bold mx-auto">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h3 class="mt-4 text-xl font-semibold">{{ $user->name }}</h3>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>

            <div class="border-t pt-4 space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Role:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    @if($user->is_active ?? true)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </div>
                @if($user->phone)
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone:</span>
                    <span>{{ $user->phone }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Joined:</span>
                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                @if($user->email_verified_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">Verified:</span>
                    <span class="text-green-600">✓ {{ $user->email_verified_at->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="lg:col-span-2 space-y-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_orders'] }}</p>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-green-600">₦{{ number_format($stats['total_spent'], 2) }}</p>
                    <p class="text-gray-500 text-sm">Total Spent</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
                    <p class="text-gray-500 text-sm">Pending Orders</p>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold mb-4">Recent Orders</h4>
                @if($user->orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Order #</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-right">Total</th>
                                <th class="px-4 py-2 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($user->orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">{{ $order->order_number }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right">₦{{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-center py-4">No orders found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
