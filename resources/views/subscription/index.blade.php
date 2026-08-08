@extends('layouts.app')

@section('title', 'সাবস্ক্রিপশন প্ল্যান - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="glass" style="max-width: 800px; margin: 0 auto; padding: 40px;">
        <h2 style="color: var(--primary-color); margin-bottom: 10px; text-align: center; font-weight: 700;">সাবস্ক্রিপশন প্ল্যান কিনুন</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">পছন্দসই প্ল্যান নির্বাচন করুন এবং বিকাশ পেমেন্টের মাধ্যমে আনলিমিটেড ব্যবহার উপভোগ করুন</p>
        
        @if (session('success'))
            <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        @php
            $manualEnabled = (\App\Models\Setting::where('key', 'gateway_manual_status')->value('value') ?? 'enabled') === 'enabled';
            $autoEnabled = (\App\Models\Setting::where('key', 'gateway_amargateway_status')->value('value') ?? 'disabled') === 'enabled';
        @endphp

        <!-- Active Subscription Status Card -->
        @if ($user->hasActiveSubscription())
            <div style="background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 30px;">
                <h4 style="color: #a5b4fc; margin-bottom: 5px; font-weight: 700;">আপনার সাবস্ক্রিপশন অ্যাক্টিভ আছে!</h4>
                <p style="color: #cbd5e1; margin-bottom: 5px;">
                    প্যাকেজ: <strong>
                        @if ($user->subscription_plan === '1_month') ১ মাস
                        @elseif ($user->subscription_plan === '6_months') ৬ মাস
                        @elseif ($user->subscription_plan === '1_year') ১ বছর
                        @endif
                    </strong>
                </p>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0;">
                    মেয়াদ শেষ হবে: <strong>{{ $user->subscription_expires_at->format('d M, Y h:i A') }}</strong>
                </p>
            </div>
        @endif

        <form method="POST" action="{{ route('subscription.buy') }}" id="subscriptionForm">
            @csrf
            
            <h4 style="margin-bottom: 15px; color: #fff;">১. সাবস্ক্রিপশন প্যাকেজ নির্বাচন করুন <span style="color:red">*</span></h4>
            
            <div class="plan-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <!-- 1 Month Plan -->
                <div class="plan-card" data-plan="1_month" data-price="50" onclick="selectPlan(this, '1_month', 50)" style="background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; position: relative;">
                    <div class="check-icon" style="display: none; position: absolute; top: 10px; right: 10px; color: #10b981;">
                        <i class="material-icons-round">check_circle</i>
                    </div>
                    <h3 style="color: #fff; margin-bottom: 5px; font-size: 1.3rem;">১ মাস</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 15px;">আনলিমিটেড অ্যাক্সেস</p>
                    <div style="margin: 15px 0;">
                        <span style="font-size: 2.3rem; font-weight: 800; color: #a5b4fc;">৳৫০</span>
                    </div>
                    <div style="background: rgba(0,0,0,0.3); padding: 8px; border-radius: 6px; font-weight: 600; color: #34d399; font-size: 0.9rem;">
                        ৳৫০ / মাস
                    </div>
                </div>

                <!-- 6 Months Plan -->
                <div class="plan-card" data-plan="6_months" data-price="250" onclick="selectPlan(this, '6_months', 250)" style="background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; position: relative;">
                    <div class="check-icon" style="display: none; position: absolute; top: 10px; right: 10px; color: #10b981;">
                        <i class="material-icons-round">check_circle</i>
                    </div>
                    <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #000; font-size: 0.75rem; font-weight: 800; padding: 3px 12px; border-radius: 50px; text-transform: uppercase;">সেরা ডিল</span>
                    <h3 style="color: #fff; margin-bottom: 5px; font-size: 1.3rem;">৬ মাস</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 15px;">আনলিমিটেড অ্যাক্সেস</p>
                    <div style="margin: 15px 0;">
                        <span style="font-size: 2.3rem; font-weight: 800; color: #a5b4fc;">৳২৫০</span>
                    </div>
                    <div style="background: rgba(0,0,0,0.3); padding: 8px; border-radius: 6px; font-weight: 600; color: #34d399; font-size: 0.9rem;">
                        ৳৪১.৬ / মাস
                    </div>
                </div>

                <!-- 1 Year Plan -->
                <div class="plan-card" data-plan="1_year" data-price="500" onclick="selectPlan(this, '1_year', 500)" style="background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; position: relative;">
                    <div class="check-icon" style="display: none; position: absolute; top: 10px; right: 10px; color: #10b981;">
                        <i class="material-icons-round">check_circle</i>
                    </div>
                    <h3 style="color: #fff; margin-bottom: 5px; font-size: 1.3rem;">১ বছর</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 15px;">আনলিমিটেড অ্যাক্সেস</p>
                    <div style="margin: 15px 0;">
                        <span style="font-size: 2.3rem; font-weight: 800; color: #a5b4fc;">৳৫০০</span>
                    </div>
                    <div style="background: rgba(0,0,0,0.3); padding: 8px; border-radius: 6px; font-weight: 600; color: #34d399; font-size: 0.9rem;">
                        ৳৪১.৬ / মাস
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="plan" id="selected_plan" value="" required>

            <div id="payment-details" style="display: none; transition: all 0.3s ease;">

                @if($manualEnabled && $autoEnabled)
                    <h4 style="margin-bottom: 15px; color: #fff;">২. পেমেন্ট মোড নির্বাচন করুন <span style="color:red">*</span></h4>
                    <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                        <label style="flex: 1; background: rgba(255,255,255,0.03); border: 2px solid #10b981; border-radius: 12px; padding: 15px; cursor: pointer; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px; border-color: #10b981; background: rgba(16, 185, 129, 0.05);" id="lbl-auto-mode">
                            <input type="radio" name="verification_mode" value="auto" checked onclick="toggleVerificationMode('auto')" style="accent-color: #10b981;">
                            <span style="color: #fff; font-weight: 600;">অটো ভেরিফিকেশন (Instant)</span>
                        </label>
                        <label style="flex: 1; background: rgba(255,255,255,0.03); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 15px; cursor: pointer; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;" id="lbl-manual-mode">
                            <input type="radio" name="verification_mode" value="manual" onclick="toggleVerificationMode('manual')" style="accent-color: #10b981;">
                            <span style="color: #fff; font-weight: 600;">ম্যানুয়াল ভেরিফিকেশন (১-১০ মিনিট)</span>
                        </label>
                    </div>
                @else
                    <input type="hidden" name="verification_mode" id="verification_mode" value="{{ $autoEnabled ? 'auto' : 'manual' }}">
                @endif

                <!-- Flow A: Auto Verification (AmarGateway API) -->
                @if($autoEnabled)
                <div id="flow-auto-verification" style="display: {{ $autoEnabled ? 'block' : 'none' }};">
                    <h4 style="margin-bottom: 15px; color: #fff;">পেমেন্ট গেটওয়ে দিয়ে অর্ডার করুন</h4>
                    <div class="form-group mb-4">
                        <label class="form-label">পেমেন্ট মেথড <span style="color:red">*</span></label>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            @foreach(['bkash' => 'bKash', 'nagad' => 'Nagad', 'rocket' => 'Rocket', 'upay' => 'Upay'] as $key => $name)
                                <label style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 12px; cursor: pointer; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px;" class="method-card" onclick="selectGatewayMethod('{{ $key }}')">
                                    <input type="radio" name="gateway_method" value="{{ $key }}" id="method-{{ $key }}" style="accent-color: #10b981; display:none;">
                                    <span style="color: #fff; font-weight: 600; font-size: 0.95rem;">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" onclick="initiateGatewayOrder()" class="btn btn-primary w-100" id="btn-gateway-order" style="padding: 14px; font-size: 1.1rem; font-weight: 600;">পেমেন্ট করুন</button>

                    <!-- Gateway Instructions Container -->
                    <div id="gateway-payment-box" style="display:none; margin-top: 30px;">
                        <div style="background: rgba(16, 185, 129, 0.1); border: 1px dashed #10b981; padding: 20px; border-radius: 8px; margin-bottom: 25px; text-align: center;">
                            <h4 style="margin-bottom: 10px; color: #34d399;">অটো-পেমেন্ট অর্ডার তৈরি হয়েছে!</h4>
                            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 15px;">নিচের <strong id="gatewayMethodName" style="text-transform:capitalize;"></strong> পার্সোনাল নম্বরে <strong id="gatewayDisplayPrice" style="color: #fbbf24;"></strong> টাকা <strong>Send Money</strong> করুন।</p>
                            <h2 style="color: #fff; letter-spacing: 2px; font-size: 2rem; margin: 0 0 15px 0;" id="gatewayTargetNumber"></h2>
                            <p style="color: #fbbf24; font-size: 0.85rem; margin-bottom: 0;">⚠️ রেফারেন্স বা টাকা পাঠানোর সময় অতিরিক্ত কোনো তথ্য দেওয়ার প্রয়োজন নেই। টাকা পাঠানোর পর নিচের বাটনে ক্লিক করে ভেরিফাই করুন।</p>
                        </div>
                        
                        <input type="hidden" id="gateway_order_ref" value="">
                        <button type="button" onclick="verifyGatewayStatus()" class="btn w-100" style="background: #10b981; color: #fff; padding: 14px; font-size: 1.1rem; font-weight: 700; border: none; border-radius: 8px;">আমি টাকা পাঠিয়েছি, ভেরিফাই করুন (Verify Payment)</button>
                    </div>
                </div>
                @endif

                <!-- Flow B: Manual Payment Request -->
                @if($manualEnabled)
                <div id="flow-manual-verification" style="display: {{ !$autoEnabled ? 'block' : 'none' }};">
                    @php
                        $bkashNumber = \App\Models\Setting::where('key', 'payment_bkash')->value('value') ?? '017XXXXXXXX';
                    @endphp
                    <div style="background: rgba(245, 158, 11, 0.1); border: 1px dashed var(--primary-color); padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                        <h4 style="margin-bottom: 10px; color: #fff;">বিকাশে ম্যানুয়াল পেমেন্ট করুন</h4>
                        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 15px;">নিচের পার্সোনাল নম্বরে <strong id="displayPrice" style="color: #f59e0b;"></strong> টাকা <strong>Send Money</strong> করুন।</p>
                        <h2 style="color: var(--text-main); letter-spacing: 2px; font-size: 2rem; margin: 0; display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                            {{ $bkashNumber }} 
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $bkashNumber }}').then(() => Swal.fire('নম্বর কপি হয়েছে!'))" style="background: rgba(255,255,255,0.1); border: none; color: #fff; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                                <i class="material-icons-round" style="font-size: 1rem;">content_copy</i>
                            </button>
                        </h2>
                    </div>

                    <h4 style="margin-bottom: 15px; color: #fff;">পেমেন্ট তথ্য দিন</h4>
                    <div class="form-group">
                        <label class="form-label">যে নম্বর থেকে টাকা পাঠিয়েছেন <span style="color:red">*</span></label>
                        <input type="text" name="sender_number" class="form-control" placeholder="আপনার বিকাশ নম্বর" value="{{ old('sender_number') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ট্রানজেকশন আইডি (TrxID) <span style="color:red">*</span></label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="TrxID দিন" value="{{ old('transaction_id') }}">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 14px; font-size: 1.1rem; font-weight: 600;">রিকোয়েস্ট সাবমিট করুন</button>
                </div>
                @endif

            </div>
        </form>
    </div>
