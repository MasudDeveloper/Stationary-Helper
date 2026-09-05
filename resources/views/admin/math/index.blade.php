@extends('layouts.admin')

@section('title', 'গণিত ক্লাসরুম কন্ট্রোল')

@section('content')
<div class="content-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9)); padding: 24px 28px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round" style="color: #fbbf24; font-size: 1.5rem;">calculate</i>
            </div>
            <h2 class="text-white fw-bold mb-0" style="font-size: 1.6rem; letter-spacing: -0.5px;">গণিত ক্লাসরুম কন্ট্রোল</h2>
        </div>
        <p class="text-slate-400 mb-0" style="font-size: 0.95rem; margin-left: 50px;">
            SSC ও মাধ্যমিকের ১৭টি অধ্যায়ের গণিত কন্টেন্ট ও প্রশ্নসমূহ এডিট/ম্যানেজ করুন।
        </p>
    </div>
    <div>
        <a href="{{ route('admin.math-lessons.create') }}" class="btn d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; font-weight: 700; border-radius: 12px; padding: 12px 22px; border: none; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <i class="material-icons-round">add_circle</i>
            <span>নতুন অধ্যায় যোগ করুন</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert border-0 rounded-2xl mb-4 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3) !important; color: #34d399; padding: 16px 20px;" role="alert">
        <i class="material-icons-round" style="font-size: 1.4rem;">check_circle</i>
        <span class="fw-semibold">{{ session('success') }}</span>
    </div>
@endif

<!-- Quick Overview Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round" style="color: #60a5fa; font-size: 1.6rem;">menu_book</i>
            </div>
            <div>
                <div style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">মোট অধ্যায়</div>
                <div style="color: #fff; font-size: 1.5rem; font-weight: 800;">{{ $lessons->count() }}টি</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round" style="color: #34d399; font-size: 1.6rem;">verified</i>
            </div>
            <div>
                <div style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">সক্রিয় অধ্যায়</div>
                <div style="color: #fff; font-size: 1.5rem; font-weight: 800;">{{ $lessons->where('is_active', true)->count() }}টি</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round" style="color: #fbbf24; font-size: 1.6rem;">quiz</i>
            </div>
            <div>
                <div style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">মোট কাস্টম প্রশ্ন</div>
                <div style="color: #fff; font-size: 1.5rem; font-weight: 800;">{{ $lessons->sum('exercises_count') }}টি</div>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div style="background: rgba(15, 23, 42, 0.7); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th class="py-3 px-3" style="width: 90px;">অধ্যায় নং</th>
                    <th class="py-3 px-3">অধ্যায়ের শিরোনাম</th>
                    <th class="py-3 px-3">বিবরণ</th>
                    <th class="py-3 px-3 text-center" style="width: 110px;">প্রশ্ন সংখ্যা</th>
                    <th class="py-3 px-3 text-center" style="width: 100px;">অবস্থা</th>
                    <th class="py-3 px-3 text-end" style="width: 280px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.2s;">
                        <td class="py-3 px-3">
                            <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 0.85rem;">
                                #{{ $lesson->chapter_no }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-white fw-bold" style="font-size: 0.98rem;">
                            {{ $lesson->title }}
                        </td>
                        <td class="py-3 px-3 style="color: #cbd5e1; font-size: 0.88rem;">
                            {{ Str::limit($lesson->description, 65) }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <span style="background: rgba(255, 255, 255, 0.06); color: #e2e8f0; border: 1px solid rgba(255, 255, 255, 0.1); padding: 4px 12px; border-radius: 12px; font-weight: 700; font-size: 0.82rem;">
                                {{ $lesson->exercises_count }}টি
                            </span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($lesson->is_active)
                                <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.78rem;">Active</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.78rem;">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.math-lessons.exercises', $lesson->id) }}" style="background: rgba(14, 165, 233, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); padding: 6px 12px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='rgba(14, 165, 233, 0.3)'" onmouseout="this.style.background='rgba(14, 165, 233, 0.15)'">
                                    <i class="material-icons-round" style="font-size: 0.95rem;">quiz</i>
                                    <span>প্রশ্নসমূহ ({{ $lesson->exercises_count }})</span>
                                </a>
                                
                                <a href="{{ route('admin.math-lessons.edit', $lesson->id) }}" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); padding: 6px 12px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='rgba(245, 158, 11, 0.3)'" onmouseout="this.style.background='rgba(245, 158, 11, 0.15)'">
                                    <i class="material-icons-round" style="font-size: 0.95rem;">edit</i>
                                    <span>এডিট</span>
                                </a>

                                <form action="{{ route('admin.math-lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই অধ্যায়টি মুছে ফেলতে চান?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.3); padding: 6px 12px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.3)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.15)'">
                                        <i class="material-icons-round" style="font-size: 0.95rem;">delete</i>
                                        <span>ডিলিট</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="material-icons-round" style="font-size: 3rem; color: #475569;">functions</i>
                            <p class="mt-2 mb-0" style="color: #94a3b8;">কোনো অধ্যায় পাওয়া যায়নি। নতুন অধ্যায় যোগ করুন।</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
