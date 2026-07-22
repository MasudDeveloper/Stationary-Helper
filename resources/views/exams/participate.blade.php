<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - সহজ কাজ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <style>
        body {
            background-color: #090d16;
            font-family: 'Inter', sans-serif;
            color: #f8fafc;
        }
        .exam-header {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            color: #fff;
            padding: 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .timer {
            font-size: 1.5rem;
            font-weight: bold;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            padding: 5px 15px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .question-card {
            background: rgba(255,255,255,0.02);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 25px;
        }
        .option-label {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 15px;
            background: rgba(0,0,0,0.2);
        }
        .option-label:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.2);
        }
        .option-input:checked + .option-label {
            background: rgba(99, 102, 241, 0.15);
            border-color: #818cf8;
            font-weight: 600;
        }
        .option-input {
            display: none;
        }
        .cq-textarea {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
            color: #fff;
            border-radius: 12px;
            padding: 15px;
            min-height: 120px;
            font-family: inherit;
        }
        .cq-textarea:focus {
            outline: none;
            border-color: #818cf8;
            background: rgba(0,0,0,0.3);
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
        }
        .form-control {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
        }
        .form-control:focus {
            background: rgba(0,0,0,0.3);
            border-color: #818cf8;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
        }
        .form-label { color: rgba(255,255,255,0.8); }
    </style>
</head>
<body>

<div id="setup-section" class="container py-5" style="max-width: 600px; margin-top: 50px;">
    <div class="card border-0" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 20px; backdrop-filter: blur(10px);">
        <div class="card-body p-5">
            <h2 class="text-center mb-4" style="color: #fff; font-weight: 800;">{{ $exam->title }}</h2>
            <div style="background: rgba(0,0,0,0.2); padding: 15px; border-radius: 12px; margin-bottom: 30px; text-align: center;">
                <p class="mb-1" style="color: var(--text-muted);"><strong>Subject:</strong> {{ $exam->subject }} | <strong>Class:</strong> {{ $exam->class }}</p>
                <p class="mb-0" style="color: #cbd5e1;"><strong>Duration:</strong> {{ $exam->duration_minutes }} minutes</p>
            </div>
            
            <form id="start-form">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" id="student_name" class="form-control form-control-lg" required placeholder="e.g. Nayan Akram">
                </div>
                <div class="mb-3">
                    <label class="form-label">Roll / ID Number</label>
                    <input type="text" id="student_roll" class="form-control form-control-lg" placeholder="e.g. 101">
                </div>
                <div class="mb-4">
                    <label class="form-label">Phone Number (Optional)</label>
                    <input type="text" id="student_phone" class="form-control form-control-lg" placeholder="01XXX-XXXXXX">
                </div>
                <button type="button" onclick="startExam()" class="btn btn-lg w-100" style="background: linear-gradient(135deg, #818cf8, #c084fc); border: none; color: #fff; font-weight: 700; border-radius: 12px; padding: 15px;">Start Exam</button>
            </form>
        </div>
    </div>
</div>

<div id="exam-section" style="display: none;">
    <div class="exam-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">{{ $exam->title }}</h4>
                <small>{{ $exam->subject }}</small>
            </div>
            <div class="timer" id="timer-display">
                00:00:00
            </div>
        </div>
    </div>

    <div class="container py-4" style="max-width: 800px;">
        <form action="{{ route('exams.submit', $exam->id) }}" method="POST" id="exam-form">
            @csrf
            <input type="hidden" name="name" id="hidden_name">
            <input type="hidden" name="roll_no" id="hidden_roll">
            <input type="hidden" name="phone" id="hidden_phone">
            
            @foreach($exam->questions as $index => $question)
                <div class="question-card">
                    @if($exam->type == 'mcq')
                        <h5 class="mb-4" style="color: #fff; line-height: 1.5; font-size: 1.15rem;"><strong>{{ $index + 1 }}.</strong> {!! $question->question_text !!} <span class="badge float-end" style="background: rgba(255,255,255,0.1); color: #cbd5e1;">{{ $question->marks }} Marks</span></h5>
                        
                        <div class="row">
                            @foreach(['a', 'b', 'c', 'd'] as $opt)
                                @if(isset($question->options[$opt]))
                                    <div class="col-md-6">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}" id="q{{ $question->id }}_{{ $opt }}" class="option-input">
                                        <label for="q{{ $question->id }}_{{ $opt }}" class="option-label">
                                            <span style="width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.1); display: inline-flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold; color: #cbd5e1; flex-shrink: 0;">{{ strtoupper($opt) }}</span>
                                            <span style="color: #e2e8f0;">{!! $question->options[$opt] !!}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <!-- CQ Question -->
                        <div class="mb-4 text-justify" style="font-size: 1.15rem; line-height: 1.6; color: #fff;">
                            <strong>{{ $index + 1 }}.</strong> {!! $question->question_text !!}
                        </div>
                        
                        <div class="ms-md-3">
                            @foreach(['a', 'b', 'c', 'd'] as $part)
                                @if(isset($question->options[$part]))
                                    <div class="mb-4" style="background: rgba(0,0,0,0.1); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                                        <p class="mb-3" style="color: #e2e8f0; font-size: 1.05rem;"><strong>{{ $part }})</strong> {!! $question->options[$part] !!}</p>
                                        <textarea name="answers[{{ $question->id }}][{{ $part }}]" class="cq-textarea" placeholder="Write your answer here..."></textarea>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="text-center mt-5 mb-5">
                <button type="submit" class="btn btn-lg px-5" style="border-radius: 30px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; font-weight: 700; padding: 15px 40px; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4); border: none;" onclick="return confirm('Are you sure you want to submit your exam?')">Submit Exam</button>
            </div>
        </form>
    </div>
</div>

<script>
    let durationSeconds = {{ $exam->duration_minutes * 60 }};
    let timerInterval;

    function startExam() {
        const name = document.getElementById('student_name').value;
        if (!name) {
            Swal.fire('Please enter your full name.');
            return;
        }

        document.getElementById('hidden_name').value = name;
        document.getElementById('hidden_roll').value = document.getElementById('student_roll').value;
        document.getElementById('hidden_phone').value = document.getElementById('student_phone').value;

        document.getElementById('setup-section').style.display = 'none';
        document.getElementById('exam-section').style.display = 'block';

        // Start Timer
        updateTimerDisplay();
        timerInterval = setInterval(() => {
            durationSeconds--;
            if (durationSeconds <= 0) {
                clearInterval(timerInterval);
                Swal.fire('Time is up! Submitting your exam automatically.');
                document.getElementById('exam-form').submit();
            } else {
                updateTimerDisplay();
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const h = Math.floor(durationSeconds / 3600).toString().padStart(2, '0');
        const m = Math.floor((durationSeconds % 3600) / 60).toString().padStart(2, '0');
        const s = (durationSeconds % 60).toString().padStart(2, '0');
        document.getElementById('timer-display').innerText = `${h}:${m}:${s}`;
        
        if (durationSeconds < 300) { // less than 5 mins
            document.getElementById('timer-display').style.color = '#ef4444'; // Red warning
        }
    }
</script>

</body>
</html>
