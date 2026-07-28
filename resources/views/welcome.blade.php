@extends('layouts.app')

@section('title', 'penghor.com - আপনার ডিজিটাল ব্যবসার স্মার্ট ও সর্বাধুনিক সহযাত্রী')

@section('content')
<style>
    /* Custom Styling for Ultra-Modern Homepage */
    .welcome-container {
        position: relative;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Guest Top Navbar */
    .guest-navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        background: rgba(26, 28, 38, 0.75);
        border: 1px solid var(--border-color);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        margin-top: 20px;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
    
    .guest-nav-links {
        display: flex;
        gap: 30px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .guest-nav-links a {
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }
    
    .guest-nav-links a:hover {
        color: #fff;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        text-align: center;
        padding: 90px 25px 80px;
        background: radial-gradient(circle at 50% 20%, rgba(99, 102, 241, 0.15) 0%, rgba(6, 182, 212, 0.05) 50%, transparent 100%), var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 28px;
        margin-bottom: 60px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .hero-glow-1 {
        position: absolute;
        top: -150px;
        left: 20%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(50px);
        pointer-events: none;
        animation: floatGlow 12s ease-in-out infinite alternate;
    }

    .hero-glow-2 {
        position: absolute;
        bottom: -150px;
        right: 20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.18) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(60px);
        pointer-events: none;
        animation: floatGlow 15s ease-in-out infinite alternate-reverse;
    }

    @keyframes floatGlow {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(40px, 20px) scale(1.1); }
        100% { transform: translate(-30px, -20px) scale(0.95); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: rgba(99, 102, 241, 0.12);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 50px;
        color: #818cf8;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 25px;
        letter-spacing: 0.02em;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.15);
    }

    .hero-title {
        font-size: 3.8rem;
        font-weight: 800;
        margin-bottom: 24px;
        letter-spacing: -0.03em;
        line-height: 1.15;
        background: linear-gradient(135deg, #ffffff 20%, #a5b4fc 60%, #22d3ee 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-muted);
        max-width: 720px;
        margin: 0 auto 40px auto;
        line-height: 1.7;
    }

    /* Live Search in Hero */
    .hero-search-box {
        max-width: 650px;
        margin: 0 auto 35px;
        position: relative;
    }

    .hero-search-input {
        width: 100%;
        padding: 16px 24px 16px 54px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(18, 20, 29, 0.8);
        backdrop-filter: blur(15px);
        color: #fff;
        font-size: 1.05rem;
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .hero-search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2), 0 15px 35px rgba(0, 0, 0, 0.5);
    }

    .hero-search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.5rem;
        pointer-events: none;
        transition: color 0.3s;
    }

    .hero-search-input:focus ~ .hero-search-icon {
        color: var(--primary-color);
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-glow-primary {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff !important;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.05rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5);
        transition: all 0.3s ease;
    }

    .btn-glow-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.7);
        background: linear-gradient(135deg, #818cf8, #6366f1);
    }

    .btn-glow-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: #fff !important;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.05rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: all 0.3s ease;
    }

    .btn-glow-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-3px);
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 70px;
    }

    .stat-card {
        background: rgba(26, 28, 38, 0.6);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 25px 20px;
        text-align: center;
        backdrop-filter: blur(12px);
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(99, 102, 241, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff, #22d3ee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 6px;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Section Headers */
    .section-header {
        text-align: center;
        margin-bottom: 45px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 12px;
        color: #fff;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 650px;
        margin: 0 auto;
    }

    /* Category Filter Tabs */
    .category-filter {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 40px;
    }

    .filter-btn {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: var(--text-muted);
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(6, 182, 212, 0.25));
        border-color: #6366f1;
        color: #fff;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 80px;
    }

    .feature-card-modern {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 28px;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    .feature-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--primary-color), var(--secondary-color), transparent);
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .feature-card-modern:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 30px rgba(99, 102, 241, 0.12);
        background: var(--bg-card-hover);
    }

    .feature-card-modern:hover::before {
        opacity: 1;
    }

    .feature-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
    }

    .feature-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .feature-card-modern:hover .feature-icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    /* Icon color variations */
    .icon-indigo { background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.25); }
    .icon-cyan { background: rgba(6, 182, 212, 0.15); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.25); }
    .icon-emerald { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); }
    .icon-violet { background: rgba(139, 92, 246, 0.15); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.25); }
    .icon-rose { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.25); }
    .icon-amber { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.25); }

    .feature-tag {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .tag-pro { background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); }
    .tag-ai { background: rgba(6, 182, 212, 0.15); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.3); }
    .tag-free { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .tag-hot { background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); }
    .tag-tool { background: rgba(255, 255, 255, 0.08); color: var(--text-muted); border: 1px solid rgba(255, 255, 255, 0.15); }

    .feature-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .feature-card-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.65;
        flex: 1;
        margin-bottom: 24px;
    }

    .feature-card-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        color: var(--primary-hover);
        font-weight: 600;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }

    .feature-card-modern:hover .feature-card-action {
        color: var(--secondary-hover);
    }

    .feature-card-action i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .feature-card-modern:hover .feature-card-action i {
        transform: translateX(6px);
    }

    /* Benefits Section */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 80px;
    }

    .benefit-box {
        background: rgba(26, 28, 38, 0.5);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px 25px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .benefit-box:hover {
        border-color: rgba(6, 182, 212, 0.4);
        transform: translateY(-5px);
        background: rgba(26, 28, 38, 0.8);
    }

    .benefit-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.15));
        color: var(--secondary-hover);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.8rem;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }

    .benefit-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 12px;
    }

    .benefit-desc {
        color: var(--text-muted);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    /* CTA Banner */
    .cta-banner {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(6, 182, 212, 0.2));
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 28px;
        padding: 60px 40px;
        text-align: center;
        margin-bottom: 80px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(99, 102, 241, 0.2);
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 16px;
    }

    .cta-subtitle {
        color: #cbd5e1;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 35px;
        line-height: 1.6;
    }

    /* No results message */
    .no-results {
        display: none;
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px dashed rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        margin-bottom: 60px;
    }

    .no-results i {
        font-size: 3.5rem;
        color: var(--text-muted);
        margin-bottom: 15px;
    }

    /* Responsive Queries */
    @media (max-width: 1100px) {
        .stats-grid, .benefits-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.6rem; }
        .hero-section { padding: 60px 15px; }
        .guest-navbar { flex-direction: column; gap: 15px; }
        .guest-nav-links { display: none; }
        .stats-grid, .benefits-grid { grid-template-columns: 1fr; }
        .features-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="welcome-container">
    
    @guest
    <!-- Guest Top Navbar -->
    <header class="guest-navbar no-print">
        <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
            <img src="{{ asset('images/logo.png') }}" alt="penghor.com Logo" style="height: 44px; width: auto; object-fit: contain;">
            <div>
                <span style="font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: 1px;">penghor</span><span style="font-size: 1.5rem; font-weight: 800; background: linear-gradient(135deg, #818cf8, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">.com</span>
            </div>
        </a>

        <ul class="guest-nav-links">
            <li><a href="#features">সকল সেবাসমূহ</a></li>
            <li><a href="#benefits">কেন আমরা?</a></li>
            <li><a href="#stats">আমাদের সাফল্য</a></li>
            <li><a href="{{ route('tickets.index') }}">সাপোর্ট ও হায়ার</a></li>
        </ul>

        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="{{ route('login') }}" class="btn" style="color: #fff; text-decoration: none; font-weight: 600; padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15);">লগইন</a>
            <a href="{{ route('register') }}" class="btn-glow-primary" style="padding: 10px 22px; font-size: 0.95rem;">ফ্রি রেজিস্ট্রেশন</a>
        </div>
    </header>
    @endguest

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        
        <div class="hero-badge">
            <i class="material-icons-round" style="font-size: 1.1rem; color: #22d3ee;">auto_awesome</i>
            <span>নতুন আপডেট: ২৮+ প্রফেশনাল এআই ও স্টেশনারি টুলস এখন এক প্ল্যাটফর্মে</span>
        </div>

        <h1 class="hero-title">আপনার ডিজিটাল ব্যবসার<br>স্মার্ট ও সর্বাধুনিক সহযাত্রী</h1>
        
        <p class="hero-subtitle">
            ডকুমেন্ট এডিটিং, সিভি মেকার, ছবি ও পাসপোর্ট লেআউট, হিসাব-নিকাশ বুককিপিং, পিডিএফ মার্জ-স্প্লিট, এআই ফটো জেনারেশন এবং সৃজনশীল প্রশ্নপত্র তৈরি করুন মুহূর্তের মধ্যে।
        </p>

        <!-- Live Search Box -->
        <div class="hero-search-box">
            <input type="text" id="toolSearchInput" class="hero-search-input" placeholder="যেকোনো টুল বা সেবা খুঁজুন... (যেমন: ছবি, পিডিএফ, সিভি, হিসাব, ব্যানার, OCR)">
            <i class="material-icons-round hero-search-icon">search</i>
        </div>

        <div class="hero-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-glow-primary">
                    <i class="material-icons-round">dashboard</i> ড্যাশবোর্ডে প্রবেশ করুন
                </a>
                <a href="#features" class="btn-glow-secondary">
                    <i class="material-icons-round">explore</i> সকল টুলস দেখুন
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-glow-primary">
                    <i class="material-icons-round">bolt</i> ফ্রি রেজিস্ট্রেশন করুন
                </a>
                <a href="{{ route('login') }}" class="btn-glow-secondary">
                    <i class="material-icons-round">login</i> লগইন করুন
                </a>
            @endauth
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-grid" id="stats">
        <div class="stat-card">
            <div class="stat-number">২৯+</div>
            <div class="stat-label">প্রফেশনাল ডিজিটাল টুলস</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">১ সেকেন্ড</div>
            <div class="stat-label">এআই ও ওচিআর প্রসেসিং স্পিড</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">১০০%</div>
            <div class="stat-label">সিকিওর ক্লাউড ডেটা ব্যাকআপ</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">২৪/৭</div>
            <div class="stat-label">এক্সপার্ট সাপোর্ট ও কাস্টম হায়ার</div>
        </div>
    </section>

    <!-- Features Section Header -->
    <section class="section-header" id="features">
        <h2 class="section-title">আমাদের সকল সেবাসমূহ ও টুলস</h2>
        <p class="section-subtitle">
            আপনার প্রতিদিনের অফিশিয়াল, স্টেশনারি ও ব্যবসায়িক কাজকে ১০ গুণ সহজ ও দ্রুত করতে ২৮টি সর্বাধুনিক ডিজিটাল সমাধান
        </p>
    </section>

    <!-- Category Filter Tabs -->
    <div class="category-filter">
        <button class="filter-btn active" data-filter="all">
            <i class="material-icons-round">apps</i> সকল সেবা (২৮)
        </button>
        <button class="filter-btn" data-filter="doc">
            <i class="material-icons-round">description</i> ডকুমেন্ট ও সিভি (৫)
        </button>
        <button class="filter-btn" data-filter="pdf">
            <i class="material-icons-round">picture_as_pdf</i> পিডিএফ টুলস (৭)
        </button>
        <button class="filter-btn" data-filter="photo">
            <i class="material-icons-round">portrait</i> ফটো, এআই ও গ্রাফিক্স (৮)
        </button>
        <button class="filter-btn" data-filter="finance">
            <i class="material-icons-round">account_balance_wallet</i> হিসাব, পরীক্ষা ও অন্যান্য (৮)
        </button>
    </div>

    <!-- No Results Message -->
    <div id="noResultsMsg" class="no-results">
        <i class="material-icons-round">search_off</i>
        <h3 style="color: #fff; margin-bottom: 10px;">কোনো টুল পাওয়া যায়নি</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px;">আপনার খোঁজা কিওয়ার্ড দিয়ে কোনো সেবা খুঁজে পাওয়া যায়নি। অন্য কোনো নাম দিয়ে চেষ্টা করুন।</p>
        <button onclick="resetFilters()" class="btn-glow-secondary" style="cursor: pointer;">সকল টুলস দেখুন</button>
    </div>

    <!-- Features Grid -->
    <div class="features-grid" id="featuresGrid">
        
        <!-- ==================== CATEGORY: DOCUMENT & CV (doc) ==================== -->
        
        <!-- 1. Document Editor -->
        <a href="{{ route('document.index') }}" class="feature-card-modern" data-category="doc" data-title="প্রফেশনাল ডকুমেন্ট এডিটর document editor typing word print stamp legal a4 a3 letter">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-indigo"><i class="material-icons-round">description</i></div>
                <span class="feature-tag tag-pro">Pro Tool</span>
            </div>
            <h3 class="feature-card-title">১. প্রফেশনাল ডকুমেন্ট এডিটর</h3>
            <p class="feature-card-desc">A4, A3, Legal, Letter এবং Stamp সাইজ পেজ লেআউট ও মার্জিন কনট্রোল সহ সরাসরি এডিটিং, বাংলা-ইংরেজি টাইপিং ও প্রিন্ট করার সুবিধা।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 2. CV Maker -->
        <a href="{{ route('cv.index') }}" class="feature-card-modern" data-category="doc" data-title="সিভি মেকার cv maker resume builder biodata bio data job ATS whatsapp">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-emerald"><i class="material-icons-round">contact_page</i></div>
                <span class="feature-tag tag-hot">Popular</span>
            </div>
            <h3 class="feature-card-title">২. সিভি ও রেজুমে মেকার</h3>
            <p class="feature-card-desc">আকর্ষণীয় এবং প্রফেশনাল রেজুমে তৈরি করুন সহজেই। একাধিক প্রিসেট টেমপ্লেট ও সরাসরি পিডিএফ ডাউনলোড বা হোয়াটসঅ্যাপে পাঠানোর সুবিধা।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 4. AI Document OCR -->
        <a href="{{ route('ocr.index') }}" class="feature-card-modern" data-category="doc" data-title="এআই ডকুমেন্ট ওচিআর ai document ocr image to text extract bangla english converter">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-violet"><i class="material-icons-round">document_scanner</i></div>
                <span class="feature-tag tag-ai">AI Powered</span>
            </div>
            <h3 class="feature-card-title">৪. এআই ডকুমেন্ট ওচিআর (OCR)</h3>
            <p class="feature-card-desc">স্ক্যান করা ছবি বা ডকুমেন্ট থেকে স্বয়ংক্রিয়ভাবে বাংলা ও ইংরেজি টেক্সট আলাদা করুন ৯৯% নির্ভুলতায় এআই ওচিআর প্রযুক্তির মাধ্যমে।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 5. Typing Speed Test -->
        <a href="{{ route('typing-test.index') }}" class="feature-card-modern" data-category="doc" data-title="টাইপিং স্পিড ও অ্যাকুরেসি টেস্ট typing speed accuracy test wpm keyboard practice bangla english">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-amber"><i class="material-icons-round">keyboard</i></div>
                <span class="feature-tag tag-free">Free</span>
            </div>
            <h3 class="feature-card-title">৫. টাইপিং স্পিড ও অ্যাকুরেসি টেস্ট</h3>
            <p class="feature-card-desc">কীবোর্ড টাইপিং গতি ও নির্ভুলতা যাচাই করুন। বাংলা ও ইংরেজি কাস্টম প্যাসেজ প্র্যাকটিস করে লাইভ WPM স্পিড ও অ্যাকুরেসি স্কোর দেখুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- ==================== CATEGORY: PDF UTILITIES (pdf) ==================== -->

        <!-- 6. PDF Merge & Split -->
        <a href="{{ route('pdf.tools') }}" class="feature-card-modern" data-category="pdf" data-title="পিডিএফ মার্জ ও স্প্লিট pdf merge split combine separate pages tools">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-rose"><i class="material-icons-round">picture_as_pdf</i></div>
                <span class="feature-tag tag-hot">Essential</span>
            </div>
            <h3 class="feature-card-title">৬. পিডিএফ মার্জ ও স্প্লিট</h3>
            <p class="feature-card-desc">একাধিক পিডিএফ ফাইলকে এক ক্লিকে জোড়া লাগিয়ে একটি ফাইল বানান অথবা বড় পিডিএফ থেকে নির্দিষ্ট পৃষ্ঠাগুলো আলাদা করে নিন নিমেষেই।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 7. PDF to Excel & Word -->
        <a href="{{ route('pdf.tools.to_excel') }}" class="feature-card-modern" data-category="pdf" data-title="পিডিএফ থেকে এক্সেল ও ওয়ার্ড pdf to excel word spreadsheet table data converter">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-emerald"><i class="material-icons-round">table_view</i></div>
                <span class="feature-tag tag-pro">Converter</span>
            </div>
            <h3 class="feature-card-title">৭. পিডিএফ থেকে এক্সেল ও ওয়ার্ড</h3>
            <p class="feature-card-desc">পিডিএফ ফাইলে থাকা টেবিল বা ডেটাসমূহ কোনো ফরম্যাটিং নষ্ট না করে সরাসরি এক্সেল (Excel) বা ওয়ার্ড স্প্রেডশিটে রূপান্তর করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 8. NID to PDF & Watermark -->
        <a href="{{ route('pdf.tools.nid_to_pdf') }}" class="feature-card-modern" data-category="pdf" data-title="এনআইডি টু পিডিএফ ও ওয়াটারমার্ক nid to pdf watermark smart card id card bangladesh print">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-cyan"><i class="material-icons-round">badge</i></div>
                <span class="feature-tag tag-pro">Smart Tool</span>
            </div>
            <h3 class="feature-card-title">৮. এনআইডি টু পিডিএফ ও ওয়াটারমার্ক</h3>
            <p class="feature-card-desc">জাতীয় পরিচয়পত্র (NID Card) ছবি থেকে এফোর সাইজে পিডিএফ তৈরি এবং যেকোনো পিডিএফে কাস্টম টেক্সট বা লোগো ওয়াটারমার্ক যুক্ত করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 9. Document Scanner (Perspective Crop) -->
        <a href="{{ route('pdf.tools.document_scanner') }}" class="feature-card-modern" data-category="pdf" data-title="ডকুমেন্ট স্ক্যানার ও ক্রপ document scanner perspective crop straighten photo book page">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-indigo"><i class="material-icons-round">scanner</i></div>
                <span class="feature-tag tag-ai">Perspective</span>
            </div>
            <h3 class="feature-card-title">৯. ডকুমেন্ট স্ক্যানার ও ক্রপ</h3>
            <p class="feature-card-desc">বাঁকাত্যারা ছবি, বইয়ের পাতা বা আইডি কার্ড ফটোশপের মতো পারস্পেক্টিভ ক্রপ করে সোজা ও স্পষ্ট স্ক্যান ডকুমেন্টে রূপান্তর করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 10. PDF & Image Compress -->
        <a href="{{ route('pdf.tools.image_compress') }}" class="feature-card-modern" data-category="pdf" data-title="পিডিএফ সাইজ রিডুস ও কম্প্রেস pdf image compress reduce file size optimizer kb mb">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-amber"><i class="material-icons-round">compress</i></div>
                <span class="feature-tag tag-tool">Optimizer</span>
            </div>
            <h3 class="feature-card-title">১০. পিডিএফ ও ছবি কম্প্রেস</h3>
            <p class="feature-card-desc">কোয়ালিটি ঠিক রেখে বড় সাইজের পিডিএফ ও ছবির ফাইল সাইজ ছোট (Compress) করুন, যা ইমেইল বা অনলাইনে সহজে শেয়ার করা যায়।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 11. PDF Repair & Permission -->
        <a href="{{ route('pdf.tools.repair') }}" class="feature-card-modern" data-category="pdf" data-title="করাপ্টেড পিডিএফ রিপেয়ার ও পারমিশন pdf repair fix corrupted password unlock permission protect">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-violet"><i class="material-icons-round">build_circle</i></div>
                <span class="feature-tag tag-tool">Recovery</span>
            </div>
            <h3 class="feature-card-title">১১. পিডিএফ রিপেয়ার ও পারমিশন</h3>
            <p class="feature-card-desc">ড্যামেজ বা নষ্ট পিডিএফ ফাইল মেরামত (Repair) করুন এবং পিডিএফের পাসওয়ার্ড ও প্রিন্ট পারমিশন আনলক বা প্রটেক্ট করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 12. PDF Page Remove & Resize -->
        <a href="{{ route('pdf.tools.page_remove') }}" class="feature-card-modern" data-category="pdf" data-title="পিডিএফ পৃষ্ঠা রিমুভ ও সাইজ ক্রপ pdf page remove delete crop resize margin">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-rose"><i class="material-icons-round">auto_delete</i></div>
                <span class="feature-tag tag-tool">Utility</span>
            </div>
            <h3 class="feature-card-title">১২. পিডিএফ পেজ রিমুভ ও ক্রপ</h3>
            <p class="feature-card-desc">পিডিএফ ফাইল থেকে অপ্রয়োজনীয় যেকোনো পৃষ্ঠা সহজেই ডিলিট করুন অথবা পেজের মার্জিন ও সাইজ কাস্টম ক্রপ করে রিসাইজ করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 13. JPG to PDF Converter -->
        <a href="{{ route('pdf.tools.jpg_to_pdf') }}" class="feature-card-modern" data-category="pdf" data-title="জেপিজি টু পিডিএফ jpg png to pdf converter image multiple photos combine">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-red"><i class="material-icons-round">picture_as_pdf</i></div>
                <span class="feature-tag tag-hot">New Tool</span>
            </div>
            <h3 class="feature-card-title">১৩. জেপিজি টু পিডিএফ (JPG to PDF)</h3>
            <p class="feature-card-desc">একাধিক ছবি (JPG, PNG, WEBP) একসাথে আপলোড করে নিমেষেই প্রফেশনাল A4 বা কাস্টম সাইজের পিডিএফ ফাইল তৈরি ও ডাউনলোড করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- ==================== CATEGORY: PHOTO, AI & GRAPHICS (photo) ==================== -->

        <!-- 13. Photo Maker (1-Click Job & Passport Photo) -->
        <a href="{{ route('photo.index') }}" class="feature-card-modern" data-category="photo" data-title="১-ক্লিক পাসপোর্ট ও জব ফটো মেকার photo maker passport size 300x300 job application background color">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-amber"><i class="material-icons-round">portrait</i></div>
                <span class="feature-tag tag-hot">Most Used</span>
            </div>
            <h3 class="feature-card-title">১৩. পাসপোর্ট ও জব ফটো মেকার</h3>
            <p class="feature-card-desc">ছবি আপলোড করে নিমেষেই পাসপোর্ট সাইজ, স্ট্যাম্প সাইজ অথবা ৩০০x৩০০ জব আবেদনের ছবি তৈরি এবং ব্যাকগ্রাউন্ড কালার পরিবর্তন করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 14. Passport Print Auto Arrange -->
        <a href="{{ route('pdf.tools.passport_print') }}" class="feature-card-modern" data-category="photo" data-title="পাসপোর্ট ছবি প্রিন্ট লেআউট passport photo print layout auto arrange 4r a4 sheet grid">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-cyan"><i class="material-icons-round">auto_awesome_mosaic</i></div>
                <span class="feature-tag tag-pro">Auto Arrange</span>
            </div>
            <h3 class="feature-card-title">১৪. পাসপোর্ট ছবি প্রিন্ট লেআউট</h3>
            <p class="feature-card-desc">একাধিক পাসপোর্ট বা স্ট্যাম্প সাইজ ছবি 4R অথবা A4 সাইজ পেপারে স্বয়ংক্রিয়ভাবে সাজিয়ে সরাসরি প্রিন্ট বা পিডিএফ সেভ করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 15. Joint Photo Maker -->
        <a href="{{ route('pdf.tools.joint_photo') }}" class="feature-card-modern" data-category="photo" data-title="জয়েন্ট ফটো মেকার যৌথ ছবি joint photo maker couple husband wife partner side by side">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-violet"><i class="material-icons-round">people_alt</i></div>
                <span class="feature-tag tag-pro">Couple Photo</span>
            </div>
            <h3 class="feature-card-title">১৫. জয়েন্ট ফটো মেকার (যৌথ ছবি)</h3>
            <p class="feature-card-desc">স্বামী-স্ত্রী বা যেকোনো দুই জনের আলাদা ছবি এক ক্লিকে পাশাপাশি যুক্ত করে নিখুঁত যৌথ (Joint) পাসপোর্ট ছবি তৈরি করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 16. AI Image Generator (AI Hub) -->
        <a href="{{ route('design.ai_hub') }}" class="feature-card-modern" data-category="photo" data-title="এআই ফটো ও ইমেজ জেনারেটর ai photo image generator ai hub artificial intelligence prompt creation">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-emerald"><i class="material-icons-round">psychology</i></div>
                <span class="feature-tag tag-ai">AI Magic</span>
            </div>
            <h3 class="feature-card-title">১৬. এআই ফটো ও ইমেজ জেনারেটর</h3>
            <p class="feature-card-desc">আপনার কল্পনার কথাগুলো লিখে জানান, আর আমাদের কৃত্রিম বুদ্ধিমত্তা (AI) মুহূর্তের মধ্যে তৈরি করে দেবে উচ্চ মানের আকর্ষণীয় বাস্তব ছবি।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 17. AI Background Remover -->
        <a href="{{ route('pdf.tools.bg_remover') }}" class="feature-card-modern" data-category="photo" data-title="এআই ব্যাকগ্রাউন্ড রিমুভার ai background remover bg remove 1-click transparent png photo">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-rose"><i class="material-icons-round">layers_clear</i></div>
                <span class="feature-tag tag-ai">1-Click AI</span>
            </div>
            <h3 class="feature-card-title">১৭. এআই ব্যাকগ্রাউন্ড রিমুভার</h3>
            <p class="feature-card-desc">যেকোনো জটিল ছবির ব্যাকগ্রাউন্ড এক ক্লিকে নিখুঁতভাবে রিমুভ করুন এবং ট্রান্সপারেন্ট (Transparent) পিএনজি ফরম্যাটে ডাউনলোড করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 18. Bangla Banner & Graphics Editor -->
        <a href="{{ route('design.editor') }}" class="feature-card-modern" data-category="photo" data-title="বাংলা ব্যানার ও গ্রাফিক্স এডিটর bangla banner graphics editor facebook post social media design font">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-indigo"><i class="material-icons-round">brush</i></div>
                <span class="feature-tag tag-pro">Design</span>
            </div>
            <h3 class="feature-card-title">১৮. বাংলা ব্যানার ও গ্রাফিক্স এডিটর</h3>
            <p class="feature-card-desc">ফেসবুক পোস্ট, ব্যানার ও বিজ্ঞাপনের জন্য প্রিসেট টেমপ্লেট নিয়ে Hind Siliguri ও Noto Serif ফন্ট ব্যবহার করে প্রফেশনাল ডিজাইন করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 19. AI Social & Stationery Templates -->
        <a href="{{ route('design.ai_templates') }}" class="feature-card-modern" data-category="photo" data-title="এআই সোশ্যাল ও স্টেশনারি টেমপ্লেট ai social stationery templates banner design automation readymade">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-cyan"><i class="material-icons-round">dashboard_customize</i></div>
                <span class="feature-tag tag-ai">AI Templates</span>
            </div>
            <h3 class="feature-card-title">১৯. এআই সোশ্যাল টেমপ্লেট</h3>
            <p class="feature-card-desc">এআই চালিত রেডিমেড কাস্টমাইজেবল টেমপ্লেট ব্যবহার করে চোখের পলকে পোস্টার, নোটিশ, বিজ্ঞাপন ও ব্যানার ডিজাইন করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 20. QR Generator & Image Convert -->
        <a href="{{ route('pdf.tools.qr_generator') }}" class="feature-card-modern" data-category="photo" data-title="কিউআর কোড জেনারেটর ও কনভার্টার qr code generator image convert resize jpg png webp">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-amber"><i class="material-icons-round">qr_code_2</i></div>
                <span class="feature-tag tag-tool">Multi-Tool</span>
            </div>
            <h3 class="feature-card-title">২০. কিউআর কোড ও কনভার্টার</h3>
            <p class="feature-card-desc">আপনার ওয়েবসাইট, ওয়াইফাই বা টেক্সটের জন্য কাস্টম QR কোড তৈরি করুন এবং যেকোনো ছবি JPG, PNG বা WEBP ফরম্যাটে কনভার্ট করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- ==================== CATEGORY: FINANCE, EXAM & MORE (finance) ==================== -->

        <!-- 21. Income-Expense Bookkeeping & Dues -->
        <a href="{{ route('accounting.index') }}" class="feature-card-modern" data-category="finance" data-title="আয়-ব্যয় হিসাব ও বুককিপিং income expense accounting bookkeeping dues bakir hishab cash calculator">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-emerald"><i class="material-icons-round">account_balance_wallet</i></div>
                <span class="feature-tag tag-pro">Bookkeeping</span>
            </div>
            <h3 class="feature-card-title">২১. আয়-ব্যয় হিসাব ও বুককিপিং</h3>
            <p class="feature-card-desc">প্রতিদিনের ব্যবসায়িক আয়-ব্যয় ট্র্যাকিং, বাকির হিসাব (Dues Tracker), ব্যালেন্স শিট এবং ক্যাশ নোট ক্যালকুলেটরের সম্পূর্ণ ডিজিটাল সমাধান।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 22. Invoice, Receipt & Memo Generator -->
        <a href="{{ route('accounting.memo') }}" class="feature-card-modern" data-category="finance" data-title="ইনভয়েস রিসিট ও ক্যাশ মেমো জেনারেটর invoice receipt cash memo generator bill whatsapp print">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-indigo"><i class="material-icons-round">receipt_long</i></div>
                <span class="feature-tag tag-hot">Billing</span>
            </div>
            <h3 class="feature-card-title">২২. রিসিট ও ক্যাশ মেমো জেনারেটর</h3>
            <p class="feature-card-desc">কাস্টমারদের জন্য প্রফেশনাল মানি রিসিট ও ক্যাশ মেমো তৈরি করুন এবং এক ক্লিকে হোয়াটসঅ্যাপে বা পিডিএফ আকারে প্রিন্ট দিন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 23. Creative & MCQ Question Maker -->
        <a href="{{ route('questions.index') }}" class="feature-card-modern" data-category="finance" data-title="সৃজনশীল ও MCQ প্রশ্নপত্র মেকার question paper maker mcq creative exam quiz latex mathjax school college">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-rose"><i class="material-icons-round">quiz</i></div>
                <span class="feature-tag tag-pro">Education</span>
            </div>
            <h3 class="feature-card-title">২৩. সৃজনশীল ও MCQ প্রশ্নপত্র মেকার</h3>
            <p class="feature-card-desc">স্কুল, কলেজ বা কোচিং সেন্টারের জন্য সৃজনশীল ও বহুনির্বাচনী প্রশ্নপত্র তৈরি করুন। রয়েছে LaTeX গাণিতিক সমীকরণ রেন্ডারিং সুবিধা।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 24. Online Exam & Quiz System -->
        <a href="{{ route('exams.index') }}" class="feature-card-modern" data-category="finance" data-title="অনলাইন এক্সাম ও কুইজ সিস্টেম online exam quiz test system participation live results evaluation">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-cyan"><i class="material-icons-round">school</i></div>
                <span class="feature-tag tag-ai">Live Test</span>
            </div>
            <h3 class="feature-card-title">২৪. অনলাইন এক্সাম ও কুইজ সিস্টেম</h3>
            <p class="feature-card-desc">শিক্ষার্থীদের জন্য অনলাইন পরীক্ষা ও কুইজ আয়োজন করুন। স্বয়ংক্রিয় মার্কিং ও ইনস্ট্যান্ট রেজাল্ট শিট তৈরির আধুনিক প্ল্যাটফর্ম।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 25. Quick Share (Fast File Transfer) -->
        <a href="{{ route('share.index') }}" class="feature-card-modern" data-category="finance" data-title="কুইক শেয়ার ফাস্ট ফাইল ট্রান্সফার quick share file transfer fast upload download instant">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-amber"><i class="material-icons-round">share</i></div>
                <span class="feature-tag tag-free">Fast Transfer</span>
            </div>
            <h3 class="feature-card-title">২৫. কুইক শেয়ার (ফাইল ট্রান্সফার)</h3>
            <p class="feature-card-desc">যেকোনো ডিভাইস থেকে কোনো ঝামেলা ছাড়াই দ্রুত ফাইল আপলোড ও ডাউনলোড করুন। প্যানড্রাইভ বা ক্যাবলের দিন শেষ!</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 26. WhatsApp Connect & Automation -->
        <a href="{{ route('whatsapp.connect') }}" class="feature-card-modern" data-category="finance" data-title="হোয়াটসঅ্যাপ কানেক্ট ও অটোমেশন whatsapp connect messaging qr code automation document sender">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-emerald"><i class="material-icons-round">qr_code_scanner</i></div>
                <span class="feature-tag tag-pro">Automation</span>
            </div>
            <h3 class="feature-card-title">২৬. হোয়াটসঅ্যাপ কানেক্ট ও অটোমেশন</h3>
            <p class="feature-card-desc">QR কোড স্ক্যান করে আপনার নিজের হোয়াটসঅ্যাপ কানেক্ট করুন এবং কাস্টমারদের ইনভয়েস ও ডকুমেন্ট সরাসরি অটো-মেসেজ পাঠান।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 27. Custom Hiring & Support Tickets -->
        <a href="{{ route('tickets.index') }}" class="feature-card-modern" data-category="finance" data-title="কাস্টম হায়ার ও ২৪/৭ সাপোর্ট টিকিট custom hiring support ticket help desk expert team 24/7 service">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-violet"><i class="material-icons-round">support_agent</i></div>
                <span class="feature-tag tag-tool">Support</span>
            </div>
            <h3 class="feature-card-title">২৭. কাস্টম হায়ার ও ২৪/৭ সাপোর্ট</h3>
            <p class="feature-card-desc">বিশেষ কোনো ডিজাইন বা কাস্টম কাজের প্রয়োজন? আমাদের এক্সপার্ট টিমকে হায়ার করুন অথবা যেকোনো সমস্যায় ২৪/৭ টিকিট ওপেন করুন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

        <!-- 28. Credit Recharge & Referral System -->
        <a href="{{ route('recharge') }}" class="feature-card-modern" data-category="finance" data-title="ক্রেডিট রিচার্জ ও রেফারেল সিস্টেম credit recharge referral commission bonus earn reward payment">
            <div class="feature-card-header">
                <div class="feature-icon-box icon-indigo"><i class="material-icons-round">payments</i></div>
                <span class="feature-tag tag-hot">Rewards</span>
            </div>
            <h3 class="feature-card-title">২৮. ক্রেডিট রিচার্জ ও রেফারেল</h3>
            <p class="feature-card-desc">মেয়াদের কোনো সীমাবদ্ধতা ছাড়াই সহজ ও নিরাপদ পেমেন্টে ক্রেডিট রিচার্জ করুন এবং বন্ধুদের রেফার করে আকর্ষণীয় কমিশন জিতে নিন।</p>
            <div class="feature-card-action"><span>ব্যবহার করুন</span><i class="material-icons-round">arrow_forward</i></div>
        </a>

    </div>

    <!-- Why Choose Us Section -->
    <section class="section-header" id="benefits" style="margin-top: 100px;">
        <h2 class="section-title">কেন penghor.com আপনার সেরা পছন্দ?</h2>
        <p class="section-subtitle">হাজারো স্টেশনারি ও ডিজিটাল উদ্যোক্তাদের আস্থা অর্জনের পেছনের ৪টি মূল কারণ</p>
    </section>

    <div class="benefits-grid">
        <div class="benefit-box">
            <div class="benefit-icon"><i class="material-icons-round">savings</i></div>
            <h3 class="benefit-title">সময় ও খরচের সাশ্রয়</h3>
            <p class="benefit-desc">আলাদা আলাদা সফটওয়্যার বা সাবস্ক্রিপশন নেওয়ার কোনো ঝামেলা নেই। আপনার প্রয়োজনীয় সকল ডিজিটাল টুলস এখন এক ঠিকানায়।</p>
        </div>
        <div class="benefit-box">
            <div class="benefit-icon"><i class="material-icons-round">touch_app</i></div>
            <h3 class="benefit-title">সহজ ও ইউজার ফ্রেন্ডলি</h3>
            <p class="benefit-desc">কোনো পূর্ববর্তী টেকনিক্যাল জ্ঞান বা গ্রাফিক্স ডিজাইন অভিজ্ঞতা ছাড়াই যে কেউ মাত্র ১ মিনিটেই প্রফেশনাল কাজ করতে পারবেন।</p>
        </div>
        <div class="benefit-box">
            <div class="benefit-icon"><i class="material-icons-round">auto_awesome</i></div>
            <h3 class="benefit-title">এআই চালিত নির্ভুলতা</h3>
            <p class="benefit-desc">অত্যাধুনিক কৃত্রিম বুদ্ধিমত্তা (AI) এবং OCR প্রযুক্তিতে ছবি এডিটিং ও ডকুমেন্ট প্রসেসিংয়ে ১০০% নির্ভুল ও নিখুঁত কাজের নিশ্চয়তা।</p>
        </div>
        <div class="benefit-box">
            <div class="benefit-icon"><i class="material-icons-round">devices</i></div>
            <h3 class="benefit-title">মোবাইল ও পিসি সাপোর্ট</h3>
            <p class="benefit-desc">যেকোনো স্মার্টফোন, ট্যাবলেট, ল্যাপটপ বা কম্পিউটার থেকে কোনো সফটওয়্যার ইন্সটল ছাড়াই সরাসরি ব্রাউজারে ব্যবহারযোগ্য।</p>
        </div>
    </div>

    <!-- CTA Banner Section -->
    <section class="cta-banner">
        <div class="hero-glow-1" style="left: 10%; top: -100px;"></div>
        <div class="hero-glow-2" style="right: 10%; bottom: -100px;"></div>
        
        <h2 class="cta-title">আজই শুরু করুন আপনার স্মার্ট ডিজিটাল যাত্রা!</h2>
        <p class="cta-subtitle">
            হাজারো উদ্যোক্তা ও প্রফেশনালদের সাথে যুক্ত হয়ে আপনার প্রতিদিনের কাজের গতি বাড়িয়ে নিন বহুগুণ। কোনো ক্রেডিট কার্ড ছাড়াই ফ্রি অ্যাকাউন্ট খুলুন এখনই।
        </p>

        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-glow-primary" style="padding: 16px 36px; font-size: 1.1rem;">
                    <i class="material-icons-round">rocket_launch</i> ড্যাশবোর্ডে চলুন
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-glow-primary" style="padding: 16px 36px; font-size: 1.1rem;">
                    <i class="material-icons-round">person_add</i> ফ্রি অ্যাকাউন্ট খুলুন
                </a>
                <a href="{{ route('login') }}" class="btn-glow-secondary" style="padding: 16px 36px; font-size: 1.1rem;">
                    <i class="material-icons-round">login</i> লগইন করুন
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer style="border-top: 1px solid var(--border-color); padding: 50px 20px 30px; text-align: center; color: var(--text-muted); font-size: 0.95rem;">
        <div style="display: flex; justify-content: center; align-items: center; gap: 12px; margin-bottom: 20px;">
            <img src="{{ asset('images/logo.png') }}" alt="penghor.com Logo" style="height: 38px; width: auto; object-fit: contain;">
            <span style="font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: 1px;">penghor</span><span style="font-size: 1.4rem; font-weight: 800; background: linear-gradient(135deg, #818cf8, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">.com</span>
        </div>
        <p style="max-width: 500px; margin: 0 auto 25px; line-height: 1.6;">
            প্রফেশনাল স্টেশনারি, বুককিপিং, ডকুমেন্ট ও গ্রাফিক্স সমাধানের সর্বাধুনিক ক্লাউড প্ল্যাটফর্ম।
        </p>
        <div style="display: flex; justify-content: center; gap: 25px; margin-bottom: 30px; flex-wrap: wrap;">
            <a href="#features" style="color: var(--text-muted); text-decoration: none;">সেবাসমূহ</a>
            <a href="#benefits" style="color: var(--text-muted); text-decoration: none;">কেন আমরা?</a>
            <a href="{{ route('tickets.index') }}" style="color: var(--text-muted); text-decoration: none;">সাপোর্ট ও যোগাযোগ</a>
            <a href="#" style="color: var(--text-muted); text-decoration: none;">প্রাইভেসি পলিসি</a>
            <a href="#" style="color: var(--text-muted); text-decoration: none;">শর্তাবলী</a>
        </div>
        <p style="font-size: 0.85rem; color: #64748b;">
            &copy; {{ date('Y') }} penghor.com. All rights reserved. Designed with ❤️ for Digital Bangladesh.
        </p>
    </footer>

