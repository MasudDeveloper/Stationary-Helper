@extends('layouts.app')

@section('title', 'Passport Photo Auto Arrange - Smart Stationary')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .upload-box {
        border: 2px dashed var(--border-color);
        padding: 30px;
        text-align: center;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
    }
    .upload-box:hover {
        background: rgba(255,255,255,0.1);
        border-color: var(--primary-color);
    }
    .upload-box input[type="file"] {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .preview-container {
        width: 100%;
        overflow: auto;
        background: #f3f4f6;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid var(--border-color);
        display: none;
    }
    canvas {
        max-width: 100%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background: white;
    }
    
    @media print {
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        #print-area { position: absolute; left: 0; top: 0; width: 100%; height: 100%; }
        canvas {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            display: block;
        }
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1000px;">
    <div class="tool-header no-print">
        <div class="tool-squircle grad-teal" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(20, 184, 166, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">auto_awesome_mosaic</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পাসপোর্ট ছবি অটো-সাজানো (Auto Arrange)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">4R বা A4 পেপারে 4 কপি, 6 কপি বা 20 কপি ছবি এক ক্লিকে প্রিন্টের জন্য সাজান।</p>
    </div>

    <div class="glass no-print" style="padding: 30px;">
        <div class="grid-2">
            
            <!-- Sidebar Setup -->
            <div>
                <div class="upload-box" id="upload-area" style="margin-bottom: 20px;">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">add_a_photo</i>
                    <p style="margin-top: 10px; color: var(--text-muted);">পাসপোর্ট সাইজ ছবি আপলোড করুন</p>
                    <input type="file" id="photo-input" accept="image/*">
                </div>
                
                <!-- Display currently loaded image preview (small) -->
                <div id="source-preview-container" style="text-align: center; margin-bottom: 20px; display: none;">
                    <p style="color: var(--text-muted); margin-bottom: 5px; font-size: 0.9rem;">Source Photo</p>
                    <img id="source-image" src="" style="width: 120px; border-radius: 6px; border: 2px solid var(--primary-color);">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">পেইজ এবং ছবির সংখ্যা</label>
                    <select id="layout-select" class="form-control" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 10px; width: 100%;">
                        <option value="4r_4" style="color: #000;">4R Page - 4 Photos</option>
                        <option value="4r_6" style="color: #000;">4R Page - 6 Photos (Standard Studio Layout)</option>
                        <option value="a4_20" style="color: #000;">A4 Page - 20 Photos</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="color: #fff; display: block; margin-bottom: 5px;">বর্ডার লাইন</label>
                    <select id="border-select" class="form-control" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid var(--border-color); border-radius: 8px; padding: 10px; width: 100%;">
                        <option value="1" style="color: #000;">হ্যাঁ (কাটার সুবিধার জন্য)</option>
                        <option value="0" style="color: #000;">না</option>
                    </select>
                </div>

                <button id="generate-btn" class="btn btn-primary" style="width: 100%; padding: 12px; margin-bottom: 10px;">
                    <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">auto_awesome</i> লেআউট তৈরি করুন
                </button>
            </div>

            <!-- Preview Area -->
            <div>
                <div id="result-actions" style="display: none; justify-content: space-between; margin-bottom: 15px;">
                    <h4 style="color: #fff; margin: 0;">প্রিভিউ</h4>
                    <div>
                        <button onclick="downloadLayout()" class="btn" style="background: #10b981; color: #fff; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem;">
                            <i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">download</i> Download JPEG
                        </button>
                        <button onclick="printLayout()" class="btn" style="background: #3b82f6; color: #fff; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem; margin-left: 5px;">
                            <i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">print</i> Print
                        </button>
                    </div>
                </div>
                
                <div class="preview-container" id="preview-container">
                    <div id="print-area">
                        <canvas id="layout-canvas"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    // Create a dynamic style tag for printing specific page sizes
    const dynamicPrintStyle = document.createElement('style');
    document.head.appendChild(dynamicPrintStyle);

    const photoInput = document.getElementById('photo-input');
    const sourceImage = document.getElementById('source-image');
    const sourcePreviewContainer = document.getElementById('source-preview-container');
    const generateBtn = document.getElementById('generate-btn');
    const layoutSelect = document.getElementById('layout-select');
    const borderSelect = document.getElementById('border-select');
    const previewContainer = document.getElementById('preview-container');
    const layoutCanvas = document.getElementById('layout-canvas');
    const resultActions = document.getElementById('result-actions');
    const ctx = layoutCanvas.getContext('2d');

    // High DPI constants
    const DPI = 300;
    const MM_TO_INCH = 25.4;
    
    // Pixel dimensions at 300 DPI
    const PP_WIDTH = Math.round((40 / MM_TO_INCH) * DPI);  // ~472px
    const PP_HEIGHT = Math.round((50 / MM_TO_INCH) * DPI); // ~591px
    
    const PAGE_4R_W = 1200; // 4 inch * 300
    const PAGE_4R_H = 1800; // 6 inch * 300
    
    const PAGE_A4_W = Math.round((210 / MM_TO_INCH) * DPI); // ~2480px
    const PAGE_A4_H = Math.round((297 / MM_TO_INCH) * DPI); // ~3508px

    // Check if image data is passed from Job Photo page
    document.addEventListener('DOMContentLoaded', () => {
        const storedPhoto = localStorage.getItem('transfer_job_photo');
        if (storedPhoto) {
            sourceImage.src = storedPhoto;
            sourcePreviewContainer.style.display = 'block';
            localStorage.removeItem('transfer_job_photo'); // clear it
            
            // Automatically select 4r_6 if we come from job photo, usually they want full page
            layoutSelect.value = '4r_6';
        }
    });

    photoInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                sourceImage.src = e.target.result;
                sourcePreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    generateBtn.addEventListener('click', () => {
        if (!sourceImage.src || sourceImage.src === window.location.href) {
            alert('দয়া করে একটি ছবি আপলোড করুন');
            return;
        }

        const layout = layoutSelect.value;
        const showBorder = borderSelect.value === '1';

        // Wait for image to be fully loaded just in case
        if (sourceImage.complete) {
            drawLayout(layout, showBorder);
        } else {
            sourceImage.onload = () => drawLayout(layout, showBorder);
        }
    });

    // Auto update layout when select options change
    function updateLayoutIfGenerated() {
        if (previewContainer.style.display === 'block') {
            const layout = layoutSelect.value;
            const showBorder = borderSelect.value === '1';
            drawLayout(layout, showBorder);
        }
    }
    
    layoutSelect.addEventListener('change', updateLayoutIfGenerated);
    borderSelect.addEventListener('change', updateLayoutIfGenerated);

    function drawPhoto(x, y, boxW, boxH, rotation = 0, showBorder = false) {
        ctx.save();
        if (rotation !== 0) {
            ctx.translate(x + boxW/2, y + boxH/2);
            ctx.rotate(rotation * Math.PI / 180);
            ctx.drawImage(sourceImage, -boxH/2, -boxW/2, boxH, boxW);
            if(showBorder) {
                const bGap = 15; // Gap between image and border
                ctx.strokeStyle = '#999999';
                ctx.lineWidth = 3;
                ctx.strokeRect(-boxH/2 - bGap, -boxW/2 - bGap, boxH + (bGap*2), boxW + (bGap*2));
            }
        } else {
            ctx.drawImage(sourceImage, x, y, boxW, boxH);
            if(showBorder) {
                const bGap = 15; // Gap between image and border
                ctx.strokeStyle = '#999999';
                ctx.lineWidth = 3;
                ctx.strokeRect(x - bGap, y - bGap, boxW + (bGap*2), boxH + (bGap*2));
            }
        }
        ctx.restore();
    }

    function drawLayout(layout, showBorder) {
        // Clear and set dimensions
        if (layout.startsWith('4r')) {
            layoutCanvas.width = PAGE_4R_W;
            layoutCanvas.height = PAGE_4R_H;
            dynamicPrintStyle.innerHTML = '@page { size: 4in 6in; margin: 0; }';
        } else {
            layoutCanvas.width = PAGE_A4_W;
            layoutCanvas.height = PAGE_A4_H;
            dynamicPrintStyle.innerHTML = '@page { size: A4; margin: 0; }';
        }

        // Fill white background
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, layoutCanvas.width, layoutCanvas.height);

        if (layout === '4r_4') {
            // 4 photos (2x2)
            const padding = 60; // gap between photos
            const startX = (PAGE_4R_W - (PP_WIDTH * 2 + padding)) / 2;
            const startY = 200;

            for(let row=0; row<2; row++) {
                for(let col=0; col<2; col++) {
                    const x = startX + col * (PP_WIDTH + padding);
                    const y = startY + row * (PP_HEIGHT + padding);
                    drawPhoto(x, y, PP_WIDTH, PP_HEIGHT, 0, showBorder);
                }
            }
        } 
        else if (layout === '4r_6') {
            // Standard 6-piece studio layout (zig-zag interlocking)
            const gap = 30; // Spacing between photos
            const totalW = PP_HEIGHT + gap + PP_WIDTH; // 591 + 30 + 472 = 1093
            const totalH = PP_HEIGHT + gap + PP_HEIGHT + gap + PP_WIDTH; // 591 + 30 + 591 + 30 + 472 = 1714
            
            const startX = (PAGE_4R_W - totalW) / 2;
            const startY = (PAGE_4R_H - totalH) / 2;
            
            const rightColX = startX + totalW - PP_WIDTH;
            const rightRotatedX = startX + totalW - PP_HEIGHT;

            // --- Left Column ---
            // 1. Top Left (Rotated, Head Left)
            drawPhoto(startX, startY, PP_HEIGHT, PP_WIDTH, -90, showBorder);
            // 2. Middle Left (Vertical)
            drawPhoto(startX, startY + PP_WIDTH + gap, PP_WIDTH, PP_HEIGHT, 0, showBorder);
            // 3. Bottom Left (Vertical)
            drawPhoto(startX, startY + PP_WIDTH + gap + PP_HEIGHT + gap, PP_WIDTH, PP_HEIGHT, 0, showBorder);

            // --- Right Column ---
            // 1. Top Right (Vertical)
            drawPhoto(rightColX, startY, PP_WIDTH, PP_HEIGHT, 0, showBorder);
            // 2. Middle Right (Vertical)
            drawPhoto(rightColX, startY + PP_HEIGHT + gap, PP_WIDTH, PP_HEIGHT, 0, showBorder);
            // 3. Bottom Right (Rotated, Head Right)
            drawPhoto(rightRotatedX, startY + PP_HEIGHT + gap + PP_HEIGHT + gap, PP_HEIGHT, PP_WIDTH, 90, showBorder);
        }
        else if (layout === 'a4_20') {
            // A4 page (2480 x 3508), 20 photos (4 cols x 5 rows)
            const gap = 60; 
            const cols = 4;
            const rows = 5;
            
            const totalW = (PP_WIDTH * cols) + (gap * (cols - 1));
            const totalH = (PP_HEIGHT * rows) + (gap * (rows - 1));
            
            const startX = (PAGE_A4_W - totalW) / 2;
            const startY = (PAGE_A4_H - totalH) / 2;

            for(let row=0; row<rows; row++) {
                for(let col=0; col<cols; col++) {
                    const x = startX + col * (PP_WIDTH + gap);
                    const y = startY + row * (PP_HEIGHT + gap);
                    drawPhoto(x, y, PP_WIDTH, PP_HEIGHT, 0, showBorder);
                }
            }
        }

        previewContainer.style.display = 'block';
        resultActions.style.display = 'flex';
    }

    function downloadLayout() {
        const dataUrl = layoutCanvas.toDataURL('image/jpeg', 1.0);
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = `Passport_Print_${layoutSelect.value}_${Date.now()}.jpg`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function printLayout() {
        // The canvas is inside #print-area. @media print handles visibility.
        window.print();
    }
</script>
@endsection
