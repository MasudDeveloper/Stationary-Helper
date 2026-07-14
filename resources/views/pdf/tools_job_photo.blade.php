@extends('layouts.app')

@section('title', 'জব ফটো ও সিগনেচার রিসাইজ - Smart Stationary')

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
    .result-img {
        max-width: 100%;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: none;
        margin-top: 15px;
    }
    .info-text {
        color: #10b981;
        font-weight: bold;
        margin-top: 10px;
        display: none;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 900px;">
    <div class="tool-header">
        <div class="tool-squircle grad-teal" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(20, 184, 166, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">badge</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">জব ফটো ও সিগনেচার রিসাইজ (Job Application)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো চাকরির আবেদনের জন্য ছবি (300x300, 100KB) এবং সিগনেচার (300x80, 60KB) এক ক্লিকেই তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        
        <div class="grid-2" style="margin-bottom: 30px;">
            <!-- Photo Section -->
            <div style="text-align: center;">
                <h4 style="color: #fff; margin-bottom: 15px;">ছবি (Photo - 300x300)</h4>
                <div class="upload-box" id="box-photo">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">account_box</i>
                    <p style="margin-top: 10px; color: var(--text-muted);">ক্লিক করে ছবি আপলোড করুন</p>
                    <input type="file" accept="image/*" onchange="processImage(this, 'photo')">
                </div>
                <img id="result-photo" class="result-img" src="" alt="Photo Result">
                <p id="info-photo" class="info-text"></p>
                <button id="btn-photo" class="btn btn-primary" onclick="downloadFile('photo')" style="width: 100%; margin-top: 15px; display: none;">ডাউনলোড ছবি</button>
            </div>

            <!-- Signature Section -->
            <div style="text-align: center;">
                <h4 style="color: #fff; margin-bottom: 15px;">স্বাক্ষর (Signature - 300x80)</h4>
                <div class="upload-box" id="box-sig">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">draw</i>
                    <p style="margin-top: 10px; color: var(--text-muted);">ক্লিক করে স্বাক্ষর আপলোড করুন</p>
                    <input type="file" accept="image/*" onchange="processImage(this, 'sig')">
                </div>
                <img id="result-sig" class="result-img" src="" alt="Signature Result">
                <p id="info-sig" class="info-text"></p>
                <button id="btn-sig" class="btn btn-primary" onclick="downloadFile('sig')" style="width: 100%; margin-top: 15px; display: none;">ডাউনলোড স্বাক্ষর</button>
            </div>
        </div>

    </div>
</div>

<script>
    let finalDataUrls = { photo: null, sig: null };
    let filenames = { photo: 'Photo_300x300.jpg', sig: 'Signature_300x80.jpg' };

    function processImage(input, type) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        const targetW = type === 'photo' ? 300 : 300;
        const targetH = type === 'photo' ? 300 : 80;
        const maxKb = type === 'photo' ? 100 : 60;
        const maxBytes = maxKb * 1024;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = targetW;
                canvas.height = targetH;
                const ctx = canvas.getContext('2d');
                
                // Draw white background in case of transparent png
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, targetW, targetH);

                // Simple stretch to fit (standard for bangladesh job portals if ratio is slightly off, 
                // but better to cover/crop. Let's do a stretch for now as it ensures exact dimension without cropping parts)
                ctx.drawImage(img, 0, 0, targetW, targetH);

                // Compress until it fits maxKb
                let quality = 1.0;
                let dataUrl = canvas.toDataURL('image/jpeg', quality);
                let sizeBytes = Math.ceil((dataUrl.length - 22) * 0.75);

                while (sizeBytes > maxBytes && quality > 0.1) {
                    quality -= 0.05;
                    dataUrl = canvas.toDataURL('image/jpeg', quality);
                    sizeBytes = Math.ceil((dataUrl.length - 22) * 0.75);
                }

                // Show result
                const resImg = document.getElementById('result-' + type);
                resImg.src = dataUrl;
                resImg.style.display = 'inline-block';
                
                const infoTxt = document.getElementById('info-' + type);
                infoTxt.innerText = `Size: ${Math.round(sizeBytes/1024)} KB (${targetW}x${targetH})`;
                infoTxt.style.display = 'block';

                document.getElementById('btn-' + type).style.display = 'block';
                document.getElementById('box-' + type).style.display = 'none';

                finalDataUrls[type] = dataUrl;
            }
        }
        reader.readAsDataURL(file);
    }

    function downloadFile(type) {
        if (!finalDataUrls[type]) return;
        const link = document.createElement('a');
        link.href = finalDataUrls[type];
        link.download = filenames[type];
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
