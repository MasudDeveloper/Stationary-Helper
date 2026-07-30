@extends('layouts.app')

@section('title', 'সিভি এডিটর - ' . $template->name)

@section('content')
<div class="content-header no-print" style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2 style="color: #fff; margin: 0; font-weight: 700;">{{ $template->name }}</h2>
        <p style="color: #cbd5e1; margin: 5px 0 0 0; font-size: 0.95rem; font-weight: 500;">প্রয়োজনীয় তথ্য দিয়ে সিভি পূরণ করুন</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('cv.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.2rem;">arrow_back</i> ফিরে যান
        </a>
    </div>
</div>

<style>
    /* Sleek Custom Scrollbar for Editor Boxes */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 8px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.35);
        border-radius: 8px;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.6);
    }
    .preview-scroll::-webkit-scrollbar {
        width: 8px;
    }
    .preview-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .preview-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .preview-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="grid-2 no-print" style="grid-template-columns: 380px 1fr; gap: 25px; align-items: start;">
    
    <!-- Left Sidebar: Form with Independent Scrolling -->
    <div class="glass custom-scroll" style="padding: 25px; position: sticky; top: 15px; max-height: calc(100vh - 30px); overflow-y: auto; border: 1px solid rgba(255,255,255,0.25); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        <h3 style="color: #ffffff; margin: 0 0 20px 0; font-size: 1.2rem; font-weight: 700; border-bottom: 2px solid #38bdf8; padding-bottom: 12px; display: flex; align-items: center; gap: 8px; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
            <i class="material-icons-round" style="color: #38bdf8;">edit_note</i> তথ্য প্রদান করুন
        </h3>
        
        <form id="cv-form">
            @foreach($fields as $field)
                @php
                    $isPhoto = in_array(strtolower($field), ['photo', 'image', 'profile_photo', 'avatar', 'pic', 'picture', 'user_photo', 'candidate_photo']);
                    $isTextarea = ! $isPhoto && preg_match('/(objective|skills|experience|education|qualifications|hobbies|address|summary|description|list|details|projects|references)/i', $field);
                    $isList = preg_match('/(skills|hobbies|qualifications|experience_list)/i', $field);
                    $isEducation = preg_match('/(education)/i', $field);
                @endphp
                <div class="form-group" style="margin-bottom: 18px;">
                    <label style="display: block; color: #ffffff; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem; text-shadow: 0 1px 2px rgba(0,0,0,0.5); letter-spacing: 0.3px;">
                        @if($isPhoto) 📷 @elseif($isEducation) 🎓 @elseif($isList) 🔹 @else ✏️ @endif {{ str_replace('_', ' ', $field) }} @if($isPhoto) (ছবি আপলোড করুন) @endif
                    </label>
                    @if($isPhoto)
                        <input type="file" accept="image/*" class="form-control cv-photo-upload" data-target="[{{ $field }}]" style="width: 100%; padding: 10px; background: rgba(15, 23, 42, 0.7); border: 1.5px dashed #38bdf8; border-radius: 8px; color: #fff; font-size: 0.9rem; cursor: pointer; font-weight: 500;">
                        <input type="hidden" class="cv-input" id="photo-hidden-{{ $field }}" data-target="[{{ $field }}]" value="{{ $savedData['['.$field.']'] ?? '' }}">
                        <small style="color: #fef08a; font-size: 0.8rem; font-weight: 500; display: block; margin-top: 5px;">* পাসপোর্ট সাইজ ছবি আপলোড করুন</small>
                    @elseif($isTextarea)
                        <textarea class="form-control cv-input" data-target="[{{ $field }}]" data-field-type="{{ $isEducation ? 'education' : ($isList ? 'list' : 'text') }}" placeholder="{{ str_replace('_', ' ', $field) }} লিখুন..." rows="{{ $isEducation ? '6' : '4' }}" style="width: 100%; padding: 12px 14px; background: rgba(15, 23, 42, 0.75); border: 1.5px solid rgba(255,255,255,0.3); border-radius: 8px; color: #ffffff; font-size: 0.95rem; line-height: 1.5; font-family: monospace; font-weight: 500;">{{ $savedData['['.$field.']'] ?? '' }}</textarea>
                        @if($isEducation)
                            <small style="color: #fef08a; font-size: 0.8rem; font-weight: 500; display: block; margin-top: 5px;">💡 টিপস: প্রথমে ডিগ্রির নাম (যেমন: S.S.C on 2013), নিচের লাইনে কোলন দিয়ে রেজাল্ট (যেমন: Result : GPA-5.00) লিখলে স্বয়ংক্রিয়ভাবে সুন্দর ফরম্যাট হয়ে যাবে!</small>
                        @elseif($isList)
                            <small style="color: #fef08a; font-size: 0.8rem; font-weight: 500; display: block; margin-top: 5px;">💡 টিপস: এন্টার (Enter) দিয়ে প্রতি লাইনে একটি করে লিখলে স্বয়ংক্রিয়ভাবে বুলেট পয়েন্ট হয়ে যাবে!</small>
                        @else
                            <small style="color: #e2e8f0; font-size: 0.8rem; font-weight: 500; display: block; margin-top: 5px;">💡 টিপস: এন্টার (Enter) দিয়ে নতুন লাইন করতে পারবেন।</small>
                        @endif
                    @else
                        <input type="text" class="form-control cv-input" data-target="[{{ $field }}]" placeholder="{{ str_replace('_', ' ', $field) }} লিখুন..." value="{{ $savedData['['.$field.']'] ?? '' }}" style="width: 100%; padding: 12px 14px; background: rgba(15, 23, 42, 0.75); border: 1.5px solid rgba(255,255,255,0.3); border-radius: 8px; color: #ffffff; font-size: 0.95rem; font-weight: 500;">
                    @endif
                </div>
            @endforeach
        </form>

        <div style="margin-top: 30px; border-top: 1.5px solid rgba(255,255,255,0.2); padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <span style="color: #ffffff; font-size: 1rem; font-weight: 600; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">প্রিন্টিং চার্জ:</span>
                <span style="color: #4ade80; font-weight: 800; font-size: 1.25rem;">{{ $template->credit_cost }} Credits</span>
            </div>
            <button id="saveCvBtn" data-id="{{ $template->id }}" data-type="cv" data-title="{{ $template->name }}" class="btn w-100" style="background: #4f46e5; color: #fff; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);">
                <i class="material-icons-round" style="font-size: 1.3rem;">save</i> সংরক্ষণ করুন (Save)
            </button>
            <button id="print-btn" class="btn w-100" style="background: var(--primary-color); color: #fff; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);">
                <i class="material-icons-round" style="font-size: 1.3rem;">print</i> প্রিন্ট করুন
            </button>
            @if((\App\Models\Setting::where('key', 'whatsapp_module_status')->value('value') ?? 'enabled') === 'enabled')
            <button id="whatsappBtn" data-id="{{ $template->id }}" data-cost="{{ $template->credit_cost ?? 5 }}" data-name="{{ $template->name }}" class="btn w-100" style="background: #25D366; color: #fff; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);">
                <i class="material-icons-round" style="font-size: 1.3rem;">chat</i> WhatsApp-এ পাঠান
            </button>
            @endif
        </div>
    </div>

    <!-- Right Side: Live Preview with Independent Scrolling & Sticky Top -->
    <div class="preview-scroll" style="background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); overflow-y: auto; overflow-x: auto; color: #000; position: sticky; top: 15px; max-height: calc(100vh - 30px); border: 2px solid #38bdf8;">
        <div style="background: #f8fafc; padding: 12px 20px; border-bottom: 2px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10;">
            <span style="font-weight: 700; color: #0f172a; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                <i class="material-icons-round" style="color: #0284c7;">visibility</i> লাইভ প্রিভিউ (Live Preview) - A4 Size
            </span>
            <span style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">100% Realtime</span>
        </div>
        <div id="cv-preview" style="padding: 0; min-height: 842px; font-family: 'Times New Roman', Times, serif; font-size: 14px; line-height: 1.5; background: #e2e8f0; display: flex; justify-content: center; overflow-x: auto;">
            {!! $template->content !!}
        </div>
    </div>

