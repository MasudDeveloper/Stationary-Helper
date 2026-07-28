@extends('layouts.app')

@section('title', 'স্টাইল কাস্টমাইজ করুন - সহজ কাজ')

@section('content')
<style>
    .customize-wrapper {
        display: flex;
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
        padding-top: 10px;
    }

    .controls-sidebar {
        width: 380px;
        flex-shrink: 0;
    }

    .canvas-preview-area {
        flex: 1;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 20px;
        min-height: 600px;
        position: relative;
    }

    #custom-canvas {
        max-width: 100%;
        max-height: 70vh;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        border-radius: 8px;
        background: #111827;
    }
</style>

<div style="margin-bottom: 25px;">
    <a href="{{ route('design.ai_templates') }}" style="text-decoration: none; color: #818cf8; display: inline-flex; align-items: center; gap: 6px; font-weight: 600; padding: 8px 16px; background: rgba(99, 102, 241, 0.1); border-radius: 8px; border: 1px solid rgba(99, 102, 241, 0.2);">
        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i> টেমপ্লেট গ্যালারিতে ফিরে যান
    </a>
</div>

<div class="customize-wrapper">
    <!-- Controls Sidebar -->
    <div class="controls-sidebar">
        <div class="glass" style="padding: 30px; display: flex; flex-direction: column; gap: 20px; border-radius: 15px;">
            <h3 style="color: #fff; margin: 0; font-size: 1.4rem; font-weight: 700;">পোস্টার কাস্টমাইজ করুন</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">নিচের তথ্যগুলো পূরণ করুন, পোস্টার প্রিভিউ স্বয়ংক্রিয়ভাবে আপডেট হবে।</p>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 5px 0;">

            <!-- Name Field -->
            @if ($template->inputs_schema['name'] ?? false)
            <div class="form-group" style="margin: 0;">
                <label class="form-label" style="font-weight: 500;">নাম (Name)</label>
                <input type="text" id="input-name" class="form-control" placeholder="যেমন: Nayan Akram" value="Nayan Akram" oninput="updatePoster()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            @endif

            <!-- Number Field -->
            @if ($template->inputs_schema['number'] ?? false)
            <div class="form-group" style="margin: 0;">
                <label class="form-label" style="font-weight: 500;">জার্সি নম্বর (Jersey Number)</label>
                <input type="number" id="input-number" class="form-control" placeholder="যেমন: 10" value="10" min="0" max="99" oninput="updatePoster()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            @endif

            <!-- User Photo Upload -->
            @if ($template->inputs_schema['photo'] ?? false)
            <div class="form-group" style="margin: 0;">
                <label class="form-label" style="font-weight: 500;">আপনার ছবি আপলোড করুন</label>
                <input type="file" id="input-photo" class="form-control" accept="image/*" onchange="handlePhotoUpload(event)" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); padding: 10px;">
                
                <div id="photo-adjustments" style="display: none; margin-top: 15px; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px;">
                    <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted);">ছবির সাইজ এডজাস্ট (Scale)</label>
                    <input type="range" id="photo-scale" min="0.1" max="3" step="0.05" value="1.0" class="form-control" style="padding: 0; height: 10px; background: rgba(255,255,255,0.1);" oninput="updatePoster()">
                    
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <div style="flex: 1;">
                            <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted);">X পজিশন</label>
                            <input type="range" id="photo-x-offset" min="-200" max="200" value="0" class="form-control" style="padding: 0; height: 10px; background: rgba(255,255,255,0.1);" oninput="updatePoster()">
                        </div>
                        <div style="flex: 1;">
                            <label class="form-label" style="font-size: 0.75rem; color: var(--text-muted);">Y পজিশন</label>
                            <input type="range" id="photo-y-offset" min="-200" max="200" value="0" class="form-control" style="padding: 0; height: 10px; background: rgba(255,255,255,0.1);" oninput="updatePoster()">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <hr style="border-color: rgba(255,255,255,0.1); margin: 5px 0;">

            <!-- Pricing/Generation Block -->
            <div style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">জেনারেশন খরচ:</span>
                    <span style="font-weight: 700; color: #818cf8; font-size: 1.1rem;">
                        @if ($template->is_premium)
                            ৳{{ Auth::user()->role === 'business' ? '1.00' : number_format($template->credits_cost, 2) }} ক্রেডিট
                        @else
                            ফ্রি
                        @endif
                    </span>
                </div>

                <button onclick="generatePoster()" class="btn btn-primary" style="width: 100%; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="material-icons-round" style="vertical-align: middle;">file_download</i> ডাউনলোড করুন
                </button>
            </div>
        </div>
    </div>

    <!-- Canvas Preview Area -->
    <div class="canvas-preview-area">
        <div id="canvas-loading" style="color: #818cf8; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="animation: spin 2s linear infinite;">sync</i> টেমপ্লেট লোড হচ্ছে...
        </div>
        <canvas id="custom-canvas" style="display: none;"></canvas>
    </div>
