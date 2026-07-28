@extends('layouts.app')

@section('title', 'পাসপোর্ট টু পিডিএফ - penghor.com')

@section('content')
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .upload-box {
        border: 2px dashed var(--border-color); padding: 40px; text-align: center;
        border-radius: 12px; background: rgba(255,255,255,0.05); cursor: pointer; position: relative;
        transition: all 0.2s;
    }
    .upload-box:hover {
        border-color: var(--primary-color); background: rgba(255,255,255,0.08);
    }
    .upload-box input {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;
    }
    .preview-container { display: none; text-align: center; margin-top: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">contact_page</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পাসপোর্ট টু পিডিএফ (Passport Scan to PDF)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">আপনার পাসপোর্টের স্ক্যান করা ছবি (বা যেকোনো ডকুমেন্টের ছবি) আপলোড করলে তা একটি A4 সাইজ পেইজের ঠিক মাঝখানে সুন্দরভাবে সেট হয়ে PDF তৈরি হয়ে যাবে।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="upload-box" id="upload-area">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted);">cloud_upload</i>
            <h3 style="margin-top: 15px; color: #fff;">এখানে ক্লিক করে পাসপোর্টের স্ক্যান ছবি সিলেক্ট করুন</h3>
            <p style="color: var(--text-muted); margin-top: 5px;">(JPG বা PNG ফরম্যাট)</p>
            <input type="file" id="image-upload" accept="image/*" onchange="processImage(this)">
        </div>

        <div id="processing-loader" style="display: none; text-align: center; padding: 30px 0;">
            <i class="material-icons-round" style="font-size: 3rem; color: var(--primary-color); animation: spin 1s linear infinite;">autorenew</i>
            <h4 style="color: #fff; margin-top: 15px;">PDF তৈরি করা হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন...</h4>
        </div>

        <div class="preview-container" id="preview-container">
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                <i class="material-icons-round" style="font-size: 3rem; color: #10b981;">check_circle</i>
                <h4 style="color: #fff; margin-top: 10px;">সাফল্যের সাথে A4 পেইজের মাঝখানে সেট করে PDF তৈরি হয়েছে!</h4>
            </div>
            <button class="btn btn-primary" onclick="downloadPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem; background: linear-gradient(135deg, #10b981, #059669); border: none; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">download</i> পিডিএফ ডাউনলোড করুন (A4 PDF)
            </button>
            <button class="btn btn-outline" onclick="location.reload()" style="width: 100%; padding: 15px; margin-top: 15px;">
                আরেকটি ছবি আপলোড করুন
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<script>
    let pdfBytes = null;
    let originalFilename = 'passport_scan.pdf';

    async function processImage(input) {
        if (!input.files || !input.files[0]) return;
        
        document.getElementById('upload-area').style.display = 'none';
        document.getElementById('processing-loader').style.display = 'block';

        const file = input.files[0];
        if (file.name) {
            originalFilename = file.name.split('.')[0] + '_A4.pdf';
        }
        const arrayBuffer = await file.arrayBuffer();

        try {
            const pdfDoc = await PDFLib.PDFDocument.create();
            const pageWidth = 595.28;  // A4 Width
            const pageHeight = 841.89; // A4 Height
            const page = pdfDoc.addPage([pageWidth, pageHeight]);

            let image;
            if (file.type === 'image/jpeg' || file.name.toLowerCase().endsWith('.jpg') || file.name.toLowerCase().endsWith('.jpeg')) {
                image = await pdfDoc.embedJpg(arrayBuffer);
            } else if (file.type === 'image/png' || file.name.toLowerCase().endsWith('.png')) {
                image = await pdfDoc.embedPng(arrayBuffer);
            } else {
                Swal.fire('দুঃখিত', 'শুধুমাত্র JPG বা PNG ছবি আপলোড করা যাবে।', 'error');
                location.reload();
                return;
            }

            const imgWidth = image.width;
            const imgHeight = image.height;

            // Maximum bounds on A4 with margins (40 points margin on each side)
            const maxDrawWidth = pageWidth - 80;
            const maxDrawHeight = pageHeight - 80;

            // Calculate scaling ratio to fit within max bounds without distortion
            const ratio = Math.min(maxDrawWidth / imgWidth, maxDrawHeight / imgHeight, 1); // 1 means do not upscale if smaller than max
            const drawWidth = imgWidth * ratio;
            const drawHeight = imgHeight * ratio;

            // Calculate coordinates to center the image on the A4 page
            const x = (pageWidth - drawWidth) / 2;
            const y = (pageHeight - drawHeight) / 2;

            // Draw single centered image
            page.drawImage(image, {
                x: x,
                y: y,
                width: drawWidth,
                height: drawHeight,
            });

            pdfBytes = await pdfDoc.save();
            
            document.getElementById('processing-loader').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';
        } catch (error) {
            console.error(error);
            Swal.fire('ত্রুটি', 'PDF তৈরি করতে সমস্যা হয়েছে: ' + error.message, 'error');
            location.reload();
        }
    }

    function downloadPdf() {
        if (!pdfBytes) return;
        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = originalFilename;
        link.click();
    }
</script>
@endsection
