@extends('layouts.app')

@section('title', 'লগিন - penghor.com')

@section('content')
<div class="auth-wrapper">
    <div class="auth-left">
        <div class="text-center" style="color: white; max-width: 400px; display: flex; flex-direction: column; align-items: center;">
            <div style="margin-bottom: 25px;">
                <img src="{{ asset('images/logo.png') }}" alt="penghor.com Logo" style="height: 80px; width: auto; object-fit: contain;">
            </div>
            <h1 style="font-size: 2.8rem; margin-bottom: 20px; font-weight: 800; letter-spacing: -0.02em;">
                <span class="text-white">penghor</span><span class="text-gradient" style="background: linear-gradient(135deg, #a5b4fc, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">.com</span>
            </h1>
            <p style="font-size: 1.1rem; line-height: 1.6; color: var(--text-muted);">উন্নত ডিজিটাল টুলস এবং এআই সার্ভিসের স্মার্ট দুনিয়ায় আপনাকে স্বাগতম।</p>
        </div>
    </div>
    
    <div class="auth-right">
        <div class="auth-form-container glass" style="padding: 40px; max-width: 450px;">
            <div class="text-center mb-4">
                <h2 style="color: #fff; font-weight: 700; margin-bottom: 10px;">স্বাগতম!</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">আপনার অ্যাকাউন্টে প্রবেশ করতে লগিন করুন</p>
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
