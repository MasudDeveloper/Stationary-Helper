@extends('layouts.admin')

@section('title', 'অধ্যায় প্রশ্নাবলী: ' . $lesson->title)

@section('content')
<style>
.custom-pagination ul.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    gap: 6px;
    margin: 0;
    justify-content: center;
    flex-wrap: wrap;
}
.custom-pagination .page-link,
.custom-pagination .page-item a,
.custom-pagination .page-item span {
    background: rgba(30, 41, 59, 0.8) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: #cbd5e1 !important;
    padding: 8px 14px !important;
    border-radius: 8px !important;
    font-weight: 700 !important;
    font-size: 0.9rem !important;
    text-decoration: none !important;
    display: inline-block;
    transition: all 0.2s;
}
.custom-pagination .page-item.active .page-link,
.custom-pagination .page-item.active span {
    background: #2563eb !important;
    border-color: #2563eb !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}
.custom-pagination .page-item.disabled span,
.custom-pagination .page-item.disabled .page-link {
    background: rgba(15, 23, 42, 0.5) !important;
    color: #475569 !important;
    border-color: rgba(255, 255, 255, 0.05) !important;
}
.custom-pagination a.page-link:hover {
    background: rgba(59, 130, 246, 0.25) !important;
    color: #60a5fa !important;
}

.param-badge {
    background: rgba(15, 23, 42, 0.9);
    border: 1px solid rgba(59, 130, 246, 0.25);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.82rem;
    color: #93c5fd;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.param-badge strong {
    color: #38bdf8;
    font-weight: 700;
}
</style>

<!-- Top Header Bar -->
<div class="content-header mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.95)); padding: 22px 26px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.math-lessons.index') }}" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); color: #cbd5e1; border-radius: 10px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
            <i class="material-icons-round">arrow_back</i>
        </a>
        <div>
            <h2 class="text-white fw-bold mb-1" style="font-size: 1.45rem;">অধ্যায় #{{ $lesson->chapter_no }}: {{ $lesson->title }} 📝</h2>
            <p class="text-slate-400 mb-0" style="font-size: 0.88rem;">১-১০০টি ডাইনামিক পরামিতিক প্রশ্ন ও স্বয়ংক্রিয় সলভার ম্যানেজ করুন</p>
        </div>
    </div>
    
    <!-- Header Actions & Search -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <button onclick="toggleCard('instructionsCard')" style="background: rgba(14, 165, 233, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); padding: 9px 16px; border-radius: 10px; font-size: 0.88rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;">
            <i class="material-icons-round" style="font-size: 1.1rem;">help_outline</i>
            <span>ব্যবহার নির্দেশিকা (Guide)</span>
        </button>

        <button onclick="toggleCard('addQuestionCard')" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; padding: 9px 18px; border-radius: 10px; font-size: 0.88rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(37,99,235,0.3);">
            <i class="material-icons-round" style="font-size: 1.1rem;">add_circle</i>
            <span>নতুন প্রশ্ন যোগ করুন</span>
        </button>

        <form action="{{ route('admin.math-lessons.exercises', $lesson->id) }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="প্রশ্ন বা প্যাটার্ন খুঁজুন..." style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; border-radius: 10px; padding: 9px 14px; font-size: 0.88rem; outline: none; width: 190px;">
            <button type="submit" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 9px 14px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">খুঁজুন</button>
            @if($search)
                <a href="{{ route('admin.math-lessons.exercises', $lesson->id) }}" style="background: rgba(255,255,255,0.1); color: #cbd5e1; padding: 9px 12px; border-radius: 10px; font-size: 0.85rem; text-decoration: none;">রিসেট</a>
            @endif
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert border-0 rounded-2xl mb-4 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3) !important; color: #34d399; padding: 16px 20px;" role="alert">
        <i class="material-icons-round" style="font-size: 1.4rem;">check_circle</i>
        <span class="fw-semibold">{{ session('success') }}</span>
    </div>
