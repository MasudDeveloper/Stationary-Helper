@extends('layouts.admin')

@section('title', 'অ্যাডমিন - বিজ্ঞাপন ম্যানেজমেন্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: #fff; margin-bottom: 25px; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 15px;">বিজ্ঞাপন ম্যানেজমেন্ট (Google & Local Ads)</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 15px; border-radius: 12px; margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 15px; border-radius: 12px; margin-bottom: 25px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Add Ad Form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content; border-top: 4px solid #c084fc;">
            <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">১. লোকাল বিজ্ঞাপন যোগ করুন</h3>
            
            <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">বিজ্ঞাপনের নাম/শিরোনাম <span style="color: #f87171;">*</span></label>
                    <input type="text" name="title" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" placeholder="যেমন: ঈদ অফার ব্যানার" required>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">ব্যানার ইমেজ <span style="color: #f87171;">*</span></label>
                    <input type="file" name="image" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" accept="image/*" required>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">টার্গেট লিংক (URL)</label>
                    <input type="url" name="target_url" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" placeholder="https://example.com/promo">
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">বিজ্ঞাপন স্লট <span style="color: #f87171;">*</span></label>
                    <select name="slot" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" required>
                        <option value="top" style="background: #1e293b;">টপ ব্যানার (Top Banner)</option>
                        <option value="bottom" style="background: #1e293b;">বটম ব্যানার (Bottom Banner)</option>
                        <option value="sidebar" style="background: #1e293b;">সাইডবার (Sidebar Banner)</option>
                    </select>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 10px; background: linear-gradient(135deg, #c084fc, #818cf8); color: #fff; font-weight: 700; border: none; border-radius: 8px; padding: 12px; box-shadow: 0 4px 15px rgba(192, 132, 252, 0.3);">বিজ্ঞাপন পাবলিশ করুন</button>
            </form>
        </div>

        <!-- Google AdSense Info -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content; border-top: 4px solid #10b981;">
            <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">২. গুগল অ্যাডসেন্স কনফিগারেশন</h3>
            <p style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.6; margin-bottom: 20px;">
                আপনার গুগল অ্যাডসেন্স স্ক্রিপ্টটি লেআউটে যুক্ত করার জন্য নিচে নির্দেশিকা দেওয়া হলো।
            </p>
            <div style="background: rgba(0,0,0,0.3); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); font-family: monospace; font-size: 0.85rem; margin-bottom: 20px; line-height: 1.5; color: #34d399; overflow-x: auto; white-space: nowrap;">
                &lt;!-- Google AdSense Script Placeholder --&gt;<br>
                &lt;script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX" crossorigin="anonymous"&gt;&lt;/script&gt;
            </div>
            <p style="font-size: 0.9rem; color: #94a3b8; line-height: 1.6;">
                আপনার AdSense একাউন্ট অ্যাপ্রুভ হলে কাঙ্ক্ষিত অ্যাড কোডটি <code style="background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; color: #e2e8f0;">resources/views/layouts/app.blade.php</code> ফাইলের হেড ট্যাগে সরাসরি বসিয়ে দিতে পারবেন।
            </p>
        </div>
    </div>

    <!-- Active Local Ads List -->
    <div class="glass" style="margin-top: 40px; padding: 30px; border-radius: 16px;">
        <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">বিদ্যমান লোকাল বিজ্ঞাপনসমূহ</h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: rgba(255,255,255,0.05);">
                    <tr>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ব্যানার</th>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">শিরোনাম</th>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">স্লট (Slot)</th>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">টার্গেট লিংক</th>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">স্ট্যাটাস</th>
                        <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ads as $ad)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">
                            <img src="{{ asset($ad->image_path) }}" alt="Banner" style="max-height: 50px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                        </td>
                        <td style="padding: 15px; color: #fff; font-weight: 700;">{{ $ad->title }}</td>
                        <td style="padding: 15px; text-transform: uppercase; font-size: 0.85rem; color: #94a3b8; font-weight: 600;">{{ $ad->slot }}</td>
                        <td style="padding: 15px;">
                            @if ($ad->target_url)
                                <a href="{{ $ad->target_url }}" target="_blank" style="color: #818cf8; text-decoration: none; font-weight: 600;">লিংক দেখুন ↗</a>
                            @else
                                <span style="color: #64748b;">নেই</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            @if ($ad->is_active)
                                <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.4);">Active</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.4);">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px; display: flex; gap: 10px;">
                            <form action="{{ route('admin.ads.toggle', $ad->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); padding: 6px 12px; font-size: 0.9rem; border-radius: 8px; font-weight: 600;">
                                    {{ $ad->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.ads.delete', $ad->id) }}" method="POST" onsubmit="return confirm('বিজ্ঞাপনটি মুছে ফেলতে চান?');">
                                @csrf
                                <button type="submit" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; cursor: pointer; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;">🪧</div>
                            কোনো লোকাল বিজ্ঞাপন পাওয়া যায়নি।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
