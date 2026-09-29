@extends('layouts.app')

@section('title', 'Quick Share')

@section('content')
<div class="share-container">
    <div class="share-header">
        <h1><i class="material-icons-round">bolt</i> কুইক শেয়ার</h1>
        <p>ফোন থেকে পিসিতে অথবা পিসি থেকে ফোনে খুব সহজেই ফাইল ট্রান্সফার করুন।</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">
            <i class="material-icons-round">error</i> {{ session('error') }}
        </div>
    @endif

    <div class="share-tabs">
        <button class="tab-btn active" onclick="switchTab('send')">
            <i class="material-icons-round">upload_file</i> ফাইল পাঠান
        </button>
        <button class="tab-btn" onclick="switchTab('receive')">
            <i class="material-icons-round">download</i> ফাইল রিসিভ করুন
        </button>
    </div>

    <!-- Send Tab -->
    <div class="share-content" id="send-tab">
        <div class="upload-zone" id="drop-zone" onclick="document.getElementById('file-input').click()">
            <div class="upload-icon">
                <i class="material-icons-round">cloud_upload</i>
            </div>
            <h3>ফাইল আপলোড করতে এখানে ক্লিক করুন</h3>
            <p>অথবা ফাইলটি টেনে এনে এখানে ছেড়ে দিন (সর্বোচ্চ ৫০ মেগাবাইট)</p>
            <input type="file" id="file-input" style="display: none;" onchange="handleFileSelect(event)">
        </div>

        <!-- Progress and Success state -->
        <div class="upload-progress" id="upload-progress" style="display: none;">
            <div class="spinner"></div>
            <p>ফাইল আপলোড হচ্ছে, অপেক্ষা করুন...</p>
        </div>

        <div class="upload-success" id="upload-success" style="display: none;">
            <i class="material-icons-round success-icon">check_circle</i>
            <h3>আপলোড সফল হয়েছে!</h3>
            <p>আপনার পিন কোডটি নিচে দেওয়া হলো। এই কোডটি দিয়ে অন্য ডিভাইসে ফাইলটি ডাউনলোড করতে পারবেন।</p>
            <div class="pin-display" id="generated-pin">000000</div>
            <p class="expiry-note"><i class="material-icons-round">info</i> ফাইলটি ২৪ ঘণ্টা পর স্বয়ংক্রিয়ভাবে মুছে যাবে।</p>
            <button class="btn-primary mt-3" onclick="resetUpload()">নতুন ফাইল পাঠান</button>
        </div>
    </div>

    <!-- Receive Tab -->
    <div class="share-content" id="receive-tab" style="display: none;">
        <div class="receive-box">
            <div class="receive-icon">
                <i class="material-icons-round">lock</i>
            </div>
            <h3>পিন কোড এন্টার করুন</h3>
            <p>অন্য ডিভাইস থেকে পাওয়া ৬-ডিজিটের পিন কোডটি এখানে দিন</p>
            
            <form action="{{ route('share.download') }}" method="POST" class="pin-form">
                @csrf
                <div class="pin-input-group">
                    <input type="text" name="pin" class="pin-input" placeholder="যেমন: 123456" maxlength="6" required autocomplete="off">
                </div>
                <button type="submit" class="btn-primary w-100">
                    <i class="material-icons-round">download</i> ডাউনলোড করুন
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.share-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 20px;
}
.share-header {
    text-align: center;
    margin-bottom: 30px;
}
.share-header h1 {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 2.2rem;
    color: var(--primary-color);
    margin-bottom: 10px;
}
.share-header p {
    color: var(--text-muted);
    font-size: 1.1rem;
}
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}
.alert-error {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}
.share-tabs {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    background: rgba(255, 255, 255, 0.03);
    padding: 8px;
    border-radius: 16px;
    border: 1px solid var(--border-color);
}
.tab-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.tab-btn:hover {
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-main);
}
.tab-btn.active {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 4px 15px var(--primary-glow);
}
.share-content {
    animation: fadeIn 0.4s ease;
}
.upload-zone {
    background: rgba(255, 255, 255, 0.02);
    border: 2px dashed var(--border-color);
    border-radius: 20px;
    padding: 60px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}
.upload-zone:hover, .upload-zone.dragover {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
}
.upload-icon {
    width: 80px;
    height: 80px;
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.upload-icon i {
    font-size: 40px;
}
.upload-zone h3 {
    font-size: 1.4rem;
    margin-bottom: 10px;
    color: var(--text-main);
}
.upload-zone p {
    color: var(--text-muted);
}
.upload-progress, .upload-success {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 50px 20px;
    text-align: center;
    backdrop-filter: blur(10px);
}
.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255, 255, 255, 0.1);
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}
.success-icon {
    font-size: 60px;
    color: #10b981;
    margin-bottom: 15px;
}
.pin-display {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--primary-color);
    letter-spacing: 5px;
    margin: 20px 0;
    text-shadow: 0 4px 20px var(--primary-glow);
    background: rgba(99, 102, 241, 0.1);
    padding: 15px 30px;
    border-radius: 16px;
    display: inline-block;
    border: 1px solid rgba(99, 102, 241, 0.2);
}
.expiry-note {
    color: var(--text-muted);
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.receive-box {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    backdrop-filter: blur(10px);
}
.receive-icon {
    width: 80px;
    height: 80px;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.receive-icon i {
    font-size: 40px;
}
.pin-form {
    max-width: 350px;
    margin: 30px auto 0;
}
.pin-input {
    width: 100%;
    background: rgba(0, 0, 0, 0.2);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 15px;
    font-size: 2rem;
    text-align: center;
    color: var(--text-main);
    letter-spacing: 5px;
    font-weight: bold;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}
.pin-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 15px var(--primary-glow);
    outline: none;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.currentTarget.classList.add('active');

    if(tab === 'send') {
        document.getElementById('send-tab').style.display = 'block';
        document.getElementById('receive-tab').style.display = 'none';
    } else {
        document.getElementById('send-tab').style.display = 'none';
        document.getElementById('receive-tab').style.display = 'block';
        setTimeout(() => document.querySelector('.pin-input').focus(), 100);
    }
}

// Drag and drop support
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
    if (e.dataTransfer.files.length) {
        uploadFile(e.dataTransfer.files[0]);
    }
});

function handleFileSelect(e) {
    if (e.target.files.length) {
        uploadFile(e.target.files[0]);
    }
}

function uploadFile(file) {
    // Check file size (50MB)
    if (file.size > 50 * 1024 * 1024) {
        alert('ফাইল সাইজ ৫০ মেগাবাইটের বেশি হতে পারবে না।');
        return;
    }

    document.getElementById('drop-zone').style.display = 'none';
    document.getElementById('upload-progress').style.display = 'block';

    let formData = new FormData();
    formData.append('file', file);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('share.upload') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('upload-progress').style.display = 'none';
        if (data.success) {
            document.getElementById('generated-pin').innerText = data.pin;
            document.getElementById('upload-success').style.display = 'block';
        } else {
            alert('আপলোডে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
            resetUpload();
        }
    })
    .catch(error => {
        document.getElementById('upload-progress').style.display = 'none';
        alert('কোনো একটি সমস্যা হয়েছে।');
        resetUpload();
        console.error(error);
    });
}

function resetUpload() {
    document.getElementById('file-input').value = '';
    document.getElementById('upload-success').style.display = 'none';
    document.getElementById('upload-progress').style.display = 'none';
    document.getElementById('drop-zone').style.display = 'block';
}
</script>
@endsection
