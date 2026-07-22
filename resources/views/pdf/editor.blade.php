@extends('layouts.app')

@section('title', 'পিডিএফ এডিটর - Smart Stationary')

@section('content')
<!-- pdf-lib CDN -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<style>
    .pdf-editor-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .pdf-editor-sidebar {
        width: 100%;
        flex-shrink: 0;
    }
    
    .pdf-editor-canvas-container {
        flex: 1;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 40px 20px;
        overflow-y: auto;
        overflow-x: auto;
        max-height: calc(100vh - 150px);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        position: relative;
    }

    .pdf-page-container {
        position: relative;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        background: #fff;
        max-width: 100%; /* For smaller screens */
    }

    .text-overlay {
        position: absolute;
        color: #000;
        font-family: Helvetica, sans-serif;
        background: rgba(99, 102, 241, 0.1);
        border: 1px dashed var(--primary-color);
        padding: 4px;
        cursor: move;
        white-space: nowrap;
        user-select: none;
        z-index: 10;
        font-size: 14px;
    }

    .whiteout-overlay {
        position: absolute;
        background: #ffffff;
        border: 1px solid rgba(239, 68, 68, 0.5); /* Red border just for visibility while editing */
        cursor: move;
        resize: both;
        overflow: hidden;
        z-index: 5;
    }


</style>

<div class="pdf-editor-wrapper">
    <!-- Sidebar -->
    <div class="pdf-editor-sidebar">
        <div class="glass" style="padding: 25px; position: sticky; top: 20px; border-radius: 15px;">
            <h3 style="margin-bottom: 20px; color: #fff; display: flex; align-items: center; gap: 8px; font-weight: 700;">
                <i class="material-icons-round" style="color: #818cf8;">edit_document</i> পিডিএফ এডিটর
            </h3>

            <div class="form-group">
                <label class="form-label">পিডিএফ আপলোড করুন</label>
                <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" onchange="loadPdfFile()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); padding: 10px;">
            </div>

            <div id="editor-controls" style="display: none;">
                <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
                
                <h4 style="margin-bottom: 15px; color: #fff; font-weight: 600;">এডিটিং টুলস</h4>
                <div class="form-group">
                    <label class="form-label">টার্গেট পেজ</label>
                    <select id="target-page-select" class="form-control" style="margin-bottom: 15px; background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);"></select>
                </div>
                
                <div class="form-group">
                    <input type="text" id="add-text-input" class="form-control" placeholder="নতুন টেক্সট লিখুন..." style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
                </div>
                <button onclick="addTextOverlay()" class="btn btn-primary" style="width: 100%; margin-bottom: 15px; font-weight: 600; background: linear-gradient(135deg, #6366f1, #06b6d4);">
                    <i class="material-icons-round" style="vertical-align: middle;">title</i> টেক্সট যোগ করুন
                </button>

                <div style="text-align: center; margin-bottom: 15px; color: var(--text-muted); font-size: 0.85rem;">
                    পুরোনো লেখা মুছতে হোয়াইটআউট ব্যবহার করুন
                </div>
                
                <button onclick="addWhiteoutOverlay()" class="btn" style="width: 100%; margin-bottom: 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                    <i class="material-icons-round" style="vertical-align: middle;">cleaning_services</i> হোয়াইটআউট (ইরেজার)
                </button>

                <hr style="border-color: var(--border-color); margin: 20px 0;">

                <button onclick="exportEditedPDF()" class="btn" style="width: 100%; background: linear-gradient(135deg, #10b981, #059669); color: #fff; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                    <i class="material-icons-round">download</i> এডিটেড পিডিএফ সেভ
                </button>
            </div>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="pdf-editor-canvas-container" id="pdf-workspace">
        <div id="placeholder-text" style="color: var(--text-muted); margin-top: 100px; text-align: center;">
            <i class="material-icons-round" style="font-size: 4rem; opacity: 0.2; margin-bottom: 16px;">upload_file</i>
            <p>শুরু করতে বাম পাশের প্যানেল থেকে একটি পিডিএফ ফাইল আপলোড করুন।</p>
        </div>
    </div>
