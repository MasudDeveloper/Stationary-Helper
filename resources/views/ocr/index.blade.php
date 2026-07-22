@extends('layouts.app')

@section('title', 'AI Document OCR')

@section('content')
<div class="ocr-container">
    <div class="ocr-header text-center mb-4">
        <h1><i class="material-icons-round text-primary" style="vertical-align: middle;">document_scanner</i> AI Document OCR</h1>
        <p class="text-muted">ছবি থেকে সরাসরি বাংলা বা ইংরেজি লেখা (Text) স্ক্যান করে বের করুন।</p>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px;">
        
        <!-- Upload Section -->
        <div class="col-md-5" style="flex: 1; min-width: 300px;">
            <div class="glass glass-interactive" style="padding: 30px; height: 100%;">
                <h4 class="mb-3">ছবি আপলোড করুন</h4>
                
                <div class="upload-zone" id="drop-zone" onclick="document.getElementById('file-input').click()">
                    <div class="upload-icon">
                        <i class="material-icons-round">cloud_upload</i>
                    </div>
                    <p>ক্লিক করে ছবি আপলোড করুন অথবা টেনে আনুন</p>
                    <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="handleFileSelect(event)">
                </div>

                <div class="image-preview mt-4" id="image-preview" style="display: none; text-align: center;">
                    <img id="preview-img" src="" alt="Preview" style="max-width: 100%; max-height: 250px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1);">
                    
                    <div class="language-select mt-3">
                        <label class="text-muted" style="font-size: 0.9rem;">ভাষার ধরন সিলেক্ট করুন:</label>
                        <select id="language" class="form-control" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 10px; border-radius: 8px; width: 100%; margin-top: 5px;">
                            <option value="ben">বাংলা (Bengali)</option>
                            <option value="eng">English</option>
                            <option value="eng+ben">English + বাংলা</option>
                        </select>
                    </div>

                    <button class="btn-primary w-100 mt-3" id="start-ocr-btn" onclick="startOcr()">
                        <i class="material-icons-round">document_scanner</i> লেখা স্ক্যান করুন
                    </button>
                    <p class="text-muted mt-2" style="font-size: 0.8rem;">(প্রতি স্ক্যানে ক্রেডিট কাটা হবে)</p>
                </div>
                
                <div id="processing-indicator" class="mt-4" style="display: none; text-align: center;">
                    <div class="spinner mb-3"></div>
                    <h5 class="text-primary">এআই স্ক্যান করছে...</h5>
                    <p class="text-muted" id="progress-text">অনুগ্রহ করে অপেক্ষা করুন</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" id="progress-bar"></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Result Section -->
        <div class="col-md-7" style="flex: 1.5; min-width: 300px;">
            <div class="glass" style="padding: 30px; height: 100%; display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 class="m-0">স্ক্যান করা লেখা</h4>
                    <div class="action-buttons" style="display: flex; gap: 10px;">
                        <button class="btn btn-sm" onclick="copyText()" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); padding: 5px 10px; border-radius: 6px;">
                            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">content_copy</i> কপি
                        </button>
                        <button class="btn btn-sm" onclick="downloadText()" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); padding: 5px 10px; border-radius: 6px;">
                            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">download</i> সেভ (txt)
                        </button>
                    </div>
                </div>

                <textarea id="ocr-result" class="form-control" style="flex: 1; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 12px; padding: 15px; font-size: 1.1rem; line-height: 1.6; resize: none; min-height: 300px;" placeholder="স্ক্যান করার পর এখানে লেখাটি চলে আসবে..."></textarea>
            </div>
        </div>

    </div>
</div>

<style>
.ocr-container {
    max-width: 1000px;
    margin: 0 auto;
}
.upload-zone {
    background: rgba(255, 255, 255, 0.02);
    border: 2px dashed rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}
.upload-zone:hover, .upload-zone.dragover {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
}
.upload-icon {
    width: 60px;
    height: 60px;
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}
.upload-icon i {
    font-size: 30px;
}
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(255, 255, 255, 0.1);
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    margin: 0 auto;
    animation: spin 1s linear infinite;
}
.progress-bar-container {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-top: 10px;
}
.progress-bar {
    height: 100%;
    width: 0%;
    background: var(--primary-color);
    transition: width 0.3s ease;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<!-- Tesseract.js Library -->
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

<script>
let selectedImageFile = null;

// Drag and Drop Handling
const dropZone = document.getElementById('drop-zone');
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        processFile(e.dataTransfer.files[0]);
    }
});

