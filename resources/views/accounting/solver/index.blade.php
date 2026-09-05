@extends('layouts.app')

@section('title', 'হিসাববিজ্ঞান ক্লাসরুম - penghor.com')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; margin-bottom: 30px;">
        <h2 style="color: #fff; font-weight: 700; border-left: 4px solid #10b981; padding-left: 12px; margin-bottom: 5px;">হিসাববিজ্ঞান ক্লাসরুম</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">জাতীয় শিক্ষাক্রম ও পাঠ্যপুস্তক বোর্ড (NCTB) সিলেবাস অনুযায়ী সমাধানকারী ও প্র্যাকটিস সেশন</p>
    </div>

    <div class="row">
        @forelse($lessons as $lesson)
            <div class="col-md-6 mb-4">
                <div class="glass" style="padding: 25px; border-radius: 16px; border-top: 4px solid #818cf8; transition: transform 0.2s;">
                    <span class="badge" style="background: rgba(129, 140, 248, 0.15); color: #c4b5fd; padding: 6px 12px; border-radius: 20px; font-weight: 700; margin-bottom: 15px; display: inline-block; border: 1px solid rgba(129, 140, 248, 0.3);">
                        অধ্যায় {{ $lesson->chapter_no }}
                    </span>
                    <h3 style="font-size: 1.4rem; color: #fff; font-weight: 700; margin-bottom: 10px;">{{ $lesson->title }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; min-height: 50px;">{{ $lesson->description }}</p>

                    <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; margin-top: 20px;">
                        <h5 style="font-size: 0.95rem; color: #cbd5e1; font-weight: 600; margin-bottom: 15px;">অনুশীলনীসমূহ:</h5>
                        <div class="list-group" style="gap: 10px;">
                            @forelse($lesson->exercises as $exercise)
                                @php
                                    $completed = isset($submissions[$exercise->id]) && $submissions[$exercise->id];
                                @endphp
                                <a href="{{ route('accounting.solver.show', $exercise->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-slate-900/40 text-slate-200 border-slate-800 rounded-xl" style="padding: 12px 18px; border: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="material-icons-round text-slate-400" style="font-size: 1.25rem;">task_alt</i>
                                        <span class="text-sm fw-medium">{{ $exercise->title }}</span>
                                    </div>
                                    @if($completed)
                                        <span class="badge bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1.5 rounded-pill text-xs">সম্পন্ন</span>
                                    @else
                                        <span class="badge bg-slate-800 text-slate-400 border border-slate-700 px-2.5 py-1.5 rounded-pill text-xs">বাকি আছে</span>
                                    @endif
                                </a>
                            @empty
                                <div class="text-sm text-slate-500">এই অধ্যায়ে কোনো অনুশীলনী যুক্ত করা হয়নি।</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="glass text-center py-5">
                    <h4 style="color: #94a3b8;">কোনো অধ্যায় পাওয়া যায়নি।</h4>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .glass:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection
