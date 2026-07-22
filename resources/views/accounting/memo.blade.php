@extends('layouts.app')

@section('title', 'ক্যাশ মেমো জেনারেটর - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px; text-align: center;" class="no-print">প্রফেশনাল ক্যাশ মেমো (Cash Memo) জেনারেটর</h2>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Input Form -->
        <div class="glass no-print" style="flex: 1; min-width: 350px; padding: 30px; height: fit-content; border-radius: 15px;">
            <h3 style="margin-bottom: 20px; color: #fff; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 10px; font-weight: 700;">প্রতিষ্ঠানের তথ্য</h3>
            
            <div class="form-group">
                <label class="form-label">লোগো (Logo)</label>
                <input type="file" id="memo_logo" class="form-control" accept="image/*" onchange="loadLogo(event)" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">প্রতিষ্ঠানের নাম</label>
                <input type="text" id="memo_company" class="form-control" value="আপনার প্রতিষ্ঠানের নাম" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">ঠিকানা</label>
                <input type="text" id="memo_address" class="form-control" value="ঠিকানা, শহর, বাংলাদেশ" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">মোবাইল নম্বর</label>
                <input type="text" id="memo_phone" class="form-control" value="০১৭XXXXXXXX" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>

            <h3 style="margin-top: 30px; margin-bottom: 20px; color: #fff; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 10px; font-weight: 700;">মেমো ও ক্রেতার তথ্য</h3>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">মেমো নং</label>
                    <input type="text" id="memo_no" class="form-control" value="INV-{{ rand(1000, 9999) }}" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
                </div>
                <div class="form-group">
                    <label class="form-label">তারিখ</label>
                    <input type="date" id="memo_date" class="form-control" value="{{ date('Y-m-d') }}" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); color-scheme: dark;">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">ক্রেতার নাম</label>
                <input type="text" id="memo_customer" class="form-control" placeholder="ক্রেতার নাম" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">ক্রেতার মোবাইল (ঐচ্ছিক)</label>
                <input type="text" id="memo_customer_phone" class="form-control" placeholder="মোবাইল নম্বর" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="form-group">
                <label class="form-label">ক্রেতার ঠিকানা (ঐচ্ছিক)</label>
                <input type="text" id="memo_customer_address" class="form-control" placeholder="ঠিকানা" oninput="updateMemoHeader()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>

            <h3 style="margin-top: 30px; margin-bottom: 20px; color: #fff; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 10px; font-weight: 700;">হিসাব / আইটেম</h3>
            
            <div class="form-group">
                <input type="text" id="item_desc" class="form-control" placeholder="পণ্যের নাম বা বিবরণ" style="margin-bottom: 10px; background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
                <div style="display: flex; gap: 10px;">
                    <input type="number" id="item_qty" class="form-control" placeholder="পরিমাণ" min="1" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
                    <input type="number" step="0.01" id="item_rate" class="form-control" placeholder="দর (টাকা)" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>
            <button onclick="addItem()" class="btn" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); width: 100%; margin-bottom: 15px; padding: 10px; border-radius: 8px; font-weight: 600; transition: all 0.3s;">+ আইটেম যোগ করুন</button>

            <div class="form-group">
                <label class="form-label">ডিসকাউন্ট (টাকা)</label>
                <input type="number" step="0.01" id="memo_discount" class="form-control" value="0" oninput="renderItems()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);">
            </div>

            <button onclick="window.print()" class="btn btn-primary" style="width: 100%; margin-top: 15px; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #10b981, #059669);"><i class="material-icons-round" style="vertical-align: middle;">print</i> প্রিন্ট / PDF সেভ করুন</button>
            <button onclick="sendViaWhatsApp()" class="btn btn-success" id="wa-btn" style="width: 100%; margin-top: 10px; font-weight: 600; padding: 12px; background: #25D366; border: none;">
                <i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">chat</i> WhatsApp-এ পাঠান
            </button>
        </div>

        <!-- Preview Area -->
        <div style="flex: 2; min-width: 450px; display: flex; justify-content: center; align-items: flex-start;">
            <div id="memo-print-area" style="background: #fff; color: #000; width: 100%; max-width: 794px; padding: 40px; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.08); font-family: 'Kalpurush', Arial, sans-serif; position: relative;">
                
                <!-- Watermark Logo (Optional) -->
                <div id="watermark_logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.05; display: none; pointer-events: none;">
                    <img src="" id="watermark_img" style="width: 300px; height: 300px; object-fit: contain;">
                </div>

                <!-- Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #111827; padding-bottom: 15px; margin-bottom: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img id="view_logo" src="" style="width: 80px; height: 80px; object-fit: contain; display: none;">
                        <div>
                            <h2 id="view_company" style="margin: 0; font-size: 2rem; font-weight: bold; color: #111827;">আপনার প্রতিষ্ঠানের নাম</h2>
                            <p id="view_address" style="margin: 5px 0 0 0; font-size: 1rem; color: #374151;">ঠিকানা, শহর, বাংলাদেশ</p>
                            <p id="view_phone" style="margin: 2px 0 0 0; font-size: 0.95rem; color: #374151;">মোবাইল: ০১৭XXXXXXXX</p>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="display: inline-block; background: #111827; color: #fff; padding: 6px 15px; font-weight: bold; font-size: 1.2rem; border-radius: 4px; letter-spacing: 1px;">ক্যাশ মেমো</div>
                    </div>
                </div>

                <!-- Title & Meta -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 1.05rem;">
                    <div>
                        <table style="text-align: left;">
                            <tr><td style="font-weight: bold; padding-right: 10px;">নাম:</td><td id="view_customer">...................................</td></tr>
                            <tr><td style="font-weight: bold; padding-right: 10px;">ঠিকানা:</td><td id="view_customer_address">...................................</td></tr>
                            <tr><td style="font-weight: bold; padding-right: 10px;">মোবাইল:</td><td id="view_customer_phone">...................................</td></tr>
                        </table>
                    </div>
                    <div>
                        <table style="text-align: left;">
                            <tr><td style="font-weight: bold; padding-right: 10px;">মেমো নং:</td><td id="view_no">INV-XXXX</td></tr>
                            <tr><td style="font-weight: bold; padding-right: 10px;">তারিখ:</td><td id="view_date">{{ date('d/m/Y') }}</td></tr>
                        </table>
                    </div>
                </div>

                <!-- Items Table -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; border: 1px solid #111827;" border="1">
                    <thead>
                        <tr style="background: #f3f4f6;">
                            <th style="padding: 10px; width: 8%; border: 1px solid #111827;">নং</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #111827;">পণ্যের বিবরণ</th>
                            <th style="padding: 10px; width: 12%; border: 1px solid #111827;">পরিমাণ</th>
                            <th style="padding: 10px; width: 15%; border: 1px solid #111827;">দর (৳)</th>
                            <th style="padding: 10px; width: 20%; text-align: right; border: 1px solid #111827;">মোট টাকা</th>
                        </tr>
                    </thead>
                    <tbody id="memo_items_body">
                        <!-- Items injected here -->
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: #9ca3af;">কোনো আইটেম যুক্ত করা হয়নি</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #111827;">মোট মূল্য:</td>
                            <td id="view_subtotal" style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #111827;">৳0.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #111827;">ডিসকাউন্ট:</td>
                            <td id="view_discount" style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #111827;">৳0.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding: 12px 10px; text-align: right; font-weight: bold; font-size: 1.15rem; background: #f3f4f6; border: 1px solid #111827;">সর্বমোট প্রদেয়:</td>
                            <td id="view_total" style="padding: 12px 10px; text-align: right; font-weight: bold; font-size: 1.15rem; background: #f3f4f6; border: 1px solid #111827;">৳0.00</td>
                        </tr>
                    </tfoot>
                </table>

                <div style="margin-bottom: 60px;">
                    <strong>কথায়:</strong> <span id="view_in_words" style="border-bottom: 1px dotted #000; display: inline-block; width: 80%; font-weight: 500;">শূন্য টাকা মাত্র</span>
                </div>

                <!-- Footer Signatures -->
                <div style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 20px;">
                    <div style="text-align: center; width: 180px;">
                        <div style="border-bottom: 1px solid #000; margin-bottom: 5px;"></div>
                        <p style="font-size: 0.95rem; font-weight: 500;">ক্রেতার স্বাক্ষর</p>
                    </div>
                    <div style="text-align: center; width: 180px;">
                        <div style="border-bottom: 1px solid #000; margin-bottom: 5px;"></div>
                        <p style="font-size: 0.95rem; font-weight: 500;">কর্তৃপক্ষের স্বাক্ষর</p>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px; font-size: 0.85rem; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 10px;">
                    সফটওয়্যার তৈরি করেছে: Smart Stationary
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        @page { margin: 10mm; }
        body * {
            visibility: hidden;
        }
        #memo-print-area, #memo-print-area * {
            visibility: visible;
        }
        #memo-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
        .navbar, .sidebar {
            display: none !important;
        }
    }
