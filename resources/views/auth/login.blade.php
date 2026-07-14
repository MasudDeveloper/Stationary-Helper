@extends('layouts.app')

@section('title', 'লগিন - সহজ কাজ')

@section('content')
<div class="auth-wrapper">
    <div class="auth-left">
        <div class="text-center" style="color: white; max-width: 400px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 20px; color: var(--primary-color);">সহজ কাজ</h1>
            <p style="font-size: 1.1rem; line-height: 1.6; color: var(--text-muted);">সহজেই স্যাম্পল ডকুমেন্টস বা টেমপ্লেট থেকে আপনার ডকুমেন্ট তৈরি করুন।</p>
        </div>
    </div>
    
    <div class="auth-right">
        <div class="auth-form-container">
            <div class="text-center mb-4">
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">লগিন করুন</h2>
                <p style="color: #6b7280; font-size: 0.95rem;">আপনার অ্যাকাউন্টে প্রবেশ করতে তথ্য দিন</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">ইমেইল <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="আপনার ইমেইল দিন" value="{{ old('email') }}" required autofocus>
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
                
                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                    <label style="color: #4b5563; display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-right: 8px;"> আমাকে মনে রাখুন
                    </label>
                    <a href="#" style="color: var(--primary-color); text-decoration: none;">পাসওয়ার্ড ভুলে গেছেন?</a>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">লগিন করুন</button>
            </form>
            
            <div class="text-center mt-4" style="font-size: 0.9rem; color: #4b5563;">
                অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">রেজিস্টার করুন</a>
            </div>
        </div>
    </div>
</div>
@endsection
