@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Order #{{ $order->id }}</h2>

    <table class="min-w-full text-sm text-left border">
        <thead>
            <tr class="border-b text-gray-700 dark:text-gray-200">
                <th class="px-4 py-2">Field</th>
                <th class="px-4 py-2">Details</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 dark:text-gray-300">
            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-4 py-2 font-semibold">Status</td>
                <td class="px-4 py-2">
                    <span class="px-3 py-1 rounded-full {{ getStatusClass($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
            </tr>
            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-4 py-2 font-semibold">Customer</td>
                <td class="px-4 py-2">{{ $order->user->name ?? 'Guest' }}</td>
            </tr>
            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-4 py-2 font-semibold">Total</td>
                <td class="px-4 py-2">${{ number_format($order->total, 2) }}</td>
            </tr>
            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-4 py-2 font-semibold">Placed on</td>
                <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            <!-- Additional order details here -->
        </tbody>
    </table>
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