</style>

<script>
    let items = [];
    
    // Number to Bengali Words converter (Basic implementation)
    function numberToBengaliWords(num) {
        const units = ['', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়', 'দশ', 'এগারো', 'বারো', 'তেরো', 'চোদ্দ', 'পনেরো', 'ষোলো', 'সতেরো', 'আঠারো', 'উনিশ'];
        const tens = ['', '', 'বিশ', 'ত্রিশ', 'চল্লিশ', 'পঞ্চাশ', 'ষাট', 'সত্তর', 'আশি', 'নব্বই'];
        
        if (num === 0) return 'শূন্য';
        
        function convertLessThanOneThousand(n) {
            if (n === 0) return '';
            let res = '';
            if (n >= 100) {
                res += units[Math.floor(n / 100)] + ' শত ';
                n %= 100;
            }
            if (n > 0) {
                if (n < 20) res += units[n];
                else {
                    res += tens[Math.floor(n / 10)] + ' ';
                    res += units[n % 10];
                }
            }
            return res.trim();
        }
        
        let words = '';
        if (num >= 10000000) {
            words += convertLessThanOneThousand(Math.floor(num / 10000000)) + ' কোটি ';
            num %= 10000000;
        }
        if (num >= 100000) {
            words += convertLessThanOneThousand(Math.floor(num / 100000)) + ' লাখ ';
            num %= 100000;
        }
        if (num >= 1000) {
            words += convertLessThanOneThousand(Math.floor(num / 1000)) + ' হাজার ';
            num %= 1000;
        }
        if (num > 0) {
            words += convertLessThanOneThousand(num);
        }
        return words.trim() + ' টাকা মাত্র';
    }

    function loadLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('view_logo');
                const watermark = document.getElementById('watermark_img');
                
                img.src = e.target.result;
                img.style.display = 'block';
                
                watermark.src = e.target.result;
                document.getElementById('watermark_logo').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('view_logo').style.display = 'none';
            document.getElementById('watermark_logo').style.display = 'none';
        }
    }

    function updateMemoHeader() {
        document.getElementById('view_company').innerText = document.getElementById('memo_company').value || 'আপনার প্রতিষ্ঠানের নাম';
        document.getElementById('view_address').innerText = document.getElementById('memo_address').value || 'ঠিকানা, শহর, বাংলাদেশ';
        document.getElementById('view_phone').innerText = 'মোবাইল: ' + (document.getElementById('memo_phone').value || '০১৭XXXXXXXX');
        
        document.getElementById('view_no').innerText = document.getElementById('memo_no').value || 'INV-XXXX';
        
        const rawDate = document.getElementById('memo_date').value;
        if(rawDate) {
            const dateObj = new Date(rawDate);
            document.getElementById('view_date').innerText = dateObj.toLocaleDateString('bn-BD');
        }

        document.getElementById('view_customer').innerText = document.getElementById('memo_customer').value || '...................................';
        document.getElementById('view_customer_phone').innerText = document.getElementById('memo_customer_phone').value || '...................................';
        document.getElementById('view_customer_address').innerText = document.getElementById('memo_customer_address').value || '...................................';
    }

    function addItem() {
        const desc = document.getElementById('item_desc').value;
        const qty = parseInt(document.getElementById('item_qty').value);
        const rate = parseFloat(document.getElementById('item_rate').value);

        if(!desc || isNaN(qty) || isNaN(rate)) {
            Swal.fire('অনুগ্রহ করে সঠিক তথ্য দিন।');
            return;
        }

        items.push({ desc, qty, rate });
        
        // Reset fields
        document.getElementById('item_desc').value = '';
        document.getElementById('item_qty').value = '';
        document.getElementById('item_rate').value = '';

        renderItems();
    }

    function removeItem(index) {
        items.splice(index, 1);
        renderItems();
    }

    function renderItems() {
        const tbody = document.getElementById('memo_items_body');
        tbody.innerHTML = '';
        
        let subtotal = 0;

        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="padding: 20px; text-align: center; color: #9ca3af;">কোনো আইটেম যুক্ত করা হয়নি</td></tr>';
        } else {
            items.forEach((item, index) => {
                const itemTotal = item.qty * item.rate;
                subtotal += itemTotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding: 10px; text-align: center; border: 1px solid #111827;">${index + 1}</td>
                    <td style="padding: 10px; border: 1px solid #111827;">
                        ${item.desc}
                        <button onclick="removeItem(${index})" class="no-print" style="margin-left: 10px; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.8rem;">(মুছুন)</button>
                    </td>
                    <td style="padding: 10px; text-align: center; border: 1px solid #111827;">${item.qty}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #111827;">${item.rate.toFixed(2)}</td>
                    <td style="padding: 10px; text-align: right; border: 1px solid #111827;">${itemTotal.toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        const discount = parseFloat(document.getElementById('memo_discount').value) || 0;
        const total = subtotal - discount;

        document.getElementById('view_subtotal').innerText = '৳' + subtotal.toFixed(2);
        document.getElementById('view_discount').innerText = '৳' + discount.toFixed(2);
        document.getElementById('view_total').innerText = '৳' + total.toFixed(2);
        
        if (total > 0) {
            document.getElementById('view_in_words').innerText = numberToBengaliWords(Math.round(total));
        } else {
            document.getElementById('view_in_words').innerText = 'শূন্য টাকা মাত্র';
        }
    }
    
    // Initial render
    updateMemoHeader();

    async function sendViaWhatsApp() {
        const phone = await Swal.fire({
            title: 'WhatsApp Number',
            input: 'text',
            inputLabel: 'গ্রাহকের হোয়াটসঅ্যাপ নম্বর দিন',
            inputPlaceholder: 'যেমন: 017XXXXXXXX',
            inputValue: document.getElementById('memo_customer_phone').value || '',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) return 'নম্বর দিতে হবে!';
            }
        });

        if (phone.isConfirmed && phone.value) {
            const no = document.getElementById('view_no').innerText;
            const date = document.getElementById('view_date').innerText;
            const company = document.getElementById('view_company').innerText;
            const customer = document.getElementById('memo_customer').value || '-';
            const total = document.getElementById('view_total').innerText;

            let itemsText = '';
            items.forEach((item, index) => {
                itemsText += `${index + 1}. ${item.desc} - ${item.qty} x ${item.rate} = ${item.qty * item.rate}\n`;
            });

            const text = `*ক্যাশ মেমো*\n\nমেমো নং: ${no}\nতারিখ: ${date}\nপ্রতিষ্ঠান: ${company}\n\nক্রেতার নাম: ${customer}\n\n*আইটেমসমূহ:*\n${itemsText}\n*সর্বমোট প্রদেয়: ${total}*\n\nধন্যবাদ!`;

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
