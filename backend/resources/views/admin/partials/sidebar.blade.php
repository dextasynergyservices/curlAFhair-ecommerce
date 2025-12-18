{{-- resources/views/admin/partials/sidebar.blade.php --}}
<div id="sidebar" class="fixed lg:relative z-30 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 w-64 lg:w-64 h-full p-4 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    {{-- Close button (visible only on mobile) --}}
    <button id="sidebarClose" class="lg:hidden absolute top-3 right-2 text-2xl">
        <i class="fas fa-times"></i>
    </button>

    <div class="text-xl font-bold mb-6">Admin Panel</div>

    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <i class="fas fa-user mr-2"></i> Users
            </a>
        </li>

        <li>
            <a href="{{ route('admin.promo.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <i class="fas fa-tags mr-2"></i> Promo
            </a>
        </li>

        {{-- Manage Products Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-shopping-bag mr-2"></i> Manage Products</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 hidden">
                <li><a href="{{ route('admin.products.create') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700">Add Products</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700">View Products</a></li>
            </ul>
        </li>

        {{-- Manage Orders Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-box mr-2"></i> Manage Orders</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 hidden">
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                        All Orders
                    </a>
                </li>
                {{-- Future: Add filtered links here if needed (e.g., Pending, Delivered) --}}
            </ul>
        </li>

        {{-- Settings Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-cogs mr-2"></i> Settings</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 hidden">
                <li><a href="{{ route('admin.settings.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700">General</a></li>
                <li><a href="#" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700">Advanced</a></li>
            </ul>
        </li>
    </ul>
</div>
