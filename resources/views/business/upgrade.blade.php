@extends('layouts.app')

@section('title', 'বিজনেস একাউন্টে আপগ্রেড - penghor.com')

@section('content')

@if(isset($settings['upgrade_banner_url']) && !empty($settings['upgrade_banner_url']))
<div style="width: 100%; height: 250px; border-radius: 12px; overflow: hidden; margin-bottom: -60px; position: relative; z-index: 0;">
    <img src="{{ $settings['upgrade_banner_url'] }}" alt="Upgrade Banner" style="width: 100%; height: 100%; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(15, 23, 42, 1) 100%);"></div>
</div>
@endif

<div class="container" style="position: relative; z-index: 1; padding-bottom: 60px; @if(!isset($settings['upgrade_banner_url']) || empty($settings['upgrade_banner_url'])) margin-top: 40px; @endif">
    <div class="glass" style="max-width: 800px; margin: 0 auto; padding: 40px; border-top: 4px solid #f59e0b; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        
        <div style="text-align: center; margin-bottom: 35px;">
            <div style="background: rgba(245, 158, 11, 0.15); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="material-icons-round" style="color: #f59e0b; font-size: 2.5rem;">storefront</i>
            </div>
            <h2 style="color: #fff; margin-bottom: 10px; font-weight: 800; font-size: 2rem;">
                বিজনেস একাউন্টে আপগ্রেড করুন
            </h2>
            <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 600px; margin: 0 auto;">
                বিজনেস একাউন্ট ব্যবহার করে আপনি সরাসরি এডমিন থেকে স্পেশাল কাজ বা অর্ডার পেতে পারেন এবং সেগুলো সম্পন্ন করে আরও বেশি আয় করতে পারেন।
            </p>
        </div>
        
        @if (session('success'))
            <div style="background: rgba(16, 185, 129, 0.15); border-left: 4px solid #10b981; color: #10b981; padding: 16px 20px; border-radius: 8px; margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                <i class="material-icons-round">check_circle</i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div style="background: rgba(239, 68, 68, 0.15); border-left: 4px solid #ef4444; color: #ef4444; padding: 16px 20px; border-radius: 8px; margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                <i class="material-icons-round">error</i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if($existingRequest)
            <div style="background: rgba(99, 102, 241, 0.1); border: 1px dashed rgba(129, 140, 248, 0.5); padding: 40px; border-radius: 16px; text-align: center;">
                <div class="spinner-border" style="width: 3rem; height: 3rem; color: #818cf8; margin-bottom: 20px;" role="status"></div>
                <h3 style="color: #fff; margin-bottom: 12px; font-weight: 700;">রিকোয়েস্ট পেন্ডিং রয়েছে!</h3>
                <p style="color: var(--text-muted); margin: 0; font-size: 1.05rem; line-height: 1.6;">আপনি ইতিমধ্যে বিজনেস একাউন্টে আপগ্রেড করার জন্য একটি রিকোয়েস্ট পাঠিয়েছেন। এডমিন এটি যাচাই করে অনুমোদন দিলে আপনার একাউন্টটি আপডেট হয়ে যাবে। দয়া করে অপেক্ষা করুন।</p>
            </div>
        @else
            <form method="POST" action="{{ route('business.upgrade') }}" id="upgradeForm">
                @csrf
                
                <div style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 16px; margin-bottom: 35px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 25px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 25px;">
                        <div>
                            <h4 style="color: #fff; margin: 0; font-weight: 600;">আপগ্রেড ফি</h4>
                            <p style="color: var(--text-muted); margin: 5px 0 0 0; font-size: 0.9rem;">এককালীন চার্জ</p>
                        </div>
                        <div style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 10px 20px; border-radius: 50px; font-size: 1.5rem; font-weight: 800;">
                            ৳{{ $upgradeFee }}
                        </div>
                    </div>

                    <div class="row g-4 mb-2">
                        <div class="col-md-5">
                            <label class="form-label text-white" style="font-weight: 500; margin-bottom: 10px;">পেমেন্ট মেথড নির্বাচন করুন</label>
                            <div style="position: relative;">
                                <select name="payment_method" id="paymentMethod" class="form-select" style="background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); padding: 12px 15px; border-radius: 8px; font-size: 1rem; cursor: pointer;" required onchange="updatePaymentNumber()">
                                    @if(isset($settings['payment_bkash']) && !empty($settings['payment_bkash']))
                                        <option value="bkash" style="color: #000;">bKash</option>
                                    @endif
                                    @if(isset($settings['payment_nagad']) && !empty($settings['payment_nagad']))
                                        <option value="nagad" style="color: #000;">Nagad</option>
                                    @endif
                                    @if(isset($settings['payment_rocket']) && !empty($settings['payment_rocket']))
                                        <option value="rocket" style="color: #000;">Rocket</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label text-white" style="font-weight: 500; margin-bottom: 10px;">এই নম্বরে Send Money করুন</label>
                            <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 8px 12px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img id="methodIcon" src="https://seeklogo.com/images/B/bkash-logo-0C1572FBB4-seeklogo.com.png" alt="Icon" style="width: 24px; height: 24px; object-fit: contain;">
                                    <span id="paymentNumberDisplay" style="color: #fff; font-size: 1.2rem; font-weight: 700; letter-spacing: 1px;">
                                        {{ $settings['payment_bkash'] ?? 'Not Set' }}
                                    </span>
                                </div>
                                <button type="button" onclick="copyPaymentNumber()" class="btn btn-sm" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                    কপি করুন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label class="form-label text-white" style="font-weight: 500; margin-bottom: 10px;">TrxID (ট্রানজেকশন আইডি) <span class="text-danger">*</span></label>
                    <div style="position: relative;">
                        <i class="material-icons-round" style="position: absolute; left: 15px; top: 13px; color: var(--text-muted);">receipt_long</i>
                        <input type="text" name="trx_id" class="form-control" placeholder="e.g. 8H3KJ..." style="background: rgba(0,0,0,0.2); color: white; border: 1px solid rgba(255,255,255,0.1); padding: 12px 15px 12px 45px; border-radius: 8px; font-size: 1.05rem;" required>
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 8px;">পেমেন্ট সম্পন্ন হওয়ার পর প্রাপ্ত ট্রানজেকশন আইডিটি এখানে দিন।</small>
                </div>

                <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #f59e0b, #ea580c); color: #fff; border: none; padding: 16px; border-radius: 12px; font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3); transition: all 0.3s ease;">
                    <i class="material-icons-round">bolt</i> আপগ্রেড রিকোয়েস্ট পাঠান
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    const paymentNumbers = {
        'bkash': '{{ $settings["payment_bkash"] ?? "Not Set" }}',
        'nagad': '{{ $settings["payment_nagad"] ?? "Not Set" }}',
        'rocket': '{{ $settings["payment_rocket"] ?? "Not Set" }}'
    };
    
    const paymentIcons = {
        'bkash': 'https://seeklogo.com/images/B/bkash-logo-0C1572FBB4-seeklogo.com.png',
        'nagad': 'https://download.logo.wine/logo/Nagad/Nagad-Logo.wine.png',
        'rocket': 'https://seeklogo.com/images/D/dutch-bangla-rocket-logo-B4D1047331-seeklogo.com.png'
    };

    function updatePaymentNumber() {
        const method = document.getElementById('paymentMethod').value;
        const number = paymentNumbers[method] || 'Not Set';
        const iconUrl = paymentIcons[method];
        
        document.getElementById('paymentNumberDisplay').innerText = number;
        document.getElementById('methodIcon').src = iconUrl;
    }
    
    function copyPaymentNumber() {
        const text = document.getElementById('paymentNumberDisplay').innerText;
        if(text === 'Not Set') {
            Swal.fire({
                icon: 'error',
                title: 'দুঃখিত',
                text: 'কোনো নম্বর সেট করা নেই!'
            });
            return;
        }
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'নম্বর কপি করা হয়েছে!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', updatePaymentNumber);
</script>
@endsection