</div>

<!-- Vanilla JavaScript for Live Filtering and Search -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const featureCards = document.querySelectorAll('.feature-card-modern');
    const searchInput = document.getElementById('toolSearchInput');
    const noResultsMsg = document.getElementById('noResultsMsg');
    const featuresGrid = document.getElementById('featuresGrid');

    let currentCategory = 'all';

    // Category Filter Click Event
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            currentCategory = this.getAttribute('data-filter');
            filterCards();
        });
    });

    // Search Input Event
    if(searchInput) {
        searchInput.addEventListener('input', function() {
            filterCards();
        });
    }

    // Main Filter Function
    function filterCards() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        featureCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const titleText = card.getAttribute('data-title').toLowerCase();
            const cardText = card.textContent.toLowerCase();

            const matchesCategory = (currentCategory === 'all' || category === currentCategory);
            const matchesSearch = (query === '' || titleText.includes(query) || cardText.includes(query));

            if(matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                card.style.animation = 'fadeInCard 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show or hide No Results message
        if(visibleCount === 0) {
            noResultsMsg.style.display = 'block';
            featuresGrid.style.display = 'none';
        } else {
            noResultsMsg.style.display = 'none';
            featuresGrid.style.display = 'grid';
        }
    }

    // Global reset function for empty state button
    window.resetFilters = function() {
        if(searchInput) searchInput.value = '';
        currentCategory = 'all';
        filterButtons.forEach(b => {
            if(b.getAttribute('data-filter') === 'all') {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
        filterCards();
    };
});
</script>

<style>
@keyframes fadeInCard {
    from { opacity: 0; transform: translateY(12px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>
@endsection
