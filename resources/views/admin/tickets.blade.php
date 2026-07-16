@extends('layouts.admin')

@section('title', 'অ্যাডমিন - রিকোয়েস্ট ম্যানেজমেন্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: #fff; margin-bottom: 25px; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 15px;">সকল সাপোর্ট ও হায়ার রিকোয়েস্ট</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 15px; border-radius: 12px; margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="overflow-x: auto; border-radius: 16px; padding: 20px; border-top: 4px solid #818cf8;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: rgba(255,255,255,0.05);">
                <tr>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">তারিখ</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ইউজার</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">বিষয়</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ক্যাটাগরি</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">স্ট্যাটাস</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; color: #94a3b8;">{{ $ticket->created_at->format('d M, Y h:i A') }}</td>
                    <td style="padding: 15px; color: #e2e8f0;">{{ $ticket->user->name }}<br><small style="color: #64748b;">{{ $ticket->user->email }}</small></td>
                    <td style="padding: 15px; color: #fff; font-weight: 700;">{{ $ticket->title }}</td>
                    <td style="padding: 15px;">
                        @if ($ticket->category == 'hiring')
                            <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.4);">Hiring</span>
                        @else
                            <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(59, 130, 246, 0.4);">Help</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if ($ticket->status == 'open')
                            <span style="color: #fbbf24; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #fbbf24;"></div> Open</span>
                        @elseif ($ticket->status == 'in_progress')
                            <span style="color: #60a5fa; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #60a5fa;"></div> In Progress</span>
                        @else
                            <span style="color: #34d399; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #34d399;"></div> Closed</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 6px 15px; font-size: 0.9rem; border-radius: 8px; font-weight: 600;">ওপেন করুন</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                        <div style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;">📭</div>
                        কোনো রিকোয়েস্ট পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
