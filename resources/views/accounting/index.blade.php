@extends('layouts.app')

@section('title', 'হিসাব-নিকাশ - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px;">আয়-ব্যয়ের হিসাব ও বুককিপিং</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Summary Widgets -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; text-align: center; border-left: 5px solid #10b981;">
            <h4 style="color: var(--text-muted); margin-bottom: 10px;">মোট আয়</h4>
            <h1 style="color: #10b981;">৳{{ number_format($income, 2) }}</h1>
        </div>
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; text-align: center; border-left: 5px solid #ef4444;">
            <h4 style="color: var(--text-muted); margin-bottom: 10px;">মোট ব্যয়</h4>
            <h1 style="color: #ef4444;">৳{{ number_format($expense, 2) }}</h1>
        </div>
        <div class="glass" style="flex: 1; min-width: 250px; padding: 25px; text-align: center; border-left: 5px solid var(--primary-color);">
            <h4 style="color: var(--text-muted); margin-bottom: 10px;">বর্তমান ব্যালেন্স</h4>
            <h1 style="color: var(--primary-color);">৳{{ number_format($balance, 2) }}</h1>
        </div>
    </div>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Add transaction form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">নতুন এন্ট্রি যোগ করুন</h3>
            <form action="{{ route('accounting.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">হিসাবের ধরন <span style="color:red">*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="income">আয় (Income)</option>
                        <option value="expense">ব্যয় (Expense)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">টাকার পরিমাণ <span style="color:red">*</span></label>
                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">বিবরণ / খাত <span style="color:red">*</span></label>
                    <input type="text" name="description" class="form-control" placeholder="যেমন: পণ্য বিক্রয়, বিদ্যুৎ বিল" required>
                </div>
                <div class="form-group">
                    <label class="form-label">তারিখ <span style="color:red">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">সংরক্ষণ করুন</button>
            </form>
        </div>

        <!-- Transactions history -->
        <div class="glass" style="flex: 2; min-width: 450px; padding: 30px;">
            <h3 style="margin-bottom: 20px;">সাম্প্রতিক লেনদেনসমূহ</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 15px;">তারিখ</th>
                            <th style="padding: 15px;">বিবরণ</th>
                            <th style="padding: 15px;">ধরন</th>
                            <th style="padding: 15px;">পরিমাণ</th>
                            <th style="padding: 15px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px;">{{ date('d M, Y', strtotime($tx->date)) }}</td>
                            <td style="padding: 15px; color: var(--text-main);">{{ $tx->description }}</td>
                            <td style="padding: 15px;">
                                @if ($tx->type == 'income')
                                    <span style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">আয়</span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">ব্যয়</span>
                                @endif
                            </td>
                            <td style="padding: 15px; font-weight: bold; color: {{ $tx->type == 'income' ? '#10b981' : '#ef4444' }};">
                                {{ $tx->type == 'income' ? '+' : '-' }}৳{{ number_format($tx->amount, 2) }}
                            </td>
                            <td style="padding: 15px;">
                                <form action="{{ route('accounting.delete', $tx->id) }}" method="POST" onsubmit="return confirm('মুছে ফেলার জন্য নিশ্চিত?');">
                                    @csrf
                                    <button type="submit" style="background: transparent; border: none; color: #ef4444; cursor: pointer; font-size: 0.9rem;">মুছুন</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো লেনদেন রেকর্ড পাওয়া যায়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
