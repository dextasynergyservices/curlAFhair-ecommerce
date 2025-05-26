<div x-data="{ showModal: false }">
    <button @click="showModal = true" class="bg-blue-500 text-white px-4 py-2 rounded">
        Edit Profile
    </button>

    <!-- Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="showModal = false" class="bg-white p-6 rounded shadow-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Edit Profile</h2>

            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label>Name</label>
                    <input type="text" wire:model="name" class="w-full border p-2 rounded">
                </div>

                <div class="mb-4">
                    <label>Email</label>
                    <input type="email" wire:model="email" class="w-full border p-2 rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
