@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Edit Category: {{ $category->name }}</h2>
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
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="e.g., Hair Care, Conditioners" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" value="{{ $category->slug }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" readonly>
                <p class="text-xs text-gray-500 mt-1">Auto-generated from name</p>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Optional description for this category">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Category Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-md px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 300x300px. Max 2MB.</p>
                
                @if($category->image)
                <div class="mt-3">
                    <p class="text-sm text-gray-500 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded">
                </div>
                @endif
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first. Default is 0.</p>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="is_active">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active (visible on frontend)</label>
            </div>

            <!-- Stats -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-medium text-gray-700 mb-2">Category Stats</h3>
                <p class="text-sm text-gray-600">Products in this category: <span class="font-semibold">{{ $category->products_count ?? $category->products()->count() }}</span></p>
            </div>

            <div class="flex justify-between items-center pt-4 border-t">
                <button type="button" id="delete-category-btn" class="text-red-600 hover:text-red-800 text-sm">Delete Category</button>
                
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update Category
                </button>
            </div>
        </form>

        <!-- Delete form moved outside the update form -->
        <form id="delete-category-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
    document.getElementById('delete-category-btn').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this category?')) {
            document.getElementById('delete-category-form').submit();
        }
    });
</script>
@endsection
