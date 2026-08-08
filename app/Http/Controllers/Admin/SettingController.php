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
            'whatsapp_module_status' => 'nullable|string',
            'whatsapp_provider' => 'nullable|string',
            'whatsapp_instance_id' => 'nullable|string',
            'whatsapp_token' => 'nullable|string',
            'ai_image_cost' => 'nullable|numeric|min:0',
            'cost_cv_whatsapp_send' => 'nullable|numeric|min:0',
            'cost_document_whatsapp_send' => 'nullable|numeric|min:0',
            'cost_ocr_scanner' => 'nullable|numeric|min:0',
            'cost_bg_removal' => 'nullable|numeric|min:0',
            'payment_bkash' => 'nullable|string',
            'payment_nagad' => 'nullable|string',
            'payment_rocket' => 'nullable|string',
            'upgrade_banner_url' => 'nullable|string',
            'gateway_manual_status' => 'nullable|string',
            'gateway_amargateway_status' => 'nullable|string',
            'gateway_merchant_key' => 'nullable|string',
            'gateway_webhook_secret' => 'nullable|string',
        ]);

        Setting::updateOrCreate(['key' => 'ocr_engine'], ['value' => $request->ocr_engine]);
        Setting::updateOrCreate(['key' => 'ocr_space_api_key'], ['value' => $request->ocr_space_api_key]);
        Setting::updateOrCreate(['key' => 'whatsapp_module_status'], ['value' => $request->whatsapp_module_status ?? 'enabled']);
        Setting::updateOrCreate(['key' => 'whatsapp_provider'], ['value' => $request->whatsapp_provider]);
        Setting::updateOrCreate(['key' => 'whatsapp_instance_id'], ['value' => $request->whatsapp_instance_id]);
        Setting::updateOrCreate(['key' => 'whatsapp_token'], ['value' => $request->whatsapp_token]);
        Setting::updateOrCreate(['key' => 'ai_image_cost'], ['value' => $request->ai_image_cost ?? '0']);
        Setting::updateOrCreate(['key' => 'cost_cv_whatsapp_send'], ['value' => $request->cost_cv_whatsapp_send ?? '5']);
        Setting::updateOrCreate(['key' => 'cost_document_whatsapp_send'], ['value' => $request->cost_document_whatsapp_send ?? '5']);
        Setting::updateOrCreate(['key' => 'cost_ocr_scanner'], ['value' => $request->cost_ocr_scanner ?? '5']);
        Setting::updateOrCreate(['key' => 'cost_bg_removal'], ['value' => $request->cost_bg_removal ?? '5']);
        Setting::updateOrCreate(['key' => 'payment_bkash'], ['value' => $request->payment_bkash]);
        Setting::updateOrCreate(['key' => 'payment_nagad'], ['value' => $request->payment_nagad]);
        Setting::updateOrCreate(['key' => 'payment_rocket'], ['value' => $request->payment_rocket]);
        Setting::updateOrCreate(['key' => 'upgrade_banner_url'], ['value' => $request->upgrade_banner_url]);
        Setting::updateOrCreate(['key' => 'gateway_manual_status'], ['value' => $request->gateway_manual_status ?? 'disabled']);
        Setting::updateOrCreate(['key' => 'gateway_amargateway_status'], ['value' => $request->gateway_amargateway_status ?? 'disabled']);
        Setting::updateOrCreate(['key' => 'gateway_merchant_key'], ['value' => $request->gateway_merchant_key]);
        Setting::updateOrCreate(['key' => 'gateway_webhook_secret'], ['value' => $request->gateway_webhook_secret]);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
