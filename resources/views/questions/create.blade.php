@extends('layouts.app')

@section('title', 'প্রশ্নপত্র তৈরি - সহজ কাজ')

@section('content')
<!-- MathJax for rendering LaTeX/Math formulas -->
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<style>
    .builder-container {
        display: flex;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .builder-sidebar {
        width: 400px;
        flex-shrink: 0;
    }
    
    .builder-preview {
        flex: 1;
        background: #e5e7eb;
        padding: 40px 20px;
        border-radius: 8px;
        overflow-y: auto;
        max-height: calc(100vh - 150px);
        display: flex;
        justify-content: center;
    }

    .question-sheet {
        background: #fff;
        color: #000;
        width: 100%;
        max-width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        font-family: 'Times New Roman', Times, serif;
    }
</style>

<div class="builder-container">
    <!-- Sidebar / Inputs -->
    <div class="builder-sidebar">
        <div class="glass" style="padding: 25px; position: sticky; top: 20px; max-height: calc(100vh - 80px); overflow-y: auto;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">
                {{ strtoupper($type) }} প্রশ্ন মেকার
            </h3>
            
            <div class="form-group">
                <label class="form-label">পরীক্ষার নাম / শিরোনাম</label>
                <input type="text" id="paper_title" class="form-control" value="বার্ষিক পরীক্ষা" oninput="updateSheetHeader()">
            </div>
            <div class="form-group" style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label class="form-label">শ্রেণী</label>
                    <input type="text" id="paper_class" class="form-control" value="দশম" oninput="updateSheetHeader()">
                </div>
                <div style="flex: 1;">
                    <label class="form-label">বিষয়</label>
                    <input type="text" id="paper_subject" class="form-control" value="উচ্চতর গণিত" oninput="updateSheetHeader()">
                </div>
            </div>

            <hr style="border-color: var(--border-color); margin: 20px 0;">

            <div id="editor-fields">
                @if ($type == 'mcq')
                    <h4>নতুন MCQ প্রশ্ন যোগ করুন</h4>
                    <div class="form-group">
                        <label class="form-label">প্রশ্ন (LaTeX সমর্থন করে, যেমন: $x^2 + y^2 = r^2$)</label>
                        <textarea id="mcq_question" class="form-control" rows="3" placeholder="প্রশ্ন লিখুন..."></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                        <input type="text" id="opt_a" class="form-control" placeholder="ক)">
                        <input type="text" id="opt_b" class="form-control" placeholder="খ)">
                        <input type="text" id="opt_c" class="form-control" placeholder="গ)">
                        <input type="text" id="opt_d" class="form-control" placeholder="ঘ)">
                    </div>
                    <button onclick="addMcqQuestion()" class="btn btn-primary" style="width: 100%;">প্রশ্ন যোগ করুন</button>
                @else
                    <h4>নতুন CQ (সৃজনশীল) প্রশ্ন যোগ করুন</h4>
                    <div class="form-group">
                        <label class="form-label">উদ্দীপক (Stem)</label>
                        <textarea id="cq_stem" class="form-control" rows="4" placeholder="উদ্দীপক লিখুন..."></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" id="cq_a" class="form-control" placeholder="ক) প্রশ্ন (১ নম্বর)">
                    </div>
                    <div class="form-group">
                        <input type="text" id="cq_b" class="form-control" placeholder="খ) প্রশ্ন (২ নম্বর)">
                    </div>
                    <div class="form-group">
                        <input type="text" id="cq_c" class="form-control" placeholder="গ) প্রশ্ন (৩ নম্বর)">
                    </div>
                    <div class="form-group">
                        <input type="text" id="cq_d" class="form-control" placeholder="ঘ) প্রশ্ন (৪ নম্বর)">
                    </div>
                    <button onclick="addCqQuestion()" class="btn btn-primary" style="width: 100%;">প্রশ্ন যোগ করুন</button>
                @endif
            </div>

            <hr style="border-color: var(--border-color); margin: 20px 0;">
            
            <button onclick="saveQuestionPaper()" class="btn" style="width: 100%; background: #10b981; color:#fff;">
                ডাটাবেসে সেভ করুন
            </button>
        </div>
    </div>

    <!-- Preview Area / Exam Sheet -->
    <div class="builder-preview">
        <div id="print-sheet" class="question-sheet">
            <!-- Header Info -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 id="view_title" style="margin: 0; font-size: 1.6rem; font-weight: bold;">বার্ষিক পরীক্ষা</h2>
                <h4 style="margin: 5px 0; font-weight: normal;">বিষয়: <span id="view_subject">উচ্চতর গণিত</span></h4>
                <div style="display: flex; justify-content: space-between; font-size: 0.95rem; margin-top: 15px; border-bottom: 2px solid #000; padding-bottom: 5px;">
                    <div>শ্রেণী: <span id="view_class">দশম</span></div>
                    <div>সময়: ২ ঘণ্টা ৩০ মিনিট</div>
                    <div>পূর্ণমান: ১০০</div>
                </div>
            </div>

            <!-- Questions Area -->
            <div id="questions-list-area" style="line-height: 1.6; font-size: 1.05rem;">
                <!-- Injected via JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
    let questions = [];

    function updateSheetHeader() {
        document.getElementById('view_title').innerText = document.getElementById('paper_title').value || 'বার্ষিক পরীক্ষা';
        document.getElementById('view_subject').innerText = document.getElementById('paper_subject').value || 'বিষয়';
        document.getElementById('view_class').innerText = document.getElementById('paper_class').value || 'শ্রেণী';
    }

    function addMcqQuestion() {
        const text = document.getElementById('mcq_question').value;
        const a = document.getElementById('opt_a').value;
        const b = document.getElementById('opt_b').value;
        const c = document.getElementById('opt_c').value;
        const d = document.getElementById('opt_d').value;

        if(!text || !a || !b || !c || !d) {
            alert('দয়া করে প্রশ্ন ও ৪টি অপশনই পূরণ করুন।');
            return;
        }

        questions.push({ text, options: { a, b, c, d } });

        // Reset
        document.getElementById('mcq_question').value = '';
        document.getElementById('opt_a').value = '';
        document.getElementById('opt_b').value = '';
        document.getElementById('opt_c').value = '';
        document.getElementById('opt_d').value = '';

        renderQuestions();
    }

    function addCqQuestion() {
        const stem = document.getElementById('cq_stem').value;
        const a = document.getElementById('cq_a').value;
        const b = document.getElementById('cq_b').value;
        const c = document.getElementById('cq_c').value;
        const d = document.getElementById('cq_d').value;

        if(!stem || !a || !b || !c || !d) {
            alert('দয়া করে উদ্দীপক এবং ক, খ, গ, ঘ সব প্রশ্ন পূরণ করুন।');
            return;
        }

        questions.push({ stem, a, b, c, d });

        // Reset
        document.getElementById('cq_stem').value = '';
        document.getElementById('cq_a').value = '';
        document.getElementById('cq_b').value = '';
        document.getElementById('cq_c').value = '';
        document.getElementById('cq_d').value = '';

        renderQuestions();
    }

    function removeQuestion(index) {
        questions.splice(index, 1);
        renderQuestions();
    }

    function renderQuestions() {
        const area = document.getElementById('questions-list-area');
        area.innerHTML = '';

        questions.forEach((q, idx) => {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.marginBottom = '25px';

            // Delete control (hidden in print)
            const delBtn = document.createElement('button');
            delBtn.innerText = 'মুছুন';
            delBtn.style.position = 'absolute';
            delBtn.style.right = '-60px';
            delBtn.style.top = '0';
            delBtn.style.background = '#ef4444';
            delBtn.style.color = '#fff';
            delBtn.style.border = 'none';
            delBtn.style.padding = '4px 8px';
            delBtn.style.borderRadius = '4px';
            delBtn.style.cursor = 'pointer';
            delBtn.className = 'no-print';
            delBtn.onclick = () => removeQuestion(idx);
            wrapper.appendChild(delBtn);

            if ('options' in q) {
                // MCQ
                const mcqHtml = `
                    <div><strong>${idx + 1}. ${q.text}</strong></div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; margin-left: 15px; margin-top: 5px;">
                        <div>ক) ${q.options.a}</div>
                        <div>খ) ${q.options.b}</div>
                        <div>গ) ${q.options.c}</div>
                        <div>ঘ) ${q.options.d}</div>
                    </div>
                `;
                wrapper.innerHTML += mcqHtml;
            } else {
                // CQ
                const cqHtml = `
                    <div style="text-align: justify; margin-bottom: 10px;"><strong>${idx + 1}. ${q.stem}</strong></div>
                    <div style="margin-left: 20px;">
                        <div>ক) ${q.a} <span style="float: right;">১</span></div>
                        <div>খ) ${q.b} <span style="float: right;">২</span></div>
                        <div>গ) ${q.c} <span style="float: right;">৩</span></div>
                        <div>ঘ) ${q.d} <span style="float: right;">৪</span></div>
                    </div>
                    <div style="clear: both;"></div>
                `;
                wrapper.innerHTML += cqHtml;
            }

            area.appendChild(wrapper);
        });

        // Trigger MathJax re-render to format equations
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise();
        }
    }

    function saveQuestionPaper() {
        if (questions.length === 0) {
            alert('প্রশ্নপত্র ফাঁকা! প্রথমে প্রশ্ন যোগ করুন।');
            return;
        }

        const title = document.getElementById('paper_title').value;
        const subject = document.getElementById('paper_subject').value;
        const className = document.getElementById('paper_class').value;
        const type = '{{ $type }}';

        fetch('{{ route("questions.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: title,
                subject: subject,
                class: className,
                type: type,
                content: JSON.stringify(questions)
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('প্রশ্নপত্র সফলভাবে সেভ করা হয়েছে!');
                window.location.href = data.redirect;
            } else {
                alert('সেভ করার সময় কোনো সমস্যা হয়েছে।');
            }
        })
        .catch(err => {
            alert('সার্ভার ত্রুটি ঘটেছে।');
        });
    }
</script>

<style>
    @media print {
        .builder-sidebar { display: none !important; }
        .no-print { display: none !important; }
        body * { visibility: hidden; }
        #print-sheet, #print-sheet * { visibility: visible; }
        #print-sheet {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            padding: 0;
        }
        .navbar { display: none !important; }
    }
</style>
@endsection