</div>

<!-- The Print View (Hidden on Screen) -->
<div class="print-only">
    <div id="print-area">
        {!! $template->content !!}
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .app-container {
            margin: 0 !important;
            padding: 0 !important;
        }
        .print-only, .print-only * {
            visibility: visible;
        }
        .print-only {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: #fff;
            color: #000;
            margin: 0;
            padding: 0;
        }
        @page {
            size: A4;
            margin: 0;
        }
    }
    .print-only {
        display: none;
    }
    @media print {
        .print-only {
            display: block;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Save original template content for resetting
        const originalContent = `{!! addslashes($template->content) !!}`;
        
        // Live Update
        $('.cv-input').on('input', function() {
            updatePreview();
        });

        // Photo Upload Handler (FileReader to base64 DataURL)
        $('.cv-photo-upload').on('change', function(e) {
            let file = e.target.files[0];
            let hiddenInput = $(this).siblings('input[type="hidden"]');
            if (file) {
                let reader = new FileReader();
                reader.onload = function(evt) {
                    hiddenInput.val(evt.target.result).trigger('input');
                };
                reader.readAsDataURL(file);
            } else {
                hiddenInput.val('').trigger('input');
            }
        });

        function updatePreview() {
            let content = originalContent;
            
            $('.cv-input').each(function() {
                let target = $(this).data('target');
                let val = $(this).val();
                let fieldType = $(this).data('field-type');
                
                let replacement = target;
                if (val) {
                    if (fieldType === 'list') {
                        // For skills, hobbies, qualifications: each new line becomes a bullet item <li>...</li>
                        let lines = val.split('\n').map(l => l.trim()).filter(l => l !== '');
                        replacement = lines.map(l => `<li>${l}</li>`).join('');
                    } else if (fieldType === 'education') {
                        // Smart Education formatting from new lines
                        let lines = val.split('\n').map(l => l.trim()).filter(l => l !== '');
                        let eduHtml = '';
                        lines.forEach(line => {
                            if (line.includes(':')) {
                                let parts = line.split(':');
                                let label = parts[0].trim();
                                let value = parts.slice(1).join(':').trim();
                                eduHtml += `<div style="padding-left: 15px; margin-bottom: 2px; font-size: 13px;">${label} &nbsp;&nbsp;: &nbsp;<strong>${value}</strong></div>`;
                            } else {
                                eduHtml += `<div style="font-weight: bold; color: #0d47a1; font-size: 14px; margin-top: 6px; margin-bottom: 2px;">${line}</div>`;
                            }
                        });
                        replacement = eduHtml;
                    } else if ($(this).is('textarea')) {
                        // Normal textareas like Objective or Experience: convert \n to <br> or <li>
                        if (target.toLowerCase().includes('experience')) {
                            let lines = val.split('\n').map(l => l.trim()).filter(l => l !== '');
                            replacement = lines.map(l => `<li style="margin-bottom: 5px; list-style: none;">${l}</li>`).join('');
                        } else {
                            replacement = val.replace(/\n/g, '<br>');
                        }
                    } else {
                        replacement = val;
                    }
                }
                
                // Replace all occurrences
                content = content.split(target).join(replacement);
            });
            
            $('#cv-preview').html(content);
            $('#print-area').html(content);
        }

        // Print & Deduct Credit
        $('#print-btn').click(function() {
            let btn = $(this);
            let cost = {{ $template->credit_cost ?? 0 }};

            if (cost > 0) {
                Swal.fire({
                    title: "নিশ্চিত করুন",
                    text: `এই সিভিটি প্রিন্ট/ডাউনলোড করতে আপনার ${cost} ক্রেডিট কাটা হবে। আপনি কি চালিয়ে যেতে চান?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ, চালিয়ে যান",
                    cancelButtonText: "না, বাতিল করুন"
                }).then((result) => {
                    if (result.isConfirmed) {
                        executePrint(btn);
                    }
                });
            } else {
                executePrint(btn);
            }
        });

        function executePrint(btn) {
            btn.prop('disabled', true).html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> প্রিন্ট হচ্ছে...');
            
            $.ajax({
                url: "{{ route('cv.deduct.credit', $template->id) }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.print();
                    }
                    btn.prop('disabled', false).html('<i class="material-icons-round">print</i> প্রিন্ট করুন');
                },
                error: function(xhr) {
                    let msg = "সার্ভার এরর! আবার চেষ্টা করুন।";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire(msg);
                    btn.prop('disabled', false).html('<i class="material-icons-round">print</i> প্রিন্ট করুন');
                }
            });
        }

        // WhatsApp Send Button Handler
        $('#whatsappBtn').click(function() {
            const id = $(this).data('id');
            const creditCost = {{ $whatsappCost ?? 0 }};
            const templateName = String($(this).data('name'));
            sendViaWhatsApp(id, creditCost, templateName);
        });

        $('#saveCvBtn').click(function() {
            const id = $(this).data('id');
            const type = $(this).data('type');
            const title = String($(this).data('title'));
            saveDocument(id, type, title);
        });

        updatePreview();
    });

    async function saveDocument(id, type, defaultTitle) {
        const { value: title } = await Swal.fire({
            title: 'সিভি সংরক্ষণ করুন',
            input: 'text',
            inputLabel: 'সিভি-র একটি নাম দিন',
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
        $('.cv-input').each(function() {
            const target = $(this).data('target');
            formData[target] = $(this).val();
        });

        const btn = $('#saveCvBtn');
        const originalText = btn.html();
        btn.html('<i class="material-icons-round" style="vertical-align: middle; animation: spin 1s linear infinite;">sync</i> সংরক্ষণ হচ্ছে...');
        btn.prop('disabled', true);

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
            btn.html(originalText);
            btn.prop('disabled', false);
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
                title: 'নিশ্চিত করুন',
                text: `এই ফাইলটি WhatsApp-এ পাঠাতে আপনার একাউন্ট থেকে ${creditCost} ক্রেডিট কাটা হবে। আপনি কি রাজি?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, পাঠিয়ে দিন',
                cancelButtonText: 'না, বাতিল করুন'
            });

            if (!confirmResp.isConfirmed) return;
        }

        const btn = document.getElementById('whatsappBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="material-icons-round" style="animation: spin 1s linear infinite; vertical-align: middle;">sync</i> জেনারেট হচ্ছে...';
        btn.disabled = true;

        try {
            const element = document.getElementById('print-area');
            
            const opt = {
                margin:       [10, 0, 10, 0],
                filename:     templateName + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Temporarily show print area for rendering
            document.querySelector('.print-only').style.display = 'block';
            
            const pdfBase64 = await html2pdf().set(opt).from(element).output('datauristring');
            
            // Hide print area again
            document.querySelector('.print-only').style.display = '';
            
            btn.innerHTML = '<i class="material-icons-round" style="animation: spin 1s linear infinite; vertical-align: middle;">sync</i> পাঠানো হচ্ছে...';
            
            const response = await fetch(`/cv-maker/${id}/send-whatsapp`, {
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
                Swal.fire('সফল!', 'কাস্টমারের WhatsApp-এ সিভি পাঠানো হয়েছে।', 'success');
            } else {
                Swal.fire('ত্রুটি!', data.message || 'ফাইল পাঠানো সম্ভব হয়নি।', 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('ত্রুটি!', 'সার্ভার এরর। আবার চেষ্টা করুন।', 'error');
            // Make sure print area is hidden on error
            document.querySelector('.print-only').style.display = '';
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection
