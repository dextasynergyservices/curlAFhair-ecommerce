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
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-user mr-2"></i> Users
            </a>
        </li>

        <li>
            <a href="{{ route('admin.promo.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.promo.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-tags mr-2"></i> Promo
            </a>
        </li>

        {{-- Manage Categories Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-folder mr-2"></i> Categories</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 {{ request()->routeIs('admin.categories.*') ? '' : 'hidden' }}">
                <li><a href="{{ route('admin.categories.create') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.create') ? 'bg-gray-100 dark:bg-gray-600' : '' }}">Add Category</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.index') ? 'bg-gray-100 dark:bg-gray-600' : '' }}">View Categories</a></li>
            </ul>
        </li>

        {{-- Manage Products Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-shopping-bag mr-2"></i> Products</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 {{ request()->routeIs('admin.products.*') ? '' : 'hidden' }}">
                <li><a href="{{ route('admin.products.create') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.create') ? 'bg-gray-100 dark:bg-gray-600' : '' }}">Add Product</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.products.index') ? 'bg-gray-100 dark:bg-gray-600' : '' }}">View Products</a></li>
            </ul>
        </li>

        {{-- Coupons --}}
        <li>
            <a href="{{ route('admin.coupons.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.coupons.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-ticket-alt mr-2"></i> Coupons
            </a>
        </li>

        {{-- Manage Orders Dropdown --}}
        <li>
            <button class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <span><i class="fas fa-box mr-2"></i> Orders</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="ml-6 mt-2 space-y-2 {{ request()->routeIs('admin.orders.*') ? '' : 'hidden' }}">
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="block px-2 py-1 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.orders.index') ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                        All Orders
                    </a>
                </li>
            </ul>
        </li>

        {{-- Settings --}}
        <li>
            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-cogs mr-2"></i> Settings
            </a>
        </li>
    </ul>
</div>
