@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Edit Product: {{ $product->name }}</h2>
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back to Products
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" readonly>
                    <p class="text-xs text-gray-500 mt-1">Auto-generated</p>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Regular Price (₦)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Discount Price (₦)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Leave empty if no discount</p>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category</label>
                <select name="category" id="category_select" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select a category</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->name }}" {{ old('category', $product->category) === $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                    @if(!in_array(old('category', $product->category), ($categories ?? collect())->pluck('name')->toArray()))
                        <option value="{{ old('category', $product->category) }}" selected>{{ old('category', $product->category) }}</option>
                    @endif
                    <option value="_custom">+ Add Custom Category</option>
                </select>
                <input type="text" name="custom_category" id="edit_custom_category" placeholder="Enter custom category name" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 hidden">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <!-- Product Flags -->
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <h3 class="font-medium text-gray-700 mb-3">Product Status & Flags</h3>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_discounted" value="1" {{ old('is_discounted', $product->is_discounted) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Has Discount</span>
                    </label>
                    
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <span class="text-sm text-gray-700">Featured Product</span>
                    </label>
                    
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_promo_product" value="1" {{ old('is_promo_product', $product->is_promo_product) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                        <span class="text-sm text-gray-700">Promo Product</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Product Variants Section -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4">Product Variants</h3>

                @foreach($product->variants as $i => $variant)
                    <div class="border p-4 rounded mb-4 bg-gray-50">
                        <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant->id }}">

                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input type="number" step="0.01" name="variants[{{ $i }}][price]" value="{{ $variant->price }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="text" name="variants[{{ $i }}][quantity]" value="{{ $variant->quantity }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discounted?</label>
                                <select name="variants[{{ $i }}][is_discounted]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="0" @selected(!$variant->is_discounted)>No</option>
                                    <option value="1" @selected($variant->is_discounted)>Yes</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>
                                <input type="number" step="0.01" name="variants[{{ $i }}][discount_price]" value="{{ $variant->discount_price }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                @endforeach

                <div id="new-variants-container"></div>

                <button type="button" onclick="addNewVariant()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    + Add Variant
                </button>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Product Image</label>
                <input type="file" name="image" class="w-full border border-gray-300 rounded-md px-3 py-2">

                @if ($product->image)
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-32 h-32 object-cover rounded">
                </div>
                @endif
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var variantIndex = {{ $product->variants->count() }};

    function addNewVariant() {
        var container = document.getElementById('new-variants-container');
        var html = '<div class="border p-4 rounded mb-4 bg-gray-100">' +
            '<div class="grid grid-cols-2 gap-4 mb-2">' +
                '<div>' +
                    '<label class="block text-sm font-medium text-gray-700 mb-1">Price</label>' +
                    '<input type="number" step="0.01" name="variants[' + variantIndex + '][price]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">' +
                '</div>' +
                '<div>' +
                    '<label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>' +
                    '<input type="number" name="variants[' + variantIndex + '][quantity]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">' +
                '</div>' +
            '</div>' +
            '<div class="grid grid-cols-2 gap-4">' +
                '<div>' +
                    '<label class="block text-sm font-medium text-gray-700 mb-1">Discounted?</label>' +
                    '<select name="variants[' + variantIndex + '][is_discounted]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">' +
                        '<option value="0">No</option>' +
                        '<option value="1">Yes</option>' +
                    '</select>' +
                '</div>' +
                '<div>' +
                    '<label class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>' +
                    '<input type="number" step="0.01" name="variants[' + variantIndex + '][discount_price]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">' +
                '</div>' +
            '</div>' +
        '</div>';
        
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }

    // Handle custom category toggle
    document.getElementById('category_select').addEventListener('change', function() {
        const customInput = document.getElementById('edit_custom_category');
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
        const categorySelect = document.getElementById('category_select');
        const customInput = document.getElementById('edit_custom_category');
        
        if (categorySelect.value === '_custom' && customInput.value.trim()) {
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
