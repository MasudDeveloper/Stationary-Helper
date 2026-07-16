@extends('layouts.app')

@section('title', 'ক্যাশ ক্যালকুলেটর - সহজ কাজ')

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
        <a href="{{ route('accounting.calculator') }}" class="btn" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">calculate</i> ক্যাশ ক্যালকুলেটর
        </a>
        <a href="{{ route('accounting.dues') }}" class="btn" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px; font-weight: 500; text-decoration: none;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 1.1rem; margin-right: 5px;">menu_book</i> বাকির খাতা
        </a>
    </div>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Calculator Form -->
        <div class="glass" style="flex: 1; min-width: 350px; padding: 30px;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">নোট হিসাব</h3>
            
            <form action="{{ route('accounting.calculator.store') }}" method="POST">
                @csrf
                <div class="form-group" style="display: flex; gap: 15px; align-items: center;">
                    <label class="form-label" style="margin: 0; width: 100px;">তারিখ:</label>
                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                
                <hr style="border-color: var(--border-color); margin: 20px 0;">

                @php
                    $notes = [1000, 500, 200, 100, 50, 20, 10, 5, 2, 1];
                @endphp

                @foreach ($notes as $note)
                <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 12px;">
                    <div style="width: 100px; font-weight: bold; text-align: right;">৳{{ $note }}  ×</div>
                    <input type="number" name="note_{{ $note }}" id="note_{{ $note }}" class="form-control note-input" style="width: 100px; padding: 8px;" min="0" value="0" oninput="calculateNote({{ $note }})">
                    <div style="width: 30px; text-align: center;">=</div>
                    <div style="flex: 1; font-weight: bold; text-align: right; color: var(--primary-color);">৳<span id="subtotal_{{ $note }}">0.00</span></div>
                </div>
                @endforeach

                <hr style="border-color: var(--border-color); margin: 20px 0;">

                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(0, 0, 0, 0.2); padding: 15px; border-radius: 8px;">
                    <h3>মোট পরিমাণ:</h3>
                    <h2 style="color: #10b981;">৳<span id="grand_total">0.00</span></h2>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">হিসাব সংরক্ষণ করুন</button>
            </form>
        </div>

        <!-- History Records -->
        <div class="glass" style="flex: 1; min-width: 350px; padding: 30px;">
            <h3 style="margin-bottom: 20px;">সংরক্ষিত ক্যাশ হিসেবের তালিকা</h3>
            
            <div style="overflow-y: auto; max-height: 550px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 15px;">তারিখ</th>
                            <th style="padding: 15px; text-align: right;">মোট পরিমাণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px;">{{ date('d M, Y', strtotime($record->date)) }}</td>
                            <td style="padding: 15px; text-align: right; font-weight: bold; color: #10b981;">৳{{ number_format($record->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো হিসাব সংরক্ষণ করা হয়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function calculateNote(value) {
        const input = document.getElementById('note_' + value);
        const qty = parseInt(input.value) || 0;
        const subtotal = qty * value;
        document.getElementById('subtotal_' + value).innerText = subtotal.toFixed(2);
        
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        const inputs = document.querySelectorAll('.note-input');
        
        inputs.forEach(input => {
            const value = parseInt(input.id.replace('note_', ''));
            const qty = parseInt(input.value) || 0;
            total += qty * value;
        });

        document.getElementById('grand_total').innerText = total.toFixed(2);
    }
</script>
@endsection
