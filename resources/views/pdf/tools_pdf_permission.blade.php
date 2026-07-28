@extends('layouts.app')

@section('title', 'পিডিএফ পারমিশন - penghor.com')

@section('content')
<!-- PDF-lib -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-pink" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">admin_panel_settings</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ পারমিশন (Secure PDF)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">আপনার পিডিএফ ফাইলকে লক (Flatten) করুন যাতে কেউ ভেতর থেকে কোনো লেখা কপি বা এডিট করতে না পারে।</p>
    </div>

    <div class="glass" style="padding: 40px; text-align: center;">
        
        <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 15px; border-radius: 10px; margin-bottom: 30px; text-align: left;">
            <strong><i class="material-icons-round" style="vertical-align: middle;">security</i> কীভাবে কাজ করে?</strong><br>
            আপনার আপলোড করা পিডিএফের সকল টেক্সট এবং এলিমেন্টকে স্ক্যান করে একটি সুরক্ষিত ইমেজ লেয়ারে পরিণত করা হবে (Flattening)। এর ফলে সাধারণ পিডিএফ রিডার দিয়ে এই ফাইল থেকে কোনো লেখা কপি বা পরিবর্তন করা সম্ভব হবে না।
        </div>

        <div class="form-group">
            <label class="form-label" style="display: block; margin-bottom: 15px;">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" style="max-width: 400px; margin: 0 auto;">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; font-weight: bold;">
            আপনার ফাইলটি সুরক্ষিত করা হচ্ছে... দয়া করে অপেক্ষা করুন। <br>
            <small>(বড় ফাইলের ক্ষেত্রে কিছুটা সময় লাগতে পারে)</small>
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="securePdf()" style="margin-top: 20px; padding: 15px 40px; font-size: 1.1rem;">
            <i class="material-icons-round">lock</i> পিডিএফ লক করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    async function securePdf() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];
        if (!file) {
            Swal.fire('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            const totalPages = pdf.numPages;

            // Create a new blank PDF
            const newPdf = await PDFLib.PDFDocument.create();

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({ scale: 2.0 }); // High res scale
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                await page.render({ canvasContext: ctx, viewport: viewport }).promise;

                // convert to JPEG (base64 string)
                const dataUrl = canvas.toDataURL('image/jpeg', 0.9);

                // Add to new PDF using pdf-lib
                const imageBytes = await fetch(dataUrl).then(res => res.arrayBuffer());
                const pdfImage = await newPdf.embedJpg(imageBytes);
                
                const newPage = newPdf.addPage([viewport.width, viewport.height]);
                newPage.drawImage(pdfImage, {
                    x: 0,
                    y: 0,
                    width: viewport.width,
                    height: viewport.height,
                });
            }

            const newPdfBytes = await newPdf.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Secured_Document.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পিডিএফ সুরক্ষিত করা হয়েছে!');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ প্রসেস করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
