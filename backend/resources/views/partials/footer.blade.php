<footer class="bg-white text-gray-100 py-10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-4">
        <!-- Column 1: Logo + Socials -->
        <div>
            <h2 class="text-2xl font-bold mb-4">curlAFhair</h2>
            <p class="text-gray-400 mb-4">Stay styled. Stay beautiful.</p>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-pink-400"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-pink-400"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-pink-400"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <!-- Column 2: Navigation -->
        <div>
            <h3 class="text-xl font-semibold mb-4 text-black">Quick Links</h3>
            <ul class="space-y-2 text-gray-400">
                <li><a href="{{ url('/') }}" class="hover:text-white">Home</a></li>
                <li><a href="{{ url('/shop') }}" class="hover:text-white">Shop</a></li>
                <li><a href="{{ url('/about') }}" class="hover:text-white">About</a></li>
                <li><a href="{{ url('/services') }}" class="hover:text-white">Services</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:text-white">Contact</a></li>
            </ul>
        </div>

        <!-- Column 3: Media -->
        <div>
            <h3 class="text-xl font-semibold mb-4 text-black">Media</h3>
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white">Gallery</a></li>
                <li><a href="#" class="hover:text-white">Blog</a></li>
                <li><a href="#" class="hover:text-white">Reviews</a></li>
                <li><a href="#" class="hover:text-white">Events</a></li>
            </ul>
        </div>

        <!-- Column 4: Contact -->
        <div>
            <h3 class="text-xl font-semibold mb-4 text-black">Contact</h3>
            <ul class="space-y-2 text-gray-400">
                <li>Email: info@curlafhair.com</li>
                <li>Phone: +234 800 123 4567</li>
                <li>Location: Lagos, Nigeria</li>
                <li><a href="#" class="hover:text-white">Support Center</a></li>
            </ul>
        </div>
    </div>
    <div class="text-center pt-6 text-sm text-gray-500">
    &copy; {{ now()->year }} curlAFhair. All rights reserved.
</div>
</footer>
