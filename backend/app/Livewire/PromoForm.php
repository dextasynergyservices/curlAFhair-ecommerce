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
    public $country_code = 'NG'; // Default to Nigeria
    public $wants_newsletter = false;
    public $successMessage = null;
    public $honeypot = '';

    protected function rules()
    {
        $phoneValidation = [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                $value = preg_replace('/\s+/', '', $value);
                $length = $this->country_code === 'US' ? 10 : 10;

                if (strlen($value) !== $length) {
                    $fail("The phone number must be {$length} digits long.");
                }
            },
            'unique:promos,phone',
        ];

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:promos,email',
            'phone' => $phoneValidation,
            'country_code' => 'required|in:NG,US',
            'honeypot' => 'nullable|prohibited',
        ];
    }

    protected $messages = [
        'email.unique' => 'A promo code has already been sent to this user.',
        'phone.unique' => 'A promo code has already been sent to this user.',
        'honeypot.prohibited' => 'Unable to process your submission.',
    ];

    public function updated($field)
    {
        if ($field === 'country_code') {
            $this->reset('phone');
        }
    }
    
    public function submit()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->successMessage = null;
        $this->name = trim($this->name ?? '');
        $this->email = trim($this->email ?? '');
        $this->phone = preg_replace('/\s+/', '', trim($this->phone ?? ''));

        // Prepend country code before validation
        $phoneWithCountryCode = ($this->country_code === 'US' ? '+1' : '+234') . $this->phone;

        $rateLimitKey = 'promo-form:' . request()->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->addError('form', 'Too many attempts. Please try again in a minute.');
            return;
        }
        RateLimiter::hit($rateLimitKey, 60);

        $this->validate();

        $promo = null;

        try {
            DB::transaction(function () use (&$promo, $phoneWithCountryCode) {
                $lastPromo = Promo::latest('id')->lockForUpdate()->first();
                $nextId = $lastPromo ? $lastPromo->id + 1 : 1;
                $promoCode = 'PROMO-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                $promo = Promo::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $phoneWithCountryCode,
                    'wants_newsletter' => $this->wants_newsletter,
                    'promo_code' => $promoCode,
                    'user_id' => auth()->id(),
                ]);
            });
        } catch (\Throwable $e) {
            $this->addError('form', 'We could not submit your request. Please try again shortly.');
            return;
        }

        // Send emails - wrapped in try-catch to prevent email failures from breaking the flow
        if ($promo) {
            try {
                Mail::to($this->email)->send(new PromoCodeMail($promo->promo_code));

                $adminEmail = config('mail.admin_address', 'admin@curlafhair.com');
                Mail::to($adminEmail)->send(new AdminPromoNotification($promo));
            } catch (\Throwable $e) {
                // Log the error but don't fail the submission
                \Log::error('Failed to send promo emails: ' . $e->getMessage(), [
                    'promo_id' => $promo->id,
                    'email' => $this->email,
                ]);
                // Continue to show success message - user's promo code is saved
            }
        }

        $this->reset(['name', 'email', 'phone', 'wants_newsletter', 'honeypot', 'country_code']);
        $this->resetValidation();
        $this->successMessage = 'Thank you! Your promo code has been sent to your email.';
    }

    public function render()
    {
        return view('livewire.promo-form');
    }
}
