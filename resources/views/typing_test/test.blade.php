@extends('layouts.app')

@section('title', 'Typing Test - Smart Stationary')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 900px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">{{ $paragraph->title }}</h2>
        <a href="{{ route('typing-test.index') }}" class="btn" style="color: #6b7280; font-weight: 500;">&larr; Back to tests</a>
    </div>

    <!-- Metrics Dashboard -->
    <div class="glass" style="padding: 20px 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border-radius: 12px;">
        <div style="text-align: center;">
            <div style="font-size: 0.9rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Time</div>
            <div id="time-display" style="font-size: 2rem; font-weight: 700; color: #3b82f6;">00:00</div>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 0.9rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">WPM</div>
            <div id="wpm-display" style="font-size: 2.5rem; font-weight: 800; color: #10b981;">0</div>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 0.9rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Accuracy</div>
            <div id="accuracy-display" style="font-size: 2rem; font-weight: 700; color: #f59e0b;">100%</div>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 0.9rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Errors</div>
            <div id="errors-display" style="font-size: 2rem; font-weight: 700; color: #ef4444;">0</div>
        </div>
    </div>

    <!-- Typing Area -->
    <div class="glass" style="padding: 40px; border-radius: 12px; position: relative;">
        <!-- Click to focus overlay -->
        <div id="focus-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); backdrop-filter: blur(2px); border-radius: 12px; display: flex; justify-content: center; align-items: center; z-index: 10; cursor: pointer;">
            <div style="background: #3b82f6; color: #fff; padding: 10px 25px; border-radius: 30px; font-weight: 600; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(59,130,246,0.3);">
                Click here or press any key to start
            </div>
        </div>
        
        <div id="text-display" style="font-size: 1.5rem; line-height: 1.8; font-family: 'Inter', sans-serif; color: #9ca3af; user-select: none;">
            <!-- Words will be injected here via JS -->
        </div>

        <input type="text" id="typing-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="position: absolute; opacity: 0; pointer-events: none;">
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <button id="restart-btn" class="btn-primary" style="padding: 10px 30px; border-radius: 30px; font-size: 1rem; font-weight: 600; background: #6b7280;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 20px; margin-right: 5px;">refresh</i> Restart Test
        </button>
    </div>

</div>

