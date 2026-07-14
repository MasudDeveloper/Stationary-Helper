@extends('layouts.app')

@section('title', 'পিডিএফ রিপেয়ার - Smart Stationary')

@section('content')
<!-- PDF-lib -->
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-red" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">build_circle</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ রিপেয়ার (PDF Repair)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">ওপেন হচ্ছে না বা এরর (Error) দেখাচ্ছে এমন নষ্ট পিডিএফ ফাইল রিপেয়ার বা মেরামত করুন।</p>
    </div>

    <div class="glass" style="padding: 40px; text-align: center;">
        
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 15px; border-radius: 10px; margin-bottom: 30px; text-align: left;">
            <strong><i class="material-icons-round" style="vertical-align: middle;">healing</i> কাজ করার পদ্ধতি</strong><br>
            আপনার আপলোড করা পিডিএফের ভেতরের স্ট্রাকচার (XRef Tables, Streams) স্ক্যান করে এররগুলো ফিক্স করা হবে এবং একটি নতুন ফ্রেশ পিডিএফ ফাইল হিসেবে সেভ করা হবে।
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">নষ্ট বা করাপ্টেড (Corrupted) পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" style="max-width: 400px; margin: 0 auto;">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; font-weight: bold;">
            পিডিএফ রিপেয়ার করা হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="repairPdf()" style="padding: 15px 40px; font-size: 1.1rem;">
            <i class="material-icons-round">build</i> পিডিএফ রিপেয়ার করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    async function repairPdf() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];

        if (!file) {
            alert('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            
            // Loading and parsing the PDF often fixes minor structural corruptions automatically in pdf-lib
            const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer, { 
                ignoreEncryption: true 
            });

            // Save builds a clean, standardized PDF structure from scratch
            const newPdfBytes = await pdfDoc.save();

            // Download
            const blob = new Blob([newPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Repaired_Document.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            alert('সফলভাবে পিডিএফ রিপেয়ার করা হয়েছে!');

        } catch (error) {
            console.error(error);
            alert('দুঃখিত, এই পিডিএফ ফাইলটি অনেক বেশি নষ্ট হয়ে গেছে যা অটোমেটিক রিপেয়ার করা সম্ভব নয়।');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
