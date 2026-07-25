@extends('layouts.app')

@section('title', 'প্রশ্নপত্র প্রিভিউ - সহজ কাজ')

@section('content')
<!-- MathJax for rendering LaTeX/Math formulas -->
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<!-- Html2Pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="container" style="margin-top: 40px; margin-bottom: 40px; max-width: 900px;">
    <!-- Controls (no-print) -->
    <div class="glass no-print" style="padding: 15px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('questions.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color:#fff; border: 1px solid var(--border-color);">
            ← তালিকায় ফিরে যান
        </a>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn btn-primary">প্রিন্ট করুন</button>
            <button onclick="exportToPDF()" class="btn" style="background: #10b981; color: #fff;">ডাউনলোড PDF</button>
        </div>
    </div>

    <!-- Printable Area -->
    <div style="display: flex; justify-content: center;">
        <div id="print-sheet" style="background: #fff; color: #000; width: 100%; max-width: 210mm; min-height: 297mm; padding: 20mm; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Times New Roman', Times, serif; font-size: 1.1rem; line-height: 1.6;">
            <!-- Header Info -->
            <div style="text-align: center; margin-bottom: 25px; font-family: 'Kalpurush', 'Siyam Rupali', 'SolaimanLipi', Arial, sans-serif;">
                <h1 style="font-weight: 800; margin: 0 0 5px 0; font-size: 26px; color: #000; letter-spacing: 0.5px;">{{ $paper->school_name ?? 'স্কুলের / প্রতিষ্ঠানের নাম' }}</h1>
                <h3 style="font-weight: 600; margin: 0 0 6px 0; font-size: 17px; color: #111;">{{ $paper->address ?? 'ঠিকানা / স্থান' }}</h3>
                <h2 style="font-weight: 700; margin: 0 0 6px 0; font-size: 20px; color: #000;">{{ $paper->title }}</h2>
                <h4 style="font-weight: 700; margin: 0 0 15px 0; font-size: 17px; color: #000;">শ্রেণী : {{ $paper->class }} &nbsp;&nbsp;&nbsp;&nbsp; বিষয়: {{ $paper->subject }}</h4>
                
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 16px; font-weight: 700; color: #000; margin-top: 10px; border-bottom: 1.5px solid #000; padding-bottom: 8px;">
                    <div>সময়: {{ $paper->duration ?? '৩ ঘণ্টা' }}</div>
                    <div>মার্ক {{ $paper->marks ?? '৫০' }}</div>
                </div>
            </div>

            <!-- Questions list -->
            <div>
                @php
                    $content = $paper->content;
                @endphp
                @foreach ($content as $idx => $q)
                    <div style="margin-bottom: 25px;">
                        @if ($paper->type == 'mcq')
                            <!-- MCQ -->
                            <div><strong>{{ $idx + 1 }}. {!! $q['text'] !!}</strong></div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; margin-left: 15px; margin-top: 5px;">
                                <div>ক) {!! $q['options']['a'] !!}</div>
                                <div>খ) {!! $q['options']['b'] !!}</div>
                                <div>গ) {!! $q['options']['c'] !!}</div>
                                <div>ঘ) {!! $q['options']['d'] !!}</div>
                            </div>
                        @else
                            <!-- CQ -->
                            <div style="text-align: justify; margin-bottom: 10px;"><strong>{{ $idx + 1 }}. {!! $q['stem'] !!}</strong></div>
                            <div style="margin-left: 20px;">
                                <div>ক) {!! $q['a'] !!} <span style="float: right;">১</span></div>
                                <div>খ) {!! $q['b'] !!} <span style="float: right;">২</span></div>
                                <div>গ) {!! $q['c'] !!} <span style="float: right;">৩</span></div>
                                <div>ঘ) {!! $q['d'] !!} <span style="float: right;">৪</span></div>
                            </div>
                            <div style="clear: both;"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function exportToPDF() {
        var element = document.getElementById('print-sheet');
        var opt = {
            margin:       0,
            filename:     '{{ str_replace(" ", "_", $paper->title) }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<style>
    @media print {
        .no-print { display: none !important; }
        body * { visibility: hidden; }
        #print-sheet, #print-sheet * { visibility: visible; }
        #print-sheet {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            padding: 0;
        }
        .navbar { display: none !important; }
    }
</style>
@endsection
