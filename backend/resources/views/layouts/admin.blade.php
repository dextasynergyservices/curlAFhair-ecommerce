{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div id="app" class="flex h-screen overflow-hidden">
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col">
            @include('admin.partials.header')

            <main class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>

         document.getElementById('sidebarToggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
    });

    document.getElementById('sidebarClose').addEventListener('click', () => {
        document.getElementById('sidebar').classList.add('-translate-x-full');
    });

    document.getElementById('themeToggle').addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
    });
    </script>
</body>
</html>
