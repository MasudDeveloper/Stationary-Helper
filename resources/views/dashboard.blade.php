@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড - Smart Stationary')

@section('content')
<div style="margin-top: 10px;">
    
    <!-- Welcome Banner -->
    <div class="glass" style="padding: 40px; margin-bottom: 40px; background: linear-gradient(135deg, rgba(20, 25, 40, 0.8) 0%, rgba(30, 36, 56, 0.4) 100%); border-left: 4px solid var(--primary-color);">
        <h2 style="color: #fff; margin-bottom: 12px; font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;">
            স্বাগতম, <span class="text-gradient">{{ Auth::user()->name }}</span>!
        </h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 600px; line-height: 1.6;">
            Smart Stationary-এর সম্পূর্ণ ড্যাশবোর্ড কন্ট্রোল প্যানেল। এখান থেকে আপনি আপনার সকল টুলস এবং সার্ভিস একসেস করতে পারবেন।
        </p>
    </div>
        
    <div class="grid-2" style="margin-bottom: 50px;">
        <!-- Account Info -->
        <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                    <div style="background: rgba(99, 102, 241, 0.15); padding: 12px; border-radius: 12px; color: var(--primary-hover);">
                        <i class="material-icons-round">badge</i>
                    </div>
                    <h3 style="color: var(--text-main); font-weight: 700; margin: 0;">অ্যাকাউন্টের তথ্য</h3>
                </div>
                
                <div style="background: rgba(0,0,0,0.2); padding: 16px; border-radius: 12px; margin-bottom: 16px; border: 1px solid rgba(255,255,255,0.03);">
                    <p style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">ইমেইল</p>
                    <p style="color: #fff; font-weight: 500;">{{ Auth::user()->email }}</p>
                </div>
                
                <div style="background: rgba(0,0,0,0.2); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.03); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">অ্যাকাউন্ট টাইপ</p>
                        <p style="color: #fff; font-weight: 500; text-transform: capitalize;">{{ Auth::user()->role }} User</p>
                    </div>
                    <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); padding: 6px 12px; border-radius: 8px; color: #fff; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; box-shadow: 0 4px 10px var(--primary-glow);">
                        Active
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Credit Balance -->
        <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1), transparent);">
            <div style="background: rgba(255,255,255,0.05); padding: 16px; border-radius: 50%; color: var(--primary-color); margin-bottom: 20px; box-shadow: 0 0 30px var(--primary-glow);">
                <i class="material-icons-round" style="font-size: 2.5rem;">account_balance_wallet</i>
            </div>
            
            <h3 style="margin-bottom: 12px; color: var(--text-muted); font-weight: 600; font-size: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">আপনার ক্রেডিট ব্যালেন্স</h3>
            <h1 style="font-size: 4rem; color: #fff; margin-bottom: 24px; font-weight: 800; line-height: 1;">
                ৳<span class="text-gradient">{{ Auth::user()->credits }}</span>
            </h1>
            <a href="{{ route('recharge') }}" class="btn btn-primary" style="padding: 14px 32px; border-radius: 30px;">
                <i class="material-icons-round" style="font-size: 1.1rem;">add_circle</i> ক্রেডিট রিচার্জ করুন
            </a>
        </div>
    </div>
    
    <div>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
            <div>
                <h3 style="font-weight: 800; font-size: 1.5rem; color: #fff; margin-bottom: 8px;">দ্রুত অ্যাক্সেস টুলস</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem;">আপনার প্রয়োজনীয় সকল প্রোডাক্টিভিটি টুলস এক জায়গায়</p>
            </div>
        </div>
        
        <div class="grid-3">
            
            <!-- Document Editor -->
            <a href="{{ route('document.index') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(99, 102, 241, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-hover);">
                        <i class="material-icons-round" style="font-size: 1.8rem;">description</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">ডকুমেন্ট এডিটিং</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">A4, A3, Legal, Letter ইত্যাদি সাইজে প্রফেশনাল পেজ তৈরি করুন</p>
                    </div>
                </div>
            </a>

            <!-- PDF Tools -->
            <a href="{{ route('pdf.tools') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(239, 68, 68, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #f87171;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">picture_as_pdf</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">পিডিএফ টুলস</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">পিডিএফ মার্জ, কমপ্রেস, ও নির্দিষ্ট পেজ আলাদা বা স্প্লিট করুন</p>
                    </div>
                </div>
            </a>

            <!-- Accounting -->
            <a href="{{ route('accounting.index') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(16, 185, 129, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #34d399;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">point_of_sale</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">আয়-ব্যয় হিসাব</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">প্রতিদিনের আয় ও ব্যয়ের ডিজিটাল বুককিপিং খাতা পরিচালনা করুন</p>
                    </div>
                </div>
            </a>

            <!-- Graphic Design -->
            <a href="{{ route('design.editor') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(236, 72, 153, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #f472b6;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">palette</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">ডিজাইন এডিটর</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">ব্যানার এবং ফেসবুক পোস্ট কাস্টমাইজ ও ডাউনলোড করুন</p>
                    </div>
                </div>
            </a>

            <!-- AI Service Hub -->
            <a href="{{ route('design.ai_hub') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(6, 182, 212, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #22d3ee;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">psychology</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">এআই হাব</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">এআই ইমেজ জেনারেশন ও ছবির অ্যাডভান্সড ব্যাকগ্রাউন্ড রিমুভার</p>
                    </div>
                </div>
            </a>

            <!-- Question Creator -->
            <a href="{{ route('questions.index') }}" style="text-decoration: none;">
                <div class="glass glass-interactive" style="height: 100%; display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: rgba(245, 158, 11, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">quiz</i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700;">প্রশ্নপত্র মেকার</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.6;">গণিত ও সমীকরণসহ সৃজনশীল ও MCQ প্রশ্নপত্র তৈরি করুন</p>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection
