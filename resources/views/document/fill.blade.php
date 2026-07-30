@php
$pageSize = strtolower($template->page_size ?? 'a4');
$orientation = strtolower($template->page_orientation ?? 'portrait');

$pageWidth = '210mm';
$pageHeight = '297mm';

if ($pageSize == 'legal') {
$pageWidth = '216mm';
$pageHeight = '356mm';
} elseif ($pageSize == 'letter') {
$pageWidth = '216mm';
$pageHeight = '279mm';
}

if ($orientation == 'landscape') {
$temp = $pageWidth;
$pageWidth = $pageHeight;
$pageHeight = $temp;
}

$marginTop = $template->margin_top ?? 10;
$marginBottom = $template->margin_bottom ?? 20;
$marginLeft = $template->margin_left ?? 20;
$marginRight = $template->margin_right ?? 20;
@endphp
<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }} - penghor.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Base Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #111827;
            overflow: hidden;
        }

        .layout-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Left Side: Document Preview */
        .doc-preview-pane {
            flex: 1;
            overflow: auto;
            /* Allows scrolling in both directions */
            padding: 40px;
        }

        .a4-paper {
            background: #fff;
            width: var(--page-w, 210mm);
            min-height: var(--page-h, 297mm);
            padding: var(--page-p, 10mm 20mm 20mm 20mm);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: 'Kalpurush', Arial, sans-serif;
            font-size: 16pt;
            line-height: 1.6;
            color: #000;
            margin: 0 auto;
            position: relative;
        }

        .placeholder-highlight {
            background-color: #e0f2fe;
            /* sky-100 */
            color: #0369a1;
            /* sky-700 */
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px dashed #7dd3fc;
            font-weight: inherit;
            font-family: inherit;
            font-size: inherit;
        }

        body.no-watermark .placeholder-highlight {
            background-color: transparent !important;
            color: #000000 !important;
            padding: 0 !important;
            border: none !important;
            font-weight: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
        }

        /* Right Side: Form Sidebar */
        .form-sidebar {
            width: 450px;
            background: #fff;
            border-left: 1px solid #e5e7eb;
            transition: width 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .form-sidebar.collapsed {
            width: 0;
            border-left: none;
        }

        .sidebar-content {
            width: 450px;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-btn {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .close-btn:hover {
            background: #dc2626;
        }

        .sidebar-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .form-control, .dynamic-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: 'Inter', 'Kalpurush', Arial, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .form-control:focus, .dynamic-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .form-control:hover, .dynamic-input:hover {
            border-color: #94a3b8;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        /* Toggle Sidebar Button */
        .toggle-sidebar-btn {
            position: absolute;
            left: -40px;
            top: 20px;
            width: 40px;
            height: 40px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-right: none;
            border-radius: 8px 0 0 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 15;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.05);
            color: #374151;
        }

        .toggle-sidebar-btn:hover {
            background: #f9fafb;
        }

        .watermark {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-content: space-around;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99;
            pointer-events: none;
            opacity: 0.16;
            overflow: hidden;
        }

        .watermark-item {
            font-size: 32px;
            font-weight: 900;
            color: #000000;
            font-family: 'Inter', Arial, sans-serif;
            transform: rotate(-35deg);
            user-select: none;
            white-space: nowrap;
            padding: 10px 20px;
            border: 2px dashed rgba(0, 0, 0, 0.35);
            border-radius: 10px;
            margin: 25px;
            letter-spacing: 2px;
        }

        body.no-watermark .watermark {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .form-sidebar {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                box-shadow: -4px 0 15px rgba(0, 0, 0, 0.1);
            }
        }

        /* Print Styles */
        @media print {
            body,
            html {
                margin: 0;
                padding: 0;
                background: #ffffff !important;
                color: #000000 !important;
                height: auto;
                overflow: visible;
            }

            .layout-wrapper {
                display: block;
                height: auto;
                overflow: visible;
                background: #ffffff !important;
            }

            .form-sidebar,
            .toggle-sidebar-btn {
                display: none !important;
            }

            .doc-preview-pane {
                padding: 0;
                overflow: visible;
                display: block;
            }

            .a4-paper {
                margin: 0;
                padding: var(--page-p, 10mm 20mm 20mm 20mm);
                box-shadow: none;
                width: var(--page-w, 210mm);
                min-height: auto;
                background: #ffffff !important;
                color: #000000 !important;
                position: relative !important;
            }

            .placeholder-highlight {
                background-color: transparent !important;
                color: #000000 !important;
                padding: 0 !important;
                border: none !important;
                font-weight: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
            }

            .watermark {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: space-around !important;
                align-content: space-around !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                z-index: 99 !important;
                pointer-events: none !important;
                opacity: 0.16 !important;
                overflow: hidden !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .watermark-item {
                font-size: 32px !important;
                font-weight: 900 !important;
                color: #000000 !important;
                font-family: 'Inter', Arial, sans-serif !important;
                transform: rotate(-35deg) !important;
                user-select: none !important;
                white-space: nowrap !important;
                padding: 10px 20px !important;
                border: 2px dashed rgba(0, 0, 0, 0.35) !important;
                border-radius: 10px !important;
                margin: 25px !important;
                letter-spacing: 2px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body.no-watermark .watermark {
                display: none !important;
            }
        }
    </style>
    @php
    echo '<style>@media print { @page { size: ' . $pageSize . ' ' . $orientation . '; margin: 0; } }</style>';
    @endphp
</head>

<body class="no-watermark">

    <div class="layout-wrapper">
        <!-- Document Preview -->
        <div class="doc-preview-pane">
            <div class="a4-paper" id="printable-doc" data-size="{{ $pageSize }}" data-orientation="{{ $orientation }}" style="--page-w: {{ $pageWidth }}; --page-h: {{ $pageHeight }}; --page-p: {{ $marginTop }}mm {{ $marginRight }}mm {{ $marginBottom }}mm {{ $marginLeft }}mm;">
                @php
                $previewContent = $template->content;
                foreach ($fields as $field) {
                $previewContent = str_replace('['.$field.']', '<span class="placeholder-highlight" data-field="'.$field.'">'.$field.'</span>', $previewContent);
                }
                @endphp
                {!! $previewContent !!}
            </div>
        </div>

        <!-- Form Sidebar -->
        <div class="form-sidebar" id="form-sidebar">
            <button class="toggle-sidebar-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
                <i class="material-icons-round" id="toggle-icon">chevron_right</i>
            </button>

            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div>
                        <h3 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 2px; color: #111827;">{{ $template->name }}</h3>
                        <p style="color: #6b7280; font-size: 0.85rem;">ফরমটি পূরণ করুন</p>
                    </div>
                    <!-- Back/Close Button -->
                    <a href="{{ route('document.index') }}" class="close-btn" title="Back to Documents">
                        <i class="material-icons-round" style="font-size: 18px;">close</i>
                    </a>
                </div>

                <div class="sidebar-body">
                    @foreach($fields as $field)
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 500; color: #374151; font-size: 0.9rem; margin-bottom: 5px; display: block;">
                            {{ str_replace('-', ' ', Str::title($field)) }}
                        </label>
                        <input type="text" class="form-control dynamic-input" data-target="{{ $field }}" placeholder="Enter {{ str_replace('-', ' ', $field) }}" value="{{ $savedData[$field] ?? '' }}" oninput="updatePreview(this)">
                    </div>
                    @endforeach
                </div>

                <div class="sidebar-footer">
                    <div style="display: flex; gap: 10px; flex-direction: column;">
                        <button onclick="printDemo()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600; background: #6b7280;">
                            <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">visibility</i> ডেমো দেখুন (জলছাপ সহ)
                        </button>
                        <button id="saveDocBtn" data-id="{{ $template->id }}" data-type="document" data-title="{{ $template->name }}" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600; background: #4f46e5; color: #fff;">
                            <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">save</i> সংরক্ষণ করুন (Save)
                        </button>
                        <button id="finalPrintBtn" data-id="{{ $template->id }}" data-cost="{{ $template->credit_cost ?? 5 }}" data-name="{{ $template->name }}" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600;">
                            <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">print</i> ফাইনাল প্রিন্ট/সেভ (ক্রেডিট লাগবে)
                        </button>
                        @if((\App\Models\Setting::where('key', 'whatsapp_module_status')->value('value') ?? 'enabled') === 'enabled')
                        <button id="whatsappBtn" data-id="{{ $template->id }}" data-cost="{{ $whatsappCost ?? 5 }}" data-name="{{ $template->name }}" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600; background: #25D366; color: #fff;">
                            <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">chat</i> WhatsApp-এ পাঠান
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('form-sidebar');
            const icon = document.getElementById('toggle-icon');
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                icon.innerText = 'chevron_left';
            } else {
                icon.innerText = 'chevron_right';
            }
        }

        function updatePreview(inputElement) {
            const fieldName = inputElement.getAttribute('data-target');
            const value = inputElement.value;

            // Find all spans with this field name
            const spans = document.querySelectorAll(`.placeholder-highlight[data-field="${fieldName}"]`);

            spans.forEach(span => {
                if (value.trim() === '') {
                    // If empty, show the placeholder name again and keep highlight
                    span.innerText = fieldName;
                    span.classList.add('placeholder-highlight');
                } else {
                    // If filled, show the value
                    span.innerText = value;
                }
            });
        }

        // Initialize: check screen size for default collapse & pre-fill inputs
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth <= 900) {
                toggleSidebar(); // Auto-collapse on small screens
            }

            document.querySelectorAll('.dynamic-input').forEach(input => {
                if (input.value) updatePreview(input);
            });

            // Add watermark div inside the A4 paper container
            const watermarkDiv = document.createElement('div');
            watermarkDiv.className = 'watermark';
            let wmHtml = '';
            for (let i = 0; i < 6; i++) {
                wmHtml += '<div class="watermark-item">penghor.com</div>';
            }
            watermarkDiv.innerHTML = wmHtml;
            const paperDoc = document.getElementById('printable-doc');
            if (paperDoc) {
                paperDoc.appendChild(watermarkDiv);
            } else {
                document.body.appendChild(watermarkDiv);
            }

            // Attach click listeners to buttons to avoid inline Blade evaluation in attributes
            const finalPrintBtn = document.getElementById('finalPrintBtn');
            if (finalPrintBtn) {
                finalPrintBtn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const cost = this.getAttribute('data-cost');
                    const name = this.getAttribute('data-name');
                    finalPrint(id, cost, name);
                });
            }

            const whatsappBtn = document.getElementById('whatsappBtn');
            if (whatsappBtn) {
                whatsappBtn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const cost = this.getAttribute('data-cost');
                    const name = this.getAttribute('data-name');
                    sendViaWhatsApp(id, cost, name);
                });
            }

            const saveDocBtn = document.getElementById('saveDocBtn');
            if (saveDocBtn) {
                saveDocBtn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const title = this.getAttribute('data-title');
                    saveDocument(id, type, title);
                });
            }
        });

        async function saveDocument(id, type, defaultTitle) {
            const { value: title } = await Swal.fire({
                title: 'ডকুমেন্ট সংরক্ষণ করুন',
                input: 'text',
                inputLabel: 'ডকুমেন্টের একটি নাম দিন',
                inputValue: defaultTitle,
                showCancelButton: true,
                confirmButtonText: 'সংরক্ষণ করুন',
                cancelButtonText: 'বাতিল',
                inputValidator: (value) => {
                    if (!value) return 'নাম দিতে হবে!';
                }
            });

            if (!title) return;

            const formData = {};
            document.querySelectorAll('.dynamic-input').forEach(input => {
                const target = input.getAttribute('data-target');
                formData[target] = input.value;
            });

            const btn = document.getElementById('saveDocBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="material-icons-round" style="vertical-align: middle; animation: spin 1s linear infinite;">sync</i> সংরক্ষণ হচ্ছে...';
            btn.disabled = true;

            try {
                const response = await fetch(`/saved-documents`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        template_id: id,
                        type: type,
                        title: title,
                        form_data: formData
                    })
                });
                const data = await response.json();
                if (data.success) {
                    Swal.fire('সফল!', data.message, 'success');
                } else {
                    Swal.fire('ত্রুটি!', 'সংরক্ষণ করা সম্ভব হয়নি।', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('ত্রুটি!', 'সার্ভার এরর হয়েছে।', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        function printDemo() {
            document.body.classList.remove('no-watermark');
            window.print();
            setTimeout(() => {
                document.body.classList.add('no-watermark');
            }, 1000);
            window.addEventListener('afterprint', () => {
                document.body.classList.add('no-watermark');
            }, { once: true });
        }

        async function finalPrint(id, creditCost, templateName = 'Document') {
            if (creditCost > 0) {
            const result = await Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: `ফাইনাল প্রিন্ট করার জন্য আপনার অ্যাকাউন্ট থেকে ${creditCost} ক্রেডিট কাটা হবে।`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, প্রিন্ট করুন',
                cancelButtonText: 'বাতিল'
            });

            if (!result.isConfirmed) {
                return;
                }
            }

            const btn = document.getElementById('finalPrintBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = 'অপেক্ষা করুন...';
            btn.disabled = true;

            try {
                const response = await fetch(`/documents/${id}/deduct-credit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Ensure watermark is hidden
                    document.body.classList.add('no-watermark');

                    // Show success alert briefly without blocking
                    Swal.fire({
                        title: 'সফল!',
                        text: 'ক্রেডিট কাটা হয়েছে! ফাইল সেভ ও প্রিন্ট হচ্ছে...',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    // 1. Automatically save/download PDF to user's computer
                    const element = document.getElementById('printable-doc');
                    const opt = {
                        margin: 0,
                        filename: templateName + '.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2, useCORS: true },
                        jsPDF: {
                            unit: 'mm',
                            format: element ? (element.getAttribute('data-size') || 'a4') : 'a4',
                            orientation: element ? (element.getAttribute('data-orientation') || 'portrait') : 'portrait'
                        }
                    };

                    setTimeout(() => {
                        Swal.close();
                        if (typeof html2pdf !== 'undefined' && element) {
                            html2pdf().set(opt).from(element).save();
                        }
                        // 2. Open print dialog after 500ms
                        setTimeout(() => {
                            window.print();
                        }, 500);
                    }, 1200);
                } else {
                    Swal.fire('দুঃখিত!', data.message || 'ক্রেডিট কাটাতে সমস্যা হয়েছে।', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('ত্রুটি!', 'সার্ভার এরর। আবার চেষ্টা করুন।', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        async function sendViaWhatsApp(id, creditCost, templateName) {
            const phone = await Swal.fire({
                title: 'WhatsApp Number',
                input: 'text',
                inputLabel: 'কাস্টমারের হোয়াটসঅ্যাপ নম্বর দিন',
                inputPlaceholder: 'যেমন: 017XXXXXXXX',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) return 'নম্বর দিতে হবে!';
                }
            });

            if (!phone.isConfirmed || !phone.value) return;

            if (creditCost > 0) {
                const confirmResp = await Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: `ফাইলটি WhatsApp-এ পাঠানোর জন্য আপনার অ্যাকাউন্ট থেকে ${creditCost} ক্রেডিট কাটা হবে।`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, সেন্ড করুন',
                cancelButtonText: 'বাতিল'
            });

            if (!confirmResp.isConfirmed) return;
            }

            const btn = document.getElementById('whatsappBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="material-icons-round spin" style="vertical-align: middle;">sync</i> জেনারেট হচ্ছে...';
            btn.disabled = true;

            try {
                // Remove watermark temporarily for PDF generation
                document.body.classList.add('no-watermark');

                const element = document.getElementById('printable-doc');

                // Configure html2pdf
                const opt = {
                    margin: 0, // We are handling margin with CSS padding
                    filename: templateName + '.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2,
                        useCORS: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: element.getAttribute('data-size') || 'a4',
                        orientation: element.getAttribute('data-orientation') || 'portrait'
                    }
                };

                // Generate PDF as base64 string
                const pdfBase64 = await html2pdf().set(opt).from(element).output('datauristring');

                // Restore watermark if needed
                document.body.classList.remove('no-watermark');

                btn.innerHTML = '<i class="material-icons-round spin" style="vertical-align: middle;">sync</i> পাঠানো হচ্ছে...';

                // Send to server
                const response = await fetch(`/documents/${id}/send-whatsapp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        phone: phone.value,
                        pdf_base64: pdfBase64,
                        filename: templateName
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire('সফল!', 'কাস্টমারের WhatsApp-এ ফাইল পাঠানো হয়েছে।', 'success');
                } else {
                    Swal.fire('ত্রুটি!', data.message || 'ফাইল পাঠানো সম্ভব হয়নি।', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('ত্রুটি!', 'সার্ভার এরর। আবার চেষ্টা করুন।', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>

</html>

