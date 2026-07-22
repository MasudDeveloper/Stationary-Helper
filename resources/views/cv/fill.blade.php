@extends('layouts.app')

@section('title', 'সিভি এডিটর - ' . $template->name)

@section('content')
<div class="content-header no-print" style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2 style="color: #fff; margin: 0; font-weight: 700;">{{ $template->name }}</h2>
        <p style="color: var(--text-muted); margin: 5px 0 0 0; font-size: 0.9rem;">প্রয়োজনীয় তথ্য দিয়ে সিভি পূরণ করুন</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('cv.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.2rem;">arrow_back</i> ফিরে যান
        </a>
    </div>
</div>

<div class="grid-2 no-print" style="grid-template-columns: 350px 1fr; gap: 25px; align-items: start;">
    
    <!-- Left Sidebar: Form -->
    <div class="glass" style="padding: 25px; position: sticky; top: 20px;">
        <h3 style="color: #fff; margin: 0 0 20px 0; font-size: 1.1rem; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">তথ্য প্রদান করুন</h3>
        
        <form id="cv-form">
            @foreach($fields as $field)
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.85rem;">{{ str_replace('_', ' ', $field) }}</label>
                    <input type="text" class="form-control cv-input" data-target="[{{ $field }}]" placeholder="{{ str_replace('_', ' ', $field) }} লিখুন..." style="width: 100%; padding: 10px 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; font-size: 0.9rem;">
                </div>
            @endforeach
        </form>

        <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <span style="color: var(--text-muted); font-size: 0.9rem;">প্রিন্টিং চার্জ:</span>
                <span style="color: #10b981; font-weight: 700; font-size: 1.1rem;">{{ $template->credit_cost }} Credits</span>
            </div>
            <button id="print-btn" class="btn w-100" style="background: var(--primary-color); color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 10px;">
                <i class="material-icons-round" style="font-size: 1.2rem;">print</i> প্রিন্ট করুন
            </button>
            <button onclick="sendViaWhatsApp({{ $template->id }}, {{ $template->credit_cost ?? 5 }}, '{{ addslashes($template->name) }}')" id="whatsappBtn" class="btn w-100" style="background: #25D366; color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="material-icons-round" style="font-size: 1.2rem;">chat</i> WhatsApp-এ পাঠান
            </button>
        </div>
    </div>

    <!-- Right Side: Live Preview -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); overflow: hidden; color: #000;">
        <div style="background: #f1f5f9; padding: 10px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: 600; color: #475569; font-size: 0.9rem;">লাইভ প্রিভিউ (Live Preview)</span>
        </div>
        <div id="cv-preview" style="padding: 40px; min-height: 842px; font-family: 'Times New Roman', Times, serif; font-size: 14px; line-height: 1.6; background: #fff;">
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
        }
        @page {
            margin: 2cm;
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

        function updatePreview() {
            let content = originalContent;
            
            $('.cv-input').each(function() {
                let target = $(this).data('target');
                let val = $(this).val();
                
                // If input is empty, leave placeholder, else replace with value
                let replacement = val ? val : target;
                
                // Replace all occurrences
                content = content.split(target).join(replacement);
            });
            
            $('#cv-preview').html(content);
            $('#print-area').html(content);
        }

        // Print & Deduct Credit
        $('#print-btn').click(function() {
            let btn = $(this);
            btn.prop('disabled', true).html('<i class="material-icons-round" style="animation: spin 1s linear infinite;">autorenew</i> প্রসেসিং...');
            
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
                    let msg = "একটি ত্রুটি হয়েছে।";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire(msg);
                    btn.prop('disabled', false).html('<i class="material-icons-round">print</i> প্রিন্ট করুন');
                }
            });
        });
    });

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
