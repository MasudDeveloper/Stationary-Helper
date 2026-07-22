@extends('layouts.app')

@section('title', 'মানি রিসিট জেনারেটর - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px; text-align: center;" class="no-print">মানি রিসিট (Money Receipt) জেনারেটর</h2>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Input Form -->
        <div class="glass no-print" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: #fff; font-weight: 700;">রিসিট তথ্য</h3>
            
            <div class="form-group">
                <label class="form-label">রিসিট নং</label>
                <input type="text" id="rec_no" class="form-control" value="MR-{{ rand(1000, 9999) }}" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">তারিখ</label>
                <input type="date" id="rec_date" class="form-control" value="{{ date('Y-m-d') }}" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); color-scheme: dark;">
            </div>
            <div class="form-group">
                <label class="form-label">গ্রহীতা / প্রতিষ্ঠানের নাম</label>
                <input type="text" id="rec_company" class="form-control" value="সহজ কাজ ডট কম" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">কার কাছ থেকে পাওয়া গেল (Received From)</label>
                <input type="text" id="rec_from" class="form-control" placeholder="গ্রাহকের নাম" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">টাকার পরিমাণ (Amount)</label>
                <input type="number" id="rec_amount" class="form-control" placeholder="0.00" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">বাবদ (Purpose)</label>
                <input type="text" id="rec_purpose" class="form-control" placeholder="যেমন: সার্ভিস চার্জ, পণ্য ক্রয়" oninput="updateReceipt()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>

            <button onclick="window.print()" class="btn btn-primary" style="width: 100%; margin-top: 15px; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #6366f1, #06b6d4);">প্রিন্ট / ডাউনলোড করুন</button>
            <button onclick="sendViaWhatsApp()" class="btn btn-success" id="wa-btn" style="width: 100%; margin-top: 10px; font-weight: 600; padding: 12px; background: #25D366; border: none;">
                <i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">chat</i> WhatsApp-এ পাঠান
            </button>
        </div>

        <!-- Preview Area -->
        <div style="flex: 2; min-width: 450px; display: flex; justify-content: center;">
            <div id="receipt-print-area" style="background: #fff; color: #000; width: 100%; max-width: 700px; padding: 40px; border: 2px solid #ccc; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); height: fit-content; font-family: 'Courier New', Courier, monospace;">
                <!-- Header -->
                <div style="text-align: center; border-bottom: 2px double #000; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 id="view_company" style="margin: 0; font-size: 1.8rem; font-weight: bold; text-transform: uppercase;">সহজ কাজ ডট কম</h2>
                    <p style="margin: 5px 0 0 0; font-size: 0.9rem;">ইমেইল: support@sohozkaj.com | মোবাইল: 017XXXXXXXX</p>
                </div>

                <!-- Title & Meta -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div><strong>রিসিট নং:</strong> <span id="view_no">MR-XXXX</span></div>
                    <div style="border: 2px solid #000; padding: 5px 20px; font-weight: bold; font-size: 1.1rem; border-radius: 4px;">মানি রিসিট</div>
                    <div><strong>তারিখ:</strong> <span id="view_date">{{ date('d/m/Y') }}</span></div>
                </div>

                <!-- Body Contents -->
                <div style="line-height: 2.2; font-size: 1.05rem; margin-bottom: 40px;">
                    <div>কার কাছ থেকে পাওয়া গেল: <span id="view_from" style="border-bottom: 1px dotted #000; display: inline-block; width: calc(100% - 210px); font-weight: bold;">................................................</span></div>
                    <div>টাকার পরিমাণ (কথায়): <span id="view_amount_words" style="border-bottom: 1px dotted #000; display: inline-block; width: calc(100% - 170px); font-weight: bold;">................................................</span></div>
                    <div>যে বাবদ পাওয়া গেল: <span id="view_purpose" style="border-bottom: 1px dotted #000; display: inline-block; width: calc(100% - 180px); font-weight: bold;">................................................</span></div>
                </div>

                <!-- Footer & Amount block -->
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div style="border: 2px solid #000; padding: 10px 25px; font-size: 1.4rem; font-weight: bold; background: #f3f4f6; border-radius: 4px;">
                        ৳ <span id="view_amount">0.00</span>/-
                    </div>
                    <div style="text-align: center; width: 200px;">
                        <div style="border-bottom: 1px solid #000; margin-bottom: 5px;"></div>
                        <strong>স্বাক্ষর</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #receipt-print-area, #receipt-print-area * {
            visibility: visible;
        }
        #receipt-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
        .no-print {
            display: none !important;
        }
        .navbar {
            display: none !important;
        }
    }
