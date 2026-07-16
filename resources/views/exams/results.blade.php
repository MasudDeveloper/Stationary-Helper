<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result - সহজ কাজ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <style>
        body {
            background-color: #090d16;
            font-family: 'Inter', sans-serif;
            color: #f8fafc;
        }
        .result-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            padding: 40px;
            text-align: center;
            max-width: 600px;
            margin: 50px auto;
            backdrop-filter: blur(10px);
        }
        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        .score-circle.pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="result-card">
        @if(session('success'))
            <div class="alert alert-success mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; border-radius: 10px;">
                {{ session('success') }}
            </div>
        @endif
        
        <h2 class="mb-2" style="color: #fff; font-weight: 800;">{{ $submission->exam->title }}</h2>
        <p class="mb-4" style="color: var(--text-muted);">{{ $submission->participant->name }} <span style="color: #94a3b8;">(Roll: {{ $submission->participant->roll_no ?? 'N/A' }})</span></p>

        @if($submission->status == 'graded')
            <div class="score-circle">
                {{ $submission->total_score }}
            </div>
            <h4 class="mb-4" style="color: #34d399;">You have completed the exam!</h4>
            
            <p style="color: #cbd5e1;">Total Marks Obtained: <strong style="color: #fff; font-size: 1.2rem;">{{ $submission->total_score }}</strong></p>
        @else
            <div class="score-circle pending text-center">
                Under<br>Review
            </div>
            <h4 class="mb-4" style="color: #fbbf24;">Exam Submitted Successfully!</h4>
            
            <p style="color: #cbd5e1;">Your answers are pending manual review by the teacher.</p>
        @endif

        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
        
        <a href="/" class="btn" style="border-radius: 20px; padding: 10px 30px; background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); font-weight: 600;">Back to Home</a>
    </div>
</div>

</body>
</html>
