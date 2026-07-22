@extends('layouts.app')

@section('title', 'Typing Test - Smart Stationary')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Typing Speed Test</h1>
        <p style="color: #6b7280; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
            Test your typing speed and accuracy. Choose a paragraph below or paste your own custom text to practice.
        </p>
    </div>

    <div class="grid-3" style="margin-bottom: 40px;">
        <!-- Custom Text Card -->
        <div class="glass" style="padding: 30px; text-align: center; border: 2px dashed #3b82f6; transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='{{ route('typing-test.custom') }}'">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="material-icons-round" style="font-size: 30px;">edit_document</i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 10px; color: #1f2937;">Custom Text Test</h3>
            <p style="color: #6b7280; font-size: 0.95rem; margin-bottom: 20px;">Paste your own text and test your typing speed.</p>
            <span class="btn-primary" style="display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: 0.9rem;">Start Custom Test</span>
        </div>

        <!-- Admin Paragraphs -->
        @foreach($paragraphs as $paragraph)
        <div class="glass" style="padding: 30px; text-align: center; transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='{{ route('typing-test.test', $paragraph->id) }}'">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="material-icons-round" style="font-size: 30px;">description</i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 10px; color: #1f2937;">{{ $paragraph->title }}</h3>
            <p style="color: #6b7280; font-size: 0.95rem; margin-bottom: 20px;">
                Language: <span style="font-weight: 600;">{{ $paragraph->language }}</span><br>
                Length: {{ str_word_count($paragraph->content) }} words
            </p>
            <span class="btn-primary" style="display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: 0.9rem; background: #10b981;">Start Test</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
