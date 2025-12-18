<?php

namespace App\Livewire;

use App\Mail\CustomizedWinnerNotification;
use App\Models\Promo;
use App\Models\WinningCode;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class PromoList extends Component
{
    use WithPagination;

    public $showWinnerModal = false;
    public $numberOfWinners = 1;
    public $winners;
    public $showCodeModal = false;
    public $newCode = '';
    public $toastMessage = null;
    public $toastType = 'success';
    public $winningPage = 1;

    public $showEditCodeModal = false;
    public $editCodeId = null;
    public $editingCode = '';

    public $showMatchesModal = false;
    public $matchedPromos = [];

    public $showComposeEmailModal = false;
    public $emailSubject = '';
    public $emailBody = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->winners = collect();
    }

    public function openCodeModal()
    {
        $this->resetErrorBag();
        $this->toastMessage = null;
        $this->toastType = 'success';
        $this->newCode = '';
        $this->showCodeModal = true;
    }

    public function saveCode()
    {
        $this->resetErrorBag();
        $this->validate([
            'newCode' => 'required|string',
        ]);

        $rawCodes = preg_split('/[,\\n]+/', $this->newCode);
        $codes = collect($rawCodes)
            ->map(fn ($c) => strtoupper(trim($c)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($codes)) {
            $this->addError('newCode', 'Please enter at least one code.');
            return;
        }

        $existing = WinningCode::whereIn('code', $codes)->pluck('code')->toArray();
        if (!empty($existing)) {
            $this->toast('Duplicate codes: ' . implode(', ', $existing), 'error');
            return;
        }

        try {
            foreach ($codes as $code) {
                WinningCode::create(['code' => $code]);
            }
            $this->toast('Promo code(s) added.', 'success');
            $this->showCodeModal = false;
            $this->newCode = '';
            $this->resetPage('winningPage');
        } catch (\Throwable $e) {
            $this->toast('Failed to add code(s). Please try again.', 'error');
        }
    }

    public function deleteCode($codeId)
    {
        $code = WinningCode::find($codeId);
        if (! $code) {
            $this->toast('Code not found.', 'error');
            return;
        }

        $code->delete();
        $this->toast('Promo code deleted.', 'success');
        $this->resetPage('winningPage');
    }

    public function editCode($codeId)
    {
        $code = WinningCode::find($codeId);
        if (! $code) {
            $this->toast('Code not found.', 'error');
            return;
        }

        $this->editCodeId = $codeId;
        $this->editingCode = $code->code;
        $this->showEditCodeModal = true;
    }

    public function updateCode()
    {
        $this->resetErrorBag();
        $this->validate([
            'editingCode' => 'required|string|max:50',
        ]);

        $new = strtoupper(trim($this->editingCode));
        if (! $new) {
            $this->addError('editingCode', 'Please enter a code.');
            return;
        }

        $exists = WinningCode::where('code', $new)
            ->where('id', '!=', $this->editCodeId)
            ->exists();

        if ($exists) {
            $this->toast('Duplicate code: ' . $new, 'error');
            return;
        }

        $code = WinningCode::find($this->editCodeId);
        if (! $code) {
            $this->toast('Code not found.', 'error');
            return;
        }

        $code->update(['code' => $new]);
        $this->toast('Promo code updated.', 'success');
        $this->showEditCodeModal = false;
        $this->resetPage('winningPage');
    }

    public function openMatchesModal()
    {
        $winningCodes = WinningCode::pluck('code');
        $this->matchedPromos = Promo::whereIn('promo_code', $winningCodes)
            ->orderByDesc('created_at')
            ->get();
        $this->showMatchesModal = true;
    }

    protected function toast(string $message, string $type = 'success'): void
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
    }

    public function pickRandomWinners()
    {
        $this->validate([
            'numberOfWinners' => 'required|integer|min:1',
        ]);

        $this->winners = Promo::inRandomOrder()->limit($this->numberOfWinners)->get();
        $this->showWinnerModal = true;
    }

    public function addWinner($promoId)
    {
        $promo = Promo::find($promoId);
        if ($promo && !$this->winners->contains($promo)) {
            $this->winners->push($promo);
        }
    }

    public function removeWinner($winnerId)
    {
        $this->winners = $this->winners->where('id', '!=', $winnerId);
    }

    public function sendWinnerNotifications()
    {
        foreach ($this->winners as $winner) {
            // Here you would typically dispatch a job to send an email or a notification
            // For example:
            // \App\Jobs\SendWinnerNotification::dispatch($winner);
            // Or:
            // Mail::to($winner->email)->send(new \App\Mail\WinnerNotification($winner));
        }

        session()->flash('success', 'Winner notifications have been sent!');

        $this->showWinnerModal = false;
        $this->winners = collect();
        $this->numberOfWinners = 1;
    }

    public function sendMatchedWinnersEmails()
    {
        if (empty($this->matchedPromos) || count($this->matchedPromos) === 0) {
            $this->toast('No matched winners to send emails to.', 'error');
            return;
        }

        // Close matches modal and open compose email modal
        $this->showMatchesModal = false;
        $this->emailSubject = 'Congratulations! You\'re a Winner!';
        $this->emailBody = '';
        $this->showComposeEmailModal = true;
    }

    public function sendCustomizedEmails()
    {
        $this->resetErrorBag();
        $this->validate([
            'emailSubject' => 'required|string|max:255',
            'emailBody' => 'required|string',
        ]);

        if (empty($this->matchedPromos) || count($this->matchedPromos) === 0) {
            $this->toast('No matched winners to send emails to.', 'error');
            return;
        }

        $sentCount = 0;
        foreach ($this->matchedPromos as $promo) {
            try {
                // Replace placeholders with actual data
                $customizedSubject = str_replace(
                    ['{name}', '{email}', '{promo_code}', '{phone}'],
                    [$promo->name, $promo->email, $promo->promo_code, $promo->phone ?? 'N/A'],
                    $this->emailSubject
                );

                $customizedBody = str_replace(
                    ['{name}', '{email}', '{promo_code}', '{phone}'],
                    [$promo->name, $promo->email, $promo->promo_code, $promo->phone ?? 'N/A'],
                    $this->emailBody
                );

                // Send the customized email
                Mail::to($promo->email)->send(new CustomizedWinnerNotification($promo, $customizedSubject, $customizedBody));
                $sentCount++;
            } catch (\Exception $e) {
                // Log error but continue with other emails
                \Log::error('Failed to send email to ' . $promo->email . ': ' . $e->getMessage());
            }
        }

        $this->toast("Email notifications have been sent to {$sentCount} winner(s)!", 'success');
        $this->showComposeEmailModal = false;
        $this->emailSubject = '';
        $this->emailBody = '';
    }

    public function closeComposeEmailModal()
    {
        $this->showComposeEmailModal = false;
        $this->emailSubject = '';
        $this->emailBody = '';
    }

    public function closeEditCodeModal()
    {
        $this->showEditCodeModal = false;
        $this->editCodeId = null;
        $this->editingCode = '';
    }

    public function render()
    {
        $promos = Promo::orderByDesc('created_at')->paginate(10);
        $totalSubmissions = Promo::count();
        $totalNewsletters = Promo::where('wants_newsletter', true)->count();
        $winningCodes = WinningCode::orderBy('code')->paginate(10, ['*'], 'winningPage');

        return view('livewire.promo-list', [
            'promos' => $promos,
            'totalSubmissions' => $totalSubmissions,
            'totalNewsletters' => $totalNewsletters,
            'winningCodes' => $winningCodes,
        ]);
    }
}