</div>

<meta id="template-data" data-overlay-settings="{{ json_encode($template->overlay_settings) }}">

<script>
    // Configuration from database
    const overlaySettings = JSON.parse(document.getElementById('template-data').dataset.overlaySettings);
    const thumbnailPath = "{{ $template->thumbnail_path }}";

    let canvas = document.getElementById('custom-canvas');
    let ctx = canvas.getContext('2d');
    let bgImage = new Image();
    let userPhoto = null;

    // Load background template
    bgImage.crossOrigin = "anonymous";
    bgImage.src = thumbnailPath;
    bgImage.onload = function() {
        document.getElementById('canvas-loading').style.display = 'none';
        canvas.style.display = 'block';
        
        // Match canvas dimensions to the background image
        canvas.width = bgImage.naturalWidth || 800;
        canvas.height = bgImage.naturalHeight || 1000;
        
        updatePoster();
    };

    function handlePhotoUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            userPhoto = new Image();
            userPhoto.src = e.target.result;
            userPhoto.onload = function() {
                document.getElementById('photo-adjustments').style.display = 'block';
                updatePoster();
            };
        };
        reader.readAsDataURL(file);
    }

    function updatePoster() {
        if (!bgImage.complete) return;

        // 1. Draw Background Template
        ctx.drawImage(bgImage, 0, 0, canvas.width, canvas.height);

        // 2. Draw User Photo (if uploaded)
        if (userPhoto && overlaySettings.photo) {
            const config = overlaySettings.photo;
            const scale = parseFloat(document.getElementById('photo-scale').value) || 1.0;
            const xOffset = parseInt(document.getElementById('photo-x-offset').value) || 0;
            const yOffset = parseInt(document.getElementById('photo-y-offset').value) || 0;

            const w = config.w * scale;
            const h = config.h * scale;
            const x = config.x + xOffset - (w - config.w) / 2;
            const y = config.y + yOffset - (h - config.h) / 2;

            // Clip photo into rounded profile frame or circle for design quality
            ctx.save();
            ctx.beginPath();
            ctx.arc(x + w/2, y + h/2, Math.min(w, h)/2, 0, Math.PI * 2);
            ctx.closePath();
            ctx.clip();
            ctx.drawImage(userPhoto, x, y, w, h);
            ctx.restore();
        }

        // 3. Draw Number Text
        const numberInput = document.getElementById('input-number');
        if (numberInput && overlaySettings.number) {
            const config = overlaySettings.number;
            ctx.fillStyle = config.color || '#f59e0b';
            ctx.font = `800 ${config.size}px 'Outfit', sans-serif`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(numberInput.value || '10', config.x, config.y);
        }

        // 4. Draw Name Text
        const nameInput = document.getElementById('input-name');
        if (nameInput && overlaySettings.name) {
            const config = overlaySettings.name;
            ctx.fillStyle = config.color || '#ffffff';
            ctx.font = `700 ${config.size}px 'Outfit', sans-serif`;
            ctx.textAlign = 'center';
            ctx.fillText((nameInput.value || 'Nayan Akram').toUpperCase(), config.x, config.y);
        }
    }

    function generatePoster() {
        // Contact server to deduct credits
        fetch("{{ route('design.ai_templates.process', $template->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(data => { throw new Error(data.error); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Download the canvas as image file
                const link = document.createElement('a');
                link.download = `penghor.com_Poster_${Date.now()}.png`;
                link.href = canvas.toDataURL('image/png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                Swal.fire('আপনার কাস্টম পোস্টার সফলভাবে জেনারেট ও ডাউনলোড করা হয়েছে!');
                window.location.reload();
            }
        })
        .catch(err => {
            Swal.fire(err.message || 'পোস্টার জেনারেট করার সময় কোনো সমস্যা হয়েছে।');
        });
    }
</script>

<style>
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
</style>
@endsection
