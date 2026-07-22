@extends('layouts.app')

@section('title', 'পিডিএফ স্প্লিট - Smart Stationary')

@section('content')
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-cyan" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(6, 182, 212, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">call_split</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ স্প্লিট (PDF Split)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">বড় পিডিএফ থেকে নির্দিষ্ট কিছু পেজ আলাদা করে নতুন পিডিএফ তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" onchange="loadPdfInfo()">
            <small id="page-count-info" style="color: #10b981; display: none; margin-top: 5px; font-weight: bold;"></small>
        </div>

        <div class="grid-2" style="margin-bottom: 30px;">
            <div>
                <label class="form-label">শুরুর পেজ (From Page)</label>
                <input type="number" id="start-page" class="form-control" value="1" min="1">
            </div>
            <div>
                <label class="form-label">শেষ পেজ (To Page)</label>
                <input type="number" id="end-page" class="form-control" value="1" min="1">
            </div>
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; text-align: center; font-weight: bold;">
            স্প্লিট করা হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="splitPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">cut</i> স্প্লিট করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    let totalPages = 0;
    let fileBytes = null;

    async function loadPdfInfo() {
        const file = document.getElementById('pdf-upload').files[0];
        if (!file) return;

        try {
            fileBytes = await file.arrayBuffer();
            const pdfDoc = await PDFLib.PDFDocument.load(fileBytes);
            totalPages = pdfDoc.getPageCount();
            
            const info = document.getElementById('page-count-info');
            info.innerText = `এই ফাইলে মোট ${totalPages} টি পেজ আছে।`;
            info.style.display = 'block';

            document.getElementById('end-page').value = totalPages;
            document.getElementById('end-page').max = totalPages;
            document.getElementById('start-page').max = totalPages;
        } catch(e) {
            console.error(e);
        }
    }

    async function splitPdf() {
        if (!fileBytes) {
            Swal.fire('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        let start = parseInt(document.getElementById('start-page').value);
        let end = parseInt(document.getElementById('end-page').value);

        if (start < 1 || end > totalPages || start > end) {
            Swal.fire('অনুগ্রহ করে সঠিক পেজ রেঞ্জ দিন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const originalPdf = await PDFLib.PDFDocument.load(fileBytes);
            const newPdf = await PDFLib.PDFDocument.create();

            // create array of page indices to copy (0-indexed)
            let pagesToCopy = [];
            for (let i = start - 1; i < end; i++) {
                pagesToCopy.push(i);
            }

            const copiedPages = await newPdf.copyPages(originalPdf, pagesToCopy);
            copiedPages.forEach((page) => {
                newPdf.addPage(page);
            });

            const newPdfBytes = await newPdf.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `Split_Pages_${start}-${end}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে স্প্লিট করা হয়েছে!');
        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ স্প্লিট করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
