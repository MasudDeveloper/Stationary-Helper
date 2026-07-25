@extends('layouts.app')

@section('title', 'প্রফেশনাল ইনভয়েস ও ক্যাশ মেমো জেনারেটর - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;" class="no-print">
        <div>
            <h2 style="color: #fff; font-size: 1.8rem; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="material-icons-round" style="color: #f97316; font-size: 2.2rem;">receipt_long</i>
                ইনভয়েস ও ক্যাশ মেমো জেনারেটর
            </h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 5px 0 0 0;">আন্তর্জাতিক মানের প্রফেশনাল ইনভয়েস ও রিসিট তৈরি করুন এবং ডাউনলোড বা প্রিন্ট করুন</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="resetForm()" class="btn" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 10px 18px; border-radius: 10px; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <i class="material-icons-round" style="font-size: 1.2rem;">restart_alt</i> নতুন মেমো / রিসেট
            </button>
            <button onclick="triggerPrint()" class="btn btn-primary" style="background: linear-gradient(135deg, #f97316, #ea580c); border: none; padding: 10px 22px; border-radius: 10px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);">
                <i class="material-icons-round" style="font-size: 1.2rem;">print</i> প্রিন্ট / PDF ডাউনলোড
            </button>
        </div>
    </div>

    <!-- Main Workspace -->
    <div style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">
        
        <!-- Controls & Editors (Left Side) -->
        <div class="glass no-print" style="flex: 1; min-width: 380px; max-width: 500px; padding: 25px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); max-height: 88vh; overflow-y: auto;">
            
            <!-- Section 1: Theme & Settings -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="margin: 0 0 15px 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
                    <i class="material-icons-round" style="color: #f97316;">palette</i> থিম ও ডকুমেন্ট সেটিংস
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">ডকুমেন্ট টাইটেল</label>
                        <select id="set_title" class="form-control" onchange="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); color: #fff; font-weight: 600;">
                            <option value="INVOICE" style="color: #000;">INVOICE (ইনভয়েস)</option>
                            <option value="RECEIPT" style="color: #000;">RECEIPT (রিসিট)</option>
                            <option value="CASH MEMO" style="color: #000;">CASH MEMO (ক্যাশ মেমো)</option>
                            <option value="ক্যাশ মেমো" style="color: #000;">ক্যাশ মেমো (বাংলা)</option>
                            <option value="চালানপত্র" style="color: #000;">চালানপত্র (বাংলা)</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">মুদ্রা (Currency)</label>
                        <select id="set_currency" class="form-control" onchange="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); color: #fff; font-weight: 600;">
                            <option value="৳" style="color: #000;">৳ (BDT / টাকা)</option>
                            <option value="$" style="color: #000;">$ (USD / dollar)</option>
                            <option value="€" style="color: #000;">€ (EUR / Euro)</option>
                            <option value="£" style="color: #000;">£ (GBP / Pound)</option>
                            <option value="SAR " style="color: #000;">SAR (Saudi Riyal)</option>
                            <option value="AED " style="color: #000;">AED (Dirham)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0; margin-top: 5px;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1; display: block; margin-bottom: 8px;">থিম কালার নির্বাচন করুন</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <button type="button" class="color-btn active" data-color="#ea580c" onclick="setThemeColor('#ea580c', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #ea580c; border: 2px solid #fff; cursor: pointer;"></button>
                        <button type="button" class="color-btn" data-color="#2563eb" onclick="setThemeColor('#2563eb', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #2563eb; border: 2px solid transparent; cursor: pointer;"></button>
                        <button type="button" class="color-btn" data-color="#10b981" onclick="setThemeColor('#10b981', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #10b981; border: 2px solid transparent; cursor: pointer;"></button>
                        <button type="button" class="color-btn" data-color="#9333ea" onclick="setThemeColor('#9333ea', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #9333ea; border: 2px solid transparent; cursor: pointer;"></button>
                        <button type="button" class="color-btn" data-color="#1e293b" onclick="setThemeColor('#1e293b', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #1e293b; border: 2px solid transparent; cursor: pointer;"></button>
                        <button type="button" class="color-btn" data-color="#dc2626" onclick="setThemeColor('#dc2626', this)" style="width: 32px; height: 32px; border-radius: 50%; background: #dc2626; border: 2px solid transparent; cursor: pointer;"></button>
                    </div>
                </div>
            </div>

            <!-- Section 2: Seller/Company Info -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="margin: 0 0 15px 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
                    <i class="material-icons-round" style="color: #38bdf8;">business</i> প্রতিষ্ঠানের তথ্য (Header Left)
                </h4>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">লোগো আপলোড (Logo)</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="file" id="set_logo" class="form-control" accept="image/*" onchange="loadLogo(event)" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                        <button type="button" onclick="removeLogo()" class="btn" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 8px 12px; border-radius: 8px; font-size: 0.8rem; white-space: nowrap;">লোগো মুছুন</button>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">প্রতিষ্ঠানের নাম</label>
                    <input type="text" id="set_company_name" class="form-control" value="Smart Stationary" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1);">
                </div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">ঠিকানা (Address)</label>
                    <input type="text" id="set_company_address" class="form-control" value="53 DIT Extention Road, Nayapaltan, Dhaka" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1);">
                </div>
                <!-- Phone and Email separated onto distinct lines -->
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">মোবাইল / ফোন (Phone)</label>
                    <input type="text" id="set_company_phone" class="form-control" value="Phone: +880 1711-111122" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1);">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">ইমেইল / ওয়েবসাইট (Email)</label>
                    <input type="text" id="set_company_email" class="form-control" value="Email: info@company.com" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1);">
                </div>
            </div>

            <!-- Section 3: Document Meta (Date & No) -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="margin: 0 0 15px 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
                    <i class="material-icons-round" style="color: #a855f7;">event_note</i> তারিখ ও নম্বর
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">তারিখ (Date)</label>
                        <input type="date" id="set_date" class="form-control" value="{{ date('Y-m-d') }}" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); color-scheme: dark;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-size: 0.85rem; color: #cbd5e1;">নম্বর (Receipt / Inv No.)</label>
                        <input type="text" id="set_no" class="form-control" value="INV-2026-001" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1);">
                    </div>
                </div>
            </div>

            <!-- Section 4: Bill To & Ship To -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px; margin-bottom: 15px;">
                    <h4 style="margin: 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <i class="material-icons-round" style="color: #10b981;">local_shipping</i> Bill To ও Ship To
                    </h4>
                    <label style="font-size: 0.8rem; color: #818cf8; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                        <input type="checkbox" id="copy_bill_ship" onchange="toggleCopyShip()" style="cursor: pointer;"> Ship To একই
                    </label>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #38bdf8; display: block; margin-bottom: 8px;">BILL TO (ক্রেতার তথ্য)</span>
                    <input type="text" id="bill_contact" class="form-control" placeholder="Contact Name / ক্রেতার নাম" value="Mr. Rahman" oninput="updateView(); copyIfChecked();" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <input type="text" id="bill_company" class="form-control" placeholder="Client Company Name / প্রতিষ্ঠান" value="Rahman Enterprises" oninput="updateView(); copyIfChecked();" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <input type="text" id="bill_address" class="form-control" placeholder="Address / ঠিকানা" value="45 Trade Center, Chittagong" oninput="updateView(); copyIfChecked();" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <input type="text" id="bill_phone" class="form-control" placeholder="Phone / মোবাইল" value="+880 1812-XXXXXX" oninput="updateView(); copyIfChecked();" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                        <input type="text" id="bill_email" class="form-control" placeholder="Email (ঐচ্ছিক)" value="rahman@enterprise.com" oninput="updateView(); copyIfChecked();" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                    </div>
                </div>

                <div id="ship_to_container" style="border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 15px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: #10b981; display: block; margin-bottom: 8px;">SHIP TO (শিপিং / ডেলিভারি ঠিকানা)</span>
                    <input type="text" id="ship_contact" class="form-control" placeholder="Name / Dept / প্রাপক" value="Logistics Dept / Warehouse 2" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <input type="text" id="ship_company" class="form-control" placeholder="Client Company Name / প্রতিষ্ঠান" value="Rahman Enterprises" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <input type="text" id="ship_address" class="form-control" placeholder="Address / ঠিকানা" value="Plot 12, Industrial Zone, Chittagong" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <input type="text" id="ship_phone" class="form-control" placeholder="Phone / মোবাইল" value="+880 1812-XXXXXX" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                </div>
            </div>

            <!-- Section 5: Items Table Add/Edit -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="margin: 0 0 15px 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
                    <i class="material-icons-round" style="color: #f59e0b;">shopping_cart</i> আইটেম সমূহ (Description, Qty, Price)
                </h4>
                
                <div style="background: rgba(0,0,0,0.2); padding: 12px; border-radius: 10px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <input type="text" id="item_desc" class="form-control" placeholder="পণ্যের বিবরণ (Description)" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); margin-bottom: 8px; font-size: 0.85rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                        <input type="number" step="any" id="item_qty" class="form-control" placeholder="পরিমাণ (Qty)" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                        <input type="number" step="any" id="item_rate" class="form-control" placeholder="দর (Unit Price)" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                        <button type="button" onclick="addItem()" class="btn" style="background: #f97316; color: #fff; font-weight: 700; border-radius: 8px; font-size: 0.85rem; border: none; cursor: pointer;">+ যোগ করুন</button>
                    </div>
                </div>

                <!-- Added items summary list -->
                <div id="added_items_list" style="max-height: 180px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px;">
                    <!-- Items rendered via JS -->
                </div>
            </div>

            <!-- Section 6: Calculations, In Words & Remarks -->
            <div class="editor-section" style="margin-bottom: 25px; background: rgba(255,255,255,0.02); padding: 18px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="margin: 0 0 15px 0; color: #fff; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
                    <i class="material-icons-round" style="color: #10b981;">calculate</i> হিসাব, ছাড় ও কথায় (In Words)
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                    <div>
                        <label class="form-label" style="font-size: 0.8rem; color: #cbd5e1;">ছাড় (Discount)</label>
                        <input type="number" step="any" id="set_discount" class="form-control" value="100" oninput="renderItems()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 0.8rem; color: #cbd5e1;">ট্যাক্স (Tax %)</label>
                        <input type="number" step="any" id="set_tax_rate" class="form-control" value="0" oninput="renderItems()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 0.8rem; color: #cbd5e1;">শিপিং (Shipping)</label>
                        <input type="number" step="any" id="set_shipping" class="form-control" value="150" oninput="renderItems()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem;">
                    </div>
                </div>

                <!-- Editable In Words Field (Automatic or Manual Override) -->
                <div style="margin-bottom: 15px; background: rgba(0,0,0,0.25); padding: 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label class="form-label" style="font-size: 0.85rem; color: #38bdf8; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 6px;">
                            <i class="material-icons-round" style="font-size: 1.1rem;">spellcheck</i> কথায় (In Words)
                        </label>
                        <label style="font-size: 0.75rem; color: #a855f7; cursor: pointer; display: flex; align-items: center; gap: 4px; background: rgba(168,85,247,0.15); padding: 3px 8px; border-radius: 6px; border: 1px solid rgba(168,85,247,0.3);">
                            <input type="checkbox" id="auto_words_check" checked onchange="toggleAutoWords()" style="cursor: pointer;"> অটোমেটিক জেনারেট
                        </label>
                    </div>
                    <input type="text" id="set_in_words" class="form-control" placeholder="কথায় পরিমাণ লিখুন..." oninput="updateCustomWords()" style="background: rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.15); font-size: 0.9rem; color: #fef08a; font-weight: 600;">
                    <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 5px;">* অটোমেটিক ঠিক না এলে বা পরিবর্তনের প্রয়োজন হলে নিজের ইচ্ছেমতো লিখে দিতে পারবেন।</small>
                </div>

                <div>
                    <label class="form-label" style="font-size: 0.8rem; color: #cbd5e1;">মন্তব্য / শর্তাবলী (Remarks, notes)</label>
                    <textarea id="set_remarks" class="form-control" rows="3" oninput="updateView()" style="background: rgba(0,0,0,0.3); border-color: rgba(255,255,255,0.1); font-size: 0.85rem; resize: vertical;">Thank you for your business!
Payment terms: 15 days from date of receipt.
Make all checks payable to Smart Stationary.</textarea>
                </div>
            </div>

            <!-- Section 7: Share & Action Buttons -->
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button onclick="triggerPrint()" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem; font-weight: 700; background: linear-gradient(135deg, #f97316, #ea580c); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.4);">
                    <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">print</i> প্রিন্ট / PDF হিসেবে সেভ করুন
                </button>
                <button onclick="sendViaWhatsApp()" class="btn" id="wa-btn" style="width: 100%; padding: 14px; font-size: 1rem; font-weight: 700; background: #25D366; color: #fff; border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);">
                    <i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">chat</i> WhatsApp-এ গ্রাহককে পাঠান
                </button>
            </div>
        </div>

        <!-- Printable Document Area (Right Side) -->
        <div id="memo-workspace-right" style="flex: 2; min-width: 500px; display: flex; justify-content: center; align-items: flex-start; padding-bottom: 40px;">
            <div id="memo-print-area" style="background: #ffffff; color: #1e293b; width: 100%; max-width: 794px; min-height: 1050px; padding: 0; box-shadow: 0 15px 35px rgba(0,0,0,0.25); border-radius: 6px; overflow: hidden; position: relative; font-family: 'Inter', 'Roboto', 'Kalpurush', sans-serif; display: flex; flex-direction: column; justify-content: space-between;">
                
                <!-- Main Top Body Content -->
                <div>
                    <!-- Top Orange Banner -->
                    <div id="banner_top" style="height: 20px; background-color: #ea580c; width: 100%; -webkit-print-color-adjust: exact; print-color-adjust: exact;"></div>

                    <!-- Header Section -->
                    <div style="padding: 25px 35px 10px; display: flex; justify-content: space-between; align-items: flex-start;">
                        
                        <!-- Left: Logo & Company -->
                        <div style="display: flex; align-items: flex-start; gap: 18px; max-width: 60%;">
                            <!-- Logo Circle -->
                            <div id="logo_container" style="width: 75px; height: 75px; border-radius: 50%; background-color: #64748b; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; overflow: hidden; border: 1px solid #e2e8f0; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                                <span id="logo_placeholder">LOGO</span>
                                <img id="view_logo" src="" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                            </div>
                            <!-- Company Info (Phone and Email strictly on separate lines) -->
                            <div>
                                <div id="view_company" style="font-size: 1.35rem; font-weight: 800; color: #334155; margin-bottom: 4px; line-height: 1.2;">Smart Stationary</div>
                                <div id="view_address" style="font-size: 0.82rem; color: #64748b; margin-bottom: 2px; line-height: 1.4;">53 DIT Extention Road, Nayapaltan, Dhaka</div>
                                <div id="view_phone" style="font-size: 0.82rem; color: #64748b; margin-bottom: 2px; line-height: 1.4;">Phone: +880 1711-111122</div>
                                <div id="view_email" style="font-size: 0.82rem; color: #64748b; line-height: 1.4;">Email: info@company.com</div>
                            </div>
                        </div>

                        <!-- Right: Document Title & Numbers -->
                        <div style="text-align: right; min-width: 210px;">
                            <div id="view_title" style="font-size: 2rem; font-weight: 800; color: #94a3b8; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 15px; line-height: 1;">INVOICE</div>
                            
                            <!-- Date -->
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; margin-bottom: 10px; width: 210px; margin-left: auto;">
                                <span style="font-size: 0.78rem; font-weight: 800; color: #475569; text-transform: uppercase;">DATE</span>
                                <span id="view_date" style="font-size: 0.82rem; font-weight: 700; color: #1e293b;">-</span>
                            </div>

                            <!-- Number -->
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; width: 210px; margin-left: auto;">
                                <span id="view_no_label" style="font-size: 0.78rem; font-weight: 800; color: #475569; text-transform: uppercase;">INVOICE NO.</span>
                                <span id="view_no" style="font-size: 0.82rem; font-weight: 700; color: #1e293b;">INV-2026-001</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bill To & Ship To Section -->
                    <div style="padding: 15px 35px; display: flex; justify-content: space-between; gap: 30px;">
                        
                        <!-- BILL TO -->
                        <div style="flex: 1;">
                            <div style="font-size: 0.78rem; font-weight: 800; color: #475569; border-bottom: 1.5px solid #94a3b8; padding-bottom: 4px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">BILL TO</div>
                            <div id="view_bill_to" style="font-size: 0.82rem; color: #1e293b; line-height: 1.5;">
                                <div style="font-weight: 700; color: #0f172a;" id="vb_contact">Mr. Rahman</div>
                                <div id="vb_company">Rahman Enterprises</div>
                                <div id="vb_address">45 Trade Center, Chittagong</div>
                                <div id="vb_phone">+880 1812-XXXXXX</div>
                                <div id="vb_email">rahman@enterprise.com</div>
                            </div>
                        </div>

                        <!-- SHIP TO -->
                        <div style="flex: 1;">
                            <div style="font-size: 0.78rem; font-weight: 800; color: #475569; border-bottom: 1.5px solid #94a3b8; padding-bottom: 4px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">SHIP TO</div>
                            <div id="view_ship_to" style="font-size: 0.82rem; color: #1e293b; line-height: 1.5;">
                                <div style="font-weight: 700; color: #0f172a;" id="vs_contact">Logistics Dept / Warehouse 2</div>
                                <div id="vs_company">Rahman Enterprises</div>
                                <div id="vs_address">Plot 12, Industrial Zone, Chittagong</div>
                                <div id="vs_phone">+880 1812-XXXXXX</div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div style="padding: 10px 35px 15px;">
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1;">
                            <thead>
                                <tr id="table_header_row" style="background-color: #ea580c; color: #ffffff; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                                    <th style="padding: 8px 12px; text-align: left; width: 48%; border-right: 1px solid rgba(255,255,255,0.25); font-size: 0.78rem; font-weight: 700; text-transform: uppercase;">DESCRIPTION</th>
                                    <th style="padding: 8px 12px; text-align: center; width: 14%; border-right: 1px solid rgba(255,255,255,0.25); font-size: 0.78rem; font-weight: 700; text-transform: uppercase;">QTY</th>
                                    <th style="padding: 8px 12px; text-align: right; width: 18%; border-right: 1px solid rgba(255,255,255,0.25); font-size: 0.78rem; font-weight: 700; text-transform: uppercase;">UNIT PRICE</th>
                                    <th style="padding: 8px 12px; text-align: right; width: 20%; font-size: 0.78rem; font-weight: 700; text-transform: uppercase;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="memo_items_body">
                                <!-- Rendered dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Calculations & Remarks -->
                    <div style="padding: 10px 35px 15px; display: flex; justify-content: space-between; align-items: flex-start; gap: 30px;">
                        
                        <!-- Left: Remarks & In Words -->
                        <div style="flex: 1; padding-top: 2px;">
                            <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; margin-bottom: 4px;">Remarks, notes:</div>
                            <div id="view_remarks" style="font-size: 0.82rem; color: #334155; line-height: 1.5; white-space: pre-line; min-height: 50px;">Thank you for your business!
Payment terms: 15 days from date of receipt.
Make all checks payable to Smart Stationary.</div>
                            
                            <div style="margin-top: 12px; padding-top: 8px; border-top: 1px dashed #cbd5e1;">
                                <span style="font-size: 0.78rem; font-weight: 700; color: #64748b;">In Words (কথায়):</span>
                                <div id="view_in_words" style="font-size: 0.85rem; font-weight: 700; color: #0f172a; font-style: italic; margin-top: 2px; line-height: 1.4;">Zero Only</div>
                            </div>
                        </div>

                        <!-- Right: Totals -->
                        <div style="width: 270px; font-size: 0.82rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600;">
                                <span>SUBTOTAL</span>
                                <span style="color: #1e293b; font-weight: 700;"><span class="view_curr">৳</span> <span id="view_subtotal">0.00</span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600;">
                                <span>DISCOUNT</span>
                                <span style="color: #ef4444; font-weight: 700;">- <span class="view_curr">৳</span> <span id="view_discount">0.00</span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 2px;">
                                <span>SUBTOTAL LESS DISCOUNT</span>
                                <span style="color: #1e293b; font-weight: 700;"><span class="view_curr">৳</span> <span id="view_subtotal_less">0.00</span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600;">
                                <span>TAX RATE</span>
                                <span style="color: #1e293b; font-weight: 700;"><span id="view_tax_rate_label">0%</span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600;">
                                <span>TOTAL TAX</span>
                                <span style="color: #1e293b; font-weight: 700;"><span class="view_curr">৳</span> <span id="view_total_tax">0.00</span></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; color: #475569; font-weight: 600; border-bottom: 1px solid #cbd5e1; padding-bottom: 6px;">
                                <span>SHIPPING/HANDLING</span>
                                <span style="color: #1e293b; font-weight: 700;"><span class="view_curr">৳</span> <span id="view_shipping">0.00</span></span>
                            </div>
                            
                            <!-- Balance Paid Box (Matches uploaded image exactly) -->
                            <div style="margin-top: 8px; background-color: #dcfce7; border: 1.5px solid #b9f6ca; padding: 10px 12px; display: flex; justify-content: space-between; align-items: center; border-radius: 4px; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                                <span style="font-size: 1rem; font-weight: 800; color: #1e293b;">Balance Paid</span>
                                <span style="font-size: 1.25rem; font-weight: 800; color: #166534;"><span class="view_curr">৳</span> <span id="view_total_amount">0.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Signatures & Banner -->
                <div>
                    <!-- Signatures -->
                    <div style="padding: 15px 35px 20px; display: flex; justify-content: space-between; align-items: flex-end; margin-top: 15px;">
                        <div style="text-align: center; width: 180px;">
                            <div style="border-bottom: 1.5px solid #475569; margin-bottom: 5px;"></div>
                            <p style="font-size: 0.82rem; font-weight: 700; color: #475569; margin: 0;">Customer's Signature</p>
                        </div>
                        <div style="text-align: center; width: 180px;">
                            <div style="border-bottom: 1.5px solid #475569; margin-bottom: 5px;"></div>
                            <p style="font-size: 0.82rem; font-weight: 700; color: #475569; margin: 0;">Authorized Signature</p>
                        </div>
                    </div>

                    <!-- Bottom Orange Banner -->
                    <div id="banner_bottom" style="height: 20px; background-color: #ea580c; width: 100%; -webkit-print-color-adjust: exact; print-color-adjust: exact;"></div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .color-btn.active {
        box-shadow: 0 0 0 3px rgba(255,255,255,0.4);
        transform: scale(1.15);
    }
    
    /* Bulletproof Flush A4 Print Styles (Zero Margins, Zero Sides Space, Exactly 1 Page) */
    @media print {
        @page {
            size: A4 portrait;
            margin: 0 !important;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm !important;
            height: 297mm !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }
        body > *:not(#memo-print-area) {
            display: none !important;
        }
        #memo-print-area {
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 210mm !important;
            height: 297mm !important;
            max-width: 210mm !important;
            max-height: 297mm !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: #ffffff !important;
            z-index: 999999999 !important;
            overflow: hidden !important;
        }
        .no-print, .app-sidebar, .sidebar, .navbar, header, footer, aside, nav {
            display: none !important;
        }
    }
