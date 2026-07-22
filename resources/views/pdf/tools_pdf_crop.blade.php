@extends('layouts.app')

@section('title', 'পিডিএফ ক্রপ - Smart Stationary')

@section('content')
<!-- PDF-lib -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .margin-input {
        text-align: center;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-pink" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">crop</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ ক্রপ (PDF Crop)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">পিডিএফের চারপাশ থেকে অতিরিক্ত সাদা অংশ কেটে ফেলুন (মার্জিন দিন)।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf">
        </div>

        <h4 style="color: #fff; margin-bottom: 20px; text-align: center;">কতটুকু কাটতে চান? (Millimeter / mm)</h4>
        
        <div class="grid-2" style="margin-bottom: 20px;">
            <div class="margin-input">
                <label class="form-label">টপ মার্জিন (Top)</label>
                <input type="number" id="crop-top" class="form-control" value="0" min="0">
            </div>
            <div class="margin-input">
                <label class="form-label">বটম মার্জিন (Bottom)</label>
                <input type="number" id="crop-bottom" class="form-control" value="0" min="0">
            </div>
        </div>

        <div class="grid-2" style="margin-bottom: 30px;">
            <div class="margin-input">
                <label class="form-label">লেফট মার্জিন (Left)</label>
                <input type="number" id="crop-left" class="form-control" value="0" min="0">
            </div>
            <div class="margin-input">
                <label class="form-label">রাইট মার্জিন (Right)</label>
                <input type="number" id="crop-right" class="form-control" value="0" min="0">
            </div>
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; text-align: center; font-weight: bold;">
            ক্রপ হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="cropPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">content_cut</i> পিডিএফ ক্রপ করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    const MM_TO_PT = 2.83465;

    async function cropPdf() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];

        if (!file) {
            Swal.fire('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        const top = parseFloat(document.getElementById('crop-top').value) * MM_TO_PT;
        const bottom = parseFloat(document.getElementById('crop-bottom').value) * MM_TO_PT;
        const left = parseFloat(document.getElementById('crop-left').value) * MM_TO_PT;
        const right = parseFloat(document.getElementById('crop-right').value) * MM_TO_PT;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
            const pages = pdfDoc.getPages();

            pages.forEach((page) => {
                const { x, y, width, height } = page.getCropBox();

                const newX = x + left;
                const newY = y + bottom;
                const newWidth = width - left - right;
                const newHeight = height - top - bottom;

                if (newWidth > 0 && newHeight > 0) {
                    page.setCropBox(newX, newY, newWidth, newHeight);
                }
            });

            const newPdfBytes = await pdfDoc.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Cropped_Document.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পিডিএফ ক্রপ করা হয়েছে!');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ ক্রপ করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
