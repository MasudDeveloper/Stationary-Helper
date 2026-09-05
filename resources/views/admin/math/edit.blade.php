@extends('layouts.admin')

@section('title', isset($lesson) ? 'অধ্যায় সম্পাদনা' : 'নতুন অধ্যায় যোগ করুন')

@section('content')
<div class="content-header mb-4 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9)); padding: 20px 24px; border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.08);">
    <a href="{{ route('admin.math-lessons.index') }}" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); color: #cbd5e1; border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
        <i class="material-icons-round">arrow_back</i>
    </a>
    <div>
        <h2 class="text-white fw-bold mb-0" style="font-size: 1.4rem;">{{ isset($lesson) ? 'গণিত অধ্যায় সম্পাদনা ✏️' : 'নতুন গণিত অধ্যায় যোগ করুন ➕' }}</h2>
        <p class="text-slate-400 mb-0" style="font-size: 0.88rem;">অধ্যায়ের শিরোনাম ও সংক্ষিপ্ত বিবরণ সংশোধন/সংরক্ষণ করুন</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div style="background: rgba(15, 23, 42, 0.7); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.08); padding: 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <form action="{{ isset($lesson) ? route('admin.math-lessons.update', $lesson->id) : route('admin.math-lessons.store') }}" method="POST">
                @csrf
                @if(isset($lesson))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: #cbd5e1; font-size: 0.9rem;">অধ্যায় নম্বর</label>
                    <input type="number" name="chapter_no" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(255, 255, 255, 0.15); color: #fbbf24; font-weight: 700; border-radius: 12px; padding: 12px 16px; outline: none; width: 100%;" value="{{ old('chapter_no', $lesson->chapter_no ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: #cbd5e1; font-size: 0.9rem;">অধ্যায়ের শিরোনাম</label>
                    <input type="text" name="title" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; border-radius: 12px; padding: 12px 16px; outline: none; width: 100%;" value="{{ old('title', $lesson->title ?? '') }}" placeholder="যেমন: সেট ও ফাংশন (Set & Function)" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: #cbd5e1; font-size: 0.9rem;">বিবরণ</label>
                    <textarea name="description" rows="4" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(255, 255, 255, 0.15); color: #cbd5e1; border-radius: 12px; padding: 12px 16px; outline: none; width: 100%;" placeholder="অধ্যায়ের সংক্ষিপ্ত বিষয়বস্তু...">{{ old('description', $lesson->description ?? '') }}</textarea>
                </div>

                <div class="mb-4 d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_active" id="isActive" style="width: 18px; height: 18px; accent-color: #f59e0b;" {{ old('is_active', $lesson->is_active ?? true) ? 'checked' : '' }}>
                    <label for="isActive" style="color: #e2e8f0; font-weight: 600; cursor: pointer; font-size: 0.95rem;">অ্যাক্টিভ হিসেবে প্রকাশ করুন</label>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <button type="submit" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; font-weight: 700; border-radius: 12px; padding: 12px 26px; border: none; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem;">save</i>
                        <span>সংরক্ষণ করুন</span>
                    </button>
                    <a href="{{ route('admin.math-lessons.index') }}" style="background: rgba(255,255,255,0.06); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.12); border-radius: 12px; padding: 12px 22px; font-weight: 600; text-decoration: none;">বাতিল</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
