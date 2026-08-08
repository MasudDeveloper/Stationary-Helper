@extends('layouts.app')

@section('title', 'রেফারেল ও আয় - penghor.com')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 60px;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 35px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #fff; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 12px; font-size: 2.2rem;">
                <div style="background: rgba(16, 185, 129, 0.15); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="material-icons-round" style="color: #10b981; font-size: 1.8rem;">diversity_3</i>
                </div>
                রেফারেল ও আয়
            </h2>
            <p style="color: var(--text-muted); margin-top: 8px; margin-bottom: 0; font-size: 1.05rem;">আপনার রেফারেল লিংক শেয়ার করে আজীবন ইনকাম করুন</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.3s;">
            <i class="material-icons-round" style="font-size: 1.2rem;">arrow_back</i> ড্যাশবোর্ডে যান
        </a>
    </div>

    <!-- Referral Stats & Link -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="glass" style="padding: 35px; height: 100%; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
                <!-- Decorative background -->
                <div style="position: absolute; right: -30px; top: -30px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%;"></div>
                
                <h4 style="color: #fff; margin-bottom: 15px; font-weight: 700; position: relative; z-index: 1;">আপনার স্পেশাল রেফারেল লিংক</h4>
                <p style="color: var(--text-muted); font-size: 1rem; margin-bottom: 25px; line-height: 1.6; position: relative; z-index: 1;">আপনার এই লিংক দিয়ে কেউ একাউন্ট খুললে, তার করা প্রতিটি পেইড কাজের (যেমন: সি‌ভি বানানো, টাইপিং টেস্ট) জন্য আপনি <strong>২০% লাইফটাইম কমিশন</strong> পাবেন!</p>
                
                @php
                    $referralLink = route('register', ['ref' => Auth::user()->referral_code]);
                @endphp
                <div style="background: rgba(0,0,0,0.4); padding: 8px 8px 8px 20px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 15px; position: relative; z-index: 1; box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);">
                    <input type="text" value="{{ $referralLink }}" id="refLink" readonly style="background: transparent; border: none; color: #a5b4fc; font-weight: 600; font-family: monospace; font-size: 1.05rem; flex: 1; outline: none; width: 100%;">
                    <button onclick="copyRefLink()" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; border: none; border-radius: 40px; padding: 12px 25px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: transform 0.2s;">
                        <i class="material-icons-round" style="font-size: 1.1rem;">content_copy</i> কপি করুন
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="glass" style="padding: 35px; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; border-bottom: 4px solid #818cf8;">
                <div style="background: rgba(99, 102, 241, 0.1); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="material-icons-round" style="font-size: 2.2rem; color: #818cf8;">group_add</i>
                </div>
                <h2 style="color: #fff; margin: 0 0 5px 0; font-size: 2.8rem; font-weight: 800;">{{ $totalReferrals }}</h2>
                <p style="color: var(--text-muted); margin: 0; font-size: 1rem; font-weight: 500;">মোট রেফারেল</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="glass" style="padding: 35px; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; border-bottom: 4px solid #10b981;">
                <div style="background: rgba(16, 185, 129, 0.1); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                    <i class="material-icons-round" style="font-size: 2.2rem; color: #10b981;">account_balance_wallet</i>
                </div>
                <h2 style="color: #10b981; margin: 0 0 5px 0; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px;">৳{{ number_format($totalEarned, 2) }}</h2>
                <p style="color: var(--text-muted); margin: 0; font-size: 1rem; font-weight: 500;">সর্বমোট আয়</p>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div style="display: flex; gap: 15px; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
        <button onclick="switchTab('earnings-tab')" class="tab-btn active" id="btn-earnings-tab" style="background: transparent; border: none; color: #fff; font-size: 1.1rem; font-weight: 700; padding: 10px 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #6366f1; transition: all 0.3s;">
            <i class="material-icons-round">history</i> আয়ের বিস্তারিত হিস্ট্রি
        </button>
        <button onclick="switchTab('users-tab')" class="tab-btn" id="btn-users-tab" style="background: transparent; border: none; color: var(--text-muted); font-size: 1.1rem; font-weight: 600; padding: 10px 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid transparent; transition: all 0.3s;">
            <i class="material-icons-round">people</i> রেফারকৃত ব্যবহারকারীগণ
        </button>
    </div>

    <!-- Earnings History Tab -->
    <div id="earnings-tab" class="tab-content">
        <div class="glass" style="padding: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="table-responsive">
                <table class="table table-borderless" style="margin: 0; color: #fff;">
                    <thead style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <tr>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">তারিখ ও সময়</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">ইউজার</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">সার্ভিস / কাজের ধরন</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; text-align: right;">কমিশন (২০%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($earnings as $earning)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.03); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px 25px;">
                                <div style="font-weight: 600; color: #e2e8f0;">{{ $earning->created_at->format('d M, Y') }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">{{ $earning->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="padding: 20px 25px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #a855f7); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;">
                                        {{ substr($earning->referredUser->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div style="font-weight: 500; font-size: 1.05rem;">{{ $earning->referredUser->name ?? 'Unknown User' }}</div>
                                </div>
                            </td>
                            <td style="padding: 20px 25px; text-transform: capitalize;">
                                <span style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); color: #818cf8; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                    {{ $earning->source_type }}
                                </span>
                            </td>
                            <td style="padding: 20px 25px; text-align: right;">
                                <div style="font-weight: 800; color: #10b981; font-size: 1.2rem;">
                                    + ৳{{ number_format($earning->amount, 2) }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center" style="padding: 80px 20px;">
                                <div style="background: rgba(255,255,255,0.02); width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                                    <i class="material-icons-round" style="font-size: 3.5rem; color: #475569;">money_off</i>
                                </div>
                                <h4 style="color: #94a3b8; font-weight: 600; margin-bottom: 10px;">এখনো কোনো আয় হয়নি</h4>
                                <p style="color: #64748b; max-width: 400px; margin: 0 auto;">আপনার রেফারেল লিংক বেশি বেশি শেয়ার করুন এবং লাইফটাইম প্যাসিভ ইনকাম শুরু করুন!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($earnings->hasPages())
            <div style="padding: 20px 25px; background: rgba(0,0,0,0.1); border-top: 1px solid rgba(255,255,255,0.05);">
                {{ $earnings->appends(request()->except('earnings_page'))->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Referred Users Tab -->
    <div id="users-tab" class="tab-content" style="display: none;">
        <div class="glass" style="padding: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="table-responsive">
                <table class="table table-borderless" style="margin: 0; color: #fff;">
                    <thead style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <tr>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">রেজিস্ট্রেশন তারিখ</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">ইউজার আইডি</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">নাম ও ইমেইল</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">অ্যাক্টিভ সাবস্ক্রিপশন</th>
                            <th style="padding: 20px 25px; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; text-align: right;">ক্রেডিট ব্যালেন্স</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referredUsers as $refUser)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.03); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px 25px;">
                                <div style="font-weight: 600; color: #e2e8f0;">{{ $refUser->created_at->format('d M, Y') }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">{{ $refUser->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="padding: 20px 25px; font-family: monospace; color: #a5b4fc; font-weight: 600;">
                                {{ $refUser->account_id }}
                            </td>
                            <td style="padding: 20px 25px;">
                                <div style="font-weight: 600; font-size: 1.05rem; color: #fff;">{{ $refUser->name }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">{{ $refUser->email }}</div>
                            </td>
                            <td style="padding: 20px 25px;">
                                @if ($refUser->hasActiveSubscription())
                                    <span style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        অ্যাক্টিভ ({{ $refUser->subscription_plan === '1_month' ? '১ মাস' : ($refUser->subscription_plan === '6_months' ? '৬ মাস' : '১ বছর') }})
                                    </span>
                                @else
                                    <span style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-block;">
                                        কোনোটিই নয়
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 20px 25px; text-align: right; font-weight: 700; color: #cbd5e1; font-size: 1.1rem;">
                                {{ $refUser->credits }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 80px 20px;">
                                <div style="background: rgba(255,255,255,0.02); width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                                    <i class="material-icons-round" style="font-size: 3.5rem; color: #475569;">people_outline</i>
                                </div>
                                <h4 style="color: #94a3b8; font-weight: 600; margin-bottom: 10px;">কোনো রেফারেল ইউজার নেই</h4>
                                <p style="color: #64748b; max-width: 400px; margin: 0 auto;">আপনার রেফারেল কোড ব্যবহার করে ইউজারদের সাইনআপ করান!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($referredUsers->hasPages())
            <div style="padding: 20px 25px; background: rgba(0,0,0,0.1); border-top: 1px solid rgba(255,255,255,0.05);">
                {{ $referredUsers->appends(request()->except('users_page'))->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.color = 'var(--text-muted)';
            btn.style.borderBottomColor = 'transparent';
            btn.classList.remove('active');
        });

        document.getElementById(tabId).style.display = 'block';
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.style.color = '#fff';
        activeBtn.style.borderBottomColor = '#6366f1';
        activeBtn.classList.add('active');
    }

    // Auto switch tab if pagination page is requested
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('users_page')) {
            switchTab('users-tab');
        }
    });

    function copyRefLink() {
        var copyText = document.getElementById("refLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value);
        
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'লিংক কপি করা হয়েছে!',
            showConfirmButton: false,
            timer: 3000,
            background: '#1e293b',
            color: '#fff'
        });
    }
</script>
@endsection
