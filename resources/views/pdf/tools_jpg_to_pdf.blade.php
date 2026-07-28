@extends('layouts.app')

@section('title', 'জেপিজি টু পিডিএফ (JPG to PDF) - penghor.com')

@section('content')
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 35px; }
    
    .upload-box {
        border: 2px dashed rgba(255, 255, 255, 0.15);
        padding: 50px 20px;
        text-align: center;
        border-radius: 20px;
        background: rgba(26, 28, 38, 0.6);
        backdrop-filter: blur(15px);
        cursor: pointer;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .upload-box:hover, .upload-box.dragover {
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.08);
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
    }

    .upload-box input {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;
    }

    /* Thumbnail Grid */
    .thumbnails-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
        margin-top: 25px;
        margin-bottom: 30px;
    }

    .thumb-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 10px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.2s ease;
    }

    .thumb-card:hover {
        transform: scale(1.03);
        border-color: rgba(99, 102, 241, 0.4);
    }

    .thumb-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
        background: #000;
    }

    .thumb-name {
        font-size: 0.75rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        text-align: center;
    }

    .thumb-delete {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 26px;
        height: 26px;
        background: #ef4444;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.5);
        border: none;
        transition: transform 0.2s, background 0.2s;
    }

    .thumb-delete:hover {
        background: #dc2626;
        transform: scale(1.15);
    }

    .thumb-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        font-size: 0.7rem;
        font-weight: bold;
        padding: 2px 8px;
        border-radius: 6px;
    }

    /* Settings Dashboard */
    .settings-panel {
        background: rgba(26, 28, 38, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        backdrop-filter: blur(12px);
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .form-group-modern label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 8px;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(18, 20, 29, 0.8);
        color: #fff;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control-modern:focus {
        border-color: var(--primary-color);
    }

    /* Action Buttons */
    .btn-convert {
        background: linear-gradient(135deg, #ef4444, #f97316);
        color: #fff;
        border: none;
        padding: 16px 32px;
        border-radius: 14px;
        font-size: 1.15rem;
        font-weight: 700;
        width: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.5);
        transition: all 0.3s ease;
    }

    .btn-convert:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -5px rgba(239, 68, 68, 0.7);
        background: linear-gradient(135deg, #f97316, #ef4444);
    }

    .btn-convert:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-action-sm {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-sm:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 950px;">
    <div class="tool-header">
        <div class="tool-squircle grad-red" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 24px; box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);">
            <i class="material-icons-round" style="font-size: 2.6rem; color: #fff;">picture_as_pdf</i>
        </div>
        <h1 style="color: #fff; font-size: 2.2rem; font-weight: 800; margin-bottom: 10px;">জেপিজি টু পিডিএফ (JPG / PNG to PDF)</h1>
        <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 600px; margin: 0 auto;">
            একাধিক ছবি (JPG, PNG, WEBP) আপলোড করে নিমেষেই প্রফেশনাল A4 বা কাস্টম সাইজের পিডিএফ ফাইল তৈরি করুন।
        </p>
    </div>

    <!-- Upload Section -->
    <div class="upload-box" id="drop-zone">
        <i class="material-icons-round" style="font-size: 4.5rem; color: #818cf8; margin-bottom: 15px;">add_photo_alternate</i>
        <h3 style="color: #fff; font-size: 1.3rem; margin-bottom: 8px;">ছবিগুলো এখানে ড্র্যাগ করুন অথবা ক্লিক করে সিলেক্ট করুন</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem;">আপনি একসাথে একাধিক ছবি (JPG, PNG, WEBP) সিলেক্ট করতে পারবেন</p>
        <input type="file" id="images-upload" accept="image/jpeg, image/png, image/webp, image/*" multiple onchange="handleFiles(this.files)">
    </div>

    <!-- Uploaded Files Section (Hidden Initially) -->
    <div id="workspace-container" style="display: none; margin-top: 30px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 15px;">
            <div>
                <h3 style="color: #fff; font-size: 1.2rem; margin: 0; display: inline-block;">সিলেক্ট করা ছবিসমূহ</h3>
                <span id="file-count-badge" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; margin-left: 10px;">0 টি ছবি</span>
            </div>
            <div style="display: flex; gap: 10px;">
                <label class="btn-action-sm" style="cursor: pointer; margin: 0;">
                    <i class="material-icons-round" style="font-size: 1rem;">add_circle</i> আরও ছবি যোগ করুন
                    <input type="file" accept="image/*" multiple onchange="handleFiles(this.files)" style="display: none;">
                </label>
                <button type="button" class="btn-action-sm" onclick="clearAllFiles()" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);">
                    <i class="material-icons-round" style="font-size: 1rem;">delete_sweep</i> সব মুছে ফেলুন
                </button>
            </div>
        </div>

        <!-- Thumbnails Grid -->
        <div class="thumbnails-grid" id="thumbnails-grid"></div>

        <!-- Settings Dashboard -->
        <div class="settings-panel">
            <h4 style="color: #fff; font-size: 1.1rem; margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="color: #38bdf8;">tune</i> পিডিএফ অপশন ও পেজ সেটআপ
            </h4>
            
            <div class="settings-grid">
                <div class="form-group-modern">
                    <label for="page-size">পেজ সাইজ (Page Size)</label>
                    <select id="page-size" class="form-control-modern">
                        <option value="a4">A4 সাইজ (Standard - 210x297 mm)</option>
                        <option value="fit">ফিট টু ইমেজ (ছবির আসল সাইজ)</option>
                        <option value="letter">Letter সাইজ (8.5x11 inch)</option>
                        <option value="legal">Legal সাইজ (8.5x14 inch)</option>
                    </select>
                </div>

                <div class="form-group-modern">
                    <label for="page-orientation">অরিয়েন্টেশন (Orientation)</label>
                    <select id="page-orientation" class="form-control-modern">
                        <option value="auto">স্বয়ংক্রিয় (ছবির সাইজ অনুযায়ী)</option>
                        <option value="portrait">লম্বালম্বি (Portrait)</option>
                        <option value="landscape">আড়াআড়ি (Landscape)</option>
                    </select>
                </div>

                <div class="form-group-modern">
                    <label for="page-margin">পেজ মার্জিন (Margin)</label>
                    <select id="page-margin" class="form-control-modern">
                        <option value="0">মার্জিন ছাড়া (No Margin - Full Page)</option>
                        <option value="20" selected>সাধারণ মার্জিন (Standard - 20pt)</option>
                        <option value="40">বড় মার্জিন (Wide - 40pt)</option>
                    </select>
                </div>

                <div class="form-group-modern">
                    <label for="file-name">পিডিএফ ফাইল নাম (File Name)</label>
                    <input type="text" id="file-name" class="form-control-modern" value="converted_images.pdf" placeholder="যেমন: my_document.pdf">
                </div>
            </div>
        </div>

        <!-- Generate Button -->
        <button type="button" id="btn-generate" class="btn-convert" onclick="generatePDF()">
            <i class="material-icons-round" id="btn-icon">picture_as_pdf</i>
            <span id="btn-text">পিডিএফ তৈরি করুন (Convert to PDF)</span>
        </button>
    </div>
