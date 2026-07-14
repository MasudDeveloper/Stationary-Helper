@extends('layouts.app')

@section('title', 'এডিটর - Smart Stationary')

@section('content')
<!-- Quill Core CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Html2Pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .editor-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .editor-sidebar {
        width: 100%;
        flex-shrink: 0;
    }
    
    .editor-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border-color);
        padding: 40px 20px;
        border-radius: 12px;
        overflow-y: auto;
        overflow-x: auto;
        max-height: calc(100vh - 150px);
    }
    
    /* Document Page Sizes */
    .doc-page {
        background: #fff;
        color: #000;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        margin-bottom: 20px;
        position: relative;
        max-width: 100%;
    }
    
    /* Sizes in mm, scaled for screen (approximate representation) */
    .size-a4 { width: 210mm; min-height: 297mm; }
    .size-a3 { width: 297mm; min-height: 420mm; }
    .size-letter { width: 216mm; min-height: 279mm; }
    .size-legal { width: 216mm; min-height: 356mm; }
    
    .ql-toolbar {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color) !important;
        border-radius: 8px 8px 0 0;
        backdrop-filter: blur(10px);
    }
    
    .ql-toolbar button, .ql-toolbar .ql-picker {
        color: var(--text-main) !important;
    }
    
    .ql-toolbar .ql-stroke {
        stroke: var(--text-main) !important;
    }
    
    .ql-toolbar .ql-fill {
        fill: var(--text-main) !important;
    }
    
    .ql-toolbar .ql-picker-options {
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
    }
    
    .ql-container {
        border: none !important;
        font-family: 'Inter', sans-serif;
    }
    
    .ql-editor {
        padding: 20mm; /* Default margin */
    }


</style>

<div class="editor-wrapper">
    <!-- Sidebar -->
    <div class="editor-sidebar">
        <div class="glass" style="padding: 25px; position: sticky; top: 20px;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                <i class="material-icons-round">settings</i> সেটিংস
            </h3>
            
            <div class="form-group">
                <label class="form-label">পৃষ্ঠার আকার (Page Size)</label>
                <select id="pageSize" class="form-control" onchange="updatePageSetup()">
                    <option value="a4">A4 (210 x 297 mm)</option>
                    <option value="a3">A3 (297 x 420 mm)</option>
                    <option value="letter">Letter (216 x 279 mm)</option>
                    <option value="legal">Legal (216 x 356 mm)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">মার্জিন (Margin)</label>
                <select id="pageMargin" class="form-control" onchange="updatePageSetup()">
                    <option value="20mm">Standard (20mm)</option>
                    <option value="10mm">Narrow (10mm)</option>
                    <option value="30mm">Wide (30mm)</option>
                </select>
            </div>
            
            <hr style="border-color: var(--border-color); margin: 20px 0;">
            
            <button onclick="downloadPDF()" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                <i class="material-icons-round">download</i> ডাউনলোড PDF
            </button>
            <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; line-height: 1.5;">
                নোট: ফাইনাল ডাউনলোডে আপনার একাউন্ট থেকে ক্রেডিট কাটা হতে পারে।
            </p>
        </div>
    </div>
    
    <!-- Main Editor -->
    <div class="editor-main">
        <div style="width: 100%; max-width: 210mm; position: sticky; top: 0; z-index: 10;">
            <div id="toolbar-container"></div>
        </div>
        
        <div id="document-container" class="doc-page size-a4 mt-4">
            <div id="editor">
                {!! isset($template) ? $template->content : '<p>এখানে টাইপ করা শুরু করুন...</p>' !!}
            </div>
        </div>
    </div>
</div>

<!-- Quill Core JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean']                                         // remove formatting button
    ];

    var quill = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });
    
    // Move toolbar to sticky container
    const toolbar = document.querySelector('.ql-toolbar');
    document.getElementById('toolbar-container').appendChild(toolbar);

    function updatePageSetup() {
        const size = document.getElementById('pageSize').value;
        const margin = document.getElementById('pageMargin').value;
        
        const docContainer = document.getElementById('document-container');
        
        // Reset classes
        docContainer.className = 'doc-page mt-4 size-' + size;
        
        // Set Toolbar width to match page
        const toolbarContainer = document.getElementById('toolbar-container').parentElement;
        if(size === 'a4') toolbarContainer.style.maxWidth = '210mm';
        else if(size === 'a3') toolbarContainer.style.maxWidth = '297mm';
        else if(size === 'letter' || size === 'legal') toolbarContainer.style.maxWidth = '216mm';
        
        // Update padding/margin in editor
        document.querySelector('.ql-editor').style.padding = margin;
    }
    
    function downloadPDF() {
        // Just client side generation for now.
        var element = document.getElementById('document-container');
        var opt = {
            margin:       0,
            filename:     'SmartStationary_Document.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'mm', format: document.getElementById('pageSize').value, orientation: 'portrait' }
        };

        // Hide toolbar borders etc for print
        document.querySelector('.ql-editor').style.border = 'none';
        
        html2pdf().set(opt).from(element).save().then(() => {
            document.querySelector('.ql-editor').style.border = '';
        });
    }
</script>
@endsection
