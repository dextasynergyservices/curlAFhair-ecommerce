@extends('layouts.clean')

@section('content')
<div 
    class="min-h-screen bg-cover bg-center bg-no-repeat bg-fixed relative"
    style="background-image: url(/images/promo.jpg);"
>
    <!-- Overlay matching background image exactly -->
     <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 opacity-75"></div>
    <div class="absolute inset-0 bg-black opacity-75"></div> 

    <!-- Main content cards - centered horizontally -->
    <div class="relative z-10 flex flex-col lg:flex-row md:pt-48 lg:pt-48 gap-8 items-center justify-center px-4 py-24 max-w-7xl w-full h-full mx-auto">
        <div class="w-full flex flex-col lg:flex-row gap-8 items-center justify-center py-12 lg:py-0">

            <!-- Form Card -->
            <div class="w-full lg:w-1/2 max-w-lg">
                <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">

                    <div class="flex items-center justify-center mb-6">
                        <div class="text-center lg:text-left">
                            <h2 class="text-2xl font-bold text-white">Get Your Promo Code</h2>
                            <p class="text-white">Enter your details to and get a number for a chance to win! </p>
                        </div>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto pr-2 mb-4">
                        <!-- Add white glass background wrapper -->
                        <div class="backdrop-blur-sm rounded-xl p-4">
                            @livewire('promo-form')
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-white">
                            By submitting, you agree to our 
                            <button 
                                type="button"
                                class="text-pink-300 hover:text-pink-200 hover:underline cursor-pointer" 
                                data-open-terms-modal>
                                    terms and conditions
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Guide Card -->
            <div class="w-full lg:w-1/2 max-w-lg">
                <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">
                    <div class="flex items-center justify-center mb-6">
                        <div class="text-center lg:text-left">
                            <h2 class="text-2xl font-bold text-white">How to Participate</h2>
                            <p class="text-white">Follow these simple steps</p>
                        </div>
                    </div>

                    <!-- FIXED: Scrollable container with proper height -->
                    <div class="max-h-[400px] overflow-y-auto pr-2 mb-4">
                        <div class="backdrop-blur-sm rounded-xl p-4">
                            @include('frontend.members.partials.promo-guide')
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div class="mt-6 pt-6 border-t border-white/20">
                        <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="https://x.com/curlafhair" target="_blank" rel="noopener noreferrer" 
                            class="bg-white/20 text-white rounded-full px-4 py-2 hover:bg-white/30 transition flex items-center justify-center w-full sm:w-auto">
                                <span class="text-sm sm:text-base">X: @curlafhair</span>
                            </a>
                            <a href="https://instagram.com/curlafhairofficial" target="_blank" rel="noopener noreferrer" 
                            class="bg-white/20 text-white rounded-full px-4 py-2 hover:bg-white/30 transition flex items-center justify-center w-full sm:w-auto">
                                <span class="text-sm sm:text-base">IG: @curlafhairofficial</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $winningCodes = \App\Models\WinningCode::orderBy('code')->get();
    @endphp
    <div id="winning-codes-trigger" class="relative z-10 max-w-5xl w-full mx-auto px-4 pb-12 hidden">
        <div class="flex items-center justify-center">
            <button 
                type="button" 
                class="px-6 py-3 rounded-lg bg-pink-500 text-white font-semibold shadow-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2 lg:hidden md:hidden"
                data-open-winning-codes
            >
                View Winning Codes
            </button>
        </div>
    </div>

    <!-- Winning Codes Modal -->
    <div id="winning-codes-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[80vh] overflow-hidden flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Winning Promo Codes</h3>
                    <p class="text-sm text-gray-600">If your code is listed, you’ve won. Congrats!</p>
                </div>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-close-winning-codes>&times;</button>
            </div>
            <div class="p-6 overflow-y-auto">
                @if($winningCodes->isEmpty())
                    <p class="text-sm text-gray-600">Winning codes will appear here once announced.</p>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        @foreach($winningCodes as $code)
                            <div class="border border-gray-200 rounded-lg px-3 py-2 text-center bg-white shadow-sm">
                                <span class="font-mono text-sm text-gray-800">{{ $code->code }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200" data-close-winning-codes>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Condition Modal -->
<div id="terms-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[80vh] overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Terms and Conditions</h3>
                <p class="text-sm text-gray-600">Please read carefully before participating</p>
            </div>
            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" data-close-terms-modal>&times;</button>
        </div>
        <div class="p-6 overflow-y-auto">
            <div class="prose prose-sm max-w-none">
                <h4 class="text-lg font-semibold text-gray-900 mb-3">Welcome to Our Promotion</h4>
                <p class="text-gray-700 mb-4">By submitting your information, you agree to the following terms and conditions:</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">1. Eligibility</h5>
                <p class="text-gray-700 mb-3">You must be at least 18 years old to participate. By submitting your information, you confirm that you meet this requirement.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">2. Promotional Codes</h5>
                <p class="text-gray-700 mb-3">Promo codes are provided at our discretion and may be subject to expiration dates, usage limits, or other restrictions. Only valid promo codes can participate.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">3. Privacy</h5>
                <p class="text-gray-700 mb-3">Your information will be used solely for the purpose of providing you with promotional offers. We will not share your personal data with third parties without your explicit consent.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">4. Winning Codes</h5>
                <p class="text-gray-700 mb-3">Winning codes will be announced on our social media platforms and displayed on this page. If your code appears in the winning codes list, you're eligible for the exclusive offer.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">5. Service Availability</h5>
                <p class="text-gray-700 mb-3">We reserve the right to modify, suspend, or discontinue the promotion at any time without prior notice.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">6. Limitation of Liability</h5>
                <p class="text-gray-700 mb-3">We are not liable for any technical issues, network problems, or other circumstances beyond our control that may affect your participation.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">7. Changes to Terms</h5>
                <p class="text-gray-700 mb-3">We may update these terms from time to time. Continued participation after changes constitutes acceptance of the new terms.</p>
                
                <h5 class="text-md font-semibold text-gray-800 mt-4 mb-2">8. Contact Information</h5>
                <p class="text-gray-700">If you have any questions about these terms, please contact us via our social media channels.</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200" data-close-terms-modal>Close</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Winning Codes Modal
        const winningModal = document.getElementById('winning-codes-modal');
        const openWinningButtons = document.querySelectorAll('[data-open-winning-codes]');
        const closeWinningButtons = document.querySelectorAll('[data-close-winning-codes]');

        const openWinningModal = () => winningModal.classList.remove('hidden');
        const closeWinningModal = () => winningModal.classList.add('hidden');

        openWinningButtons.forEach(btn => btn.addEventListener('click', openWinningModal));
        closeWinningButtons.forEach(btn => btn.addEventListener('click', closeWinningModal));
        winningModal.addEventListener('click', (e) => {
            if (e.target === winningModal) closeWinningModal();
        });

        // Terms and Conditions Modal
        const termsModal = document.getElementById('terms-modal');
        const openTermsButtons = document.querySelectorAll('[data-open-terms-modal]');
        const closeTermsButtons = document.querySelectorAll('[data-close-terms-modal]');

        const openTermsModal = () => termsModal.classList.remove('hidden');
        const closeTermsModal = () => termsModal.classList.add('hidden');

        openTermsButtons.forEach(btn => btn.addEventListener('click', (e) => {
            e.preventDefault();
            openTermsModal();
        }));
        closeTermsButtons.forEach(btn => btn.addEventListener('click', closeTermsModal));
        termsModal.addEventListener('click', (e) => {
            if (e.target === termsModal) closeTermsModal();
        });

        // Handle Escape key for both modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (!termsModal.classList.contains('hidden')) closeTermsModal();
                if (!winningModal.classList.contains('hidden')) closeWinningModal();
            }
        });
    });
</script>

<style>
    /* Remove any footer */
    footer {
        display: none !important;
    }
</style>
@endsection