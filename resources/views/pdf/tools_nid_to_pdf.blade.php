@extends('layouts.app')

@section('title', 'এনআইডি টু পিডিএফ - Smart Stationary')

@section('content')
<!-- PDF-lib -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

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
    .preview-img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 15px;
        display: none;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 900px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">badge</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">এনআইডি টু পিডিএফ (NID to PDF)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">আপনার এনআইডি (NID) কার্ডের দুই পাশের ছবি দিয়ে খুব সহজেই প্রিন্ট করার উপযোগী একটি A4 সাইজের পিডিএফ তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        
        <div class="grid-2" style="margin-bottom: 30px;">
            <div>
                <label class="form-label text-center" style="display: block; margin-bottom: 10px;">সামনের অংশ (Front Side)</label>
                <div class="upload-box" id="box-front">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">add_photo_alternate</i>
                    <p style="margin-top: 10px; color: var(--text-muted);">ক্লিক করে ছবি আপলোড করুন</p>
                    <input type="file" id="nid-front" accept="image/*" onchange="previewImage(this, 'preview-front')">
                    <img id="preview-front" class="preview-img" src="" alt="Front Preview">
                </div>
            </div>

            <div>
                <label class="form-label text-center" style="display: block; margin-bottom: 10px;">পেছনের অংশ (Back Side)</label>
                <div class="upload-box" id="box-back">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted);">add_photo_alternate</i>
                    <p style="margin-top: 10px; color: var(--text-muted);">ক্লিক করে ছবি আপলোড করুন</p>
                    <input type="file" id="nid-back" accept="image/*" onchange="previewImage(this, 'preview-back')">
                    <img id="preview-back" class="preview-img" src="" alt="Back Preview">
                </div>
            </div>
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; text-align: center; font-weight: bold;">
            পিডিএফ তৈরি হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="generateNidPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">picture_as_pdf</i> পিডিএফ তৈরি করে ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'inline-block';
                input.parentElement.querySelector('i').style.display = 'none';
                input.parentElement.querySelector('p').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function generateNidPdf() {
        const frontFile = document.getElementById('nid-front').files[0];
        const backFile = document.getElementById('nid-back').files[0];

        if (!frontFile || !backFile) {
            Swal.fire('অনুগ্রহ করে এনআইডির দুই পাশের ছবিই আপলোড করুন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const pdfDoc = await PDFLib.PDFDocument.create();
            // A4 Size in points
            const page = pdfDoc.addPage([595.28, 841.89]);
            const { width, height } = page.getSize();

            // Function to convert and embed image
            async function embedImage(file) {
                const arrayBuffer = await file.arrayBuffer();
                let image;
                if (file.type === 'image/png') {
                    image = await pdfDoc.embedPng(arrayBuffer);
                } else {
                    image = await pdfDoc.embedJpg(arrayBuffer);
                }
                return image;
            }

            const frontImg = await embedImage(frontFile);
            const backImg = await embedImage(backFile);

            // NID Standard size approx: 3.375 x 2.125 inches
            // We scale it up slightly for A4 (e.g., 340 x 215 points)
            const cardWidth = 340;
            const cardHeight = 215;

            // Center X
            const x = (width - cardWidth) / 2;

            // Place Front at Top, Back at Middle
            const frontY = height - 100 - cardHeight;
            const backY = frontY - 30 - cardHeight;

            page.drawImage(frontImg, {
                x: x,
                y: frontY,
                width: cardWidth,
                height: cardHeight,
            });

            page.drawImage(backImg, {
                x: x,
                y: backY,
                width: cardWidth,
                height: cardHeight,
            });

            const pdfBytes = await pdfDoc.save();

            // Download
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'NID_Card.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পিডিএফ তৈরি করা হয়েছে!');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ তৈরি করতে সমস্যা হয়েছে! দয়া করে শুধু JPG বা PNG ছবি আপলোড করুন।');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
