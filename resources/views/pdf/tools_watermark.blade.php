@extends('layouts.app')

@section('title', 'পিডিএফ ওয়াটারমার্ক - Smart Stationary')

@section('content')
<!-- pdf-lib CDN -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .setting-group {
        margin-bottom: 20px;
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-purple" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">branding_watermark</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ ওয়াটারমার্ক</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো পিডিএফ ফাইলে আপনার নিজের কাস্টম টেক্সট ওয়াটারমার্ক হিসেবে যুক্ত করুন।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="setting-group">
            <label class="form-label">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf">
        </div>

        <div class="setting-group">
            <label class="form-label">ওয়াটারমার্ক টেক্সট</label>
            <input type="text" id="watermark-text" class="form-control" placeholder="যেমন: CONFIDENTIAL">
        </div>

        <div class="grid-2" style="margin-bottom: 20px;">
            <div>
                <label class="form-label">ফন্ট সাইজ</label>
                <input type="number" id="font-size" class="form-control" value="60" min="10" max="200">
            </div>
            <div>
                <label class="form-label">স্বচ্ছতা (Opacity 0 - 1)</label>
                <input type="number" id="opacity" class="form-control" value="0.3" min="0.1" max="1" step="0.1">
            </div>
        </div>
        
        <div class="grid-2" style="margin-bottom: 30px;">
            <div>
                <label class="form-label">রং (Color)</label>
                <select id="color" class="form-control">
                    <option value="0,0,0">Black (কালো)</option>
                    <option value="1,0,0">Red (লাল)</option>
                    <option value="0,0,1">Blue (নীল)</option>
                    <option value="0.5,0.5,0.5">Gray (ধূসর)</option>
                </select>
            </div>
            <div>
                <label class="form-label">এঙ্গেল (Rotation Degree)</label>
                <input type="number" id="angle" class="form-control" value="45">
            </div>
        </div>

        <button class="btn btn-primary" onclick="applyWatermark()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">water_drop</i> ওয়াটারমার্ক যুক্ত করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    async function applyWatermark() {
        const fileInput = document.getElementById('pdf-upload');
        const textInput = document.getElementById('watermark-text').value;
        const fontSize = parseInt(document.getElementById('font-size').value);
        const opacity = parseFloat(document.getElementById('opacity').value);
        const colorVal = document.getElementById('color').value.split(',').map(Number);
        const angle = parseInt(document.getElementById('angle').value);

        if (!fileInput.files[0]) {
            alert('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        if (!textInput) {
            alert('ওয়াটারমার্ক টেক্সট দিন।');
            return;
        }

        try {
            const arrayBuffer = await fileInput.files[0].arrayBuffer();
            const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);
            const pages = pdfDoc.getPages();

            const font = await pdfDoc.embedFont(PDFLib.StandardFonts.HelveticaBold);

            pages.forEach((page) => {
                const { width, height } = page.getSize();
                
                // Calculate position to center
                const textWidth = font.widthOfTextAtSize(textInput, fontSize);
                const textHeight = font.heightAtSize(fontSize);

                page.drawText(textInput, {
                    x: width / 2 - textWidth / 2,
                    y: height / 2 - textHeight / 2,
                    size: fontSize,
                    font: font,
                    color: PDFLib.rgb(colorVal[0], colorVal[1], colorVal[2]),
                    opacity: opacity,
                    rotate: PDFLib.degrees(angle),
                });
            });

            const pdfBytes = await pdfDoc.save();

            // Download
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Watermarked.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            alert('সফলভাবে ওয়াটারমার্ক যুক্ত করা হয়েছে!');

        } catch (err) {
            console.error(err);
            alert('ওয়াটারমার্ক যুক্ত করতে সমস্যা হয়েছে।');
        }
    }
</script>
@endsection
