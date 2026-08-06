@extends('layouts.app')

@section('title', 'অ্যাডভান্স ফটো স্টুডিও (Passport Maker) - penghor.com')

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
    .color-btn {
        width: 35px; height: 35px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.2);
        cursor: pointer;
        display: inline-block;
        transition: all 0.2s;
    }
    .color-btn.active {
        border-color: #ffffff;
        transform: scale(1.15);
        box-shadow: 0 0 15px rgba(255,255,255,0.5);
    }
    .slider-group {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 12px;
    }
    .slider-group label {
        display: flex; justify-content: space-between;
        color: #e2e8f0; font-size: 0.9rem; font-weight: 600; margin-bottom: 5px;
    }
    .slider-group input[type="range"] {
        width: 100%; accent-color: #3b82f6;
    }
    .canvas-container {
        background: rgba(15, 23, 42, 0.8);
        padding: 20px; border-radius: 15px;
        border: 1px solid rgba(255,255,255,0.15);
        text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    #photo-canvas {
        max-width: 100%; height: auto; border-radius: 6px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .action-btn {
        padding: 8px 15px; border-radius: 8px; border: none;
        background: rgba(255,255,255,0.1); color: #fff; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px;
    }
    .action-btn:hover { background: rgba(255,255,255,0.2); }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1100px;">
    <div class="tool-header">
        <div class="tool-squircle grad-teal" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(20, 184, 166, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">badge</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">অ্যাডভান্স ফটো স্টুডিও (Passport Maker)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ছবি থেকে প্রফেশনাল পাসপোর্ট সাইজ বা জব সাইজ ছবি তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 30px; border-radius: 20px; margin-bottom: 30px;">
        <div class="grid-2" style="gap: 30px;">
            <!-- Setup & Controls -->
            <div>
                <div id="step-upload">
                    <h3 style="color: #fff; font-size: 1.2rem; margin-bottom: 15px;">১. ছবি আপলোড করুন</h3>
                    <div class="upload-box" id="box-photo">
                        <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">add_a_photo</i>
                        <p style="margin-top: 10px; color: var(--text-muted);">ক্লিক করে ছবি আপলোড করুন</p>
                        <input type="file" id="input-photo" accept="image/*" onchange="previewPhoto(this)">
                        <img id="thumb-photo" style="max-width: 100%; max-height: 150px; display: none; margin: 10px auto; border-radius: 8px;">
                    </div>
                    <div style="margin-top: 15px;">
                        <label style="color: #cbd5e1; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" id="remove-bg-checkbox" checked style="width: 18px; height: 18px; accent-color: #3b82f6;"> 
                            AI দিয়ে ব্যাকগ্রাউন্ড রিমুভ করুন (Premium)
                        </label>
                    </div>
                    <button id="btn-process" onclick="processPhoto()" class="btn-primary" style="width: 100%; padding: 12px; margin-top: 15px; border-radius: 10px; font-weight: 600;">
                        <i class="material-icons-round" style="vertical-align: middle;">auto_awesome</i> প্রসেস শুরু করুন
                    </button>
                    
                    <div id="loading-indicator" style="display: none; margin-top: 15px; text-align: center; color: #60a5fa;">
                        <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem; margin-bottom: 10px;"></div>
                        <p>অনুগ্রহ করে অপেক্ষা করুন, প্রসেসিং চলছে...</p>
                    </div>
                </div>

                <!-- Editor Controls -->
                <div id="step-editor" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
                        <h3 style="color: #fff; font-size: 1.2rem; margin: 0;">২. কাস্টমাইজেশন</h3>
                        <div style="display: flex; gap: 5px;">
                            <button class="action-btn" onclick="undo()" title="Undo"><i class="material-icons-round">undo</i></button>
                            <button class="action-btn" onclick="redo()" title="Redo"><i class="material-icons-round">redo</i></button>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="color: #e2e8f0; font-size: 0.9rem; margin-bottom: 8px; display: block;">সাইজ (Size Format):</label>
                        <select id="size-selector" class="form-control" onchange="updateSize()" style="background: rgba(15, 23, 42, 0.9); color: #fff; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 8px;">
                            <option value="472x591">পাসপোর্ট সাইজ (40mm x 50mm)</option>
                            <option value="300x300">জব অ্যাপ্লিকেশন (300x300 px)</option>
                            <option value="600x600">বিডি জবস / স্কয়ার (600x600 px)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="color: #e2e8f0; font-size: 0.9rem; margin-bottom: 8px; display: block;">ব্যাকগ্রাউন্ড কালার:</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <span class="color-btn active" style="background: #0054a6;" onclick="setBgColor('#0054a6', this)" title="Studio Blue"></span>
                            <span class="color-btn" style="background: #ffffff;" onclick="setBgColor('#ffffff', this)" title="White"></span>
                            <span class="color-btn" style="background: #0284c7;" onclick="setBgColor('#0284c7', this)" title="Sky Blue"></span>
                            <span class="color-btn" style="background: #1e293b;" onclick="setBgColor('#1e293b', this)" title="Dark"></span>
                            <span class="color-btn" style="background: #e5e7eb;" onclick="setBgColor('#e5e7eb', this)" title="Gray"></span>
                            <input type="color" onchange="setBgColor(this.value)" value="#0054a6" style="width: 35px; height: 35px; border-radius: 50%; padding: 0; cursor: pointer; background: transparent; border: none;">
                        </div>
                    </div>

                    <div class="slider-group">
                        <label><span>জুম (Zoom):</span> <span id="val-zoom">100%</span></label>
                        <input type="range" id="slider-zoom" min="0.5" max="2.0" step="0.02" value="1.0" oninput="drawCanvas(); saveStateDebounced()">
                    </div>
                    <div class="slider-group">
                        <label><span>রোটেশন (Rotation):</span> <span id="val-rot">0°</span></label>
                        <input type="range" id="slider-rot" min="-180" max="180" step="1" value="0" oninput="drawCanvas(); saveStateDebounced()">
                    </div>
                    <div class="slider-group">
                        <label><span>ডানে-বামে (X Offset):</span> <span id="val-x">0 px</span></label>
                        <input type="range" id="slider-x" min="-300" max="300" step="1" value="0" oninput="drawCanvas(); saveStateDebounced()">
                    </div>
                    <div class="slider-group" style="margin-bottom: 5px;">
                        <label><span>ওপর-নিচ (Y Offset):</span> <span id="val-y">0 px</span></label>
                        <input type="range" id="slider-y" min="-300" max="300" step="1" value="0" oninput="drawCanvas(); saveStateDebounced()">
                    </div>
                    <button onclick="resetSliders()" class="btn" style="width: 100%; background: rgba(255,255,255,0.1); color: #cbd5e1; border-radius: 8px; padding: 6px; font-size: 0.85rem; margin-top: 10px;">
                        রিসেট করুন
                    </button>
                </div>
            </div>

            <!-- Canvas Preview -->
            <div>
                <div class="canvas-container">
                    <h3 style="color: #fff; font-size: 1.2rem; margin-bottom: 15px;"><i class="material-icons-round" style="color: #34d399; vertical-align: middle;">verified</i> ফাইনাল প্রিভিউ</h3>
                    <div style="margin-bottom: 20px;">
                        <canvas id="photo-canvas" width="472" height="591"></canvas>
                    </div>
                    
                    <div id="result-actions" style="display: none; flex-direction: column; gap: 10px;">
                        <button onclick="downloadPhoto()" class="btn-primary" style="padding: 12px; border-radius: 10px; background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: bold;">
                            <i class="material-icons-round" style="vertical-align: middle;">download</i> ছবি ডাউনলোড করুন
                        </button>
                        <button onclick="sendToPrint()" class="btn" style="padding: 12px; border-radius: 10px; background: #f59e0b; color: #fff; border: none; font-weight: bold;">
                            <i class="material-icons-round" style="vertical-align: middle;">print</i> A4/4R প্রিন্ট পেজে পাঠান
                        </button>
                        <button onclick="restart()" class="btn" style="padding: 8px; border-radius: 10px; background: rgba(255,255,255,0.1); color: #94a3b8; border: none;">
                            নতুন ছবি নিন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let rawFile = null;
    let baseImg = null;
    let bgColor = '#0054a6';
    
    // State management for Undo/Redo
    let states = [];
    let currentStateIndex = -1;
    let saveTimeout = null;

    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            rawFile = input.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                const thumb = document.getElementById('thumb-photo');
                thumb.src = e.target.result;
                thumb.style.display = 'block';
                document.querySelector('#box-photo i').style.display = 'none';
                document.querySelector('#box-photo p').style.display = 'none';
            };
            reader.readAsDataURL(rawFile);
        }
    }

    async function processPhoto() {
        if (!rawFile) {
            Swal.fire({ title: 'ছবি নির্বাচন করুন!', icon: 'warning', background: '#1e293b', color: '#fff' });
            return;
        }

        document.getElementById('btn-process').style.display = 'none';
        document.getElementById('loading-indicator').style.display = 'block';

        const useAI = document.getElementById('remove-bg-checkbox').checked;

        try {
            if (useAI) {
                const formData = new FormData();
                formData.append('image', rawFile);
                formData.append('tool_name', 'Advanced Passport Maker');
                
                const res = await fetch("{{ route('pdf.tools.bg_remover.process') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: formData
                });
                const data = await res.json();
                if (!data.success) throw new Error(data.message || 'সার্ভার এরর!');
                baseImg = await loadImg(data.image);
            } else {
                baseImg = await loadImg(URL.createObjectURL(rawFile));
            }

            document.getElementById('step-upload').style.display = 'none';
            document.getElementById('step-editor').style.display = 'block';
            document.getElementById('result-actions').style.display = 'flex';
            
            resetSliders(); // initial draw and save state

        } catch (error) {
            Swal.fire({ title: 'ত্রুটি!', text: error.message, icon: 'error', background: '#1e293b', color: '#fff' });
            document.getElementById('btn-process').style.display = 'block';
            document.getElementById('loading-indicator').style.display = 'none';
        }
    }

    function loadImg(src) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.src = src;
        });
    }

    function setBgColor(color, btnEl) {
        bgColor = color;
        if (btnEl) {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            btnEl.classList.add('active');
        }
        drawCanvas();
        saveStateDebounced();
    }

    function updateSize() {
        const sizeStr = document.getElementById('size-selector').value;
        const [w, h] = sizeStr.split('x').map(Number);
        const canvas = document.getElementById('photo-canvas');
        canvas.width = w;
        canvas.height = h;
        
        document.getElementById('slider-zoom').value = 1.0;
        document.getElementById('slider-rot').value = 0;
        document.getElementById('slider-x').value = 0;
        document.getElementById('slider-y').value = 0;
        
        drawCanvas();
        saveStateDebounced();
    }

    function resetSliders() {
        document.getElementById('slider-zoom').value = 1.0;
        document.getElementById('slider-rot').value = 0;
        document.getElementById('slider-x').value = 0;
        document.getElementById('slider-y').value = 0;
        drawCanvas();
        saveStateDebounced();
    }

    function drawCanvas() {
        if (!baseImg) return;
        const canvas = document.getElementById('photo-canvas');
        const ctx = canvas.getContext('2d');
        const cw = canvas.width;
        const ch = canvas.height;

        ctx.fillStyle = bgColor;
        ctx.fillRect(0, 0, cw, ch);

        const zoom = parseFloat(document.getElementById('slider-zoom').value);
        const rot = parseFloat(document.getElementById('slider-rot').value);
        const offsetX = parseFloat(document.getElementById('slider-x').value);
        const offsetY = parseFloat(document.getElementById('slider-y').value);

        document.getElementById('val-zoom').innerText = Math.round(zoom * 100) + '%';
        document.getElementById('val-rot').innerText = rot + '°';
        document.getElementById('val-x').innerText = offsetX + ' px';
        document.getElementById('val-y').innerText = offsetY + ' px';

        // Base auto-fit size
        let targetH = ch * 0.90; // Default fill 90% vertically
        let ratio = baseImg.width / baseImg.height;
        let w = (targetH * ratio) * zoom;
        let h = targetH * zoom;

        let cx = cw / 2 + offsetX;
        let cy = ch / 2 + offsetY + (ch * 0.05); // shift slightly down

        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(rot * Math.PI / 180);
        ctx.drawImage(baseImg, -w/2, -h/2, w, h);
        ctx.restore();
    }

    function saveState() {
        const state = {
            zoom: document.getElementById('slider-zoom').value,
            rot: document.getElementById('slider-rot').value,
            x: document.getElementById('slider-x').value,
            y: document.getElementById('slider-y').value,
            color: bgColor,
            size: document.getElementById('size-selector').value
        };
        
        if (currentStateIndex < states.length - 1) {
            states = states.slice(0, currentStateIndex + 1);
        }
        states.push(state);
        currentStateIndex++;
    }

    function saveStateDebounced() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveState, 400); 
    }

    function applyState(state) {
        document.getElementById('slider-zoom').value = state.zoom;
        document.getElementById('slider-rot').value = state.rot;
        document.getElementById('slider-x').value = state.x;
        document.getElementById('slider-y').value = state.y;
        document.getElementById('size-selector').value = state.size;
        
        setBgColor(state.color, null); 
        
        const [w, h] = state.size.split('x').map(Number);
        const canvas = document.getElementById('photo-canvas');
        canvas.width = w;
        canvas.height = h;
        
        drawCanvas();
    }

    function undo() {
        if (currentStateIndex > 0) {
            currentStateIndex--;
            applyState(states[currentStateIndex]);
        }
    }

    function redo() {
        if (currentStateIndex < states.length - 1) {
            currentStateIndex++;
            applyState(states[currentStateIndex]);
        }
    }

    function downloadPhoto() {
        const canvas = document.getElementById('photo-canvas');
        const link = document.createElement('a');
        link.download = `Passport_Photo_${Date.now()}.jpg`;
        link.href = canvas.toDataURL('image/jpeg', 1.0);
        link.click();
    }

    function sendToPrint() {
        const canvas = document.getElementById('photo-canvas');
        localStorage.setItem('transfer_job_photo', canvas.toDataURL('image/jpeg', 1.0));
        window.location.href = "{{ route('pdf.tools.passport_print') }}";
    }

    function restart() {
        window.location.reload();
    }
</script>
@endsection
