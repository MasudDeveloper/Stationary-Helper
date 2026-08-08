@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<style>
    .settings-container {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }
    .settings-sidebar {
        flex: 0 0 280px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 20px;
        position: sticky;
        top: 20px;
    }
    .settings-nav {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        color: #94a3b8;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        text-decoration: none;
    }
    .settings-nav-item:hover {
        background: rgba(255,255,255,0.05);
        color: #fff;
    }
    .settings-nav-item.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: #fff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    .settings-content {
        flex: 1;
        min-width: 0; /* Prevents overflow */
    }
    .settings-section {
        display: none;
        animation: fadeIn 0.4s ease-out;
    }
    .settings-section.active {
        display: block;
    }
    .settings-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .settings-card-title {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .form-label {
        color: #e2e8f0;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    .form-control-custom {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 12px 18px !important;
        transition: all 0.3s;
    }
    .form-control-custom:focus {
        background: rgba(15, 23, 42, 0.9) !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
    }
    .settings-hint {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 8px;
        line-height: 1.5;
    }
    .btn-save-all {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 16px 30px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }
    .btn-save-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.6);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 991px) {
        .settings-container {
            flex-direction: column;
        }
        .settings-sidebar {
            flex: auto;
            width: 100%;
            position: relative;
            top: 0;
            margin-bottom: 20px;
        }
        .settings-nav {
            flex-direction: row;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        .settings-nav-item {
            white-space: nowrap;
        }
    }
</style>

<div class="mb-4">
    <h2 class="text-white fw-bold mb-1">System Settings</h2>
    <p class="text-muted">Manage global configuration, APIs, and pricing.</p>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4 d-flex align-items-center gap-3" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; border-radius: 12px; padding: 16px 20px;">
        <i class="material-icons-round">check_circle</i>
        <div><strong>Success!</strong> {{ session('success') }}</div>
    </div>
@endif

<form action="{{ route('admin.settings.store') }}" method="POST" id="settingsForm">
    @csrf
    <div class="settings-container">
        
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar">
            <div class="settings-nav">
                <a class="settings-nav-item active" onclick="switchTab('api')">
                    <i class="material-icons-round">api</i> OCR & APIs
                </a>
                <a class="settings-nav-item" onclick="switchTab('pricing')">
                    <i class="material-icons-round">toll</i> Services Pricing
                </a>
                <a class="settings-nav-item" onclick="switchTab('whatsapp')">
                    <i class="material-icons-round">chat</i> WhatsApp Config
                </a>
                <a class="settings-nav-item" onclick="switchTab('payment')">
                    <i class="material-icons-round">payments</i> Payment & Banner
                </a>
            </div>
            
            <div class="mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <button type="submit" class="btn-save-all">
                    <i class="material-icons-round">save</i> Save Changes
                </button>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="settings-content">
            
            <!-- Section: APIs (OCR) -->
            <div id="tab-api" class="settings-section active">
                <div class="settings-card">
                    <div class="settings-card-title text-primary">
                        <i class="material-icons-round">document_scanner</i> OCR API Settings
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Active OCR Engine</label>
                        <select name="ocr_engine" class="form-control form-control-custom">
                            <option value="tesseract" {{ ($settings['ocr_engine'] ?? 'tesseract') === 'tesseract' ? 'selected' : '' }}>Tesseract.js (Free, Browser-based)</option>
                            <option value="ocr_space" {{ ($settings['ocr_engine'] ?? '') === 'ocr_space' ? 'selected' : '' }}>OCR.Space API (Highly Accurate)</option>
                        </select>
                        <div class="settings-hint">Tesseract is free but less accurate for Bengali. OCR.Space requires an API key but provides superior accuracy.</div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">OCR.Space API Key</label>
                        <input type="text" name="ocr_space_api_key" value="{{ $settings['ocr_space_api_key'] ?? '' }}" class="form-control form-control-custom" placeholder="Enter OCR.Space API Key">
                        <div class="settings-hint">Get a free key from <a href="https://ocr.space/ocrapi" target="_blank" style="color: #60a5fa; text-decoration: none;">OCR.Space</a> (25,000 requests/month free).</div>
                    </div>
                </div>
            </div>

            <!-- Section: Pricing & Credits -->
            <div id="tab-pricing" class="settings-section">
                <div class="settings-card">
                    <div class="settings-card-title" style="color: #38bdf8;">
                        <i class="material-icons-round">palette</i> AI Image Generation
                    </div>
                    <div class="mb-2">
                        <label class="form-label">AI Image Generation Cost (Credits per Image)</label>
                        <input type="number" step="0.01" min="0" name="ai_image_cost" value="{{ $settings['ai_image_cost'] ?? '0' }}" class="form-control form-control-custom" placeholder="0 for Free">
                        <div class="settings-hint">Set to <strong class="text-success">0</strong> to make AI image generation completely FREE for all users.</div>
                    </div>
                </div>

                <div class="settings-card">
                    <div class="settings-card-title" style="color: #f472b6;">
                        <i class="material-icons-round">auto_awesome_mosaic</i> Utilities Pricing
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">CV WhatsApp Send Cost</label>
                            <input type="number" step="0.01" min="0" name="cost_cv_whatsapp_send" value="{{ $settings['cost_cv_whatsapp_send'] ?? '5' }}" class="form-control form-control-custom">
                            <div class="settings-hint">Cost for sending CV directly to WhatsApp.</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Doc WhatsApp Send Cost</label>
                            <input type="number" step="0.01" min="0" name="cost_document_whatsapp_send" value="{{ $settings['cost_document_whatsapp_send'] ?? '5' }}" class="form-control form-control-custom">
                            <div class="settings-hint">Cost for sending Document directly to WhatsApp.</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">OCR Scanner Cost</label>
                            <input type="number" step="0.01" min="0" name="cost_ocr_scanner" value="{{ $settings['cost_ocr_scanner'] ?? '5' }}" class="form-control form-control-custom">
                            <div class="settings-hint">Cost for extracting text from an image.</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Background Removal Cost</label>
                            <input type="number" step="0.01" min="0" name="cost_bg_removal" value="{{ $settings['cost_bg_removal'] ?? '5' }}" class="form-control form-control-custom">
                            <div class="settings-hint">Cost for removing background from an image.</div>
                        </div>
                    </div>
                    <div class="p-3 mt-2" style="background: rgba(16, 185, 129, 0.1); border-radius: 12px; border: 1px solid rgba(16,185,129,0.2);">
                        <i class="material-icons-round text-success" style="vertical-align: middle; font-size: 20px;">info</i>
                        <span style="color: #cbd5e1; font-size: 0.9rem; margin-left: 8px;"><strong>Note:</strong> Set any cost to <span class="text-success fw-bold">0</span> to make it FREE. Template printing costs are managed separately.</span>
                    </div>
                </div>
            </div>

            <!-- Section: WhatsApp API -->
            <div id="tab-whatsapp" class="settings-section">
                <div class="settings-card">
                    <div class="settings-card-title text-success">
                        <i class="material-icons-round">mark_chat_read</i> WhatsApp Integration
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">WhatsApp Module Status</label>
                        <select name="whatsapp_module_status" class="form-control form-control-custom">
                            <option value="enabled" {{ ($settings['whatsapp_module_status'] ?? 'enabled') === 'enabled' ? 'selected' : '' }}>Enabled (Show WhatsApp Features)</option>
                            <option value="disabled" {{ ($settings['whatsapp_module_status'] ?? 'enabled') === 'disabled' ? 'selected' : '' }}>Disabled (Hide WhatsApp Features)</option>
                        </select>
                        <div class="settings-hint">If Disabled, all WhatsApp-related buttons will be completely hidden.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">WhatsApp API Provider</label>
                        <select name="whatsapp_provider" class="form-control form-control-custom">
                            <option value="none" {{ ($settings['whatsapp_provider'] ?? 'none') === 'none' ? 'selected' : '' }}>None (Use Free wa.me Link)</option>
                            <option value="ultramsg" {{ ($settings['whatsapp_provider'] ?? '') === 'ultramsg' ? 'selected' : '' }}>Ultramsg (Automated API)</option>
                        </select>
                        <div class="settings-hint">If 'None' is selected, it opens WhatsApp Web/App manually for free sending.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Ultramsg Instance ID</label>
                            <input type="text" name="whatsapp_instance_id" value="{{ $settings['whatsapp_instance_id'] ?? '' }}" class="form-control form-control-custom" placeholder="e.g. instance12345">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Ultramsg Token</label>
                            <input type="text" name="whatsapp_token" value="{{ $settings['whatsapp_token'] ?? '' }}" class="form-control form-control-custom" placeholder="e.g. y0wux... ">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Payment & Misc -->
            <div id="tab-payment" class="settings-section">
                <div class="settings-card">
                    <div class="settings-card-title text-warning">
                        <i class="material-icons-round">account_balance_wallet</i> Payment Methods (Recharge)
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">bKash Number</label>
                            <input type="text" name="payment_bkash" value="{{ $settings['payment_bkash'] ?? '' }}" class="form-control form-control-custom" placeholder="e.g. 017XX-XXXXXX">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Nagad Number</label>
                            <input type="text" name="payment_nagad" value="{{ $settings['payment_nagad'] ?? '' }}" class="form-control form-control-custom" placeholder="e.g. 016XX-XXXXXX">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Rocket Number</label>
                            <input type="text" name="payment_rocket" value="{{ $settings['payment_rocket'] ?? '' }}" class="form-control form-control-custom" placeholder="e.g. 019XX-XXXXXX">
                        </div>
                    </div>
                </div>

                <div class="settings-card mt-4">
                    <div class="settings-card-title text-success">
                        <i class="material-icons-round">payment</i> AmarGateway Auto-Verification Configuration
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Manual Bkash Payment Status</label>
                            <select name="gateway_manual_status" class="form-control form-control-custom">
                                <option value="enabled" {{ ($settings['gateway_manual_status'] ?? 'enabled') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                                <option value="disabled" {{ ($settings['gateway_manual_status'] ?? 'enabled') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <div class="settings-hint">যদি এটি ইনেবল থাকে, ইউজাররা ম্যানুয়ালি Bkash পেমেন্ট করতে পারবে।</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">AmarGateway Auto Payment Status</label>
                            <select name="gateway_amargateway_status" class="form-control form-control-custom">
                                <option value="enabled" {{ ($settings['gateway_amargateway_status'] ?? 'disabled') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                                <option value="disabled" {{ ($settings['gateway_amargateway_status'] ?? 'disabled') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <div class="settings-hint">যদি এটি ইনেবল থাকে, ইউজাররা গেটওয়ের মাধ্যমে অটোমেটিক পেমেন্ট করতে পারবে।</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Merchant Secret Key (X-Merchant-Key)</label>
                            <input type="text" name="gateway_merchant_key" value="{{ $settings['gateway_merchant_key'] ?? '' }}" class="form-control form-control-custom" placeholder="mc_r15KAbL9...">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Webhook Secret Key (MERCHANT_WEBHOOK_SECRET)</label>
                            <input type="text" name="gateway_webhook_secret" value="{{ $settings['gateway_webhook_secret'] ?? '' }}" class="form-control form-control-custom" placeholder="webhook_secret_key...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Gateway Webhook Callback URL</label>
                            <input type="text" readonly value="{{ url('/api/payment/callback') }}" class="form-control form-control-custom" style="background: rgba(0,0,0,0.3); color: #818cf8; font-family: monospace;">
                            <div class="settings-hint">আপনার AmarGateway মার্চেন্ট প্যানেলে এই Webhook URL টি সেভ করুন।</div>
                        </div>
                    </div>
                </div>

                <div class="settings-card mb-0">
                    <div class="settings-card-title" style="color: #c084fc;">
                        <i class="material-icons-round">image</i> Upgrade Page Banner
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Banner Image URL</label>
                        <input type="text" name="upgrade_banner_url" value="{{ $settings['upgrade_banner_url'] ?? '' }}" class="form-control form-control-custom" placeholder="https://imgur.com/your-image.png">
                        <div class="settings-hint">Recommended size: <strong>1200x300 px</strong>. Upload to a free host like Imgur and paste the direct image link here.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
    function switchTab(tabId) {
        // Hide all sections
        document.querySelectorAll('.settings-section').forEach(el => {
            el.classList.remove('active');
        });
        
        // Remove active class from all nav items
        document.querySelectorAll('.settings-nav-item').forEach(el => {
            el.classList.remove('active');
        });
        
        // Show target section
        document.getElementById('tab-' + tabId).classList.add('active');
        
        // Add active class to clicked nav item
        event.currentTarget.classList.add('active');
    }
</script>
@endsection
