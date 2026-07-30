@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="glass p-4">
            <h2 class="mb-4">System Settings</h2>

            @if(session('success'))
                <div class="alert alert-success mb-4" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #10b981;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                
                <h4 class="mb-3 text-primary"><i class="material-icons-round" style="vertical-align: middle;">document_scanner</i> OCR API Settings</h4>
                
                <div class="form-group mb-4">
                    <label>Active OCR Engine</label>
                    <select name="ocr_engine" class="form-control" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <option value="tesseract" {{ ($settings['ocr_engine'] ?? 'tesseract') === 'tesseract' ? 'selected' : '' }}>Tesseract.js (Free, Browser-based)</option>
                        <option value="ocr_space" {{ ($settings['ocr_engine'] ?? '') === 'ocr_space' ? 'selected' : '' }}>OCR.Space API (Highly Accurate)</option>
                    </select>
                    <small class="text-muted mt-2 d-block">Tesseract is free but less accurate for Bengali. OCR.Space requires an API key but is highly accurate.</small>
                </div>

                <div class="form-group mb-4">
                    <label>OCR.Space API Key</label>
                    <input type="text" name="ocr_space_api_key" value="{{ $settings['ocr_space_api_key'] ?? '' }}" class="form-control" placeholder="Enter OCR.Space API Key" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    <small class="text-muted mt-2 d-block">Get a free key from <a href="https://ocr.space/ocrapi" target="_blank" style="color: #6366f1;">OCR.Space</a> (25,000 requests/month free).</small>
                </div>

                <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">

                <h4 class="mb-3 text-info" style="color: #38bdf8 !important;"><i class="material-icons-round" style="vertical-align: middle;">palette</i> AI Hub (Image Generation) Settings</h4>

                <div class="form-group mb-4">
                    <label>AI Image Generation Cost (Credits per Image)</label>
                    <input type="number" step="0.01" min="0" name="ai_image_cost" value="{{ $settings['ai_image_cost'] ?? '0' }}" class="form-control" placeholder="Enter cost in credits (0 for Free)" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    <small class="text-muted mt-2 d-block" style="color: #94a3b8 !important;">Set to <strong style="color: #10b981;">0</strong> to make AI image generation completely FREE for all users. If you set any value (e.g. 1.00 or 5.00), that many credits will be deducted per generated image.</small>
                </div>

                <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">

                <h4 class="mb-3 text-primary"><i class="material-icons-round" style="vertical-align: middle;">toll</i> Other Tools Pricing (Credits)</h4>
                
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label>CV WhatsApp Send Cost</label>
                        <input type="number" step="0.01" min="0" name="cost_cv_whatsapp_send" value="{{ $settings['cost_cv_whatsapp_send'] ?? '5' }}" class="form-control" placeholder="e.g. 5" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <small class="text-muted mt-2 d-block">Cost for sending CV directly to WhatsApp.</small>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label>Document WhatsApp Send Cost</label>
                        <input type="number" step="0.01" min="0" name="cost_document_whatsapp_send" value="{{ $settings['cost_document_whatsapp_send'] ?? '5' }}" class="form-control" placeholder="e.g. 5" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <small class="text-muted mt-2 d-block">Cost for sending Document directly to WhatsApp.</small>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label>OCR Scanner Cost</label>
                        <input type="number" step="0.01" min="0" name="cost_ocr_scanner" value="{{ $settings['cost_ocr_scanner'] ?? '5' }}" class="form-control" placeholder="e.g. 5" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <small class="text-muted mt-2 d-block">Cost for extracting text from an image.</small>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label>Background Removal Cost</label>
                        <input type="number" step="0.01" min="0" name="cost_bg_removal" value="{{ $settings['cost_bg_removal'] ?? '5' }}" class="form-control" placeholder="e.g. 5" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <small class="text-muted mt-2 d-block">Cost for removing background from an image.</small>
                    </div>
                </div>
                <small class="text-muted mb-4 d-block" style="color: #94a3b8 !important;"><strong>Note:</strong> Set any cost to <strong style="color: #10b981;">0</strong> to make it FREE. CV and Document printing costs are set individually per template.</small>

                <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">

                <h4 class="mb-3 text-success"><i class="material-icons-round" style="vertical-align: middle;">chat</i> WhatsApp API Settings</h4>

                <div class="form-group mb-4">
                    <label>WhatsApp Module Status</label>
                    <select name="whatsapp_module_status" class="form-control" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <option value="enabled" {{ ($settings['whatsapp_module_status'] ?? 'enabled') === 'enabled' ? 'selected' : '' }}>Enabled (Show WhatsApp Features)</option>
                        <option value="disabled" {{ ($settings['whatsapp_module_status'] ?? 'enabled') === 'disabled' ? 'selected' : '' }}>Disabled (Hide WhatsApp Features)</option>
                    </select>
                    <small class="text-muted mt-2 d-block">If 'Disabled' is selected, all WhatsApp-related buttons and scanners will be hidden across the system.</small>
                </div>

                <div class="form-group mb-4">
                    <label>WhatsApp API Provider</label>
                    <select name="whatsapp_provider" class="form-control" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <option value="none" {{ ($settings['whatsapp_provider'] ?? 'none') === 'none' ? 'selected' : '' }}>None (Use Free wa.me Link)</option>
                        <option value="ultramsg" {{ ($settings['whatsapp_provider'] ?? '') === 'ultramsg' ? 'selected' : '' }}>Ultramsg (Automated API)</option>
                    </select>
                    <small class="text-muted mt-2 d-block">If 'None' is selected, it will open WhatsApp Web/App manually to send the message for free.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label>Ultramsg Instance ID</label>
                        <input type="text" name="whatsapp_instance_id" value="{{ $settings['whatsapp_instance_id'] ?? '' }}" class="form-control" placeholder="e.g. instance12345" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label>Ultramsg Token</label>
                        <input type="text" name="whatsapp_token" value="{{ $settings['whatsapp_token'] ?? '' }}" class="form-control" placeholder="e.g. y0wux... " style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                </div>

                <h4 class="mb-3 text-warning mt-4"><i class="material-icons-round" style="vertical-align: middle;">payments</i> Payment Methods (Upgrade & Recharge)</h4>
                
                <div class="row">
                    <div class="col-md-4 form-group mb-4">
                        <label>bKash Number</label>
                        <input type="text" name="payment_bkash" value="{{ $settings['payment_bkash'] ?? '' }}" class="form-control" placeholder="e.g. 017XX-XXXXXX" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                    <div class="col-md-4 form-group mb-4">
                        <label>Nagad Number</label>
                        <input type="text" name="payment_nagad" value="{{ $settings['payment_nagad'] ?? '' }}" class="form-control" placeholder="e.g. 016XX-XXXXXX" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                    <div class="col-md-4 form-group mb-4">
                        <label>Rocket Number</label>
                        <input type="text" name="payment_rocket" value="{{ $settings['payment_rocket'] ?? '' }}" class="form-control" placeholder="e.g. 019XX-XXXXXX" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                </div>

                <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">

                <h4 class="mb-3 text-info"><i class="material-icons-round" style="vertical-align: middle;">image</i> Upgrade Page Banner</h4>
                <div class="form-group mb-4">
                    <label>Banner Image URL</label>
                    <input type="text" name="upgrade_banner_url" value="{{ $settings['upgrade_banner_url'] ?? '' }}" class="form-control" placeholder="Enter image URL" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1);">
                    <small class="text-muted mt-2 d-block">Recommended size: <strong>1200 x 300 pixels</strong> (or similar ultra-wide aspect ratio). You can upload to a free image host like Imgur and paste the direct link (.jpg/.png) here.</small>
                </div>

                <button type="submit" class="btn btn-primary px-4 py-2 w-100 mt-3">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
