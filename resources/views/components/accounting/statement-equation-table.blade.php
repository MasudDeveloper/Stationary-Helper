{{-- Accounting Statement Equation Sheet Component (Image 3 Format) --}}
@props(['data' => null])

@php
    $defaultRows = [
        ['date' => '২০১৭ মার্চ ১', 'particulars' => '', 'cash' => 20000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => 20000],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 20000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => 20000],
        ['date' => '" ৩', 'particulars' => '', 'cash' => -5000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => -5000],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 15000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => 15000],
        ['date' => '" ৯', 'particulars' => '', 'cash' => -15000, 'receivable' => 0, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 0],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 0, 'receivable' => 0, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 15000],
        ['date' => '" ১৪', 'particulars' => '', 'cash' => 2000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => 2000],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 2000, 'receivable' => 0, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 17000],
        ['date' => '" ১৭', 'particulars' => '', 'cash' => -1000, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => -1000],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 1000, 'receivable' => 0, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 16000],
        ['date' => '" ২২', 'particulars' => '', 'cash' => 0, 'receivable' => 1500, 'equipment' => 0, 'liabilities' => 0, 'equity' => 1500],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 1000, 'receivable' => 1500, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 17500],
        ['date' => '" ২৫', 'particulars' => '', 'cash' => -300, 'receivable' => 0, 'equipment' => 0, 'liabilities' => 0, 'equity' => -300],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 700, 'receivable' => 1500, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 17200],
        ['date' => '" ৩০', 'particulars' => '', 'cash' => 1200, 'receivable' => -1200, 'equipment' => 0, 'liabilities' => 0, 'equity' => 0],
        ['date' => '', 'particulars' => 'উদ্বৃত্ত', 'cash' => 1900, 'receivable' => 300, 'equipment' => 15000, 'liabilities' => 0, 'equity' => 17200],
    ];

    $rows = $data['rows'] ?? $defaultRows;
    $totalAssetSum = 19200;
    $totalEqLiabSum = 19200;
@endphp

<div class="statement-equation-wrapper p-3 rounded-3" style="font-family: 'Hind Siliguri', sans-serif; background: #ffffff; color: #1e293b; border: 2px solid #0f172a; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
    <div style="font-weight: 700; font-size: 1.05rem; margin-bottom: 12px; color: #0f172a;">
        কাজের সমাধান : বিবরণী ছকে হিসাব সমীকরণের উপর লেনদেনের প্রভাব নিম্নরূপ :
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: center; border: 2px solid #0f172a;">
            <thead>
                <tr style="border-bottom: 2px solid #0f172a;">
                    <th style="border: 1px solid #0f172a; padding: 6px; width: 100px;" rowspan="2">তারিখ</th>
                    <th style="border: 1px solid #0f172a; padding: 6px;" colspan="3">সম্পদ</th>
                    <th style="border: 1px solid #0f172a; padding: 6px; width: 30px;" rowspan="2">=</th>
                    <th style="border: 1px solid #0f172a; padding: 6px; width: 100px;" rowspan="2">দায়</th>
                    <th style="border: 1px solid #0f172a; padding: 6px; width: 30px;" rowspan="2">+</th>
                    <th style="border: 1px solid #0f172a; padding: 6px; width: 140px;" rowspan="2">মালিকানাস্বত্ব</th>
                </tr>
                <tr style="border-bottom: 2px solid #0f172a;">
                    <th style="border: 1px solid #0f172a; padding: 5px;">নগদান হিসাব</th>
                    <th style="border: 1px solid #0f172a; padding: 5px;">দেনাদার/প্রাপ্য হিসাব</th>
                    <th style="border: 1px solid #0f172a; padding: 5px;">যন্ত্রপাতি হিসাব</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    @php
                        $isUdbritta = ($row['particulars'] ?? '') === 'উদ্বৃত্ত';
                    @endphp
                    <tr style="{{ $isUdbritta ? 'background: #f8fafc; font-weight: bold;' : '' }}">
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: center;">{{ $row['date'] }}</td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">
                            @if($isUdbritta) <span style="float: left; font-weight: normal; font-size: 0.8rem;">উদ্বৃত্ত</span> @endif
                            @if($row['cash'] != 0)
                                {{ $row['cash'] < 0 ? '('.number_format(abs($row['cash'])).')' : number_format($row['cash']) }}
                            @endif
                        </td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">
                            @if($row['receivable'] != 0)
                                {{ $row['receivable'] < 0 ? '('.number_format(abs($row['receivable'])).')' : number_format($row['receivable']) }}
                            @endif
                        </td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">
                            @if($row['equipment'] != 0)
                                {{ $row['equipment'] < 0 ? '('.number_format(abs($row['equipment'])).')' : number_format($row['equipment']) }}
                            @endif
                        </td>
                        <td style="border: 1px solid #0f172a; padding: 4px;">=</td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">
                            @if($row['liabilities'] != 0)
                                {{ number_format($row['liabilities']) }}
                            @endif
                        </td>
                        <td style="border: 1px solid #0f172a; padding: 4px;">+</td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">
                            @if($row['equity'] != 0)
                                {{ $row['equity'] < 0 ? '('.number_format(abs($row['equity'])).')' : number_format($row['equity']) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                <!-- Total Line with Double Underline -->
                <tr style="font-weight: bold; background: #e2e8f0; border-top: 2px solid #0f172a;">
                    <td style="border: 1px solid #0f172a; padding: 6px;">মোট</td>
                    <td style="border: 1px solid #0f172a; padding: 6px; text-decoration: underline; text-decoration-style: double; font-size: 1rem;" colspan="3">
                        ৳ {{ number_format($totalAssetSum) }}
                    </td>
                    <td style="border: 1px solid #0f172a; padding: 6px;">=</td>
                    <td style="border: 1px solid #0f172a; padding: 6px;" colspan="3">
                        <span style="text-decoration: underline; text-decoration-style: double; font-size: 1rem;">৳ {{ number_format($totalEqLiabSum) }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
