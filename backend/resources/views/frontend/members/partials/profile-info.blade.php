{{-- resources/views/frontend/members/partials/profile-info.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Profile Information</h2>
    <div class="flex items-center space-x-4">
        <img src="https://via.placeholder.com/80" alt="Profile Photo" class="w-20 h-20 rounded-full border border-gray-300">
        <div>
            <p class="text-gray-900 dark:text-white font-medium">John Doe</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">johndoe@example.com</p>
        </div>
    </div>
</div>

{{-- resources/views/frontend/members/partials/order-history.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Order History</h2>
    <ul class="space-y-4">
        <li class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
            <span>#12345 - Shampoo Pack</span>
            <span>March 1, 2025</span>
        </li>
        <li class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
            <span>#12346 - Hair Oil</span>
            <span>April 1, 2025</span>
        </li>
    </ul>
</div>

{{-- resources/views/frontend/members/partials/saved-items.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Saved Items</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl">
            <p class="text-sm text-gray-800 dark:text-gray-200">Hair Gel</p>
        </div>
        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl">
            <p class="text-sm text-gray-800 dark:text-gray-200">Conditioner</p>
        </div>
    </div>
</div>

{{-- resources/views/frontend/members/partials/wishlist.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Wishlist</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl">
            <p class="text-sm text-gray-800 dark:text-gray-200">Hair Serum</p>
        </div>
        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl">
            <p class="text-sm text-gray-800 dark:text-gray-200">Scalp Brush</p>
        </div>
    </div>
</div>

{{-- resources/views/frontend/members/partials/notifications.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Notifications</h2>
    <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
        <li>You have a new message from support.</li>
        <li>Your order #12346 has been shipped.</li>
    </ul>
</div>
