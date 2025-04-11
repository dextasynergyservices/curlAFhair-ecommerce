<nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a id="logo" href="{{ url('/') }}" class="text-2xl font-bold text-white transition-colors">curlAFhair</a>

        <!-- Hamburger -->
        <button id="nav-toggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
            <i class="fas fa-bars"></i>
        </button>

        <!-- Desktop Menu -->
        <ul id="nav-links" class="hidden md:flex space-x-6 font-medium text-white transition-colors mx-auto">
            <li><a href="{{ url('/') }}" class="hover:text-pink-400">Home</a></li>
            <li><a href="{{ url('/shop') }}" class="hover:text-pink-400">Shop</a></li>
            <li><a href="{{ url('/about') }}" class="hover:text-pink-400">About</a></li>
            <li><a href="{{ url('/services') }}" class="hover:text-pink-400">Services</a></li>
            <li><a href="{{ url('/contact') }}" class="hover:text-pink-400">Contact</a></li>
            <li><a href="{{ url('/cart') }}" class="hover:text-pink-400">Cart</a></li>
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden px-4 pb-4 bg-black text-white">
        <ul class="space-y-3 font-medium">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
            <li><a href="{{ url('/services') }}">Services</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
            <li><a href="{{ url('/cart') }}">Cart</a></li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const navLinks = document.getElementById('nav-links');
    const navToggle = document.getElementById('nav-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const logo = document.getElementById('logo');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-white', 'shadow-md');
            logo.classList.remove('text-white');
            logo.classList.add('text-white');
            navLinks.classList.remove('text-white');
            navLinks.classList.add('text-black');
        } else {
            navbar.classList.remove('bg-white', 'shadow-md');
            logo.classList.remove('text-white');
            logo.classList.add('text-white');
            navLinks.classList.remove('text-black');
            navLinks.classList.add('text-white');
        }
    });

    navToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
});
</script>
