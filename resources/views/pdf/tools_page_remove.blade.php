@extends('layouts.app')

@section('title', 'পেজ রিমুভ - penghor.com')

@section('content')
<!-- pdf-lib CDN -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<style>
    .tool-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .page-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .page-card {
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        cursor: pointer;
        position: relative;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 2px solid transparent;
    }
    .page-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }
    .page-card.selected {
        border-color: #ef4444; /* Red border */
    }
    .page-card.selected::after {
        content: '\e872'; /* Delete icon */
        font-family: 'Material Icons Round';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(239, 68, 68, 0.7);
        color: #fff;
        font-size: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
    .page-card canvas {
        width: 100%;
        height: auto;
        border: 1px solid #ddd;
    }
    .page-number {
        text-align: center;
        font-weight: 600;
        margin-top: 8px;
        color: #333;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1000px;">
    <div class="tool-header">
        <div class="tool-squircle grad-purple" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">auto_delete</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ পেজ রিমুভ</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো পিডিএফ ফাইল আপলোড করুন এবং যে পেজগুলো ডিলিট করতে চান সেগুলোতে ক্লিক করুন।</p>
    </div>

    <div class="glass" style="padding: 30px;">
        <div class="form-group text-center">
            <label class="form-label" style="display: block; margin-bottom: 15px; font-size: 1rem;">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" style="max-width: 400px; margin: 0 auto;" onchange="loadPdf()">
        </div>

        <div id="loading" style="display: none; text-align: center; color: var(--primary-color); margin: 20px 0;">
            লোড হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <div id="pages-container" class="page-grid"></div>

        <div id="action-area" style="display: none; text-align: center; margin-top: 40px;">
            <button class="btn btn-primary" onclick="removeSelectedPages()" style="padding: 15px 40px; font-size: 1.1rem;">
                <i class="material-icons-round">delete_sweep</i> পেজ রিমুভ করে ডাউনলোড করুন
            </button>
        </div>
    </div>
</div>

<script>
    let pdfDocBytes = null;
    let selectedPages = new Set();
    let totalPages = 0;

    async function loadPdf() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];
        if (!file) return;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('pages-container').innerHTML = '';
        document.getElementById('action-area').style.display = 'none';
        selectedPages.clear();

        try {
            pdfDocBytes = await file.arrayBuffer();
            const pdfJsDoc = await pdfjsLib.getDocument({ data: pdfDocBytes }).promise;
            totalPages = pdfJsDoc.numPages;

            const container = document.getElementById('pages-container');

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdfJsDoc.getPage(i);
                const viewport = page.getViewport({ scale: 0.5 }); // Thumbnail scale

                const card = document.createElement('div');
                card.className = 'page-card';
                card.dataset.pageIndex = i - 1; // 0-indexed for pdf-lib
                card.onclick = () => togglePageSelection(card, i - 1);

                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                const ctx = canvas.getContext('2d');

                await page.render({ canvasContext: ctx, viewport: viewport }).promise;

                card.appendChild(canvas);
                
                const num = document.createElement('div');
                num.className = 'page-number';
                num.innerText = `Page ${i}`;
                card.appendChild(num);

                container.appendChild(card);
            }

            document.getElementById('loading').style.display = 'none';
            document.getElementById('action-area').style.display = 'block';

        } catch (err) {
            console.error(err);
            Swal.fire('ফাইল লোড করতে সমস্যা হয়েছে!');
            document.getElementById('loading').style.display = 'none';
        }
    }

    function togglePageSelection(card, pageIndex) {
        if (selectedPages.has(pageIndex)) {
            selectedPages.delete(pageIndex);
            card.classList.remove('selected');
        } else {
            selectedPages.add(pageIndex);
            card.classList.add('selected');
        }
    }

    async function removeSelectedPages() {
        if (selectedPages.size === 0) {
            Swal.fire('আপনি কোনো পেজ সিলেক্ট করেননি!');
            return;
        }

        if (selectedPages.size === totalPages) {
            Swal.fire('আপনি সবগুলো পেজ সিলেক্ট করেছেন। অন্তত একটি পেজ রাখতে হবে।');
            return;
        }

        try {
            const originalPdf = await PDFLib.PDFDocument.load(pdfDocBytes);
            const newPdf = await PDFLib.PDFDocument.create();

            const pagesToKeep = [];
            for (let i = 0; i < totalPages; i++) {
                if (!selectedPages.has(i)) {
                    pagesToKeep.push(i);
                }
            }

            const copiedPages = await newPdf.copyPages(originalPdf, pagesToKeep);
            copiedPages.forEach((page) => newPdf.addPage(page));

            const newPdfBytes = await newPdf.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Removed_Pages.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পেজ রিমুভ করে পিডিএফ ডাউনলোড করা হয়েছে!');

        } catch (err) {
            console.error(err);
            Swal.fire('পিডিএফ সেভ করতে সমস্যা হয়েছে!');
        }
    }
</script>
@endsection
