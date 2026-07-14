@extends('layouts.app')

@section('title', 'ইমেজ কম্প্রেস - Smart Stationary')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    #preview-container { text-align: center; margin-top: 20px; display: none; }
    #preview-image { max-width: 100%; max-height: 400px; border-radius: 8px; border: 1px solid var(--border-color); }
    .size-info { margin-top: 10px; font-weight: bold; color: var(--text-muted); }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">compress</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">ইমেজ কম্প্রেস (Image Compress)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">ছবির সাইজ (MB/KB) কমিয়ে আনুন কোনো ধরনের সফটওয়্যার ছাড়াই।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label">ছবি নির্বাচন করুন (JPG, PNG)</label>
            <input type="file" id="image-upload" class="form-control" accept="image/*" onchange="loadImage()">
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">কম্প্রেশন কোয়ালিটি: <span id="quality-val">80%</span></label>
            <input type="range" id="quality-slider" min="10" max="100" value="80" style="width: 100%;" oninput="updateQualityLabel()">
            <small style="color: var(--text-muted);">কোয়ালিটি কমালে ছবির সাইজ কমবে, তবে ছবির মান কিছুটা কমে যেতে পারে।</small>
        </div>

        <div id="preview-container">
            <img id="preview-image" src="" alt="Preview">
            <div class="grid-2" style="margin-top: 15px;">
                <div class="size-info" style="color: #ef4444;">আগের সাইজ: <span id="original-size">-</span></div>
                <div class="size-info" style="color: #10b981;">নতুন সাইজ (আনুমানিক): <span id="compressed-size">-</span></div>
            </div>
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="compressImage()" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 30px; display: none;">
            <i class="material-icons-round">download</i> কম্প্রেস করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    let originalImageObj = new Image();
    let originalFile = null;

    function updateQualityLabel() {
        document.getElementById('quality-val').innerText = document.getElementById('quality-slider').value + '%';
        if (originalFile) {
            estimateNewSize();
        }
    }

    function loadImage() {
        const fileInput = document.getElementById('image-upload');
        originalFile = fileInput.files[0];

        if (!originalFile) return;

        // Display original size
        document.getElementById('original-size').innerText = formatBytes(originalFile.size);

        const reader = new FileReader();
        reader.onload = function(e) {
            originalImageObj.src = e.target.result;
            originalImageObj.onload = function() {
                document.getElementById('preview-image').src = originalImageObj.src;
                document.getElementById('preview-container').style.display = 'block';
                document.getElementById('process-btn').style.display = 'block';
                estimateNewSize();
            }
        }
        reader.readAsDataURL(originalFile);
    }

    function estimateNewSize() {
        const quality = parseInt(document.getElementById('quality-slider').value) / 100;
        const canvas = document.createElement('canvas');
        canvas.width = originalImageObj.width;
        canvas.height = originalImageObj.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(originalImageObj, 0, 0);

        const dataUrl = canvas.toDataURL('image/jpeg', quality);
        
        // Calculate base64 size roughly
        const base64Length = dataUrl.length - 'data:image/jpeg;base64,'.length;
        const sizeInBytes = Math.ceil(base64Length * 0.75);

        document.getElementById('compressed-size').innerText = formatBytes(sizeInBytes);
    }

    function compressImage() {
        if (!originalFile) return;

        const quality = parseInt(document.getElementById('quality-slider').value) / 100;
        const canvas = document.createElement('canvas');
        canvas.width = originalImageObj.width;
        canvas.height = originalImageObj.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(originalImageObj, 0, 0);

        const dataUrl = canvas.toDataURL('image/jpeg', quality);

        // Download
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = 'Compressed_' + originalFile.name;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
    }
</script>
@endsection
