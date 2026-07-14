@extends('layouts.admin')

@section('title', 'অ্যাডমিন - পেমেন্ট রিকোয়েস্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 20px;">পেমেন্ট রিকোয়েস্ট সমূহ</h2>

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

    <div class="glass" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 15px;">তারিখ</th>
                    <th style="padding: 15px;">ইউজার</th>
                    <th style="padding: 15px;">টাকার পরিমাণ</th>
                    <th style="padding: 15px;">ক্রেডিট</th>
                    <th style="padding: 15px;">সেন্ডার নম্বর</th>
                    <th style="padding: 15px;">TrxID</th>
                    <th style="padding: 15px;">স্ট্যাটাস</th>
                    <th style="padding: 15px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 15px;">{{ $req->created_at->format('d M, Y h:i A') }}</td>
                    <td style="padding: 15px;">{{ $req->user->name }}<br><small style="color: var(--text-muted)">{{ $req->user->email }}</small></td>
                    <td style="padding: 15px; color: var(--primary-color); font-weight: bold;">৳{{ $req->amount }}</td>
                    <td style="padding: 15px;">{{ $req->credits }}</td>
                    <td style="padding: 15px;">{{ $req->sender_number }}</td>
                    <td style="padding: 15px;">{{ $req->transaction_id }}</td>
                    <td style="padding: 15px;">
                        @if ($req->status == 'pending')
                            <span style="background: #f59e0b; color: #000; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Pending</span>
                        @elseif ($req->status == 'approved')
                            <span style="background: #10b981; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Approved</span>
                        @else
                            <span style="background: #ef4444; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Rejected</span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if ($req->status == 'pending')
                            <div style="display: flex; gap: 10px;">
                                <form action="{{ route('admin.payments.approve', $req->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: #10b981; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Approve</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $req->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: #ef4444; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Reject</button>
                                </form>
                            </div>
                        @else
                            <span style="color: var(--text-muted)">Processed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো পেমেন্ট রিকোয়েস্ট পাওয়া যায়নি।</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
