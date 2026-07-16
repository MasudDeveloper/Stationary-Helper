@extends('layouts.app')

@section('title', 'Online Exams - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="d-flex justify-content-between align-items-center mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
        <div>
            <h2 style="color: #fff; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 12px; margin-bottom: 5px;">Online Exams</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">অনলাইন এক্সাম তৈরি ও পরিচালনা করুন</p>
        </div>
        <div>
            <a href="{{ route('exams.create', ['type' => 'mcq']) }}" class="btn" style="background: linear-gradient(135deg, #8b5cf6, #d946ef); border: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4); color: #fff; font-weight: 600;">+ MCQ Exam</a>
            <a href="{{ route('exams.create', ['type' => 'cq']) }}" class="btn" style="background: linear-gradient(135deg, #ec4899, #f43f5e); border: none; box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4); color: #fff; font-weight: 600; margin-left: 10px;">+ CQ Exam</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; color: #059669; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($exams as $exam)
            <div class="col-md-4 mb-4">
                <div class="glass" style="padding: 25px; border-radius: 16px; transition: transform 0.3s; position: relative;">
                    <span class="badge" style="position: absolute; top: 15px; right: 15px; background: {{ $exam->type == 'mcq' ? 'rgba(139, 92, 246, 0.2)' : 'rgba(236, 72, 153, 0.2)' }}; color: {{ $exam->type == 'mcq' ? '#c4b5fd' : '#fbcfe8' }}; padding: 6px 12px; border-radius: 20px; font-weight: 700; text-transform: uppercase; border: 1px solid {{ $exam->type == 'mcq' ? 'rgba(139, 92, 246, 0.4)' : 'rgba(236, 72, 153, 0.4)' }};">
                        {{ $exam->type }}
                    </span>
                    <h3 style="font-size: 1.4rem; margin-bottom: 10px; color: #fff; font-weight: 700;">{{ $exam->title }}</h3>
                    <p style="color: var(--text-muted); margin-bottom: 5px;"><strong>Subject:</strong> <span style="color: #e2e8f0;">{{ $exam->subject }}</span></p>
                    <p style="color: var(--text-muted); margin-bottom: 5px;"><strong>Class:</strong> <span style="color: #e2e8f0;">{{ $exam->class }}</span></p>
                    <p style="color: var(--text-muted); margin-bottom: 15px;"><strong>Duration:</strong> <span style="color: #e2e8f0;">{{ $exam->duration_minutes }} minutes</span></p>
                    
                    <div style="background: rgba(0,0,0,0.2); padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.9rem; border: 1px solid rgba(255,255,255,0.05);">
                        <strong style="color: #cbd5e1;">Public Link:</strong>
                        <div style="display: flex; gap: 5px; margin-top: 8px;">
                            <input type="text" class="form-control" value="{{ route('exams.participate', $exam->id) }}" readonly style="font-size: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 6px 10px;" id="link_{{ $exam->id }}">
                            <button class="btn btn-sm" onclick="copyLink('link_{{ $exam->id }}')" style="background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); font-size: 0.8rem; font-weight: 600; padding: 6px 12px;">Copy</button>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <a href="{{ route('exams.show', $exam->id) }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 6px 15px; font-size: 0.9rem; border-radius: 6px; text-decoration: none; border: 1px solid rgba(255,255,255,0.1);">View Details</a>
                        <form action="{{ route('exams.delete', $exam->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exam?');" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #fca5a5; padding: 6px 15px; font-size: 0.9rem; border-radius: 6px; border: 1px solid rgba(239, 68, 68, 0.3);">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="glass text-center" style="padding: 50px;">
                    <h4 style="color: var(--text-color);">No exams created yet.</h4>
                    <p style="color: #9ca3af; margin-bottom: 20px;">Create your first MCQ or CQ exam to get started.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
function copyLink(id) {
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Copied the link: " + copyText.value);
}
</script>

<style>
    .glass:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
</style>
@endsection
