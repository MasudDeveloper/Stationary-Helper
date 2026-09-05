@extends('layouts.admin')

@section('title', 'নতুন অনুশীলনী তৈরি করুন')

@section('content')
<div class="content-header mb-4">
    <h2 class="text-white fw-bold">নতুন অনুশীলনী তৈরি করুন</h2>
    <p class="text-muted">উদ্দীপক এবং সঠিক হিসাব সমীকরণ উত্তর স্কিমা যুক্ত করুন</p>
</div>

<div class="glass p-5 rounded-2xl">
    <form action="{{ route('admin.accounting-solver.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">অধ্যায় নির্বাচন করুন</label>
                <select name="lesson_id" class="form-select bg-slate-800 text-white border-slate-700 rounded-xl" required>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}">অধ্যায় {{ $lesson->chapter_no }} : {{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-4">
                <label class="form-label text-slate-200">অনুশীলনীর শিরোনাম</label>
                <input type="text" name="title" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="যেমন: উদ্দীপক ও লেনদেন প্রভাব" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">উদ্দীপক / প্রশ্ন বর্ণনা (HTML ফরম্যাট সাপোর্ট করে)</label>
            <textarea name="stimulus" rows="5" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl" placeholder="প্রশ্ন উদ্দীপক এখানে লিখুন..." required></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label text-slate-200">সঠিক উত্তর স্কিমা (JSON format)</label>
            <textarea name="answer_schema" rows="6" class="form-control bg-slate-800 text-white border-slate-700 rounded-xl font-monospace" placeholder='[{"account": "নগদান হিসাব", "nature": "Asset", "type": "Dr", "amount": 50000}]' required></textarea>
            <div class="text-xs text-slate-500 mt-2">
                ফরম্যাট: <code>[{"account": "হিসাবের নাম", "nature": "Asset|Liability|Equity|Revenue|Expense", "type": "Dr|Cr", "amount": টাকার_পরিমাণ}]</code>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('admin.accounting-solver.index') }}" class="btn btn-outline-light rounded-xl">বাতিল করুন</a>
            <button type="submit" class="btn btn-success px-4 rounded-xl">সংরক্ষণ করুন</button>
        </div>
    </form>
</div>
@endsection
