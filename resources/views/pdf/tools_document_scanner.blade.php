@extends('layouts.app')

@section('title', 'ছবি ও ডকুমেন্ট সোজা করুন (CamScanner Perspective Crop) - penghor.com')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 35px; }
    .upload-box {
        border: 2px dashed var(--border-color);
        padding: 40px 20px;
        text-align: center;
        border-radius: 16px;
        background: rgba(255,255,255,0.04);
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
        max-width: 600px;
        margin: 0 auto;
    }
    .upload-box:hover {
        background: rgba(255,255,255,0.08);
        border-color: #ec4899;
        transform: translateY(-3px);
    }
    .upload-box input[type="file"] {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .canvas-container {
        position: relative;
        display: inline-block;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        border: 2px solid rgba(255,255,255,0.15);
        background: #0f172a;
        max-width: 100%;
    }
    #editor-canvas {
        display: block;
        max-width: 100%;
        height: auto;
        cursor: crosshair;
    }
    .filter-btn {
        padding: 10px 18px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(30, 41, 59, 0.8);
        color: #e2e8f0;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .filter-btn:hover, .filter-btn.active {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
    }
    .ratio-btn {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        color: #cbd5e1;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .ratio-btn.active, .ratio-btn:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }
    .step-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .badge-step {
        background: #ec4899;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        margin-right: 10px;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1100px;">
    <div class="tool-header">
        <div class="tool-squircle grad-pink" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 24px; box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4);">
            <i class="material-icons-round" style="font-size: 2.8rem; color: #fff;">document_scanner</i>
        </div>
        <h2 style="color: #fff; font-size: 2rem; font-weight: 800;">ছবি ও ডকুমেন্ট সোজা করুন (CamScanner Perspective Crop)</h2>
        <p style="color: var(--text-muted); margin-top: 10px; font-size: 1.05rem; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            মোবাইল দিয়ে বাঁকাত্যারা করে তোলা যেকোনো ছবি, এনআইডি, সার্টিফিকেট বা বইয়ের পাতার ৪ কর্নার সিলেক্ট করে এক ক্লিকেই ফটোশপের মতো ৯০ ডিগ্রি সোজা ও ক্লিয়ার করুন!
        </p>
    </div>

    <!-- Step 1: Upload Box -->
    <div id="step-1" class="step-card">
        <h3 style="color: #fff; font-size: 1.3rem; margin-bottom: 25px; text-align: center;">
            <span class="badge-step">১</span> বাঁকাত্যারা ছবি বা ডকুমেন্ট আপলোড করুন
        </h3>

        <div class="upload-box" id="drop-area">
            <i class="material-icons-round" style="font-size: 4rem; color: #f472b6;">add_photo_alternate</i>
            <p style="margin-top: 15px; color: #e2e8f0; font-size: 1.1rem; font-weight: 600;">ক্লিক করে ছবি নির্বাচন করুন অথবা এখানে টেনে আনুন</p>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 5px;">এনআইডি কার্ড, দলিল, সার্টিফিকেট, বইয়ের পাতা বা যেকোনো ছবি (JPG, PNG)</p>
            <input type="file" id="file-input" accept="image/*" onchange="handleImageUpload(this)">
        </div>
    </div>

    <!-- Step 2: 4-Corner Editor (Hidden Initially) -->
    <div id="step-2" class="step-card" style="display: none; text-align: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; text-align: left;">
            <h3 style="color: #fff; font-size: 1.3rem; margin: 0; display: flex; align-items: center;">
                <span class="badge-step">২</span> ৪টি কর্নার মাউস বা হাত দিয়ে টেনে ডকুমেন্টের কোণায় বসান
            </h3>
            
            <!-- Quick Preset Corner Buttons -->
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button onclick="resetCorners(0.05)" class="ratio-btn" title="কর্নার একটু ভেতরে আনুন">
                    <i class="material-icons-round" style="vertical-align: middle; font-size: 16px;">filter_center_focus</i> অটো মার্জিন
                </button>
                <button onclick="resetCorners(0)" class="ratio-btn" title="পুরো ছবির ৪ কোণায় সেট করুন">
                    <i class="material-icons-round" style="vertical-align: middle; font-size: 16px;">fullscreen</i> ফুল ইমেজ
                </button>
            </div>
        </div>

        <p style="color: #60a5fa; font-size: 0.95rem; margin-bottom: 20px; background: rgba(59, 130, 246, 0.1); padding: 10px 15px; border-radius: 10px; display: inline-block;">
            💡 <strong>টিপস:</strong> লাল, সবুজ, নীল ও হলুদ রঙের ৪টি বৃত্ত টেনে আপনার ডকুমেন্টের আসল ৪ কোণায় ঠিকমত বসিয়ে নিচের বাটনে ক্লিক করুন।
        </p>

        <!-- Aspect Ratio Option -->
        <div style="margin-bottom: 25px; display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
            <span style="color: #e2e8f0; font-weight: 600; font-size: 0.95rem;">আউটপুট অনুপাত (Ratio):</span>
            <button onclick="setRatio('auto', this)" class="ratio-btn active">✨ অটোমেটিক (Auto)</button>
            <button onclick="setRatio('a4', this)" class="ratio-btn">📄 A4 ডকুমেন্ট (210x297)</button>
            <button onclick="setRatio('nid', this)" class="ratio-btn">🪪 এনআইডি / কার্ড (85x54)</button>
            <button onclick="setRatio('legal', this)" class="ratio-btn">📜 লিগ্যাল সাইজ</button>
            <button onclick="setRatio('square', this)" class="ratio-btn">🔲 স্কয়ার (1:1)</button>
        </div>

        <!-- Editor Canvas -->
        <div style="overflow-x: auto; padding: 10px 0;">
            <div class="canvas-container" id="editor-container">
                <canvas id="editor-canvas"></canvas>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <button onclick="processPerspectiveCrop()" class="btn-primary" style="padding: 16px 40px; border-radius: 35px; font-size: 1.15rem; font-weight: 700; background: linear-gradient(135deg, #ec4899, #8b5cf6); border: none; box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4); cursor: pointer; display: inline-flex; align-items: center; gap: 10px;">
                <i class="material-icons-round" style="font-size: 26px;">auto_fix_high</i> ✨ ছবি সোজা ও ক্রপ করুন (Straighten Document)
            </button>
            <button onclick="uploadNewImage()" class="btn" style="padding: 14px 25px; border-radius: 30px; background: rgba(255,255,255,0.1); color: #cbd5e1; border: none; font-weight: 600; cursor: pointer;">
                <i class="material-icons-round" style="vertical-align: middle;">refresh</i> অন্য ছবি নিন
            </button>
        </div>
    </div>

    <!-- Step 3: Result & CamScanner Filters (Hidden Initially) -->
    <div id="step-3" class="step-card" style="display: none; text-align: center;">
        <h3 style="color: #fff; font-size: 1.4rem; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="material-icons-round" style="color: #34d399;">task_alt</i> ৯০ ডিগ্রি সোজা করা প্রফেশনাল ডকুমেন্ট
        </h3>

        <!-- CamScanner Style Filter Toolbar -->
        <div style="margin-bottom: 25px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
            <button onclick="applyFilter('original', this)" class="filter-btn active">
                <i class="material-icons-round" style="color: #60a5fa;">image</i> অরিজিনাল কালার
            </button>
            <button onclick="applyFilter('magic', this)" class="filter-btn">
                <i class="material-icons-round" style="color: #f59e0b;">auto_awesome</i> ম্যাজিক কালার (ক্লিন ও উজ্জ্বল)
            </button>
            <button onclick="applyFilter('bw', this)" class="filter-btn">
                <i class="material-icons-round" style="color: #fff;">contrast</i> সাদা-কালো ডকুমেন্ট (B&W Scan)
            </button>
            <button onclick="applyFilter('gray', this)" class="filter-btn">
                <i class="material-icons-round" style="color: #94a3b8;">filter_b_and_w</i> গ্রে-স্কেল
            </button>
        </div>

        <!-- Result Canvas / Image Preview -->
        <div style="overflow-x: auto; padding: 10px 0; margin-bottom: 30px;">
            <div class="canvas-container" style="background: #ffffff; padding: 10px; border-radius: 12px;">
                <canvas id="result-canvas" style="max-width: 100%; height: auto; display: block; margin: 0 auto; border-radius: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);"></canvas>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <button onclick="downloadDocument('jpg')" class="btn-primary" style="padding: 15px 30px; border-radius: 30px; font-size: 1.1rem; font-weight: 700; background: linear-gradient(135deg, #10b981, #059669); border: none; box-shadow: 0 8px 20px rgba(16,185,129,0.4); cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round">download</i> এইচডি ডাউনলোড (JPG)
            </button>
            <button onclick="downloadDocument('png')" class="btn" style="padding: 15px 25px; border-radius: 30px; font-size: 1.05rem; font-weight: 700; background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; border: none; box-shadow: 0 8px 20px rgba(59,130,246,0.3); cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round">image</i> ডাউনলোড (PNG)
            </button>
            <button onclick="printDocument()" class="btn" style="padding: 15px 25px; border-radius: 30px; font-size: 1.05rem; font-weight: 700; background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; box-shadow: 0 8px 20px rgba(245,158,11,0.3); cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round">print</i> সরাসরি প্রিন্ট করুন
            </button>
            <button onclick="backToEditor()" class="btn" style="padding: 12px 22px; border-radius: 25px; background: rgba(255,255,255,0.1); color: #e2e8f0; border: none; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="material-icons-round">edit</i> কর্নার এডিট করুন
            </button>
            <button onclick="uploadNewImage()" class="btn" style="padding: 12px 22px; border-radius: 25px; background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.4); font-weight: 600; cursor: pointer;">
                নতুন ছবি
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let origImage = new Image();
    let editorCanvas, editorCtx;
    let resultCanvas, resultCtx;
    
    // Corner points normalized (0.0 to 1.0)
    // 0: Top-Left, 1: Top-Right, 2: Bottom-Right, 3: Bottom-Left
    let corners = [
        { x: 0.1, y: 0.1 },
        { x: 0.9, y: 0.1 },
        { x: 0.9, y: 0.9 },
        { x: 0.1, y: 0.9 }
    ];

    let activeCornerIndex = -1;
    let dragThreshold = 35; // px radius for clicking handle
    let selectedRatio = 'auto';
    let currentFilter = 'original';
    let unwarpedImageData = null;

    window.onload = function() {
        editorCanvas = document.getElementById('editor-canvas');
        editorCtx = editorCanvas.getContext('2d');
        resultCanvas = document.getElementById('result-canvas');
        resultCtx = resultCanvas.getContext('2d');

        setupMouseAndTouchEvents();
    };

    function handleImageUpload(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                origImage.onload = function() {
                    document.getElementById('step-1').style.display = 'none';
                    document.getElementById('step-2').style.display = 'block';
                    document.getElementById('step-3').style.display = 'none';
                    
                    initEditor();
                };
                origImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function initEditor() {
        // Fit canvas width to max 800px while maintaining aspect ratio
        const maxW = Math.min(window.innerWidth - 60, 800);
        const scale = origImage.width > maxW ? maxW / origImage.width : 1;
        
        editorCanvas.width = origImage.width * scale;
        editorCanvas.height = origImage.height * scale;

        resetCorners(0.06); // 6% inset by default
        renderEditor();
    }

    function resetCorners(inset) {
        corners = [
            { x: inset, y: inset },
            { x: 1 - inset, y: inset },
            { x: 1 - inset, y: 1 - inset },
            { x: inset, y: 1 - inset }
        ];
        renderEditor();
    }

    function renderEditor() {
        if (!origImage.width) return;
        
        const cw = editorCanvas.width;
        const ch = editorCanvas.height;

        // Draw original photo
        editorCtx.clearRect(0, 0, cw, ch);
        editorCtx.drawImage(origImage, 0, 0, cw, ch);

        // Convert normalized corners to canvas coordinates
        const pts = corners.map(c => ({ x: c.x * cw, y: c.y * ch }));

        // Draw semi-transparent dark mask outside polygon
        editorCtx.save();
        editorCtx.fillStyle = 'rgba(0, 0, 0, 0.55)';
        editorCtx.beginPath();
        editorCtx.moveTo(0, 0);
        editorCtx.lineTo(cw, 0);
        editorCtx.lineTo(cw, ch);
        editorCtx.lineTo(0, ch);
        editorCtx.closePath();
        
        // Cut out quad
        editorCtx.moveTo(pts[0].x, pts[0].y);
        editorCtx.lineTo(pts[3].x, pts[3].y);
        editorCtx.lineTo(pts[2].x, pts[2].y);
        editorCtx.lineTo(pts[1].x, pts[1].y);
        editorCtx.closePath();
        editorCtx.fill('evenodd');
        editorCtx.restore();

        // Draw glowing quad boundary lines
        editorCtx.save();
        editorCtx.lineWidth = 3;
        editorCtx.strokeStyle = '#38bdf8';
        editorCtx.shadowColor = '#0284c7';
        editorCtx.shadowBlur = 10;
        editorCtx.beginPath();
        editorCtx.moveTo(pts[0].x, pts[0].y);
        editorCtx.lineTo(pts[1].x, pts[1].y);
        editorCtx.lineTo(pts[2].x, pts[2].y);
        editorCtx.lineTo(pts[3].x, pts[3].y);
        editorCtx.closePath();
        editorCtx.stroke();

        // Draw 3x3 Grid inside Quad for precision straightening
        editorCtx.lineWidth = 1;
        editorCtx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
        editorCtx.shadowBlur = 0;
        for (let i = 1; i <= 2; i++) {
            let t = i / 3.0;
            // Horizontal lines
            let pLeftX = pts[0].x + (pts[3].x - pts[0].x) * t;
            let pLeftY = pts[0].y + (pts[3].y - pts[0].y) * t;
            let pRightX = pts[1].x + (pts[2].x - pts[1].x) * t;
            let pRightY = pts[1].y + (pts[2].y - pts[1].y) * t;
            editorCtx.beginPath();
            editorCtx.moveTo(pLeftX, pLeftY);
            editorCtx.lineTo(pRightX, pRightY);
            editorCtx.stroke();

            // Vertical lines
            let pTopX = pts[0].x + (pts[1].x - pts[0].x) * t;
            let pTopY = pts[0].y + (pts[1].y - pts[0].y) * t;
            let pBotX = pts[3].x + (pts[2].x - pts[3].x) * t;
            let pBotY = pts[3].y + (pts[2].y - pts[3].y) * t;
            editorCtx.beginPath();
            editorCtx.moveTo(pTopX, pTopY);
            editorCtx.lineTo(pBotX, pBotY);
            editorCtx.stroke();
        }

        // Draw 4 Corner Handles with distinct colors
        const handleColors = ['#ef4444', '#22c55e', '#3b82f6', '#eab308']; // Red, Green, Blue, Yellow
        const handleLabels = ['TL', 'TR', 'BR', 'BL'];
        
        pts.forEach((p, idx) => {
            // Outer white ring
            editorCtx.beginPath();
            editorCtx.arc(p.x, p.y, 16, 0, Math.PI * 2);
            editorCtx.fillStyle = '#ffffff';
            editorCtx.shadowColor = 'rgba(0,0,0,0.5)';
            editorCtx.shadowBlur = 8;
            editorCtx.fill();

            // Inner colored circle
            editorCtx.beginPath();
            editorCtx.arc(p.x, p.y, 12, 0, Math.PI * 2);
            editorCtx.fillStyle = handleColors[idx];
            editorCtx.fill();
            
            // Center dot
            editorCtx.beginPath();
            editorCtx.arc(p.x, p.y, 3, 0, Math.PI * 2);
            editorCtx.fillStyle = '#ffffff';
            editorCtx.fill();
        });
        editorCtx.restore();
    }

    function setupMouseAndTouchEvents() {
        function getCanvasCoords(e) {
            const rect = editorCanvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function onStart(e) {
            const pos = getCanvasCoords(e);
            const cw = editorCanvas.width;
            const ch = editorCanvas.height;

            activeCornerIndex = -1;
            let minDist = dragThreshold;

            corners.forEach((c, idx) => {
                const cx = c.x * cw;
                const cy = c.y * ch;
                const dist = Math.hypot(pos.x - cx, pos.y - cy);
                if (dist < minDist) {
                    minDist = dist;
                    activeCornerIndex = idx;
                }
            });

            if (activeCornerIndex !== -1) {
                e.preventDefault();
            }
        }

        function onMove(e) {
            if (activeCornerIndex === -1) return;
            e.preventDefault();

            const pos = getCanvasCoords(e);
            const cw = editorCanvas.width;
            const ch = editorCanvas.height;

            // Clamp between 0 and 1
            let nx = Math.max(0, Math.min(1, pos.x / cw));
            let ny = Math.max(0, Math.min(1, pos.y / ch));

            corners[activeCornerIndex] = { x: nx, y: ny };
            renderEditor();
        }

        function onEnd(e) {
            activeCornerIndex = -1;
        }

        editorCanvas.addEventListener('mousedown', onStart);
        window.addEventListener('mousemove', onMove);
        window.addEventListener('mouseup', onEnd);

        editorCanvas.addEventListener('touchstart', onStart, { passive: false });
        window.addEventListener('touchmove', onMove, { passive: false });
        window.addEventListener('touchend', onEnd);
    }

    function setRatio(ratio, btnEl) {
        selectedRatio = ratio;
        document.querySelectorAll('.ratio-btn').forEach(b => b.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');
    }

    // THE CORE PERSPECTIVE TRANSFORMATION (BILINEAR QUAD UNWARP)
    function processPerspectiveCrop() {
        Swal.fire({
            title: 'ছবি সোজা করা হচ্ছে...',
            text: 'অনুগ্রহ করে অপেক্ষা করুন, ৪ কর্নার ক্যালকুলেট করে ৯০ ডিগ্রি সোজা করা হচ্ছে...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        setTimeout(() => {
            const ow = origImage.width;
            const oh = origImage.height;

            // Convert normalized corners to original image pixel coordinates
            const p0 = { x: corners[0].x * ow, y: corners[0].y * oh }; // TL
            const p1 = { x: corners[1].x * ow, y: corners[1].y * oh }; // TR
            const p2 = { x: corners[2].x * ow, y: corners[2].y * oh }; // BR
            const p3 = { x: corners[3].x * ow, y: corners[3].y * oh }; // BL

            // Calculate physical lengths of top, bottom, left, right edges
            const widthTop = Math.hypot(p1.x - p0.x, p1.y - p0.y);
            const widthBot = Math.hypot(p2.x - p3.x, p2.y - p3.y);
            const heightLeft = Math.hypot(p3.x - p0.x, p3.y - p0.y);
            const heightRight = Math.hypot(p2.x - p1.x, p2.y - p1.y);

            let destW = Math.round(Math.max(widthTop, widthBot));
            let destH = Math.round(Math.max(heightLeft, heightRight));

            // Apply selected ratio override if not auto
            if (selectedRatio === 'a4') {
                destH = Math.round(destW * (297 / 210));
            } else if (selectedRatio === 'nid') {
                destH = Math.round(destW * (54 / 85.6));
            } else if (selectedRatio === 'legal') {
                destH = Math.round(destW * (14 / 8.5));
            } else if (selectedRatio === 'square') {
                destH = destW;
            }

            // Limit max dimensions for lightning fast rendering while keeping crisp 300 DPI quality
            const maxDim = 2000;
            if (destW > maxDim || destH > maxDim) {
                const sc = maxDim / Math.max(destW, destH);
                destW = Math.round(destW * sc);
                destH = Math.round(destH * sc);
            }

            // Create offscreen canvas for original source image data
            const srcCanvas = document.createElement('canvas');
            srcCanvas.width = ow;
            srcCanvas.height = oh;
            const srcCtx = srcCanvas.getContext('2d');
            srcCtx.drawImage(origImage, 0, 0);
            const srcData = srcCtx.getImageData(0, 0, ow, oh).data;

            // Prepare destination canvas
            resultCanvas.width = destW;
            resultCanvas.height = destH;
            const destImgData = resultCtx.createImageData(destW, destH);
            const destData = destImgData.data;

            // Bilinear interpolation mapping for every destination pixel
            for (let dy = 0; dy < destH; dy++) {
                const v = dy / (destH - 1);
                for (let dx = 0; dx < destW; dx++) {
                    const u = dx / (destW - 1);

                    // Interpolate X and Y in source quad
                    const sx = (1 - u) * (1 - v) * p0.x + u * (1 - v) * p1.x + u * v * p2.x + (1 - u) * v * p3.x;
                    const sy = (1 - u) * (1 - v) * p0.y + u * (1 - v) * p1.y + u * v * p2.y + (1 - u) * v * p3.y;

                    // Nearest neighbor / simple bilinear pixel sample
                    const px = Math.min(ow - 1, Math.max(0, Math.round(sx)));
                    const py = Math.min(oh - 1, Math.max(0, Math.round(sy)));
                    const srcIdx = (py * ow + px) * 4;
                    const destIdx = (dy * destW + dx) * 4;

                    destData[destIdx] = srcData[srcIdx];         // R
                    destData[destIdx + 1] = srcData[srcIdx + 1]; // G
                    destData[destIdx + 2] = srcData[srcIdx + 2]; // B
                    destData[destIdx + 3] = 255;                 // A
                }
            }

            // Save raw unwarped image data for filter switching
            unwarpedImageData = destImgData;
            resultCtx.putImageData(unwarpedImageData, 0, 0);

            // Switch to result step
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-3').style.display = 'block';
            
            applyFilter(currentFilter, document.querySelector('.filter-btn.active'));
            Swal.close();
        }, 150);
    }

    // CAMSCANNER STYLE ENHANCEMENT FILTERS
    function applyFilter(filterType, btnEl) {
        currentFilter = filterType;
        if (btnEl) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btnEl.classList.add('active');
        }

        if (!unwarpedImageData) return;

        const w = resultCanvas.width;
        const h = resultCanvas.height;
        const copyData = resultCtx.createImageData(w, h);
        const src = unwarpedImageData.data;
        const dst = copyData.data;

        for (let i = 0; i < src.length; i += 4) {
            let r = src[i];
            let g = src[i+1];
            let b = src[i+2];

            if (filterType === 'magic') {
                // Magic Color: Increase contrast, brighten white background, saturate colors
                // Calculate luminance
                let lum = 0.299 * r + 0.587 * g + 0.114 * b;
                // Contrast boost
                r = ((r - 128) * 1.35) + 128 + 15;
                g = ((g - 128) * 1.35) + 128 + 15;
                b = ((b - 128) * 1.35) + 128 + 15;
                // If light paper, push closer to pure white
                if (lum > 175) {
                    r = Math.min(255, r * 1.15);
                    g = Math.min(255, g * 1.15);
                    b = Math.min(255, b * 1.15);
                }
            } else if (filterType === 'bw') {
                // B&W Clear Scan: Adaptive thresholding style for sharp text on white paper
                let lum = 0.299 * r + 0.587 * g + 0.114 * b;
                let val = lum > 140 ? 255 : (lum < 90 ? 0 : lum * 0.8);
                r = g = b = val;
            } else if (filterType === 'gray') {
                // Grayscale
                let lum = 0.299 * r + 0.587 * g + 0.114 * b;
                r = g = b = lum;
            }

            dst[i] = Math.min(255, Math.max(0, r));
            dst[i+1] = Math.min(255, Math.max(0, g));
            dst[i+2] = Math.min(255, Math.max(0, b));
            dst[i+3] = 255;
        }

        resultCtx.putImageData(copyData, 0, 0);
    }

    function downloadDocument(format) {
        const link = document.createElement('a');
        const ext = format === 'png' ? 'png' : 'jpg';
        const mime = format === 'png' ? 'image/png' : 'image/jpeg';
        link.download = `Scanned_Document_${Date.now()}.${ext}`;
        link.href = resultCanvas.toDataURL(mime, 0.95);
        link.click();
    }

    function printDocument() {
        const dataUrl = resultCanvas.toDataURL('image/jpeg', 0.98);
        const win = window.open('', '_blank');
        win.document.write(`
            <html>
            <head><title>Print Scanned Document - penghor.com</title></head>
            <body style="margin:0; padding:0; display:flex; justify-content:center; align-items:center; min-height:100vh;">
                <img src="${dataUrl}" style="max-width:100%; max-height:100vh; display:block;" onload="window.print();">
            </body>
            </html>
        `);
        win.document.close();
    }

    function backToEditor() {
        document.getElementById('step-3').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    }

    function uploadNewImage() {
        document.getElementById('file-input').value = '';
        document.getElementById('step-3').style.display = 'none';
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';
    }
</script>
@endsection
