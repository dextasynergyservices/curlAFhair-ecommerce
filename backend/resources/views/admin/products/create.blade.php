@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Category *</label>
                    <select name="category" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ old('category') === $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                        <option value="_custom" {{ old('category') && !in_array(old('category'), $categories->pluck('name')->toArray()) ? 'selected' : '' }}>+ Add Custom Category</option>
                    </select>
                    <input type="text" name="custom_category" id="custom_category" value="{{ old('custom_category') }}" placeholder="Enter custom category name" 
                           class="w-full border rounded px-3 py-2 mt-2 focus:ring-2 focus:ring-blue-500 hidden">
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Quantity/Size *</label>
                    <input type="text" name="quantity" value="{{ old('quantity') }}" placeholder="e.g., 300ml, 500ml" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" required>
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" required>
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 font-medium">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" placeholder="Describe your product...">{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Pricing -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Pricing</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Regular Price (₦) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" required>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Discount Price (₦)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0" class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" placeholder="Leave empty if no discount">
                    @error('discount_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_discounted" value="1" {{ old('is_discounted') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Enable discount for this product</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Check this box to show the discount price on the storefront</p>
            </div>
        </div>

        <!-- Product Image -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Product Image</h3>
            
            <div>
                <label class="block text-gray-700 font-medium">Upload Image</label>
                <input type="file" name="image" accept="image/*" class="w-full mt-1 border rounded px-3 py-2">
                <p class="text-sm text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG, GIF, WEBP. Max size: 2MB</p>
            </div>
        </div>

        <!-- Product Settings -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Product Settings</h3>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Active</span>
                    <span class="ml-2 text-sm text-gray-500">(Product will be visible on the storefront)</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                    <span class="ml-2 text-gray-700">Featured Product</span>
                    <span class="ml-2 text-sm text-gray-500">(Will be highlighted on homepage)</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="is_promo_product" value="1" {{ old('is_promo_product') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Promo Product</span>
                    <span class="ml-2 text-sm text-gray-500">(Can be purchased with winning promo codes for FREE)</span>
                </label>
            </div>
        </div>

        <!-- Product Variants -->
        <div id="variant-section">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Product Variants (Optional)</h3>
            <p class="text-sm text-gray-500 mb-4">Add different sizes/quantities with different prices</p>

            <div id="new-variants-container"></div>

            <button type="button" onclick="addNewVariant()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i class="fas fa-plus mr-1"></i> Add Variant
            </button>
        </div>

        @verbatim
        <script>
            let variantIndex = 0;

            function addNewVariant() {
                const container = document.getElementById('new-variants-container');

                container.insertAdjacentHTML('beforeend', `
                    <div class="border p-4 rounded mb-4 bg-gray-50 relative" id="variant-${variantIndex}">
                        <button type="button" onclick="removeVariant(${variantIndex})" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <label class="block text-sm font-medium">Price (₦) *</label>
                                <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Quantity/Size *</label>
                                <input type="text" name="variants[${variantIndex}][quantity]" placeholder="e.g., 500ml" class="w-full border rounded px-3 py-2" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Discounted?</label>
                                <select name="variants[${variantIndex}][is_discounted]" class="w-full border rounded px-3 py-2">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Discount Price (₦)</label>
                                <input type="number" step="0.01" name="variants[${variantIndex}][discount_price]" class="w-full border rounded px-3 py-2">
                            </div>
                        </div>
                    </div>
                `);

                variantIndex++;
            }

            function removeVariant(index) {
                document.getElementById('variant-' + index).remove();
            }
        </script>
        @endverbatim

        <div class="flex justify-end gap-4 pt-6">
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Create Product</button>
        </div>
    </form>
</div>

<script>
    // Handle custom category toggle
    document.querySelector('select[name="category"]').addEventListener('change', function() {
        const customInput = document.getElementById('custom_category');
        if (this.value === '_custom') {
            customInput.classList.remove('hidden');
            customInput.required = true;
        } else {
            customInput.classList.add('hidden');
            customInput.required = false;
            customInput.value = '';
        }
    });

    // On form submit, if custom category is selected, use the custom value
    document.querySelector('form').addEventListener('submit', function(e) {
        const categorySelect = document.querySelector('select[name="category"]');
        const customInput = document.getElementById('custom_category');
        
        if (categorySelect.value === '_custom' && customInput.value.trim()) {
            // Create hidden input with the custom category value
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'category';
            hiddenInput.value = customInput.value.trim();
            this.appendChild(hiddenInput);
            categorySelect.removeAttribute('name');
        }
    });
</script>
@endsection
