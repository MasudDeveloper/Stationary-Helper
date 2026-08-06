@extends('layouts.app')

@section('title', 'যৌথ পাসপোর্ট ছবি মেকার (Husband-Wife Joint Photo) - penghor.com')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 35px; }
    .upload-box {
        border: 2px dashed var(--border-color);
        padding: 30px 20px;
        text-align: center;
        border-radius: 16px;
        background: rgba(255,255,255,0.04);
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
        height: 240px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .upload-box:hover {
        background: rgba(255,255,255,0.08);
        border-color: #3b82f6;
        transform: translateY(-3px);
    }
    .upload-box input[type="file"] {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .preview-thumb {
        max-width: 100%;
        max-height: 180px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        display: none;
    }
    .color-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.2);
        cursor: pointer;
        transition: all 0.2s;
        display: inline-block;
        position: relative;
    }
    .color-btn.active {
        border-color: #ffffff;
        transform: scale(1.15);
        box-shadow: 0 0 15px rgba(255,255,255,0.5);
    }
    .slider-group {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 15px;
    }
    .slider-group label {
        display: flex;
        justify-content: space-between;
        color: #e2e8f0;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .slider-group input[type="range"] {
        width: 100%;
        accent-color: #3b82f6;
    }
    .result-canvas-wrapper {
        text-align: center;
        background: rgba(15, 23, 42, 0.8);
        padding: 30px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    #joint-canvas {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6);
        border: 2px solid rgba(255,255,255,0.2);
    }
    .progress-bar-container {
        width: 100%;
        height: 12px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        overflow: hidden;
        margin: 20px 0;
        display: none;
    }
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #10b981);
        width: 0%;
        transition: width 0.3s ease;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1000px;">
    <div class="tool-header">
        <div class="tool-squircle grad-purple" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 24px; box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);">
            <i class="material-icons-round" style="font-size: 2.8rem; color: #fff;">people_alt</i>
        </div>
        <h2 style="color: #fff; font-size: 2rem; font-weight: 800;">যৌথ পাসপোর্ট ছবি মেকার (Husband-Wife Joint Photo)</h2>
        <p style="color: var(--text-muted); margin-top: 10px; font-size: 1.05rem; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            স্বামী-স্ত্রী বা দুজনের আলাদা ছবি আপলোড দিলে এক ক্লিকে দুই ছবির ব্যাকগ্রাউন্ড রিমুভ করে পাশাপাশি বসিয়ে প্রফেশনাল যৌথ পাসপোর্ট সাইজ ছবি তৈরি করুন!
        </p>
    </div>

    <!-- Step 1: Upload Photos -->
    <div class="glass" id="step-upload" style="padding: 40px; border-radius: 20px; margin-bottom: 30px;">
        <h3 style="color: #fff; font-size: 1.3rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <span style="background: #3b82f6; color: #fff; width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem;">১</span>
            দুজনের ছবি আপলোড করুন
        </h3>

        <div class="grid-2" style="gap: 30px;">
            <!-- Person 1 Upload -->
            <div>
                <label style="color: #60a5fa; font-weight: 700; margin-bottom: 10px; display: block; font-size: 1.05rem;"><i class="material-icons-round" style="vertical-align: middle; font-size: 20px;">person</i> ১ম ব্যক্তির ছবি (যেমন: স্বামী / Husband)</label>
                <div class="upload-box" id="box-p1">
                    <div id="placeholder-p1">
                        <i class="material-icons-round" style="font-size: 3.5rem; color: #64748b;">add_a_photo</i>
                        <p style="margin-top: 10px; color: #94a3b8; font-weight: 500;">ক্লিক করে ১ম ছবি নির্বাচন করুন</p>
                        <span style="font-size: 0.8rem; color: #64748b;">JPG, PNG সমর্থন করে</span>
                    </div>
                    <img id="thumb-p1" class="preview-thumb" alt="Preview Person 1">
                    <input type="file" id="input-p1" accept="image/*" onchange="previewImage(this, 1)">
                </div>
            </div>

            <!-- Person 2 Upload -->
            <div>
                <label style="color: #f472b6; font-weight: 700; margin-bottom: 10px; display: block; font-size: 1.05rem;"><i class="material-icons-round" style="vertical-align: middle; font-size: 20px;">person_outline</i> ২য় ব্যক্তির ছবি (যেমন: স্ত্রী / Wife)</label>
                <div class="upload-box" id="box-p2">
                    <div id="placeholder-p2">
                        <i class="material-icons-round" style="font-size: 3.5rem; color: #64748b;">add_a_photo</i>
                        <p style="margin-top: 10px; color: #94a3b8; font-weight: 500;">ক্লিক করে ২য় ছবি নির্বাচন করুন</p>
                        <span style="font-size: 0.8rem; color: #64748b;">JPG, PNG সমর্থন করে</span>
                    </div>
                    <img id="thumb-p2" class="preview-thumb" alt="Preview Person 2">
                    <input type="file" id="input-p2" accept="image/*" onchange="previewImage(this, 2)">
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 25px;"><label style="color: #cbd5e1; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 1.05rem;"><input type="checkbox" id="remove-bg-checkbox" checked style="width: 20px; height: 20px; accent-color: #3b82f6;">AI ব্যাকগ্রাউন্ড রিমুভ করুন (টিক তুলে দিলে দ্রুত কাজ করবে)</label></div><div style="text-align: center; margin-top: 25px;"><button id="btn-generate" onclick="startProcessing()" class="btn-primary" style="padding: 16px 40px; border-radius: 35px; font-size: 1.15rem; font-weight: 700; background: linear-gradient(135deg, #3b82f6, #10b981); border: none; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4); cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px;"><i class="material-icons-round" style="font-size: 26px;">auto_awesome</i> ছবি মার্জ করুন (Merge Photos)</button></div><!-- Progress bar during AI Background Removal -->
        <div id="loading-section" style="display: none; text-align: center; margin-top: 25px; background: rgba(30, 41, 59, 0.8); padding: 25px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
            <div style="display: inline-flex; align-items: center; gap: 12px; color: #60a5fa; font-weight: 700; font-size: 1.15rem; margin-bottom: 10px;">
                <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                <span id="loading-status-text">এআই দিয়ে ব্যাকগ্রাউন্ড রিমুভ করা হচ্ছে... (অনুগ্রহ করে অপেক্ষা করুন)</span>
            </div>
            <div class="progress-bar-container" style="display: block;">
                <div class="progress-bar-fill" id="progress-bar"></div>
            </div>
            <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">প্রথমবার লোড হতে একটু সময় নিতে পারে, এরপর তাৎক্ষণিক কাজ করবে।</p>
        </div>
    </div>

    <!-- Step 2 & 3: Editor & Live Preview (Hidden Initially) -->
    <div id="step-result" style="display: none;">
        <div class="grid-2" style="gap: 30px; align-items: start;">
            
            <!-- Controls & Settings Panel -->
            <div class="glass" style="padding: 30px; border-radius: 20px;">
                <h3 style="color: #fff; font-size: 1.25rem; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">
                    <i class="material-icons-round" style="vertical-align: middle; color: #60a5fa; margin-right: 6px;">tune</i> সাইজ ও পজিশন সমন্বয় (Customization)
                </h3>

                <!-- Background Color -->
                <div style="margin-bottom: 25px;">
                    <label style="color: #e2e8f0; font-size: 0.95rem; font-weight: 700; margin-bottom: 12px; display: block;">স্টুডিও ব্যাকগ্রাউন্ড কালার:</label>
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                        <span class="color-btn active" style="background: #0054a6;" onclick="setBgColor('#0054a6', this)" title="স্টুডিও ব্লু"></span>
                        <span class="color-btn" style="background: #ffffff;" onclick="setBgColor('#ffffff', this)" title="সাদা (White)"></span>
                        <span class="color-btn" style="background: #0284c7;" onclick="setBgColor('#0284c7', this)" title="আকাশী ব্লু (Sky Blue)"></span>
                        <span class="color-btn" style="background: #1e293b;" onclick="setBgColor('#1e293b', this)" title="ডার্ক নেভি"></span>
                        <span class="color-btn" style="background: #e5e7eb;" onclick="setBgColor('#e5e7eb', this)" title="স্টুডিও গ্রে"></span>
                        <div style="position: relative; display: inline-block;">
                            <input type="color" id="custom-color-picker" value="#0054a6" onchange="setBgColor(this.value)" style="width: 38px; height: 38px; border-radius: 50%; border: none; padding: 0; cursor: pointer; background: transparent;">
                        </div>
                    </div>
                </div>

                <!-- Passport Size Selector -->
                <div style="margin-bottom: 25px;">
                    <label style="color: #e2e8f0; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; display: block;">ছবির সাইজ (Size Format):</label>
                    <select id="size-selector" class="form-control" onchange="updateCanvasSize()" style="background: rgba(15, 23, 42, 0.9); color: #fff; border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; padding: 10px;">
                        <option value="591x472">যৌথ ল্যান্ডস্কেপ সাইজ (50mm x 40mm / স্ট্যান্ডার্ড পাশা-পাশি)</option>
                        <option value="600x450">স্ট্যান্ডার্ড স্টুডিও ল্যান্ডস্কেপ (4:3 Ratio / 600x450 px)</option>
                        <option value="600x400">ল্যান্ডস্কেপ ৩আর (3R Ratio - 600x400 px)</option>
                        <option value="472x591">পোর্ট্রেট সাইজ (40mm x 50mm - সিগেল পাসপোর্ট অনুপাত)</option>
                        <option value="450x450">স্কয়ার সাইজ (1.5 x 1.5 inch / 1:1)</option>
                    </select>
                </div>

                <!-- Person 1 Sliders -->
                <div style="border-left: 3px solid #60a5fa; padding-left: 12px; margin-bottom: 20px;">
                    <h4 style="color: #60a5fa; font-size: 1rem; margin-bottom: 12px;">১ম ব্যক্তি (বাম পাশে / Husband)</h4>
                    <div class="slider-group">
                        <label><span>জুম (Scale):</span> <span id="val-scale1">100%</span></label>
                        <input type="range" id="slider-scale1" min="0.5" max="1.6" step="0.02" value="1.0" oninput="renderCanvas()">
                    </div>
                    <div class="slider-group" style="margin-bottom: 0;">
                        <label><span>ওপর-নিচ পজিশন (Height Adjust):</span> <span id="val-y1">0 px</span></label>
                        <input type="range" id="slider-y1" min="-120" max="120" step="2" value="0" oninput="renderCanvas()">
                    </div>
                </div>

                <!-- Person 2 Sliders -->
                <div style="border-left: 3px solid #f472b6; padding-left: 12px; margin-bottom: 20px;">
                    <h4 style="color: #f472b6; font-size: 1rem; margin-bottom: 12px;">২য় ব্যক্তি (ডান পাশে / Wife)</h4>
                    <div class="slider-group">
                        <label><span>জুম (Scale):</span> <span id="val-scale2">100%</span></label>
                        <input type="range" id="slider-scale2" min="0.5" max="1.6" step="0.02" value="1.0" oninput="renderCanvas()">
                    </div>
                    <div class="slider-group" style="margin-bottom: 0;">
                        <label><span>ওপর-নিচ পজিশন (Height Adjust):</span> <span id="val-y2">0 px</span></label>
                        <input type="range" id="slider-y2" min="-120" max="120" step="2" value="0" oninput="renderCanvas()">
                    </div>
                </div>

                <!-- Spacing / Overlap Slider -->
                <div class="slider-group" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3);">
                    <label style="color: #34d399;"><span>দুজনের মাঝখানের দূরত্ব (Spacing):</span> <span id="val-spacing">0 px</span></label>
                    <input type="range" id="slider-spacing" min="-80" max="80" step="2" value="-15" oninput="renderCanvas()">
                </div>

                <button onclick="resetSliders()" class="btn" style="width: 100%; background: rgba(255,255,255,0.1); color: #cbd5e1; border-radius: 10px; padding: 8px; font-size: 0.9rem; margin-top: 10px;">
                    <i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">restart_alt</i> সাইজ ও পজিশন রিসেট করুন
                </button>
            </div>

            <!-- Canvas Result Panel -->
            <div class="result-canvas-wrapper">
                <h3 style="color: #fff; font-size: 1.3rem; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="material-icons-round" style="color: #34d399;">verified</i> তৈরি করা যৌথ পাসপোর্ট ছবি
                </h3>

                <canvas id="joint-canvas" width="591" height="472"></canvas>

                <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 15px;">
                    <button onclick="downloadJointPhoto()" class="btn-primary" style="padding: 14px 25px; border-radius: 30px; font-size: 1.1rem; font-weight: 700; background: linear-gradient(135deg, #10b981, #059669); border: none; box-shadow: 0 8px 20px rgba(16,185,129,0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="material-icons-round" style="font-size: 24px;">download</i> এইচডি ছবি ডাউনলোড করুন (JPG)
                    </button>

                    <button onclick="sendToPassportPrint()" class="btn" style="padding: 14px 25px; border-radius: 30px; font-size: 1.05rem; font-weight: 700; background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; box-shadow: 0 8px 20px rgba(245,158,11,0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="material-icons-round" style="font-size: 24px;">print</i> পাসপোর্ট প্রিন্ট শীটে পাঠান (A4 / 4R Print)
                    </button>

                    <button onclick="resetAll()" class="btn" style="padding: 10px 20px; border-radius: 25px; font-size: 0.95rem; font-weight: 600; background: rgba(255,255,255,0.1); color: #94a3b8; border: none; cursor: pointer;">
                        <i class="material-icons-round" style="vertical-align: middle; font-size: 20px;">refresh</i> নতুন ছবি আপলোড করুন
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Cropper Modal -->
<div id="cropModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; flex-direction: column; align-items: center; justify-content: center;">
    <div style="background: rgba(30, 41, 59, 1); padding: 20px; border-radius: 12px; width: 90%; max-width: 600px; display: flex; flex-direction: column; gap: 15px;">
        <h3 style="color: #fff; margin: 0; font-size: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">ছবি ক্রপ করুন (Passport Size)</h3>
        <div style="height: 60vh; background: #000; border-radius: 8px; display: flex; justify-content: center; align-items: center;">
            <img id="cropImage" src="" style="max-width: 100%; max-height: 100%; display: block;">
        </div>
        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button id="cancelCropBtn" class="btn" style="padding: 10px 20px; background: rgba(255,255,255,0.1); color: #fff; border: none; border-radius: 8px; cursor: pointer;">Cancel</button>
            <button id="saveCropBtn" class="btn-primary" style="padding: 10px 20px; background: #3b82f6; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">Crop & Save</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    let fileP1 = null;
    let fileP2 = null;
    let imgObj1 = null;
    let imgObj2 = null;
    let currentBgColor = '#0054a6';

    let cropperInstance = null;
    let currentCropPerson = null;

    function previewImage(input, personNum) {
        if (input.files && input.files[0]) {
            currentCropPerson = personNum;
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cropImage').src = e.target.result;
                document.getElementById('cropModal').style.display = 'flex';
                
                if (cropperInstance) cropperInstance.destroy();
                cropperInstance = new Cropper(document.getElementById('cropImage'), {
                    aspectRatio: 0.8, // 4:5 passport size ratio
                    viewMode: 1,
                    autoCropArea: 0.9,
                });
            }
            reader.readAsDataURL(file);
            input.value = ''; // Reset input to allow re-upload
        }
    }

    document.getElementById('cancelCropBtn').onclick = () => {
        document.getElementById('cropModal').style.display = 'none';
        if(cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    };

    document.getElementById('saveCropBtn').onclick = () => {
        if (!cropperInstance) return;
        const canvas = cropperInstance.getCroppedCanvas({
            width: 400,
            height: 500,
            fillColor: '#fff'
        });
        canvas.toBlob((blob) => {
            if (currentCropPerson === 1) fileP1 = blob;
            if (currentCropPerson === 2) fileP2 = blob;
            
            const thumbUrl = URL.createObjectURL(blob);
            document.getElementById(`placeholder-p${currentCropPerson}`).style.display = 'none';
            const thumb = document.getElementById(`thumb-p${currentCropPerson}`);
            thumb.src = thumbUrl;
            thumb.style.display = 'block';
            
            document.getElementById('cropModal').style.display = 'none';
            cropperInstance.destroy();
            cropperInstance = null;
        }, 'image/jpeg', 1.0);
    };

    async function startProcessing() {
        if (!fileP1 || !fileP2) {
            Swal.fire({
                title: 'ছবি নির্বাচন করুন!',
                text: 'যৌথ ছবি তৈরি করতে স্বামী ও স্ত্রী দুজনের ছবিই নির্বাচন করতে হবে।',
                icon: 'warning',
                background: '#1e293b',
                color: '#fff'
            });
            return;
        }

        document.getElementById('btn-generate').disabled = true;
        document.getElementById('loading-section').style.display = 'block';
        document.getElementById('progress-bar').style.width = '10%';

                try {
            const useBgRemover = document.getElementById('remove-bg-checkbox').checked;

            if (!useBgRemover) {
                document.getElementById('loading-status-text').innerText = 'ছবি লোড করা হচ্ছে...';
                imgObj1 = await blobToImage(fileP1);
                document.getElementById('progress-bar').style.width = '50%';
                imgObj2 = await blobToImage(fileP2);
                document.getElementById('progress-bar').style.width = '100%';
            } else {
                document.getElementById('loading-status-text').innerText = '১ম ছবির ব্যাকগ্রাউন্ড রিমুভ করা হচ্ছে...';
                
                async function removeBgWithAPI(file) {
                    const formData = new FormData();
                    formData.append('image', file, 'image.jpg');
                    formData.append('tool_name', 'Joint Photo Maker');
                    
                    const res = await fetch("{{ route('pdf.tools.bg_remover.process') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    
                    const data = await res.json();
                    if (!data.success) {
                        throw new Error(data.message || 'সার্ভার এরর!');
                    }
                    return data.image; // data:image/png;base64,...
                }

                // Remove BG for Person 1
                let base64_1 = await removeBgWithAPI(fileP1);
                imgObj1 = await base64ToImage(base64_1);
                
                document.getElementById('progress-bar').style.width = '50%';
                document.getElementById('loading-status-text').innerText = '২য় ছবির ব্যাকগ্রাউন্ড রিমুভ করা হচ্ছে...';

                // Remove BG for Person 2
                let base64_2 = await removeBgWithAPI(fileP2);
                imgObj2 = await base64ToImage(base64_2);
            }

            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('loading-status-text').innerText = 'ছবি মার্জ করা হচ্ছে, অপেক্ষা করুন...';

            setTimeout(() => {
                document.getElementById('step-upload').style.display = 'none';
                document.getElementById('step-result').style.display = 'block';
                document.getElementById('loading-section').style.display = 'none';
                document.getElementById('btn-generate').disabled = false;
                
                updateCanvasSize();
                renderCanvas();
            }, 500);

        } catch (error) {
            console.error(error);
            Swal.fire({
                title: 'ত্রুটি!',
                text: 'ব্যাকগ্রাউন্ড রিমুভ করতে সমস্যা হয়েছে: ' + error.message,
                icon: 'error',
                background: '#1e293b',
                color: '#fff'
            });
            document.getElementById('loading-section').style.display = 'none';
            document.getElementById('btn-generate').disabled = false;
        }
    }

    // Defringe / clean white halo pixels from AI cutout
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
                for (let i = 0; i < data.length; i += 4) {
                    const alpha = data[i + 3];
                    if (alpha > 0 && alpha < 250) {
                        data[i] = Math.max(0, data[i] - 60);
                        data[i+1] = Math.max(0, data[i+1] - 60);
                        data[i+2] = Math.max(0, data[i+2] - 60);
                        data[i+3] = Math.max(0, alpha - 20);
                    }
                }
                ctx.putImageData(imgData, 0, 0);
                canvas.toBlob((b) => resolve(b), 'image/png');
            };
            img.src = URL.createObjectURL(blob);
        });
    }

    function blobToImage(blob) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.src = URL.createObjectURL(blob);
        });
    }

    function base64ToImage(base64) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.src = base64;
        });
    }

    function setBgColor(color, btnEl) {
        currentBgColor = color;
        if (btnEl) {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            btnEl.classList.add('active');
        }
        renderCanvas();
    }

    function updateCanvasSize() {
        const sizeStr = document.getElementById('size-selector').value;
        const [w, h] = sizeStr.split('x').map(Number);
        const canvas = document.getElementById('joint-canvas');
        canvas.width = w;
        canvas.height = h;
        renderCanvas();
    }

    function renderCanvas() {
        if (!imgObj1 || !imgObj2) return;

        const canvas = document.getElementById('joint-canvas');
        const ctx = canvas.getContext('2d');
        const cw = canvas.width;
        const ch = canvas.height;

        // Fill background
        ctx.fillStyle = currentBgColor;
        ctx.fillRect(0, 0, cw, ch);

        // Read slider values
        const scale1 = parseFloat(document.getElementById('slider-scale1').value);
        const yOffset1 = parseFloat(document.getElementById('slider-y1').value);
        const scale2 = parseFloat(document.getElementById('slider-scale2').value);
        const yOffset2 = parseFloat(document.getElementById('slider-y2').value);
        const spacing = parseFloat(document.getElementById('slider-spacing').value);

        // Update labels
        document.getElementById('val-scale1').innerText = Math.round(scale1 * 100) + '%';
        document.getElementById('val-y1').innerText = yOffset1 + ' px';
        document.getElementById('val-scale2').innerText = Math.round(scale2 * 100) + '%';
        document.getElementById('val-y2').innerText = yOffset2 + ' px';
        document.getElementById('val-spacing').innerText = spacing + ' px';

        // Calculate base height (fit to approx 85% of canvas height)
        let targetHeight = ch * 0.85;
        
        // Person 1 aspect and dimensions
        const ratio1 = imgObj1.width / imgObj1.height;
        let h1 = targetHeight * scale1;
        let w1 = h1 * ratio1;

        // Person 2 aspect and dimensions
        const ratio2 = imgObj2.width / imgObj2.height;
        let h2 = targetHeight * scale2;
        let w2 = h2 * ratio2;

        // Total width of both persons combined plus spacing
        let totalW = w1 + w2 + spacing;

        // SMART AUTO-FIT SAFEGUARD:
        // If total width exceeds 90% of the canvas width, automatically scale down both heights proportionally!
        // This ensures BOTH husband and wife are ALWAYS 100% visible and NEVER cut off at the edges!
        const maxAllowedW = cw * 0.90;
        if (totalW > maxAllowedW) {
            const fitFactor = maxAllowedW / totalW;
            h1 *= fitFactor;
            w1 *= fitFactor;
            h2 *= fitFactor;
            w2 *= fitFactor;
            totalW = w1 + w2 + spacing;
        }

        // Center them horizontally
        const startX = (cw - totalW) / 2;
        const x1 = startX;
        const x2 = startX + w1 + spacing;

        // Align to bottom edge with Y offset
        const y1 = ch - h1 + yOffset1;
        const y2 = ch - h2 + yOffset2;

        // Draw Image 1 (Husband/Left Person)
        ctx.drawImage(imgObj1, x1, y1, w1, h1);

        // Draw Image 2 (Wife/Right Person)
        ctx.drawImage(imgObj2, x2, y2, w2, h2);
    }

    function resetSliders() {
        document.getElementById('slider-scale1').value = 1.0;
        document.getElementById('slider-y1').value = 0;
        document.getElementById('slider-scale2').value = 1.0;
        document.getElementById('slider-y2').value = 0;
        document.getElementById('slider-spacing').value = -15;
        renderCanvas();
    }

    function downloadJointPhoto() {
        const canvas = document.getElementById('joint-canvas');
        const link = document.createElement('a');
        link.download = `Joint_Passport_Photo_${Date.now()}.jpg`;
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
    }

    function sendToPassportPrint() {
        const canvas = document.getElementById('joint-canvas');
        const dataUrl = canvas.toDataURL('image/jpeg', 0.95);
        localStorage.setItem('transfer_job_photo', dataUrl);

        Swal.fire({
            title: 'প্রিন্ট শীটে পাঠানো হয়েছে!',
            text: 'আপনাকে পাসপোর্ট প্রিন্ট শীট পেজে নিয়ে যাওয়া হচ্ছে। সেখান থেকে 4R বা A4 পেপারে একাধিক কপি প্রিন্ট করতে পারবেন।',
            icon: 'success',
            background: '#1e293b',
            color: '#fff',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "{{ route('pdf.tools.passport_print') }}";
        });
    }

    function resetAll() {
        fileP1 = null;
        fileP2 = null;
        imgObj1 = null;
        imgObj2 = null;
        document.getElementById('input-p1').value = '';
        document.getElementById('input-p2').value = '';
        document.getElementById('thumb-p1').style.display = 'none';
        document.getElementById('thumb-p2').style.display = 'none';
        document.getElementById('placeholder-p1').style.display = 'block';
        document.getElementById('placeholder-p2').style.display = 'block';
        document.getElementById('step-result').style.display = 'none';
        document.getElementById('step-upload').style.display = 'block';
        resetSliders();
    }
</script>
@endsection
