@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
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
            <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="w-full border rounded px-3 py-2 mt-1" required>
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

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Create Product</button>
        </div>
    </form>
</div>
@endsection
