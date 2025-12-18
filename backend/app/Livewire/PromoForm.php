<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PromoCodeMail;
use App\Mail\AdminPromoNotification;
use Illuminate\Support\Facades\RateLimiter;

class PromoForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $wants_newsletter = false;
    public $successMessage = null;
    public $honeypot = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:promos,email',
        'phone' => 'required|string|max:20|unique:promos,phone',
        'honeypot' => 'nullable|prohibited',
    ];

    protected $messages = [
        'email.unique' => 'A promo code has already been sent to this user.',
        'phone.unique' => 'A promo code has already been sent to this user.',
        'honeypot.prohibited' => 'Unable to process your submission.',
    ];

    public function submit()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->successMessage = null;
        $this->name = trim($this->name ?? '');
        $this->email = trim($this->email ?? '');
        $this->phone = trim($this->phone ?? '');

        $rateLimitKey = 'promo-form:' . request()->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->addError('form', 'Too many attempts. Please try again in a minute.');
            return;
        }
        RateLimiter::hit($rateLimitKey, 60);

        $this->validate();

        $alreadyHasPromo = Promo::where('email', $this->email)
            ->orWhere('phone', $this->phone)
            ->exists();

        if ($alreadyHasPromo) {
            $this->addError('form', 'A promo code has already been sent to this user.');
            return;
        }

        $promo = null;

        try {
            DB::transaction(function () use (&$promo) {
                $lastPromo = Promo::latest('id')->lockForUpdate()->first();
                $nextId = $lastPromo ? $lastPromo->id + 1 : 1;
                $promoCode = 'PROMO-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                $promo = Promo::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'wants_newsletter' => $this->wants_newsletter,
                    'promo_code' => $promoCode,
                    'user_id' => auth()->id(),
                ]);
            });
        } catch (\Throwable $e) {
            $this->addError('form', 'We could not submit your request. Please try again shortly.');
            return;
        }

        if ($promo) {
            Mail::to($this->email)->send(new PromoCodeMail($promo->promo_code));

            $adminEmail = config('mail.admin_address', 'admin@curlafhair.com');
            Mail::to($adminEmail)->send(new AdminPromoNotification($promo));
        }

        $this->reset(['name', 'email', 'phone', 'wants_newsletter', 'honeypot']);
        $this->resetValidation();
        $this->successMessage = 'Thank you! Your promo code has been sent to your email.';
    }

    public function render()
    {
        return view('livewire.promo-form');
    }
}