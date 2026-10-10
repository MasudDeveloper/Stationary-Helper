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

// Calculate pdfPageHeight as exactly 1mm shorter than pageHeight to prevent browser rounding overflows
$pdfPageHeight = (intval(filter_var($pageHeight, FILTER_SANITIZE_NUMBER_INT)) - 1) . 'mm';

$marginTopInch = $template->margin_top ?? 1.0;
$marginBottomInch = $template->margin_bottom ?? 1.0;
$marginLeftInch = $template->margin_left ?? 1.0;
$marginRightInch = $template->margin_right ?? 1.0;


@endphp
<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $template->name }} - penghor.com</title>
    <!-- Google Fonts including Bangla Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @font-face {
            font-family: 'Kalpurush';
            src: url('https://cdn.jsdelivr.net/gh/rohit-singh-dev/bangla-fonts@main/Kalpurush.ttf') format('truetype');
            font-display: swap;
        }
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('https://cdn.jsdelivr.net/gh/rohit-singh-dev/bangla-fonts@main/SolaimanLipi.ttf') format('truetype');
            font-display: swap;
        }

        /* Base Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Hind Siliguri', 'Noto Sans Bengali', 'Inter', sans-serif;
            background: #f3f4f6;
            color: #111827;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        .layout-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Mobile Top Bar */
        .mobile-top-bar {
            display: none;
            background: #0f172a;
            color: #ffffff;
            padding: 10px 14px;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .mobile-top-title {
            font-size: 0.95rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        .mobile-nav-pills {
            display: flex;
            gap: 6px;
        }

        .mobile-pill-btn {
            background: rgba(255, 255, 255, 0.12);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .mobile-pill-btn.active {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }

        /* Left Side: Document Preview */
        .doc-preview-pane {
            flex: 1;
            overflow: auto;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            background: #e2e8f0;
        }

        .page-scale-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: var(--page-w, 210mm);
            max-width: var(--page-w, 210mm);
            min-width: var(--page-w, 210mm);
            margin: 0 auto;
            transition: transform 0.2s ease;
        }

        .a4-paper {
            background: #fff;
            width: var(--page-w, 210mm);
            height: var(--page-h, 297mm);
            overflow: hidden;
            padding-top: var(--page-margin-top, 1.0in) !important;
            padding-bottom: var(--page-margin-bottom, 1.0in) !important;
            padding-left: var(--page-margin-left, 1.0in) !important;
            padding-right: var(--page-margin-right, 1.0in) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            font-family: 'Kalpurush', 'Hind Siliguri', 'Noto Sans Bengali', 'SolaimanLipi', Arial, sans-serif;
            font-size: 16pt;
            line-height: 1.6;
            color: #000;
            margin: 0 auto 30px auto;
            position: relative;
            outline: none;
            page-break-after: always;
            break-after: page;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .a4-paper * {
            box-sizing: border-box;
        }

        .a4-paper img,
        .a4-paper table {
            max-width: 100% !important;
        }

        .a4-paper:last-child {
            margin-bottom: 0;
            page-break-after: avoid;
            break-after: avoid;
        }

        /* PDF Generation Overrides */
        #printable-doc-container.pdf-generation .a4-paper {
            margin: 0 auto !important;
            box-shadow: none !important;
            height: {{ $pdfPageHeight }} !important;
            overflow: hidden !important;
            transform: none !important;
        }

        @media print {
            #printable-doc-container {
                background: transparent !important;
            }

            .a4-paper {
                margin: 0 !important;
                box-shadow: none !important;
                width: var(--page-w) !important;
                height: auto !important;
                min-height: 0 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: avoid !important;
                break-after: avoid !important;
                transform: none !important;
            }

            .a4-paper+.a4-paper {
                page-break-before: always !important;
                break-before: page !important;
            }
        }

        .placeholder-highlight {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px dashed #7dd3fc;
            font-weight: inherit;
            font-family: inherit;
            font-size: inherit;
        }

        body.no-watermark .placeholder-highlight {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px dashed #7dd3fc;
        }

        body.pdf-generation .placeholder-highlight {
            background-color: transparent !important;
            color: #000000 !important;
            padding: 0 !important;
            border: none !important;
            font-weight: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
        }

        .bijoy-label-auto,
        .bijoy-label-force {
            font-family: 'SutonnyMJ', 'Sutonnymj', 'Kalpurush', Arial, sans-serif !important;
            font-size: 1.15rem !important;
        }

        /* Right Side: Form Sidebar */
        .form-sidebar {
            width: 450px;
            background: #fff;
            border-left: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .form-sidebar.collapsed {
            width: 0;
            border-left: none;
            overflow: hidden;
        }

        .sidebar-content {
            width: 450px;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #f8fafc;
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

        .field-label {
            font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
            line-height: 1.4;
        }

        .form-control,
        .dynamic-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: 'Kalpurush', 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .form-control:focus,
        .dynamic-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .form-control:hover,
        .dynamic-input:hover {
            border-color: #94a3b8;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
            background: #f8fafc;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: background 0.2s;
            font-family: 'Hind Siliguri', sans-serif;
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
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: background 0.2s;
            font-family: 'Hind Siliguri', sans-serif;
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

        /* Responsive Mobile Styles */
        @media (max-width: 900px) {
            body {
                overflow: auto;
            }
            .layout-wrapper {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }
            .mobile-top-bar {
                display: flex;
            }
            .doc-preview-pane {
                padding: 15px 10px 90px 10px;
                min-height: calc(100vh - 60px);
                overflow-x: hidden;
                width: 100%;
            }
            .form-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100vw !important;
                height: 100vh !important;
                z-index: 1000;
                background: #ffffff;
                border-left: none;
                box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.2);
                transform: translateY(0);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .form-sidebar.collapsed {
                transform: translateY(100%);
                width: 100vw !important;
            }
            .sidebar-content {
                width: 100% !important;
                max-width: 100% !important;
                height: 100%;
            }
            .toggle-sidebar-btn {
                display: none;
            }
            .mobile-floating-bar {
                position: fixed;
                bottom: 16px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 990;
                display: flex;
                gap: 8px;
                background: #0f172a;
                padding: 6px 12px;
                border-radius: 30px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.35);
                border: 1px solid rgba(255,255,255,0.15);
            }
            .mobile-float-btn {
                background: rgba(255,255,255,0.1);
                color: #f8fafc;
                border: none;
                padding: 8px 14px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 5px;
                cursor: pointer;
                font-family: 'Hind Siliguri', sans-serif;
            }
            .mobile-float-btn.active {
                background: #3b82f6;
                color: #ffffff;
            }
        }

        /* Print Styles */
        @media print {

            body,
            html,
            .app-container,
            .app-content,
            .content-body {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                color: #000000 !important;
                height: auto !important;
                overflow: visible !important;
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                box-shadow: none !important;
            }

            .app-sidebar,
            .top-navbar,
            .no-print {
                display: none !important;
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
                margin: 0 !important;
                box-shadow: none !important;
                width: var(--page-w) !important;
                height: auto !important;
                min-height: 0 !important;
                background: #ffffff !important;
                color: #000000 !important;
                position: relative !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
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
    echo '<style>
        :root {
            --page-margin-top: ' . $marginTopInch . 'in;
            --page-margin-bottom: ' . $marginBottomInch . 'in;
            --page-margin-left: ' . $marginLeftInch . 'in;
            --page-margin-right: ' . $marginRightInch . 'in;
        }

        @media print {
            @page {
                size: ' . $pageSize . ' ' . $orientation . ';
                margin: 0 !important;
            }
        }
    </style>';
    @endphp

</head>

<body class="no-watermark">

    <!-- Mobile Top Navigation Bar -->
    <div class="mobile-top-bar">
        <div style="display: flex; align-items: center; gap: 8px;">
            <a href="{{ route('document.index') }}" style="color: #fff; text-decoration: none; display: flex; align-items: center;">
                <i class="material-icons-round">arrow_back</i>
            </a>
            <div class="mobile-top-title">{{ $template->name }}</div>
        </div>
        <div class="mobile-nav-pills">
            <button class="mobile-pill-btn" onclick="openMobileTab('preview')" id="mobilePillPreview">
                <i class="material-icons-round" style="font-size: 16px;">description</i> প্রিভিউ
            </button>
            <button class="mobile-pill-btn active" onclick="openMobileTab('form')" id="mobilePillForm">
                <i class="material-icons-round" style="font-size: 16px;">edit</i> তথ্য দিন
            </button>
        </div>
    </div>

    <div class="layout-wrapper">
        <!-- Document Preview -->
        <div class="doc-preview-pane" id="doc-preview-pane">
            <div class="page-scale-wrapper" id="page-scale-wrapper">
                <div id="printable-doc-container" data-size="{{ $pageSize }}" data-orientation="{{ $orientation }}" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                    @php
                    $previewContent = $template->content;
                    foreach ($fields as $field) {
                    $safeFieldId = base64_encode($field);
                    $previewContent = str_replace('['.$field.']', '<span class="placeholder-highlight" data-field="'.$safeFieldId.'">'.$field.'</span>', $previewContent);
                    }

                    // Split template content by page breaks using hash # delimiters to avoid slash escaping issues
                    $pagesContent = preg_split('#<img[^>]*class="mce-pagebreak"[^>]*>|<p[^>]*class="mce-pagebreak"[^>]*>.*?</p>|<div[^>]*class="mce-pagebreak"[^>]*>.*?</div>|<!-- pagebreak -->#is', $previewContent);
                    @endphp

                    @foreach($pagesContent as $index => $pageHtml)
                    @php
                    // Filter out empty page residues left by pagebreak tag splits
                    $stripped = trim(strip_tags($pageHtml));
                    $stripped = str_replace(['&nbsp;', "\r", "\n", "\t", ' '], '', $stripped);
                    $hasContent = !empty($stripped) || str_contains($pageHtml, '<img') || str_contains($pageHtml, '<table' ) || str_contains($pageHtml, '<iframe' ) || str_contains($pageHtml, '<hr' );
                    @endphp
                    @if($hasContent)
                    <div class="a4-paper" data-size="{{ $pageSize }}" data-orientation="{{ $orientation }}" style="--page-w: {{ $pageWidth }}; --page-h: {{ $pageHeight }};">
                        {!! $pageHtml !!}
                    </div>
                    @endif
                    @endforeach
                </div>
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
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="close-btn" onclick="openMobileTab('preview')" title="Close Drawer" style="background: #64748b;">
                        <i class="material-icons-round" style="font-size: 18px;">expand_more</i>
                    </button>
                    <a href="{{ route('document.index') }}" class="close-btn" title="Back to Documents">
                        <i class="material-icons-round" style="font-size: 18px;">close</i>
                    </a>
                </div>
            </div>

            <div class="sidebar-body">
                <!-- Global Font Toggle -->
                <div style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; background: #f1f5f9; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    <span style="font-size: 0.85rem; color: #475569; font-weight: 600;">Bijoy Font Support:</span>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; cursor: pointer; user-select: none; color: #1e293b; font-weight: 600;">
                        <input type="checkbox" id="bijoyLabelToggle" onchange="document.querySelectorAll('.field-label').forEach(el => el.classList.toggle('bijoy-label-force', this.checked))" style="accent-color: #3b82f6; width: 16px; height: 16px;">
                        Use Bijoy (SutonnyMJ)
                    </label>
                </div>

                @foreach($fields as $field)
                @php
                $safeFieldId = base64_encode($field);
                $cleanText = strip_tags($field);
                $cleanText = html_entity_decode($cleanText);

                // Heuristic: If it has extended ASCII OR contains common English-based Bijoy syllables
                $isBijoy = preg_match('/[\x80-\xFF]/', $cleanText) ||
                preg_match('/(wjLyb|wjLyB|bvg|wVKvbv|welq|ZvwiL|cÖwZôv|gva¨g|msL¨v|Rb|UvKv|wefvM|‡Rjv|_vbv|MÖvg|WvK|BDwbqb|Dct|WvKvbv)/i', $cleanText);
                $labelClass = $isBijoy ? 'field-label bijoy-label-auto' : 'field-label';
                @endphp
                <div style="margin-bottom: 20px;">
                    <label class="{{ $labelClass }}" style="font-weight: 600; color: #374151; font-size: 0.95rem; margin-bottom: 6px; display: block;">
                        {!! $field !!}
                    </label>
                    <input type="text" class="form-control dynamic-input" data-target="{{ $safeFieldId }}" data-real-key="{{ $field }}" placeholder="তথ্য লিখুন..." value="{{ $savedData[$field] ?? '' }}" oninput="updatePreview(this)">
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
                    <button id="finalPrintBtn" data-id="{{ $template->id }}" data-cost="{{ Auth::user()->hasActiveSubscription() ? 0 : ($template->credit_cost ?? 5) }}" data-name="{{ $template->name }}" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600;">
                        <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">print</i> ফাইনাল প্রিন্ট/সেভ {{ Auth::user()->hasActiveSubscription() ? '' : '(ক্রেডিট লাগবে)' }}
                    </button>
                    @if((\App\Models\Setting::where('key', 'whatsapp_module_status')->value('value') ?? 'enabled') === 'enabled')
                    <button id="whatsappBtn" data-id="{{ $template->id }}" data-cost="{{ Auth::user()->hasActiveSubscription() ? 0 : ($whatsappCost ?? 5) }}" data-name="{{ $template->name }}" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1rem; border-radius: 8px; font-weight: 600; background: #25D366; color: #fff;">
                        <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">chat</i> WhatsApp-এ পাঠান
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile Floating Bottom Action Bar -->
    <div class="mobile-floating-bar no-print">
        <button class="mobile-float-btn" onclick="openMobileTab('form')" id="mobileFloatFormBtn">
            <i class="material-icons-round" style="font-size: 18px;">edit_note</i> ফরম পূরণ
        </button>
        <button class="mobile-float-btn active" onclick="openMobileTab('preview')" id="mobileFloatPreviewBtn">
            <i class="material-icons-round" style="font-size: 18px;">visibility</i> প্রিভিউ
        </button>
        <button class="mobile-float-btn" onclick="openMobileTab('actions')" id="mobileFloatActionBtn">
            <i class="material-icons-round" style="font-size: 18px;">print</i> প্রিন্ট/সেভ
        </button>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('form-sidebar');
            const icon = document.getElementById('toggle-icon');
            sidebar.classList.toggle('collapsed');

            if (icon) {
                if (sidebar.classList.contains('collapsed')) {
                    icon.innerText = 'chevron_left';
                } else {
                    icon.innerText = 'chevron_right';
                }
            }
        }

        function openMobileTab(tabName) {
            const sidebar = document.getElementById('form-sidebar');
            const previewPill = document.getElementById('mobilePillPreview');
            const formPill = document.getElementById('mobilePillForm');
            const floatForm = document.getElementById('mobileFloatFormBtn');
            const floatPreview = document.getElementById('mobileFloatPreviewBtn');
            const floatAction = document.getElementById('mobileFloatActionBtn');

            if (tabName === 'form') {
                sidebar.classList.remove('collapsed');
                if (formPill) formPill.classList.add('active');
                if (previewPill) previewPill.classList.remove('active');
                if (floatForm) floatForm.classList.add('active');
                if (floatPreview) floatPreview.classList.remove('active');
                if (floatAction) floatAction.classList.remove('active');
            } else if (tabName === 'preview') {
                sidebar.classList.add('collapsed');
                if (previewPill) previewPill.classList.add('active');
                if (formPill) formPill.classList.remove('active');
                if (floatPreview) floatPreview.classList.add('active');
                if (floatForm) floatForm.classList.remove('active');
                if (floatAction) floatAction.classList.remove('active');
            } else if (tabName === 'actions') {
                sidebar.classList.remove('collapsed');
                if (floatAction) floatAction.classList.add('active');
                if (floatForm) floatForm.classList.remove('active');
                if (floatPreview) floatPreview.classList.remove('active');
                // Scroll sidebar body to bottom actions
                const sidebarBody = document.querySelector('.sidebar-body');
                if (sidebarBody) sidebarBody.scrollTop = sidebarBody.scrollHeight;
            }
        }

        function autoFitMobilePages() {
            const pane = document.getElementById('doc-preview-pane');
            const scaleWrapper = document.getElementById('page-scale-wrapper');
            const papers = document.querySelectorAll('.a4-paper');
            if (!pane || !scaleWrapper || papers.length === 0) return;

            if (window.innerWidth <= 900) {
                pane.style.overflowX = 'hidden';
                const paneWidth = pane.clientWidth - 10; // 5px padding left & right
                const paperWidthPx = papers[0].offsetWidth || 794; // 210mm base width

                if (paneWidth > 0 && paneWidth < paperWidthPx) {
                    const scaleFactor = paneWidth / paperWidthPx;
                    scaleWrapper.style.transform = `scale(${scaleFactor})`;
                    scaleWrapper.style.transformOrigin = 'top center';
                    
                    let totalUnscaledHeight = 0;
                    papers.forEach(p => {
                        totalUnscaledHeight += (p.offsetHeight || 1123) + 30;
                    });
                    const totalScaledHeight = totalUnscaledHeight * scaleFactor;
                    scaleWrapper.style.height = `${totalScaledHeight}px`;
                    scaleWrapper.style.marginBottom = '0px';
                } else {
                    scaleWrapper.style.transform = 'none';
                    scaleWrapper.style.height = 'auto';
                    scaleWrapper.style.marginBottom = '0px';
                }
            } else {
                scaleWrapper.style.transform = 'none';
                scaleWrapper.style.height = 'auto';
                scaleWrapper.style.marginBottom = '0px';
            }
        }

        window.addEventListener('resize', autoFitMobilePages);
        window.addEventListener('orientationchange', autoFitMobilePages);

        function updatePreview(inputElement) {
            const safeFieldId = inputElement.getAttribute('data-target');
            const value = inputElement.value;

            // Use manual attribute comparison instead of CSS selector
            // because base64 can contain '=', '+', '/' that break CSS attribute selectors
            const allSpans = document.querySelectorAll('.placeholder-highlight, [data-field]');
            allSpans.forEach(span => {
                if (span.getAttribute('data-field') !== safeFieldId) return;

                if (!span.hasAttribute('data-original')) {
                    span.setAttribute('data-original', span.innerHTML);
                }
                if (value.trim() === '') {
                    span.innerHTML = span.getAttribute('data-original');
                } else {
                    span.innerText = value;
                }

                // Keep the placeholder-highlight class always active so the user can easily spot editable fields on screen
                span.classList.add('placeholder-highlight');
            });
        }

        // Initialize: check screen size for default collapse & pre-fill inputs
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth <= 900) {
                openMobileTab('form'); // Open form drawer by default on mobile for easy form filling
            }
            autoFitMobilePages();
            setTimeout(autoFitMobilePages, 300);


            document.querySelectorAll('.dynamic-input').forEach(input => {
                if (input.value) updatePreview(input);
            });

            // Add watermark div inside each page sheet container
            document.querySelectorAll('.a4-paper').forEach(paperDoc => {
                const watermarkDiv = document.createElement('div');
                watermarkDiv.className = 'watermark';
                let wmHtml = '';
                for (let i = 0; i < 6; i++) {
                    wmHtml += '<div class="watermark-item">penghor.com</div>';
                }
                watermarkDiv.innerHTML = wmHtml;
                paperDoc.appendChild(watermarkDiv);
            });

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
            const {
                value: title
            } = await Swal.fire({
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
                const realKey = input.getAttribute('data-real-key');
                formData[realKey] = input.value;
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
            document.body.classList.add('pdf-generation'); // Hide highlights for print dialog
            window.print();
            setTimeout(() => {
                document.body.classList.add('no-watermark');
                document.body.classList.remove('pdf-generation');
            }, 1000);
            window.addEventListener('afterprint', () => {
                document.body.classList.add('no-watermark');
                document.body.classList.remove('pdf-generation');
            }, {
                once: true
            });
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
                    // Ensure watermark and highlights are hidden for generation
                    document.body.classList.add('no-watermark');
                    document.body.classList.add('pdf-generation');

                    // Show success alert briefly without blocking
                    Swal.fire({
                        title: 'সফল!',
                        text: 'ক্রেডিট কাটা হয়েছে! ফাইল সেভ ও প্রিন্ট হচ্ছে...',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    // Automatically save/download PDF to user's computer
                    const element = document.getElementById('printable-doc-container');
                    const opt = {
                        margin: 0,
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
                            format: element ? (element.getAttribute('data-size') || 'a4') : 'a4',
                            orientation: element ? (element.getAttribute('data-orientation') || 'portrait') : 'portrait'
                        },
                        pagebreak: {
                            mode: 'css'
                        }
                    };

                    setTimeout(async () => {
                        Swal.close();
                        if (typeof html2pdf !== 'undefined' && element) {
                            element.classList.add('pdf-generation');
                            await html2pdf().set(opt).from(element).save();
                            element.classList.remove('pdf-generation');
                        }

                        document.body.classList.remove('pdf-generation'); // Restore highlights

                        // Open print dialog after 500ms
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
                // Remove watermark and highlights temporarily for PDF generation
                document.body.classList.add('no-watermark');
                document.body.classList.add('pdf-generation');

                const element = document.getElementById('printable-doc-container');

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
                    },
                    pagebreak: {
                        mode: 'css'
                    }
                };

                // Generate PDF as base64 string
                element.classList.add('pdf-generation');
                const pdfBase64 = await html2pdf().set(opt).from(element).output('datauristring');
                element.classList.remove('pdf-generation');

                // Restore watermark and highlights
                document.body.classList.remove('no-watermark');
                document.body.classList.remove('pdf-generation');

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