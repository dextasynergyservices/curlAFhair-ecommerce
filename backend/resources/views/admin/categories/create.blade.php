@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Add New Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back to Categories
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

    <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="e.g., Hair Care, Conditioners" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Optional description for this category">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-md px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 300x300px. Max 2MB.</p>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first. Default is 0.</p>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" checked
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="is_active">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active (visible on frontend)</label>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
