@extends('layouts.app')

@section('title', 'ওয়ার্ড টু পিডিএফ - Smart Stationary')

@section('content')
<!-- Mammoth.js for Word to HTML -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
<!-- html2pdf for HTML to PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
    #doc-preview { display: none; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #ddd; text-align: left; max-height: 500px; overflow-y: auto; color: #000; margin-bottom: 20px; }
    #doc-preview p { margin-bottom: 10px; line-height: 1.5; }
    #doc-preview table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    #doc-preview th, #doc-preview td { border: 1px solid #000; padding: 5px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-blue" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">picture_as_pdf</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">ওয়ার্ড টু পিডিএফ (Word to PDF)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো মাইক্রোসফট ওয়ার্ড ফাইল (.docx) থেকে এক ক্লিকেই পিডিএফ তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 40px; text-align: center;">
        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label" style="display: block; margin-bottom: 15px;">ওয়ার্ড ফাইল (.docx) নির্বাচন করুন</label>
            <input type="file" id="word-upload" class="form-control" accept=".docx" style="max-width: 400px; margin: 0 auto;" onchange="previewWord()">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; font-weight: bold;">
            প্রসেস করা হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <!-- Hidden container that holds the HTML for PDF generation -->
        <div id="doc-preview"></div>

        <button id="process-btn" class="btn btn-primary" onclick="convertToPdf()" style="width: 100%; padding: 15px; font-size: 1.1rem; display: none;">
            <i class="material-icons-round">file_download</i> পিডিএফ তৈরি করে ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    let extractedHtml = '';
    let fileName = 'Converted_Document.pdf';

    function previewWord() {
        const fileInput = document.getElementById('word-upload');
        const file = fileInput.files[0];

        if (!file) return;
        
        fileName = file.name.replace('.docx', '.pdf');

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';
        document.getElementById('doc-preview').style.display = 'none';

        const reader = new FileReader();
        reader.onload = function(loadEvent) {
            const arrayBuffer = loadEvent.target.result;

            mammoth.convertToHtml({ arrayBuffer: arrayBuffer })
                .then(function(result) {
                    extractedHtml = result.value; // The generated HTML
                    const messages = result.messages; // Any messages/warnings
                    
                    document.getElementById('doc-preview').innerHTML = extractedHtml;
                    
                    document.getElementById('loading').style.display = 'none';
                    // We don't show the preview to the user because it might look slightly unstyled, we just let them click download
                    // document.getElementById('doc-preview').style.display = 'block'; 
                    document.getElementById('process-btn').style.display = 'inline-block';
                })
                .catch(function(error) {
                    console.error(error);
                    alert('ওয়ার্ড ফাইলটি রিড করতে সমস্যা হয়েছে। শুধুমাত্র .docx ফাইল সাপোর্ট করে।');
                    document.getElementById('loading').style.display = 'none';
                });
        };
        reader.readAsArrayBuffer(file);
    }

    function convertToPdf() {
        if (!extractedHtml) return;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        // We wrap the html in a div with proper padding for the PDF
        const element = document.createElement('div');
        element.innerHTML = extractedHtml;
        element.style.padding = '20px';
        element.style.color = '#000';
        element.style.fontFamily = 'Arial, sans-serif';
        element.style.lineHeight = '1.5';

        // PDF Generation options
        const opt = {
            margin:       15,
            filename:     fileName,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Generate PDF
        html2pdf().set(opt).from(element).save().then(() => {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
            alert('সফলভাবে পিডিএফ তৈরি করা হয়েছে!');
        }).catch(err => {
            console.error(err);
            alert('পিডিএফ ডাউনলোড করতে সমস্যা হয়েছে।');
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        });
    }
</script>
@endsection