</div>

<script>
    const bkashTarget = "{{ \App\Models\Setting::where('key', 'payment_bkash')->value('value') ?? '017XXXXXXXX' }}";
    const nagadTarget = "{{ \App\Models\Setting::where('key', 'payment_nagad')->value('value') ?? '016XXXXXXXX' }}";
    const rocketTarget = "{{ \App\Models\Setting::where('key', 'payment_rocket')->value('value') ?? '019XXXXXXXX' }}";

    function selectPlan(element, planName, price) {
        document.querySelectorAll('.plan-card').forEach(card => {
            card.style.borderColor = 'rgba(255,255,255,0.1)';
            card.style.background = 'rgba(255,255,255,0.05)';
            card.style.transform = 'scale(1)';
            card.querySelector('.check-icon').style.display = 'none';
        });

        element.style.borderColor = '#10b981';
        element.style.background = 'rgba(16, 185, 129, 0.05)';
        element.style.transform = 'scale(1.02)';
        element.querySelector('.check-icon').style.display = 'block';

        document.getElementById('selected_plan').value = planName;
        document.getElementById('payment-details').style.display = 'block';

        if (document.getElementById('displayPrice')) {
            document.getElementById('displayPrice').innerText = price;
        }
        if (document.getElementById('gatewayDisplayPrice')) {
            document.getElementById('gatewayDisplayPrice').innerText = price;
        }
    }

    function toggleVerificationMode(mode) {
        const manualFlow = document.getElementById('flow-manual-verification');
        const autoFlow = document.getElementById('flow-auto-verification');
        const lblAuto = document.getElementById('lbl-auto-mode');
        const lblManual = document.getElementById('lbl-manual-mode');

        if (mode === 'auto') {
            if(autoFlow) autoFlow.style.display = 'block';
            if(manualFlow) manualFlow.style.display = 'none';
            if(lblAuto) {
                lblAuto.style.borderColor = '#10b981';
                lblAuto.style.background = 'rgba(16, 185, 129, 0.05)';
            }
            if(lblManual) {
                lblManual.style.borderColor = 'rgba(255,255,255,0.1)';
                lblManual.style.background = 'rgba(255,255,255,0.03)';
            }
        } else {
            if(autoFlow) autoFlow.style.display = 'none';
            if(manualFlow) manualFlow.style.display = 'block';
            if(lblAuto) {
                lblAuto.style.borderColor = 'rgba(255,255,255,0.1)';
                lblAuto.style.background = 'rgba(255,255,255,0.03)';
            }
            if(lblManual) {
                lblManual.style.borderColor = '#10b981';
                lblManual.style.background = 'rgba(16, 185, 129, 0.05)';
            }
        }
    }

    function selectGatewayMethod(method) {
        document.querySelectorAll('.method-card').forEach(card => {
            card.style.borderColor = 'rgba(255,255,255,0.1)';
            card.style.background = 'rgba(255,255,255,0.05)';
        });

        const input = document.getElementById('method-' + method);
        input.checked = true;
        input.parentElement.style.borderColor = '#10b981';
        input.parentElement.style.background = 'rgba(16, 185, 129, 0.05)';
    }

    async function initiateGatewayOrder() {
        const plan = document.getElementById('selected_plan').value;
        const methodInput = document.querySelector('input[name="gateway_method"]:checked');

        if (!plan) {
            Swal.fire('দুঃখিত', 'অনুগ্রহ করে প্রথমে একটি প্যাকেজ নির্বাচন করুন।', 'error');
            return;
        }
        if (!methodInput) {
            Swal.fire('দুঃখিত', 'অনুগ্রহ করে পেমেন্ট মেথড (bKash/Nagad...) নির্বাচন করুন।', 'error');
            return;
        }

        const btn = document.getElementById('btn-gateway-order');
        btn.disabled = true;
        btn.innerText = 'অর্ডার তৈরি হচ্ছে...';

        try {
            const response = await fetch("{{ route('gateway.payment.create') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: 'subscription',
                    plan: plan,
                    payment_method: methodInput.value
                })
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById('gateway_order_ref').value = data.order_ref;
                document.getElementById('gatewayMethodName').innerText = methodInput.value;
                
                let targetNum = bkashTarget;
                if (methodInput.value === 'nagad') targetNum = nagadTarget;
                else if (methodInput.value === 'rocket') targetNum = rocketTarget;
                else if (methodInput.value === 'upay') targetNum = bkashTarget; // default fallback

                document.getElementById('gatewayTargetNumber').innerHTML = `${targetNum} <button type="button" onclick="navigator.clipboard.writeText('${targetNum}').then(() => Swal.fire('নম্বর কপি হয়েছে!'))" style="background: rgba(255,255,255,0.1); border: none; color: #fff; padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size:1rem;"><i class="material-icons-round" style="font-size: 1rem; vertical-align:middle;">content_copy</i></button>`;

                document.getElementById('gateway-payment-box').style.display = 'block';
                btn.style.display = 'none';
                Swal.fire('অর্ডার তৈরি হয়েছে!', 'নিচের নির্দেশনাবলী অনুসরণ করে পেমেন্ট করুন।', 'success');
            } else {
                Swal.fire('ত্রুটি', data.message || 'অর্ডার তৈরি করতে সমস্যা হয়েছে।', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('ত্রুটি', 'সার্ভার কানেকশন এরর হয়েছে। আবার চেষ্টা করুন।', 'error');
        } finally {
            btn.disabled = false;
            btn.innerText = 'পেমেন্ট করুন';
        }
    }

    async function verifyGatewayStatus() {
        const orderRef = document.getElementById('gateway_order_ref').value;
        if (!orderRef) return;

        Swal.fire({
            title: 'পেমেন্ট যাচাই করা হচ্ছে...',
            text: 'দয়া করে অপেক্ষা করুন।',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const response = await fetch("{{ route('gateway.payment.status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_ref: orderRef })
            });

            const data = await response.json();
            if (data.success) {
                Swal.fire('সফল!', 'আপনার পেমেন্ট সফলভাবে ভেরিফাই করা হয়েছে এবং সাবস্ক্রিপশন একটিভ হয়েছে!', 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('পেন্ডিং', data.message || 'পেমেন্ট এখনো ভেরিফাই হয়নি।', 'warning');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('ত্রুটি', 'সার্ভার যাচাইকরণ এরর। দয়া করে একটু পর আবার চেষ্টা করুন।', 'error');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const oldPlan = "{{ old('plan') }}";
        if(oldPlan) {
            const card = document.querySelector(`.plan-card[data-plan="${oldPlan}"]`);
            if(card) {
                const price = card.getAttribute('data-price');
                selectPlan(card, oldPlan, price);
            }
        }
    });
</script>
@endsection
