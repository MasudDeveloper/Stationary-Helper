@extends('layouts.app')

@section('title', 'গণিত ক্লাসরুম - Master Mathematics')

@section('content')
<div class="container py-5" style="color: var(--text-main); font-family: 'Outfit', 'Inter', 'Hind Siliguri', sans-serif;">
    <!-- Welcome Header -->
    <div style="text-align: center; margin-bottom: 50px; position: relative;">
        <!-- Glowing background blobs -->
        <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 250px; height: 250px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 70%); z-index: -1;"></div>

        <div style="margin-bottom: 20px;">
            <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 8px 20px; border-radius: 30px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="font-size: 1rem;">school</i> MATHEMATICS CLASSROOM
            </span>
        </div>

        <h1 style="font-size: 3.2rem; font-weight: 800; color: #fff; margin-bottom: 15px; letter-spacing: -0.5px; line-height: 1.2;">
            গণিত মাস্টারক্লাস
        </h1>

        <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 650px; margin: 0 auto 30px auto; line-height: 1.7;">
            পাটিগণিত, বীজগণিত, জ্যামিতি ও পরিসংখ্যানের মৌলিক সূত্র, ইন্টারেক্টিভ কুইজ এবং গ্রাফ পেপার সলভার দিয়ে সহজে গণিত শিখুন।
        </p>

        <a href="{{ route('lms.dashboard') }}" class="btn btn-secondary py-2 px-4" style="border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--border-color);">
            <i class="material-icons-round">arrow_back</i>
            <span>লার্নিং পোর্টালে ফিরে যান</span>
        </a>
    </div>

    <!-- Syllabus Sections (Grid of chapters) -->
    <div>
        <div style="margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
            <span style="width: 24px; height: 4px; background-color: #f59e0b; display: inline-block; border-radius: 2px;"></span>
            <h3 style="color: #fff; font-weight: 800; font-size: 1.4rem; margin: 0; letter-spacing: 0.5px;">
                অধ্যায় সমূহ (Mathematics Chapters)
            </h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
            @foreach($lessons as $lesson)
                @php
                    $isActive = $lesson->is_active ?? true;
                    $borderCol = $isActive ? 'rgba(245, 158, 11, 0.3)' : 'rgba(255, 255, 255, 0.08)';
                    $gradCol = $isActive ? 'linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%)' : 'linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(0, 0, 0, 0.4) 100%)';
                @endphp
                <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 25px; min-height: 250px; border-radius: 20px; border: 1px solid {{ $borderCol }}; background: {{ $gradCol }}; transition: all 0.3s; position: relative; overflow: hidden;">
                    
                    @if($isActive)
                        <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0) 70%);"></div>
                    @endif

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #fbbf24; background: rgba(245, 158, 11, 0.1); padding: 4px 10px; border-radius: 6px;">
                                অধ্যায় {{ $lesson->chapter_no }}
                            </span>
                            @if($isActive)
                                <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Ready / Active</span>
                            @else
                                <span style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border: 1px solid rgba(255, 255, 255, 0.1); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming</span>
                            @endif
                        </div>

                        <h4 style="color: #fff; font-size: 1.25rem; font-weight: 700; margin: 0 0 10px 0;">{{ $lesson->title }}</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin: 0 0 20px 0;">{{ $lesson->description }}</p>
                    </div>

                    <div>
                        @if($isActive)
                            <a href="{{ route('math.show', $lesson->id) }}" class="btn w-100" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; text-decoration: none; padding: 10px; border-radius: 8px; font-weight: 600; text-align: center; display: block; transition: transform 0.2s;">
                                পড়া শুরু করুন <i class="material-icons-round" style="font-size: 0.95rem; vertical-align: middle; margin-left: 4px;">arrow_forward</i>
                            </a>
                        @else
                            <a href="{{ route('math.show', $lesson->id) }}" class="btn w-100" style="background: rgba(255,255,255,0.05); color: var(--text-muted); text-decoration: none; border: 1px solid rgba(255,255,255,0.05); padding: 10px; border-radius: 8px; font-weight: 600; text-align: center; display: block;">
                                অধ্যায় পরিচিতি <i class="material-icons-round" style="font-size: 0.95rem; vertical-align: middle; margin-left: 4px;">lock</i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
