@extends('layouts.app')

@section('title', 'এআই টেমপ্লেট - সহজ কাজ')

@section('content')
<style>
    /* Styling to match user screenshots */
    .ai-templates-layout {
        display: flex;
        gap: 30px;
        margin-top: 10px;
    }

    .sidebar-filters {
        width: 280px;
        flex-shrink: 0;
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        height: fit-content;
    }

    .main-templates-area {
        flex: 1;
    }

    .filter-section-title {
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
        color: var(--text-main);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 25px;
    }

    .filter-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--text-muted);
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.02);
    }

    .filter-item:hover, .filter-item.active {
        background: rgba(245, 158, 11, 0.08);
        color: var(--primary-color);
        font-weight: 600;
    }

    .filter-count {
        background: rgba(255, 255, 255, 0.05);
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .filter-item.active .filter-count {
        background: var(--primary-color);
        color: var(--text-dark);
        font-weight: 700;
    }

    /* Orientation icons */
    .orientation-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 25px;
    }

    .orientation-btn {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 6px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.75rem;
        color: var(--text-muted);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .orientation-btn i {
        font-size: 1.2rem;
    }

    .orientation-btn:hover, .orientation-btn.active {
        border-color: var(--primary-color);
        background: rgba(245, 158, 11, 0.05);
        color: var(--primary-color);
    }

    /* Sorting and other options */
    .sort-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        cursor: pointer;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .radio-input {
        accent-color: var(--primary-color);
    }

    /* Search & Top tags */
    .search-container {
        position: relative;
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 16px 20px 16px 50px;
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: var(--text-main);
        font-size: 1rem;
        outline: none;
        transition: all 0.2s;
    }

    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px var(--primary-glow);
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.4rem;
    }

    .tags-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .tag-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s;
    }

    .tag-item:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(245, 158, 11, 0.05);
    }

    /* Template Grid Cards */
    .template-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .template-card:hover {
        transform: translateY(-6px);
        border-color: var(--primary-color);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4), 0 0 0 1px var(--primary-color);
    }

    .card-image-wrapper {
        position: relative;
        aspect-ratio: 4/5;
        background: #090d16;
        overflow: hidden;
    }

    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .template-card:hover .card-image-wrapper img {
        transform: scale(1.05);
    }

    .card-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-details {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
        line-height: 1.4;
    }

    .card-category {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div style="margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
    <h2 style="color: #fff; font-weight: 800; font-size: 2.2rem; margin-bottom: 8px; border-left: 4px solid #818cf8; padding-left: 12px;">এআই টেমপ্লেট (AI Templates)</h2>
    <p style="color: var(--text-muted); font-size: 1.05rem; margin: 0;">পছন্দের স্টাইল বেছে নিন, আপনার ছবি আপলোড করুন — কয়েক সেকেন্ডেই একই লুকের ছবি পেয়ে যাবেন।</p>
</div>

<div class="ai-templates-layout">
    <!-- Sidebar Filters -->
    <aside class="sidebar-filters no-print">
        <!-- Categories -->
        <div class="filter-section-title">
            <span>ক্যাটাগরি</span>
            <a href="{{ route('design.ai_templates') }}" style="font-size: 0.8rem; color: var(--primary-color); text-decoration: none;">রিসেট</a>
        </div>
        <ul class="filter-list">
            <a href="{{ route('design.ai_templates', ['category' => 'all']) }}" style="text-decoration: none;">
                <li class="filter-item {{ !request('category') || request('category') === 'all' ? 'active' : '' }}">
                    <span>সব</span>
                    <span class="filter-count">{{ \App\Models\AiTemplate::count() }}</span>
                </li>
            </a>
            <a href="{{ route('design.ai_templates', ['category' => 'world_cup']) }}" style="text-decoration: none;">
                <li class="filter-item {{ request('category') === 'world_cup' ? 'active' : '' }}">
                    <span>ফুটবল বিশ্বকাপ ২০২৬</span>
                    <span class="filter-count">{{ \App\Models\AiTemplate::where('category', 'world_cup')->count() }}</span>
                </li>
            </a>
            <a href="{{ route('design.ai_templates', ['category' => 'creative']) }}" style="text-decoration: none;">
                <li class="filter-item {{ request('category') === 'creative' ? 'active' : '' }}">
                    <span>ক্রিয়েটিভ ফটোস</span>
                    <span class="filter-count">{{ \App\Models\AiTemplate::where('category', 'creative')->count() }}</span>
                </li>
            </a>
            <a href="{{ route('design.ai_templates', ['category' => 'restore']) }}" style="text-decoration: none;">
                <li class="filter-item {{ request('category') === 'restore' ? 'active' : '' }}">
                    <span>ফটো পুনরুদ্ধার</span>
                    <span class="filter-count">{{ \App\Models\AiTemplate::where('category', 'restore')->count() }}</span>
                </li>
            </a>
        </ul>

        <!-- Orientation -->
        <div class="filter-section-title">ওরিয়েন্টেশন</div>
        <div class="orientation-grid">
            <div class="orientation-btn active">
                <i class="material-icons-round">grid_view</i>
                <span>সব</span>
            </div>
            <div class="orientation-btn">
                <i class="material-icons-round">stay_current_portrait</i>
                <span>পোর্ট্রেট</span>
            </div>
            <div class="orientation-btn">
                <i class="material-icons-round">crop_landscape</i>
                <span>ল্যান্ডস্কেপ</span>
            </div>
            <div class="orientation-btn">
                <i class="material-icons-round">crop_square</i>
                <span>স্কয়ার</span>
            </div>
        </div>

        <!-- Sorting -->
        <div class="filter-section-title">সাজানো</div>
        <div class="sort-list">
            <label class="radio-container">
                <input type="radio" name="sort" class="radio-input" checked> জনপ্রিয়
            </label>
            <label class="radio-container">
                <input type="radio" name="sort" class="radio-input"> নতুন প্রথমে
            </label>
            <label class="radio-container">
                <input type="radio" name="sort" class="radio-input"> নাম অনুসারে
            </label>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="main-templates-area">
        <!-- Search bar -->
        <form action="{{ route('design.ai_templates') }}" method="GET" class="search-container">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <i class="material-icons-round search-icon">search</i>
            <input type="text" name="search" class="search-input" placeholder="নাম বা ক্যাটাগরি দিয়ে খুঁজুন..." value="{{ request('search') }}">
        </form>

        <!-- Popular tags -->
        <div class="tags-container">
            <span style="font-size: 0.85rem; color: var(--text-muted);">জনপ্রিয় ট্যাগ:</span>
            <a href="{{ route('design.ai_templates', ['search' => 'Argentina']) }}" class="tag-item">আর্জেন্টিনা</a>
            <a href="{{ route('design.ai_templates', ['search' => 'Brazil']) }}" class="tag-item">ব্রাজিল</a>
            <a href="{{ route('design.ai_templates', ['search' => 'Restore']) }}" class="tag-item">পুনরুদ্ধার</a>
            <a href="{{ route('design.ai_templates', ['search' => 'Wedding']) }}" class="tag-item">বিবাহ</a>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $templates->count() }} টি টেমপ্লেট পাওয়া গেছে</p>
        </div>

        <!-- Templates Grid -->
        <div class="grid-3">
            @forelse ($templates as $tmpl)
                <div class="template-card">
                    <div class="card-image-wrapper">
                        <img src="{{ $tmpl->thumbnail_path }}" alt="{{ $tmpl->title }}">
                        <div class="card-badge">
                            <i class="material-icons-round" style="font-size: 1rem;">trending_up</i>
                            <span>{{ rand(100, 300) }} বার ব্যবহৃত</span>
                        </div>
                    </div>
                    <div class="card-details">
                        <span class="card-category">
                            @if ($tmpl->category === 'world_cup')
                                ফুটবল বিশ্বকাপ ২০২৬
                            @elseif ($tmpl->category === 'creative')
                                ক্রিয়েটিভ ফটোস
                            @elseif ($tmpl->category === 'restore')
                                ফটো পুনরুদ্ধার
                            @else
                                অন্যান্য
                            @endif
                        </span>
                        <h4 class="card-title">{{ $tmpl->title }}</h4>
                        
                        <div style="margin-top: auto; padding-top: 15px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05);">
                            <span style="font-weight: 700; color: #818cf8; font-size: 0.9rem;">
                                @if ($tmpl->is_premium)
                                    <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-right: 2px;">stars</i>৳{{ $tmpl->credits_cost }} ক্রেডিট
                                @else
                                    <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 2px 8px; border-radius: 4px;">ফ্রি</span>
                                @endif
                            </span>
                            <a href="{{ route('design.ai_templates.customize', $tmpl->id) }}" class="btn" style="padding: 8px 16px; font-size: 0.85rem; background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); font-weight: 600; border-radius: 6px;">
                                স্টাইল তৈরি করুন
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 50px;" class="glass">
                    কোনো এআই টেমপ্লেট খুঁজে পাওয়া যায়নি।
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