@endif

<!-- Collapsible Instructions Guide Card -->
<div id="instructionsCard" style="display: none; background: rgba(15, 23, 42, 0.95); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 20px; padding: 24px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color: #38bdf8; font-weight: 800; font-size: 1.25rem; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round">menu_book</i>
            <span>প্যাটার্নভিত্তিক ডাইনামিক ইনপুট নির্দেশিকা (Pattern Guide)</span>
        </h4>
        <button onclick="toggleCard('instructionsCard')" style="background: rgba(255,255,255,0.1); color: #cbd5e1; border: none; padding: 4px 10px; border-radius: 6px; cursor: pointer;">বন্ধ করুন ✖</button>
    </div>
    
    <div class="row g-3" style="color: #cbd5e1; font-size: 0.92rem;">
        <div class="col-md-4">
            <div style="background: rgba(30, 41, 59, 0.6); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); height: 100%;">
                <h5 style="color: #fbbf24; font-weight: 700; font-size: 0.98rem;">📌 প্যাটার্ন ১ (মৌলিক ও ভগ্নাংশ)</h5>
                <p style="margin: 0; font-size: 0.85rem; line-height: 1.6;">
                    • <strong>s1/s2:</strong> সেট A ও B এর নাম<br>
                    • <strong>aLim:</strong> মৌলিক সংখ্যার সীমা<br>
                    • <strong>c1/c3:</strong> লব ও হর সহগ
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div style="background: rgba(30, 41, 59, 0.6); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); height: 100%;">
                <h5 style="color: #fbbf24; font-weight: 700; font-size: 0.98rem;">📌 প্যাটার্ন ২ (গুণনীয়ক ও এক-এক)</h5>
                <p style="margin: 0; font-size: 0.85rem; line-height: 1.6;">
                    • <strong>s1/s2:</strong> সেট P ও Q এর নাম<br>
                    • <strong>p1/q1:</strong> গুণনীয়ক ও গুণিতক সংখ্যা<br>
                    • <strong>uLim:</strong> সার্বিক সেটের সীমা
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div style="background: rgba(30, 41, 59, 0.6); padding: 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); height: 100%;">
                <h5 style="color: #fbbf24; font-weight: 700; font-size: 0.98rem;">📌 প্যাটার্ন ৩ (অন্বয় ও বহুপদী)</h5>
                <p style="margin: 0; font-size: 0.85rem; line-height: 1.6;">
                    • <strong>s1/s2:</strong> অন্বয় S ও সেট A<br>
                    • <strong>kRel:</strong> অন্বয়ের সম্পর্ক (y = kx)<br>
                    • <strong>fB/fC:</strong> বহুপদীর সহগ ও ধ্রুবক
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Collapsible Add New Question Card -->
<div id="addQuestionCard" style="display: none; background: rgba(15, 23, 42, 0.95); border: 1px solid rgba(37, 99, 235, 0.4); border-radius: 20px; padding: 24px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color: #60a5fa; font-weight: 800; font-size: 1.2rem; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round">add_circle</i>
            <span>নতুন পরামিতিক সৃজনশীল প্রশ্ন যোগ করুন</span>
        </h4>
        <button onclick="toggleCard('addQuestionCard')" style="background: rgba(255,255,255,0.1); color: #cbd5e1; border: none; padding: 4px 10px; border-radius: 6px; cursor: pointer;">বন্ধ করুন ✖</button>
    </div>

    <form action="{{ route('admin.math-lessons.exercises.store', $lesson->id) }}" method="POST">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-slate-300 font-semibold small">প্রশ্নের শিরোনাম</label>
                <input type="text" name="title" placeholder="যেমন: সৃজনশীল প্রশ্ন নং ১০১ (প্যাটার্ন ১)" style="background: rgba(30, 41, 59, 0.9); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 10px; padding: 10px 14px; width: 100%; outline: none;" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-slate-300 font-semibold small">প্যাটার্ন সিলেক্ট করুন (প্যাটার্ন পরিবর্তন করলে ইনপুট ঘর অটো বদলে যাবে)</label>
                <select id="new_pattern" onchange="renderDynamicFields('new', this.value)" style="background: rgba(30, 41, 59, 0.9); border: 1px solid rgba(255,255,255,0.15); color: #fbbf24; font-weight: 700; border-radius: 10px; padding: 10px 14px; width: 100%; outline: none;">
                    <option value="P1">প্যাটার্ন ১: মৌলিক সংখ্যা ও ভগ্নাংশ ফাংশন</option>
                    <option value="P2">প্যাটার্ন ২: গুণনীয়ক, গুণিতক ও এক-এক ফাংশন</option>
                    <option value="P3">প্যাটার্ন ৩: ক্রমজোড় অন্বয় ও বহুপদী ফাংশন</option>
                    <option value="P4">প্যাটার্ন ৪: সেট গঠন পদ্ধতি ও শক্তি সেট</option>
                    <option value="P5">প্যাটার্ন ৫: ভেনচিত্র ও পাওয়ার ফাংশন</option>
                </select>
            </div>
        </div>

        <!-- Dynamic Inputs Container for New Question -->
        <div id="dynamic_fields_new" class="row g-3 mb-4"></div>

        <input type="hidden" name="options" id="new_json_options">

        <button type="submit" onclick="syncNewOptionsJson()" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; padding: 12px 26px; border-radius: 12px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(37,99,235,0.4);">
            নতুন প্রশ্ন সংরক্ষণ করুন
        </button>
    </form>
