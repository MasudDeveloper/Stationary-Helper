@extends('layouts.app')

@section('title', 'পিডিএফ টু ওয়ার্ড - Smart Stationary')

@section('content')
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
        <div class="tool-squircle grad-blue" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">description</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ টু ওয়ার্ড (PDF to Word)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">আপনার পিডিএফ ফাইল থেকে টেক্সট এক্সট্রাক্ট করে এডিটেবল মাইক্রোসফট ওয়ার্ড ফাইলে (Word / Doc) কনভার্ট করুন।</p>
    </div>

    <div class="glass" style="padding: 40px; text-align: center;">
        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label" style="display: block; margin-bottom: 15px;">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" style="max-width: 400px; margin: 0 auto;">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; font-weight: bold;">
            ওয়ার্ডে কনভার্ট করা হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="convertToWord()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">file_download</i> ওয়ার্ড ফাইল হিসেবে ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    async function convertToWord() {
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

            let htmlContent = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <meta charset="utf-8">
                <title>Converted Document</title>
                <style>
                    body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; }
                    p { margin: 0 0 10pt 0; }
                </style>
            </head>
            <body>`;

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                const textContent = await page.getTextContent();
                
                let pageText = "";
                let lastY = -1;

                textContent.items.forEach(item => {
                    const y = Math.round(item.transform[5]);
                    
                    // Simple logic to detect line breaks based on Y coordinate change
                    if (lastY !== -1 && Math.abs(lastY - y) > 5) {
                        pageText += "</p><p>";
                    }
                    
                    pageText += item.str + " ";
                    lastY = y;
                });

                htmlContent += `<p>${pageText}</p>`;
                
                // Add page break if not last page
                if (i < totalPages) {
                    htmlContent += `<br clear="all" style="page-break-before:always" />`;
                }
            }

            htmlContent += `</body></html>`;

            // Download as .doc
            const blob = new Blob(['\ufeff', htmlContent], { type: 'application/msword' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Converted_Document.doc';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে কনভার্ট করা হয়েছে! ফাইলটি Microsoft Word দিয়ে ওপেন করুন।');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ কনভার্ট করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
