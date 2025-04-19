@extends('layouts.members')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16 pt-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart Panel -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Order Statistics</h3>
                <div>
                    @if (@isset($hasChartData) && $hasChartData) <!-- Check if there are labels (data) to display -->
                        {!! $chart->container() !!}
                    @else
                        <p class="text-gray-600 dark:text-gray-300">No data available for the chart.</p>
                    @endif
                </div>
            </div>

            <!-- Activity Feed Panel -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Recent Activity</h3>
                <ul>
                    @if (@isset($hasOrders) && $hasOrders)
                        @foreach ($recentActivities as $activity)
                            <li class="text-gray-600 dark:text-gray-300">
                                Order #{{ $activity->id }} placed on {{ $activity->created_at->format('M d, Y') }}
                            </li>
                        @endforeach
                    @else
                        <li class="text-gray-600 dark:text-gray-300">No orders made yet.</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Shortcuts Panel -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <a href="{{ url('/order-tracking') }}" class="text-blue-500 hover:underline">Track Order</a>
            </div>
            <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <button @click="open = true" class="text-blue-500 hover:underline">Update Profile</button>

                <!-- Modal -->
                <template x-if="open">
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md relative shadow-xl">
                            <button @click="open = false" class="absolute top-2 right-3 text-gray-600 dark:text-gray-300 hover:text-red-600">&times;</button>
                            <livewire:edit-profile />
                        </div>
                    </div>
                </template>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <a href="{{ url('/wishlist') }}" class="text-blue-500 hover:underline">Add to Wishlist</a>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center">
                <a href="{{ url('/cart') }}" class="text-blue-500 hover:underline">Go to Cart</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {!! $chart->script() !!}
@endsection
