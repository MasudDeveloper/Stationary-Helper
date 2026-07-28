@extends('layouts.app')

@section('title', 'পাসপোর্ট ছবি মেকার - penghor.com')

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
            
            <div style="margin-bottom: 15px;">
                <button id="openEraserBtn" class="btn w-100" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 8px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <i class="material-icons-round" style="font-size: 18px;">auto_fix_normal</i> ম্যানুয়াল ইরেজার (Brush/Delete)
                </button>
            </div>
            
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
            <button id="downloadBtn" class="btn w-100" style="background: var(--primary-color); color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                <i class="material-icons-round">download</i> ডাউনলোড করুন
            </button>
            <button id="sendToArrangeBtn" class="btn w-100" style="background: #f59e0b; color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="material-icons-round">auto_awesome_mosaic</i> অটো-অ্যারেঞ্জ (4R / A4)
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

<!-- Eraser Modal -->
<div id="eraserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; flex-direction: column; align-items: center; justify-content: center;">
    <div style="background: var(--card-bg); padding: 20px; border-radius: 12px; width: 90%; max-width: 800px; display: flex; flex-direction: column; gap: 15px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
            <h3 style="color: #fff; margin: 0; font-size: 1.2rem;"><i class="material-icons-round" style="vertical-align: middle;">auto_fix_normal</i> ম্যানুয়াল ইরেজার</h3>
            <div>
                <button id="eraserUndoBtn" class="btn btn-outline" style="padding: 6px 10px;" title="Undo (আগের অবস্থায়)"><i class="material-icons-round" style="font-size: 18px;">undo</i></button>
                <button id="eraserRedoBtn" class="btn btn-outline" style="padding: 6px 10px; margin-right: 10px;" title="Redo (পরের অবস্থায়)"><i class="material-icons-round" style="font-size: 18px;">redo</i></button>
                <button id="saveEraserBtn" class="btn btn-primary" style="padding: 6px 15px; margin-right: 10px;"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">save</i> সেভ করুন</button>
                <button id="closeEraserBtn" class="btn btn-outline" style="padding: 6px 15px;"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">close</i> বাতিল</button>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div style="display: flex; gap: 10px; align-items: center; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px;">
                <span style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">ব্রাশ সাইজ:</span>
                <input type="range" id="eraserSize" min="5" max="100" value="20" style="flex-grow: 1;">
            </div>
            <div style="display: flex; gap: 10px; align-items: center; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px;">
                <span style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">সফটনেস:</span>
                <input type="range" id="eraserSoftness" min="0" max="100" value="20" style="flex-grow: 1;">
            </div>
        </div>
        
        <div style="display: flex; justify-content: center; gap: 15px; align-items: center;">
            <button id="eraserZoomOutBtn" class="btn btn-outline" style="padding: 4px 10px;"><i class="material-icons-round" style="font-size: 18px;">zoom_out</i></button>
            <span id="eraserZoomVal" style="color: #fff; font-weight: bold; width: 50px; text-align: center;">100%</span>
            <button id="eraserZoomInBtn" class="btn btn-outline" style="padding: 4px 10px;"><i class="material-icons-round" style="font-size: 18px;">zoom_in</i></button>
        </div>

        <div id="eraserCanvasContainer" style="width: 100%; height: 50vh; overflow: auto; display: flex; align-items: flex-start; justify-content: center; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\"><rect width=\"10\" height=\"10\" fill=\"%23ddd\"/><rect x=\"10\" width=\"10\" height=\"10\" fill=\"%23fff\"/><rect y=\"10\" width=\"10\" height=\"10\" fill=\"%23fff\"/><rect x=\"10\" y=\"10\" width=\"10\" height=\"10\" fill=\"%23ddd\"/></svg>'); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; position: relative;">
            <canvas id="eraserCanvas" style="cursor: none; touch-action: none; transform-origin: top center;"></canvas>
            <div id="brushCursor" style="pointer-events: none; position: fixed; border: 1px solid rgba(255,255,255,0.8); border-radius: 50%; box-shadow: 0 0 0 1px rgba(0,0,0,0.5); display: none; transform: translate(-50%, -50%); z-index: 10000; background: rgba(255,255,255,0.1);"></div>
        </div>
        <p style="color: var(--text-muted); text-align: center; margin: 0; font-size: 0.85rem;"><i class="material-icons-round" style="font-size: 14px; vertical-align: middle;">info</i> মাউস বা আঙুল দিয়ে ড্র্যাগ করে ছবির অপ্রয়োজনীয় অংশ মুছে ফেলুন।</p>
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
        
        Swal.fire({
            title: 'নিশ্চিত করুন',
            text: "ব্যাকগ্রাউন্ড রিমুভ করতে ৫ ক্রেডিট কাটা হবে। আপনি কি রাজি?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'হ্যাঁ, শুরু করুন',
            cancelButtonText: 'বাতিল'
        }).then(async (result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> প্রসেসিং...');

                try {
                    // First deduct credit (Assuming design.ai_hub.bg_remove deducts 5 credits)
                    let res = await $.ajax({
                        url: "{{ route('design.ai_hub.bg_remove') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            image: 'dummy_for_deduction'
                        }
                    });

                    if(res.success) {
                        // Update balance on UI
                        const balanceSpans = document.querySelectorAll('.credit-badge span');
                        if (balanceSpans.length > 0 && res.new_balance) {
                            balanceSpans[0].innerText = 'Credits: ' + res.new_balance;
                        }

                        btn.html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> <span>এআই কাজ করছে (0%)...</span>');
                        
                        // Get current image blob
                        let originalCanvas = cropper.getCroppedCanvas();
                        let imageBlob = await new Promise(resolve => originalCanvas.toBlob(resolve, 'image/png'));
                        
                        // Remove Background
                        let rawBlob = await imglyRemoveBackground(imageBlob, {
                            progress: (key, current, total) => {
                                let percent = Math.round((current / total) * 100);
                                if(percent > 100) percent = 100;
                                btn.find('span').text(`এআই কাজ করছে (${percent}%)...`);
                            }
                        });
                        
                        btn.find('span').text(`এজ ক্লিনআপ হচ্ছে...`);
                        let transparentBlob = await cleanEdges(rawBlob);
                        let transparentUrl = URL.createObjectURL(transparentBlob);
                        
                        // Replace cropper image with the new transparent one
                        cropper.replace(transparentUrl);
                        
                        // Re-apply filters and background after replace
                        setTimeout(() => {
                            updatePreviewStyles();
                        }, 500);
                        
                        Swal.fire("সাফল্যের সাথে ব্যাকগ্রাউন্ড রিমুভ করা হয়েছে!");
                    } else {
                        Swal.fire('দুঃখিত', res.message || 'অপর্যাপ্ত ক্রেডিট', 'error');
                    }
                } catch (error) {
                    let msg = "ত্রুটি হয়েছে।";
                    if(error.responseJSON && error.responseJSON.error) {
                        msg = error.responseJSON.error;
                    } else if (error.message) {
                        msg = error.message;
                    }
                    Swal.fire("ত্রুটি", msg, "error");
                }

                btn.prop('disabled', false).html('<i class="material-icons-round">auto_fix_high</i> ব্যাকগ্রাউন্ড সরান (5 Credits)');
            }
        });
    });

    // Clean edges (Defringe/Burn) for white AI artifacts
    function cleanEdges(blob) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imgData.data;
                const width = canvas.width;
                const height = canvas.height;
                
                for (let y = 0; y < height; y++) {
                    for (let x = 0; x < width; x++) {
                        let idx = (y * width + x) * 4;
                        let alpha = data[idx + 3];
                        
                        if (alpha > 10) {
                            let isEdge = false;
                            // Check surrounding pixels to see if it's near a transparent edge
                            const offsets = [
                                [-2,0], [2,0], [0,-2], [0,2],
                                [-1,-1], [1,-1], [-1,1], [1,1]
                            ];
                            for(let i=0; i<offsets.length; i++) {
                                let nx = x + offsets[i][0];
                                let ny = y + offsets[i][1];
                                if(nx >= 0 && nx < width && ny >= 0 && ny < height) {
                                    if(data[(ny * width + nx) * 4 + 3] < 20) {
                                        isEdge = true;
                                        break;
                                    }
                                }
                            }
                            
                            if (isEdge) {
                                // Darken to remove white halo
                                data[idx] = Math.max(0, data[idx] - 70);     // R
                                data[idx+1] = Math.max(0, data[idx+1] - 70); // G
                                data[idx+2] = Math.max(0, data[idx+2] - 70); // B
                                // Smooth alpha
                                if(alpha > 50) {
                                    data[idx+3] = Math.max(0, alpha - 15);
                                }
                            }
                        }
                    }
                }
                ctx.putImageData(imgData, 0, 0);
                canvas.toBlob(resolve, 'image/png');
            };
            img.src = URL.createObjectURL(blob);
        });
    }

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

    $('#sendToArrangeBtn').click(function() {
        if (!cropper) {
            Swal.fire("আগে একটি ছবি আপলোড করুন!");
            return;
        }

        let canvas = cropper.getCroppedCanvas({
            fillColor: 'transparent'
        });

        let finalCanvas = document.createElement('canvas');
        finalCanvas.width = canvas.width;
        finalCanvas.height = canvas.height;
        let ctx = finalCanvas.getContext('2d');

        if(bgColor !== 'transparent') {
            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);
        }

        let b = $('#brightness').val();
        let c = $('#contrast').val();
        let s = $('#saturation').val();
        ctx.filter = `brightness(${b}%) contrast(${c}%) saturate(${s}%)`;
        ctx.drawImage(canvas, 0, 0);

        let dataURL = finalCanvas.toDataURL('image/png');
        localStorage.setItem('transfer_job_photo', dataURL);
        window.location.href = "{{ route('pdf.tools.passport_print') }}";
    });

    // --- Eraser Tool Logic ---
    let eraserCanvas = document.getElementById('eraserCanvas');
    let eraserCtx = eraserCanvas.getContext('2d', { willReadFrequently: true });
    let isErasing = false;
    let eraserSize = 20;
    let lastPos = null;
    let eraserZoom = 1;
    let baseWidth = 0;
    
    // History for Undo/Redo
    let eraserHistory = [];
    let historyIndex = -1;

    function saveEraserState() {
        if(historyIndex < eraserHistory.length - 1) {
            eraserHistory = eraserHistory.slice(0, historyIndex + 1);
        }
        eraserHistory.push(eraserCanvas.toDataURL('image/png'));
        historyIndex++;
    }

    $('#eraserUndoBtn').click(function() {
        if(historyIndex > 0) {
            historyIndex--;
            restoreEraserState(eraserHistory[historyIndex]);
        }
    });

    $('#eraserRedoBtn').click(function() {
        if(historyIndex < eraserHistory.length - 1) {
            historyIndex++;
            restoreEraserState(eraserHistory[historyIndex]);
        }
    });

    function restoreEraserState(dataUrl) {
        let img = new Image();
        img.onload = function() {
            eraserCtx.globalCompositeOperation = 'source-over';
            eraserCtx.clearRect(0, 0, eraserCanvas.width, eraserCanvas.height);
            eraserCtx.drawImage(img, 0, 0);
        };
        img.src = dataUrl;
    }

    function updateZoom() {
        $('#eraserCanvas').css({
            width: (baseWidth * eraserZoom) + 'px',
            height: 'auto'
        });
        $('#eraserZoomVal').text(Math.round(eraserZoom * 100) + '%');
        updateCursorSize();
    }

    $('#eraserZoomInBtn').click(function() {
        eraserZoom += 0.25;
        updateZoom();
    });

    $('#eraserZoomOutBtn').click(function() {
        eraserZoom = Math.max(0.25, eraserZoom - 0.25);
        updateZoom();
    });

    function updateCursorSize() {
        if (!$('#eraserModal').is(':visible')) return;
        let rect = eraserCanvas.getBoundingClientRect();
        let scaleX = eraserCanvas.width / rect.width;
        let displaySize = eraserSize / scaleX;
        $('#brushCursor').css({
            width: displaySize + 'px',
            height: displaySize + 'px'
        });
    }

    $('#eraserSize').on('input', function() {
        eraserSize = parseInt($(this).val());
        updateCursorSize();
    });
    
    $('#eraserSoftness').on('input', function() {
        // Just for UX, we don't need to change visual cursor instantly
    });

    $('#openEraserBtn').click(function() {
        if (!cropper) {
            Swal.fire("আগে একটি ছবি আপলোড করুন!");
            return;
        }
        let src = $('#imagePreview').attr('src');
        let img = new Image();
        img.onload = function() {
            eraserCanvas.width = img.width;
            eraserCanvas.height = img.height;
            
            baseWidth = img.width;
            if(img.width > window.innerWidth * 0.9) {
                baseWidth = window.innerWidth * 0.9;
            }
            eraserZoom = 1;
            updateZoom();
            
            eraserCtx.globalCompositeOperation = 'source-over';
            eraserCtx.clearRect(0, 0, eraserCanvas.width, eraserCanvas.height);
            eraserCtx.drawImage(img, 0, 0);
            
            let newMax = Math.max(100, Math.round(Math.min(img.width, img.height) / 5));
            $('#eraserSize').attr('max', newMax);
            eraserSize = Math.max(20, Math.round(newMax / 5));
            $('#eraserSize').val(eraserSize);
            
            $('#eraserSoftness').val(20); // Default softness
            
            // reset history
            eraserHistory = [];
            historyIndex = -1;
            saveEraserState();
            
            $('#eraserModal').css('display', 'flex');
            updateCursorSize();
        };
        img.src = src;
    });

    $('#closeEraserBtn').click(function() {
        $('#eraserModal').hide();
        $('#brushCursor').hide();
    });

    // Custom cursor logic
    $(window).on('mousemove touchmove', function(e) {
        if ($('#eraserModal').is(':visible')) {
            let target = $(e.target);
            if (target.closest('#eraserCanvasContainer').length > 0) {
                let clientX, clientY;
                if(e.type.includes('touch') || (e.originalEvent && e.originalEvent.touches)) {
                    let touch = (e.originalEvent.touches && e.originalEvent.touches[0]) || (e.originalEvent.changedTouches && e.originalEvent.changedTouches[0]);
                    if(touch) {
                        clientX = touch.clientX;
                        clientY = touch.clientY;
                    }
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }
                if(clientX !== undefined) {
                    $('#brushCursor').css({
                        left: clientX + 'px',
                        top: clientY + 'px',
                        display: 'block'
                    });
                }
            } else {
                $('#brushCursor').hide();
            }
        }
    });

    $('#eraserCanvasContainer').on('mouseleave', function() {
        $('#brushCursor').hide();
    });

    function getMousePos(canvas, evt) {
        let rect = canvas.getBoundingClientRect();
        let scaleX = canvas.width / rect.width;
        let scaleY = canvas.height / rect.height;
        let clientX = evt.clientX;
        let clientY = evt.clientY;
        
        if(evt.type.includes('touch') || (evt.originalEvent && evt.originalEvent.touches)) {
            let touch = (evt.originalEvent.touches && evt.originalEvent.touches[0]) || (evt.originalEvent.changedTouches && evt.originalEvent.changedTouches[0]);
            if(touch) {
                clientX = touch.clientX;
                clientY = touch.clientY;
            }
        }
        return {
            x: (clientX - rect.left) * scaleX,
            y: (clientY - rect.top) * scaleY
        };
    }

    function erase(e) {
        if (!isErasing) return;
        if(e.type.includes('touch')) {
            e.preventDefault(); 
        }
        
        let pos = getMousePos(eraserCanvas, e);
        let softness = parseInt($('#eraserSoftness').val());
        let blurAmount = (eraserSize / 2) * (softness / 100);
        
        eraserCtx.globalCompositeOperation = 'destination-out';
        eraserCtx.lineWidth = Math.max(1, eraserSize - blurAmount);
        eraserCtx.lineCap = 'round';
        eraserCtx.lineJoin = 'round';
        
        eraserCtx.shadowBlur = blurAmount;
        eraserCtx.shadowColor = 'black';
        
        eraserCtx.beginPath();
        if (lastPos) {
            eraserCtx.moveTo(lastPos.x, lastPos.y);
            eraserCtx.lineTo(pos.x, pos.y);
        } else {
            eraserCtx.arc(pos.x, pos.y, Math.max(0.5, (eraserSize - blurAmount)/2), 0, Math.PI * 2, false);
            eraserCtx.fill();
        }
        eraserCtx.stroke();
        
        eraserCtx.shadowBlur = 0;
        
        lastPos = pos;
    }

    $(eraserCanvas).on('mousedown touchstart', function(e) {
        isErasing = true;
        lastPos = null;
        erase(e);
    });
    $(eraserCanvas).on('mousemove touchmove', function(e) {
        erase(e);
    });
    $(window).on('mouseup touchend', function() {
        if(isErasing) {
            saveEraserState();
        }
        isErasing = false;
        lastPos = null;
    });

    $('#saveEraserBtn').click(function() {
        let dataUrl = eraserCanvas.toDataURL('image/png');
        $('#imagePreview').attr('src', dataUrl);
        cropper.replace(dataUrl);
        $('#eraserModal').hide();
        $('#brushCursor').hide();
    });
});
</script>
@endsection
