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
        @php
            $content = $paper->content;
            $questions = isset($content['questions']) ? $content['questions'] : $content;
            $settings = isset($content['settings']) ? $content['settings'] : ['columns' => 1];
            $columns = $settings['columns'] ?? 1;
            $isDuplicate = !empty($settings['duplicate']) || ($settings['header_style'] ?? '') === 'split';
            $orientation = $settings['orientation'] ?? 'portrait';
            $copies = ($columns == 2 && $isDuplicate) ? 2 : 1;
            
            $maxWidth = $orientation == 'landscape' ? '297mm' : '210mm';
            $minHeight = $orientation == 'landscape' ? '210mm' : '297mm';
        @endphp

        <div id="print-sheet" style="background: #fff; color: #000; width: 100%; max-width: {{ $maxWidth }}; min-height: {{ $minHeight }}; padding: 20mm; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Times New Roman', Times, serif; font-size: 1.1rem; line-height: 1.6;">

            <div style="display: {{ $copies == 2 ? 'flex' : 'block' }}; gap: 40px; width: 100%;">
                @for ($i = 0; $i < $copies; $i++)
                    <div style="{{ $copies == 2 ? 'flex: 1;' : '' }} {{ $copies == 1 && $columns == 2 ? 'column-count: 2; column-gap: 40px;' : '' }}">
                        <div style="text-align: center; margin-bottom: 25px; break-inside: avoid;">
                            @if (!empty($paper->school_name))
                                <h1 style="font-weight: 800; margin: 0 0 5px 0; font-size: 26px; color: #000; letter-spacing: 0.5px;">{{ $paper->school_name }}</h1>
                            @endif
                            @if (!empty($paper->address))
                                <h3 style="font-weight: 600; margin: 0 0 6px 0; font-size: 17px; color: #111;">{{ $paper->address }}</h3>
                            @endif
                            <h2 style="font-weight: 700; margin: 0 0 6px 0; font-size: 20px; color: #000;">{{ $paper->title }}</h2>
                            <h4 style="font-weight: 700; margin: 0 0 15px 0; font-size: 17px; color: #000;">শ্রেণী : {{ $paper->class }} &nbsp;&nbsp;&nbsp;&nbsp; বিষয়: {{ $paper->subject }}</h4>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 16px; font-weight: 700; color: #000; margin-top: 10px;">
                                <div>সময়: {{ $paper->duration ?? '৩ ঘণ্টা' }}</div>
                                <div>মার্ক {{ $paper->marks ?? '৫০' }}</div>
                            </div>
                        </div>

                        <div>
                            @foreach ($questions as $idx => $q)
                                <div style="margin-bottom: 25px; break-inside: avoid;">
                                    @php
                                        $type = $q['type'] ?? (isset($q['options']) ? 'mcq' : 'cq');
                                    @endphp
                                    
                                    @if ($type == 'text')
                                        @if (!empty($q['is_header']))
                                            <div style="text-align: center; font-weight: bold; margin: 15px 0 10px 0;">
                                                {!! $q['text'] ?? '' !!}
                                                @if(!empty($q['marks']))
                                                    <span style="float: right; font-weight: normal;">{!! $q['marks'] !!}</span>
                                                @endif
                                            </div>
                                        @else
                                            <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                                <div>{!! $q['text'] ?? '' !!}</div>
                                                @if(!empty($q['marks']))
                                                    <div>{!! $q['marks'] !!}</div>
                                                @endif
                                            </div>
                                        @endif
                                    @elseif ($type == 'mcq')
                                        <!-- MCQ -->
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                            <div><strong>{{ $idx + 1 }}. {!! $q['text'] ?? $q['stem'] ?? '' !!}</strong></div>
                                            @if(!empty($q['marks']))
                                                <div style="white-space: nowrap; margin-left: 10px;">{!! $q['marks'] !!}</div>
                                            @endif
                                        </div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; margin-left: 15px; margin-top: 5px;">
                                            <div>ক) {!! $q['options']['a'] ?? '' !!}</div>
                                            <div>খ) {!! $q['options']['b'] ?? '' !!}</div>
                                            <div>গ) {!! $q['options']['c'] ?? '' !!}</div>
                                            <div>ঘ) {!! $q['options']['d'] ?? '' !!}</div>
                                        </div>
                                    @else
                                        <!-- CQ -->
                                        <div style="text-align: justify; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: flex-start;">
                                            <div><strong>{{ $idx + 1 }}. {!! $q['stem'] ?? $q['text'] ?? '' !!}</strong></div>
                                            @if(!empty($q['marks']))
                                                <div style="white-space: nowrap; margin-left: 10px;">{!! $q['marks'] !!}</div>
                                            @endif
                                        </div>
                                        <div style="margin-left: 20px;">
                                            @if(!empty($q['a'])) <div>ক) {!! $q['a'] !!} <span style="float: right;">১</span></div> @endif
                                            @if(!empty($q['b'])) <div>খ) {!! $q['b'] !!} <span style="float: right;">২</span></div> @endif
                                            @if(!empty($q['c'])) <div>গ) {!! $q['c'] !!} <span style="float: right;">৩</span></div> @endif
                                            @if(!empty($q['d'])) <div>ঘ) {!! $q['d'] !!} <span style="float: right;">৪</span></div> @endif
                                        </div>
                                        <div style="clear: both;"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endfor
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
            jsPDF:        { unit: 'mm', format: 'a4', orientation: '{{ $orientation }}' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<style>
    @media print {
        @page { size: A4 {{ $orientation }}; margin: 0; }
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
