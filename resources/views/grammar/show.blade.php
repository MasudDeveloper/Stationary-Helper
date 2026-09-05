@extends('layouts.app')

@section('title', $lesson->level_name . ' - penghor.com')

@section('content')
<div class="container py-4" style="color: var(--text-main);">
    <!-- Navigation Back Link -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('grammar.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="material-icons-round" style="font-size: 1.15rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">গ্রামার ড্যাশবোর্ডে ফিরে যান</span>
        </a>
    </div>

    <!-- Header Lesson Card -->
    <div class="glass mb-4 p-4">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <span style="background: rgba(99, 102, 241, 0.15); color: var(--primary-hover); border: 1px solid rgba(99, 102, 241, 0.3); padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-bottom: 8px;">
                    Level {{ $lesson->level_no }} - {{ $lesson->category }}
                </span>
                <h1 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->level_name }}</h1>
            </div>
            @if($submission)
                <div id="top-score-badge">
                    <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round">check_circle</i>
                        <span style="font-family: 'Hind Siliguri', sans-serif;">কুইজ সম্পন্ন (প্রাপ্ত স্কোর: {{ round($submission->score) }}%)</span>
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Lesson Material Details Grid -->
    <div class="show-layout-grid">
        <!-- Lesson Content Column -->
        <div class="lesson-content-column">
            <div class="glass p-4" style="height: 100%;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="material-icons-round" style="color: var(--primary-hover);">menu_book</i>
                    টপিক স্টাডি গাইড
                </h3>

                <!-- Rule and Formula -->
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">১. নিয়ম ও সূত্র (Rule & Formula)</h5>
                    <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border-left: 4px solid var(--primary-color); border-radius: 4px; margin-bottom: 12px;">
                        <p style="margin: 0; color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                            <strong>রুল:</strong> {{ $lesson->rule }}
                        </p>
                    </div>
                    @if($lesson->formula)
                        <div style="padding: 15px; background: rgba(99, 102, 241, 0.04); border: 1px dashed rgba(99, 102, 241, 0.25); border-radius: 8px;">
                            <p style="margin: 0; color: var(--primary-hover); font-family: 'Courier New', monospace; font-size: 0.95rem; line-height: 1.5;">
                                <strong>ফর্মুলা / স্ট্রাকচার:</strong> {{ $lesson->formula }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Recognition -->
                @if($lesson->recognition)
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">২. কীভাবে চিনবে (How to Identify)</h5>
                    <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border-radius: 8px;">
                        <p style="margin: 0; color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->recognition }}</p>
                    </div>
                </div>
                @endif

                <!-- Step-by-Step Directions -->
                @if($lesson->step_1 || $lesson->step_2 || $lesson->step_3)
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">৩. সমাধানের ধাপসমূহ (Step-by-Step Method)</h5>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        @if($lesson->step_1)
                        <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 8px;">
                            <span style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; display: inline-block; margin-bottom: 10px;">ধাপ ১ (Step 1)</span>
                            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->step_1 }}</p>
                        </div>
                        @endif
                        @if($lesson->step_2)
                        <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 8px;">
                            <span style="background: rgba(99, 102, 241, 0.1); color: var(--primary-hover); padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; display: inline-block; margin-bottom: 10px;">ধাপ ২ (Step 2)</span>
                            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->step_2 }}</p>
                        </div>
                        @endif
                        @if($lesson->step_3)
                        <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 8px;">
                            <span style="background: rgba(6, 182, 212, 0.1); color: var(--secondary-hover); padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; display: inline-block; margin-bottom: 10px;">ধাপ ৩ (Step 3)</span>
                            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->step_3 }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Examples & Common Mistakes -->
                @if($lesson->example || $lesson->common_mistake)
                <div style="margin-bottom: 30px;">
                    <h5 style="color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">৪. উদাহরণ ও সাধারণ ভুল (Examples & Mistakes)</h5>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                        @if($lesson->example)
                        <div style="padding: 15px; background: rgba(16, 185, 129, 0.02); border: 1px solid rgba(16, 185, 129, 0.15); border-radius: 8px;">
                            <div style="color: var(--success); font-weight: bold; font-size: 0.9rem; margin-bottom: 8px; display: flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif;">
                                <i class="material-icons-round" style="font-size: 1.1rem;">check_circle</i> সঠিক উদাহরণ (Example)
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{!! nl2br(e($lesson->example)) !!}</p>
                        </div>
                        @endif
                        @if($lesson->common_mistake)
                        <div style="padding: 15px; background: rgba(239, 68, 68, 0.02); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: 8px;">
                            <div style="color: var(--danger); font-weight: bold; font-size: 0.9rem; margin-bottom: 8px; display: flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif;">
                                <i class="material-icons-round" style="font-size: 1.1rem;">cancel</i> সাধারণ ভুল (Common mistake)
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin: 0; font-family: 'Hind Siliguri', sans-serif;">{!! nl2br(e($lesson->common_mistake)) !!}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Exam Answer Writing Pattern -->
                @if($lesson->exam_answer_pattern)
                <div>
                    <h5 style="color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">৫. পরীক্ষায় কীভাবে উত্তর লিখবে (Exam Answering Strategy)</h5>
                    <div style="padding: 15px; background: rgba(255, 255, 255, 0.02); border-left: 4px solid var(--success); border-radius: 4px;">
                        <p style="margin: 0; color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">{{ $lesson->exam_answer_pattern }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Quiz Section Column -->
        <div class="quiz-panel-column">
            <div class="glass p-4" style="position: sticky; top: 100px; z-index: 10;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; font-family: 'Hind Siliguri', sans-serif;">
                    <i class="material-icons-round" style="color: var(--secondary-hover);">quiz</i>
                    অনুশীলন কুইজ (Quiz)
                </h3>

                @if($lesson->exercises->isEmpty())
                    <p style="color: var(--text-muted); font-size: 0.85rem;">এই পাঠের জন্য কোনো অনুশীলন কুইজ পাওয়া হয়নি।</p>
                @else
                    <!-- Quiz Score Result Alert -->
                    <div id="quiz-result-alert" class="d-none" style="padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                        <h5 style="font-weight: bold; margin-bottom: 4px; font-family: 'Hind Siliguri', sans-serif;">কুইজের ফলাফল</h5>
                        <p id="quiz-result-text" style="margin: 0; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;"></p>
                    </div>

                    <form id="quiz-form" onsubmit="submitQuiz(event)">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            @foreach($lesson->exercises as $index => $exercise)
                                @php
                                    $savedAnswer = $submission && isset($submission->answers[$exercise->id]) ? $submission->answers[$exercise->id] : null;
                                @endphp
                                <div id="exercise-{{ $exercise->id }}" style="padding: 15px; background: rgba(0, 0, 0, 0.2); border: 1px solid var(--border-color); border-radius: 12px;">
                                    <p style="color: var(--primary-hover); font-weight: bold; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">প্রশ্ন {{ $index + 1 }}</p>
                                    <p style="color: #fff; font-size: 0.95rem; line-height: 1.5; margin-bottom: 12px;">{!! $exercise->question !!}</p>

                                    <!-- Multiple Choices -->
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach($exercise->options as $optionIdx => $option)
                                            <div class="custom-radio-wrapper" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: rgba(255, 255, 255, 0.01); border: 1px solid var(--border-color); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="radio" name="answers[{{ $exercise->id }}]" id="option-{{ $exercise->id }}-{{ $optionIdx }}" value="{{ $option }}" {{ $savedAnswer === $option ? 'checked' : '' }} {{ $submission ? 'disabled' : '' }} required style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--primary-color);">
                                                <label for="option-{{ $exercise->id }}-{{ $optionIdx }}" style="cursor: pointer; font-size: 0.9rem; color: var(--text-muted); margin: 0; width: 100%;">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Feedback & Explanation -->
                                    <div class="exercise-feedback d-none" id="feedback-{{ $exercise->id }}" style="margin-top: 15px; padding: 12px; background: rgba(0, 0, 0, 0.4); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem;">
                                        <div class="feedback-status" style="font-weight: bold; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif;"></div>
                                        <div class="explanation-text" style="color: var(--text-muted); line-height: 1.4;"></div>
                                    </div>
                                    
                                    @if($submission)
                                        <div class="pre-existing-feedback" style="margin-top: 15px; padding: 12px; background: rgba(0, 0, 0, 0.4); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem;">
                                            @php
                                                $isAnsCorrect = ($savedAnswer === $exercise->correct_answer);
                                            @endphp
                                            <div style="font-weight: bold; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; color: {{ $isAnsCorrect ? 'var(--success)' : 'var(--danger)' }};">
                                                <i class="material-icons-round" style="font-size: 1.1rem;">{{ $isAnsCorrect ? 'check_circle' : 'cancel' }}</i>
                                                {{ $isAnsCorrect ? 'সঠিক হয়েছে!' : 'ভুল হয়েছে। সঠিক উত্তর: ' . $exercise->correct_answer }}
                                            </div>
                                            <div style="color: var(--text-muted); line-height: 1.4;">{{ $exercise->explanation }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Action Buttons -->
                        <div style="margin-top: 25px;" id="form-actions-wrapper">
                            @if($submission)
                                <button type="button" class="btn btn-secondary w-100 py-3" onclick="resetQuiz()" style="font-family: 'Hind Siliguri', sans-serif; border-radius: 10px;">
                                    <i class="material-icons-round" style="font-size: 1.15rem;">refresh</i>
                                    <span>কুইজ পুনরায় দিন (Retake)</span>
                                </button>
                            @else
                                <button type="submit" id="submit-quiz-btn" class="btn btn-primary w-100 py-3" style="font-family: 'Hind Siliguri', sans-serif; border-radius: 10px;">
                                    <i class="material-icons-round" style="font-size: 1.15rem;">send</i>
                                    <span>উত্তর জমা দিন (Submit Quiz)</span>
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .show-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: start;
    }
    .custom-radio-wrapper:hover {
        background: rgba(255, 255, 255, 0.03) !important;
        border-color: var(--border-hover) !important;
    }
    .custom-radio-wrapper input[type="radio"]:checked + label {
        color: #fff !important;
        font-weight: 600;
    }
    @media (max-width: 1024px) {
        .show-layout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function submitQuiz(event) {
        event.preventDefault();
        
        const form = document.getElementById('quiz-form');
        const submitBtn = document.getElementById('submit-quiz-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="width: 1rem; height: 1rem; border-width: 0.15em; display: inline-block;"></span> Submitting...`;
        }

        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            if (key.startsWith('answers[')) {
                const match = key.match(/answers\[(\d+)\]/);
                if (match) {
                    data[match[1]] = value;
                }
            }
        });

        axios.post(`{{ route('grammar.quiz.submit', $lesson->id) }}`, {
            answers: data
        })
        .then(response => {
            const result = response.data;
            if (result.success) {
                // Show result alert
                const alertBox = document.getElementById('quiz-result-alert');
                const resultText = document.getElementById('quiz-result-text');
                alertBox.classList.remove('d-none');
                
                if (result.score >= 80) {
                    alertBox.className = '';
                    alertBox.style.background = 'rgba(16, 185, 129, 0.1)';
                    alertBox.style.color = 'var(--success)';
                    alertBox.style.border = '1px solid rgba(16, 185, 129, 0.2)';
                    resultText.innerHTML = `চমৎকার! আপনি কুইজে <strong>${result.score}%</strong> পেয়ে উত্তীর্ণ হয়েছেন (${result.correct_count}/${result.total}টি সঠিক)।`;
                } else {
                    alertBox.className = '';
                    alertBox.style.background = 'rgba(255, 193, 7, 0.1)';
                    alertBox.style.color = '#ffc107';
                    alertBox.style.border = '1px solid rgba(255, 193, 7, 0.2)';
                    resultText.innerHTML = `আপনি কুইজে <strong>${result.score}%</strong> পেয়েছেন (${result.correct_count}/${result.total}টি সঠিক)। একটু মনোযোগ দিয়ে আবার চেষ্টা করুন।`;
                }

                // Show top score badge
                const topScoreBadge = document.getElementById('top-score-badge');
                if (topScoreBadge) {
                    topScoreBadge.innerHTML = `<span style="background: rgba(16, 185, 129, 0.1); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                                    <i class="material-icons-round">check_circle</i>
                                                    <span>কুইজ সম্পন্ন (প্রাপ্ত স্কোর: ${Math.round(result.score)}%)</span>
                                                </span>`;
                }

                // Loop questions and show explanations
                for (const exerciseId in result.results) {
                    const exerciseResult = result.results[exerciseId];
                    const feedbackDiv = document.getElementById(`feedback-${exerciseId}`);
                    const statusText = feedbackDiv.querySelector('.feedback-status');
                    const explanationText = feedbackDiv.querySelector('.explanation-text');
                    
                    feedbackDiv.classList.remove('d-none');
                    explanationText.innerHTML = exerciseResult.explanation;
                    
                    if (exerciseResult.is_correct) {
                        statusText.style.color = 'var(--success)';
                        statusText.innerHTML = `<i class="material-icons-round" style="font-size: 1.1rem;">check_circle</i> সঠিক হয়েছে!`;
                    } else {
                        statusText.style.color = 'var(--danger)';
                        statusText.innerHTML = `<i class="material-icons-round" style="font-size: 1.1rem;">cancel</i> ভুল হয়েছে। সঠিক উত্তর: ${exerciseResult.correct}`;
                    }
                }

                // Disable inputs
                form.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.disabled = true;
                });

                // Update Action buttons
                const actionsWrapper = document.getElementById('form-actions-wrapper');
                actionsWrapper.innerHTML = `<button type="button" class="btn btn-secondary w-100 py-3" onclick="resetQuiz()" style="font-family: 'Hind Siliguri', sans-serif; border-radius: 10px;">
                                                <i class="material-icons-round" style="font-size: 1.15rem;">refresh</i>
                                                <span>কুইজ পুনরায় দিন (Retake)</span>
                                            </button>`;
            }
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong while submitting the quiz. Please try again.',
            });
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<i class="material-icons-round" style="font-size: 1.15rem;">send</i> <span>উত্তর জমা দিন (Submit Quiz)</span>`;
            }
        });
    }

    function resetQuiz() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will lose your current score and retake the quiz!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Yes, Retake it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Clear client feedback
                document.querySelectorAll('.exercise-feedback').forEach(div => {
                    div.classList.add('d-none');
                });
                
                const preFeedback = document.querySelectorAll('.pre-existing-feedback');
                preFeedback.forEach(div => {
                    div.remove();
                });

                // Uncheck radios and enable them
                const form = document.getElementById('quiz-form');
                form.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.checked = false;
                    radio.disabled = false;
                });

                // Hide result alert
                const alertBox = document.getElementById('quiz-result-alert');
                alertBox.classList.add('d-none');

                // Restore submit button
                const actionsWrapper = document.getElementById('form-actions-wrapper');
                actionsWrapper.innerHTML = `<button type="submit" id="submit-quiz-btn" class="btn btn-primary w-100 py-3" style="font-family: 'Hind Siliguri', sans-serif; border-radius: 10px;">
                                                <i class="material-icons-round" style="font-size: 1.15rem;">send</i>
                                                <span>উত্তর জমা দিন (Submit Quiz)</span>
                                            </button>`;
            }
        });
    }
</script>
@endsection
