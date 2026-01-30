<nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class=" mx-auto px-10 md:px-10 py-4 flex justify-between items-center">
        <a id="logo" href="{{ url('/') }}" class="text-2xl font-bold text-white transition-colors h-[80px]"><img src="/images/logo.png" alt="logo" class="w-[175] h-[80px]"></a>

        <button id="nav-toggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Desktop Menu -->
        <ul id="nav-links" class="hidden md:flex space-x-6 text-lg text-white transition-colors mx-auto">
            <li><a href="{{ url('/') }}" class="hover:text-pink-400">Home</a></li>
            <li><a href="{{ url('/shop') }}" class="hover:text-pink-400">Shop</a></li>
            <li><a href="{{ url('/promo') }}" class="hover:text-pink-400">Promo</a></li>
            <li><a href="{{ url('/about') }}" class="hover:text-pink-400">About</a></li>
            <li><a href="{{ url('/services') }}" class="hover:text-pink-400">Services</a></li>
            <li><a href="{{ url('/contact') }}" class="hover:text-pink-400">Contact</a></li>
        </ul>

        <ul id="nav-links-2" class="hidden md:flex justify-end space-x-6 text-lg text-white transition-colors items-center">
            <!-- Cart with count and dropdown -->
            <li class="relative group">
                <a href="{{ route('cart.index') }}" class="hover:text-pink-400 relative flex items-center">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount ?? 0 > 0 ? '' : 'hidden' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
                <!-- Hover Dropdown -->
                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="p-4 text-center">
                        <p class="text-gray-600 text-sm mb-2">
                            <span id="cart-dropdown-count">{{ $cartCount ?? 0 }}</span> item(s) in cart
                        </p>
                        <a href="{{ route('cart.index') }}" class="block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors text-sm font-medium">
                            View Cart
                        </a>
                    </div>
                </div>
            </li>

            @guest
                <li class="ml-auto"><a href="{{ route('login') }}" class="hover:text-pink-400">Login</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-pink-400">Sign Up</a></li>
            @endguest

            @auth
                <li class="relative group">
                    <a href="{{ route('dashboard') }}" class="hover:text-pink-400 flex items-center">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                    <!-- User Dropdown -->
                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <p class="px-4 py-2 text-gray-800 font-medium border-b">{{ auth()->user()->name }}</p>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 text-sm">Dashboard</a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 text-sm">Admin Panel</a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 text-sm">Profile</a>
                            <hr class="my-1">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-red-500 hover:bg-gray-100 text-sm">Logout</a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </li>
            @endauth
        </ul>

    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden h-screen pointer-events-none px-4 py-4 bg-black text-white bg-black/50 backdrop-blur">
        <ul class="space-y-3 font-medium pointer-events-auto">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/shop') }}">Shop</a></li>
            <li><a href="{{ url('/promo') }}">Promo</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
            <li><a href="{{ url('/services') }}">Services</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
            <li>
                <a href="{{ route('cart.index') }}" class="flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i> 
                    Cart 
                    <span id="mobile-cart-count" class="ml-2 bg-pink-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount ?? 0 > 0 ? '' : 'hidden' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
            </li>

            @guest
                <li><a href="{{ route('login') }}" class="hover:text-pink-400">Login</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-pink-400">Sign Up</a></li>
            @endguest

            @auth
                <li><a href="{{ route('dashboard') }}" class="hover:text-pink-400">Dashboard</a></li>
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-pink-400">Admin Panel</a></li>
                @endif
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="text-red-500 hover:underline">Logout</a>
                    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </li>
            @endauth
        </ul>
    </div>

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
            navLinks.classList.add('text-white');
            navToggle.classList.remove('text-black');
            navToggle.classList.add('text-white');
            navLinks2.classList.remove('text-black');
            navLinks2.classList.add('text-white');
        }
    });

    navToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Fetch and update cart count
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const cartCountEl = document.getElementById('cart-count');
                const mobileCartCountEl = document.getElementById('mobile-cart-count');
                const dropdownCountEl = document.getElementById('cart-dropdown-count');
                
                if (cartCountEl) {
                    cartCountEl.textContent = count;
                    cartCountEl.classList.toggle('hidden', count === 0);
                }
                if (mobileCartCountEl) {
                    mobileCartCountEl.textContent = count;
                    mobileCartCountEl.classList.toggle('hidden', count === 0);
                }
                if (dropdownCountEl) {
                    dropdownCountEl.textContent = count;
                }
            })
            .catch(err => console.log('Cart count fetch error:', err));
    }

    // Update cart count on page load
    updateCartCount();

    // Listen for custom cart update events
    window.addEventListener('cart-updated', updateCartCount);
});
</script>
