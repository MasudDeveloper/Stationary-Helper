@extends('layouts.app')

@section('title', 'লার্নিং হাব (LMS) - penghor.com')

@section('content')
<div class="container py-5" style="color: var(--text-main); font-family: 'Outfit', 'Inter', 'Hind Siliguri', sans-serif;">
    
    <!-- Hero Banner with Stats -->
    <div class="glass" style="padding: 40px; margin-bottom: 40px; position: relative; overflow: hidden; border-radius: 24px; border: 1px solid rgba(245, 158, 11, 0.25); background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%);">
        <!-- Glowing background blobs -->
        <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 70%); z-index: 1; pointer-events: none;"></div>
        
        <div style="position: relative; z-index: 2;">
            <div style="margin-bottom: 20px;">
                <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 8px 20px; border-radius: 30px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="material-icons-round" style="font-size: 1rem;">school</i> লার্নিং পোর্টাল (LMS)
                </span>
            </div>

            <h1 style="font-size: 2.8rem; font-weight: 800; color: #fff; margin-bottom: 12px; letter-spacing: -0.5px; line-height: 1.2;">
                স্বাগতম লার্নিং হাব-এ! 🎓
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 700px; line-height: 1.6; margin-bottom: 30px;">
                পেনহোর লার্নিং ম্যানেজমেন্ট পোর্টালে আপনার স্বাগতম। হিসাববিজ্ঞান, ইংরেজি গ্রামার এবং গণিত বিষয়ের জটিল টপিকগুলো সহজে শিখতে নিচে যেকোনো একটি সাবজেক্ট নির্বাচন করুন।
            </p>

            <!-- Learning Progress Section -->
            <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.05); padding: 25px; border-radius: 16px; max-width: 600px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="color: #fff; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                        <i class="material-icons-round" style="color: #fbbf24; font-size: 1.1rem;">insights</i> সামগ্রিক অগ্রগতি (Overall Progress)
                    </span>
                    <span style="color: #fbbf24; font-weight: 700; font-size: 1rem;">{{ $progressPercent }}%</span>
                </div>
                <!-- Progress Bar -->
                <div style="width: 100%; height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px; overflow: hidden; margin-bottom: 15px;">
                    <div style="width: {{ $progressPercent }}%; height: 100%; background: linear-gradient(90deg, #f59e0b, #fbbf24); border-radius: 5px; transition: width 0.5s ease-in-out;"></div>
                </div>
                <div style="display: flex; gap: 20px; font-size: 0.85rem; color: var(--text-muted);">
                    <div>মোট অধ্যায়/লেসন: <strong style="color: #fff;">{{ $totalLessons }}টি</strong></div>
                    <div>সম্পন্ন করেছেন: <strong style="color: #10b981;">{{ $totalCompleted }}টি</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Grid -->
    <div>
        <div style="margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
            <span style="width: 24px; height: 4px; background-color: #f59e0b; display: inline-block; border-radius: 2px;"></span>
            <h3 style="color: #fff; font-weight: 800; font-size: 1.4rem; margin: 0; letter-spacing: 0.5px;">
                পড়াশোনার বিষয়সমূহ (Subjects)
            </h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 30px;">
            
            <!-- Subject 1: Accounting -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 300px; border-radius: 20px; border: 1px solid rgba(16, 185, 129, 0.25); background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative;">
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%); pointer-events: none;"></div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="material-icons-round" style="color: #34d399; font-size: 1.6rem;">account_balance_wallet</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">সক্রিয় (Active)</span>
                    </div>

                    <h4 style="color: #fff; font-size: 1.35rem; font-weight: 700; margin: 0 0 10px 0;">হিসাববিজ্ঞান ক্লাসরুম</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin: 0 0 20px 0;">
                        লেনদেনের দুতরফা দাখিলা পদ্ধতি, খতিয়ান ভুক্তি এবং ডেবিট/ক্রেডিট নির্ণয় করার চমৎকার ইন্টারেক্টিভ লার্নিং মডিউল ও এক্সারসাইজ সলভার।
                    </p>
                </div>

                <div>
                    <!-- Mini progress info -->
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px;">
                        <span>লেসন সংখ্যা: <strong>{{ $accountingLessonsCount }}টি</strong></span>
                        <span>সম্পন্ন: <strong style="color: #34d399;">{{ $accountingCompleted }}টি</strong></span>
                    </div>
                    
                    <a href="{{ route('accounting.solver.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600; text-align: center; display: block; transition: transform 0.2s;">
                        ক্লাসে প্রবেশ করুন <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-left: 4px;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- Subject 2: English Grammar -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 300px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative;">
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%); pointer-events: none;"></div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">spellcheck</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">সক্রিয় (Active)</span>
                    </div>

                    <h4 style="color: #fff; font-size: 1.35rem; font-weight: 700; margin: 0 0 10px 0;">ইংরেজি গ্রামার ক্লাসরুম</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin: 0 0 20px 0;">
                        টেন্স (Tense), ন্যারেশন (Narration) এবং অন্যান্য গ্রামাটিক্যাল রুলস সহজে শিখুন এবং লাইভ কুইজে অংশ নিয়ে নিজেকে যাচাই করুন।
                    </p>
                </div>

                <div>
                    <!-- Mini progress info -->
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px;">
                        <span>লেসন সংখ্যা: <strong>{{ $englishLessonsCount }}টি</strong></span>
                        <span>সম্পন্ন: <strong style="color: #818cf8;">{{ $englishCompleted }}টি</strong></span>
                    </div>
                    
                    <a href="{{ route('grammar.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600; text-align: center; display: block; transition: transform 0.2s;">
                        ক্লাসে প্রবেশ করুন <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-left: 4px;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- Subject 3: Mathematics -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 300px; border-radius: 20px; border: 1px solid rgba(245, 158, 11, 0.25); background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative;">
                
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="material-icons-round" style="color: #fbbf24; font-size: 1.6rem;">functions</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">সক্রিয় (Active)</span>
                    </div>

                    <h4 style="color: #fff; font-size: 1.35rem; font-weight: 700; margin: 0 0 10px 0;">গণিত ক্লাসরুম</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin: 0 0 20px 0;">
                        পাটিগণিত, বীজগণিত ও জ্যামিতির বিভিন্ন সূত্রাবলী, সমীকরণ সমাধান করার শর্টকাট কৌশল এবং ইন্টারেক্টিভ কুইজ নিয়ে আসছে নতুন মডিউল।
                    </p>
                </div>

                <div>
                    <!-- Mini progress info -->
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px;">
                        <span>লেসন সংখ্যা: <strong>{{ $mathLessonsCount }}টি</strong></span>
                        <span>সম্পন্ন: <strong style="color: #fbbf24;">{{ $mathCompleted }}টি</strong></span>
                    </div>
                    
                    <a href="{{ route('math.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600; text-align: center; display: block; transition: transform 0.2s;">
                        ক্লাসে প্রবেশ করুন <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-left: 4px;">arrow_forward</i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    
</div>
@endsection