</style>

<script>
    // Initial default items matching the aesthetic of a real stationery trading company
    let items = [
        { desc: 'Premium A4 Copy Paper (80 GSM, 500 Sheets)', qty: 50, rate: 450.00 },
        { desc: 'Gel Pen Box (Blue, 12 Pcs)', qty: 20, rate: 120.00 },
        { desc: 'Office Desk Organizer (Mesh Steel)', qty: 6, rate: 350.00 }
    ];
    let currentThemeColor = '#ea580c';

    // 100% Accurate Bengali Words mapping from 0 to 99
    const bnNumbers = [
        '', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়', 'দশ', 
        'এগারো', 'বারো', 'তেরো', 'চৌদ্দ', 'পনেরো', 'ষোলো', 'সতেরো', 'আঠারো', 'উনিশ', 
        'বিশ', 'একুশ', 'বাইশ', 'তেইশ', 'চব্বিশ', 'পঁচিশ', 'ছাব্বিশ', 'সাতাশ', 'আঠাশ', 'উনত্রিশ', 
        'ত্রিশ', 'একত্রিশ', 'বত্রিশ', 'তেত্রিশ', 'চৌত্রিশ', 'পঁয়ত্রিশ', 'ছত্রিশ', 'সাঁইত্রিশ', 'আটত্রিশ', 'উনচল্লিশ', 
        'চল্লিশ', 'একচল্লিশ', 'বিয়াল্লিশ', 'তেতাল্লিশ', 'চুয়াল্লিশ', 'পঁয়তাল্লিশ', 'ছেচল্লিশ', 'সাতচল্লিশ', 'আটচল্লিশ', 'উনপঞ্চাশ', 
        'পঞ্চাশ', 'একান্ন', 'বায়ান্ন', 'তিপ্পান্ন', 'চুয়ান্ন', 'পঞ্চান্ন', 'ছাপ্পান্ন', 'সাতান্ন', 'আটান্ন', 'উনষাট', 
        'ষাট', 'একষট্টি', 'বাষট্টি', 'তেষট্টি', 'চৌষট্টি', 'পঁয়ষট্টি', 'ছেষট্টি', 'সাতষট্টি', 'আটষট্টি', 'উনসত্তর', 
        'সত্তর', 'একাত্তর', 'বাহাত্তর', 'তেহাত্তর', 'চুয়াত্তর', 'পঁচাত্তর', 'ছিয়াত্তর', 'সাতাত্তর', 'আটাত্তর', 'উনআশি', 
        'আশি', 'একাশি', 'বিয়াশি', 'তিরাশি', 'চুরাশি', 'পঁচাশি', 'ছিয়াশি', 'সাতাশি', 'অষ্টাশী', 'উননব্বই', 
        'নব্বই', 'একানব্বই', 'বিয়ানব্বই', 'তিরানব্বই', 'চুরানব্বই', 'পঁচানব্বই', 'ছিয়ানব্বই', 'সাতانব্বই', 'আটানব্বই', 'নিরানব্বই'
    ];

    // Bulletproof Portal Print Technique (Moves element to root before print to prevent ancestor margin/padding/overflow traps)
    let originalParent = null;
    let nextSibling = null;

    function prepareForPrint() {
        const printArea = document.getElementById('memo-print-area');
        if (printArea && printArea.parentElement !== document.body) {
            originalParent = printArea.parentElement;
            nextSibling = printArea.nextElementSibling;
            document.body.appendChild(printArea);
        }
    }

    function restoreAfterPrint() {
        const printArea = document.getElementById('memo-print-area');
        if (printArea && originalParent) {
            if (nextSibling) {
                originalParent.insertBefore(printArea, nextSibling);
            } else {
                originalParent.appendChild(printArea);
            }
            originalParent = null;
            nextSibling = null;
        }
    }

    window.addEventListener('beforeprint', prepareForPrint);
    window.addEventListener('afterprint', restoreAfterPrint);

    function triggerPrint() {
        prepareForPrint();
        setTimeout(() => {
            window.print();
        }, 150);
    }

    function numberToWords(num, currency) {
        if (num === 0) return currency === '৳' ? 'শূন্য টাকা মাত্র' : 'Zero Only';
        
        if (currency === '৳') {
            return numberToBengaliWords(Math.round(num));
        } else {
            return numberToEnglishWords(Math.round(num)) + ' ' + (currency === '$' ? 'Dollars' : '') + ' Only';
        }
    }

    function numberToBengaliWords(num) {
        if (num === 0) return 'শূন্য টাকা মাত্র';
        
        function convertLessThanOneThousand(n) {
            if (n === 0) return '';
            let res = '';
            if (n >= 100) {
                res += bnNumbers[Math.floor(n / 100)] + ' শত ';
                n %= 100;
            }
            if (n > 0) {
                res += bnNumbers[n];
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

    function numberToEnglishWords(num) {
        const a = ['','One ','Two ','Three ','Four ','Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
        const b = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
        
        if ((num = num.toString()).length > 9) return 'Overflow';
        let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return ''; 
        let str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
        return str.trim() || 'Zero';
    }

    function toggleAutoWords() {
        const isAuto = document.getElementById('auto_words_check').checked;
        const input = document.getElementById('set_in_words');
        if (isAuto) {
            input.style.opacity = '0.7';
            renderItems();
        } else {
            input.style.opacity = '1';
            input.focus();
        }
    }

    function updateCustomWords() {
        if (!document.getElementById('auto_words_check').checked) {
            const val = document.getElementById('set_in_words').value.trim();
            document.getElementById('view_in_words').innerText = val || 'Zero Only';
        }
    }

    function setThemeColor(color, btn) {
        currentThemeColor = color;
        document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        
        document.getElementById('banner_top').style.backgroundColor = color;
        document.getElementById('banner_bottom').style.backgroundColor = color;
        document.getElementById('table_header_row').style.backgroundColor = color;
    }

    function loadLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('view_logo');
                img.src = e.target.result;
                img.style.display = 'block';
                document.getElementById('logo_placeholder').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    function removeLogo() {
        document.getElementById('set_logo').value = '';
        document.getElementById('view_logo').style.display = 'none';
        document.getElementById('view_logo').src = '';
        document.getElementById('logo_placeholder').style.display = 'block';
    }

    function toggleCopyShip() {
        const isChecked = document.getElementById('copy_bill_ship').checked;
        const container = document.getElementById('ship_to_container');
        if (isChecked) {
            container.style.opacity = '0.4';
            container.style.pointerEvents = 'none';
            copyIfChecked();
        } else {
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
        }
    }

    function copyIfChecked() {
        if (!document.getElementById('copy_bill_ship').checked) return;
        document.getElementById('ship_contact').value = document.getElementById('bill_contact').value;
        document.getElementById('ship_company').value = document.getElementById('bill_company').value;
        document.getElementById('ship_address').value = document.getElementById('bill_address').value;
        document.getElementById('ship_phone').value = document.getElementById('bill_phone').value;
        updateView();
    }

    function updateView() {
        // Title & Currency
        const title = document.getElementById('set_title').value || 'INVOICE';
        document.getElementById('view_title').innerText = title;
        document.getElementById('view_no_label').innerText = title === 'CASH MEMO' || title === 'ক্যাশ মেমো' ? 'MEMO NO.' : (title === 'INVOICE' ? 'INVOICE NO.' : 'RECEIPT NO.');

        const curr = document.getElementById('set_currency').value || '৳';
        document.querySelectorAll('.view_curr').forEach(el => el.innerText = curr);

        // Company Left Info (Phone and Email strictly separated)
        document.getElementById('view_company').innerText = document.getElementById('set_company_name').value || 'Smart Stationary';
        document.getElementById('view_address').innerText = document.getElementById('set_company_address').value || '';
        document.getElementById('view_phone').innerText = document.getElementById('set_company_phone').value || '';
        document.getElementById('view_email').innerText = document.getElementById('set_company_email').value || '';

        // Meta Right Info
        const rawDate = document.getElementById('set_date').value;
        if (rawDate) {
            const dateObj = new Date(rawDate);
            document.getElementById('view_date').innerText = dateObj.toLocaleDateString('en-GB');
        } else {
            document.getElementById('view_date').innerText = '-';
        }
        document.getElementById('view_no').innerText = document.getElementById('set_no').value || '-';

        // Bill To
        document.getElementById('vb_contact').innerText = document.getElementById('bill_contact').value || '-';
        document.getElementById('vb_company').innerText = document.getElementById('bill_company').value || '';
        document.getElementById('vb_address').innerText = document.getElementById('bill_address').value || '';
        document.getElementById('vb_phone').innerText = document.getElementById('bill_phone').value || '';
        document.getElementById('vb_email').innerText = document.getElementById('bill_email').value || '';

        // Ship To
        document.getElementById('vs_contact').innerText = document.getElementById('ship_contact').value || '-';
        document.getElementById('vs_company').innerText = document.getElementById('ship_company').value || '';
        document.getElementById('vs_address').innerText = document.getElementById('ship_address').value || '';
        document.getElementById('vs_phone').innerText = document.getElementById('ship_phone').value || '';

        // Remarks
        document.getElementById('view_remarks').innerText = document.getElementById('set_remarks').value || '';

        renderItems();
    }

    function addItem() {
        const desc = document.getElementById('item_desc').value.trim();
        const qty = parseFloat(document.getElementById('item_qty').value);
        const rate = parseFloat(document.getElementById('item_rate').value);

        if (!desc || isNaN(qty) || isNaN(rate) || qty <= 0 || rate < 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('ত্রুটি', 'অনুগ্রহ করে পণ্যের বিবরণ, সঠিক পরিমাণ এবং দর প্রদান করুন।', 'warning');
            } else {
                alert('অনুগ্রহ করে পণ্যের বিবরণ, সঠিক পরিমাণ এবং দর প্রদান করুন।');
            }
            return;
        }

        items.push({ desc, qty, rate });
        document.getElementById('item_desc').value = '';
        document.getElementById('item_qty').value = '';
        document.getElementById('item_rate').value = '';
        document.getElementById('item_desc').focus();

        renderItems();
    }

    function removeItem(index) {
        items.splice(index, 1);
        renderItems();
    }

    function renderItems() {
        const curr = document.getElementById('set_currency').value || '৳';
        
        // Render added items in Left Control list
        const listDiv = document.getElementById('added_items_list');
        listDiv.innerHTML = '';
        if (items.length === 0) {
            listDiv.innerHTML = '<div style="color: #94a3b8; font-size: 0.8rem; text-align: center; padding: 10px;">কোনো আইটেম যোগ করা হয়নি</div>';
        } else {
            items.forEach((item, idx) => {
                const itemBox = document.createElement('div');
                itemBox.style.cssText = 'background: rgba(255,255,255,0.04); padding: 8px 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(255,255,255,0.05); font-size: 0.85rem;';
                itemBox.innerHTML = `
                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 65%;">
                        <strong style="color: #fff;">${idx + 1}. ${item.desc}</strong>
                        <div style="color: #94a3b8; font-size: 0.75rem;">${item.qty} x ${item.rate.toFixed(2)}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 700; color: #38bdf8;">${curr}${(item.qty * item.rate).toFixed(2)}</span>
                        <button type="button" onclick="removeItem(${idx})" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 2px;"><i class="material-icons-round" style="font-size: 1.1rem;">delete</i></button>
                    </div>
                `;
                listDiv.appendChild(itemBox);
            });
        }

        // Render printable table body
        const tbody = document.getElementById('memo_items_body');
        tbody.innerHTML = '';
        let subtotal = 0;

        // Ensure at least 8 rows for the classic printed ledger look
        const minRows = Math.max(items.length, 8);

        for (let i = 0; i < minRows; i++) {
            const tr = document.createElement('tr');
            const isEven = i % 2 === 0;
            tr.style.backgroundColor = isEven ? '#ffffff' : '#f8fafc';
            tr.style.borderBottom = '1px solid #e2e8f0';
            tr.style.color = '#334155';
            tr.style.fontSize = '0.82rem';

            if (i < items.length) {
                const item = items[i];
                const total = item.qty * item.rate;
                subtotal += total;

                tr.innerHTML = `
                    <td style="padding: 7px 12px; border-right: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0;">
                        <span style="font-weight: 600; color: #0f172a;">${item.desc}</span>
                    </td>
                    <td style="padding: 7px 12px; text-align: center; border-right: 1px solid #e2e8f0;">${item.qty}</td>
                    <td style="padding: 7px 12px; text-align: right; border-right: 1px solid #e2e8f0;">${item.rate.toFixed(2)}</td>
                    <td style="padding: 7px 12px; text-align: right; font-weight: 700; color: #0f172a; border-right: 1px solid #e2e8f0;">${total.toFixed(2)}</td>
                `;
            } else {
                // Empty padded row to maintain format aesthetic
                tr.innerHTML = `
                    <td style="padding: 8px 12px; border-right: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0; color: #cbd5e1;">&nbsp;</td>
                    <td style="padding: 8px 12px; text-align: center; border-right: 1px solid #e2e8f0; color: #cbd5e1;">&nbsp;</td>
                    <td style="padding: 8px 12px; text-align: right; border-right: 1px solid #e2e8f0; color: #cbd5e1;">&nbsp;</td>
                    <td style="padding: 8px 12px; text-align: right; color: #cbd5e1; border-right: 1px solid #e2e8f0;">0.00</td>
                `;
            }
            tbody.appendChild(tr);
        }

        // Totals calculation
        const discount = parseFloat(document.getElementById('set_discount').value) || 0;
        const subtotalLess = Math.max(0, subtotal - discount);
        const taxRate = parseFloat(document.getElementById('set_tax_rate').value) || 0;
        const totalTax = (subtotalLess * taxRate) / 100;
        const shipping = parseFloat(document.getElementById('set_shipping').value) || 0;
        const grandTotal = subtotalLess + totalTax + shipping;

        document.getElementById('view_subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('view_discount').innerText = discount.toFixed(2);
        document.getElementById('view_subtotal_less').innerText = subtotalLess.toFixed(2);
        document.getElementById('view_tax_rate_label').innerText = taxRate + '%';
        document.getElementById('view_total_tax').innerText = totalTax.toFixed(2);
        document.getElementById('view_shipping').innerText = shipping.toFixed(2);
        document.getElementById('view_total_amount').innerText = grandTotal.toFixed(2);

        // Update In Words (if automatic mode is active)
        const isAuto = document.getElementById('auto_words_check').checked;
        if (isAuto) {
            const calculatedWords = numberToWords(grandTotal, curr);
            document.getElementById('set_in_words').value = calculatedWords;
            document.getElementById('view_in_words').innerText = calculatedWords;
        }
    }

    function resetForm() {
        if (confirm('আপনি কি নিশ্চিত যে নতুন মেমো শুরু করতে চান? সমস্ত তথ্য রিসেট হয়ে যাবে।')) {
            items = [];
            document.getElementById('set_title').value = 'INVOICE';
            document.getElementById('set_currency').value = '৳';
            document.getElementById('set_company_name').value = 'Smart Stationary';
            document.getElementById('set_company_address').value = '53 DIT Extention Road, Nayapaltan, Dhaka';
            document.getElementById('set_company_phone').value = 'Phone: +880 1711-111122';
            document.getElementById('set_company_email').value = 'Email: info@company.com';
            document.getElementById('set_no').value = 'INV-' + Math.floor(1000 + Math.random() * 9000);
            document.getElementById('set_date').value = new Date().toISOString().split('T')[0];
            
            document.getElementById('bill_contact').value = '';
            document.getElementById('bill_company').value = '';
            document.getElementById('bill_address').value = '';
            document.getElementById('bill_phone').value = '';
            document.getElementById('bill_email').value = '';
            
            document.getElementById('ship_contact').value = '';
            document.getElementById('ship_company').value = '';
            document.getElementById('ship_address').value = '';
            document.getElementById('ship_phone').value = '';
            document.getElementById('copy_bill_ship').checked = false;
            toggleCopyShip();
            
            document.getElementById('set_discount').value = '0';
            document.getElementById('set_tax_rate').value = '0';
            document.getElementById('set_shipping').value = '0';
            document.getElementById('auto_words_check').checked = true;
            toggleAutoWords();
            document.getElementById('set_remarks').value = 'Thank you for your business!\nPayment terms: 15 days from date of receipt.';
            
            removeLogo();
            setThemeColor('#ea580c', document.querySelector('.color-btn[data-color="#ea580c"]'));
            updateView();
        }
    }

    // Initialize View on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateView();
    });

    async function sendViaWhatsApp() {
        const phone = await Swal.fire({
            title: 'WhatsApp Number',
            input: 'text',
            inputLabel: 'গ্রাহকের হোয়াটসঅ্যাপ নম্বর দিন (PDF ইনভয়েস পাঠানো হবে)',
            inputPlaceholder: 'যেমন: 017XXXXXXXX',
            inputValue: document.getElementById('bill_phone').value || '',
            showCancelButton: true,
            confirmButtonText: 'PDF তৈরি ও পাঠান <i class="material-icons-round" style="vertical-align: middle; font-size:1rem;">send</i>',
            cancelButtonText: 'বাতিল',
            inputValidator: (value) => {
                if (!value) return 'নম্বর দিতে হবে!';
            }
        });

        if (phone.isConfirmed && phone.value) {
            const no = document.getElementById('view_no').innerText;
            const date = document.getElementById('view_date').innerText;
            const company = document.getElementById('view_company').innerText;
            const customer = document.getElementById('vb_contact').innerText || document.getElementById('vb_company').innerText || '-';
            const total = document.getElementById('view_total_amount').innerText;
            const curr = document.getElementById('set_currency').value || '৳';

            let itemsText = '';
            items.forEach((item, index) => {
                itemsText += `${index + 1}. ${item.desc} - ${item.qty} x ${item.rate.toFixed(2)} = ${curr}${(item.qty * item.rate).toFixed(2)}\n`;
            });

            const text = `*${document.getElementById('view_title').innerText}*\n\nনং: ${no}\nতারিখ: ${date}\nপ্রতিষ্ঠান: ${company}\n\n*গ্রাহক (Bill To):*\nনাম: ${customer}\nঠিকানা: ${document.getElementById('vb_address').innerText}\n\n*আইটেমসমূহ:*\n${itemsText}\n*সর্বমোট পরিশোধযোগ্য (Balance Paid): ${curr}${total}*\n\nধন্যবাদ!`;

            const btn = document.getElementById('wa-btn');
            btn.innerHTML = '<i class="material-icons-round spin">sync</i> PDF তৈরি করা হচ্ছে...';
            btn.disabled = true;

            // Show loading dialog for PDF generation
            Swal.fire({
                title: 'PDF জেনারেট হচ্ছে...',
                text: 'অনুগ্রহ করে একটু অপেক্ষা করুন, ইনভয়েসের PDF তৈরি করা হচ্ছে।',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Generate high quality PDF base64 using html2canvas & jsPDF
            let pdfBase64 = null;
            let filename = `Invoice_${no.replace(/[^a-zA-Z0-9_\-]/g, '_')}.pdf`;
            try {
                const element = document.getElementById('memo-print-area');
                const origBoxShadow = element.style.boxShadow;
                const origBorderRadius = element.style.borderRadius;
                element.style.boxShadow = 'none';
                element.style.borderRadius = '0';

                const canvas = await html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    backgroundColor: '#ffffff'
                });

                element.style.boxShadow = origBoxShadow;
                element.style.borderRadius = origBorderRadius;

                const imgData = canvas.toDataURL('image/jpeg', 0.95);
                if (window.jspdf && window.jspdf.jsPDF) {
                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, Math.min(pdfHeight, 297));
                    pdfBase64 = pdf.output('datauristring');
                }
            } catch (e) {
                console.error("PDF generation failed:", e);
            }

            fetch('{{ route("accounting.whatsapp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    phone: phone.value, 
                    message: text,
                    pdf_base64: pdfBase64,
                    filename: filename
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = '<i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">chat</i> WhatsApp-এ গ্রাহককে পাঠান';
                btn.disabled = false;
                Swal.close();

                if (data.success) {
                    Swal.fire('সফল!', 'WhatsApp-এ গ্রাহকের নম্বরে সরাসরি ইনভয়েস PDF ও বিবরণ পাঠানো হয়েছে।', 'success');
                } else {
                    Swal.fire('ত্রুটি!', data.message || 'ফাইল পাঠানো সম্ভব হয়নি।', 'error');
                }
            })
            .catch(err => {
                btn.innerHTML = '<i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">chat</i> WhatsApp-এ গ্রাহককে পাঠান';
                btn.disabled = false;
                Swal.fire('ত্রুটি!', 'সার্ভারের সাথে সমস্যা হচ্ছে।', 'error');
            });
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection
