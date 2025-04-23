@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Add New Product</h2>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-800 p-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Price</label>
            <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Quantity</label>
            <input type="text" name="quantity" value="{{ old('quantity') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Stock</label>
            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Product Image</label>
            <input type="file" name="image" class="w-full mt-1">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add Product
            </button>
        </div>
    </form>
</div>
@endsection
