@extends('layouts.admin')

@section('title', 'অ্যাডমিন - পেমেন্ট রিকোয়েস্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: #fff; margin-bottom: 25px; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 15px;">পেমেন্ট রিকোয়েস্ট সমূহ</h2>

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

    <div class="glass" style="overflow-x: auto; border-radius: 16px; padding: 20px; border-top: 4px solid #34d399;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: rgba(255,255,255,0.05);">
                <tr>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">তারিখ</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ইউজার</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">টাকার পরিমাণ</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ক্রেডিট</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">সেন্ডার নম্বর</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">TrxID</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">স্ট্যাটাস</th>
                    <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; color: #94a3b8;">{{ $req->created_at->format('d M, Y h:i A') }}</td>
                    <td style="padding: 15px; color: #e2e8f0;">{{ $req->user->name }}<br><small style="color: #64748b;">{{ $req->user->email }}</small></td>
                    <td style="padding: 15px; color: #34d399; font-weight: 700;">৳{{ $req->amount }}</td>
                    <td style="padding: 15px; color: #e2e8f0; font-weight: 600;">{{ $req->credits }}</td>
                    <td style="padding: 15px; color: #cbd5e1;">{{ $req->sender_number }}</td>
                    <td style="padding: 15px; color: #cbd5e1; font-family: monospace;">{{ $req->transaction_id }}</td>
                    <td style="padding: 15px;">
                        @if ($req->status == 'pending')
                            <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.4);">Pending</span>
                        @elseif ($req->status == 'approved')
                            <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.4);">Approved</span>
                        @else
                            <span style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.4);">Rejected</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if ($req->status == 'pending')
                            <div style="display: flex; gap: 10px;">
                                <form action="{{ route('admin.payments.approve', $req->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 6px 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Approve</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $req->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 6px 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Reject</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #64748b; font-weight: 600;">Processed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: var(--text-muted);">
                        <div style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;">💳</div>
                        কোনো পেমেন্ট রিকোয়েস্ট পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
