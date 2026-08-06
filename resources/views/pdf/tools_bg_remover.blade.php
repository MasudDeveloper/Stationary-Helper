@extends('layouts.app')

@section('title', 'ব্যাকগ্রাউন্ড রিমুভার - penghor.com')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .upload-box {
        border: 2px dashed var(--border-color);
        padding: 40px;
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
        display: none;
        text-align: center;
        margin-top: 30px;
    }
    .preview-img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"><rect width="10" height="10" fill="%23ddd"/><rect x="10" width="10" height="10" fill="%23fff"/><rect y="10" width="10" height="10" fill="%23fff"/><rect x="10" y="10" width="10" height="10" fill="%23ddd"/></svg>');
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">imagesearch_roller</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">ইমেজ ব্যাকগ্রাউন্ড রিমুভার (Background Remover)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ছবির ব্যাকগ্রাউন্ড এক ক্লিকেই মুছে ফেলুন (Transparent PNG)। এটি পুরোপুরি আপনার ব্রাউজারেই কাজ করে!</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="upload-box" id="upload-area">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted);">cloud_upload</i>
            <h3 style="margin-top: 15px; color: #fff;">এখানে ক্লিক করে ছবি সিলেক্ট করুন</h3>
            <p style="color: var(--text-muted); margin-top: 5px;">(JPG বা PNG ফাইল)</p>
            <input type="file" id="image-upload" accept="image/*" onchange="removeBackground(this)">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 30px 0; text-align: center;">
            <i class="material-icons-round" style="font-size: 3rem; animation: spin 2s linear infinite;">autorenew</i>
            <h3 style="margin-top: 10px;">ব্যাকগ্রাউন্ড রিমুভ করা হচ্ছে...</h3>
            
            <!-- Progress Bar -->
            <div style="width: 100%; max-width: 400px; margin: 20px auto; background: rgba(255,255,255,0.1); border-radius: 10px; height: 10px; overflow: hidden;">
                <div id="progress-bar" style="height: 100%; width: 0%; background: var(--primary-color); transition: width 0.3s ease;"></div>
            </div>
            
            <p style="color: var(--text-muted);"><small>মডেল লোড ও প্রসেস হতে কিছুটা সময় লাগতে পারে। দয়া করে অপেক্ষা করুন।</small></p>
        </div>

        <div class="preview-container" id="preview-container">
            <h4 style="color: #fff; margin-bottom: 15px;">ফলাফল (Transparent Image):</h4>
            <img id="result-img" class="preview-img" src="" alt="Result">
            
            <button class="btn btn-primary" onclick="downloadImage()" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 30px;">
                <i class="material-icons-round">download</i> ডাউনলোড করুন (PNG)
            </button>

            <!-- Link to Passport Auto Arrange -->
            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px; border: 1px solid var(--border-color); margin-top: 15px;">
                <p style="color: #fff; margin-bottom: 10px; font-size: 0.9rem;">ছবিটি পাসপোর্ট সাইজে প্রিন্ট করতে চান?</p>
                <button onclick="arrangePassportPhoto()" class="btn" style="width: 100%; background: #f59e0b; color: #fff; border: none;">
                    <i class="material-icons-round" style="vertical-align: middle; font-size: 18px; margin-right: 5px;">auto_awesome_mosaic</i> অটো-অ্যারেঞ্জ (4R / A4)
                </button>
            </div>

            <button class="btn btn-outline" onclick="resetTool()" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 15px;">
                আরেকটি ছবি আপলোড করুন
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<!-- imgly background removal will be loaded dynamically -->

<script>
    let currentBlob = null;
    let originalFilename = 'image.png';

    async function removeBackground(input) {
        if (!input.files || !input.files[0]) return;
        
        const file = input.files[0];
        const cost = {{ $cost ?? 0 }};

        if (cost > 0) {
            Swal.fire({
                title: 'নিশ্চিত করুন',
                text: `এই ছবির ব্যাকগ্রাউন্ড রিমুভ করতে আপনার একাউন্ট থেকে ${cost} ক্রেডিট কাটা হবে (সফল হলে)। আপনি কি রাজি?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, রিমুভ করুন',
                cancelButtonText: 'না, বাতিল করুন'
            }).then((result) => {
                if (result.isConfirmed) {
                    processImage(file);
                } else {
                    input.value = ''; // Reset file input
                }
            });
        } else {
            processImage(file);
        }
    }

    async function processImage(file) {
        document.getElementById('upload-area').style.display = 'none';
        document.getElementById('loading').style.display = 'block';
        document.getElementById('preview-container').style.display = 'none';
        
        // Simulate progress bar since server-side processing doesn't provide easy live progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += 5;
            if (progress > 90) progress = 90;
            document.getElementById('progress-bar').style.width = progress + '%';
        }, 500);

        originalFilename = file.name.split('.')[0] + '_transparent.png';
        const formData = new FormData();
        formData.append('image', file);

        try {
            const res = await fetch("{{ route('pdf.tools.bg_remover.process') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await res.json();
            
            clearInterval(progressInterval);
            document.getElementById('progress-bar').style.width = '100%';
            
            if (!data.success) {
                document.getElementById('upload-area').style.display = 'block';
                document.getElementById('loading').style.display = 'none';
                Swal.fire('ত্রুটি!', data.message || 'সার্ভার এরর!', 'error');
                resetTool();
                return;
            }

            // Update balance
            const balanceEl = document.getElementById('credit-balance');
            if (balanceEl) balanceEl.innerText = data.new_balance;

            // Display image
            document.getElementById('result-img').src = data.image;
            document.getElementById('loading').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';

            // Convert base64 data to blob for download/passport function
            const response = await fetch(data.image);
            currentBlob = await response.blob();

        } catch(err) {
            clearInterval(progressInterval);
            document.getElementById('upload-area').style.display = 'block';
            document.getElementById('loading').style.display = 'none';
            Swal.fire('সার্ভার এরর!', 'অনুগ্রহ করে আবার চেষ্টা করুন।', 'error');
            console.error(err);
            resetTool();
        }
    }

    // AI artifacts often leave a white fringe. We darken semi-transparent pixels to act like a burn tool.
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
                    // Semi-transparent pixels (usually edges/hair fringes)
                    if (alpha > 0 && alpha < 250) {
                        // Darken them (burn effect) to remove white halo
                        data[i] = Math.max(0, data[i] - 60);     // R
                        data[i+1] = Math.max(0, data[i+1] - 60); // G
                        data[i+2] = Math.max(0, data[i+2] - 60); // B
                        // Slightly reduce alpha to feather it
                        data[i+3] = Math.max(0, alpha - 20);
                    }
                }
                ctx.putImageData(imgData, 0, 0);
                canvas.toBlob(resolve, 'image/png');
            };
            img.src = URL.createObjectURL(blob);
        });
    }

    function downloadImage() {
        if (!currentBlob) return;
        const link = document.createElement('a');
        link.href = URL.createObjectURL(currentBlob);
        link.download = originalFilename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    function arrangePassportPhoto() {
        if (!currentBlob) return;
        // Convert to data URL for transfer
        const reader = new FileReader();
        reader.onload = function(e) {
            localStorage.setItem('transfer_job_photo', e.target.result);
            window.location.href = "{{ route('pdf.tools.passport_print') }}";
        };
        reader.readAsDataURL(currentBlob);
    }

    function resetTool() {
        document.getElementById('upload-area').style.display = 'block';
        document.getElementById('loading').style.display = 'none';
        document.getElementById('preview-container').style.display = 'none';
        document.getElementById('image-upload').value = '';
        currentBlob = null;
    }
</script>
@endsection
