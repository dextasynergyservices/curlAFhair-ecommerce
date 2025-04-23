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
