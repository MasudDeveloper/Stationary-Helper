@extends('layouts.admin')

@section('title', 'সিভি টেমপ্লেট ম্যানেজমেন্ট')

@section('content')
<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="color: #fff; margin: 0; font-weight: 700;">সিভি টেমপ্লেট ম্যানেজমেন্ট</h2>
        <p style="color: var(--text-muted); margin: 5px 0 0 0; font-size: 0.9rem;">সকল সিভি টেমপ্লেট দেখুন এবং পরিচালনা করুন</p>
    </div>
    <a href="{{ route('admin.cv-templates.create') }}" class="btn" style="background: var(--primary-color); color: #fff; border-radius: 8px; padding: 10px 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <i class="material-icons-round" style="font-size: 1.2rem;">add</i> নতুন টেমপ্লেট
    </a>
</div>

@if(session('success'))
    <div class="alert" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; color: #10b981; padding: 15px; margin-bottom: 25px; border-radius: 0 8px 8px 0;">
        {{ session('success') }}
    </div>
@endif

<div class="glass" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">নাম</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">ভাষা ও ফরম্যাট</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">ডিজাইন</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">ক্রেডিট</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">স্ট্যাটাস</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px 20px; color: #fff; font-weight: 500;">
                            {{ $template->name }}
                        </td>
                        <td style="padding: 15px 20px;">
                            <span style="background: rgba(99, 102, 241, 0.15); color: #818cf8; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem;">{{ strtoupper($template->language) }}</span>
                            <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; margin-left: 5px;">{{ $template->format ?? 'N/A' }}</span>
                        </td>
                        <td style="padding: 15px 20px; color: var(--text-muted); font-size: 0.9rem;">
                            {{ $template->design_name ?? 'Default' }}
                        </td>
                        <td style="padding: 15px 20px; color: #fff; font-weight: 600;">
                            {{ $template->credit_cost }}
                        </td>
                        <td style="padding: 15px 20px;">
                            @if($template->is_active)
                                <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Active</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                <a href="{{ route('admin.cv-templates.edit', $template->id) }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem;">এডিট</a>
                                <form action="{{ route('admin.cv-templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; cursor: pointer;">ডিলিট</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো সিভি টেমপ্লেট পাওয়া যায়নি।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
