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

            <!-- Form Card -->
            <div class="w-full lg:w-1/2 max-w-lg">
                <div class="bg-gradient-to-br from-purple-500/10 to-pink-500/10 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">

                    <div class="flex items-center justify-center mb-6">
                        <div class="text-center lg:text-left">
                            <h2 class="text-2xl font-bold text-white">Get Your Promo Code</h2>
                            <p class="text-white">Enter your details to participate in the exclusive sale</p>
                        </div>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto pr-2 mb-4">
                        <!-- Add white glass background wrapper -->
                        <div class="backdrop-blur-sm rounded-xl p-4">
                            @livewire('promo-form')
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-white">By submitting, you agree to our terms and conditions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $winningCodes = \App\Models\WinningCode::orderBy('code')->get();
    @endphp
    <div id="winning-codes-trigger" class="relative z-10 max-w-5xl w-full mx-auto px-4 pb-12">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('winning-codes-modal');
        const openButtons = document.querySelectorAll('[data-open-winning-codes]');
        const closeButtons = document.querySelectorAll('[data-close-winning-codes]');

        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');

        openButtons.forEach(btn => btn.addEventListener('click', openModal));
        closeButtons.forEach(btn => btn.addEventListener('click', closeModal));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
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