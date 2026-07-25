<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রশ্নপত্র তৈরি - সহজ কাজ</title>
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
            background: #0f172a; /* Dark background */
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
            background: #1e293b;
            border-right: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            z-index: 10;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,0,0,0.1);
        }

        .sidebar-content {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }
        
        .builder-preview {
            flex: 1;
            background: #020617; /* darker background for preview area */
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
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
            background: rgba(0,0,0,0.2); 
            border: 1px solid rgba(255,255,255,0.1); 
            color: #fff; 
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus { 
            background: rgba(0,0,0,0.3); 
            border-color: #3b82f6; 
            color: #fff; 
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); 
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }

        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            font-weight: 600;
        }
        .btn-gradient:hover { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; }
        
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
                {{ strtoupper($type) }} প্রশ্ন মেকার
            </h5>
            <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-light" style="border-color: rgba(255,255,255,0.2); padding: 4px 10px;">
                <i class="material-icons-round" style="font-size: 16px; vertical-align: text-bottom;">close</i> বন্ধ করুন
            </a>
        </div>
        
        <div class="sidebar-content">
            <div class="form-group mb-2">
                <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">স্কুলের / প্রতিষ্ঠানের নাম</label>
                <input type="text" id="paper_school" class="form-control" value="স্কুলের / প্রতিষ্ঠানের নাম" placeholder="স্কুলের নাম লিখুন..." oninput="updateSheetHeader()">
            </div>

            <div class="form-group mb-2">
                <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">ঠিকানা / স্থান</label>
                <input type="text" id="paper_address" class="form-control" value="ঠিকানা / স্থান" placeholder="ঠিকানা লিখুন..." oninput="updateSheetHeader()">
            </div>

            <div class="form-group mb-2">
                <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">পরীক্ষার নাম / শিরোনাম</label>
                <input type="text" id="paper_title" class="form-control" value="বার্ষিক পরীক্ষা" placeholder="পরীক্ষার নাম লিখুন..." oninput="updateSheetHeader()">
            </div>
            
            <div class="row mb-2 g-2">
                <div class="col-6">
                    <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">শ্রেণী</label>
                    <input type="text" id="paper_class" class="form-control" value="দশম" placeholder="শ্রেণী..." oninput="updateSheetHeader()">
                </div>
                <div class="col-6">
                    <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">বিষয়</label>
                    <input type="text" id="paper_subject" class="form-control" value="সাধারণ গণিত" placeholder="বিষয়..." oninput="updateSheetHeader()">
                </div>
            </div>

            <div class="row mb-4 g-2">
                <div class="col-6">
                    <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">সময়</label>
                    <input type="text" id="paper_time" class="form-control" value="৩ ঘণ্টা" placeholder="সময়..." oninput="updateSheetHeader()">
                </div>
                <div class="col-6">
                    <label class="form-label" style="font-size: 0.85rem; color: #93c5fd;">পূর্ণমান / মার্ক</label>
                    <input type="text" id="paper_marks" class="form-control" value="৫০" placeholder="মার্ক..." oninput="updateSheetHeader()">
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 0 0 20px 0;">

            <div id="editor-fields">
                <input type="hidden" id="edit_index" value="-1">
                @if ($type == 'mcq')
                    <h6 class="text-white mb-3 d-flex align-items-center gap-2">
                        <i class="material-icons-round" style="font-size: 18px; color: #8b5cf6;">add_circle</i>
                        <span id="form_title">নতুন MCQ প্রশ্ন যোগ করুন</span>
                    </h6>
                    <div class="form-group mb-3">
                        <label class="form-label">প্রশ্ন (LaTeX সমর্থন করে, যেমন: $x^2 + y^2 = r^2$)</label>
                        <textarea id="mcq_question" class="form-control" rows="2" placeholder="প্রশ্ন লিখুন..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <input type="text" id="opt_a" class="form-control" placeholder="ক)">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_b" class="form-control" placeholder="খ)">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_c" class="form-control" placeholder="গ)">
                        </div>
                        <div class="col-6">
                            <input type="text" id="opt_d" class="form-control" placeholder="ঘ)">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="saveOrUpdateMcqQuestion()" class="btn btn-gradient w-100" id="btn_save_q">
                            + প্রশ্ন যোগ করুন
                        </button>
                        <button onclick="cancelEdit()" class="btn btn-secondary" id="btn_cancel_q" style="display: none;">
                            বাতিল করুন
                        </button>
                    </div>
                @else
                    <h6 class="text-white mb-3 d-flex align-items-center gap-2">
                        <i class="material-icons-round" style="font-size: 18px; color: #ec4899;">add_circle</i>
                        <span id="form_title">নতুন সৃজনশীল প্রশ্ন যোগ করুন</span>
                    </h6>
                    <div class="form-group mb-3">
                        <label class="form-label">উদ্দীপক (Stem)</label>
                        <textarea id="cq_stem" class="form-control" rows="3" placeholder="উদ্দীপক লিখুন..."></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_a" class="form-control" placeholder="ক) জ্ঞানমূলক (মান ১)">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_b" class="form-control" placeholder="খ) অনুধাবনমূলক (মান ২)">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" id="cq_c" class="form-control" placeholder="গ) প্রয়োগমূলক (মান ৩)">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" id="cq_d" class="form-control" placeholder="ঘ) উচ্চতর দক্ষতা (মান ৪)">
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="saveOrUpdateCqQuestion()" class="btn btn-gradient w-100" id="btn_save_q" style="background: linear-gradient(135deg, #ec4899, #be185d);">
                            + প্রশ্ন যোগ করুন
                        </button>
                        <button onclick="cancelEdit()" class="btn btn-secondary" id="btn_cancel_q" style="display: none;">
                            বাতিল করুন
                        </button>
                    </div>
                @endif
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 25px 0;">
            
            <button onclick="saveQuestionPaper()" class="btn w-100 btn-save">
                <i class="material-icons-round" style="font-size: 18px; vertical-align: text-bottom;">cloud_upload</i> ডাটাবেসে সেভ করুন
            </button>
        </div>
    </div>

    <!-- Preview Area -->
    <div class="builder-preview">
        <div class="preview-paper">
            <div style="text-align: center; margin-bottom: 25px; font-family: 'Kalpurush', 'Siyam Rupali', 'SolaimanLipi', Arial, sans-serif;">
                <h1 id="view_school" style="font-weight: 800; margin: 0 0 5px 0; font-size: 26px; color: #000; letter-spacing: 0.5px;">স্কুলের / প্রতিষ্ঠানের নাম</h1>
                <h3 id="view_address" style="font-weight: 600; margin: 0 0 6px 0; font-size: 17px; color: #111;">ঠিকানা / স্থান</h3>
                <h2 id="view_title" style="font-weight: 700; margin: 0 0 6px 0; font-size: 20px; color: #000;">বার্ষিক পরীক্ষা</h2>
                <h4 style="font-weight: 700; margin: 0 0 15px 0; font-size: 17px; color: #000;">শ্রেণী : <span id="view_class">দশম</span> &nbsp;&nbsp;&nbsp;&nbsp; বিষয়: <span id="view_subject">সাধারণ গণিত</span></h4>
                
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 16px; font-weight: 700; color: #000; margin-top: 10px; border-bottom: 1.5px solid #000; padding-bottom: 8px;">
                    <div>সময়: <span id="view_time">৩ ঘণ্টা</span></div>
                    <div>মার্ক <span id="view_marks">৫০</span></div>
                </div>
            </div>

            <div id="questions-list-area" style="font-size: 1.1rem; line-height: 1.5;">
                <!-- Questions injected via JS -->
                <div class="text-center" style="color: #9ca3af; padding: 100px 0;" id="empty-state">
                    <i class="material-icons-round" style="font-size: 4rem; opacity: 0.5;">assignment</i>
                    <h5 class="mt-3">প্রশ্নপত্র ফাঁকা</h5>
                    <p style="font-size: 0.9rem;">বাম পাশের প্যানেল থেকে প্রশ্ন যোগ করুন।</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let questions = [];

    function updateSheetHeader() {
        document.getElementById('view_school').innerText = document.getElementById('paper_school').value || 'স্কুলের / প্রতিষ্ঠানের নাম';
        document.getElementById('view_address').innerText = document.getElementById('paper_address').value || 'ঠিকানা / স্থান';
        document.getElementById('view_title').innerText = document.getElementById('paper_title').value || 'বার্ষিক পরীক্ষা';
        document.getElementById('view_class').innerText = document.getElementById('paper_class').value || 'দশম';
        document.getElementById('view_subject').innerText = document.getElementById('paper_subject').value || 'সাধারণ গণিত';
        document.getElementById('view_time').innerText = document.getElementById('paper_time').value || '৩ ঘণ্টা';
        document.getElementById('view_marks').innerText = document.getElementById('paper_marks').value || '৫০';
    }

    function saveOrUpdateMcqQuestion() {
        const text = document.getElementById('mcq_question').value;
        const a = document.getElementById('opt_a').value;
        const b = document.getElementById('opt_b').value;
        const c = document.getElementById('opt_c').value;
        const d = document.getElementById('opt_d').value;
        const editIndex = parseInt(document.getElementById('edit_index').value);

        if(!text || !a || !b || !c || !d) {
            Swal.fire('দয়া করে প্রশ্ন ও ৪টি অপশনই পূরণ করুন।');
            return;
        }

        const qData = { text, options: { a, b, c, d } };

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
        const editIndex = parseInt(document.getElementById('edit_index').value);

        if(!stem || !a || !b || !c || !d) {
            Swal.fire('দয়া করে উদ্দীপক এবং ক, খ, গ, ঘ সব প্রশ্ন পূরণ করুন।');
            return;
        }

        const qData = { stem, a, b, c, d };

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
        document.getElementById('form_title').innerText = 'প্রশ্ন আপডেট করুন';
        document.getElementById('btn_save_q').innerText = 'আপডেট করুন';
        document.getElementById('btn_cancel_q').style.display = 'block';

        if ('options' in q) {
            // MCQ
            document.getElementById('mcq_question').value = q.text;
            document.getElementById('opt_a').value = q.options.a;
            document.getElementById('opt_b').value = q.options.b;
            document.getElementById('opt_c').value = q.options.c;
            document.getElementById('opt_d').value = q.options.d;
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
        document.getElementById('form_title').innerText = 'নতুন প্রশ্ন যোগ করুন';
        document.getElementById('btn_save_q').innerHTML = '+ প্রশ্ন যোগ করুন';
        document.getElementById('btn_cancel_q').style.display = 'none';

        // Clear form
        if (document.getElementById('mcq_question')) {
            document.getElementById('mcq_question').value = '';
            document.getElementById('opt_a').value = '';
            document.getElementById('opt_b').value = '';
            document.getElementById('opt_c').value = '';
            document.getElementById('opt_d').value = '';
        } else {
            document.getElementById('cq_stem').value = '';
            document.getElementById('cq_a').value = '';
            document.getElementById('cq_b').value = '';
            document.getElementById('cq_c').value = '';
            document.getElementById('cq_d').value = '';
        }
    }

    function removeQuestion(index) {
        if(confirm('আপনি কি এই প্রশ্নটি মুছে ফেলতে চান?')) {
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

        if (questions.length === 0) {
            area.innerHTML = `
            <div class="text-center" style="color: #9ca3af; padding: 100px 0;">
                <i class="material-icons-round" style="font-size: 4rem; opacity: 0.5;">assignment</i>
                <h5 class="mt-3">প্রশ্নপত্র ফাঁকা</h5>
                <p style="font-size: 0.9rem;">বাম পাশের প্যানেল থেকে প্রশ্ন যোগ করুন।</p>
            </div>`;
            return;
        }

        questions.forEach((q, idx) => {
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
                        <strong>${idx + 1}.</strong> ${q.text}
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px; margin-left: 15px;">
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
                    <div style="margin-bottom: 10px; padding-right: 70px; text-align: justify;">
                        <strong>${idx + 1}.</strong> ${q.stem}
                    </div>
                    <div style="padding-left: 20px;">
                        <div>ক) ${q.a} <span style="float: right;">১</span></div>
                        <div>খ) ${q.b} <span style="float: right;">২</span></div>
                        <div>গ) ${q.c} <span style="float: right;">৩</span></div>
                        <div>ঘ) ${q.d} <span style="float: right;">৪</span></div>
                    </div>
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
            Swal.fire('প্রশ্নপত্র ফাঁকা! প্রথমে প্রশ্ন যোগ করুন।');
            return;
        }

        const schoolName = document.getElementById('paper_school').value;
        const address = document.getElementById('paper_address').value;
        const title = document.getElementById('paper_title').value;
        const subject = document.getElementById('paper_subject').value;
        const className = document.getElementById('paper_class').value;
        const duration = document.getElementById('paper_time').value;
        const marks = document.getElementById('paper_marks').value;
        const type = '{{ $type }}';

        fetch('{{ route("questions.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                school_name: schoolName,
                address: address,
                title: title,
                subject: subject,
                class: className,
                duration: duration,
                marks: marks,
                type: type,
                content: JSON.stringify(questions)
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                Swal.fire('প্রশ্নপত্র সফলভাবে সেভ করা হয়েছে!');
                window.location.href = data.redirect;
            } else {
                Swal.fire('সেভ করার সময় কোনো সমস্যা হয়েছে।');
            }
        })
        .catch(err => {
            Swal.fire('সার্ভার ত্রুটি ঘটেছে।');
        });
    }
</script>

<style>
    @media print {
        .builder-sidebar { display: none !important; }
        .no-print { display: none !important; }
        body { background: #fff !important; }
        .builder-preview { padding: 0 !important; background: #fff !important; }
        .preview-paper { box-shadow: none !important; margin: 0 !important; padding: 0 !important; border: none !important; }
        .question-card { border: none !important; margin-bottom: 20px !important; }
    }
</style>

</body>
</html>
