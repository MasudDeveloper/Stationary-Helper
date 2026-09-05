@extends('layouts.admin')

@section('title', isset($lesson) ? 'লেভেল সম্পাদন করুন' : 'নতুন লেভেল তৈরি করুন')

@section('content')
<div class="content-header mb-4">
    <h2 class="text-white fw-bold">{{ isset($lesson) ? 'লেভেল সম্পাদন করুন ✏️' : 'নতুন লেভেল তৈরি করুন ➕' }}</h2>
    <p class="text-muted">গ্রামার সিলেবাসের বিষয়বস্তু এবং নিয়মাবলী যুক্ত বা সম্পাদন করুন।</p>
</div>

<div class="glass p-5 rounded-2xl mb-5">
    <form action="{{ isset($lesson) ? route('admin.grammar-lessons.update', $lesson->id) : route('admin.grammar-lessons.store') }}" method="POST">
        @csrf
        @if(isset($lesson))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">লেভেল নম্বর (Level Number)</label>
                <input type="number" name="level_no" value="{{ old('level_no', $lesson->level_no ?? '') }}" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: ১, ২, ৩..." required>
            </div>
            
            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">লেভেল শিরোনাম (Level Name)</label>
                <input type="text" name="level_name" value="{{ old('level_name', $lesson->level_name ?? '') }}" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: Parts of Speech (Noun)..." required>
            </div>

            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">শ্রেণী / ক্যাটাগরি (Category)</label>
                <input type="text" name="category" value="{{ old('category', $lesson->category ?? '') }}" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: LEVEL 1 — Class 3–4 Foundation" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">মূল নিয়ম (Rule)</label>
            <textarea name="rule" rows="4" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="এখানে নিয়মের মূল সারসংক্ষেপ লিখুন...">{{ old('rule', $lesson->rule ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">সূত্র / স্ট্রাকচার (Formula)</label>
            <textarea name="formula" rows="2" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl font-monospace" placeholder="যেমন: Subject + Verb + Object...">{{ old('formula', $lesson->formula ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">কীভাবে চিনবে (Recognition)</label>
            <textarea name="recognition" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="সেন্টেন্সে কোন সংকেত বা আচরণ দেখে চেনা যাবে...">{{ old('recognition', $lesson->recognition ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">সমাধানের ধাপ ১ (Step 1)</label>
                <textarea name="step_1" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="প্রথম ধাপ...">{{ old('step_1', $lesson->step_1 ?? '') }}</textarea>
            </div>
            
            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">সমাধানের ধাপ ২ (Step 2)</label>
                <textarea name="step_2" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="দ্বিতীয় ধাপ...">{{ old('step_2', $lesson->step_2 ?? '') }}</textarea>
            </div>

            <div class="col-md-4 mb-4">
                <label class="form-label text-slate-200">সমাধানের ধাপ ৩ (Step 3)</label>
                <textarea name="step_3" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="তৃতীয় ধাপ...">{{ old('step_3', $lesson->step_3 ?? '') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">সঠিক উদাহরণ (Examples)</label>
                <textarea name="example" rows="4" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="সঠিক সেন্টেন্সের উদাহরণ...">{{ old('example', $lesson->example ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">সাধারণ ভুল (Common Mistakes)</label>
                <textarea name="common_mistake" rows="4" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="কমন ভুলসমূহ এবং কীভাবে তা পরিহার করবে...">{{ old('common_mistake', $lesson->common_mistake ?? '') }}</textarea>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">পরীক্ষায় উত্তর লেখার নিয়ম (Exam Answering Strategy)</label>
            <textarea name="exam_answer_pattern" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="পরীক্ষায় কীভাবে উত্তর লিখতে হবে...">{{ old('exam_answer_pattern', $lesson->exam_answer_pattern ?? '') }}</textarea>
        </div>

        <div class="mb-4 d-flex align-items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input bg-slate-800 border-slate-700 rounded" {{ old('is_active', $lesson->is_active ?? true) ? 'checked' : '' }} style="width: 20px; height: 20px; cursor: pointer;">
            <label for="is_active" class="form-check-label text-slate-200" style="cursor: pointer;">লেভেলটি সক্রিয় করুন (Publish Level)</label>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('admin.grammar-lessons.index') }}" class="btn btn-outline-light rounded-xl">বাতিল করুন</a>
            <button type="submit" class="btn btn-success px-4 rounded-xl" style="background-color: #10b981; border: none;">সংরক্ষণ করুন</button>
        </div>
    </form>
</div>
@endsection
