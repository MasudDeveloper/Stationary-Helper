<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }} - Smart Stationary</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    
    <style>
        /* Base Reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; color: #111827; overflow: hidden; }
        
        .layout-wrapper { display: flex; height: 100vh; overflow: hidden; position: relative; }
        
        /* Left Side: Document Preview */
        .doc-preview-pane {
            flex: 1;
            overflow: auto; /* Allows scrolling in both directions */
            padding: 40px;
        }
        
        .a4-paper {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 20mm 20mm 20mm;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-family: 'Kalpurush', Arial, sans-serif;
            font-size: 16pt;
            line-height: 1.6;
            color: #000;
            margin: 0 auto;
        }

        .placeholder-highlight {
            background-color: #fbcfe8; /* pink-200 */
            color: #be185d; /* pink-700 */
            padding: 2px 5px;
            border-radius: 4px;
            border: 1px solid #f9a8d4;
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
            overflow-y: auto;
            padding: 20px;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .dynamic-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 5px;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .dynamic-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background: #3b82f6;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: #2563eb;
        }

        /* Toggle Button */
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
            box-shadow: -2px 0 5px rgba(0,0,0,0.05);
            color: #374151;
        }
        
        .toggle-sidebar-btn:hover {
            background: #f9fafb;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .form-sidebar {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                box-shadow: -4px 0 15px rgba(0,0,0,0.1);
            }
        }

        /* Print Styles */
        @media print {
            @page { margin: 0; }
            body, html { margin: 0; padding: 0; background: #ffffff !important; color: #000000 !important; height: auto; overflow: visible; }
            .layout-wrapper { display: block; height: auto; overflow: visible; background: #ffffff !important; }
            .form-sidebar, .toggle-sidebar-btn { display: none !important; }
            .doc-preview-pane { padding: 0; overflow: visible; display: block; }
            .a4-paper { 
                margin: 0; 
                padding: 10mm 20mm; 
                box-shadow: none; 
                width: 100%; 
                min-height: auto; 
                background: #ffffff !important; 
                color: #000000 !important;
            }
            .placeholder-highlight { background-color: transparent !important; color: #000000 !important; padding: 0 !important; border: none !important; }
        }
    </style>
</head>
<body>

<div class="layout-wrapper">
    <!-- Document Preview -->
    <div class="doc-preview-pane">
        <div class="a4-paper" id="printable-doc">
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
                        <input type="text" class="dynamic-input" data-target="{{ $field }}" placeholder="Enter {{ str_replace('-', ' ', $field) }}" oninput="updatePreview(this)">
                    </div>
                @endforeach
            </div>
            
            <div class="sidebar-footer">
                <button onclick="window.print()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 1.1rem; border-radius: 8px; font-weight: 600;">
                    <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">print</i> প্রিন্ট / PDF সেভ করুন
                </button>
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
            if(input.value) updatePreview(input);
        });
    });
</script>
</body>
</html>
