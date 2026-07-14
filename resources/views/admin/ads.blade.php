@extends('layouts.admin')

@section('title', 'অ্যাডমিন - বিজ্ঞাপন ম্যানেজমেন্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px;">বিজ্ঞাপন ম্যানেজমেন্ট (Google & Local Ads)</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Add Ad Form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">১. লোকাল বিজ্ঞাপন যোগ করুন</h3>
            
            <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">বিজ্ঞাপনের নাম/শিরোনাম <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="যেমন: ঈদ অফার ব্যানার" required>
                </div>
                <div class="form-group">
                    <label class="form-label">ব্যানার ইমেজ <span style="color:red">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label class="form-label">টার্গেট লিংক (URL)</label>
                    <input type="url" name="target_url" class="form-control" placeholder="https://example.com/promo">
                </div>
                <div class="form-group">
                    <label class="form-label">বিজ্ঞাপন স্লট <span style="color:red">*</span></label>
                    <select name="slot" class="form-control" required>
                        <option value="top">টপ ব্যানার (Top Banner)</option>
                        <option value="bottom">বটম ব্যানার (Bottom Banner)</option>
                        <option value="sidebar">সাইডবার (Sidebar Banner)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">বিজ্ঞাপন পাবলিশ করুন</button>
            </form>
        </div>

        <!-- Google AdSense Info -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">২. গুগল অ্যাডসেন্স কনফিগারেশন</h3>
            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px;">
                আপনার গুগল অ্যাডসেন্স স্ক্রিপ্টটি লেআউটে যুক্ত করার জন্য নিচে নির্দেশিকা দেওয়া হলো।
            </p>
            <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 8px; border: 1px solid var(--border-color); font-family: monospace; font-size: 0.85rem; margin-bottom: 20px; line-height: 1.4; color: #10b981;">
                &lt;!-- Google AdSense Script Placeholder --&gt;<br>
                &lt;script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX" crossorigin="anonymous"&gt;&lt;/script&gt;
            </div>
            <p style="font-size: 0.9rem; color: var(--text-muted);">
                আপনার AdSense একাউন্ট অ্যাপ্রুভ হলে কাঙ্ক্ষিত অ্যাড কোডটি `resources/views/layouts/app.blade.php` ফাইলের হেড ট্যাগে সরাসরি বসিয়ে দিতে পারবেন।
            </p>
        </div>
    </div>

    <!-- Active Local Ads List -->
    <div class="glass" style="margin-top: 40px; padding: 30px;">
        <h3 style="margin-bottom: 20px;">বিদ্যমান লোকাল বিজ্ঞাপনসমূহ</h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th style="padding: 15px;">ব্যানার</th>
                        <th style="padding: 15px;">শিরোনাম</th>
                        <th style="padding: 15px;">স্লট (Slot)</th>
                        <th style="padding: 15px;">টার্গেট লিংক</th>
                        <th style="padding: 15px;">স্ট্যাটাস</th>
                        <th style="padding: 15px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ads as $ad)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 15px;">
                            <img src="{{ asset($ad->image_path) }}" alt="Banner" style="max-height: 50px; border-radius: 4px; border: 1px solid var(--border-color);">
                        </td>
                        <td style="padding: 15px; color: var(--text-main); font-weight: bold;">{{ $ad->title }}</td>
                        <td style="padding: 15px; text-transform: uppercase; font-size: 0.85rem;">{{ $ad->slot }}</td>
                        <td style="padding: 15px;">
                            @if ($ad->target_url)
                                <a href="{{ $ad->target_url }}" target="_blank" style="color: var(--primary-color); text-decoration: none;">লিংক দেখুন ↗</a>
                            @else
                                <span style="color: var(--text-muted);">নেই</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            @if ($ad->is_active)
                                <span style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Active</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px; display: flex; gap: 10px;">
                            <form action="{{ route('admin.ads.toggle', $ad->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border-color); padding: 6px 12px; font-size: 0.9rem;">
                                    {{ $ad->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.ads.delete', $ad->id) }}" method="POST" onsubmit="return confirm('বিজ্ঞাপনটি মুছে ফেলতে চান?');">
                                @csrf
                                <button type="submit" style="background: transparent; border: none; color: #ef4444; cursor: pointer; padding-top: 8px;">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো লোকাল বিজ্ঞাপন পাওয়া যায়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
