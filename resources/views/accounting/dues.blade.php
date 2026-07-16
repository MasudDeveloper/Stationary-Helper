@extends('layouts.app')

@section('title', 'বাকির খাতা - সহজ কাজ')

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
        <a href="{{ route('accounting.index') }}" class="btn" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px; font-weight: 500; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">account_balance_wallet</i> আয়-ব্যয়
        </a>
        <a href="{{ route('accounting.calculator') }}" class="btn" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px; font-weight: 500; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">calculate</i> ক্যাশ ক্যালকুলেটর
        </a>
        <a href="{{ route('accounting.dues') }}" class="btn" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">
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
        .btn-action {
            cursor: pointer; 
            font-size: 0.85rem; 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-weight: 500; 
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-paid {
            background: rgba(16, 185, 129, 0.1); 
            border: 1px solid rgba(16, 185, 129, 0.2); 
            color: #10b981; 
        }
        .btn-paid:hover {
            background: rgba(16, 185, 129, 0.2);
        }
        .btn-delete {
            background: rgba(239, 68, 68, 0.1); 
            border: 1px solid rgba(239, 68, 68, 0.2); 
            color: #f87171; 
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
        }
        .status-paid {
            text-decoration: line-through;
            opacity: 0.6;
        }
    </style>

    <!-- Summary Widgets -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; border-radius: 15px; border-top: 4px solid #10b981; position: relative;">
            <div style="position: absolute; right: 20px; top: 20px; color: rgba(16, 185, 129, 0.2);">
                <i class="material-icons-round" style="font-size: 3rem;">arrow_downward</i>
            </div>
            <h4 style="color: var(--text-muted); margin-bottom: 10px; font-weight: 600;">মোট পাবো (Receivable)</h4>
            <h1 style="color: #10b981; font-weight: 800; font-size: 2.2rem; margin: 0;">৳{{ number_format($receivable, 2) }}</h1>
        </div>
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; border-radius: 15px; border-top: 4px solid #ef4444; position: relative;">
            <div style="position: absolute; right: 20px; top: 20px; color: rgba(239, 68, 68, 0.2);">
                <i class="material-icons-round" style="font-size: 3rem;">arrow_upward</i>
            </div>
            <h4 style="color: var(--text-muted); margin-bottom: 10px; font-weight: 600;">মোট দিবো (Payable)</h4>
            <h1 style="color: #ef4444; font-weight: 800; font-size: 2.2rem; margin: 0;">৳{{ number_format($payable, 2) }}</h1>
        </div>
    </div>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        
        <!-- Add Due Form -->
        <div class="glass" style="flex: 1; min-width: 300px; padding: 25px; border-radius: 15px; height: fit-content;">
            <h3 style="color: #fff; margin-bottom: 20px; font-size: 1.2rem; font-weight: 600;">নতুন হিসাব যোগ করুন</h3>
            
            <form action="{{ route('accounting.dues.store') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; display: block;">কার সাথে লেনদেন?</label>
                    <input type="text" name="person_name" class="form-control" placeholder="নাম লিখুন" required style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; display: block;">ধরন</label>
                    <select name="type" class="form-control" required style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
                        <option value="receivable" style="color: #000;">আমি পাবো (Receivable)</option>
                        <option value="payable" style="color: #000;">আমি দিবো (Payable)</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; display: block;">পরিমাণ (টাকা)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; display: block;">উদ্দেশ্য / বিবরণ</label>
                    <input type="text" name="purpose" class="form-control" placeholder="কী বাবদ?" style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; display: block;">তারিখ</label>
                    <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
                </div>
                
                <button type="submit" class="btn w-100" style="background: #3b82f6; color: white; padding: 12px; border-radius: 6px; font-weight: 600; border: none; width: 100%;">
                    যুক্ত করুন
                </button>
            </form>
        </div>

        <!-- Dues List -->
        <div class="glass" style="flex: 2; min-width: 400px; padding: 25px; border-radius: 15px;">
            <h3 style="color: #fff; margin-bottom: 20px; font-size: 1.2rem; font-weight: 600;">বাকির তালিকা</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; color: #fff;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); color: var(--text-muted); font-size: 0.9rem;">
                            <th style="padding: 12px 10px; text-align: left;">তারিখ</th>
                            <th style="padding: 12px 10px; text-align: left;">নাম</th>
                            <th style="padding: 12px 10px; text-align: left;">উদ্দেশ্য</th>
                            <th style="padding: 12px 10px; text-align: right;">পরিমাণ</th>
                            <th style="padding: 12px 10px; text-align: center;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dues as $due)
                            <tr class="tx-row {{ $due->is_paid ? 'status-paid' : '' }}">
                                <td style="padding: 15px 10px; font-size: 0.9rem;">
                                    {{ $due->due_date ? \Carbon\Carbon::parse($due->due_date)->format('d M, Y') : '-' }}
                                </td>
                                <td style="padding: 15px 10px; font-weight: 500;">
                                    {{ $due->person_name }}
                                </td>
                                <td style="padding: 15px 10px; font-size: 0.9rem; color: var(--text-muted);">
                                    {{ $due->purpose ?? '-' }}
                                </td>
                                <td style="padding: 15px 10px; text-align: right; font-weight: 700; color: {{ $due->type == 'receivable' ? '#10b981' : '#ef4444' }};">
                                    {{ $due->type == 'receivable' ? '+' : '-' }} ৳{{ number_format($due->amount, 2) }}
                                </td>
                                <td style="padding: 15px 10px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        @if(!$due->is_paid)
                                            <form action="{{ route('accounting.dues.mark_paid', $due->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn-action btn-paid" title="পরিশোধিত করুন">
                                                    <i class="material-icons-round" style="font-size: 1rem;">check_circle</i>
                                                </button>
                                            </form>
                                        @else
                                            <span style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Paid</span>
                                        @endif

                                        <form action="{{ route('accounting.dues.delete', $due->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('আপনি কি নিশ্চিত যে এটি মুছে ফেলতে চান?');">
                                            @csrf
                                            <button type="submit" class="btn-action btn-delete" title="মুছে ফেলুন">
                                                <i class="material-icons-round" style="font-size: 1rem;">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                    <i class="material-icons-round" style="font-size: 3rem; margin-bottom: 10px; opacity: 0.5;">menu_book</i><br>
                                    কোনো বাকির হিসাব পাওয়া যায়নি
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