</div>

<!-- Main Questions List Card -->
<div class="row g-4">
    <div class="col-12">
        <div style="background: rgba(15, 23, 42, 0.7); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 26px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-white fw-bold mb-0" style="font-size: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i class="material-icons-round" style="color: #fbbf24;">list_alt</i>
                    <span>অধ্যায়ের প্রশ্নাবলী</span>
                </h4>
                <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 6px 16px; border-radius: 20px; font-size: 0.88rem; font-weight: 800;">
                    মোট {{ $exercises->total() }}টি প্রশ্ন (প্রদর্শিত: {{ $exercises->firstItem() }} - {{ $exercises->lastItem() }})
                </span>
            </div>

            @forelse($exercises as $index => $exercise)
                @php
                    $opts = is_array($exercise->options) ? $exercise->options : json_decode($exercise->options, true) ?? [];
                    $qNum = $exercises->firstItem() + $index;
                    $pat = $opts['p'] ?? 'P1';
                @endphp
                
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255,255,255,0.08); border-radius: 18px; padding: 22px; margin-bottom: 22px;">
                    <!-- Question Header & Actions -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; padding: 5px 14px; border-radius: 8px; font-weight: 800; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(37,99,235,0.3);">
                                #{{ $qNum }}
                            </span>
                            <h5 style="color: #fbbf24; font-weight: 700; font-size: 1.08rem; margin: 0;">
                                {{ $exercise->title }}
                            </h5>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button onclick="toggleEditForm({{ $exercise->id }}, '{{ $pat }}')" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); padding: 7px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                <i class="material-icons-round" style="font-size: 1rem;">edit</i>
                                <span>পরামিতি এডিট করুন</span>
                            </button>

                            <form action="{{ route('admin.math-lessons.exercises.delete', $exercise->id) }}" method="POST" onsubmit="return confirm('এই প্রশ্নটি মুছে ফেলতে চান?')" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 7px 14px; border-radius: 10px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px;" title="ডিলিট">
                                    <i class="material-icons-round" style="font-size: 1rem;">delete</i>
                                    <span>ডিলিট</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Current Parameters Summary Badges with Bengali Labels -->
                    @if(count($opts) > 0)
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin: 14px 0; background: rgba(15, 23, 42, 0.5); padding: 12px 14px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.04);">
                            <span class="param-badge"><strong>প্যাটার্ন:</strong> {{ $pat }}</span>
                            <span class="param-badge"><strong>সেট ১ (s1):</strong> {{ $opts['s1'] ?? 'A' }}</span>
                            <span class="param-badge"><strong>সেট ২ (s2):</strong> {{ $opts['s2'] ?? 'B' }}</span>
                            <span class="param-badge"><strong>ফাংশন (fn):</strong> {{ $opts['fn'] ?? 'f' }}</span>
                            <span class="param-badge"><strong>চলক (vr):</strong> {{ $opts['vr'] ?? 'x' }}</span>
                            
                            @if(isset($opts['aLim']))
                                <span class="param-badge"><strong>মৌলিক সীমা (aLim):</strong> {{ $opts['aLim'] }}</span>
                            @endif
                            @if(isset($opts['c1']))
                                <span class="param-badge"><strong>সহগ (c1):</strong> {{ $opts['c1'] }}</span>
                            @endif
                            @if(isset($opts['p1']))
                                <span class="param-badge"><strong>গুণনীয়ক (p1):</strong> {{ $opts['p1'] }}</span>
                            @endif
                            @if(isset($opts['q1']))
                                <span class="param-badge"><strong>গুণিতক (q1):</strong> {{ $opts['q1'] }}</span>
                            @endif
                            @if(isset($opts['kRel']))
                                <span class="param-badge"><strong>অন্বয় সম্পর্ক (kRel):</strong> y={{ $opts['kRel'] }}x</span>
                            @endif
                            @if(isset($opts['tPow']))
                                <span class="param-badge"><strong>পাওয়ার (tPow):</strong> {{ $opts['tPow'] }}</span>
                            @endif
                        </div>
                    @endif

                    <!-- Hidden Edit Parameter Form -->
                    <div id="editForm_{{ $exercise->id }}" style="display: none; background: rgba(15, 23, 42, 0.95); border: 1px dashed rgba(245, 158, 11, 0.4); border-radius: 16px; padding: 24px; margin-top: 18px;">
                        <h6 style="color: #fbbf24; font-weight: 700; margin-bottom: 18px; font-size: 1.05rem;">⚙️ প্রশ্ন #{{ $qNum }} এর পরামিতি সম্পাদনা করুন:</h6>
                        
                        <form action="{{ route('admin.math-lessons.exercises.update', $exercise->id) }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-slate-300 small font-semibold">প্রশ্নের শিরোনাম</label>
                                    <input type="text" name="title" value="{{ $exercise->title }}" style="background: rgba(30, 41, 59, 0.9); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 10px; padding: 10px 14px; width: 100%; outline: none;" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-slate-300 small font-semibold">প্যাটার্ন সিলেক্ট করুন (বদলালে ইনপুট ঘর অটো পরিবর্তন হবে)</label>
                                    <select id="edit_pat_{{ $exercise->id }}" onchange="renderDynamicFields({{ $exercise->id }}, this.value)" style="background: rgba(30, 41, 59, 0.9); border: 1px solid rgba(255,255,255,0.15); color: #fbbf24; font-weight: 700; border-radius: 10px; padding: 10px 14px; width: 100%; outline: none;">
                                        <option value="P1" {{ $pat === 'P1' ? 'selected' : '' }}>প্যাটার্ন ১: মৌলিক সংখ্যা ও ভগ্নাংশ ফাংশন</option>
                                        <option value="P2" {{ $pat === 'P2' ? 'selected' : '' }}>প্যাটার্ন ২: গুণনীয়ক, গুণিতক ও এক-এক ফাংশন</option>
                                        <option value="P3" {{ $pat === 'P3' ? 'selected' : '' }}>প্যাটার্ন ৩: ক্রমজোড় অন্বয় ও বহুপদী ফাংশন</option>
                                        <option value="P4" {{ $pat === 'P4' ? 'selected' : '' }}>প্যাটার্ন ৪: সেট গঠন পদ্ধতি ও শক্তি সেট</option>
                                        <option value="P5" {{ $pat === 'P5' ? 'selected' : '' }}>প্যাটার্ন ৫: ভেনচিত্র ও পাওয়ার ফাংশন</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dynamic Inputs Container for Question Edit -->
                            <div id="dynamic_fields_{{ $exercise->id }}" class="row g-3 mb-4"></div>

                            <input type="hidden" name="options" id="json_options_{{ $exercise->id }}">

                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" onclick="syncOptionsJson({{ $exercise->id }})" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 700; cursor: pointer;">
                                    আপডেট ও সংরক্ষণ
                                </button>
                                <button type="button" onclick="toggleEditForm({{ $exercise->id }})" style="background: rgba(255,255,255,0.1); color: #cbd5e1; border: none; padding: 10px 18px; border-radius: 10px; cursor: pointer;">
                                    বাতিল
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="material-icons-round" style="font-size: 3.5rem; color: #475569;">quiz</i>
                    <p class="mt-2 mb-0" style="color: #94a3b8;">কোনো প্রশ্ন পাওয়া যায়নি।</p>
                </div>
            @endforelse

            <!-- Dark Pagination -->
            <div class="custom-pagination mt-4">
                {{ $exercises->appends(['search' => $search])->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script>
const exerciseOptionsMap = {};
@foreach($exercises as $ex)
    exerciseOptionsMap[{{ $ex->id }}] = @json(is_array($ex->options) ? $ex->options : json_decode($ex->options, true) ?? []);
@endforeach

function toggleCard(cardId) {
    const el = document.getElementById(cardId);
    if(el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
        if(el.style.display === 'block') {
            if(cardId === 'addQuestionCard') {
                renderDynamicFields('new', document.getElementById('new_pattern').value);
            }
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
}

function toggleEditForm(id, defaultPat) {
    const el = document.getElementById('editForm_' + id);
    if(el) {
        const isHidden = el.style.display === 'none';
        el.style.display = isHidden ? 'block' : 'none';
        if(isHidden) {
            const patSelect = document.getElementById('edit_pat_' + id);
            const pat = patSelect ? patSelect.value : (defaultPat || 'P1');
            renderDynamicFields(id, pat);
        }
    }
}

// DYNAMIC INPUT RENDERER ACCORDING TO PATTERN TYPE
function renderDynamicFields(id, pat) {
    const container = document.getElementById('dynamic_fields_' + id);
    if(!container) return;

    const opts = id === 'new' ? {} : (exerciseOptionsMap[id] || {});
    let html = '';

    if (pat === 'P1') {
        html = `
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট ১ নাম (s1)</label>
                <input type="text" id="df_${id}_s1" value="${opts.s1 || 'A'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট ২ নাম (s2)</label>
                <input type="text" id="df_${id}_s2" value="${opts.s2 || 'B'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">ফাংশন নাম (fn)</label>
                <input type="text" id="df_${id}_fn" value="${opts.fn || 'f'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">চলক (vr)</label>
                <input type="text" id="df_${id}_vr" value="${opts.vr || 'x'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">মৌলিক সীমা (aLim)</label>
                <input type="number" id="df_${id}_aLim" value="${opts.aLim !== undefined ? opts.aLim : 11}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">লব সহগ c1 (c1·x)</label>
                <input type="number" id="df_${id}_c1" value="${opts.c1 !== undefined ? opts.c1 : 3}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">লব ধ্রুবক (c2)</label>
                <input type="number" id="df_${id}_c2" value="${opts.c2 !== undefined ? opts.c2 : 1}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">হর সহগ c3 (c3·x)</label>
                <input type="number" id="df_${id}_c3" value="${opts.c3 !== undefined ? opts.c3 : 3}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
        `;
    } else if (pat === 'P2') {
        html = `
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট P নাম (s1)</label>
                <input type="text" id="df_${id}_s1" value="${opts.s1 || 'P'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট Q নাম (s2)</label>
                <input type="text" id="df_${id}_s2" value="${opts.s2 || 'Q'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">ফাংশন নাম (fn)</label>
                <input type="text" id="df_${id}_fn" value="${opts.fn || 'g'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">চলক (vr)</label>
                <input type="text" id="df_${id}_vr" value="${opts.vr || 'y'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সার্বিক সেট সীমা (uLim)</label>
                <input type="number" id="df_${id}_uLim" value="${opts.uLim !== undefined ? opts.uLim : 10}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">গুণনীয়ক সংখ্যা (p1)</label>
                <input type="number" id="df_${id}_p1" value="${opts.p1 !== undefined ? opts.p1 : 12}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">গুণিতক সংখ্যা (q1)</label>
                <input type="number" id="df_${id}_q1" value="${opts.q1 !== undefined ? opts.q1 : 3}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">গুণিতক সীমা (q2)</label>
                <input type="number" id="df_${id}_q2" value="${opts.q2 !== undefined ? opts.q2 : 9}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
        `;
    } else if (pat === 'P3') {
        html = `
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">অন্বয় নাম (s1)</label>
                <input type="text" id="df_${id}_s1" value="${opts.s1 || 'S'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট A নাম (s2)</label>
                <input type="text" id="df_${id}_s2" value="${opts.s2 || 'A'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">ফাংশন নাম (fn)</label>
                <input type="text" id="df_${id}_fn" value="${opts.fn || 'F'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">চলক (vr)</label>
                <input type="text" id="df_${id}_vr" value="${opts.vr || 'x'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-4">
                <label class="form-label text-slate-300 small font-semibold">অন্বয় সম্পর্ক y = kx (kRel)</label>
                <input type="number" id="df_${id}_kRel" value="${opts.kRel !== undefined ? opts.kRel : 2}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-4">
                <label class="form-label text-slate-300 small font-semibold">x² এর সহগ (fB)</label>
                <input type="number" id="df_${id}_fB" value="${opts.fB !== undefined ? opts.fB : 5}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-4">
                <label class="form-label text-slate-300 small font-semibold">ধ্রুবক পদ (fC)</label>
                <input type="number" id="df_${id}_fC" value="${opts.fC !== undefined ? opts.fC : -3}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
        `;
    } else if (pat === 'P4') {
        html = `
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট A নাম (s1)</label>
                <input type="text" id="df_${id}_s1" value="${opts.s1 || 'A'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট B নাম (s2)</label>
                <input type="text" id="df_${id}_s2" value="${opts.s2 || 'B'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">ফাংশন নাম (fn)</label>
                <input type="text" id="df_${id}_fn" value="${opts.fn || 'f'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">চলক (vr)</label>
                <input type="text" id="df_${id}_vr" value="${opts.vr || 'x'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">x² সীমা (sqLim)</label>
                <input type="number" id="df_${id}_sqLim" value="${opts.sqLim !== undefined ? opts.sqLim : 4}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">গুণনীয়ক (gn)</label>
                <input type="number" id="df_${id}_gn" value="${opts.gn !== undefined ? opts.gn : 6}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">লব সহগ (c1)</label>
                <input type="number" id="df_${id}_c1" value="${opts.c1 !== undefined ? opts.c1 : 2}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">হর সহগ (c3)</label>
                <input type="number" id="df_${id}_c3" value="${opts.c3 !== undefined ? opts.c3 : 2}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
        `;
    } else { // P5
        html = `
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট A নাম (s1)</label>
                <input type="text" id="df_${id}_s1" value="${opts.s1 || 'A'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">সেট B নাম (s2)</label>
                <input type="text" id="df_${id}_s2" value="${opts.s2 || 'B'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">ফাংশন নাম (fn)</label>
                <input type="text" id="df_${id}_fn" value="${opts.fn || 'g'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-3">
                <label class="form-label text-slate-300 small font-semibold">চলক (vr)</label>
                <input type="text" id="df_${id}_vr" value="${opts.vr || 't'}" class="form-control bg-slate-800 border-slate-700 text-info fw-bold">
            </div>
            <div class="col-md-6">
                <label class="form-label text-slate-300 small font-semibold">পাওয়ার tⁿ (tPow)</label>
                <input type="number" id="df_${id}_tPow" value="${opts.tPow !== undefined ? opts.tPow : 3}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
            <div class="col-md-6">
                <label class="form-label text-slate-300 small font-semibold">ধ্রুবক k (kVal)</label>
                <input type="number" id="df_${id}_kVal" value="${opts.kVal !== undefined ? opts.kVal : 1}" class="form-control bg-slate-800 border-slate-700 text-success fw-bold">
            </div>
        `;
    }

    container.innerHTML = html;
}

function syncOptionsJson(id) {
    const patSelect = document.getElementById('edit_pat_' + id);
    const pattern = patSelect ? patSelect.value : 'P1';
    
    const getV = (key, def) => {
        const el = document.getElementById(`df_${id}_${key}`);
        if(!el) return def;
        return isNaN(el.value) || el.value === "" ? el.value : parseFloat(el.value);
    };

    const data = {
        id: id,
        p: pattern,
        s1: getV('s1', 'A'),
        s2: getV('s2', 'B'),
        fn: getV('fn', 'f'),
        vr: getV('vr', 'x'),
        aLim: getV('aLim', 11),
        b1: 9,
        b2: 130,
        c1: getV('c1', 3),
        c2: getV('c2', 1),
        c3: getV('c3', 3),
        c4: -1,
        uLim: getV('uLim', 10),
        p1: getV('p1', 12),
        q1: getV('q1', 3),
        q2: getV('q2', 9),
        kRel: getV('kRel', 2),
        fA: 1,
        fB: getV('fB', 5),
        fC: getV('fC', -3),
        sqLim: getV('sqLim', 4),
        gn: getV('gn', 6),
        kVal: getV('kVal', 1),
        tPow: getV('tPow', 3)
    };

    document.getElementById('json_options_' + id).value = JSON.stringify(data);
}

function syncNewOptionsJson() {
    const pattern = document.getElementById('new_pattern').value;
    
    const getV = (key, def) => {
        const el = document.getElementById(`df_new_${key}`);
        if(!el) return def;
        return isNaN(el.value) || el.value === "" ? el.value : parseFloat(el.value);
    };

    const data = {
        p: pattern,
        s1: getV('s1', 'A'),
        s2: getV('s2', 'B'),
        fn: getV('fn', 'f'),
        vr: getV('vr', 'x'),
        aLim: getV('aLim', 11),
        b1: 9,
        b2: 130,
        c1: getV('c1', 3),
        c2: getV('c2', 1),
        c3: getV('c3', 3),
        c4: -1,
        uLim: getV('uLim', 10),
        p1: getV('p1', 12),
        q1: getV('q1', 3),
        q2: getV('q2', 9),
        kRel: getV('kRel', 2),
        fA: 1,
        fB: getV('fB', 5),
        fC: getV('fC', -3),
        sqLim: getV('sqLim', 4),
        gn: getV('gn', 6),
        kVal: getV('kVal', 1),
        tPow: getV('tPow', 3)
    };

    document.getElementById('new_json_options').value = JSON.stringify(data);
}

document.addEventListener('DOMContentLoaded', () => {
    // Initial dynamic render for new question form if open
    renderDynamicFields('new', 'P1');
});
</script>
@endsection
