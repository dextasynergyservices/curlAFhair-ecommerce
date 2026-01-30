<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:30',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
            'about_us' => 'nullable|string|max:2000',
            'footer_text' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
            'meta_title' => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:300',
            // Payment settings
            'payment_paystack_enabled' => 'nullable',
            'payment_paypal_enabled' => 'nullable',
            'payment_stripe_enabled' => 'nullable',
            'payment_bank_transfer_enabled' => 'nullable',
            'payment_cod_enabled' => 'nullable',
        ]);

        $settings = SiteSetting::getSettings();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            $settings->logo_path = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            $settings->favicon_path = $faviconPath;
        }

        // Update other fields
        $settings->site_name = $validated['site_name'];
        $settings->site_email = $validated['site_email'] ?? null;
        $settings->contact_number = $validated['contact_number'] ?? null;
        $settings->about_us = $validated['about_us'] ?? null;
        $settings->footer_text = $validated['footer_text'] ?? null;
        $settings->facebook_url = $validated['facebook_url'] ?? null;
        $settings->twitter_url = $validated['twitter_url'] ?? null;
        $settings->instagram_url = $validated['instagram_url'] ?? null;
        $settings->tiktok_url = $validated['tiktok_url'] ?? null;
        $settings->youtube_url = $validated['youtube_url'] ?? null;
        $settings->currency = $validated['currency'] ?? 'NGN';
        $settings->currency_symbol = $validated['currency_symbol'] ?? '₦';
        $settings->meta_title = $validated['meta_title'] ?? null;
        $settings->meta_description = $validated['meta_description'] ?? null;

        // Update payment settings (checkboxes)
        $settings->payment_paystack_enabled = $request->has('payment_paystack_enabled');
        $settings->payment_paypal_enabled = $request->has('payment_paypal_enabled');
        $settings->payment_stripe_enabled = $request->has('payment_stripe_enabled');
        $settings->payment_bank_transfer_enabled = $request->has('payment_bank_transfer_enabled');
        $settings->payment_cod_enabled = $request->has('payment_cod_enabled');

        $settings->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully!');
    }
}
