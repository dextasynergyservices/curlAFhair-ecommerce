@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Edit User: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back to Users
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="+234 XXX XXX XXXX">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Role *</label>
                            <select name="role" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @if($user->id === auth()->id())
                                <p class="text-xs text-yellow-600 mt-1">⚠️ Be careful when changing your own role!</p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-medium text-gray-700 mb-3">Change Password (leave blank to keep current)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" name="password" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Min 8 characters">
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-4">
            <!-- User Preview -->
            <div class="bg-white shadow rounded-lg p-6 text-center">
                @if($user->profile_photo_path)
                    <img class="h-20 w-20 rounded-full mx-auto object-cover" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    <div class="h-20 w-20 rounded-full bg-pink-600 flex items-center justify-center text-white text-2xl font-bold mx-auto">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h4 class="mt-3 font-medium">{{ $user->name }}</h4>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="font-medium mb-4">Quick Actions</h4>
                
                @if($user->id !== auth()->id())
                <div class="space-y-3">
                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded {{ ($user->is_active ?? true) ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                            @if($user->is_active ?? true)
                                🚫 Deactivate User
                            @else
                                ✓ Activate User
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 rounded bg-red-50 text-red-700 hover:bg-red-100">
                            🗑️ Delete User
                        </button>
                    </form>
                </div>
                @else
                <p class="text-sm text-gray-500">Actions unavailable for your own account.</p>
                @endif
            </div>

            <!-- Account Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="font-medium mb-4">Account Info</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Created:</span>
                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Updated:</span>
                        <span>{{ $user->updated_at->format('M d, Y') }}</span>
                    </div>
                    @if($user->email_verified_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Verified:</span>
                        <span class="text-green-600">✓ Yes</span>
                    </div>
                    @else
                    <div class="flex justify-between">
                        <span class="text-gray-500">Verified:</span>
                        <span class="text-red-600">✗ No</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete User?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
