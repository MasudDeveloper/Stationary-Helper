@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন - সহজ কাজ')

@section('content')
<div class="auth-wrapper">
    <div class="auth-left">
        <div class="text-center" style="color: white; max-width: 400px; display: flex; flex-direction: column; align-items: center;">
            <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 50%; margin-bottom: 30px; border: 1px solid rgba(255,255,255,0.2);">
                <i class="material-icons-round" style="font-size: 4rem; color: #a5b4fc;">person_add</i>
            </div>
            <h1 style="font-size: 3rem; margin-bottom: 20px; font-weight: 800; letter-spacing: -0.02em;">
                <span class="text-white">Smart</span><span class="text-gradient" style="background: linear-gradient(135deg, #a5b4fc, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Station</span>
            </h1>
            <p style="font-size: 1.1rem; line-height: 1.6; color: var(--text-muted);">উন্নত ডিজিটাল টুলস এবং এআই সার্ভিসের স্মার্ট দুনিয়ায় যোগ দিতে অ্যাকাউন্ট তৈরি করুন।</p>
        </div>
    </div>
    
    <div class="auth-right">
        <div class="auth-form-container glass" style="padding: 40px; max-width: 450px;">
            <div class="text-center mb-4">
                <h2 style="color: #fff; font-weight: 700; margin-bottom: 10px;">নতুন অ্যাকাউন্ট</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">নতুন একাউন্ট খুলতে সঠিক তথ্য দিন</p>
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
