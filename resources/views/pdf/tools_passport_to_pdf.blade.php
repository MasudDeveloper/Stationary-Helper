@extends('layouts.app')

@section('title', 'পাসপোর্ট টু পিডিএফ - Smart Stationary')

@section('content')
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

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
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">contact_page</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem;">পাসপোর্ট টু পিডিএফ</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ছবি আপলোড করে A4 সাইজের পিডিএফে পাসপোর্ট সাইজ ছবি প্রিন্ট করুন</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="upload-box" id="upload-area">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted);">cloud_upload</i>
            <h3 style="margin-top: 15px; color: #fff;">এখানে ক্লিক করে ছবি সিলেক্ট করুন</h3>
            <input type="file" id="image-upload" accept="image/*" onchange="processImage(this)">
        </div>

        <div class="preview-container" id="preview-container">
            <h4 style="color: #fff; margin-bottom: 15px;">PDF তৈরি হয়েছে:</h4>
            <button class="btn btn-primary" onclick="downloadPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                <i class="material-icons-round">download</i> পিডিএফ ডাউনলোড করুন
            </button>
            <button class="btn btn-outline" onclick="location.reload()" style="width: 100%; padding: 15px; margin-top: 15px;">
                আরেকটি ছবি আপলোড করুন
            </button>
        </div>
    </div>
</div>

<script>
    let pdfBytes = null;

    async function processImage(input) {
        if (!input.files || !input.files[0]) return;
        
        document.getElementById('upload-area').innerHTML = '<h3 style="color:#fff;">Processing...</h3>';

        const file = input.files[0];
        const arrayBuffer = await file.arrayBuffer();

        const pdfDoc = await PDFLib.PDFDocument.create();
        const page = pdfDoc.addPage([595.28, 841.89]); // A4 Size

        let image;
        if (file.type === 'image/jpeg') image = await pdfDoc.embedJpg(arrayBuffer);
        else if (file.type === 'image/png') image = await pdfDoc.embedPng(arrayBuffer);
        else return Swal.fire('Only JPG/PNG allowed');

        // Passport size is typically 40x50 mm -> ~113x141 points
        // Draw 4 copies on top
        for (let i = 0; i < 4; i++) {
            page.drawImage(image, {
                x: 50 + (i * 120),
                y: 841.89 - 150 - 50,
                width: 113,
                height: 141,
            });
        }

        pdfBytes = await pdfDoc.save();
        
        document.getElementById('upload-area').style.display = 'none';
        document.getElementById('preview-container').style.display = 'block';
    }

    function downloadPdf() {
        if (!pdfBytes) return;
        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'passport_photos.pdf';
        link.click();
    }
</script>
@endsection
