@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Coupons</h1>
            <p class="text-gray-600">Manage discount coupons for your store</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Coupon
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-gray-500 text-sm">Total Coupons</div>
            <div class="text-2xl font-bold">{{ $coupons->total() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-gray-500 text-sm">Active Coupons</div>
            <div class="text-2xl font-bold text-green-600">{{ $coupons->where('is_active', true)->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-gray-500 text-sm">Percentage Type</div>
            <div class="text-2xl font-bold text-blue-600">{{ $coupons->where('type', 'percentage')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-gray-500 text-sm">Fixed Type</div>
            <div class="text-2xl font-bold text-purple-600">{{ $coupons->where('type', 'fixed')->count() }}</div>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-mono font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $coupon->code }}</span>
                            </div>
                            @if($coupon->description)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($coupon->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coupon->type === 'percentage')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Percentage</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Fixed Amount</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ₦{{ number_format($coupon->value) }}
                            @endif
                            @if($coupon->minimum_amount)
                                <div class="text-xs text-gray-500">Min: ₦{{ number_format($coupon->minimum_amount) }}</div>
                            @endif
                            @if($coupon->maximum_discount && $coupon->type === 'percentage')
                                <div class="text-xs text-gray-500">Max: ₦{{ number_format($coupon->maximum_discount) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $coupon->times_used }} / {{ $coupon->usage_limit ?? '∞' }}</div>
                            @if($coupon->usage_limit_per_user)
                                <div class="text-xs text-gray-500">{{ $coupon->usage_limit_per_user }} per user</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                @if($coupon->starts_at && $coupon->expires_at)
                                    {{ $coupon->starts_at->format('M d') }} - {{ $coupon->expires_at->format('M d, Y') }}
                                @elseif($coupon->expires_at)
                                    Expires: {{ $coupon->expires_at->format('M d, Y') }}
                                @elseif($coupon->starts_at)
                                    Starts: {{ $coupon->starts_at->format('M d, Y') }}
                                @else
                                    <span class="text-gray-500">No limit</span>
                                @endif
                            </div>
                            @if($coupon->expires_at && $coupon->expires_at->isPast())
                                <span class="text-xs text-red-500">Expired</span>
                            @elseif($coupon->starts_at && $coupon->starts_at->isFuture())
                                <span class="text-xs text-yellow-500">Not started</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="focus:outline-none">
                                    @if($coupon->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 hover:bg-red-200">Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <p>No coupons found</p>
                            <a href="{{ route('admin.coupons.create') }}" class="text-primary hover:underline mt-2 inline-block">Create your first coupon</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($coupons->hasPages())
        <div class="mt-4">
            {{ $coupons->links() }}
        </div>
    @endif
</div>
@endsection
