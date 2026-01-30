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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Coupon</h1>
            <span class="font-mono font-bold text-lg bg-gray-100 px-3 py-1 rounded">{{ $coupon->code }}</span>
        </div>

        <!-- Usage Stats -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Usage Statistics</h3>
            <div class="flex gap-6 text-sm">
                <div>
                    <span class="text-gray-500">Times Used:</span>
                    <span class="font-semibold ml-1">{{ $coupon->times_used }}</span>
                </div>
                @if($coupon->usage_limit)
                    <div>
                        <span class="text-gray-500">Remaining:</span>
                        <span class="font-semibold ml-1">{{ max(0, $coupon->usage_limit - $coupon->times_used) }}</span>
                    </div>
                @endif
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Code -->
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                    Coupon Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary uppercase"
                       placeholder="e.g., SAVE20" required>
                <p class="text-xs text-gray-500 mt-1">Code will be automatically converted to uppercase</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="2" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                          placeholder="Optional description for internal use">{{ old('description', $coupon->description) }}</textarea>
            </div>

            <!-- Type & Value -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                        Discount Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" onchange="updateValueLabel()" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (₦)</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                        <span id="valueLabel">Discount Value</span> <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" 
                           step="0.01" min="0" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="e.g., 10" required>
                </div>
            </div>

            <!-- Minimum Amount & Maximum Discount -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="minimum_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount (₦)</label>
                    <input type="number" name="minimum_amount" id="minimum_amount" value="{{ old('minimum_amount', $coupon->minimum_amount) }}" 
                           step="0.01" min="0" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for no minimum">
                </div>
                <div id="maxDiscountWrapper">
                    <label for="maximum_discount" class="block text-sm font-medium text-gray-700 mb-1">Maximum Discount (₦)</label>
                    <input type="number" name="maximum_discount" id="maximum_discount" value="{{ old('maximum_discount', $coupon->maximum_discount) }}" 
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
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" 
                           min="1" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for unlimited">
                    @if($coupon->times_used > 0)
                        <p class="text-xs text-amber-600 mt-1">Already used {{ $coupon->times_used }} times</p>
                    @endif
                </div>
                <div>
                    <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">Usage Limit Per User</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}" 
                           min="1" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Leave empty for unlimited">
                </div>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" 
                           value="{{ old('starts_at', $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to start immediately</p>
                </div>
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" 
                           value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                    @if($coupon->expires_at && $coupon->expires_at->isPast())
                        <p class="text-xs text-red-600 mt-1">This coupon has expired</p>
                    @endif
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="ml-2 text-sm text-gray-700">Active (coupon can be used)</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-between items-center">
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                        Delete Coupon
                    </button>
                </form>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.coupons.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg">
                        Update Coupon
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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
