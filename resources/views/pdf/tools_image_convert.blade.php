@extends('layouts.app')

@section('title', 'ইমেজ কনভার্ট - Smart Stationary')

@section('content')
<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .upload-box {
        border: 2px dashed var(--border-color); padding: 40px; text-align: center;
        border-radius: 12px; background: rgba(255,255,255,0.05); cursor: pointer; position: relative;
    }
    .upload-box input {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;
    }
    .preview-container { display: none; text-align: center; margin-top: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">transform</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem;">ইমেজ কনভার্ট</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ছবিকে JPG, PNG বা WEBP তে কনভার্ট করুন</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="upload-box" id="upload-area">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted);">cloud_upload</i>
            <h3 style="margin-top: 15px; color: #fff;">ছবি সিলেক্ট করুন</h3>
            <input type="file" id="image-upload" accept="image/*" onchange="previewImage(this)">
        </div>

        <div class="preview-container" id="preview-container">
            <img id="preview-img" style="max-height: 200px; margin-bottom: 20px; border-radius: 8px;">
            
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <select id="format-select" class="form-control">
                    <option value="image/jpeg">JPG</option>
                    <option value="image/png">PNG</option>
                    <option value="image/webp">WEBP</option>
                </select>
                <button class="btn btn-primary" onclick="convertImage()" style="flex: 1;">
                    <i class="material-icons-round">sync</i> কনভার্ট করুন
                </button>
            </div>
            
            <a id="download-link" class="btn btn-outline" style="display: none; width: 100%;">
                <i class="material-icons-round">download</i> ডাউনলোড
            </a>
        </div>
    </div>
</div>

<script>
    let currentImage = null;

    function previewImage(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const url = URL.createObjectURL(file);
        
        currentImage = new Image();
        currentImage.src = url;
        currentImage.onload = () => {
            document.getElementById('preview-img').src = url;
            document.getElementById('upload-area').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';
        };
    }

    function convertImage() {
        if (!currentImage) return;
        
        const format = document.getElementById('format-select').value;
        const ext = format.split('/')[1];
        
        const canvas = document.createElement('canvas');
        canvas.width = currentImage.width;
        canvas.height = currentImage.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(currentImage, 0, 0);
        
        const dataUrl = canvas.toDataURL(format, 0.9);
        
        const link = document.getElementById('download-link');
        link.href = dataUrl;
        link.download = `converted_image.${ext}`;
        link.style.display = 'block';
    }
</script>
@endsection