</div>

<script>
    let pdfDocBytes = null;
    let pdfJsDoc = null;
    let pageOverlays = {}; // Holds added text items keyed by page number
    let pageWhiteouts = {}; // Holds added whiteout areas
    let currentScale = 1.3; // Rendering scale

    async function loadPdfFile() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];
        if (!file) return;

        document.getElementById('placeholder-text').style.display = 'none';
        const workspace = document.getElementById('pdf-workspace');
        workspace.innerHTML = ''; // Clear workspace
        pageOverlays = {}; 
        pageWhiteouts = {};

        try {
            pdfDocBytes = await file.arrayBuffer();
            
            // Load and Render PDF pages using PDF.js
            pdfJsDoc = await pdfjsLib.getDocument({ data: pdfDocBytes }).promise;
            const pageCount = pdfJsDoc.numPages;

            const pageSelect = document.getElementById('target-page-select');
            pageSelect.innerHTML = '';

            for (let pageNum = 1; pageNum <= pageCount; pageNum++) {
                // Add select option
                const opt = document.createElement('option');
                opt.value = pageNum;
                opt.innerText = `Page ${pageNum}`;
                pageSelect.appendChild(opt);

                const page = await pdfJsDoc.getPage(pageNum);
                
                // For mobile responsiveness, we might want to scale down slightly if screen is small
                let scale = currentScale;
                if (window.innerWidth < 768) {
                    scale = 0.8;
                }
                
                const viewport = page.getViewport({ scale: scale });

                // Container for this page
                const pageContainer = document.createElement('div');
                pageContainer.id = `page-container-${pageNum}`;
                pageContainer.className = 'pdf-page-container';
                pageContainer.style.width = `${viewport.width}px`;
                pageContainer.style.height = `${viewport.height}px`;

                // Canvas for rendering page contents
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                canvas.style.width = '100%';
                canvas.style.height = '100%';
                pageContainer.appendChild(canvas);

                const ctx = canvas.getContext('2d');
                await page.render({ canvasContext: ctx, viewport: viewport }).promise;

                workspace.appendChild(pageContainer);
                pageOverlays[pageNum] = [];
                pageWhiteouts[pageNum] = [];
            }

            document.getElementById('editor-controls').style.display = 'block';

        } catch (err) {
            console.error(err);
            Swal.fire('পিডিএফ ফাইল লোড করতে সমস্যা হয়েছে।');
        }
    }

    function addTextOverlay() {
        const textVal = document.getElementById('add-text-input').value;
        if (!textVal) return;

        const pageNum = parseInt(document.getElementById('target-page-select').value);
        const container = document.getElementById(`page-container-${pageNum}`);
        if (!container) return;

        const textDiv = document.createElement('div');
        textDiv.className = 'text-overlay';
        textDiv.innerText = textVal;
        textDiv.style.left = '50px';
        textDiv.style.top = '50px';

        makeDraggable(textDiv, container);

        container.appendChild(textDiv);

        pageOverlays[pageNum].push({
            element: textDiv,
            text: textVal
        });

        document.getElementById('add-text-input').value = '';
    }

    function addWhiteoutOverlay() {
        const pageNum = parseInt(document.getElementById('target-page-select').value);
        const container = document.getElementById(`page-container-${pageNum}`);
        if (!container) return;

        const whiteoutDiv = document.createElement('div');
        whiteoutDiv.className = 'whiteout-overlay';
        whiteoutDiv.style.left = '50px';
        whiteoutDiv.style.top = '50px';
        whiteoutDiv.style.width = '100px';
        whiteoutDiv.style.height = '20px';

        makeDraggable(whiteoutDiv, container);

        container.appendChild(whiteoutDiv);

        pageWhiteouts[pageNum].push({
            element: whiteoutDiv
        });
    }

    function makeDraggable(element, boundary) {
        let active = false;
        let startX, startY;
        let initialX, initialY;

        element.addEventListener('mousedown', dragStart);
        // Also support touch events for mobile
        element.addEventListener('touchstart', dragStart, {passive: false});

        document.addEventListener('mouseup', dragEnd);
        document.addEventListener('touchend', dragEnd);

        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag, {passive: false});

        function dragStart(e) {
            // Ignore resize handle clicks for whiteout
            if (e.offsetX > element.offsetWidth - 15 && e.offsetY > element.offsetHeight - 15) return;
            
            if (e.target === element) {
                active = true;
                if(e.type === 'touchstart') {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                } else {
                    startX = e.clientX;
                    startY = e.clientY;
                }
                initialX = parseFloat(element.style.left) || 0;
                initialY = parseFloat(element.style.top) || 0;
            }
        }

        function dragEnd(e) {
            active = false;
        }

        function drag(e) {
            if (active) {
                let currentX, currentY;
                if(e.type === 'touchmove') {
                    currentX = e.touches[0].clientX;
                    currentY = e.touches[0].clientY;
                    e.preventDefault(); // Prevent scrolling while dragging
                } else {
                    currentX = e.clientX;
                    currentY = e.clientY;
                }

                const dx = currentX - startX;
                const dy = currentY - startY;

                element.style.left = `${initialX + dx}px`;
                element.style.top = `${initialY + dy}px`;
            }
        }
    }

    async function exportEditedPDF() {
        if (!pdfDocBytes) return;

        try {
            // Load PDF in pdf-lib
            const pdfDoc = await PDFLib.PDFDocument.load(pdfDocBytes);
            const pages = pdfDoc.getPages();

            // Iterate over pages
            for (let pageNum = 1; pageNum <= pages.length; pageNum++) {
                const index = pageNum - 1;
                const page = pages[index];
                const { width, height } = page.getSize();
                
                const container = document.getElementById(`page-container-${pageNum}`);
                if(!container) continue;

                // Actual DOM width/height
                const containerWidth = container.getBoundingClientRect().width;
                const containerHeight = container.getBoundingClientRect().height;

                const scaleX = width / containerWidth;
                const scaleY = height / containerHeight;

                // 1. Draw Whiteouts first (so text can go on top)
                if (pageWhiteouts[pageNum]) {
                    for (let overlay of pageWhiteouts[pageNum]) {
                        const el = overlay.element;
                        const left = parseFloat(el.style.left) || 0;
                        const top = parseFloat(el.style.top) || 0;
                        const elWidth = el.offsetWidth;
                        const elHeight = el.offsetHeight;

                        const pdfX = left * scaleX;
                        // pdf-lib y origin is bottom left
                        const pdfY = height - (top * scaleY) - (elHeight * scaleY);

                        page.drawRectangle({
                            x: pdfX,
                            y: pdfY,
                            width: elWidth * scaleX,
                            height: elHeight * scaleY,
                            color: PDFLib.rgb(1, 1, 1) // White
                        });
                    }
                }

                // 2. Draw Texts
                if (pageOverlays[pageNum]) {
                    for (let overlay of pageOverlays[pageNum]) {
                        const el = overlay.element;
                        const left = parseFloat(el.style.left) || 0;
                        const top = parseFloat(el.style.top) || 0;

                        const pdfX = left * scaleX;
                        // Adjust font baseline
                        const pdfY = height - (top * scaleY) - (14 * scaleY * 1.2); 

                        page.drawText(overlay.text, {
                            x: pdfX,
                            y: pdfY,
                            size: 14 * scaleX, // Scale font size roughly
                            color: PDFLib.rgb(0, 0, 0)
                        });
                    }
                }
            }

            const pdfBytes = await pdfDoc.save();
            
            // Download file
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'SmartStationary_Edited.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('এডিটেড পিডিএফ ডাউনলোড সম্পূর্ণ হয়েছে!');

        } catch (err) {
            console.error(err);
            Swal.fire('পিডিএফ সেভ করতে সমস্যা হয়েছে।');
        }
    }
</script>
@endsection
