@extends('layouts.app')

@section('title', 'পাসপোর্ট ছবি মেকার - Smart Stationary')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="content-header" style="margin-top: 10px; margin-bottom: 30px;">
    <h2 style="color: #fff; margin: 0; font-size: 2rem; font-weight: 700;">পাসপোর্ট ছবি মেকার</h2>
    <p style="color: var(--text-muted); margin: 8px 0 0 0; font-size: 1rem;">ছবির ব্যাকগ্রাউন্ড রিমুভ, কালার চেঞ্জ এবং পাসপোর্ট/স্ট্যাম্প সাইজ ক্রপ করুন</p>
</div>

<div class="grid-2" style="grid-template-columns: 350px 1fr; gap: 25px; align-items: start;">
    
    <!-- Left Sidebar: Controls -->
    <div class="glass" style="padding: 25px;">
        <h3 style="color: #fff; margin: 0 0 20px 0; font-size: 1.1rem; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">টুলস এবং সেটিংস</h3>
        
        <!-- Step 1: Upload -->
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">১. ছবি আপলোড করুন</label>
            <input type="file" id="imageInput" accept="image/*" style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
        </div>

        <!-- Step 2: Background Remove -->
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">২. ব্যাকগ্রাউন্ড রিমুভ (AI)</label>
            <button id="bgRemoveBtn" class="btn w-100" style="background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px;">
                <i class="material-icons-round">auto_fix_high</i> ব্যাকগ্রাউন্ড সরান (5 Credits)
            </button>
        </div>

        <!-- Step 3: Size Selection -->
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">৩. সাইজ নির্বাচন করুন</label>
            <select id="aspectRatioSelect" class="form-control" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                <option value="0.8">Passport Size (40x50 mm)</option>
                <option value="0.8">Stamp Size (20x25 mm)</option>
                <option value="1">Square (1:1)</option>
                <option value="NaN">Free Crop</option>
            </select>
        </div>

        <!-- Step 4: Background Color -->
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">৪. ব্যাকগ্রাউন্ড কালার (রিমুভ করার পর)</label>
            <div style="display: flex; gap: 10px; align-items: center;">
                <div class="color-btn" data-color="transparent" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid #fff; background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZv4zMDD8Z0TRxAAS5KjHY8CAYcAAw4CRaMCoMGBwGAAAn+ELABU29kMAAAAASUVORK5CYII=');" title="Transparent"></div>
                <div class="color-btn" data-color="#ffffff" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; background: #ffffff; border: 1px solid #ccc;" title="White"></div>
                <div class="color-btn" data-color="#1e90ff" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; background: #1e90ff;" title="Blue"></div>
                <div class="color-btn" data-color="#dc143c" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; background: #dc143c;" title="Red"></div>
                <input type="color" id="customBgColor" value="#1e90ff" style="width: 35px; height: 35px; padding: 0; border: none; border-radius: 50%; cursor: pointer; background: transparent;" title="Custom Color">
            </div>
        </div>

        <!-- Step 5: Adjustments -->
        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">৫. এডজাস্টমেন্ট (Enhance)</label>
            
            <div style="margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 5px;">
                    <span>ব্রাইটনেস (Brightness)</span> <span id="valBrightness">100%</span>
                </div>
                <input type="range" id="brightness" min="0" max="200" value="100" style="width: 100%;">
            </div>

            <div style="margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 5px;">
                    <span>কন্ট্রাস্ট (Contrast)</span> <span id="valContrast">100%</span>
                </div>
                <input type="range" id="contrast" min="0" max="200" value="100" style="width: 100%;">
            </div>

            <div style="margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 5px;">
                    <span>স্যাচুরেশন (Saturation)</span> <span id="valSaturation">100%</span>
                </div>
                <input type="range" id="saturation" min="0" max="200" value="100" style="width: 100%;">
            </div>
        </div>

        <!-- Action -->
        <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <button id="downloadBtn" class="btn w-100" style="background: var(--primary-color); color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="material-icons-round">download</i> ডাউনলোড করুন
            </button>
        </div>
    </div>

    <!-- Right Side: Preview & Cropper -->
    <div class="glass" style="padding: 25px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 500px; background: rgba(0,0,0,0.4);">
        <div id="imageContainer" style="width: 100%; max-width: 600px; max-height: 600px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
            <img id="imagePreview" src="" style="max-width: 100%; display: none;">
            <div id="placeholder" style="color: var(--text-muted); text-align: center;">
                <i class="material-icons-round" style="font-size: 4rem; opacity: 0.5;">add_photo_alternate</i>
                <p>বামে থেকে ছবি আপলোড করুন</p>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script type="module">
    import { removeBackground } from "https://esm.sh/@imgly/background-removal@1.4.5";
    window.imglyRemoveBackground = removeBackground;
