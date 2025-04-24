@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div>
            <label class="block text-gray-700">Price</label>
            <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div>
            <label class="block text-gray-700">Category</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div>
            <label class="block text-gray-700">Quantity</label>
            <input type="text" name="quantity" value="{{ old('quantity') }}" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div>
            <label class="block text-gray-700">Stock</label>
            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div>
            <label class="block text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2 mt-1">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700">Product Image</label>
            <input type="file" name="image" class="w-full mt-1">
        </div>

        <div id="variant-section" class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Product Variants</h3>

        <div id="new-variants-container"></div>

        <button type="button" onclick="addNewVariant()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Add Variant
        </button>
    </div>

    @verbatim
    <script>
        let variantIndex = 0;

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
                            <input type="text" name="variants[\${variantIndex}][quantity]" class="w-full border rounded px-3 py-2">
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
    @endverbatim

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Create Product</button>
        </div>
    </form>
</div>
@endsection
