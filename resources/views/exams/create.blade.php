<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam - সহজ কাজ</title>
    <!-- Basic Bootstrap for grid and forms -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- MathJax for rendering LaTeX/Math formulas -->
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            background: #090d16;
            color: #f8fafc;
        }

        .builder-fullscreen {
            display: flex;
            height: 100vh;
            width: 100vw;
        }
        
        .builder-sidebar {
            width: 450px;
            flex-shrink: 0;
            background: rgba(255,255,255,0.02);
            border-right: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
            z-index: 10;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,0,0,0.2);
        }

        .sidebar-content {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }
        
        .builder-preview {
            flex: 1;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"), #020617;
            padding: 40px 20px;
            overflow-y: auto;
            display: flex;
            justify-content: center;
        }

        .preview-paper {
            background: #fff;
            color: #000;
            width: 100%;
            max-width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            font-family: 'Times New Roman', Times, serif;
            position: relative;
        }

        .question-card {
            padding: 10px;
            margin-bottom: 15px;
            position: relative;
            border: 1px dashed transparent;
            transition: all 0.2s;
        }
        
        .question-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .action-btns {
            position: absolute;
            right: 0;
            top: 0;
            display: none;
            gap: 5px;
        }

        .question-card:hover .action-btns {
            display: flex;
        }

        .btn-action {
            background: #e2e8f0;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #475569;
            transition: 0.2s;
        }
        
        .btn-action:hover { background: #3b82f6; color: #fff; }
        .btn-action.delete:hover { background: #ef4444; color: #fff; }

        /* Form styling */
        .form-label { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin-bottom: 5px; font-weight: 500; }
        .form-control, .form-select { 
            background: rgba(255,255,255,0.03); 
            border: 1px solid rgba(255,255,255,0.1); 
            color: #fff; 
            font-size: 0.95rem;
            padding: 10px;
        }
        .form-control:focus, .form-select:focus { 
            background: rgba(0,0,0,0.3); 
            border-color: #818cf8; 
            color: #fff; 
            box-shadow: 0 0 0 0.2rem rgba(129, 140, 248, 0.25); 
        }
        .form-control::placeholder { color: rgba(255,255,255,0.2); }
        .form-select option { background: #1e293b; color: #fff; }

        .btn-gradient {
            background: linear-gradient(135deg, #8b5cf6, #d946ef);
            color: #fff;
            border: none;
            font-weight: 600;
        }
        .btn-gradient:hover { background: linear-gradient(135deg, #7c3aed, #c026d3); color: #fff; }
        
        .btn-save {
            background: linear-gradient(135deg, #10b981, #059669);
            color:#fff; 
            border:none; 
            padding: 12px; 
            font-weight: bold; 
            font-size: 1.1rem; 
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-save:hover { background: linear-gradient(135deg, #059669, #047857); color: #fff; }

        /* Custom Scrollbar for Sidebar */
        .sidebar-content::-webkit-scrollbar { width: 6px; }
        .sidebar-content::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
        .sidebar-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    </style>
</head>
<body>

<div class="builder-fullscreen">
    <!-- Sidebar / Inputs -->
    <div class="builder-sidebar">
        <div class="sidebar-header">
            <h5 style="margin: 0; color: #fff; font-weight: bold; display: flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="color: #3b82f6;">edit_document</i> 
                {{ strtoupper($type) }} Exam Builder
            </h5>
            <a href="{{ route('exams.index') }}" class="btn btn-sm btn-outline-light" style="border-color: rgba(255,255,255,0.2); padding: 4px 10px;">
                <i class="material-icons-round" style="font-size: 16px; vertical-align: text-bottom;">close</i> Close
            </a>
        </div>
        
        <div class="sidebar-content">
            <div class="form-group mb-3">
                <label class="form-label">Exam Title</label>
                <input type="text" id="paper_title" class="form-control" value="Final Examination" oninput="updateSheetHeader()">
            </div>
            
            <div class="row mb-3 g-2">
                <div class="col-6">
                    <label class="form-label">Class</label>
                    <input type="text" id="paper_class" class="form-control" value="Class 10" oninput="updateSheetHeader()">
                </div>
                <div class="col-6">
                    <label class="form-label">Subject</label>
                    <input type="text" id="paper_subject" class="form-control" value="Higher Math" oninput="updateSheetHeader()">
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label class="form-label">Duration (Minutes)</label>
                <input type="number" id="paper_duration" class="form-control" value="60" oninput="updateSheetHeader()">
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 0 0 20px 0;">

            <div id="editor-fields">
                @if ($type == 'mcq')
                    <h6 class="text-white mb-3 d-flex align-items-center gap-2">
                        <i class="material-icons-round" style="font-size: 18px; color: #8b5cf6;">add_circle</i>
                        <span id="form_title">Add MCQ Question</span>
                    </h6>
                    <div class="form-group mb-3">
                        <label class="form-label">Question (MathJax: $x^2 = 4$)</label>
                        <textarea id="mcq_question" class="form-control" rows="3" placeholder="Enter question here..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <input type="text" id="opt_a" class="form-control" placeholder="Option A">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_b" class="form-control" placeholder="Option B">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_c" class="form-control" placeholder="Option C">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_d" class="form-control" placeholder="Option D">
                        </div>
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label">Correct Answer</label>
                            <select id="mcq_correct" class="form-select">
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Marks</label>
                            <input type="number" id="mcq_marks" class="form-control" value="1">
                        </div>
                    </div>
                    <input type="hidden" id="edit_index" value="-1">
                    <div class="d-flex gap-2">
                        <button onclick="saveOrUpdateMcqQuestion()" class="btn btn-gradient w-100" id="btn_save_q">
                            + Add Question
                        </button>
                        <button onclick="cancelEdit()" class="btn btn-secondary" id="btn_cancel_q" style="display: none;">
                            Cancel
                        </button>
                    </div>
                @else
                    <h6 class="text-white mb-3 d-flex align-items-center gap-2">
                        <i class="material-icons-round" style="font-size: 18px; color: #ec4899;">add_circle</i>
                        <span id="form_title">Add CQ Question</span>
                    </h6>
                    <div class="form-group mb-3">
                        <label class="form-label">Stem (Stimulus) (Supports MathJax)</label>
                        <textarea id="cq_stem" class="form-control" rows="4" placeholder="Enter stem context here..."></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_a" class="form-control" placeholder="a) Knowledge based (1 mark)">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_b" class="form-control" placeholder="b) Comprehension based (2 marks)">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_c" class="form-control" placeholder="c) Application based (3 marks)">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" id="cq_d" class="form-control" placeholder="d) Higher Order based (4 marks)">
                    </div>
                    <input type="hidden" id="edit_index" value="-1">
                    <div class="d-flex gap-2">
                        <button onclick="saveOrUpdateCqQuestion()" class="btn btn-gradient w-100" id="btn_save_q" style="background: linear-gradient(135deg, #ec4899, #be185d);">
                            + Add Question
                        </button>
                        <button onclick="cancelEdit()" class="btn btn-secondary" id="btn_cancel_q" style="display: none;">
                            Cancel
                        </button>
                    </div>
                @endif
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 25px 0;">
            
            <button onclick="saveExam()" class="btn w-100 btn-save">
                <i class="material-icons-round" style="font-size: 18px; vertical-align: text-bottom;">cloud_upload</i> Save Exam & Publish
            </button>
        </div>
    </div>

    <!-- Preview Area -->
    <div class="builder-preview">
        <div class="preview-paper">
            <div style="text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #000;">
                <h2 id="view_title" style="font-weight: bold; margin: 0 0 5px 0; font-size: 1.8rem;">Final Examination</h2>
                <h4 id="view_subject" style="font-weight: normal; margin: 0 0 10px 0; font-size: 1.2rem;">Higher Math</h4>
                <div style="display: flex; justify-content: space-between; font-size: 1rem; font-weight: bold;">
                    <div>Class: <span id="view_class">Class 10</span></div>
                    <div>Time: <span id="view_duration">60</span> minutes</div>
                    <div>Total Marks: <span id="view_marks">0</span></div>
                </div>
            </div>

            <div id="questions-list-area" style="font-size: 1.1rem; line-height: 1.5;">
                <!-- Questions injected via JS -->
                <div class="text-center" style="color: #9ca3af; padding: 100px 0;" id="empty-state">
                    <i class="material-icons-round" style="font-size: 4rem; opacity: 0.5;">assignment</i>
                    <h5 class="mt-3">Paper is Empty</h5>
                    <p style="font-size: 0.9rem;">Add questions from the sidebar to build your exam paper.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let questions = [];
    let totalMarks = 0;

    function updateSheetHeader() {
        document.getElementById('view_title').innerText = document.getElementById('paper_title').value || 'Final Examination';
        document.getElementById('view_subject').innerText = document.getElementById('paper_subject').value || 'Subject';
        document.getElementById('view_class').innerText = document.getElementById('paper_class').value || 'Class';
        document.getElementById('view_duration').innerText = document.getElementById('paper_duration').value || '60';
    }

    function saveOrUpdateMcqQuestion() {
        const text = document.getElementById('mcq_question').value;
        const a = document.getElementById('opt_a').value;
        const b = document.getElementById('opt_b').value;
        const c = document.getElementById('opt_c').value;
        const d = document.getElementById('opt_d').value;
        const correct_answer = document.getElementById('mcq_correct').value;
        const marks = parseFloat(document.getElementById('mcq_marks').value) || 1;
        const editIndex = parseInt(document.getElementById('edit_index').value);

        if(!text || !a || !b || !c || !d) {
            alert('Please fill out the question and all options.');
            return;
        }

        const qData = { text, options: { a, b, c, d }, correct_answer, marks };

        if (editIndex >= 0) {
            questions[editIndex] = qData; // Update existing
        } else {
            questions.push(qData); // Add new
        }

        cancelEdit();
        renderQuestions();
    }

    function saveOrUpdateCqQuestion() {
        const stem = document.getElementById('cq_stem').value;
        const a = document.getElementById('cq_a').value;
        const b = document.getElementById('cq_b').value;
        const c = document.getElementById('cq_c').value;
        const d = document.getElementById('cq_d').value;
        const marks = 10; 
        const editIndex = parseInt(document.getElementById('edit_index').value);

        if(!stem || !a || !b || !c || !d) {
            alert('Please fill out the stem and all 4 questions.');
            return;
        }

        const qData = { stem, a, b, c, d, marks };

        if (editIndex >= 0) {
            questions[editIndex] = qData;
        } else {
            questions.push(qData);
        }

        cancelEdit();
        renderQuestions();
    }

    function editQuestion(index) {
        const q = questions[index];
        document.getElementById('edit_index').value = index;
        document.getElementById('form_title').innerText = 'Edit Question';
        document.getElementById('btn_save_q').innerText = 'Update Question';
        document.getElementById('btn_cancel_q').style.display = 'block';

        if ('options' in q) {
            // MCQ
            document.getElementById('mcq_question').value = q.text;
            document.getElementById('opt_a').value = q.options.a;
            document.getElementById('opt_b').value = q.options.b;
            document.getElementById('opt_c').value = q.options.c;
            document.getElementById('opt_d').value = q.options.d;
            document.getElementById('mcq_correct').value = q.correct_answer;
            document.getElementById('mcq_marks').value = q.marks;
        } else {
            // CQ
            document.getElementById('cq_stem').value = q.stem;
            document.getElementById('cq_a').value = q.a;
            document.getElementById('cq_b').value = q.b;
            document.getElementById('cq_c').value = q.c;
            document.getElementById('cq_d').value = q.d;
        }
    }

    function cancelEdit() {
        document.getElementById('edit_index').value = '-1';
        document.getElementById('form_title').innerText = 'Add New Question';
        document.getElementById('btn_save_q').innerHTML = '+ Add Question';
        document.getElementById('btn_cancel_q').style.display = 'none';

        // Clear form
        if (document.getElementById('mcq_question')) {
            document.getElementById('mcq_question').value = '';
            document.getElementById('opt_a').value = '';
            document.getElementById('opt_b').value = '';
            document.getElementById('opt_c').value = '';
            document.getElementById('opt_d').value = '';
            document.getElementById('mcq_marks').value = '1';
        } else {
            document.getElementById('cq_stem').value = '';
            document.getElementById('cq_a').value = '';
            document.getElementById('cq_b').value = '';
            document.getElementById('cq_c').value = '';
            document.getElementById('cq_d').value = '';
        }
    }

    function removeQuestion(index) {
        if(confirm('Are you sure you want to remove this question?')) {
            questions.splice(index, 1);
            if(document.getElementById('edit_index').value == index) {
                cancelEdit();
            }
            renderQuestions();
        }
    }

    function renderQuestions() {
        const area = document.getElementById('questions-list-area');
        area.innerHTML = '';
        totalMarks = 0;

        if (questions.length === 0) {
            area.innerHTML = `
            <div class="text-center" style="color: #9ca3af; padding: 100px 0;">
                <i class="material-icons-round" style="font-size: 4rem; opacity: 0.5;">assignment</i>
                <h5 class="mt-3">Paper is Empty</h5>
                <p style="font-size: 0.9rem;">Add questions from the sidebar to build your exam paper.</p>
            </div>`;
            document.getElementById('view_marks').innerText = totalMarks;
            return;
        }

        questions.forEach((q, idx) => {
            totalMarks += q.marks;
            const wrapper = document.createElement('div');
            wrapper.className = 'question-card';

            // Action Buttons
            const actions = document.createElement('div');
            actions.className = 'action-btns no-print';

            const editBtn = document.createElement('button');
            editBtn.className = 'btn-action';
            editBtn.innerHTML = '<i class="material-icons-round" style="font-size: 16px;">edit</i>';
            editBtn.title = 'Edit';
            editBtn.onclick = () => editQuestion(idx);

            const delBtn = document.createElement('button');
            delBtn.className = 'btn-action delete';
            delBtn.innerHTML = '<i class="material-icons-round" style="font-size: 16px;">delete</i>';
            delBtn.title = 'Delete';
            delBtn.onclick = () => removeQuestion(idx);

            actions.appendChild(editBtn);
            actions.appendChild(delBtn);
            wrapper.appendChild(actions);

            if ('options' in q) {
                // MCQ
                const mcqHtml = `
                    <div style="margin-bottom: 10px; padding-right: 70px;">
                        <strong>${idx + 1}.</strong> ${q.text} <span style="float: right;">[${q.marks}]</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                        <div>a) ${q.options.a}</div>
                        <div>b) ${q.options.b}</div>
                        <div>c) ${q.options.c}</div>
                        <div>d) ${q.options.d}</div>
                    </div>
                `;
                wrapper.innerHTML += mcqHtml;
            } else {
                // CQ
                const cqHtml = `
                    <div style="margin-bottom: 10px; padding-right: 70px; text-align: justify;">
                        <strong>${idx + 1}.</strong> ${q.stem} <span style="float: right;">[${q.marks}]</span>
                    </div>
                    <div style="padding-left: 20px;">
                        <div>a) ${q.a} <span style="float: right;">(1)</span></div>
                        <div>b) ${q.b} <span style="float: right;">(2)</span></div>
                        <div>c) ${q.c} <span style="float: right;">(3)</span></div>
                        <div>d) ${q.d} <span style="float: right;">(4)</span></div>
                    </div>
                `;
                wrapper.innerHTML += cqHtml;
            }

            area.appendChild(wrapper);
        });

        document.getElementById('view_marks').innerText = totalMarks;

        // MathJax re-render
        if (typeof MathJax !== 'undefined') {
            MathJax.typesetPromise();
        }
    }

    function saveExam() {
        if (questions.length === 0) {
            alert('Please add at least one question to the exam.');
            return;
        }

        const title = document.getElementById('paper_title').value;
        const subject = document.getElementById('paper_subject').value;
        const className = document.getElementById('paper_class').value;
        const duration = document.getElementById('paper_duration').value;
        const type = '{{ $type }}';

        fetch('{{ route("exams.store") }}', {
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
                duration_minutes: duration,
                questions: JSON.stringify(questions)
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                window.location.href = data.redirect;
            } else {
                alert('An error occurred while saving.');
            }
        })
        .catch(err => {
            alert('Server error.');
        });
    }
</script>

<style>
    @media print {
        .builder-sidebar { display: none !important; }
        .no-print { display: none !important; }
        body { background: #fff !important; }
        .builder-preview { padding: 0 !important; background: #fff !important; }
        .preview-paper { box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
        .question-card { border: none !important; margin-bottom: 20px !important; }
    }
</style>

</body>
</html>
