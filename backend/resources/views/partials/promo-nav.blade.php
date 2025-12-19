<nav id="navbar"class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class=" mx-auto px-10 md:px-10 pd-12 pt-4 flex justify-between items-center">
        <a id="logo" href="{{ url('/') }}" class="text-2xl font-bold text-white transition-colors h-[50px]"><img src="/images/logo.png" alt="logo" class="w-[150] h-[50px] md:w-[175] md:h-[80px] lg:w-[175] lg:h-[80px]"></a>
        <div class="hidden md:flex items-center space-x-6 text-white font-medium">
            <button
                type="button"
                class="px-4 py-2 rounded-lg bg-pink-500 hover:bg-pink-600 text-white shadow transition focus:outline-none focus:ring-2 focus:ring-pink-300 hidden"
                data-open-winning-codes
            >
                Winning Codes
            </button>
        </div>
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
            navbar.classList.add('transparent', 'shadow-md');
        } else {
            navbar.classList.remove('transparent', 'shadow-md');
        }
    });

    navToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
});
</script>