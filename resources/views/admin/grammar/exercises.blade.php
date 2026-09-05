@extends('layouts.admin')

@section('title', 'কুইজ প্রশ্নাবলী ম্যানেজ করুন')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.grammar-lessons.index') }}" class="d-inline-flex align-items-center gap-1 text-slate-400 hover:text-white text-decoration-none" style="transition: color 0.2s;">
        <i class="material-icons-round" style="font-size: 1.15rem;">arrow_back</i>
        <span>লেভেল লিস্টে ফিরে যান</span>
    </a>
</div>

<div class="content-header mb-4">
    <h2 class="text-white fw-bold">কুইজ প্রশ্নাবলী ম্যানেজ করুন 📝</h2>
    <p class="text-muted">লেভেল #{{ $lesson->level_no }}: <strong>{{ $lesson->level_name }}</strong>-এর জন্য অনুশীলন প্রশ্নাবলী নিয়ন্ত্রণ করুন।</p>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 bg-emerald-500/10 text-emerald-400 rounded-xl mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <!-- Existing Questions (Left) -->
    <div class="col-lg-7 mb-4">
        <div class="glass p-4 rounded-2xl">
            <h4 class="text-white font-weight-bold mb-4" style="font-family: 'Hind Siliguri', sans-serif;">বর্তমান প্রশ্নসমূহ ({{ $lesson->exercises->count() }}টি)</h4>
            
            <div class="space-y-4">
                @forelse($lesson->exercises as $index => $exercise)
                    <div class="p-3 rounded mb-3 position-relative" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255,255,255,0.04);">
                        <!-- Delete Button (Top Right) -->
                        <div class="position-absolute" style="right: 15px; top: 15px;">
                            <form action="{{ route('admin.grammar-lessons.exercises.destroy', $exercise->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 rounded-circle" title="মুছে ফেলুন">
                                    <i class="material-icons-round" style="font-size: 1.15rem;">delete</i>
                                </button>
                            </form>
                        </div>

                        <p class="text-indigo-400 fw-bold small mb-1">প্রশ্ন {{ $index + 1 }}</p>
                        <div class="text-white small mb-3">{!! $exercise->question !!}</div>

                        <!-- Options List -->
                        <div class="row g-2 mb-3">
                            @foreach($exercise->options as $option)
                                @php
                                    $isCorrect = ($option === $exercise->correct_answer);
                                @endphp
                                <div class="col-6">
                                    <div class="p-2 rounded small d-flex align-items-center gap-2 {{ $isCorrect ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 fw-semibold' : 'bg-slate-800/40 text-slate-400 border border-slate-700/30' }}">
                                        @if($isCorrect)
                                            <i class="material-icons-round" style="font-size: 0.95rem;">check_circle</i>
                                        @else
                                            <i class="material-icons-round" style="font-size: 0.95rem;">radio_button_unchecked</i>
                                        @endif
                                        <span>{{ $option }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Explanation -->
                        @if($exercise->explanation)
                            <div class="p-3 rounded bg-slate-900 border border-slate-800 small text-slate-400">
                                <strong class="text-indigo-400">ব্যাখ্যা:</strong> {{ $exercise->explanation }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="material-icons-round" style="font-size: 3rem;">quiz</i>
                        <p class="mt-2 mb-0">কোনো অনুশীলন প্রশ্ন পাওয়া যায়নি। ডানে ফর্ম ব্যবহার করে প্রথম প্রশ্ন যোগ করুন।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Create Question Form (Right) -->
    <div class="col-lg-5 mb-4">
        <div class="glass p-4 rounded-2xl sticky-top" style="top: 100px; z-index: 10;">
            <h4 class="text-white font-weight-bold mb-4" style="font-family: 'Hind Siliguri', sans-serif;">নতুন প্রশ্ন যোগ করুন</h4>

            <form action="{{ route('admin.grammar-lessons.exercises.store', $lesson->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-slate-200">প্রশ্ন বর্ণনা (Question Title / Html tags allowed)</label>
                    <textarea name="question" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: Fill in the blank: She is ______ honest girl." required>{{ old('question') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-slate-200">অপশন সমূহ (Options)</label>
                    <div class="row g-2">
                        <div class="col-6 mb-2">
                            <input type="text" name="options[]" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl form-control-sm" placeholder="Option A" required>
                        </div>
                        <div class="col-6 mb-2">
                            <input type="text" name="options[]" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl form-control-sm" placeholder="Option B" required>
                        </div>
                        <div class="col-6">
                            <input type="text" name="options[]" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl form-control-sm" placeholder="Option C" required>
                        </div>
                        <div class="col-6">
                            <input type="text" name="options[]" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl form-control-sm" placeholder="Option D" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-slate-200">সঠিক উত্তর (Exact text from options)</label>
                    <input type="text" name="correct_answer" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: a, an, true, etc. (বানান মিলিয়ে লিখুন)" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-slate-200">বাংলা ব্যাখ্যা (Explanation in Bengali)</label>
                    <textarea name="explanation" rows="3" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="প্রশ্নটির সঠিক উত্তরের স্বপক্ষে ব্যাখ্যা প্রদান করুন...">{{ old('explanation') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 rounded-xl" style="background-color: #10b981; border: none;">
                    প্রশ্ন যুক্ত করুন
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
