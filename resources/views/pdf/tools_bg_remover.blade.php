@extends('layouts.app')

@section('title', 'ব্যাকগ্রাউন্ড রিমুভার - Smart Stationary')

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
            <p style="color: var(--text-muted);"><small>প্রথমবার ব্যবহারে মডেল লোড হতে কিছুটা সময় লাগতে পারে।</small></p>
        </div>

        <div class="preview-container" id="preview-container">
            <h4 style="color: #fff; margin-bottom: 15px;">ফলাফল (Transparent Image):</h4>
            <img id="result-img" class="preview-img" src="" alt="Result">
            
            <button class="btn btn-primary" onclick="downloadImage()" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 30px;">
                <i class="material-icons-round">download</i> ডাউনলোড করুন (PNG)
            </button>
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
        originalFilename = file.name.split('.')[0] + '_transparent.png';

        document.getElementById('upload-area').style.display = 'none';
        document.getElementById('loading').style.display = 'block';
        document.getElementById('preview-container').style.display = 'none';

        try {
            // Dynamically import the library using esm.sh (reliable for browser imports)
            const module = await import('https://esm.sh/@imgly/background-removal@1.4.5');
            const removeBg = module.default || module.removeBackground;

            if (!removeBg) {
                throw new Error("লাইব্রেরি লোড হতে ব্যর্থ হয়েছে।");
            }

            const config = {
                publicPath: 'https://staticimgly.com/@imgly/background-removal-data/1.4.5/dist/'
            };

            // Create object URL for the image
            const imageUrl = URL.createObjectURL(file);

            // Process image
            currentBlob = await removeBg(imageUrl, config);
            
            // Create Result URL
            const resultUrl = URL.createObjectURL(currentBlob);
            
            document.getElementById('result-img').src = resultUrl;
            document.getElementById('loading').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';

        } catch (error) {
            console.error(error);
            Swal.fire('ব্যাকগ্রাউন্ড রিমুভ করতে সমস্যা হয়েছে: ' + error.message);
            resetTool();
        }
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

    function resetTool() {
        document.getElementById('upload-area').style.display = 'block';
        document.getElementById('loading').style.display = 'none';
        document.getElementById('preview-container').style.display = 'none';
        document.getElementById('image-upload').value = '';
        currentBlob = null;
    }
</script>
@endsection
