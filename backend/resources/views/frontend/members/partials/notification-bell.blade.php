{{-- <div x-data="notificationDropdown" class="relative text-right mb-6">
    <button @click="toggle"
        class="relative inline-flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full hover:ring-2 hover:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-gray-700" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405C18.79 14.79 18 13.42 18 12V8a6 6 0 10-12 0v4c0 1.42-.79 2.79-1.595 3.595L3 17h5m7 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($user->unreadNotifications->count())
            <span id="notificationCount"
                class="absolute top-0 right-0 block h-5 w-5 text-xs bg-red-600 text-white rounded-full leading-5">
                {{ $user->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" x-transition @click.away="open = false"
        class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg z-50 p-4">
        <h4 class="text-sm font-semibold text-gray-800 mb-2">Recent Notifications</h4>
        @forelse($user->unreadNotifications->take(5) as $notification)
            <div class="p-2 border-b border-gray-200 text-sm text-gray-700">
                {{ $notification->data['title'] ?? 'No message content.' }}
                <span class="block text-xs text-gray-500">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No new notifications.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationDropdown', () => ({
            open: false,
            toggle() {
                this.open = !this.open;

                if (this.open) {
                    fetch("{{ route('notifications.markAsRead') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    }).then(res => res.json())
                      .then(data => {
                        if (data.success) {
                            document.getElementById('notificationCount')?.remove();
                        }
                    });
                }
            }
        }));
    });
</script>
@endpush --}}

<!-- Bell Icon -->
<button @click="showNotifications = !showNotifications" class="relative">
    🔔
    {{-- @if ($unreadCount)
        <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-1 text-xs">
            {{ $unreadCount }}
        </span>
    @endif --}}
</button>

<!-- Notification Modal -->
<div x-show="showNotifications" x-cloak class="fixed right-4 top-16 w-96 bg-white shadow rounded-lg p-4 z-50">
    <h2 class="text-lg font-semibold">Notifications</h2>
    <ul class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
        @forelse ($notifications as $note)
            <li class="py-2">
                <strong>{{ $note->data['title'] }}</strong><br>
                <span>{{ $note->data['message'] }}</span>
            </li>
        @empty
            <li class="py-2 text-gray-500">No notifications found.</li>
        @endforelse
    </ul>
</div>
