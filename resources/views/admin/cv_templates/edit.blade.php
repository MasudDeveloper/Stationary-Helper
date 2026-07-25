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
            
            <!-- Complete Admin Instructions Box -->
            <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(148, 163, 184, 0.2); border-left: 4px solid #3b82f6; padding: 15px 20px; border-radius: 8px; margin-bottom: 15px; color: #e2e8f0; font-size: 0.85rem; line-height: 1.6;">
                <h4 style="color: #60a5fa; margin: 0 0 10px 0; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                    <i class="material-icons-round" style="font-size: 1.1rem;">help_outline</i> সিভি টেমপ্লেট ও ছবি (Photo) তৈরির সম্পূর্ণ নির্দেশিকা
                </h4>
                <ul style="margin: 0; padding-left: 20px; color: #cbd5e1;">
                    <li style="margin-bottom: 6px;"><strong>ফিল্ড (Placeholder) তৈরি:</strong> যেকোনো ডায়নামিক তথ্য নেওয়ার জন্য থার্ড ব্র্যাকেট <code>[ ]</code> ব্যবহার করুন। যেমন: <code>[Name]</code>, <code>[Phone]</code>, <code>[Email]</code>, <code>[Career_Objective]</code> ইত্যাদি। সিস্টেম স্বয়ংক্রিয়ভাবে কাস্টমারের জন্য এই ইনপুটগুলো তৈরি করে দেবে।</li>
                    <li style="margin-bottom: 6px;"><strong>ছবি (Photo) যুক্ত করার নিয়ম:</strong> সিভিতে ছবি যোগ করার জন্য এইচটিএমএল কোডে অবশ্যই <strong><code>[Photo]</code></strong> বা <strong><code>[Image]</code></strong> ট্যাগ লিখুন। যেমন:<br>
                    <code style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px; color: #38bdf8; display: inline-block; margin-top: 4px;">&lt;img src="[Photo]" alt="Profile Photo" style="width: 150px; height: 170px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"&gt;</code><br>
                    <em>কোডে <code>[Photo]</code> লিখলে সিস্টেম স্বয়ংক্রিয়ভাবে কাস্টমারকে ছবি আপলোডের বাটন দেখাবে এবং ছবি আপলোড করলে তা লাইভ সিভিতে বসে যাবে!</em></li>
                    <li><strong>পেজ ও ডিজাইন টিপস:</strong> ১ পেজ বা ২ পেজের জন্য কন্টেন্ট ও ফন্ট সাইজ (13px-14px) সামঞ্জস্যপূর্ণ রাখুন। ফ্লেক্সবক্স বা টেবিল দিয়ে লেআউট তৈরি করুন যাতে প্রিন্ট করার সময় কোনো ডিজাইন ভেঙ্গে না যায়।</li>
                </ul>
            </div>

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
