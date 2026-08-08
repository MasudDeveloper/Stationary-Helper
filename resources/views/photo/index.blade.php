@extends('layouts.app')

@section('title', 'ফটো স্টুডিও (Advanced) - penghor.com')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<style>
    :root {
        --panel-bg: rgba(20, 25, 40, 0.7);
        --btn-bg: rgba(255, 255, 255, 0.05);
        --btn-hover: rgba(255, 255, 255, 0.1);
        --active-color: #3b82f6;
    }
    
    .studio-container {
        display: grid;
        grid-template-columns: 280px 1fr 280px;
        gap: 20px;
        align-items: stretch;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .studio-panel {
        background: var(--panel-bg);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    /* Top Actions */
    .top-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 20px;
    }
    .action-btn {
        width: 40px; height: 40px;
        border-radius: 8px;
        background: var(--btn-bg);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        display: flex; justify-content: center; align-items: center;
        cursor: pointer; transition: all 0.2s;
    }
    .action-btn:hover { background: var(--btn-hover); color: #fff; transform: translateY(-2px); }
    .action-btn.primary { background: rgba(16, 185, 129, 0.2); color: #10b981; border-color: rgba(16, 185, 129, 0.3); }
    .action-btn.primary:hover { background: #10b981; color: #fff; }

    /* Left Sidebar Buttons */
    .tool-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }
    .tool-btn {
        background: var(--btn-bg);
        border: 1px solid rgba(255,255,255,0.1);
        color: #cbd5e1;
        padding: 10px;
        border-radius: 8px;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
        font-weight: 600;
    }
    .tool-btn:hover { background: var(--btn-hover); color: #fff; }
    .tool-btn.active { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border-color: rgba(59, 130, 246, 0.4); }
    
    .tool-btn.danger { background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239, 68, 68, 0.3); }
    .tool-btn.danger:hover { background: rgba(239, 68, 68, 0.2); }
    
    .tool-btn-full { grid-column: span 2; }

    /* Right Sidebar Items */
    .upload-tray {
        border: 2px dashed rgba(59, 130, 246, 0.5);
        background: rgba(59, 130, 246, 0.05);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 25px;
        transition: all 0.3s;
        position: relative;
    }
    .upload-tray:hover { background: rgba(59, 130, 246, 0.1); }
    .upload-tray input { position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; }
    
    .color-swatches {
        display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
    }
    .color-swatch {
        width: 35px; height: 35px; border-radius: 8px; cursor: pointer;
        border: 2px solid rgba(255,255,255,0.1);
        transition: transform 0.2s;
    }
    .color-swatch:hover { transform: scale(1.1); }
    .color-swatch.active { border-color: #fff; box-shadow: 0 0 10px rgba(255,255,255,0.4); }

    /* Canvas Area */
    .canvas-wrapper {
        flex-grow: 1;
        background: rgba(0,0,0,0.5);
        border-radius: 8px;
        display: flex; justify-content: center; align-items: center;
        overflow: hidden;
        min-height: 400px;
        position: relative;
    }
    
    /* Sliders */
    .slider-item { margin-bottom: 12px; }
    .slider-item label { display: flex; justify-content: space-between; font-size: 0.8rem; color: #94a3b8; margin-bottom: 5px; }
    .slider-item input { width: 100%; accent-color: var(--active-color); }
</style>

<div class="content-header" style="margin-top: 10px;">
    <h2 style="color: #fff; margin: 0; font-size: 1.8rem; font-weight: 700;"><i class="material-icons-round" style="vertical-align: middle; color: #60a5fa;">photo_camera</i> Photo Studio</h2>
</div>

<div class="studio-container">
    
    <!-- LEFT PANEL: Tools & Adjustments -->
    <div class="studio-panel">
        <div class="tool-group">
            <div class="tool-btn tool-btn-full" onclick="document.getElementById('sizeSelect').focus()">
                <i class="material-icons-round">crop</i> 
                <select id="sizeSelect" style="background:transparent; border:none; color:#fff; outline:none; font-weight:bold; cursor:pointer;">
                    <option value="0.8">Passport (40x50mm)</option>
                    <option value="0.8">Stamp (20x25mm)</option>
                    <option value="1">Square (1:1)</option>
                    <option value="NaN">Free Crop</option>
                </select>
            </div>
            
            <button class="tool-btn" id="bgRemoveBtn">
                <i class="material-icons-round">auto_fix_high</i> BG-AI (5c)
            </button>
            <button class="tool-btn" id="applyCropBtn" style="background: rgba(255,255,255,0.15);">
                <i class="material-icons-round">crop</i> Apply Crop
            </button>
            <button class="tool-btn danger" id="openEraserBtn">
                <i class="material-icons-round">format_paint</i> Erase
            </button>
            
            <button class="tool-btn" onclick="undo()" id="btnUndo" disabled><i class="material-icons-round">undo</i> Undo</button>
            <button class="tool-btn" onclick="redo()" id="btnRedo" disabled><i class="material-icons-round">redo</i> Redo</button>
        </div>

        <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <p style="color: #fff; font-size: 0.9rem; margin-bottom: 15px; font-weight: 600;"><i class="material-icons-round" style="font-size: 16px; vertical-align: middle;">tune</i> Adjustments</p>
            
            <div class="slider-item">
                <label><span>Brightness</span> <span id="valBrightness">100%</span></label>
                <input type="range" id="brightness" min="0" max="200" value="100">
            </div>
            <div class="slider-item">
                <label><span>Contrast</span> <span id="valContrast">100%</span></label>
                <input type="range" id="contrast" min="0" max="200" value="100">
            </div>
            <div class="slider-item">
                <label><span>Saturation</span> <span id="valSaturation">100%</span></label>
                <input type="range" id="saturation" min="0" max="200" value="100">
            </div>
        </div>
    </div>

    <!-- CENTER PANEL: Canvas Preview -->
    <div class="studio-panel" style="padding: 10px;">
        <div class="top-actions">
            <button class="action-btn" title="Rotate Left" onclick="rotateLeft()"><i class="material-icons-round">rotate_left</i></button>
            <button class="action-btn" title="Rotate Right" onclick="rotateRight()"><i class="material-icons-round">rotate_right</i></button>
            <div style="flex-grow: 1;"></div>
            <button class="action-btn primary" title="Download" id="downloadBtn"><i class="material-icons-round">download</i></button>
            <button class="action-btn" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.3);" title="Send to Print" id="sendToArrangeBtn"><i class="material-icons-round">print</i></button>
        </div>
        
        <div class="canvas-wrapper">
            <img id="imagePreview" src="" style="max-width: 100%; display: none;">
            <div id="placeholder" style="color: var(--text-muted); text-align: center;">
                <i class="material-icons-round" style="font-size: 3rem; opacity: 0.5;">add_photo_alternate</i>
                <p style="margin-top: 10px;">Upload an image from the right panel</p>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL: Upload & Colors -->
    <div class="studio-panel">
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 10px; font-weight: bold;">Image Tray</p>
        <div class="upload-tray">
            <i class="material-icons-round" style="color: #3b82f6; font-size: 2.5rem;">upload_file</i>
            <p style="color: #60a5fa; font-weight: 600; margin-top: 10px;">Upload Image</p>
            <p style="color: #94a3b8; font-size: 0.75rem;">Or drop image here</p>
            <input type="file" id="imageInput" accept="image/*">
        </div>

        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 10px; font-weight: bold; margin-top: 10px;">Colors</p>
        <div class="color-swatches">
            <div class="color-swatch active" data-color="transparent" style="background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZv4zMDD8Z0TRxAAS5KjHY8CAYcAAw4CRaMCoMGBwGAAAn+ELABU29kMAAAAASUVORK5CYII=');" title="Transparent"></div>
            <div class="color-swatch" data-color="#ffffff" style="background: #ffffff;" title="White"></div>
            <div class="color-swatch" data-color="#0ea5e9" style="background: #0ea5e9;" title="Sky Blue"></div>
            <div class="color-swatch" data-color="#1d4ed8" style="background: #1d4ed8;" title="Studio Blue"></div>
            <div class="color-swatch" data-color="#0f172a" style="background: #0f172a;" title="Dark Navy"></div>
            <div class="color-swatch" data-color="#e11d48" style="background: #e11d48;" title="Red"></div>
            <div class="color-swatch" data-color="linear-gradient(135deg, #f6d365 0%, #fda085 100%)" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);" title="Gradient Warm"></div>
        </div>
        
        <label style="display: flex; align-items: center; gap: 8px; color: #cbd5e1; font-size: 0.9rem; cursor: pointer; margin-bottom: 25px;">
            <input type="checkbox" id="addBorder" style="width: 16px; height: 16px; accent-color: #3b82f6;"> 2px Border (White)
        </label>

        <a href="{{ route('pdf.tools.joint_photo') }}" class="btn" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; text-decoration: none; padding: 12px; border-radius: 8px; text-align: center; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 8px;">
            <i class="material-icons-round">people</i> Joint Photo
        </a>
    </div>

</div>

<!-- Eraser Modal -->
<div id="eraserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; flex-direction: column; align-items: center; justify-content: center;">
    <div style="background: var(--card-bg); padding: 20px; border-radius: 12px; width: 90%; max-width: 800px; display: flex; flex-direction: column; gap: 15px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
            <h3 style="color: #fff; margin: 0; font-size: 1.2rem;"><i class="material-icons-round" style="vertical-align: middle;">auto_fix_normal</i> Manual Eraser</h3>
            <div>
                <button id="saveEraserBtn" class="btn btn-primary" style="padding: 6px 15px; margin-right: 10px;"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">save</i> Save</button>
                <button id="closeEraserBtn" class="btn btn-outline" style="padding: 6px 15px;"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">close</i> Cancel</button>
            </div>
        </div>
        
        <div style="display: flex; gap: 15px; align-items: center; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                <span style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">Size:</span>
                <input type="range" id="eraserSize" min="5" max="150" value="30" style="flex-grow: 1;">
            </div>
            <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                <span style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">Softness:</span>
                <input type="range" id="eraserSoftness" min="0" max="100" value="50" style="flex-grow: 1;">
            </div>
        </div>

        <div id="eraserCanvasContainer" style="width: 100%; height: 50vh; overflow: hidden; display: flex; align-items: center; justify-content: center; background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZv4zMDD8Z0TRxAAS5KjHY8CAYcAAw4CRaMCoMGBwGAAAn+ELABU29kMAAAAASUVORK5CYII='); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; position: relative;">
            <canvas id="eraserCanvas" style="cursor: none; touch-action: none; position: absolute; max-width: 100%; max-height: 100%;"></canvas>
            <div id="brushCursor" style="pointer-events: none; position: fixed; border: 1px solid rgba(255,255,255,0.8); border-radius: 50%; box-shadow: 0 0 0 1px rgba(0,0,0,0.5); display: none; transform: translate(-50%, -50%); z-index: 10000; background: rgba(255,255,255,0.2);"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let cropper;
    let bgColor = 'transparent';
    
    // History State
    let states = [];
    let stateIndex = -1;

    function saveState(imageSrc) {
        if(stateIndex < states.length - 1) {
            states = states.slice(0, stateIndex + 1);
        }
        states.push(imageSrc);
        stateIndex++;
        updateUndoRedoBtns();
    }

    function updateUndoRedoBtns() {
        $('#btnUndo').prop('disabled', stateIndex <= 0);
        $('#btnRedo').prop('disabled', stateIndex >= states.length - 1);
    }

    window.undo = function() {
        if (stateIndex > 0) {
            stateIndex--;
            loadState(states[stateIndex]);
        }
    }

    window.redo = function() {
        if (stateIndex < states.length - 1) {
            stateIndex++;
            loadState(states[stateIndex]);
        }
    }

    function loadState(src) {
        if (cropper) {
            cropper.replace(src);
        } else {
            $('#imagePreview').attr('src', src).show();
            initCropper();
        }
    }

    window.rotateLeft = function() { if(cropper) cropper.rotate(-90); }
    window.rotateRight = function() { if(cropper) cropper.rotate(90); }

    $('#imageInput').change(function(e) {
        let files = e.target.files;
        if (files && files.length > 0) {
            let file = files[0];
            let url = URL.createObjectURL(file);
            
            $('#imagePreview').attr('src', url).show();
            $('#placeholder').hide();
            
            states = [];
            stateIndex = -1;
            saveState(url);

            initCropper();
        }
    });

    function initCropper() {
        if (cropper) cropper.destroy();
        let ratio = parseFloat($('#sizeSelect').val());
        cropper = new Cropper(document.getElementById('imagePreview'), {
            aspectRatio: isNaN(ratio) ? NaN : ratio,
            viewMode: 1,
            background: false,
            autoCropArea: 0.5,
        });
    }

    $('#sizeSelect').change(function() {
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
        let bgStyle = bgColor;
        
        let css = `
            .cropper-view-box, .cropper-canvas {
                background: ${bgStyle} !important;
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

    $('.color-swatch').click(function() {
        $('.color-swatch').removeClass('active');
        $(this).addClass('active');
        bgColor = $(this).data('color');
        updatePreviewStyles();
    });

    $('#brightness, #contrast, #saturation').on('input', updatePreviewStyles);

    // Python API BG Removal
    $('#bgRemoveBtn').click(function() {
        if (!cropper) return;
        let btn = $(this);
        Swal.fire({
            title: 'Confirm AI Removal',
            text: "This will deduct 5 Credits. Proceed?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#475569',
            background: '#1e293b', color: '#fff'
        }).then(async (result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> Processing...');
                
                Swal.fire({
                    title: 'Background Removing...',
                    html: 'Please wait, our AI is processing your image.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: '#1e293b',
                    color: '#fff',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Get the currently cropped area instead of states[0].
                    // This ensures the AI processes exactly what the user selected, and effectively applies the crop.
                    let croppedCanvas = cropper.getCroppedCanvas();
                    
                    let maxDim = 1200;
                    let width = croppedCanvas.width;
                    let height = croppedCanvas.height;
                    
                    if (width > maxDim || height > maxDim) {
                        if (width > height) {
                            height = Math.round((height * maxDim) / width);
                            width = maxDim;
                        } else {
                            width = Math.round((width * maxDim) / height);
                            height = maxDim;
                        }
                        
                        let tempCanvas = document.createElement('canvas');
                        tempCanvas.width = width;
                        tempCanvas.height = height;
                        let ctx = tempCanvas.getContext('2d');
                        ctx.drawImage(croppedCanvas, 0, 0, width, height);
                        croppedCanvas = tempCanvas;
                    }
                    
                    let imageBlob = await new Promise(resolve => croppedCanvas.toBlob(resolve, 'image/png'));
                    
                    const formData = new FormData();
                    formData.append('image', imageBlob, 'temp.png');
                    formData.append('tool_name', 'Photo Studio');

                    let res = await fetch("{{ route('pdf.tools.bg_remover.process') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    let data = await res.json();

                    if(data.success) {
                        // Because we sent the cropped canvas, the returned image IS the cropped image.
                        saveState(data.image); // Save transparent image to history state
                        
                        // Replace the image in the cropper. It will reset the crop box to cover this entire new image.
                        cropper.replace(data.image);
                        
                        setTimeout(() => {
                            updatePreviewStyles();
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Background removed successfully',
                                timer: 2000,
                                showConfirmButton: false,
                                background: '#1e293b', color: '#fff'
                            });
                        }, 500);
                    } else {
                        throw new Error(data.message || 'Error occurred');
                    }
                } catch (error) {
                    Swal.close();
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Error: ' + error.message,
                        background: '#1e293b', color: '#fff'
                    });
                } finally {
                    btn.prop('disabled', false).html('<i class="material-icons-round">auto_fix_high</i> BG-AI (5c)');
                }
            }
        });
    });
        
    // Apply Crop Button
    $('#applyCropBtn').click(function() {
        if(!cropper) return;
        let canvas = cropper.getCroppedCanvas();
        let dataUrl = canvas.toDataURL('image/png');
        saveState(dataUrl);
        cropper.replace(dataUrl);
        // Flash effect for feedback
        let preview = $('#imagePreview');
        preview.css('opacity', '0.5');
        setTimeout(() => { preview.css('opacity', '1'); }, 200);
    });

    // Final Processing
    function getProcessedCanvas() {
        let canvas = cropper.getCroppedCanvas({ fillColor: 'transparent' });
        let finalCanvas = document.createElement('canvas');
        let borderEnabled = $('#addBorder').is(':checked');
        let borderSize = borderEnabled ? 2 : 0;
        
        finalCanvas.width = canvas.width;
        finalCanvas.height = canvas.height;
        let ctx = finalCanvas.getContext('2d');

        // Draw Background
        if(bgColor !== 'transparent') {
            if(bgColor.includes('gradient')) {
                // simple gradient mapping
                let grad = ctx.createLinearGradient(0, 0, finalCanvas.width, finalCanvas.height);
                grad.addColorStop(0, "#f6d365");
                grad.addColorStop(1, "#fda085");
                ctx.fillStyle = grad;
            } else {
                ctx.fillStyle = bgColor;
            }
            ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);
        }

        // Apply filters and draw image
        let b = $('#brightness').val();
        let c = $('#contrast').val();
        let s = $('#saturation').val();
        ctx.filter = `brightness(${b}%) contrast(${c}%) saturate(${s}%)`;
        
        // draw image respecting border space if enabled
        if (borderEnabled) {
            ctx.drawImage(canvas, borderSize, borderSize, finalCanvas.width - borderSize*2, finalCanvas.height - borderSize*2);
            // Draw border
            ctx.filter = 'none';
            ctx.lineWidth = borderSize * 2;
            ctx.strokeStyle = '#ffffff';
            ctx.strokeRect(0, 0, finalCanvas.width, finalCanvas.height);
        } else {
            ctx.drawImage(canvas, 0, 0);
        }

        return finalCanvas;
    }

    $('#downloadBtn').click(function() {
        if (!cropper) return;
        let finalCanvas = getProcessedCanvas();
        finalCanvas.toBlob(function(blob) {
            let url = URL.createObjectURL(blob);
            let a = document.createElement('a');
            a.href = url;
            a.download = 'studio_photo.png';
            a.click();
            URL.revokeObjectURL(url);
        }, 'image/png');
    });

    $('#sendToArrangeBtn').click(function() {
        if (!cropper) return;
        let finalCanvas = getProcessedCanvas();
        let dataURL = finalCanvas.toDataURL('image/png');
        localStorage.setItem('transfer_job_photo', dataURL);
        window.location.href = "{{ route('pdf.tools.passport_print') }}";
    });

    // --- Eraser Tool (Advanced with size & softness) ---
    let eraserCanvas = document.getElementById('eraserCanvas');
    let eraserCtx = eraserCanvas.getContext('2d');
    let isErasing = false;
    let eraserSize = 30;
    let eraserSoftness = 0.5;

    $('#openEraserBtn').click(function() {
        if (!cropper) return;
        let originalCanvas = cropper.getCroppedCanvas();
        eraserCanvas.width = originalCanvas.width;
        eraserCanvas.height = originalCanvas.height;
        eraserCtx.drawImage(originalCanvas, 0, 0);
        
        $('#eraserModal').css('display', 'flex');
        
        // Let CSS max-width/max-height handle scaling, we don't need manual CSS transform logic
        updateBrushCursor(0, 0, false);
    });

    $('#closeEraserBtn').click(function() { 
        $('#eraserModal').hide(); 
    });

    $('#eraserSize').on('input', function() { 
        eraserSize = parseInt($(this).val()); 
        updateBrushCursor(lastMouseX, lastMouseY, true);
    });
    
    $('#eraserSoftness').on('input', function() { 
        eraserSoftness = parseInt($(this).val()) / 100; // 0 to 1
    });

    let lastMouseX = -100;
    let lastMouseY = -100;

    function getCanvasScale() {
        // Since canvas uses max-width/max-height in a flex container, 
        // rect.width / original.width gives the true scale ratio.
        let rect = eraserCanvas.getBoundingClientRect();
        return rect.width / eraserCanvas.width;
    }

    function updateBrushCursor(clientX, clientY, visible) {
        lastMouseX = clientX;
        lastMouseY = clientY;
        let scale = getCanvasScale();
        let displaySize = eraserSize * scale;
        $('#brushCursor').css({
            width: displaySize + 'px',
            height: displaySize + 'px',
            left: clientX + 'px',
            top: clientY + 'px',
            display: visible ? 'block' : 'none'
        });
    }

    $('#eraserCanvasContainer').on('mousemove touchmove', function(e) {
        let clientX = e.clientX || (e.originalEvent.touches ? e.originalEvent.touches[0].clientX : 0);
        let clientY = e.clientY || (e.originalEvent.touches ? e.originalEvent.touches[0].clientY : 0);
        updateBrushCursor(clientX, clientY, true);
    });

    $('#eraserCanvasContainer').on('mouseleave touchend', function() {
        $('#brushCursor').hide();
    });

    function erase(e) {
        if (!isErasing) return;
        let rect = eraserCanvas.getBoundingClientRect();
        let scale = getCanvasScale();
        
        let clientX = e.clientX || (e.originalEvent.touches ? e.originalEvent.touches[0].clientX : 0);
        let clientY = e.clientY || (e.originalEvent.touches ? e.originalEvent.touches[0].clientY : 0);
        
        // Coordinate relative to canvas element
        let x = clientX - rect.left;
        let y = clientY - rect.top;
        
        // Scale to actual image coordinates
        x /= scale;
        y /= scale;

        eraserCtx.globalCompositeOperation = 'destination-out';
        
        let radgrad = eraserCtx.createRadialGradient(x, y, 0, x, y, eraserSize/2);
        
        // Softness logic: 0 = hard edge, 1 = completely soft
        let colorStop = 1 - eraserSoftness;
        if(colorStop < 0.01) colorStop = 0.01;
        if(colorStop > 0.99) colorStop = 0.99;
        
        radgrad.addColorStop(0, 'rgba(0,0,0,1)');
        radgrad.addColorStop(colorStop, 'rgba(0,0,0,1)');
        radgrad.addColorStop(1, 'rgba(0,0,0,0)');
        
        eraserCtx.fillStyle = radgrad;
        eraserCtx.beginPath();
        eraserCtx.arc(x, y, eraserSize/2, 0, Math.PI * 2, false);
        eraserCtx.fill();
    }

    $(eraserCanvas).on('mousedown touchstart', function(e) { 
        if(e.type === 'touchstart') e.preventDefault();
        isErasing = true; 
        erase(e); 
    });
    
    $(eraserCanvas).on('mousemove touchmove', function(e) {
        if(e.type === 'touchmove') e.preventDefault();
        erase(e);
    });
    
    $(window).on('mouseup touchend', function() { isErasing = false; });

    $('#saveEraserBtn').click(function() {
        let dataUrl = eraserCanvas.toDataURL('image/png');
        saveState(dataUrl);
        cropper.replace(dataUrl);
    });
});

// Add Paste Support (Ctrl+V)
window.addEventListener('paste', function(e) {
    if (e.clipboardData && e.clipboardData.files.length > 0) {
        const file = e.clipboardData.files[0];
        if (file.type.startsWith('image/')) {
            const input = document.getElementById('imageUpload');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            input.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endsection
