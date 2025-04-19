<div class="p-6 bg-white rounded-lg shadow-md max-w-xl mx-auto">
    @if (session()->has('message'))
        <div class="text-green-600 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full border rounded-md p-2" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full border rounded-md p-2" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full border rounded-md p-2" />
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
            <input type="file" id="profile_photo" wire:model="profile_photo" class="mt-1 block w-full" />
            @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                Save Changes
            </button>
        </div>
    </form>
</div>
