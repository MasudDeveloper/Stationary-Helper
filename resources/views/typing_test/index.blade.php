@extends('layouts.app')

@section('title', 'টাইপিং স্পিড টেস্ট (Typing Speed Test) - penghor.com')

@section('content')
<style>
    .typing-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 35px 25px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    .typing-card:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(99, 102, 241, 0.2);
    }
    .typing-card-custom {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        border: 2px dashed rgba(59, 130, 246, 0.5);
        border-radius: 20px;
        padding: 35px 25px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    .typing-card-custom:hover {
        transform: translateY(-8px);
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.08);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 25px rgba(59, 130, 246, 0.3);
    }
    .badge-lang {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.3);
        display: inline-block;
    }
    .badge-words {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(59, 130, 246, 0.3);
        display: inline-block;
    }
    .btn-start-custom {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 600;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        transition: all 0.3s;
        border: none;
        width: 100%;
        margin-top: 20px;
    }
    .btn-start-test {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 600;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        transition: all 0.3s;
        border: none;
        width: 100%;
        margin-top: 20px;
    }
    .card-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #ffffff !important;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }
    .card-desc {
        color: #cbd5e1 !important;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }
</style>

<div class="container" style="padding: 40px 20px;">
    <div style="text-align: center; margin-bottom: 45px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); padding: 6px 18px; border-radius: 30px; color: #a5b4fc; font-size: 0.9rem; font-weight: 600; margin-bottom: 15px;">
            <i class="material-icons-round" style="font-size: 18px;">keyboard</i> প্রফেশনাল টাইপিং স্পিড টেস্ট
        </div>
        <h1 style="font-size: 2.75rem; font-weight: 800; color: #ffffff; margin-bottom: 12px; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Typing Speed Test</h1>
        <p style="color: #e2e8f0; font-size: 1.15rem; max-width: 650px; margin: 0 auto; line-height: 1.6;">
            আপনার টাইপিং স্পিড এবং নির্ভুলতা যাচাই করুন। নিচের যেকোনো একটি অনুচ্ছেদ বেছে নিন অথবা নিজের কাস্টম টেক্সট দিয়ে প্র্যাকটিস করুন।
        </p>
    </div>

    <div class="grid-3" style="margin-bottom: 40px; gap: 25px;">
        <!-- Custom Text Card -->
        <div class="typing-card-custom" onclick="window.location.href='{{ route('typing-test.custom') }}'">
            <div>
                <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.3);">
                    <i class="material-icons-round" style="font-size: 34px;">post_add</i>
                </div>
                <h3 class="card-title">Custom Text Test</h3>
                <p class="card-desc">আপনার নিজের যেকোনো বাংলা বা ইংরেজি লেখা পেস্ট করে টাইপিং স্পিড টেস্ট করুন।</p>
            </div>
            <div>
                <span class="btn-start-custom"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px; margin-right: 5px;">play_arrow</i> কাস্টম টেস্ট শুরু করুন</span>
            </div>
        </div>

        <!-- Admin Paragraphs -->
        @foreach($paragraphs as $paragraph)
        <div class="typing-card" onclick="window.location.href='{{ route('typing-test.test', $paragraph->id) }}'">
            <div>
                <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <i class="material-icons-round" style="font-size: 34px;">description</i>
                </div>
                <h3 class="card-title">{{ $paragraph->title }}</h3>
                <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <span class="badge-lang"><i class="material-icons-round" style="font-size: 14px; vertical-align: middle; margin-right: 3px;">language</i> {{ $paragraph->language }}</span>
                    <span class="badge-words"><i class="material-icons-round" style="font-size: 14px; vertical-align: middle; margin-right: 3px;">notes</i> {{ count(preg_split('/\s+/u', trim($paragraph->content), -1, PREG_SPLIT_NO_EMPTY)) }} শব্দ</span>
                </div>
            </div>
            <div>
                <span class="btn-start-test"><i class="material-icons-round" style="vertical-align: middle; font-size: 18px; margin-right: 5px;">speed</i> টেস্ট শুরু করুন</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
