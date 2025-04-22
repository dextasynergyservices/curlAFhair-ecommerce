{{-- resources/views/admin/partials/header.blade.php --}}
<header class="flex items-center justify-between bg-white dark:bg-gray-800 p-4 border-b dark:border-gray-700">
    <div class="flex items-center gap-4">
        <button id="sidebarToggle" class="lg:hidden text-2xl">
            <i class="fas fa-bars"></i>
        </button>

        <button id="themeToggle" class="text-xl">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm">
            {{ Auth::user()->name ?? 'Admin' }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-500 hover:underline">Logout</button>
        </form>
    </div>
</header>
