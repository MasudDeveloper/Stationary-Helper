@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড')

@section('content')
<div style="margin-top: 10px;">
    <div class="glass" style="padding: 40px; margin-bottom: 40px; border-color: rgba(129, 140, 248, 0.2); border-radius: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 style="color: #fff; margin-bottom: 10px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #818cf8; font-size: 2.2rem;">waving_hand</i> স্বাগতম, অ্যাডমিন!
                </h2>
                <p style="color: var(--text-muted); margin-bottom: 30px; font-size: 1.1rem;">সহজ কাজ অ্যাপ্লিকেশনের সার্বিক কার্যক্রমের সংক্ষিপ্ত চিত্র</p>
            </div>
            
            <form action="{{ route('admin.toggle_paid_service') }}" method="POST" style="margin-bottom: 30px;">
                @csrf
                <button type="submit" class="btn {{ $paidServiceStatus === 'off' ? 'btn-danger' : 'btn-primary' }}" style="display: flex; align-items: center; gap: 8px; border-radius: 50px; padding: 10px 20px; font-weight: bold; background: {{ $paidServiceStatus === 'off' ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}; color: {{ $paidServiceStatus === 'off' ? '#f87171' : '#34d399' }}; border: 1px solid {{ $paidServiceStatus === 'off' ? 'rgba(239, 68, 68, 0.4)' : 'rgba(16, 185, 129, 0.4)' }};">
                    <i class="material-icons-round">{{ $paidServiceStatus === 'off' ? 'money_off' : 'attach_money' }}</i>
                    {{ $paidServiceStatus === 'off' ? 'Paid Service OFF' : 'Paid Service ON' }}
                </button>
            </form>
        </div>

        <!-- Stats Grid -->
        <div class="grid-3" style="margin-bottom: 40px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <!-- Total Users -->
            <div class="glass" style="padding: 25px; border-left: 5px solid #818cf8; background: rgba(129, 140, 248, 0.05); border-radius: 16px; transition: transform 0.3s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: #cbd5e1; font-weight: 600; font-size: 1.1rem;">মোট ইউজার</span>
                    <i class="material-icons-round" style="color: #818cf8; font-size: 28px;">group</i>
                </div>
                <h1 style="font-size: 2.8rem; color: #fff; font-weight: 800; margin: 0; line-height: 1;">{{ $totalUsers }}</h1>
            </div>

            <!-- Pending Payments -->
            <div class="glass" style="padding: 25px; border-left: 5px solid #34d399; background: rgba(52, 211, 153, 0.05); border-radius: 16px; transition: transform 0.3s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: #cbd5e1; font-weight: 600; font-size: 1.1rem;">পেন্ডিং পেমেন্ট</span>
                    <i class="material-icons-round" style="color: #34d399; font-size: 28px;">pending_actions</i>
                </div>
                <h1 style="font-size: 2.8rem; color: #34d399; font-weight: 800; margin: 0; line-height: 1;">{{ $pendingPaymentsCount }}</h1>
                <p style="font-size: 0.9rem; color: #6ee7b7; margin-top: 8px; margin-bottom: 0; font-weight: 600;">মোট মূল্য: ৳{{ number_format($pendingPaymentsSum, 2) }}</p>
            </div>

            <!-- Active Tickets -->
            <div class="glass" style="padding: 25px; border-left: 5px solid #f87171; background: rgba(248, 113, 113, 0.05); border-radius: 16px; transition: transform 0.3s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: #cbd5e1; font-weight: 600; font-size: 1.1rem;">খোলা সাপোর্ট টিকেট</span>
                    <i class="material-icons-round" style="color: #f87171; font-size: 28px;">support_agent</i>
                </div>
                <h1 style="font-size: 2.8rem; color: #f87171; font-weight: 800; margin: 0; line-height: 1;">{{ $openTicketsCount }}</h1>
            </div>

            <!-- AI Templates -->
            <div class="glass" style="padding: 25px; border-left: 5px solid #fbbf24; background: rgba(251, 191, 36, 0.05); border-radius: 16px; transition: transform 0.3s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: #cbd5e1; font-weight: 600; font-size: 1.1rem;">মোট এআই টেমপ্লেট</span>
                    <i class="material-icons-round" style="color: #fbbf24; font-size: 28px;">collections</i>
                </div>
                <h1 style="font-size: 2.8rem; color: #fbbf24; font-weight: 800; margin: 0; line-height: 1;">{{ $totalAiTemplates }}</h1>
            </div>

            <!-- Active Local Ads -->
            <div class="glass" style="padding: 25px; border-left: 5px solid #c084fc; background: rgba(192, 132, 252, 0.05); border-radius: 16px; transition: transform 0.3s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="color: #cbd5e1; font-weight: 600; font-size: 1.1rem;">সক্রিয় লোকাল বিজ্ঞাপন</span>
                    <i class="material-icons-round" style="color: #c084fc; font-size: 28px;">campaign</i>
                </div>
                <h1 style="font-size: 2.8rem; color: #c084fc; font-weight: 800; margin: 0; line-height: 1;">{{ $activeAds }}</h1>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid-2" style="gap: 30px;">
            <!-- Recent Users -->
            <div class="glass" style="padding: 30px; border-radius: 16px;">
                <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">সাম্প্রতিক ইউজার রেজিস্টার্ড</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: rgba(255,255,255,0.05);">
                            <tr style="text-align: left;">
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">নাম</th>
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">ইমেইল</th>
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">রোল</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $u)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 15px 12px; color: #fff; font-weight: 600;">{{ $u->name }}</td>
                                <td style="padding: 15px 12px; color: #94a3b8;">{{ $u->email }}</td>
                                <td style="padding: 15px 12px; text-transform: uppercase; font-size: 0.8rem; color: #818cf8; font-weight: 700;">{{ $u->role }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো ইউজার পাওয়া যায়নি।</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="glass" style="padding: 30px; border-radius: 16px;">
                <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">সাম্প্রতিক পেমেন্ট রিকোয়েস্ট</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: rgba(255,255,255,0.05);">
                            <tr style="text-align: left;">
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">ইউজার</th>
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">টাকা</th>
                                <th style="padding: 12px; font-size: 0.85rem; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1);">স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPayments as $p)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 15px 12px; color: #fff; font-weight: 600;">{{ $p->user->name ?? 'Unknown' }}</td>
                                <td style="padding: 15px 12px; color: #e2e8f0; font-weight: 700;">৳{{ number_format($p->amount, 2) }}</td>
                                <td style="padding: 15px 12px;">
                                    @if ($p->status === 'pending')
                                        <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.4);">Pending</span>
                                    @elseif ($p->status === 'approved')
                                        <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.4);">Approved</span>
                                    @else
                                        <span style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.4);">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো পেমেন্ট রিকোয়েস্ট পাওয়া যায়নি।</td>
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
