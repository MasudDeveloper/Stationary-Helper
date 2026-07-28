@extends('layouts.app')

@section('title', 'পিডিএফ রিসাইজ - penghor.com')

@section('content')
<!-- PDF-lib -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-pink" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">aspect_ratio</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ রিসাইজ (PDF Resize)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">আপনার পিডিএফ ফাইলের পেজ সাইজ পরিবর্তন করুন (যেমন A4, Letter, Legal)।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group">
            <label class="form-label">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf">
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">নতুন পেজ সাইজ (Page Size)</label>
            <select id="page-size" class="form-control">
                <option value="A4">A4 (Standard)</option>
                <option value="Letter">Letter</option>
                <option value="Legal">Legal</option>
                <option value="A5">A5</option>
            </select>
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; text-align: center; font-weight: bold;">
            রিসাইজ হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="resizePdf()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">photo_size_select_actual</i> পিডিএফ রিসাইজ করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    const PAGE_SIZES = {
        'A4': [595.28, 841.89],
        'Letter': [612.00, 792.00],
        'Legal': [612.00, 1008.00],
        'A5': [420.94, 595.28]
    };

    async function resizePdf() {
        const fileInput = document.getElementById('pdf-upload');
        const sizeKey = document.getElementById('page-size').value;
        const file = fileInput.files[0];

        if (!file) {
            Swal.fire('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const originalPdf = await PDFLib.PDFDocument.load(arrayBuffer);
            const newPdf = await PDFLib.PDFDocument.create();

            const targetSize = PAGE_SIZES[sizeKey];
            const originalPages = originalPdf.getPages();

            for (let i = 0; i < originalPages.length; i++) {
                const originalPage = originalPages[i];
                // Embed the page
                const [embeddedPage] = await newPdf.embedPdf(originalPdf, [i]);
                
                // Add a new blank page with the target size
                const newPage = newPdf.addPage(targetSize);
                
                // Get dimensions to scale properly
                const { width: origW, height: origH } = originalPage.getSize();
                const scale = Math.min(targetSize[0] / origW, targetSize[1] / origH);
                
                const scaledW = origW * scale;
                const scaledH = origH * scale;

                // Center the page
                const x = (targetSize[0] - scaledW) / 2;
                const y = (targetSize[1] - scaledH) / 2;

                newPage.drawPage(embeddedPage, {
                    x: x,
                    y: y,
                    width: scaledW,
                    height: scaledH
                });
            }

            const newPdfBytes = await newPdf.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `Resized_${sizeKey}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পিডিএফ রিসাইজ করা হয়েছে!');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ রিসাইজ করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
