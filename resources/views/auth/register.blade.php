@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন - সহজ কাজ')

@section('content')
<div class="auth-wrapper">
    <div class="auth-left">
        <div class="text-center" style="color: white; max-width: 400px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 20px; color: var(--primary-color);">সহজ কাজ</h1>
            <p style="font-size: 1.1rem; line-height: 1.6; color: var(--text-muted);">সহজেই আপনার কাজ সম্পূর্ণ করতে আজই একটি একাউন্ট তৈরি করুন।</p>
        </div>
    </div>
    
    <div class="auth-right">
        <div class="auth-form-container">
            <div class="text-center mb-4">
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">রেজিস্টার করুন</h2>
                <p style="color: #6b7280; font-size: 0.95rem;">নতুন একাউন্ট খুলতে তথ্য দিন</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">নাম <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="আপনার নাম দিন" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">ইমেইল <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="আপনার ইমেইল দিন" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড <span style="color:red">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="পাসওয়ার্ড লিখুন" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span style="color:red">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="পাসওয়ার্ড আবার লিখুন" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">অ্যাকাউন্ট তৈরি করুন</button>
            </form>
            
            <div class="text-center mt-4" style="font-size: 0.9rem; color: #4b5563;">
                ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">লগিন করুন</a>
            </div>
        </div>
    </div>
</div>
@endsection
