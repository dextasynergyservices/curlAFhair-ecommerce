<div class="rounded-xl p-6 border-2 border-purple-200/50 shadow-lg">
    @if($errors->has('form'))
        <div class="mb-6 p-4 bg-red-50 border-2 border-red-300 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 112 0v2a1 1 0 11-2 0v-2zm1-8a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-800 font-medium">{{ $errors->first('form') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-5">
        <!-- Honeypot Field (hidden from users) -->
        <div class="hidden">
            <label for="promo_trap" class="sr-only">Do not fill this field</label>
            <input
                type="text"
                id="promo_trap"
                wire:model="honeypot"
                autocomplete="off"
                tabindex="-1"
                aria-hidden="true"
            >
        </div>

        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-medium text-white mb-2">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full pl-10 pr-4 py-3 bg-white/80 border-2 border-gray-300/80 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-400 transition placeholder-gray-500"
                    placeholder="Enter your full name"
                    required
                >
            </div>
            @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-white mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input 
                    type="email" 
                    id="email" 
                    wire:model="email" 
                    class="w-full pl-10 pr-4 py-3 bg-white/80 border-2 border-gray-300/80 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-400 transition placeholder-gray-500"
                    placeholder="you@example.com"
                    required
                >
            </div>
            @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Phone Number with Country Selector -->
       <div>
    <label for="phone" class="block text-sm font-medium text-white mb-2">Phone Number</label>
    <div class="flex flex-col sm:flex-row gap-4">
        <!-- Country Code Dropdown -->
        <div class="w-full sm:w-1/3">
            <div wire:ignore class="relative">
                <button 
                    type="button" 
                    onclick="toggleCountryDropdown()"
                    class="w-full px-3 py-3 bg-white/80 border-2 border-gray-300/80 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-400 transition flex items-center justify-between"
                    id="country-button"
                >
                    <div class="flex items-center">
                        <span class="fi fi-{{ strtolower($country_code) }} mr-2"></span>
                        <span class="text-sm font-medium">+{{ $country_code == 'US' ? '1' : '234' }}</span>
                    </div>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <!-- Dropdown Options -->
                <div 
                    id="country-dropdown" 
                    class="absolute hidden mt-1 w-full bg-white border-2 border-gray-300/80 rounded-lg shadow-lg z-50 overflow-hidden"
                >
                    <button 
                        type="button"
                        wire:click="$set('country_code', 'NG')"
                        onclick="selectCountry('ng', '+234')"
                        class="w-full px-4 py-3 text-left hover:bg-gray-50 flex items-center text-sm border-b border-gray-100"
                    >
                        <span class="fi fi-ng mr-3"></span>
                        <div class="flex flex-col">
                            <span class="font-medium">NG</span>
                            <span class="text-xs text-gray-500">+234</span>
                        </div>
                    </button>
                    <button 
                        type="button"
                        wire:click="$set('country_code', 'US')"
                        onclick="selectCountry('us', '+1')"
                        class="w-full px-4 py-3 text-left hover:bg-gray-50 flex items-center text-sm"
                    >
                        <span class="fi fi-us mr-3"></span>
                        <div class="flex flex-col">
                            <span class="font-medium">US</span>
                            <span class="text-xs text-gray-500">+1</span>
                        </div>
                    </button>
                </div>
            </div>
            @error('country_code') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Phone Number Input -->
        <div class="w-full sm:w-2/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <input 
                    type="tel" 
                    id="phone" 
                    wire:model="phone" 
                    class="w-full pl-10 pr-4 py-3 bg-white/80 border-2 border-gray-300/80 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-400 transition placeholder-gray-500"
                    placeholder="{{ $country_code == 'US' ? '555 123 4567' : '801 234 5678' }}"
                    required
                >
            </div>
        </div>
    </div>
    @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>

        <!-- Newsletter Checkbox -->
        <div class="flex items-start p-3 border-2 border-gray-200/50 rounded-lg bg-white/50">
            <input 
                type="checkbox" 
                id="newsletter" 
                wire:model="wants_newsletter"
                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded mt-1"
            >
            <label for="newsletter" class="ml-3 block text-sm text-gray-700">
                I want to receive updates about future promos and products
            </label>
        </div>

        <button 
            type="submit" 
            class="w-full bg-pink-500 text-white font-semibold py-2 md:py-3 px-2 md:px-4 rounded-lg border-2 border-pink-600 hover:bg-pink-600 hover:border-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed text-sm md:text-base"
            wire:loading.attr="disabled"
            wire:target="submit"
        >
            <span class="flex items-center justify-center gap-1">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg> 
                <span wire:loading.remove wire:target="submit">Get My Promo Code</span>
                <span wire:loading wire:target="submit" class="flex items-center">
                    <svg class="animate-spin h-3 w-3 md:h-4 md:w-4 mr-1 md:mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z"></path>
                    </svg>
                    Sending...
                </span>
            </span>
        </button>

        @if($successMessage)
            <div class="p-4 bg-green-50 border-2 border-green-300 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-green-800 font-medium">{{ $successMessage }}</p>
                </div>
            </div>
        @endif
    </form>

    <!-- Additional Info -->
    <div class="mt-6 pt-6 border-t-2 border-gray-200/50">
        <div class="flex items-center justify-center">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
            <p class="text-xs text-white text-center">
                Your information will be used solely for this promotion and will be handled in accordance with our Privacy Policy. We do not sell or share your data with third parties
            </p>
        </div>
    </div>
</div>

<script>
    function toggleCountryDropdown() {
        const dropdown = document.getElementById('country-dropdown');
        dropdown.classList.toggle('hidden');
    }

    function selectCountry(code, dialCode) {
        // Update button display
        const button = document.getElementById('country-button');
        button.innerHTML = `
            <div class="flex items-center">
                <span class="fi fi-${code} mr-2"></span>
                <span class="text-sm font-medium">${dialCode}</span>
            </div>
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        `;
        
        // Update phone placeholder
        const phoneInput = document.getElementById('phone');
        phoneInput.placeholder = dialCode === '+1' ? '555 123 4567' : '801 234 5678';
        
        // Close dropdown
        document.getElementById('country-dropdown').classList.add('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('country-dropdown');
        const button = document.getElementById('country-button');
        
        if (dropdown && button) {
            document.addEventListener('click', function(event) {
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
</script>