<style>
    .correct { color: #10b981; }
    .incorrect { color: #ef4444; background: rgba(239, 68, 68, 0.1); border-radius: 2px; }
    .current { border-bottom: 2px solid #3b82f6; animation: blink 1s infinite; }
    .remaining { color: #9ca3af; }
    
    @keyframes blink {
        0%, 100% { border-bottom-color: transparent; }
        50% { border-bottom-color: #3b82f6; }
    }
    
    #text-display {
        white-space: pre-wrap;
        word-break: break-word;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const textDisplay = document.getElementById('text-display');
    const typingInput = document.getElementById('typing-input');
    const timeDisplay = document.getElementById('time-display');
    const wpmDisplay = document.getElementById('wpm-display');
    const accuracyDisplay = document.getElementById('accuracy-display');
    const errorsDisplay = document.getElementById('errors-display');
    const focusOverlay = document.getElementById('focus-overlay');
    const restartBtn = document.getElementById('restart-btn');

    let text = {!! json_encode($paragraph->content) !!};
    
    let timer = 0;
    let timerInterval = null;
    let isTestActive = false;
    let errors = 0;
    let totalTyped = 0;
    let lastInputLength = 0;

    function initTest() {
        timer = 0;
        errors = 0;
        totalTyped = 0;
        lastInputLength = 0;
        isTestActive = false;
        clearInterval(timerInterval);
        
        timeDisplay.innerText = '00:00';
        wpmDisplay.innerText = '0';
        accuracyDisplay.innerText = '100%';
        errorsDisplay.innerText = '0';
        
        typingInput.value = '';
        typingInput.maxLength = text.length;
        focusOverlay.style.display = 'flex';
        
        updateTextDisplay();
    }

    function updateTextDisplay() {
        const val = typingInput.value;
        
        let correctStr = '';
        let incorrectStr = '';
        let currentStr = '';
        let remainingStr = '';
        
        let i = 0;
        while (i < val.length && val[i] === text[i]) {
            correctStr += text[i];
            i++;
        }
        
        let incorrectLength = val.length - i;
        if (i + incorrectLength > text.length) {
            incorrectLength = text.length - i;
        }
        
        incorrectStr = text.substr(i, incorrectLength);
        
        if (i + incorrectLength < text.length) {
            currentStr = text.substr(i + incorrectLength, 1);
        }
        
        remainingStr = text.substr(i + incorrectLength + 1);
        
        textDisplay.innerHTML = 
            (correctStr ? `<span class="correct">${correctStr}</span>` : '') +
            (incorrectStr ? `<span class="incorrect">${incorrectStr}</span>` : '') +
            (currentStr ? `<span class="current">${currentStr}</span>` : '') +
            (remainingStr ? `<span class="remaining">${remainingStr}</span>` : '');
            
        // Auto scroll
        const currentEl = textDisplay.querySelector('.current');
        if (currentEl) {
            const container = textDisplay;
            if (currentEl.offsetTop > container.scrollTop + container.clientHeight - 50) {
                container.scrollTop = currentEl.offsetTop - 50;
            }
        }
    }

    function startTimer() {
        if (!isTestActive) {
            isTestActive = true;
            timerInterval = setInterval(() => {
                timer++;
                let minutes = Math.floor(timer / 60);
                let seconds = timer % 60;
                timeDisplay.innerText = `${minutes < 10 ? '0'+minutes : minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
                calculateMetrics();
            }, 1000);
        }
    }

    function calculateMetrics() {
        let correctChars = document.querySelectorAll('.correct').length > 0 ? document.querySelector('.correct').innerText.length : 0;
        let timeInMinutes = timer / 60;
        let wpm = timeInMinutes > 0 ? Math.round((correctChars / 5) / timeInMinutes) : 0;
        
        let accuracy = totalTyped > 0 ? Math.round(((totalTyped - errors) / totalTyped) * 100) : 100;
        if(accuracy < 0) accuracy = 0;

        wpmDisplay.innerText = wpm;
        accuracyDisplay.innerText = `${accuracy}%`;
        errorsDisplay.innerText = errors;
    }

    function endTest() {
        clearInterval(timerInterval);
        isTestActive = false;
        calculateMetrics();
        
        Swal.fire({
            title: 'Test Completed!',
            html: `
                <div style="font-size: 1.2rem; margin-top: 15px;">
                    <div style="margin-bottom: 10px;"><strong>WPM:</strong> <span style="color: #10b981;">${wpmDisplay.innerText}</span></div>
                    <div style="margin-bottom: 10px;"><strong>Accuracy:</strong> <span style="color: #f59e0b;">${accuracyDisplay.innerText}</span></div>
                    <div style="margin-bottom: 10px;"><strong>Errors:</strong> <span style="color: #ef4444;">${errorsDisplay.innerText}</span></div>
                    <div><strong>Time:</strong> <span style="color: #3b82f6;">${timeDisplay.innerText}</span></div>
                </div>
            `,
            icon: 'success',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#3b82f6',
            allowOutsideClick: false
        }).then(() => {
            initTest();
        });
    }

    typingInput.addEventListener('input', (e) => {
        if (!isTestActive && typingInput.value.length > 0) startTimer();
        
        const currentLength = typingInput.value.length;
        
        // Track keystrokes and errors only when length increases (typing forward)
        if (currentLength > lastInputLength) {
            totalTyped++;
            if (typingInput.value[currentLength - 1] !== text[currentLength - 1]) {
                errors++;
            }
        }
        lastInputLength = currentLength;
        
        updateTextDisplay();
        
        if (currentLength >= text.length) {
            endTest();
        }
    });

    focusOverlay.addEventListener('click', () => {
        focusOverlay.style.display = 'none';
        typingInput.focus();
    });

    document.addEventListener('keydown', (e) => {
        if (focusOverlay.style.display !== 'none' && e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
            focusOverlay.style.display = 'none';
            typingInput.focus();
        }
    });

    restartBtn.addEventListener('click', initTest);

    // Initial call
    initTest();

</script>
@endsection
