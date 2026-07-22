@extends('layouts.app')

@section('title', 'ইমেজ এক্সট্রাক্ট - Smart Stationary')

@section('content')
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>
<!-- JSZip CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    #image-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }
    .img-card {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 5px;
        background: #fff;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .img-card img {
        width: 100%;
        height: auto;
        border-radius: 4px;
    }
    .img-card span {
        display: block;
        font-size: 0.8rem;
        color: #666;
        margin-top: 5px;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 900px;">
    <div class="tool-header">
        <div class="tool-squircle grad-purple" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">image_search</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ থেকে ইমেজ এক্সট্রাক্ট</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">পিডিএফ আপলোড করুন এবং এর সকল পেজ ইমেজ (JPG) হিসেবে ডাউনলোড করুন।</p>
    </div>

    <div class="glass" style="padding: 30px;">
        <div class="form-group text-center">
            <label class="form-label" style="display: block; margin-bottom: 15px;">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" style="max-width: 400px; margin: 0 auto;" onchange="processPdf()">
        </div>

        <div id="loading" style="display: none; text-align: center; color: var(--primary-color); margin: 20px 0;">
            প্রসেস হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <div id="image-preview"></div>

        <div id="action-area" style="display: none; text-align: center; margin-top: 40px;">
            <button class="btn btn-primary" onclick="downloadAll()" style="padding: 15px 40px; font-size: 1.1rem;">
                <i class="material-icons-round">folder_zip</i> সব ছবি একসাথে ডাউনলোড করুন (ZIP)
            </button>
        </div>
    </div>
</div>

<script>
    let extractedImages = [];

    async function processPdf() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];
        if (!file) return;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('action-area').style.display = 'none';
        extractedImages = [];

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            const totalPages = pdf.numPages;
            const previewContainer = document.getElementById('image-preview');

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                // high resolution scale
                const viewport = page.getViewport({ scale: 2.0 });
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                await page.render({ canvasContext: ctx, viewport: viewport }).promise;

                // convert to JPEG
                const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                extractedImages.push({
                    name: `page_${i}.jpg`,
                    dataUrl: dataUrl
                });

                // Add to preview UI (use smaller image for preview)
                const card = document.createElement('div');
                card.className = 'img-card';
                card.innerHTML = `
                    <img src="${dataUrl}" alt="Page ${i}">
                    <span>Page ${i}</span>
                `;
                previewContainer.appendChild(card);
            }

            document.getElementById('loading').style.display = 'none';
            document.getElementById('action-area').style.display = 'block';

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ থেকে ছবি এক্সট্রাক্ট করতে সমস্যা হয়েছে!');
            document.getElementById('loading').style.display = 'none';
        }
    }

    async function downloadAll() {
        if (extractedImages.length === 0) return;

        const zip = new JSZip();
        
        extractedImages.forEach((img) => {
            // remove data:image/jpeg;base64, from the string
            const base64Data = img.dataUrl.split(',')[1];
            zip.file(img.name, base64Data, { base64: true });
        });

        zip.generateAsync({ type: 'blob' }).then(function(content) {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(content);
            link.download = 'Extracted_Images.zip';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    }
</script>
@endsection
