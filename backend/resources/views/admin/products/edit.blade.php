@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Edit Product: {{ $product->name }}</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Price</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Quantity</label>
            <input type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Product Variants</h3>

        @foreach($product->variants as $i => $variant)
            <div class="border p-4 rounded mb-4 bg-gray-50">
                <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant->id }}">

                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div>
                        <label class="block text-sm font-medium">Price</label>
                        <input type="number" step="0.01" name="variants[{{ $i }}][price]" value="{{ $variant->price }}" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Quantity</label>
                        <input type="text" name="variants[{{ $i }}][quantity]" value="{{ $variant->quantity }}" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Discounted?</label>
                        <select name="variants[{{ $i }}][is_discounted]" class="w-full border rounded px-3 py-2">
                            <option value="0" @selected(!$variant->is_discounted)>No</option>
                            <option value="1" @selected($variant->is_discounted)>Yes</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Discount Price</label>
                        <input type="number" step="0.01" name="variants[{{ $i }}][discount_price]" value="{{ $variant->discount_price }}" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>
        @endforeach

        <!-- JS-powered section for new variants -->
        <div id="new-variants-container"></div>

        <button type="button" onclick="addNewVariant()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Add Variant
        </button>
    </div>

    <script>
        let variantIndex = {{ $product->variants->count() }};

        function addNewVariant() {
            const container = document.getElementById('new-variants-container');

            container.insertAdjacentHTML('beforeend', `
                <div class="border p-4 rounded mb-4 bg-gray-100">
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div>
                            <label class="block text-sm font-medium">Price</label>
                            <input type="number" step="0.01" name="variants[\${variantIndex}][price]" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Quantity</label>
                            <input type="number" name="variants[\${variantIndex}][quantity]" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Discounted?</label>
                            <select name="variants[\${variantIndex}][is_discounted]" class="w-full border rounded px-3 py-2">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Discount Price</label>
                            <input type="number" step="0.01" name="variants[\${variantIndex}][discount_price]" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>
            `);

            variantIndex++;
        }
    </script>


        <div>
            <label class="block font-medium">Product Image</label>
            <input type="file" name="image" class="w-full mt-1">

            @if ($product->image)
            <div class="mt-4">
                <img src="{{ asset('storage/products/'.$product->image) }}" alt="Product Image" class="w-32 h-32 object-cover">
            </div>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection
