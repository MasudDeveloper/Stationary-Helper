@extends('layouts.app')

@section('title', 'ক্রেডিট রিচার্জ - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="glass" style="max-width: 600px; margin: 0 auto; padding: 40px;">
        <h2 style="color: var(--primary-color); margin-bottom: 10px; text-align: center;">ক্রেডিট রিচার্জ করুন</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">বিকাশ এর মাধ্যমে ম্যানুয়ালি পেমেন্ট করে ফর্মটি পূরণ করুন</p>
        
        @if (session('success'))
            <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: rgba(245, 158, 11, 0.1); border: 1px dashed var(--primary-color); padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
            <h4 style="margin-bottom: 10px;">বিকাশ পার্সোনাল নম্বর:</h4>
            <h2 style="color: var(--text-main); letter-spacing: 2px;">017XX-XXXXXX</h2>
            <p style="font-size: 0.9rem; margin-top: 10px; color: var(--text-muted);">এই নম্বরে সেন্ড মানি করে নিচের ফর্মটি পূরণ করুন। (১ টাকা = ১ ক্রেডিট)</p>
        </div>

        <form method="POST" action="{{ route('recharge') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">পরিমাণ (টাকা) <span style="color:red">*</span></label>
                <input type="number" name="amount" class="form-control" placeholder="কত টাকা পাঠিয়েছেন?" value="{{ old('amount') }}" required min="10">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">যে নম্বর থেকে টাকা পাঠিয়েছেন <span style="color:red">*</span></label>
                <input type="text" name="sender_number" class="form-control" placeholder="আপনার বিকাশ নম্বর" value="{{ old('sender_number') }}" required>
                @error('sender_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">ট্রানজেকশন আইডি (TrxID) <span style="color:red">*</span></label>
                <input type="text" name="transaction_id" class="form-control" placeholder="TrxID দিন" value="{{ old('transaction_id') }}" required>
                @error('transaction_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">রিকোয়েস্ট সাবমিট করুন</button>
        </form>
    </div>
</div>
@endsection
