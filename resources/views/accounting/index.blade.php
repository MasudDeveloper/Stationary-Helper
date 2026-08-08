@extends('layouts.app')

@section('title', 'হিসাব-নিকাশ - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <div>
            <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 12px; margin-bottom: 8px;">অ্যাকাউন্টিং মডিউল</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">আপনার আয়-ব্যয়, ক্যাশ ও বাকির হিসাব রাখুন</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div style="display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; overflow-x: auto;">
        <a href="{{ route('accounting.index') }}" class="btn" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">account_balance_wallet</i> আয়-ব্যয়
        </a>
        <a href="{{ route('accounting.calculator') }}" class="btn" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px; font-weight: 500; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">calculate</i> ক্যাশ ক্যালকুলেটর
        </a>
        <a href="{{ route('accounting.dues') }}" class="btn" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px; font-weight: 500; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">menu_book</i> বাকির খাতা
        </a>
    </div>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .tx-row {
            border-bottom: 1px solid rgba(255,255,255,0.05); 
            transition: background 0.2s;
        }
        .tx-row:hover {
            background: rgba(255,255,255,0.02) !important;
        }
        .btn-delete {
            background: rgba(239, 68, 68, 0.1); 
            border: 1px solid rgba(239, 68, 68, 0.2); 
            color: #f87171; 
            cursor: pointer; 
            font-size: 0.85rem; 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-weight: 500; 
            transition: all 0.2s;
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2) !important;
        }
    </style>

    <!-- Summary Widgets -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; border-radius: 15px; border-top: 4px solid #10b981; position: relative;">
            <div style="position: absolute; right: 20px; top: 20px; color: rgba(16, 185, 129, 0.2);">
                <i class="material-icons-round" style="font-size: 3rem;">trending_up</i>
            </div>
            <h4 style="color: var(--text-muted); margin-bottom: 10px; font-weight: 600;">মোট আয়</h4>
            <h1 style="color: #10b981; font-weight: 800; font-size: 2.2rem; margin: 0;">৳{{ number_format($income, 2) }}</h1>
        </div>
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; border-radius: 15px; border-top: 4px solid #ef4444; position: relative;">
            <div style="position: absolute; right: 20px; top: 20px; color: rgba(239, 68, 68, 0.2);">
                <i class="material-icons-round" style="font-size: 3rem;">trending_down</i>
            </div>
            <h4 style="color: var(--text-muted); margin-bottom: 10px; font-weight: 600;">মোট ব্যয়</h4>
            <h1 style="color: #ef4444; font-weight: 800; font-size: 2.2rem; margin: 0;">৳{{ number_format($expense, 2) }}</h1>
        </div>
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; border-radius: 15px; border-top: 4px solid #3b82f6; position: relative;">
            <div style="position: absolute; right: 20px; top: 20px; color: rgba(59, 130, 246, 0.2);">
                <i class="material-icons-round" style="font-size: 3rem;">account_balance</i>
            </div>
            <h4 style="color: var(--text-muted); margin-bottom: 10px; font-weight: 600;">বর্তমান ব্যালেন্স</h4>
            <h1 style="color: #3b82f6; font-weight: 800; font-size: 2.2rem; margin: 0;">৳{{ number_format($balance, 2) }}</h1>
        </div>
    </div>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Add transaction form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; border-radius: 15px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: #fff; font-weight: 700;">নতুন এন্ট্রি যোগ করুন</h3>
            <form action="{{ route('accounting.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">হিসাবের ধরন <span style="color:red">*</span></label>
                    <select name="type" class="form-control" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);" required>
                        <option value="income" style="color: #000;">আয় (Income)</option>
                        <option value="expense" style="color: #000;">ব্যয় (Expense)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">টাকার পরিমাণ <span style="color:red">*</span></label>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);" required>
                </div>
                <div class="form-group">
                    <label class="form-label">বিবরণ / খাত <span style="color:red">*</span></label>
                    <input type="text" name="description" class="form-control" placeholder="যেমন: পণ্য বিক্রয়, বিদ্যুৎ বিল" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1);" required>
                </div>
                <div class="form-group">
                    <label class="form-label">তারিখ <span style="color:red">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); color-scheme: dark;" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #6366f1, #06b6d4);">সংরক্ষণ করুন</button>
            </form>
        </div>

        <!-- Transactions history -->
        <div class="glass" style="flex: 2; min-width: 450px; padding: 0; border-radius: 15px; overflow: hidden;">
            <div style="padding: 25px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <h3 style="margin: 0; color: #fff; font-weight: 700;">সাম্প্রতিক লেনদেনসমূহ</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead style="background: rgba(255,255,255,0.03);">
                        <tr>
                            <th style="padding: 15px 25px; color: var(--text-muted); font-weight: 500;">তারিখ</th>
                            <th style="padding: 15px 25px; color: var(--text-muted); font-weight: 500;">বিবরণ</th>
                            <th style="padding: 15px 25px; color: var(--text-muted); font-weight: 500;">ধরন</th>
                            <th style="padding: 15px 25px; color: var(--text-muted); font-weight: 500;">পরিমাণ</th>
                            <th style="padding: 15px 25px; color: var(--text-muted); font-weight: 500; text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                        <tr class="tx-row">
                            <td style="padding: 15px 25px; color: var(--text-muted);">{{ date('d M, Y', strtotime($tx->date)) }}</td>
                            <td style="padding: 15px 25px; color: #fff; font-weight: 500;">{{ $tx->description }}</td>
                            <td style="padding: 15px 25px;">
                                @if ($tx->type == 'income')
                                    <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">আয়</span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">ব্যয়</span>
                                @endif
                            </td>
                            <td style="padding: 15px 25px; font-weight: 700; font-size: 1.1rem; @if($tx->type == 'income') color: #10b981; @else color: #ef4444; @endif">
                                @if($tx->type == 'income') + @else - @endif৳{{ number_format($tx->amount, 2) }}
                            </td>
                            <td style="padding: 15px 25px; text-align: right;">
                                <form action="{{ route('accounting.transaction.delete', $tx->id) }}" method="POST" onsubmit="return confirm('মুছে ফেলার জন্য নিশ্চিত?');">
                                    @csrf
                                    <button type="submit" class="btn-delete">মুছুন</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-muted);">কোনো লেনদেন রেকর্ড পাওয়া যায়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
