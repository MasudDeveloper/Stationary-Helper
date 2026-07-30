@extends('layouts.admin')

@section('title', 'অর্ডার ম্যানেজমেন্ট')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title">অর্ডার ম্যানেজমেন্ট</h2>
        <p class="content-subtitle">শপকিপারদের কাজ দিন এবং পেমেন্ট ট্র্যাক করুন</p>
    </div>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
        <i class="material-icons-round">add</i> নতুন অর্ডার
    </a>
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
                    <th>অর্ডার আইডি</th>
                    <th>শপকিপার</th>
                    <th>কাজের বিবরণ</th>
                    <th>অ্যামাউন্ট</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}<br><small style="color: var(--text-muted);">{{ $order->created_at->format('d M, Y') }}</small></td>
                    <td>
                        <div style="font-weight: bold; color: #fff;">{{ $order->shopkeeper->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">ID: {{ $order->shopkeeper->account_id }}</div>
                    </td>
                    <td style="max-width: 250px;">{{ Str::limit($order->order_details, 50) }}</td>
                    <td>৳{{ number_format($order->amount, 2) }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Pending</span>
                        @elseif($order->status == 'accepted')
                            <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Accepted</span>
                        @elseif($order->status == 'completed')
                            <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Completed</span>
                        @else
                            <span style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Paid</span>
                        @endif
                    </td>
                    <td>
                        @if($order->status == 'completed')
                        <form action="{{ route('admin.orders.paid', $order->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই অর্ডারটির পেমেন্ট সম্পন্ন হয়েছে?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" style="padding: 5px 10px;" title="Mark as Paid">
                                <i class="material-icons-round" style="font-size: 1.2rem;">payments</i> Paid
                            </button>
                        </form>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px; color: var(--text-muted);">
                        কোনো অর্ডার পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
