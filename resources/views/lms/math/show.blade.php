@extends('layouts.app')

@section('title', $lesson->title . ' - penghor.com')

@section('content')
<div class="container py-4" style="color: var(--text-main); font-family: 'Outfit', 'Inter', 'Hind Siliguri', sans-serif;">
    <!-- Navigation Back Link -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('math.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="material-icons-round" style="font-size: 1.15rem;">arrow_back</i>
            <span>গণিত ক্লাসরুমে ফিরে যান</span>
        </a>
    </div>

    <!-- Header Lesson Card -->
    <div class="glass mb-4 p-4" style="border: 1px solid rgba(255, 255, 255, 0.08); background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(0, 0, 0, 0.4) 100%);">
        <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-bottom: 8px;">
            অধ্যায় {{ $lesson->chapter_no }}
        </span>
        <h1 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0;">{{ $lesson->title }}</h1>
    </div>

    <!-- Syllabus Content Block -->
    <div class="glass p-5 text-center" style="border: 1px solid rgba(255, 255, 255, 0.08); background: rgba(0, 0, 0, 0.2); border-radius: 16px;">
        <div style="margin-bottom: 20px; color: #fbbf24;">
            <i class="material-icons-round" style="font-size: 4rem;">lock</i>
        </div>
        <h3 style="color: #fff; font-weight: 700; font-size: 1.5rem; margin-bottom: 12px;">অধ্যায়ের বিস্তারিত তথ্য শীঘ্রই আসছে</h3>
        <p style="color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto 30px auto; line-height: 1.6;">
            <strong>{{ $lesson->title }}</strong> অধ্যায়ের নিয়ম, সূত্র, গাণিতিক সমাধান এবং কুইজ মডিউল খুব শীঘ্রই উন্মুক্ত করা হবে। অনুগ্রহ করে পরিসংখ্যান ক্লাসরুমে প্রবেশ করে সম্পূর্ণ গাইড ও সলভার ব্যবহার করুন।
        </p>
        <a href="{{ route('math.index') }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; text-decoration: none; padding: 10px 25px; border-radius: 8px; font-weight: 600;">
            অন্যান্য অধ্যায় দেখুন
        </a>
    </div>
</div>
@endsection
