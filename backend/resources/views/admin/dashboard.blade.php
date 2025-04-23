@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Orders -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Total Orders</h3>
        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $totalOrders }}</p>
    </div>

    <!-- Total Sales -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Total Sales</h3>
        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">${{ number_format($totalSales, 2) }}</p>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Pending Orders</h3>
        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $pendingOrders }}</p>
    </div>

    <!-- Shipped Orders -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Shipped Orders</h3>
        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $shippedOrders }}</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.orders.index') }}" class="bg-blue-600 text-white py-3 px-5 rounded-lg text-center hover:bg-blue-700 transition">View Orders</a>
        <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white py-3 px-5 rounded-lg text-center hover:bg-green-700 transition">Add Product</a>
        <a href="{{ route('admin.users.index') }}" class="bg-purple-600 text-white py-3 px-5 rounded-lg text-center hover:bg-purple-700 transition">Manage Users</a>
    </div>
</div>

<!-- Activity Feed -->
<div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Recent Activity</h3>
        <!-- Filter Dropdown -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
        <label for="log" class="block text-gray-600 dark:text-gray-300 mb-1 font-medium">Filter by Type:</label>
        <select name="log" id="log" onchange="this.form.submit()" class="w-full sm:w-1/3 p-2 rounded-lg border dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">All</option>
            <option value="order" @selected(request('log') === 'order')>Orders</option>
            <option value="user" @selected(request('log') === 'user')>Users</option>
        </select>
    </form>

    <!-- Activity Feed List -->
    <ul class="space-y-3">
        @forelse ($activities as $activity)
            <li class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        <span class="font-semibold">
                            {{ $activity->causer?->name ?? 'System' }}
                        </span>
                        {{ $activity->description }}
                        @if ($activity->subject)
                            <span class="italic text-gray-500 dark:text-gray-400">
                                ({{ class_basename($activity->subject_type) }} ID: {{ $activity->subject_id }})
                            </span>
                        @endif
                    </p>

                    @if ($activity->properties?->has('attributes'))
                        <details class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <summary class="cursor-pointer">View Changes</summary>
                            <div class="pl-4 mt-1">
                                @foreach ($activity->properties['attributes'] as $key => $value)
                                    @php
                                        $old = $activity->properties['old'][$key] ?? null;
                                    @endphp
                                    <p>
                                        <strong>{{ $key }}</strong>:
                                        <span class="text-red-500 line-through">{{ $old }}</span>
                                        →
                                        <span class="text-green-500">{{ $value }}</span>
                                    </p>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                    {{ $activity->created_at->diffForHumans() }}
                </span>
            </li>
        @empty
            <li class="text-gray-500 dark:text-gray-400">No recent activity.</li>
        @endforelse
    </ul>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $activities->appends(['log' => request('log')])->links() }}
    </div>

</div>

<!-- Recent Orders -->
<div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Recent Orders</h3>
    <table class="min-w-full text-sm text-left">
        <thead>
            <tr class="border-b text-gray-700 dark:text-gray-200">
                <th class="px-4 py-2">Order #</th>
                <th class="px-4 py-2">Customer</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Placed</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 dark:text-gray-300">
            @foreach ($recentOrders as $order)
                <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-2">#{{ $order->id }}</td>
                    <td class="px-4 py-2">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-4 py-2">${{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                    <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-500 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
