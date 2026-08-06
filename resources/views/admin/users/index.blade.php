@extends('layouts.admin')

@section('title', 'ইউজার লিস্ট')

@section('content')
<div class="content-header" style="margin-bottom: 25px;">
    <div>
        <h2 style="color: #fff; margin: 0; font-weight: 700;">সকল ইউজার</h2>
        <p style="color: var(--text-muted); margin: 5px 0 0 0; font-size: 0.9rem;">সিস্টেমের সকল ইউজারের তালিকা ও বিস্তারিত তথ্য</p>
    </div>
</div>

<div class="glass" style="padding: 30px; border-radius: 16px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: rgba(255,255,255,0.05);">
                <tr style="text-align: left;">
                    <th style="padding: 15px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">নাম / মোবাইল</th>
                    <th style="padding: 15px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">ইমেইল</th>
                    <th style="padding: 15px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">অ্যাকাউন্ট আইডি</th>
                    <th style="padding: 15px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">ব্যালেন্স / ক্রেডিট</th>
                    <th style="padding: 15px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">যোগদানের তারিখ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; color: #fff; font-weight: 600;">
                        {{ $user->name }}
                    </td>
                    <td style="padding: 15px; color: #94a3b8;">
                        {{ $user->email }}
                    </td>
                    <td style="padding: 15px; color: #818cf8; font-family: monospace; font-weight: bold; font-size: 0.95rem;">
                        {{ $user->account_id ?? 'N/A' }}
                    </td>
                    <td style="padding: 15px; color: #34d399; font-weight: 700;">
                        ৳ {{ number_format($user->credits, 2) }}
                    </td>
                    <td style="padding: 15px; color: #94a3b8; font-size: 0.85rem;">
                        {{ $user->created_at->format('d M Y, h:i A') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-muted); font-size: 1.1rem;">কোনো ইউজার পাওয়া যায়নি।</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div style="margin-top: 25px;">
        {{ $users->links() }}
    </div>
    @endif
</div>

<style>
    /* Pagination style override for dark theme */
    .pagination { display: flex; list-style: none; padding: 0; gap: 5px; justify-content: center; }
    .pagination li a, .pagination li span { padding: 8px 12px; background: rgba(255,255,255,0.05); color: #cbd5e1; border-radius: 6px; text-decoration: none; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s; }
    .pagination li.active span { background: var(--primary-color); color: #fff; border-color: var(--primary-color); }
    .pagination li a:hover { background: rgba(255,255,255,0.1); color: #fff; }
</style>
@endsection
