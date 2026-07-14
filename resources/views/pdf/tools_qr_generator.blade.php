@extends('layouts.app')

@section('title', 'কিউআর কোড জেনারেটর - Smart Stationary')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .qr-container { display: flex; justify-content: center; margin-top: 20px; background: #fff; padding: 20px; border-radius: 10px; width: max-content; margin: 20px auto; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-green" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">qr_code_2</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem;">কিউআর কোড জেনারেটর</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো টেক্সট বা লিংকের জন্য কিউআর কোড তৈরি করুন</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label">টেক্সট বা লিংক লিখুন</label>
            <input type="text" id="qr-text" class="form-control" placeholder="https://google.com">
        </div>
        
        <button class="btn btn-primary" onclick="generateQR()" style="width: 100%; padding: 15px;">
            <i class="material-icons-round">qr_code</i> জেনারেট করুন
        </button>

        <div id="qr-result" style="display: none; text-align: center; margin-top: 30px;">
            <div class="qr-container" id="qrcode"></div>
            <button class="btn btn-outline" onclick="downloadQR()" style="margin-top: 15px;">
                <i class="material-icons-round">download</i> ডাউনলোড
            </button>
        </div>
    </div>
</div>

<script>
    let qrcodeObj = null;

    function generateQR() {
        const text = document.getElementById('qr-text').value;
        if (!text) return alert('টেক্সট বা লিংক দিন');
        
        const container = document.getElementById('qrcode');
        container.innerHTML = '';
        
        qrcodeObj = new QRCode(container, {
            text: text,
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        
        document.getElementById('qr-result').style.display = 'block';
    }

    function downloadQR() {
        const img = document.querySelector('#qrcode img');
        if (!img) return;
        const link = document.createElement('a');
        link.href = img.src;
        link.download = 'qrcode.png';
        link.click();
    }
</script>
@endsection
