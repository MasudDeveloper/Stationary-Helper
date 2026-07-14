@extends('layouts.app')

@section('title', 'ইমেজ রিসাইজ - Smart Stationary')

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
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">photo_size_select_large</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem;">ইমেজ রিসাইজ</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ছবির ডাইমেনশন (Width/Height) পরিবর্তন করুন</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="upload-box" id="upload-area">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted);">cloud_upload</i>
            <h3 style="margin-top: 15px; color: #fff;">ছবি সিলেক্ট করুন</h3>
            <input type="file" id="image-upload" accept="image/*" onchange="previewImage(this)">
        </div>

        <div class="preview-container" id="preview-container">
            <img id="preview-img" style="max-height: 200px; margin-bottom: 20px; border-radius: 8px;">
            
            <div style="display: flex; gap: 10px; margin-bottom: 20px; justify-content: center;">
                <div>
                    <label class="form-label">Width (px)</label>
                    <input type="number" id="width-input" class="form-control" style="width: 100px;">
                </div>
                <div>
                    <label class="form-label">Height (px)</label>
                    <input type="number" id="height-input" class="form-control" style="width: 100px;">
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary" onclick="resizeImage()">
                        <i class="material-icons-round">crop</i> রিসাইজ
                    </button>
                </div>
            </div>
            
            <a id="download-link" class="btn btn-outline" style="display: none; width: 100%;">
                <i class="material-icons-round">download</i> ডাউনলোড
            </a>
        </div>
    </div>
</div>

<script>
    let currentImage = null;
    let fileExt = 'png';

    function previewImage(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        fileExt = file.name.split('.').pop();
        const url = URL.createObjectURL(file);
        
        currentImage = new Image();
        currentImage.src = url;
        currentImage.onload = () => {
            document.getElementById('preview-img').src = url;
            document.getElementById('width-input').value = currentImage.width;
            document.getElementById('height-input').value = currentImage.height;
            document.getElementById('upload-area').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';
        };
    }

    function resizeImage() {
        if (!currentImage) return;
        
        const width = parseInt(document.getElementById('width-input').value);
        const height = parseInt(document.getElementById('height-input').value);
        
        const canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(currentImage, 0, 0, width, height);
        
        const dataUrl = canvas.toDataURL(`image/${fileExt === 'jpg' ? 'jpeg' : fileExt}`);
        
        document.getElementById('preview-img').src = dataUrl;
        
        const link = document.getElementById('download-link');
        link.href = dataUrl;
        link.download = `resized_image.${fileExt}`;
        link.style.display = 'block';
    }
</script>
@endsection
