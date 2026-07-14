@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড')

@section('content')
<div style="margin-top: 10px;">
    <div class="glass" style="padding: 40px; margin-bottom: 40px; border-color: rgba(59, 130, 246, 0.2);">
        <h2 style="color: var(--primary-color); margin-bottom: 10px; font-weight: 800;">স্বাগতম, অ্যাডমিন!</h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">সহজ কাজ অ্যাপ্লিকেশনের সার্বিক কার্যক্রমের সংক্ষিপ্ত চিত্র</p>

        <!-- Stats Grid -->
        <div class="grid-3" style="margin-bottom: 40px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
            <!-- Total Users -->
            <div class="glass" style="padding: 20px; border-left: 5px solid var(--primary-color); background: rgba(59, 130, 246, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: var(--text-muted); font-weight: 600;">মোট ইউজার</span>
                    <i class="material-icons-round" style="color: var(--primary-color);">group</i>
                </div>
                <h1 style="font-size: 2.2rem; color: var(--text-main); font-weight: 800; margin: 0;">{{ $totalUsers }}</h1>
            </div>

            <!-- Pending Payments -->
            <div class="glass" style="padding: 20px; border-left: 5px solid #10b981; background: rgba(16, 185, 129, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: var(--text-muted); font-weight: 600;">পেন্ডিং পেমেন্ট</span>
                    <i class="material-icons-round" style="color: #10b981;">pending_actions</i>
                </div>
                <h1 style="font-size: 2.2rem; color: #10b981; font-weight: 800; margin: 0;">{{ $pendingPaymentsCount }}</h1>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px; margin-bottom: 0;">মোট মূল্য: ৳{{ number_format($pendingPaymentsSum, 2) }}</p>
            </div>

            <!-- Active Tickets -->
            <div class="glass" style="padding: 20px; border-left: 5px solid #ef4444; background: rgba(239, 68, 68, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: var(--text-muted); font-weight: 600;">খোলা সাপোর্ট টিকেট</span>
                    <i class="material-icons-round" style="color: #ef4444;">support_agent</i>
                </div>
                <h1 style="font-size: 2.2rem; color: #ef4444; font-weight: 800; margin: 0;">{{ $openTicketsCount }}</h1>
            </div>

            <!-- AI Templates -->
            <div class="glass" style="padding: 20px; border-left: 5px solid #f59e0b; background: rgba(245, 158, 11, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: var(--text-muted); font-weight: 600;">মোট এআই টেমপ্লেট</span>
                    <i class="material-icons-round" style="color: #f59e0b;">collections</i>
                </div>
                <h1 style="font-size: 2.2rem; color: #f59e0b; font-weight: 800; margin: 0;">{{ $totalAiTemplates }}</h1>
            </div>

            <!-- Active Local Ads -->
            <div class="glass" style="padding: 20px; border-left: 5px solid #8b5cf6; background: rgba(139, 92, 246, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: var(--text-muted); font-weight: 600;">সক্রিয় লোকাল বিজ্ঞাপন</span>
                    <i class="material-icons-round" style="color: #8b5cf6;">campaign</i>
                </div>
                <h1 style="font-size: 2.2rem; color: #8b5cf6; font-weight: 800; margin: 0;">{{ $activeAds }}</h1>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid-2">
            <!-- Recent Users -->
            <div class="glass" style="padding: 25px;">
                <h3 style="margin-bottom: 20px; color: var(--text-main); font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">সাম্প্রতিক ইউজার রেজিস্টার্ড</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                                <th style="padding: 10px; font-size: 0.8rem;">নাম</th>
                                <th style="padding: 10px; font-size: 0.8rem;">ইমেইল</th>
                                <th style="padding: 10px; font-size: 0.8rem;">রোল</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $u)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 12px 10px; color: var(--text-main); font-weight: bold;">{{ $u->name }}</td>
                                <td style="padding: 12px 10px;">{{ $u->email }}</td>
                                <td style="padding: 12px 10px; text-transform: uppercase; font-size: 0.8rem; color: var(--primary-color);">{{ $u->role }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding: 20px; text-align: center; color: var(--text-muted);">কোনো ইউজার পাওয়া যায়নি।</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="glass" style="padding: 25px;">
                <h3 style="margin-bottom: 20px; color: var(--text-main); font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">সাম্প্রতিক পেমেন্ট রিকোয়েস্ট</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                                <th style="padding: 10px; font-size: 0.8rem;">ইউজার</th>
                                <th style="padding: 10px; font-size: 0.8rem;">টাকা</th>
                                <th style="padding: 10px; font-size: 0.8rem;">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPayments as $p)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 12px 10px; color: var(--text-main); font-weight: bold;">{{ $p->user->name ?? 'Unknown' }}</td>
                                <td style="padding: 12px 10px;">৳{{ number_format($p->amount, 2) }}</td>
                                <td style="padding: 12px 10px;">
                                    @if ($p->status === 'pending')
                                        <span style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">Pending</span>
                                    @elseif ($p->status === 'approved')
                                        <span style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">Approved</span>
                                    @else
                                        <span style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding: 20px; text-align: center; color: var(--text-muted);">কোনো পেমেন্ট রিকোয়েস্ট পাওয়া যায়নি।</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
