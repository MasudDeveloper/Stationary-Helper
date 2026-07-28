<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        // Get all settings into a key-value array
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ocr_engine' => 'required|in:tesseract,ocr_space',
            'ocr_space_api_key' => 'nullable|string',
            'whatsapp_provider' => 'nullable|string',
            'whatsapp_instance_id' => 'nullable|string',
            'whatsapp_token' => 'nullable|string',
            'ai_image_cost' => 'nullable|numeric|min:0',
        ]);

        Setting::updateOrCreate(['key' => 'ocr_engine'], ['value' => $request->ocr_engine]);
        Setting::updateOrCreate(['key' => 'ocr_space_api_key'], ['value' => $request->ocr_space_api_key]);
        Setting::updateOrCreate(['key' => 'whatsapp_provider'], ['value' => $request->whatsapp_provider]);
        Setting::updateOrCreate(['key' => 'whatsapp_instance_id'], ['value' => $request->whatsapp_instance_id]);
        Setting::updateOrCreate(['key' => 'whatsapp_token'], ['value' => $request->whatsapp_token]);
        Setting::updateOrCreate(['key' => 'ai_image_cost'], ['value' => $request->ai_image_cost ?? '0']);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
