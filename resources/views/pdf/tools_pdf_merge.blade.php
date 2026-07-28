@extends('layouts.app')

@section('title', 'পিডিএফ মার্জ - penghor.com')

@section('content')
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    .file-list { margin-top: 15px; text-align: left; background: rgba(0,0,0,0.05); padding: 15px; border-radius: 8px; }
    .file-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.1); color: var(--text-color); }
    .file-item:last-child { border-bottom: none; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-cyan" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(6, 182, 212, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">call_merge</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ মার্জ (PDF Merge)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">একাধিক পিডিএফ ফাইল একসাথে জোড়া লাগিয়ে একটি পিডিএফ তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 40px; text-align: center;">
        <div class="form-group">
            <label class="form-label" style="display: block; margin-bottom: 15px;">একাধিক পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf" multiple onchange="listFiles()" style="max-width: 400px; margin: 0 auto;">
        </div>

        <div id="file-list-container" class="file-list" style="display: none;">
            <h4 style="margin-bottom: 10px;">সিলেক্ট করা ফাইলসমূহ:</h4>
            <div id="files-wrapper"></div>
            <small style="color: #ef4444; margin-top: 10px; display: block;">* ফাইলগুলো এই ক্রমানুসারেই (Serial) জোড়া লাগবে।</small>
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; font-weight: bold;">
            ফাইল জোড়া লাগানো হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="mergePdfs()" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 30px; display: none;">
            <i class="material-icons-round">merge_type</i> মার্জ করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    let selectedFiles = [];

    function listFiles() {
        const input = document.getElementById('pdf-upload');
        selectedFiles = Array.from(input.files);

        if (selectedFiles.length === 0) {
            document.getElementById('file-list-container').style.display = 'none';
            document.getElementById('process-btn').style.display = 'none';
            return;
        }

        const wrapper = document.getElementById('files-wrapper');
        wrapper.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            wrapper.innerHTML += `
                <div class="file-item">
                    <span><strong>${index + 1}.</strong> ${file.name}</span>
                </div>
            `;
        });

        document.getElementById('file-list-container').style.display = 'block';
        if (selectedFiles.length > 1) {
            document.getElementById('process-btn').style.display = 'block';
        } else {
            document.getElementById('process-btn').style.display = 'none';
            Swal.fire('মার্জ করার জন্য অন্তত ২টি পিডিএফ ফাইল নির্বাচন করুন।');
        }
    }

    async function mergePdfs() {
        if (selectedFiles.length < 2) return;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const mergedPdf = await PDFLib.PDFDocument.create();

            for (const file of selectedFiles) {
                const arrayBuffer = await file.arrayBuffer();
                const pdf = await PDFLib.PDFDocument.load(arrayBuffer);
                const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                copiedPages.forEach((page) => {
                    mergedPdf.addPage(page);
                });
            }

            const mergedPdfBytes = await mergedPdf.save();

            // Download
            const blob = new Blob([mergedPdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Merged_Document.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে পিডিএফ মার্জ করা হয়েছে!');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ মার্জ করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'block';
        }
    }
</script>
@endsection
