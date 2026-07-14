@extends('layouts.app')

@section('title', 'প্রশ্নপত্র তৈরি - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 10px; text-align: center;">প্রশ্নপত্র মেকার (Question Paper Maker)</h2>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">সহজেই সৃজনশীল (CQ) এবং বহুনির্বাচনী (MCQ) প্রশ্নপত্র তৈরি করুন</p>

    <!-- Create Selection Buttons -->
    <div style="display: flex; gap: 20px; justify-content: center; margin-bottom: 40px;">
        <a href="{{ route('questions.create', ['type' => 'mcq']) }}" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem; border-radius: 30px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);">
            + নতুন MCQ প্রশ্নপত্র তৈরি করুন
        </a>
        <a href="{{ route('questions.create', ['type' => 'cq']) }}" class="btn" style="padding: 15px 30px; font-size: 1.1rem; border-radius: 30px; background: rgba(255,255,255,0.1); border: 1px solid var(--border-color); color: #fff;">
            + নতুন CQ প্রশ্নপত্র তৈরি করুন
        </a>
    </div>

    <!-- Saved List -->
    <div class="glass" style="padding: 30px;">
        <h3 style="margin-bottom: 20px;">সংরক্ষিত প্রশ্নপত্রসমূহ</h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th style="padding: 15px;">তারিখ</th>
                        <th style="padding: 15px;">শিরোনাম</th>
                        <th style="padding: 15px;">শ্রেণী / বিষয়</th>
                        <th style="padding: 15px;">ধরন</th>
                        <th style="padding: 15px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($papers as $paper)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 15px;">{{ $paper->created_at->format('d M, Y') }}</td>
                        <td style="padding: 15px; color: var(--text-main); font-weight: bold;">{{ $paper->title }}</td>
                        <td style="padding: 15px;">{{ $paper->class }} - {{ $paper->subject }}</td>
                        <td style="padding: 15px;">
                            @if ($paper->type == 'mcq')
                                <span style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">MCQ</span>
                            @else
                                <span style="background: rgba(59, 130, 246, 0.2); color: #3b82f6; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">CQ</span>
                            @endif
                        </td>
                        <td style="padding: 15px; display: flex; gap: 10px;">
                            <a href="{{ route('questions.show', $paper->id) }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border-color); padding: 6px 12px; font-size: 0.9rem;">দেখুন ও প্রিন্ট</a>
                            <form action="{{ route('questions.delete', $paper->id) }}" method="POST" onsubmit="return confirm('প্রশ্নপত্রটি মুছে ফেলতে চান?');">
                                @csrf
                                <button type="submit" style="background: transparent; border: none; color: #ef4444; cursor: pointer; padding-top: 8px;">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো প্রশ্নপত্র পাওয়া যায়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
