@extends('layouts.admin')

@section('title', 'সিভি টেমপ্লেট এডিট করুন')

@section('content')
<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="color: #fff; margin: 0; font-weight: 700;">এডিট সিভি টেমপ্লেট</h2>
        <p style="color: var(--text-muted); margin: 5px 0 0 0; font-size: 0.9rem;">টেমপ্লেটের তথ্য পরিবর্তন করুন</p>
    </div>
    <a href="{{ route('admin.cv-templates.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <i class="material-icons-round" style="font-size: 1.2rem;">arrow_back</i> ফিরে যান
    </a>
</div>

<div class="glass" style="padding: 30px;">
    <form action="{{ route('admin.cv-templates.update', $cvTemplate->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid-2" style="gap: 20px;">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">টেমপ্লেটের নাম <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" value="{{ $cvTemplate->name }}" required class="form-control" placeholder="যেমন: Professional CV 1" style="width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">ভাষা <span style="color: #ef4444;">*</span></label>
                <select name="language" required class="form-control" style="width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    <option value="en" {{ $cvTemplate->language == 'en' ? 'selected' : '' }}>English</option>
                    <option value="bn" {{ $cvTemplate->language == 'bn' ? 'selected' : '' }}>Bangla</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">ফরম্যাট / পেজ</label>
                <select name="format" class="form-control" style="width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    <option value="1-Page" {{ $cvTemplate->format == '1-Page' ? 'selected' : '' }}>1 Page</option>
                    <option value="2-Page" {{ $cvTemplate->format == '2-Page' ? 'selected' : '' }}>2 Pages</option>
                    <option value="Normal" {{ $cvTemplate->format == 'Normal' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">ডিজাইন নাম</label>
                <input type="text" name="design_name" value="{{ $cvTemplate->design_name }}" class="form-control" placeholder="যেমন: Modern, Classic" style="width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">ক্রেডিট খরচ <span style="color: #ef4444;">*</span></label>
                <input type="number" name="credit_cost" value="{{ $cvTemplate->credit_cost }}" min="0" required class="form-control" style="width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">স্ট্যাটাস</label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; color: #fff;">
                    <input type="checkbox" name="is_active" value="1" {{ $cvTemplate->is_active ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--primary-color);">
                    সক্রিয় (Active)
                </label>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">টেমপ্লেট কন্টেন্ট (HTML) <span style="color: #ef4444;">*</span></label>
            <p style="font-size: 0.8rem; color: #818cf8; margin-top: 0; margin-bottom: 10px;">ফিল্ড যোগ করতে স্কয়ার ব্র্যাকেট ব্যবহার করুন, যেমন: [Name], [Phone], [Email]</p>
            <textarea name="content" required class="form-control" rows="15" style="width: 100%; padding: 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-family: monospace;">{{ $cvTemplate->content }}</textarea>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn" style="background: var(--primary-color); color: #fff; padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                আপডেট করুন
            </button>
        </div>
    </form>
</div>
@endsection
