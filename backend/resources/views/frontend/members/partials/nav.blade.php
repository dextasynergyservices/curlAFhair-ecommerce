<nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class=" mx-auto px-10 md:px-10 py-4 flex justify-between items-center">
        <a id="logo" href="{{ url('/') }}" class="text-2xl font-bold text-white transition-colors h-[80px]"><img src="/images/logo.png" alt="logo" class="w-[175] h-[80px]"></a>

        <button id="nav-toggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Desktop Menu -->
        <ul id="nav-links" class="hidden md:flex space-x-6 text-lg text-black transition-colors mx-auto">
            <li><a href="{{ url('/') }}" class="hover:text-pink-400">Home</a></li>
            <li><a href="{{ url('/shop') }}" class="hover:text-pink-400">Shop</a></li>
            <li><a href="{{ url('/about') }}" class="hover:text-pink-400">About</a></li>
            <li><a href="{{ url('/services') }}" class="hover:text-pink-400">Services</a></li>
            <li><a href="{{ url('/contact') }}" class="hover:text-pink-400">Contact</a></li>
        </ul>

        <ul id="nav-links-2" class="hidden md:flex justify-end space-x-6 text-lg text-black transition-colors">
            <li><a href="{{ url('/cart') }}" class="hover:text-pink-400"><i class="fas fa-shopping-cart"></i></a></li>

            @guest
                <li class="ml-auto"><a href="{{ route('login') }}" class="hover:text-pink-400">Login</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-pink-400">Sign Up</a></li>
            @endguest

            @auth
                <li class="ml-auto">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-500 hover:underline">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </li>
            @endauth
        </ul>

    </div>

    <div id="mobile-menu" class="md:hidden hidden h-screen pointer-events-none px-4 py-4 bg-black text-white bg-black/50 backdrop-blur">
        <ul class="space-y-3 font-medium">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
            <li><a href="{{ url('/services') }}">Services</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
            <li><a href="{{ url('/cart') }}"><i class="fas fa-shopping-cart"></i></a></li>

            @guest
                <li><a href="{{ route('login') }}" class="hover:text-pink-400">Login</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-pink-400">Sign Up</a></li>
            @endguest

            @auth
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="text-red-500 hover:underline">Logout</a>
                    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </li>
            @endauth
        </ul>
    </div>

</nav>



</nav>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const navLinks = document.getElementById('nav-links');
    const navLinks2 = document.getElementById('nav-links-2')
    const navToggle = document.getElementById('nav-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const logo = document.getElementById('logo');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-white', 'shadow-md');
            logo.classList.remove('text-white');
            logo.classList.add('text-black');
            navLinks.classList.remove('text-white');
            navLinks.classList.add('text-black');
            navToggle.classList.remove('text-white');
            navToggle.classList.add('text-black');
            navLinks2.classList.remove('text-white');
            navLinks2.classList.add('text-black');
        } else {
            navbar.classList.remove('bg-white', 'shadow-md');
            logo.classList.remove('text-black');
            logo.classList.add('text-white');
            navLinks.classList.remove('text-black');
            navLinks.classList.add('text-black');
            navToggle.classList.remove('text-black');
            navToggle.classList.add('text-white');
            navLinks2.classList.remove('text-black');
            navLinks2.classList.add('text-black');
        }
    });

    navToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
});
</script>