</script>
<script>
$(document).ready(function() {
    let cropper;
    let bgColor = 'transparent';

    $('#imageInput').change(function(e) {
        let files = e.target.files;
        if (files && files.length > 0) {
            let file = files[0];
            let url = URL.createObjectURL(file);
            
            $('#imagePreview').attr('src', url).show();
            $('#placeholder').hide();

            if (cropper) {
                cropper.destroy();
            }

            let ratio = parseFloat($('#aspectRatioSelect').val());
            
            cropper = new Cropper(document.getElementById('imagePreview'), {
                aspectRatio: isNaN(ratio) ? NaN : ratio,
                viewMode: 1,
                background: false
            });
        }
    });

    $('#aspectRatioSelect').change(function() {
        if (cropper) {
            let val = parseFloat($(this).val());
            cropper.setAspectRatio(isNaN(val) ? NaN : val);
        }
    });

    function updatePreviewStyles() {
        let b = $('#brightness').val();
        let c = $('#contrast').val();
        let s = $('#saturation').val();
        
        $('#valBrightness').text(b + '%');
        $('#valContrast').text(c + '%');
        $('#valSaturation').text(s + '%');
        
        let filterString = `brightness(${b}%) contrast(${c}%) saturate(${s}%)`;
        let bgStyle = bgColor === 'transparent' ? 'transparent' : bgColor;
        
        let css = `
            .cropper-view-box, .cropper-canvas {
                background-color: ${bgStyle} !important;
            }
            .cropper-canvas img, .cropper-view-box img {
                filter: ${filterString} !important;
            }
        `;
        
        if($('#dynamic-filters').length === 0) {
            $('head').append('<style id="dynamic-filters"></style>');
        }
        $('#dynamic-filters').html(css);
    }

    $('.color-btn').click(function() {
        $('.color-btn').css('border', 'none');
        $(this).css('border', '2px solid #fff');
        bgColor = $(this).data('color');
        updatePreviewStyles();
    });

    $('#customBgColor').on('input', function() {
        $('.color-btn').css('border', 'none');
        bgColor = $(this).val();
        updatePreviewStyles();
    });

    $('#brightness, #contrast, #saturation').on('input', function() {
        updatePreviewStyles();
    });

    // Background Remove Function using @imgly/background-removal
    $('#bgRemoveBtn').click(async function() {
        if (!cropper) {
            Swal.fire("আগে একটি ছবি আপলোড করুন!");
            return;
        }

        if (typeof window.imglyRemoveBackground === 'undefined') {
            Swal.fire("AI মডেল লোড হচ্ছে, দয়া করে কিছুক্ষণ অপেক্ষা করুন এবং আবার চেষ্টা করুন।");
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> প্রসেসিং...');

        try {
            // First deduct credit
            let res = await $.ajax({
                url: "{{ route('design.ai_hub.bg_remove') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image: 'dummy_for_deduction'
                }
            });

            if(res.success) {
                btn.html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> এআই কাজ করছে (সময় লাগতে পারে)...');
                
                // Get current image blob
                let originalCanvas = cropper.getCroppedCanvas();
                let imageBlob = await new Promise(resolve => originalCanvas.toBlob(resolve, 'image/png'));
                
                // Remove Background
                let transparentBlob = await imglyRemoveBackground(imageBlob, {
                    progress: (key, current, total) => {
                        console.log(`Downloading AI models: ${key} ${current}/${total}`);
                    }
                });
                
                let transparentUrl = URL.createObjectURL(transparentBlob);
                
                // Replace cropper image with the new transparent one
                cropper.replace(transparentUrl);
                
                // Re-apply filters and background after replace
                setTimeout(() => {
                    updatePreviewStyles();
                }, 500);
                
                Swal.fire("সাফল্যের সাথে ব্যাকগ্রাউন্ড রিমুভ করা হয়েছে!");
            }
        } catch (error) {
            let msg = "ত্রুটি হয়েছে।";
            if(error.responseJSON && error.responseJSON.error) {
                msg = error.responseJSON.error;
            } else if (error.message) {
                msg = error.message;
            }
            Swal.fire(msg);
        }

        btn.prop('disabled', false).html('<i class="material-icons-round">auto_fix_high</i> ব্যাকগ্রাউন্ড সরান (5 Credits)');
    });

    $('#downloadBtn').click(function() {
        if (!cropper) {
            Swal.fire("আগে একটি ছবি আপলোড করুন!");
            return;
        }

        // Get the cropped canvas with transparent background initially
        let canvas = cropper.getCroppedCanvas({
            fillColor: 'transparent'
        });

        // Create a new canvas to compose the final image with background and filters
        let finalCanvas = document.createElement('canvas');
        finalCanvas.width = canvas.width;
        finalCanvas.height = canvas.height;
        let ctx = finalCanvas.getContext('2d');

        // Apply background color if not transparent
        if(bgColor !== 'transparent') {
            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);
        }

        // Apply CSS filters matching the preview
        let b = $('#brightness').val();
        let c = $('#contrast').val();
        let s = $('#saturation').val();
        ctx.filter = `brightness(${b}%) contrast(${c}%) saturate(${s}%)`;

        // Draw the cropped image on top
        ctx.drawImage(canvas, 0, 0);

        finalCanvas.toBlob(function(blob) {
            let url = URL.createObjectURL(blob);
            let a = document.createElement('a');
            a.href = url;
            a.download = 'passport_photo.png';
            a.click();
            URL.revokeObjectURL(url);
        }, 'image/png');
    });
});
</script>
@endsection
