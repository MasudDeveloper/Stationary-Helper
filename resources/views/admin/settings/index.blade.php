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

                <h4 class="mb-3 text-success"><i class="material-icons-round" style="vertical-align: middle;">chat</i> WhatsApp API Settings</h4>

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

                <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">

                <button type="submit" class="btn btn-primary px-4 py-2 w-100">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
