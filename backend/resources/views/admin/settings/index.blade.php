@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Site Settings</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- General Settings -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">General Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Site Name *</label>
                            <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name ?? '') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Site Email</label>
                                <input type="email" name="site_email" value="{{ old('site_email', $settings->site_email ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="contact@example.com">
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number', $settings->contact_number ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="+234 XXX XXX XXXX">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">About Us</label>
                            <textarea name="about_us" rows="4" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Brief description about your business">{{ old('about_us', $settings->about_us ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Footer Text</label>
                            <input type="text" name="footer_text" value="{{ old('footer_text', $settings->footer_text ?? '') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="© 2024 CurlAF Hair. All rights reserved.">
                        </div>
                    </div>
                </div>

                <!-- Currency Settings -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Currency Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Currency Code</label>
                            <select name="currency" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="NGN" {{ old('currency', $settings->currency ?? 'NGN') === 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                                <option value="USD" {{ old('currency', $settings->currency ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="GBP" {{ old('currency', $settings->currency ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="EUR" {{ old('currency', $settings->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Currency Symbol</label>
                            <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $settings->currency_symbol ?? '₦') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   maxlength="5">
                        </div>
                    </div>
                </div>

                <!-- Payment Gateway Settings -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">💳 Payment Gateway Settings</h3>
                    <p class="text-sm text-gray-500 mb-4">Enable or disable payment methods available at checkout</p>
                    
                    <style>
                        .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
                        .toggle-switch input { opacity: 0; width: 0; height: 0; }
                        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 24px; }
                        .toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
                        .toggle-switch input:checked + .toggle-slider { background-color: #db2777; }
                        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }
                    </style>
                    
                    <div class="space-y-4">
                        <!-- Paystack -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">💳</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Paystack</h4>
                                    <p class="text-sm text-gray-500">Accept card payments, bank transfers, USSD</p>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="payment_paystack_enabled" value="1" 
                                       {{ old('payment_paystack_enabled', $settings->payment_paystack_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <!-- PayPal -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">🅿️</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">PayPal</h4>
                                    <p class="text-sm text-gray-500">Accept payments via PayPal accounts</p>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="payment_paypal_enabled" value="1" 
                                       {{ old('payment_paypal_enabled', $settings->payment_paypal_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <!-- Stripe -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">💳</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Stripe</h4>
                                    <p class="text-sm text-gray-500">Accept credit/debit card payments worldwide</p>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="payment_stripe_enabled" value="1" 
                                       {{ old('payment_stripe_enabled', $settings->payment_stripe_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">🏦</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Bank Transfer</h4>
                                    <p class="text-sm text-gray-500">Accept direct bank transfers (manual verification)</p>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="payment_bank_transfer_enabled" value="1" 
                                       {{ old('payment_bank_transfer_enabled', $settings->payment_bank_transfer_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">💵</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Cash on Delivery</h4>
                                    <p class="text-sm text-gray-500">Customer pays when order is delivered</p>
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="payment_cod_enabled" value="1" 
                                       {{ old('payment_cod_enabled', $settings->payment_cod_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>Note:</strong> Make sure to configure API keys in your <code>.env</code> file for each enabled payment gateway.
                        </p>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Social Media Links</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        Facebook
                                    </span>
                                </label>
                                <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://facebook.com/yourpage">
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        Instagram
                                    </span>
                                </label>
                                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://instagram.com/yourprofile">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        Twitter / X
                                    </span>
                                </label>
                                <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://twitter.com/yourprofile">
                            </div>

                            <div>
                                <label class="block font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                                        TikTok
                                    </span>
                                </label>
                                <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings->tiktok_url ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://tiktok.com/@yourprofile">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    YouTube
                                </span>
                            </label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings->youtube_url ?? '') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://youtube.com/@yourchannel">
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">SEO Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $settings->meta_title ?? '') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="CurlAF Hair - Premium Hair Products"
                                   maxlength="100">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" rows="3" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Shop premium hair products at CurlAF Hair. Quality wigs, bundles, and hair care products."
                                      maxlength="300">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Logo & Favicon -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Branding</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Site Logo</label>
                            <input type="file" name="logo" accept="image/*"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 200x60px. Max 2MB.</p>
                            
                            @if($settings->logo_path ?? false)
                            <div class="mt-3">
                                <p class="text-sm text-gray-500 mb-2">Current Logo:</p>
                                <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Current Logo" class="max-h-16 border rounded p-2 bg-gray-50">
                            </div>
                            @endif
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Favicon</label>
                            <input type="file" name="favicon" accept="image/png,image/x-icon"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 32x32px. PNG or ICO.</p>
                            
                            @if($settings->favicon_path ?? false)
                            <div class="mt-3">
                                <p class="text-sm text-gray-500 mb-2">Current Favicon:</p>
                                <img src="{{ asset('storage/' . $settings->favicon_path) }}" alt="Current Favicon" class="w-8 h-8 border rounded">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="bg-white shadow rounded-lg p-6">
                    <button type="submit" class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-700 transition">
                        Save Settings
                    </button>
                </div>

                <!-- Quick Links -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4 border-b pb-2">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.products.index') }}" class="block text-blue-600 hover:text-blue-800">→ Manage Products</a>
                        <a href="{{ route('admin.categories.index') }}" class="block text-blue-600 hover:text-blue-800">→ Manage Categories</a>
                        <a href="{{ route('admin.orders.index') }}" class="block text-blue-600 hover:text-blue-800">→ View Orders</a>
                        <a href="{{ route('admin.users.index') }}" class="block text-blue-600 hover:text-blue-800">→ Manage Users</a>
                        <a href="{{ route('admin.coupons.index') }}" class="block text-blue-600 hover:text-blue-800">→ Manage Coupons</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
