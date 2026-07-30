@extends('layouts.app')

@section('title', 'আমার অর্ডারসমূহ - penghor.com')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="color: #fff; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="material-icons-round" style="color: #3b82f6;">assignment</i> আমার অর্ডারসমূহ
            </h2>
            <p style="color: var(--text-muted); margin-top: 5px; margin-bottom: 0;">এডমিন থেকে প্রাপ্ত সকল কাজের তালিকা</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1);">
            <i class="material-icons-round" style="vertical-align: middle;">arrow_back</i> ড্যাশবোর্ডে যান
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="glass" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="table" style="margin: 0; color: #fff;">
                <thead style="background: rgba(255,255,255,0.05);">
                    <tr>
                        <th style="padding: 15px 20px; color: var(--text-muted); border-bottom: 1px solid rgba(255,255,255,0.1);">তারিখ</th>
                        <th style="padding: 15px 20px; color: var(--text-muted); border-bottom: 1px solid rgba(255,255,255,0.1);">কাজের বিবরণ</th>
                        <th style="padding: 15px 20px; color: var(--text-muted); border-bottom: 1px solid rgba(255,255,255,0.1);">অ্যামাউন্ট</th>
                        <th style="padding: 15px 20px; color: var(--text-muted); border-bottom: 1px solid rgba(255,255,255,0.1);">স্ট্যাটাস</th>
                        <th style="padding: 15px 20px; color: var(--text-muted); border-bottom: 1px solid rgba(255,255,255,0.1); text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 20px;">{{ $order->created_at->format('d M, Y h:i A') }}</td>
                        <td style="padding: 20px; max-width: 300px;">
                            <div style="background: rgba(0,0,0,0.2); padding: 10px; border-radius: 6px; font-size: 0.95rem; line-height: 1.5; color: #e2e8f0;">
                                {{ $order->order_details }}
                            </div>
                        </td>
                        <td style="padding: 20px; font-weight: 700; color: #10b981; font-size: 1.1rem;">৳{{ number_format($order->amount, 2) }}</td>
                        <td style="padding: 20px;">
                            @if($order->status == 'pending')
                                <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Pending</span>
                            @elseif($order->status == 'accepted')
                                <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Accepted</span>
                            @elseif($order->status == 'completed')
                                <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Completed</span>
                            @else
                                <span style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Paid</span>
                            @endif
                        </td>
                        <td style="padding: 20px; text-align: right;">
                            @if($order->status == 'pending')
                            <form action="{{ route('shopkeeper.orders.accept', $order->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই অর্ডারটি গ্রহণ করতে চান?');">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; border-radius: 6px;">
                                    <i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">thumb_up</i> Accept
                                </button>
                            </form>
                            @elseif($order->status == 'accepted')
                            <form action="{{ route('shopkeeper.orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('আপনি কি কাজটি সম্পূর্ণ করেছেন?');">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; border-radius: 6px;">
                                    <i class="material-icons-round" style="vertical-align: middle; font-size: 1.2rem;">done_all</i> Mark Complete
                                </button>
                            </form>
                            @else
                            <span style="color: var(--text-muted); font-size: 0.9rem;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 50px; color: var(--text-muted);">
                            <i class="material-icons-round" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">assignment_late</i><br>
                            আপনাকে এখনো কোনো অর্ডার দেওয়া হয়নি।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