function handleFileSelect(e) {
    if (e.target.files.length) {
        processFile(e.target.files[0]);
    }
}

function processFile(file) {
    if (!file.type.startsWith('image/')) {
        Swal.fire('ভুল ফাইল', 'অনুগ্রহ করে একটি ছবি (Image) আপলোড করুন।', 'error');
        return;
    }
    selectedImageFile = file;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('drop-zone').style.display = 'none';
        document.getElementById('image-preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
}

function startOcr() {
    if (!selectedImageFile) return;

    // First deduct credit via AJAX
    document.getElementById('start-ocr-btn').disabled = true;
    document.getElementById('start-ocr-btn').innerHTML = '<i class="material-icons-round spin">sync</i> প্রসেস হচ্ছে...';

    fetch('{{ route("ocr.deduct_credit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Update UI balance if it exists
            const creditBadge = document.getElementById('credit-badge');
            if(creditBadge) creditBadge.innerText = data.remaining_credits.toFixed(2);
            
            // Proceed with OCR
            executeOcr();
        } else {
            Swal.fire('ক্রেডিট নেই', data.error, 'error');
            resetOcrState();
        }
    })
    .catch(error => {
        Swal.fire('ত্রুটি', 'সার্ভারের সাথে সংযোগ করা যাচ্ছে না।', 'error');
        resetOcrState();
    });
}

function executeOcr() {
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('processing-indicator').style.display = 'block';
    
    const lang = document.getElementById('language').value;
    const engine = '{{ $engine }}'; // passed from controller

    if (engine === 'ocr_space') {
        executeOcrSpace(lang);
    } else {
        executeTesseract(lang);
    }
}

function executeTesseract(lang) {
    Tesseract.recognize(
        selectedImageFile,
        lang,
        { 
            logger: m => {
                if (m.status === 'recognizing text') {
                    const percent = Math.round(m.progress * 100);
                    document.getElementById('progress-bar').style.width = percent + '%';
                    document.getElementById('progress-text').innerText = 'স্ক্যানিং প্রোগ্রেস: ' + percent + '%';
                }
            }
        }
    ).then(({ data: { text } }) => {
        finishOcr(text);
    }).catch(err => {
        failOcr('ছবি থেকে লেখা বের করতে সমস্যা হয়েছে।');
    });
}

function executeOcrSpace(lang) {
    document.getElementById('progress-bar').style.width = '100%';
    document.getElementById('progress-text').innerText = 'সার্ভারে পাঠানো হচ্ছে (অপেক্ষা করুন)...';

    const reader = new FileReader();
    reader.readAsDataURL(selectedImageFile);
    reader.onload = function () {
        const base64Image = reader.result;
        
        fetch('{{ route("ocr.process_space") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image: base64Image, language: lang })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                finishOcr(data.text);
            } else {
                failOcr(data.error || 'অজানা ত্রুটি হয়েছে।');
            }
        })
        .catch(err => {
            failOcr('সার্ভারের সাথে সংযোগ করতে সমস্যা হয়েছে।');
        });
    };
}

function finishOcr(text) {
    document.getElementById('ocr-result').value = text;
    document.getElementById('processing-indicator').style.display = 'none';
    document.getElementById('image-preview').style.display = 'block';
    resetOcrState();
    Swal.fire('সফল!', 'লেখা স্ক্যান করা সম্পন্ন হয়েছে।', 'success');
}

function failOcr(errorMsg) {
    document.getElementById('processing-indicator').style.display = 'none';
    document.getElementById('image-preview').style.display = 'block';
    resetOcrState();
    Swal.fire('ত্রুটি!', errorMsg, 'error');
}

function resetOcrState() {
    document.getElementById('start-ocr-btn').disabled = false;
    document.getElementById('start-ocr-btn').innerHTML = '<i class="material-icons-round">document_scanner</i> লেখা স্ক্যান করুন';
    document.getElementById('progress-bar').style.width = '0%';
    document.getElementById('progress-text').innerText = 'অনুগ্রহ করে অপেক্ষা করুন';
}

function copyText() {
    const text = document.getElementById('ocr-result').value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            title: 'কপি হয়েছে!',
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    });
}

function downloadText() {
    const text = document.getElementById('ocr-result').value;
    if (!text) return;
    
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'scanned_text.txt';
    a.click();
}
</script>
@endsection
