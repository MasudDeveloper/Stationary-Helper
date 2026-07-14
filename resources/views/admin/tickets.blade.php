@extends('layouts.admin')

@section('title', 'অ্যাডমিন - রিকোয়েস্ট ম্যানেজমেন্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px;">সকল সাপোর্ট ও হায়ার রিকোয়েস্ট</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 15px;">তারিখ</th>
                    <th style="padding: 15px;">ইউজার</th>
                    <th style="padding: 15px;">বিষয়</th>
                    <th style="padding: 15px;">ক্যাটাগরি</th>
                    <th style="padding: 15px;">স্ট্যাটাস</th>
                    <th style="padding: 15px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 15px;">{{ $ticket->created_at->format('d M, Y h:i A') }}</td>
                    <td style="padding: 15px;">{{ $ticket->user->name }}<br><small style="color: var(--text-muted)">{{ $ticket->user->email }}</small></td>
                    <td style="padding: 15px; color: var(--text-main); font-weight: bold;">{{ $ticket->title }}</td>
                    <td style="padding: 15px;">
                        @if ($ticket->category == 'hiring')
                            <span style="background: rgba(245, 158, 11, 0.2); color: var(--primary-color); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Hiring</span>
                        @else
                            <span style="background: rgba(59, 130, 246, 0.2); color: #3b82f6; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Help</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if ($ticket->status == 'open')
                            <span style="color: #f59e0b; font-weight: bold;">Open</span>
                        @elseif ($ticket->status == 'in_progress')
                            <span style="color: #3b82f6; font-weight: bold;">In Progress</span>
                        @else
                            <span style="color: #10b981; font-weight: bold;">Closed</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border-color); padding: 6px 12px; font-size: 0.9rem;">ওপেন করুন</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো রিকোয়েস্ট পাওয়া যায়নি।</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
