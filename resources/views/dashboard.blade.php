@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড - Smart Stationary')

@section('content')
<div style="margin-top: 10px;">

    <!-- Welcome Banner -->
    <div class="glass" style="padding: 40px; margin-bottom: 30px;">
        <h2 style="color: #fff; margin-bottom: 12px; font-size: 2.2rem; font-weight: 700; letter-spacing: -0.02em;">
            স্বাগতম, {{ Auth::user()->name }}!
        </h2>
        <p style="color: var(--text-muted); font-size: 1rem; max-width: 700px; line-height: 1.6; margin-bottom: 25px;">
            SmartStation কন্ট্রোল প্যানেলে আপনাকে স্বাগতম। এখান থেকে আপনি আপনার সমস্ত ডিজিটাল টুলস এবং সার্ভিসগুলো অত্যন্ত দক্ষতার সাথে পরিচালনা করতে পারবেন।
        </p>
        <div style="display: flex; gap: 15px;">
            <a href="#" class="btn btn-outline-primary" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 10px 20px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="font-size: 1.1rem;">bolt</i> Quick Start Guide
            </a>
            <a href="#" class="btn btn-outline-secondary" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 10px 20px; font-weight: 500; font-size: 0.9rem;">
                View System Logs
            </a>
        </div>
    </div>

    <div class="grid-2" style="margin-bottom: 40px;">
        <!-- Account Info -->
        <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin: 0;">অ্যাকাউন্ট ডিটেইলস</h3>
                    <div style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Active</div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                    <div style="background: rgba(255,255,255,0.05); padding: 10px; border-radius: 10px; color: var(--text-muted);">
                        <i class="material-icons-round" style="font-size: 1.2rem;">mail_outline</i>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0 0 4px 0;">ইমেইল ঠিকানা</p>
                        <p style="color: #fff; font-weight: 500; font-size: 1rem; margin: 0;">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 10px; color: #10b981;">
                        <i class="material-icons-round" style="font-size: 1.2rem;">verified_user</i>
                    </div>
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0 0 4px 0;">ব্যবহারকারীর ধরন</p>
                        <p style="color: #fff; font-weight: 500; font-size: 1rem; margin: 0; text-transform: capitalize;">Active {{ Auth::user()->role }} User</p>
                    </div>
                </div>
            </div>
            <div style="margin-top: 30px;">
                <a href="#" style="color: #818cf8; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 5px;">
                    Edit Profile Details <i class="material-icons-round" style="font-size: 1rem;">arrow_forward</i>
                </a>
            </div>
        </div>

        <!-- Credit Balance -->
        <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin: 0;">আপনার ক্রেডিট ব্যালেন্স</h3>
                    <div style="background: rgba(6, 182, 212, 0.15); color: #22d3ee; padding: 8px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="material-icons-round" style="font-size: 1.2rem;">payments</i>
                    </div>
                </div>

                <h1 style="font-size: 3rem; color: #a5b4fc; margin: 0 0 8px 0; font-weight: 700; line-height: 1;">
                    ৳{{ number_format(Auth::user()->credits, 2) }}
                </h1>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">ব্যালেন্স মেয়াদের কোনো সীমাবদ্ধতা নেই</p>
            </div>

            <div style="margin-top: 30px;">
                <a href="{{ route('recharge') }}" class="btn w-100" style="background: linear-gradient(135deg, #6366f1, #06b6d4); color: #fff; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 1rem;">
                    <i class="material-icons-round" style="font-size: 1.2rem;">add_circle_outline</i> ক্রেডিট রিচার্জ করুন
                </a>
            </div>
        </div>
    </div>

    <!-- Refer & Earn -->
    <div class="glass" style="margin-bottom: 40px; padding: 30px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        <div style="flex: 1; min-width: 300px;">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                <div style="background: rgba(234, 179, 8, 0.15); color: #eab308; padding: 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="material-icons-round" style="font-size: 1.5rem;">celebration</i>
                </div>
                <h3 style="color: #fff; font-weight: 700; font-size: 1.3rem; margin: 0;">রেফার করুন এবং আয় করুন</h3>
            </div>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0 0 15px 0;">
                আপনার রেফারেল লিংক ব্যবহার করে কেউ অ্যাকাউন্ট খুললে এবং রিচার্জ করলে আপনি পাবেন নিশ্চিত কমিশন। আপনার রেফারেল লিংকটি বন্ধুদের সাথে শেয়ার করুন!
            </p>
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <div style="background: rgba(0,0,0,0.2); padding: 10px 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); color: #a5b4fc; font-family: monospace; font-size: 1.1rem;">
                    {{ url('/register?ref=' . Auth::user()->referral_code) }}
                </div>
                <button data-link="{{ url('/register?ref=' . Auth::user()->referral_code) }}" onclick="navigator.clipboard.writeText(this.getAttribute('data-link')).then(() => Swal.fire('লিংক কপি হয়েছে!'))" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 10px 15px; border-radius: 8px; font-weight: 600;">
                    <i class="material-icons-round" style="font-size: 1.1rem; vertical-align: middle;">content_copy</i> কপি লিংক
                </button>
            </div>
        </div>
        <div style="background: rgba(0,0,0,0.15); padding: 25px; border-radius: 12px; border: 1px dashed rgba(255,255,255,0.2); min-width: 250px; text-align: center;">
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0 0 5px 0;">মোট রেফার করেছেন</p>
            <h2 style="color: #10b981; font-size: 2.5rem; margin: 0; font-weight: 700;">{{ Auth::user()->referrals()->count() }}</h2>
            <p style="color: var(--text-muted); font-size: 0.8rem; margin: 5px 0 0 0;">জন ইউজার</p>
        </div>
    </div>

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h3 style="font-weight: 700; font-size: 1.3rem; color: #fff; margin: 0; border-left: 3px solid #818cf8; padding-left: 10px;">দ্রুত অ্যাক্সেস টুলস</h3>
            <a href="#" style="color: var(--text-muted); font-size: 0.9rem; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                সকল টুলস দেখুন <i class="material-icons-round" style="font-size: 1rem;">open_in_new</i>
            </a>
        </div>

        <div class="grid-3" style="gap: 20px;">

            <!-- Document Editor -->
            <a href="{{ route('document.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(99, 102, 241, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #818cf8; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">description</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Document Editor</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">প্রফেশনাল ডকুমেন্ট তৈরি এবং এডিট করার উন্নত টুল।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>
            <!-- WhatsApp Connect -->
            <a href="{{ route('whatsapp.connect') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(37, 211, 102, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #25D366; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">qr_code_scanner</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">WhatsApp Connect</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">QR স্ক্যান করে আপনার নিজের WhatsApp কানেক্ট করুন</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- CV Maker -->
            <a href="{{ route('cv.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(16, 185, 129, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #10b981; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">contact_page</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">CV Maker</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">সহজেই প্রফেশনাল এবং আকর্ষণীয় সিভি তৈরি করুন।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- PDF Tools -->
            <a href="{{ route('pdf.tools') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(6, 182, 212, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #22d3ee; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">picture_as_pdf</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">PDF Tools</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">PDF ফাইল কনভার্ট, মার্জ এবং কম্প্রেস করার সমাধান।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Photo Maker -->
            <a href="{{ route('photo.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(234, 179, 8, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #eab308; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">portrait</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Photo Maker</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">ছবি আপলোড করে পাসপোর্ট সাইজ ক্রপ এবং কালার চেঞ্জ করুন।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Accounting -->
            <a href="{{ route('accounting.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(236, 72, 153, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f472b6; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">account_balance</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Income-Expense</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">আপনার আয় ও ব্যয়ের হিসাব রাখুন ডিজিটাল পদ্ধতিতে।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- AI Service Hub -->
            <a href="{{ route('design.ai_hub') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(16, 185, 129, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #34d399; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">psychology</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">AI Hub</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">কৃত্রিম বুদ্ধিমত্তার সাহায্যে কাজগুলো করুন মুহূর্তেই।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Question Creator -->
            <a href="{{ route('questions.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(239, 68, 68, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f87171; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">quiz</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Question Maker</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">স্বয়ংক্রিয়ভাবে পরীক্ষার প্রশ্নপত্র তৈরির আধুনিক টুল।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Typing Test -->
            <a href="{{ route('typing-test.index') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(139, 92, 246, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #a78bfa; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">keyboard</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Typing Test</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">টাইপিং স্পিড এবং অ্যাকুরেসি লাইভ চেক করুন।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Passport Print Auto Arrange -->
            <a href="{{ route('pdf.tools.passport_print') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(59, 130, 246, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #60a5fa; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">auto_awesome_mosaic</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Passport Layout</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">পাসপোর্ট ছবি 4R/A4 পেপারে অটোমেটিক সাজান।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Joint Photo Maker -->
            <a href="{{ route('pdf.tools.joint_photo') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(168, 85, 247, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #c084fc; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">people_alt</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Joint Photo Maker</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">স্বামী-স্ত্রী বা দুজনের ছবি একসাথে পাসপোর্ট সাইজ করুন।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

            <!-- Document Scanner (Perspective Crop) -->
            <a href="{{ route('pdf.tools.document_scanner') }}" style="text-decoration: none; display: block;">
                <div class="glass glass-interactive" style="height: 100%; padding: 25px; position: relative;">
                    <div style="background: rgba(236, 72, 153, 0.1); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ec4899; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 1.5rem;">document_scanner</i>
                    </div>
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Document Scanner</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">বাঁকাত্যারা ছবি বা ডকুমেন্ট ফটোশপের মতো সোজা ও ক্রপ করুন।</p>
                    <i class="material-icons-round" style="position: absolute; bottom: 20px; right: 20px; color: var(--text-muted); font-size: 1.2rem;">arrow_forward</i>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection