<div class="px-4 sm:px-6 lg:px-8">
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="sm:flex sm:items-center sm:justify-between gap-4">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Promo Submissions</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the users who have submitted the promo form.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
            <button wire:click="openMatchesModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-500 rounded-md hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400">
                View Winners
            </button>
            <button wire:click="openCodeModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add Winning Code
            </button>
        </div>
    </div>
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Promo Code</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Wants Newsletter</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Submission Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($promos as $promo)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $promo->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $promo->email }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $promo->phone }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $promo->promo_code }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $promo->wants_newsletter ? 'Yes' : 'No' }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $promo->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $promos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Total Submissions</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $totalSubmissions }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">Newsletter Subscribers</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $totalNewsletters }}</p>
        </div>
    </div>

    @if ($toastMessage)
        <div 
            class="fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg text-sm
            {{ $toastType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
            {{ $toastMessage }}
        </div>
    @endif

    @if ($showCodeModal)
        <div class="fixed inset-0 z-20 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Add Winning Codes</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Promo Codes (comma separated)</label>
                    <textarea wire:model.defer="newCode" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="PROMO-00001, PROMO-00002, PROMO-00003"></textarea>
                    @error('newCode') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showCodeModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</button>
                    <button wire:click="saveCode" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Save</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showEditCodeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" wire:click.self="$set('showEditCodeModal', false)">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 space-y-4" wire:click.stop wire:key="edit-modal">
                <h3 class="text-lg font-semibold text-gray-900">Edit Winning Code</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Promo Code</label>
                    <input type="text" wire:model="editingCode" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="PROMO-00001">
                    @error('editingCode') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <button wire:click="closeEditCodeModal" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</button>
                    <button wire:click="updateCode" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Save</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showMatchesModal)
        <div class="fixed inset-0 z-30 flex items-center justify-center bg-black/75 p-4" wire:click.self="$set('showMatchesModal', false)">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[80vh] overflow-hidden flex flex-col" wire:click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Users with Winning Promo Codes</h3>
                        <p class="text-sm text-gray-600">Showing users whose promo code matches a winning code.</p>
                    </div>
                    <button wire:click="$set('showMatchesModal', false)" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div class="p-6 overflow-auto">
                    @if (empty($matchedPromos) || count($matchedPromos) === 0)
                        <p class="text-sm text-gray-600">No matches yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Name</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Email</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Phone</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Promo Code</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Newsletter</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Submitted</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($matchedPromos as $promo)
                                        <tr>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $promo->name }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $promo->email }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $promo->phone }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900 font-mono">{{ $promo->promo_code }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $promo->wants_newsletter ? 'Yes' : 'No' }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-500">{{ optional($promo->created_at)->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    @if (!empty($matchedPromos) && count($matchedPromos) > 0)
                        <button wire:click="sendMatchedWinnersEmails" type="button" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Send Email Notifications</button>
                    @endif
                    <button wire:click="$set('showMatchesModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Close</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showComposeEmailModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 p-4" wire:click.self="closeComposeEmailModal">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[85vh] overflow-hidden flex flex-col" wire:click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Compose Email to Winners</h3>
                        <p class="text-sm text-gray-600">Customize your message to send to {{ count($matchedPromos) }} winner(s).</p>
                    </div>
                    <button wire:click="closeComposeEmailModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div class="p-6 overflow-auto space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Subject <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.defer="emailSubject" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter email subject">
                        @error('emailSubject') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Message <span class="text-red-500">*</span></label>
                        <textarea wire:model.defer="emailBody" rows="8" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Write your customized message here..."></textarea>
                        @error('emailBody') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        <p class="mt-2 text-xs text-gray-500">You can use placeholders like @{{ '{name}' }}, @{{ '{email}' }}, @{{ '{promo_code}' }} which will be replaced with each winner's information.</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button wire:click="closeComposeEmailModal" type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</button>
                    <button wire:click="sendCustomizedEmails" type="button" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Send Emails</button>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-10 bg-white shadow rounded-lg p-4">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Winning Codes</h3>
                <p class="text-sm text-gray-600">Codes visible to users on the promo page.</p>
            </div>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Code</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Added</th>
                        <th class="px-3 py-2 text-right text-xs font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($winningCodes as $code)
                        <tr wire:key="code-{{ $code->id }}">
                            <td class="px-3 py-2 text-sm text-gray-900 font-mono">{{ $code->code }}</td>
                            <td class="px-3 py-2 text-sm text-gray-500">{{ optional($code->created_at)->format('M d, Y H:i') }}</td>
                            <td class="px-3 py-2 text-sm text-right space-x-3" onclick="event.stopPropagation()">
                                <button type="button" wire:click="editCode({{ $code->id }})" onclick="event.preventDefault(); event.stopPropagation();" wire:loading.attr="disabled" class="text-indigo-600 hover:text-indigo-800 disabled:opacity-50 cursor-pointer" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l2.651 2.651a2.25 2.25 0 010 3.182l-8.106 8.106a2.25 2.25 0 01-.951.568l-3.347.957a.75.75 0 01-.927-.927l.957-3.347a2.25 2.25 0 01.568-.951l8.106-8.106a2.25 2.25 0 013.182 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
                                    </svg>
                                </button>
                                <button type="button" wire:click="deleteCode({{ $code->id }})" onclick="event.preventDefault(); event.stopPropagation();" wire:loading.attr="disabled" class="text-red-600 hover:text-red-800 disabled:opacity-50" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 011-1h4a1 1 0 011 1m-7 0h10" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-4 text-sm text-gray-500 text-center">No winning codes yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $winningCodes->links() }}
        </div>
    </div>

    <!-- <div class="mt-8">
        <div class="flex items-center space-x-4">
            <input type="number" wire:model="numberOfWinners" class="w-24 border-gray-300 rounded-md shadow-sm">
            <button wire:click="pickRandomWinners" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Pick Random Winners
            </button>
        </div>
    </div> -->

    @if ($showWinnerModal)
        <div class="fixed inset-0 z-30 flex items-center justify-center bg-black/60 p-4" wire:click.self="$set('showWinnerModal', false)">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg sm:max-w-xl overflow-hidden">
                <div class="px-6 pt-6 pb-2 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Random Winners</h3>
                </div>
                <div class="p-6 max-h-[60vh] overflow-y-auto">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($winners as $winner)
                            <li class="py-4">
                                <div class="flex space-x-3">
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between gap-3">
                                            <div>
                                                <h3 class="text-sm font-medium">{{ $winner->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $winner->email }}</p>
                                            </div>
                                            <button wire:click="removeWinner({{ $winner->id }})" class="text-red-600 hover:text-red-900">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="px-6 pb-6 pt-4 border-t border-gray-200 space-y-3">
                    <button wire:click="sendWinnerNotifications" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Send Notifications
                    </button>
                    <button wire:click="$set('showWinnerModal', false)" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
