@extends('layouts.app')

@section('title', 'Custom Typing Test - Smart Stationary')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 900px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">Custom Typing Test</h2>
        <a href="{{ route('typing-test.index') }}" class="btn" style="color: #6b7280; font-weight: 500;">&larr; Back to tests</a>
    </div>

    <!-- Input Section (Shown initially) -->
    <div id="setup-section" class="glass" style="padding: 40px; border-radius: 12px; margin-bottom: 20px;">
        <h3 style="margin-bottom: 15px; color: #374151;">Paste Your Text</h3>
        <p style="color: #6b7280; margin-bottom: 20px;">Paste the text you want to practice with below. Make sure it doesn't contain weird hidden characters.</p>
        
        <textarea id="custom-text-input" class="form-control" rows="8" placeholder="Paste your text here..." style="font-size: 1.1rem; line-height: 1.6; font-family: 'Inter', sans-serif; resize: vertical; margin-bottom: 20px;"></textarea>
        
        <div style="text-align: right;">
            <button id="start-custom-btn" class="btn-primary" style="padding: 12px 30px; border-radius: 30px; font-size: 1rem; font-weight: 600;">
                <i class="material-icons-round" style="vertical-align: middle; font-size: 20px; margin-right: 5px;">play_arrow</i> Start Test
            </button>
        </div>
    </div>

    <!-- Test Section (Hidden initially) -->
    <div id="test-section" style="display: none;">
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
            
            <div id="text-display" style="font-size: 1.5rem; line-height: 1.8; font-family: 'Inter', sans-serif; color: #9ca3af; user-select: none; max-height: 400px; overflow-y: auto;">
                <!-- Words will be injected here via JS -->
            </div>

            <input type="text" id="typing-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="position: absolute; opacity: 0; pointer-events: none;">
        </div>
        
        <div style="text-align: center; margin-top: 30px; display: flex; justify-content: center; gap: 15px;">
            <button id="restart-btn" class="btn-primary" style="padding: 10px 30px; border-radius: 30px; font-size: 1rem; font-weight: 600; background: #6b7280;">
                <i class="material-icons-round" style="vertical-align: middle; font-size: 20px; margin-right: 5px;">refresh</i> Restart Text
            </button>
            <button id="new-text-btn" class="btn-primary" style="padding: 10px 30px; border-radius: 30px; font-size: 1rem; font-weight: 600; background: #f59e0b;">
                <i class="material-icons-round" style="vertical-align: middle; font-size: 20px; margin-right: 5px;">edit_note</i> New Text
            </button>
        </div>
    </div>

</div>

<style>
    .word { margin-right: 8px; display: inline-block; }
    .char { display: inline-block; border-bottom: 2px solid transparent; }
    .char.correct { color: #1f2937; }
    .char.incorrect { color: #ef4444; background: rgba(239, 68, 68, 0.1); }
    .char.current { border-bottom-color: #3b82f6; animation: blink 1s infinite; }
    
    @keyframes blink {
        0%, 100% { border-bottom-color: transparent; }
        50% { border-bottom-color: #3b82f6; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const setupSection = document.getElementById('setup-section');
    const testSection = document.getElementById('test-section');
    const customTextInput = document.getElementById('custom-text-input');
    const startCustomBtn = document.getElementById('start-custom-btn');
    const newTextBtn = document.getElementById('new-text-btn');

    const textDisplay = document.getElementById('text-display');
    const typingInput = document.getElementById('typing-input');
    const timeDisplay = document.getElementById('time-display');
    const wpmDisplay = document.getElementById('wpm-display');
    const accuracyDisplay = document.getElementById('accuracy-display');
    const errorsDisplay = document.getElementById('errors-display');
    const focusOverlay = document.getElementById('focus-overlay');
    const restartBtn = document.getElementById('restart-btn');

    let text = '';
    let chars = [];
    let charElements = [];
    
    let currentIndex = 0;
    let timer = 0;
    let timerInterval = null;
    let isTestActive = false;
    let errors = 0;
    let totalTyped = 0;

    startCustomBtn.addEventListener('click', () => {
        let val = customTextInput.value.trim();
        // Replace multiple spaces with a single space
        val = val.replace(/\s+/g, ' ');

        if (!val) {
            Swal.fire('Error', 'Please enter some text to practice.', 'error');
            return;
        }
        
        text = val;
        setupSection.style.display = 'none';
        testSection.style.display = 'block';
        initTest();
    });

    newTextBtn.addEventListener('click', () => {
        clearInterval(timerInterval);
        testSection.style.display = 'none';
        setupSection.style.display = 'block';
        customTextInput.value = '';
    });

    function initTest() {
        textDisplay.innerHTML = '';
        chars = text.split('');
        charElements = [];
        
        let wordSpan = document.createElement('span');
        wordSpan.className = 'word';
        
        chars.forEach((char, index) => {
            const charSpan = document.createElement('span');
            charSpan.innerText = char;
            charSpan.className = 'char';
            if (index === 0) charSpan.classList.add('current');
            charElements.push(charSpan);
            
            wordSpan.appendChild(charSpan);
            
            if (char === ' ') {
                textDisplay.appendChild(wordSpan);
                wordSpan = document.createElement('span');
                wordSpan.className = 'word';
            }
        });
        textDisplay.appendChild(wordSpan); // Append the last word

        currentIndex = 0;
        timer = 0;
        errors = 0;
        totalTyped = 0;
        isTestActive = false;
        clearInterval(timerInterval);
        
        timeDisplay.innerText = '00:00';
        wpmDisplay.innerText = '0';
        accuracyDisplay.innerText = '100%';
        errorsDisplay.innerText = '0';
        typingInput.value = '';
        focusOverlay.style.display = 'flex';
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
        // WPM = (total correct characters / 5) / time in minutes
        let correctChars = document.querySelectorAll('.char.correct').length;
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
        if (currentIndex >= chars.length) return;
        
        const inputValue = typingInput.value;
        const currentChar = inputValue[inputValue.length - 1];
        
        if (!isTestActive) startTimer();
        totalTyped++;
        
        charElements[currentIndex].classList.remove('current');

        if (currentChar === chars[currentIndex]) {
            charElements[currentIndex].classList.add('correct');
        } else {
            charElements[currentIndex].classList.add('incorrect');
            errors++;
        }
        
        currentIndex++;
        
        if (currentIndex < chars.length) {
            charElements[currentIndex].classList.add('current');
            
            // Auto scroll logic (simple approach)
            const currentEl = charElements[currentIndex];
            const container = textDisplay;
            if (currentEl.offsetTop > container.scrollTop + container.clientHeight - 50) {
                container.scrollTop = currentEl.offsetTop - 50;
            }
        } else {
            endTest();
        }
    });

    typingInput.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && currentIndex > 0) {
            e.preventDefault();
            
            charElements[currentIndex]?.classList.remove('current');
            currentIndex--;
            
            charElements[currentIndex].classList.remove('correct', 'incorrect');
            charElements[currentIndex].classList.add('current');
            
            typingInput.value = typingInput.value.slice(0, -1);
        }
    });

    focusOverlay.addEventListener('click', () => {
        focusOverlay.style.display = 'none';
        typingInput.focus();
    });

    document.addEventListener('keydown', (e) => {
        if (testSection.style.display !== 'none' && focusOverlay.style.display !== 'none' && e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
            focusOverlay.style.display = 'none';
            typingInput.focus();
        }
    });

    restartBtn.addEventListener('click', initTest);

</script>
@endsection
