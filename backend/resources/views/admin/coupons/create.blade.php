@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Coupons
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Coupon</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <!-- Code -->
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                    Coupon Code <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary uppercase"
                           placeholder="e.g., SAVE20" required>
                    <button type="button" onclick="generateCode()" class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg text-sm">
                        Generate
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Code will be automatically converted to uppercase</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="2" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                          placeholder="Optional description for internal use">{{ old('description') }}</textarea>
            </div>

            <!-- Type & Value -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                        Discount Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" onchange="updateValueLabel()" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₦)</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                        <span id="valueLabel">Discount Value</span> <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="value" id="value" value="{{ old('value') }}" 
                           step="0.01" min="0" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="e.g., 10" required>
                </div>
            </div>

            <!-- Minimum Amount & Maximum Discount -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="minimum_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount (₦)</label>
                    <input type="number" name="minimum_amount" id="minimum_amount" value="{{ old('minimum_amount') }}" 
                           step="0.01" min="0" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for no minimum">
                </div>
                <div id="maxDiscountWrapper">
                    <label for="maximum_discount" class="block text-sm font-medium text-gray-700 mb-1">Maximum Discount (₦)</label>
                    <input type="number" name="maximum_discount" id="maximum_discount" value="{{ old('maximum_discount') }}" 
                           step="0.01" min="0" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Cap for percentage discounts">
                    <p class="text-xs text-gray-500 mt-1">Only applies to percentage discounts</p>
                </div>
            </div>

            <!-- Usage Limits -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Total Usage Limit</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" 
                           min="1" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for unlimited">
                </div>
                <div>
                    <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">Usage Limit Per User</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user') }}" 
                           min="1" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for unlimited">
                </div>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to start immediately</p>
                </div>
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="ml-2 text-sm text-gray-700">Active (coupon can be used)</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.coupons.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg">
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('code').value = code;
}

function updateValueLabel() {
    const type = document.getElementById('type').value;
    const label = document.getElementById('valueLabel');
    const maxWrapper = document.getElementById('maxDiscountWrapper');
    
    if (type === 'percentage') {
        label.textContent = 'Percentage (%)';
        maxWrapper.style.display = 'block';
    } else {
        label.textContent = 'Amount (₦)';
        maxWrapper.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateValueLabel);
</script>
@endsection
