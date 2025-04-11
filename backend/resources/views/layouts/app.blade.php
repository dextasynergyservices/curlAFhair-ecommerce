<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'curlAFhair' }}</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
    <!-- FontAwesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  </head>
  <body class="font-sans antialiased bg-gray-50 text-gray-900">

    @include('partials.nav') <!-- We'll create this -->

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer')

  </body>
</html>
