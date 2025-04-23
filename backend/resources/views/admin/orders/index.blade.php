@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">All Orders</h2>

    {{-- Filter Form --}}
    <form method="GET" class="mb-6">
        <label for="status" class="mr-2 text-sm text-gray-700 dark:text-gray-300">Filter by Status:</label>
        <select name="status" id="status" class="px-3 py-1 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" onchange="this.form.submit()">
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Orders Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead>
                <tr class="border-b text-gray-700 dark:text-gray-200">
                    <th class="px-4 py-2">Order #</th>
                    <th class="px-4 py-2">Customer</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Placed</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-300">
                @forelse ($orders as $order)
                    <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-4 py-2 capitalize">
                            <span class="px-3 py-1 rounded-full {{ getStatusClass($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-500 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->appends(['status' => request('status')])->links() }}
    </div>
</div>
@endsection

@php
    // Helper function to return the correct status class
    function getStatusClass($status) {
        switch ($status) {
            case 'pending':
                return 'bg-yellow-300 text-yellow-800';
            case 'processing':
                return 'bg-blue-300 text-blue-800';
            case 'shipped':
                return 'bg-green-300 text-green-800';
            case 'delivered':
                return 'bg-teal-300 text-teal-800';
            case 'cancelled':
                return 'bg-red-300 text-red-800';
            default:
                return 'bg-gray-300 text-gray-800';
        }
    }
@endphp
