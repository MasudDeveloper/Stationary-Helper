@extends('layouts.admin')

@section('title', 'অনুশীলনী আপডেট করুন')

@section('content')
<div class="content-header mb-4">
    <h2 class="text-white fw-bold">অনুশীলনী আপডেট করুন</h2>
    <p class="text-muted">উদ্দীপক এবং সঠিক হিসাব সমীকরণ উত্তর স্কিমা আপডেট করুন</p>
</div>

<div class="glass p-5 rounded-2xl">
    <form action="{{ route('admin.accounting-solver.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">অধ্যায় নির্বাচন করুন</label>
                <select name="lesson_id" class="form-select bg-slate-800 text-white border-slate-700 rounded-xl" required>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $exercise->lesson_id == $lesson->id ? 'selected' : '' }}>অধ্যায় {{ $lesson->chapter_no }} : {{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">অনুশীলনীর শিরোনাম</label>
                <input type="text" name="title" value="{{ $exercise->title }}" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">উদ্দীপক / প্রশ্ন বর্ণনা</label>
            <textarea name="stimulus" rows="5" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" required>{{ $exercise->stimulus }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">সঠিক উত্তর স্কিমা (JSON format)</label>
            <textarea name="answer_schema" rows="6" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl font-monospace" required>{{ json_encode($exercise->answer_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('admin.accounting-solver.index') }}" class="btn btn-outline-light rounded-xl">বাতিল করুন</a>
            <button type="submit" class="btn btn-success px-4 rounded-xl">আপডেট করুন</button>
        </div>
    </form>
</div>
@endsection
