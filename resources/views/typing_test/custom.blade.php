@extends('layouts.app')

@section('title', 'Custom Typing Test - Smart Stationary')

@section('content')
<style>
    .correct { color: #34d399 !important; text-shadow: 0 0 8px rgba(52, 211, 153, 0.3); font-weight: 600; }
    .incorrect { color: #f87171 !important; background: rgba(239, 68, 68, 0.25); border-radius: 4px; padding: 0 2px; }
    .current { border-bottom: 3px solid #60a5fa; background: rgba(96, 165, 250, 0.2); border-radius: 4px; animation: blink 1s infinite; }
    .remaining { color: #94a3b8; }
    
    @keyframes blink {
        0%, 100% { border-bottom-color: transparent; background: transparent; }
        50% { border-bottom-color: #60a5fa; background: rgba(96, 165, 250, 0.2); }
    }
    
    #text-display {
        white-space: pre-wrap;
        word-break: break-word;
        font-size: 1.6rem;
        line-height: 1.9;
        font-family: 'Inter', 'SolaimanLipi', sans-serif;
        user-select: none;
        max-height: 450px;
        overflow-y: auto;
        padding-right: 15px;
    }

    #text-display::-webkit-scrollbar {
        width: 8px;
    }
    #text-display::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    #text-display::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.4);
        border-radius: 10px;
    }

    .setup-panel {
        background: rgba(30, 41, 59, 0.75);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        margin-bottom: 25px;
    }

    .metrics-panel {
        background: rgba(30, 41, 59, 0.75);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 25px 35px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    .metric-label {
        font-size: 0.9rem;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 5px;
    }
    .typing-box {
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(99, 102, 241, 0.4);
        padding: 45px;
        border-radius: 24px;
        position: relative;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 0 30px rgba(99, 102, 241, 0.05);
    }
    .btn-back {
        color: #93c5fd;
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.3);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .btn-back:hover {
        background: rgba(59, 130, 246, 0.3);
        color: #ffffff;
        transform: translateX(-3px);
    }
    .btn-restart {
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 1.05rem;
        font-weight: 600;
        background: linear-gradient(135deg, #64748b, #475569);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-restart:hover {
        background: linear-gradient(135deg, #475569, #334155);
        transform: translateY(-2px);
    }
    .btn-new-text {
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 1.05rem;
        font-weight: 600;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-new-text:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
    }
</style>

<div class="container" style="padding: 40px 20px; max-width: 950px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <span style="font-size: 0.85rem; color: #60a5fa; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">কাস্টম প্র্যাকটিস মোড</span>
            <h2 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Custom Typing Test</h2>
        </div>
        <a href="{{ route('typing-test.index') }}" class="btn-back"><i class="material-icons-round" style="vertical-align: middle; font-size: 20px; margin-right: 6px;">arrow_back</i> সব টেস্টে ফিরে যান</a>
    </div>

    <!-- Input Section (Shown initially) -->
    <div id="setup-section" class="setup-panel">
        <h3 style="margin-bottom: 12px; color: #ffffff; font-size: 1.45rem; font-weight: 700;"><i class="material-icons-round" style="vertical-align: middle; color: #60a5fa; margin-right: 6px;">content_paste</i> আপনার টেক্সট এখানে পেস্ট করুন</h3>
        <p style="color: #cbd5e1; margin-bottom: 22px; font-size: 1rem; line-height: 1.6;">আপনি যে টেক্সট বা অনুচ্ছেদ প্র্যাকটিস করতে চান তা নিচের বক্সে পেস্ট করুন। বাংলা বা ইংরেজি যেকোনো লেখাই সাপোর্ট করবে।</p>
        
        <textarea id="custom-text-input" class="form-control" rows="8" placeholder="এখানে আপনার লেখা পেস্ট করুন..." style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(99, 102, 241, 0.4); color: #ffffff; border-radius: 16px; padding: 22px; font-size: 1.15rem; line-height: 1.7; font-family: 'Inter', 'SolaimanLipi', sans-serif; resize: vertical; margin-bottom: 25px; width: 100%; box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);"></textarea>
        
        <div style="text-align: right;">
            <button id="start-custom-btn" style="padding: 14px 36px; border-radius: 35px; font-size: 1.05rem; font-weight: 700; background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; border: none; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="font-size: 24px;">play_arrow</i> টেস্ট শুরু করুন
            </button>
        </div>
    </div>

    <!-- Test Section (Hidden initially) -->
    <div id="test-section" style="display: none;">
        <!-- Metrics Dashboard -->
        <div class="metrics-panel">
            <div style="text-align: center;">
                <div class="metric-label">সময় (Time)</div>
                <div id="time-display" style="font-size: 2.2rem; font-weight: 800; color: #60a5fa; text-shadow: 0 0 15px rgba(96, 165, 250, 0.3);">00:00</div>
            </div>
            <div style="width: 1px; height: 50px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div class="metric-label">গতি (WPM)</div>
                <div id="wpm-display" style="font-size: 2.75rem; font-weight: 900; color: #34d399; text-shadow: 0 0 15px rgba(52, 211, 153, 0.3);">0</div>
            </div>
            <div style="width: 1px; height: 50px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div class="metric-label">নির্ভুলতা (Accuracy)</div>
                <div id="accuracy-display" style="font-size: 2.2rem; font-weight: 800; color: #fbbf24; text-shadow: 0 0 15px rgba(251, 191, 36, 0.3);">100%</div>
            </div>
            <div style="width: 1px; height: 50px; background: rgba(255,255,255,0.1);"></div>
            <div style="text-align: center;">
                <div class="metric-label">ভুল (Errors)</div>
                <div id="errors-display" style="font-size: 2.2rem; font-weight: 800; color: #f87171; text-shadow: 0 0 15px rgba(248, 113, 113, 0.3);">0</div>
            </div>
        </div>

        <!-- Typing Area -->
        <div class="typing-box">
            <!-- Click to focus overlay -->
            <div id="focus-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(6px); border-radius: 22px; display: flex; justify-content: center; align-items: center; z-index: 10; cursor: pointer;">
                <div style="background: linear-gradient(135deg, #3b82f6, #6366f1); color: #fff; padding: 16px 36px; border-radius: 40px; font-weight: 700; font-size: 1.2rem; box-shadow: 0 10px 30px rgba(59,130,246,0.5); display: flex; align-items: center; gap: 12px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="material-icons-round" style="font-size: 28px;">touch_app</i> ক্লিক করুন বা যেকোনো কি (Key) চাপুন টেস্ট শুরু করতে
                </div>
            </div>
            
            <div id="text-display">
                <!-- Words will be injected here via JS -->
            </div>

            <input type="text" id="typing-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="position: absolute; opacity: 0; pointer-events: none;">
        </div>
        
        <div style="text-align: center; margin-top: 35px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
            <button id="restart-btn" class="btn-restart">
                <i class="material-icons-round" style="font-size: 24px;">refresh</i> পুনরায় শুরু করুন (Restart)
            </button>
            <button id="new-text-btn" class="btn-new-text">
                <i class="material-icons-round" style="font-size: 24px;">post_add</i> নতুন টেক্সট দিন (New Text)
            </button>
        </div>
    </div>

</div>

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
    
    let timer = 0;
    let timerInterval = null;
    let isTestActive = false;
    let errors = 0;
    let totalTyped = 0;
    let lastInputLength = 0;

    startCustomBtn.addEventListener('click', () => {
        let val = customTextInput.value.trim();
        val = val.replace(/\s+/g, ' ');

        if (!val) {
            Swal.fire({
                title: 'ত্রুটি!',
                text: 'অনুগ্রহ করে প্র্যাকটিস করার জন্য কিছু টেক্সট বক্সে পেস্ট করুন।',
                icon: 'error',
                background: '#1e293b',
                color: '#fff'
            });
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
            if (currentEl.offsetTop > container.scrollTop + container.clientHeight - 60) {
                container.scrollTop = currentEl.offsetTop - 60;
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
            title: 'অভিনন্দন! টেস্ট সম্পন্ন হয়েছে! 🎉',
            html: `
                <div style="font-size: 1.15rem; margin-top: 20px; line-height: 2; text-align: left; background: rgba(30, 41, 59, 0.8); padding: 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                    <div style="display:flex; justify-content:space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom:8px;"><strong>গতি (WPM):</strong> <span style="color: #34d399; font-weight:800; font-size:1.4rem;">${wpmDisplay.innerText}</span></div>
                    <div style="display:flex; justify-content:space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 8px 0;"><strong>নির্ভুলতা (Accuracy):</strong> <span style="color: #fbbf24; font-weight:800; font-size:1.4rem;">${accuracyDisplay.innerText}</span></div>
                    <div style="display:flex; justify-content:space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 8px 0;"><strong>ভুল (Errors):</strong> <span style="color: #f87171; font-weight:800; font-size:1.4rem;">${errorsDisplay.innerText}</span></div>
                    <div style="display:flex; justify-content:space-between; padding-top: 8px;"><strong>সময় (Time):</strong> <span style="color: #60a5fa; font-weight:800; font-size:1.4rem;">${timeDisplay.innerText}</span></div>
                </div>
            `,
            icon: 'success',
            background: '#1e293b',
            color: '#fff',
            confirmButtonText: '<i class="material-icons-round" style="vertical-align:middle;">refresh</i> আবার চেষ্টা করুন',
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
        if (testSection.style.display !== 'none' && focusOverlay.style.display !== 'none' && e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
            focusOverlay.style.display = 'none';
            typingInput.focus();
        }
    });

    restartBtn.addEventListener('click', initTest);

</script>
@endsection