</div>

<script>
    let uploadedFiles = [];

    // Handle Drag & Drop
    const dropZone = document.getElementById('drop-zone');
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            handleFiles(e.dataTransfer.files);
        }
    });

    // Handle File Selection
    function handleFiles(files) {
        if (!files || files.length === 0) return;
        
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) {
                Swal.fire('ত্রুটি', `শুধুমাত্র ছবি ফাইল (JPG, PNG, WEBP) আপলোড করা যাবে: ${file.name}`, 'error');
                return;
            }
            uploadedFiles.push(file);
        });

        renderThumbnails();
    }

    // Render Thumbnails
    function renderThumbnails() {
        const container = document.getElementById('thumbnails-grid');
        const workspace = document.getElementById('workspace-container');
        const countBadge = document.getElementById('file-count-badge');

        container.innerHTML = '';
        countBadge.textContent = `${uploadedFiles.length} টি ছবি`;

        if (uploadedFiles.length === 0) {
            workspace.style.display = 'none';
            dropZone.style.display = 'block';
            return;
        }

        workspace.style.display = 'block';
        dropZone.style.display = 'none';

        uploadedFiles.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            const card = document.createElement('div');
            card.className = 'thumb-card';
            card.innerHTML = `
                <span class="thumb-badge">${index + 1}</span>
                <button type="button" class="thumb-delete" onclick="removeFile(${index})" title="ছবিটি ডিলিট করুন">
                    <i class="material-icons-round" style="font-size: 1rem;">close</i>
                </button>
                <img src="${url}" class="thumb-img" alt="${file.name}">
                <div class="thumb-name">${file.name}</div>
            `;
            container.appendChild(card);
        });
    }

    // Remove single file
    function removeFile(index) {
        uploadedFiles.splice(index, 1);
        renderThumbnails();
    }

    // Clear all files
    function clearAllFiles() {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "সিলেক্ট করা সকল ছবি মুছে ফেলা হবে!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'হ্যাঁ, মুছে ফেলুন!',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                uploadedFiles = [];
                renderThumbnails();
            }
        });
    }

    // Convert Image to Canvas Data (handles WEBP, BMP, etc. uniformly for PDF-Lib)
    function imageToDataURL(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    // Create canvas and export as PNG to preserve transparency/quality natively
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    const dataUrl = canvas.toDataURL('image/png');
                    resolve({
                        dataUrl: dataUrl,
                        width: img.width,
                        height: img.height
                    });
                };
                img.onerror = reject;
                img.src = e.target.result;
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    // Generate PDF Engine using PDF-Lib
    async function generatePDF() {
        if (uploadedFiles.length === 0) {
            return Swal.fire('সতর্কতা', 'দয়া করে কমপক্ষে ১টি ছবি আপলোড করুন!', 'warning');
        }

        const btn = document.getElementById('btn-generate');
        const icon = document.getElementById('btn-icon');
        const text = document.getElementById('btn-text');

        try {
            btn.disabled = true;
            icon.textContent = 'hourglass_empty';
            text.textContent = 'পিডিএফ প্রসেস করা হচ্ছে... অপেক্ষা করুন';

            const pdfDoc = await PDFLib.PDFDocument.create();

            const pageSizeOpt = document.getElementById('page-size').value;
            const orientationOpt = document.getElementById('page-orientation').value;
            const margin = parseFloat(document.getElementById('page-margin').value) || 0;
            let fileName = document.getElementById('file-name').value.trim() || 'converted_images.pdf';
            if (!fileName.toLowerCase().endsWith('.pdf')) fileName += '.pdf';

            // Process each image in sequence
            for (let i = 0; i < uploadedFiles.length; i++) {
                const file = uploadedFiles[i];
                const imgData = await imageToDataURL(file);

                // Embed image into pdfDoc
                const pngImage = await pdfDoc.embedPng(imgData.dataUrl);
                const imgWidth = imgData.width;
                const imgHeight = imgData.height;

                let pageWidth, pageHeight;

                if (pageSizeOpt === 'fit') {
                    // Page dimensions exact match to image plus margins
                    pageWidth = imgWidth + (margin * 2);
                    pageHeight = imgHeight + (margin * 2);
                } else {
                    // Standard sizes in points (72 points = 1 inch)
                    if (pageSizeOpt === 'a4') { pageWidth = 595.28; pageHeight = 841.89; }
                    else if (pageSizeOpt === 'letter') { pageWidth = 612.00; pageHeight = 792.00; }
                    else if (pageSizeOpt === 'legal') { pageWidth = 612.00; pageHeight = 1008.00; }

                    // Apply Orientation
                    if (orientationOpt === 'landscape' || (orientationOpt === 'auto' && imgWidth > imgHeight)) {
                        const temp = pageWidth;
                        pageWidth = Math.max(pageWidth, pageHeight);
                        pageHeight = Math.min(temp, pageHeight);
                    } else if (orientationOpt === 'portrait' || (orientationOpt === 'auto' && imgHeight >= imgWidth)) {
                        const temp = pageHeight;
                        pageHeight = Math.max(pageWidth, pageHeight);
                        pageWidth = Math.min(temp, pageWidth);
                    }
                }

                const page = pdfDoc.addPage([pageWidth, pageHeight]);

                // Calculate printable area inside margins
                const availWidth = pageWidth - (margin * 2);
                const availHeight = pageHeight - (margin * 2);

                // Scale image proportionally to fit available area
                const scale = Math.min(availWidth / imgWidth, availHeight / imgHeight);
                const drawWidth = imgWidth * scale;
                const drawHeight = imgHeight * scale;

                // Center image on page
                const x = margin + (availWidth - drawWidth) / 2;
                const y = margin + (availHeight - drawHeight) / 2;

                page.drawImage(pngImage, {
                    x: x,
                    y: y,
                    width: drawWidth,
                    height: drawHeight,
                });
            }

            // Save PDF and trigger automatic download
            const pdfBytes = await pdfDoc.save();
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const url = URL.createObjectURL(blob);
            
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            Swal.fire({
                title: 'অভিনন্দন!',
                text: `${uploadedFiles.length} টি ছবি নিয়ে আপনার পিডিএফ ফাইল তৈরি এবং ডাউনলোড শুরু হয়েছে!`,
                icon: 'success',
                confirmButtonColor: '#10b981',
                confirmButtonText: 'ঠিক আছে'
            });

        } catch (error) {
            console.error('Error generating PDF:', error);
            Swal.fire('ত্রুটি', 'পিডিএফ তৈরি করার সময় কোনো সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
        } finally {
            btn.disabled = false;
            icon.textContent = 'picture_as_pdf';
            text.textContent = 'পিডিএফ তৈরি করুন (Convert to PDF)';
        }
    }
</script>
@endsection
