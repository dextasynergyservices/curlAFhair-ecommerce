<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first(); // Assuming you have a single record for settings
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate and update settings
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'social_links' => 'nullable|array',
        ]);

        // Update site settings
        $settings = SiteSetting::first();
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
