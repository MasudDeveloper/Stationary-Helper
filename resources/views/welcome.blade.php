@extends('layouts.app')

@section('title', 'সহজ কাজ - প্রফেশনাল স্টেশনারি ও বুককিপিং অ্যাসিস্ট্যান্ট')

@section('content')
<style>
    .welcome-hero {
        text-align: center;
        padding: 80px 20px;
        background: radial-gradient(circle at center, rgba(245, 158, 11, 0.1) 0%, transparent 60%);
        border-radius: 24px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background-color: var(--bg-sidebar);
    }
    
    .hero-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.05) 0%, transparent 70%);
        pointer-events: none;
        animation: floatGlow 15s linear infinite;
    }
    
    @keyframes floatGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .welcome-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
        line-height: 1.2;
        background: linear-gradient(135deg, #fff 30%, var(--primary-color) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-subtitle {
        font-size: 1.25rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto 35px auto;
        line-height: 1.6;
    }

    .feature-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: left;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .feature-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.1);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: rgba(245, 158, 11, 0.1);
        color: var(--primary-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .feature-icon i {
        font-size: 1.5rem;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--text-main);
    }

    .feature-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        flex: 1;
    }
</style>

<div class="welcome-hero">
    <div class="hero-glow"></div>
    <h1 class="welcome-title">সহজ সমাধান, সব কাজ এক জায়গায়</h1>
    <p class="welcome-subtitle">
        ডকুমেন্ট এডিটিং, অ্যাকাউন্ট বুককিপিং, পিডিএফ মার্জ-স্প্লিট, প্রশ্নপত্র মেকার এবং এআই জেনারেশন সার্ভিস ব্যবহার করুন এক ক্লিকে।
    </p>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">ড্যাশবোর্ডে প্রবেশ করুন</a>
    @else
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('login') }}" class="btn btn-primary">লগইন করুন</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">নতুন অ্যাকাউন্ট খুলুন</a>
        </div>
    @endauth
</div>

<h2 style="text-align: center; margin-bottom: 40px; font-size: 2rem; font-weight: 800;">আমাদের সেবাসমূহ</h2>

<div class="grid-3" style="margin-bottom: 80px;">
    <!-- Document Editor -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">description</i>
        </div>
        <h3 class="feature-title">১. প্রফেশনাল ডকুমেন্ট এডিটর</h3>
        <p class="feature-desc">A4, A3, Legal, Letter এবং Stamp সাইজ পেজ লেআউট ও মার্জিন কনট্রোল সহ সরাসরি এডিটিং ও প্রিন্ট করার সুবিধা।</p>
    </div>

    <!-- PDF Tools -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">picture_as_pdf</i>
        </div>
        <h3 class="feature-title">২. পিডিএফ মার্জ ও স্প্লিট</h3>
        <p class="feature-desc">একাধিক পিডিএফ ফাইলকে একটি ফাইলে রূপান্তর করুন অথবা নির্দিষ্ট পৃষ্ঠাগুলো আলাদা করে নতুন পিডিএফ ফাইল বানিয়ে নিন নিমেষেই।</p>
    </div>

    <!-- Accounting -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">account_balance_wallet</i>
        </div>
        <h3 class="feature-title">৩. হিসাব-নিকাশ ও বুককিপিং</h3>
        <p class="feature-desc">প্রতিদিনের আয়-ব্যয় ট্র্যাকিং, ব্যালেন্স শিট, মানি রিসিট ও ক্যাশ মেমো জেনারেটর এবং সেভ করার সুবিধাসহ ক্যাশ নোট ক্যালকুলেটর।</p>
    </div>

    <!-- Graphics Design -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">brush</i>
        </div>
        <h3 class="feature-title">৪. গ্রাফিক্স ও বাংলা ব্যানার এডিটর</h3>
        <p class="feature-desc">ফেসবুক পোস্ট প্রিসেট টেমপ্লেট নিয়ে এবং Hind Siliguri ও Noto Serif Bengali ফন্ট ব্যবহার করে আকর্ষণীয় বাংলা ব্যানার ডিজাইন করুন।</p>
    </div>

    <!-- AI Tools -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">psychology</i>
        </div>
        <h3 class="feature-title">৫. এআই ফটো ও ইমেজ জেনারেটর</h3>
        <p class="feature-desc">পাবলিক ও বিজনেস টায়ারে এআই ইমেজ জেনারেশন এবং স্বচ্ছ পিএনজি ব্যাকগ্রাউন্ড রিমুভার টুল ব্যবহারের দুর্দান্ত সুবিধা।</p>
    </div>

    <!-- Question Paper Generator -->
    <div class="feature-card">
        <div class="feature-icon">
            <i class="material-icons-round">quiz</i>
        </div>
        <h3 class="feature-title">৬. সৃজনশীল ও MCQ প্রশ্নপত্র মেকার</h3>
        <p class="feature-desc">LaTeX (MathJax) গাণিতিক সমীকরণ রেন্ডারিং সাপোর্টসহ স্কুল/কলেজের পরীক্ষা ও বহুনির্বাচনী প্রশ্নপত্র তৈরি ও পিডিএফ ডাউনলোড।</p>
    </div>
</div>
@endsection
