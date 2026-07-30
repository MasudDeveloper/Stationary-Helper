@extends('layouts.admin')

@section('title', 'বিজনেস আপগ্রেড রিকোয়েস্ট')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title">বিজনেস আপগ্রেড রিকোয়েস্ট</h2>
        <p class="content-subtitle">ইউজারদের বিজনেস একাউন্টে আপগ্রেড করার রিকোয়েস্টগুলো যাচাই করুন</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" style="margin-bottom: 20px; background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px;">
        {{ session('error') }}
    </div>
@endif

<div class="glass" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>তারিখ</th>
                    <th>ইউজার</th>
                    <th>পেমেন্ট মেথড</th>
                    <th>ট্রানজেকশন আইডি</th>
                    <th>ফি (টাকা)</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->created_at->format('d M, Y h:i A') }}</td>
                    <td>
                        <div style="font-weight: bold; color: #fff;">{{ $req->user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $req->user->email }}</div>
                    </td>
                    <td style="text-transform: capitalize;">{{ $req->payment_method }}</td>
                    <td><span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $req->trx_id }}</span></td>
                    <td>৳{{ number_format($req->amount, 2) }}</td>
                    <td>
                        @if($req->status == 'pending')
                            <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Pending</span>
                        @elseif($req->status == 'approved')
                            <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Approved</span>
                        @else
                            <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($req->status == 'pending')
                        <div style="display: flex; gap: 5px;">
                            <form action="{{ route('admin.business_upgrades.approve', $req->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই রিকোয়েস্টটি Approve করতে চান?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" style="padding: 5px 10px;" title="Approve">
                                    <i class="material-icons-round" style="font-size: 1.2rem;">check_circle</i>
                                </button>
                            </form>
                            <form action="{{ route('admin.business_upgrades.reject', $req->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই রিকোয়েস্টটি Reject করতে চান?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 5px 10px;" title="Reject">
                                    <i class="material-icons-round" style="font-size: 1.2rem;">cancel</i>
                                </button>
                            </form>
                        </div>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">No Action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 30px; color: var(--text-muted);">
                        কোনো রিকোয়েস্ট পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $requests->links() }}
    </div>
</div>
@endsection
