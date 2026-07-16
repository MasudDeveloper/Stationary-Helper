@extends('layouts.app')

@section('title', 'Exam Details - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="glass" style="padding: 30px; border-radius: 15px; border-top: 4px solid #818cf8;">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-color: rgba(255,255,255,0.1) !important;">
            <div>
                <h2 style="color: #fff; margin-bottom: 5px; font-weight: 700;">{{ $exam->title }}</h2>
                <h5 style="color: var(--text-muted);">{{ $exam->subject }} | {{ $exam->class }} | {{ $exam->duration_minutes }} minutes</h5>
            </div>
            <a href="{{ route('exams.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;">Back to Exams</a>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white border-0" style="background: rgba(139, 92, 246, 0.1) !important; border: 1px solid rgba(139, 92, 246, 0.2) !important; border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="color: #c4b5fd; font-weight: 800; font-size: 2.5rem;">{{ $exam->questions->count() }}</h3>
                        <p class="mb-0" style="color: #a78bfa; font-weight: 600;">Total Questions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white border-0" style="background: rgba(16, 185, 129, 0.1) !important; border: 1px solid rgba(16, 185, 129, 0.2) !important; border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="color: #6ee7b7; font-weight: 800; font-size: 2.5rem;">{{ $exam->participants->count() }}</h3>
                        <p class="mb-0" style="color: #34d399; font-weight: 600;">Participants</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white border-0" style="background: rgba(59, 130, 246, 0.1) !important; border: 1px solid rgba(59, 130, 246, 0.2) !important; border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="color: #93c5fd; font-weight: 800; font-size: 2.2rem; margin-top: 5px;">{{ $exam->type == 'mcq' ? 'Auto' : 'Manual' }}</h3>
                        <p class="mb-0" style="color: #60a5fa; font-weight: 600;">Exam Type</p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4 mb-3 text-white" style="font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="color: #818cf8;">fact_check</i> Submissions
        </h4>
        
        @if($exam->submissions->count() > 0)
            <div class="table-responsive" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
                <table class="table table-hover mb-0" style="background: transparent; color: #fff; margin-bottom: 0;">
                    <thead style="background: rgba(255,255,255,0.05); color: #cbd5e1;">
                        <tr>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Student Name</th>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Roll/ID</th>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Phone</th>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Score</th>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Status</th>
                            <th style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px;">Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam->submissions as $submission)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td style="padding: 15px; color: #e2e8f0;">{{ $submission->participant->name }}</td>
                                <td style="padding: 15px; color: #94a3b8;">{{ $submission->participant->roll_no ?? '-' }}</td>
                                <td style="padding: 15px; color: #94a3b8;">{{ $submission->participant->phone ?? '-' }}</td>
                                <td style="padding: 15px; color: #34d399; font-weight: 700; font-size: 1.1rem;">{{ $submission->total_score }}</td>
                                <td style="padding: 15px;">
                                    @if($submission->status == 'graded')
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); padding: 6px 12px; border-radius: 20px;">Graded</span>
                                    @else
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); padding: 6px 12px; border-radius: 20px;">Pending</span>
                                    @endif
                                </td>
                                <td style="padding: 15px; color: #94a3b8;">{{ $submission->created_at->format('d M, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-secondary text-center" style="background: rgba(255,255,255,0.05); border: none; color: #9ca3af;">
                No submissions yet. Share the exam link for students to participate.
            </div>
        @endif
        
    </div>
</div>
@endsection
