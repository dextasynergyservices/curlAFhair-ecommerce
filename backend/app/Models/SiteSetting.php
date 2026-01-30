<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_email',
        'contact_number',
        'logo_path',
        'favicon_path',
        'about_us',
        'footer_text',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'tiktok_url',
        'youtube_url',
        'currency',
        'currency_symbol',
        'meta_title',
        'meta_description',
        'payment_paystack_enabled',
        'payment_paypal_enabled',
        'payment_stripe_enabled',
        'payment_bank_transfer_enabled',
        'payment_cod_enabled',
    ];

    protected $casts = [
        'payment_paystack_enabled' => 'boolean',
        'payment_paypal_enabled' => 'boolean',
        'payment_stripe_enabled' => 'boolean',
        'payment_bank_transfer_enabled' => 'boolean',
        'payment_cod_enabled' => 'boolean',
    ];
    
    /**
     * Get the first settings record or create default
     */
    public static function getSettings()
    {
        return static::first() ?? static::create([
            'site_name' => 'CurlAF Hair',
            'currency' => 'NGN',
            'currency_symbol' => '₦',
            'payment_paystack_enabled' => true,
        ]);
    }

    /**
     * Get enabled payment methods
     */
    public function getEnabledPaymentMethods()
    {
        $methods = [];
        
        if ($this->payment_paystack_enabled) {
            $methods['paystack'] = [
                'name' => 'Paystack',
                'description' => 'Pay with card, bank transfer, or USSD',
                'icon' => '💳',
            ];
        }
        
        if ($this->payment_paypal_enabled) {
            $methods['paypal'] = [
                'name' => 'PayPal',
                'description' => 'Pay with your PayPal account',
                'icon' => '🅿️',
            ];
        }
        
        if ($this->payment_stripe_enabled) {
            $methods['stripe'] = [
                'name' => 'Stripe',
                'description' => 'Pay with credit or debit card',
                'icon' => '💳',
            ];
        }
        
        if ($this->payment_bank_transfer_enabled) {
            $methods['bank_transfer'] = [
                'name' => 'Bank Transfer',
                'description' => 'Pay via direct bank transfer',
                'icon' => '🏦',
            ];
        }
        
        if ($this->payment_cod_enabled) {
            $methods['cod'] = [
                'name' => 'Cash on Delivery',
                'description' => 'Pay when your order arrives',
                'icon' => '💵',
            ];
        }
        
        return $methods;
    }
}