</style>

<script>
    function updateReceipt() {
        document.getElementById('view_company').innerText = document.getElementById('rec_company').value || 'সহজ কাজ ডট কম';
        document.getElementById('view_no').innerText = document.getElementById('rec_no').value || 'MR-XXXX';
        
        const rawDate = document.getElementById('rec_date').value;
        if(rawDate) {
            const dateObj = new Date(rawDate);
            document.getElementById('view_date').innerText = dateObj.toLocaleDateString('bn-BD');
        }

        document.getElementById('view_from').innerText = document.getElementById('rec_from').value || '................................................';
        document.getElementById('view_purpose').innerText = document.getElementById('rec_purpose').value || '................................................';
        
        const amount = parseFloat(document.getElementById('rec_amount').value) || 0;
        document.getElementById('view_amount').innerText = amount.toFixed(2);
        
        if(amount > 0) {
            document.getElementById('view_amount_words').innerText = inWords(Math.floor(amount)) + " Taka Only";
        } else {
            document.getElementById('view_amount_words').innerText = '................................................';
        }
    }

    // Number to words converter helper
    function inWords (num) {
        var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
        var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];
        if ((num = num.toString()).length > 9) return 'overflow';
        var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return ''; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        return str;
    }

    async function sendViaWhatsApp() {
        const phone = await Swal.fire({
            title: 'WhatsApp Number',
            input: 'text',
            inputLabel: 'গ্রাহকের হোয়াটসঅ্যাপ নম্বর দিন',
            inputPlaceholder: 'যেমন: 017XXXXXXXX',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) return 'নম্বর দিতে হবে!';
            }
        });

        if (phone.isConfirmed && phone.value) {
            const no = document.getElementById('view_no').innerText;
            const date = document.getElementById('view_date').innerText;
            const company = document.getElementById('view_company').innerText;
            const from = document.getElementById('rec_from').value || '-';
            const purpose = document.getElementById('rec_purpose').value || '-';
            const amount = document.getElementById('view_amount').innerText;

            const text = `*মানি রিসিট*\n\nরিসিট নং: ${no}\nতারিখ: ${date}\nপ্রতিষ্ঠান: ${company}\n\nযার কাছ থেকে প্রাপ্ত: ${from}\nবাবদ: ${purpose}\n\n*মোট পরিমাণ: ৳ ${amount}/-*\n\nধন্যবাদ!`;

            const btn = document.getElementById('wa-btn');
            btn.innerHTML = '<i class="material-icons-round spin">sync</i> পাঠানো হচ্ছে...';
            btn.disabled = true;

            fetch('{{ route("accounting.whatsapp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: phone.value, message: text })
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = '<i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">chat</i> WhatsApp-এ পাঠান';
                btn.disabled = false;

                if (data.success) {
                    Swal.fire('সফল!', 'WhatsApp-এ মেমো পাঠানো হয়েছে।', 'success');
                } else if (data.fallback) {
                    // Open wa.me manually
                    let formatPhone = phone.value.replace(/[^0-9]/g, '');
                    if (formatPhone.length === 11 && formatPhone.startsWith('01')) {
                        formatPhone = '88' + formatPhone;
                    }
                    window.open(`https://wa.me/${formatPhone}?text=${encodeURIComponent(text)}`, '_blank');
                    Swal.fire('নির্দেশনা', 'আপনার WhatsApp ওপেন করা হয়েছে, সেখান থেকে সেন্ড করুন।', 'info');
                } else {
                    Swal.fire('ত্রুটি', data.error || 'পাঠানো সম্ভব হয়নি!', 'error');
                }
            })
            .catch(err => {
                btn.innerHTML = '<i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">chat</i> WhatsApp-এ পাঠান';
                btn.disabled = false;
                Swal.fire('ত্রুটি', 'সার্ভারের সাথে সমস্যা হচ্ছে।', 'error');
            });
        }
    }
</script>
@endsection
