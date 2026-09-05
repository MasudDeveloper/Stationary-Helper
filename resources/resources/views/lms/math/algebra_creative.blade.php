@extends('layouts.app')

@section('title', 'বীজগাণিতিক রাশি - ৫০টি সৃজনশীল মাস্টার সলভার')

@section('content')
<!-- KaTeX for Professional Math Rendering -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

<div class="algebra-wrapper" style="color: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('math.index') }}" class="btn btn-outline-light btn-sm rounded-xl mb-3" style="text-decoration: none;">
            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">arrow_back</i> অধ্যায় তালিকায় ফিরে যান
        </a>
        <h2 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0 0 8px 0;">
            বীজগাণিতিক রাশি (Algebraic Expression) — মাস্টার সলভার 🔵
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            বর্গ, ঘন, উৎপাদকে বিশ্লেষণ ও মান নির্ণয়ের বিভিন্ন প্রশ্নের কাস্টম ইনপুট দিয়ে পূর্ণ সমাধান দেখুন।
        </p>
    </div>

    <!-- 2-Column Sidebar Layout -->
    <div class="row g-4">
        <!-- Sidebar Question Jumper (Left Column) -->
        <div class="col-lg-3 col-md-4">
            <div style="position: sticky; top: 90px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08); padding: 18px; max-height: calc(100vh - 120px); overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 style="color: #fbbf24; font-weight: 800; font-size: 1.05rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.2rem;">category</i>
                        <span>বীজগণিত নেভিগেশন</span>
                    </h5>
                    <span id="totalBadge" style="background: rgba(37,99,235,0.2); color: #60a5fa; padding: 2px 10px; border-radius: 10px; font-size: 0.78rem; font-weight: 800;">
                        ৫০টি প্রশ্ন
                    </span>
                </div>

                <!-- Nav Mode Toggle Button -->
                <button id="navModeBtn" onclick="algApp.toggleNavMode()" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 7px 10px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; width: 100%; margin-bottom: 12px; transition: all 0.2s;">
                    🔄 নেভিগেশন মোড: প্যাটার্নভিত্তিক
                </button>

                <!-- Search Input Box -->
                <div class="mb-3">
                    <input type="number" id="searchInput" placeholder="প্রশ্ন নম্বর লিখুন..." oninput="algApp.render()" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); background: rgba(30, 41, 59, 0.9); color: #fff; font-size: 0.88rem; outline: none;">
                </div>

                <!-- Grouped Categorized Nav Grid -->
                <div id="navGroupedGrid"></div>
            </div>
        </div>

        <!-- Main Content Questions List (Right Column) -->
        <div class="col-lg-9 col-md-8">
            <div id="questionsContainer"></div>
        </div>
    </div>
</div>

<style>
.algebra-wrapper .q-card {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 20px;
    padding: 26px;
    margin-bottom: 26px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-top: 5px solid #2563eb;
}

.algebra-wrapper .q-badge {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-weight: 800;
    margin-bottom: 15px;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.algebra-wrapper .edit-panel {
    background: rgba(30, 41, 59, 0.6);
    border: 1px dashed rgba(245, 158, 11, 0.4);
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 20px;
}

.algebra-wrapper .grid-inputs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
}

.algebra-wrapper .input-group {
    display: flex;
    flex-direction: column;
}

.algebra-wrapper .input-group label {
    font-size: 11px;
    color: #cbd5e1;
    font-weight: 700;
    margin-bottom: 3px;
}

.algebra-wrapper .input-group input {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(15, 23, 42, 0.9);
    color: #60a5fa;
    font-weight: 700;
    outline: none;
}

.algebra-wrapper .stimulus-box {
    background: rgba(30, 58, 138, 0.2);
    padding: 20px;
    border-left: 5px solid #3b82f6;
    border-radius: 0 12px 12px 0;
    margin: 20px 0;
    font-size: 1.05rem;
    line-height: 1.7;
    color: #f1f5f9;
}

.algebra-wrapper .sub-q-list {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.algebra-wrapper .sub-q-list li {
    margin-bottom: 12px;
    font-weight: 600;
    color: #e2e8f0;
    font-size: 1.02rem;
}

.algebra-wrapper .btn-solution {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 800;
    font-size: 1rem;
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
}

.algebra-wrapper .btn-solution.active {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.algebra-wrapper .solution-box {
    display: none;
    margin-top: 20px;
    padding: 22px;
    background: rgba(15, 23, 42, 0.9);
    border: 1.5px solid #059669;
    border-radius: 14px;
}

.algebra-wrapper .solution-box.active {
    display: block;
}

.algebra-wrapper .step-item {
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding-bottom: 14px;
}

.algebra-wrapper .step-title {
    color: #34d399;
    font-weight: 700;
    font-size: 1.05rem;
    display: block;
    margin-bottom: 8px;
}

.algebra-wrapper .sidebar-group-title {
    color: #fbbf24;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    margin: 16px 0 8px 0;
    padding-bottom: 4px;
    border-bottom: 1px solid rgba(245, 158, 11, 0.2);
}

.algebra-wrapper .nav-btn-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 5px;
}

.algebra-wrapper .nav-btn {
    background: rgba(30, 41, 59, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
    padding: 6px 0;
    cursor: pointer;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.82rem;
    text-align: center;
    transition: all 0.2s;
}

.algebra-wrapper .nav-btn:hover,
.algebra-wrapper .nav-btn.active {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
}
</style>

<script>
const dbExercises = @json($customExercises ?? []);

const algApp = {
    questions: [],
    navMode: 'pattern', // 'pattern' or 'serial'

    init() {
        if (dbExercises && dbExercises.length > 0) {
            this.loadFromDb();
        } else {
            this.generate50Questions();
        }
        this.renderNav();
        this.render();
    },

    toggleNavMode() {
        this.navMode = this.navMode === 'pattern' ? 'serial' : 'pattern';
        const btn = document.getElementById('navModeBtn');
        if (btn) {
            btn.innerHTML = this.navMode === 'pattern' ? '🔄 নেভিগেশন মোড: প্যাটার্নভিত্তিক' : '🔢 নেভিগেশন মোড: সিরিয়াল অনুযায়ী';
        }
        this.renderNav();
    },

    loadFromDb() {
        this.questions = [];
        dbExercises.forEach((ex, idx) => {
            let opts = ex.options;
            if (typeof opts === 'string') {
                try { opts = JSON.parse(opts); } catch(e) { opts = {}; }
            }
            if (!opts || typeof opts !== 'object') opts = {};

            const pattern = opts.p || 'P1';
            let q = {
                id: ex.id,
                title: ex.title,
                pattern: pattern,
                k: opts.k !== undefined ? opts.k : 3,
                a: opts.a !== undefined ? opts.a : 5,
                b: opts.b !== undefined ? opts.b : 6,
                coeffA: opts.coeffA !== undefined ? opts.coeffA : 3,
                coeffB: opts.coeffB !== undefined ? opts.coeffB : 11,
                coeffC: opts.coeffC !== undefined ? opts.coeffC : -4,
                show: false
            };
            this.questions.push(q);
        });
    },

    generate50Questions() {
        this.questions = [];
        for (let i = 1; i <= 50; i++) {
            const mod = (i - 1) % 5;
            let p = 'P1';
            if(mod === 1) p = 'P2';
            else if(mod === 2) p = 'P3';
            else if(mod === 3) p = 'P4';
            else if(mod === 4) p = 'P5';

            this.questions.push({
                id: i,
                title: `সৃজনশীল প্রশ্ন নং: ${i}`,
                pattern: p,
                k: 3 + (i % 4),
                a: 4 + (i % 3),
                b: 6,
                coeffA: 3,
                coeffB: 11,
                coeffC: -4,
                show: false
            });
        }
    },

    renderNav() {
        const container = document.getElementById('navGroupedGrid');
        container.innerHTML = '';

        if (this.navMode === 'serial') {
            const total = this.questions.length;
            const chunkSize = 10;
            
            for (let start = 1; start <= total; start += chunkSize) {
                const end = Math.min(start + chunkSize - 1, total);
                
                const titleEl = document.createElement('div');
                titleEl.className = 'sidebar-group-title';
                titleEl.innerText = `${start}-${end} নম্বর প্রশ্ন`;
                container.appendChild(titleEl);

                const gridEl = document.createElement('div');
                gridEl.className = 'nav-btn-grid';

                for (let i = start; i <= end; i++) {
                    const b = document.createElement('button');
                    b.className = 'nav-btn';
                    b.innerText = i;
                    b.onclick = () => { 
                        document.getElementById('searchInput').value = i; 
                        this.render(); 
                        window.scrollTo({ top: 120, behavior: 'smooth' }); 
                    };
                    gridEl.appendChild(b);
                }
                container.appendChild(gridEl);
            }
        } else {
            const groups = [
                { key: 'P1', title: 'প্যাটার্ন ১: বর্গ মান (x + 1/x = k)' },
                { key: 'P2', title: 'প্যাটার্ন ২: ঘন মান (x³ + 1/x³)' },
                { key: 'P3', title: 'প্যাটার্ন ৩: দ্বিপদী মান (a + b, ab)' },
                { key: 'P4', title: 'প্যাটার্ন ৪: উৎপাদকে বিশ্লেষণ' },
                { key: 'P5', title: 'প্যাটার্ন ৫: বীজগণিতীয় প্রমাণ' },
            ];

            groups.forEach((g, gIdx) => {
                const qList = this.questions.filter((q, idx) => (q.pattern === g.key) || (!q.pattern && (idx % 5 === gIdx)));
                if (qList.length > 0) {
                    const titleEl = document.createElement('div');
                    titleEl.className = 'sidebar-group-title';
                    titleEl.innerText = `${g.title} (${qList.length}টি)`;
                    container.appendChild(titleEl);

                    const gridEl = document.createElement('div');
                    gridEl.className = 'nav-btn-grid';

                    qList.forEach(q => {
                        const qNo = this.questions.indexOf(q) + 1;
                        const b = document.createElement('button');
                        b.className = 'nav-btn';
                        b.innerText = qNo;
                        b.onclick = () => { 
                            document.getElementById('searchInput').value = qNo; 
                            this.render(); 
                            window.scrollTo({ top: 120, behavior: 'smooth' }); 
                        };
                        gridEl.appendChild(b);
                    });

                    container.appendChild(gridEl);
                }
            });
        }
    },

    updateParam(id, key, val) {
        const q = this.questions.find(item => item.id === id);
        if (q) {
            q[key] = parseFloat(val) || 0;
            this.render();
        }
    },

    toggleSolution(id) {
        const q = this.questions.find(item => item.id === id);
        if (q) {
            q.show = !q.show;
            this.render();
        }
    },

    render() {
        const container = document.getElementById('questionsContainer');
        const search = document.getElementById('searchInput').value;
        container.innerHTML = '';

        this.questions.forEach((q, idx) => {
            const qNo = idx + 1;
            if (search && qNo != search && q.id != search) return;

            const card = document.createElement('div');
            card.className = 'q-card';

            let stim = '', subQ = '', sol = '', editInputs = '';

            if (q.pattern === 'P1') {
                editInputs = `
                    <div class="input-group"><label>মান k (x + 1/x):</label><input type="number" value="${q.k}" oninput="algApp.updateParam(${q.id}, 'k', this.value)"></div>
                `;
                stim = `$x + \\frac{1}{x} = ${q.k}$`;
                subQ = `
                    <li>ক) $x - \\frac{1}{x}$ এর মান নির্ণয় করো।</li>
                    <li>খ) $x^2 + \\frac{1}{x^2}$ এর মান বের করো।</li>
                    <li>গ) প্রমাণ করো যে, $x^4 + \\frac{1}{x^4} = ${Math.pow(Math.pow(q.k, 2) - 2, 2) - 2}$।</li>
                `;
                const minus = Math.sqrt(Math.max(0, q.k * q.k - 4)).toFixed(2);
                const sq = q.k * q.k - 2;
                const quad = sq * sq - 2;
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> $(x - 1/x)^2 = (x + 1/x)^2 - 4 = ${q.k}^2 - 4 = ${q.k*q.k - 4} \\implies x - 1/x = \\sqrt{${q.k*q.k - 4}} = ${minus}$</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> $x^2 + 1/x^2 = (x + 1/x)^2 - 2 = ${q.k}^2 - 2 = ${sq}$</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> $x^4 + 1/x^4 = (x^2 + 1/x^2)^2 - 2 = ${sq}^2 - 2 = ${quad}$ (প্রমাণিত)</div>
                `;
            } else if (q.pattern === 'P2') {
                editInputs = `
                    <div class="input-group"><label>মান k (x + 1/x):</label><input type="number" value="${q.k}" oninput="algApp.updateParam(${q.id}, 'k', this.value)"></div>
                `;
                stim = `$x + \\frac{1}{x} = ${q.k}$`;
                subQ = `
                    <li>ক) $x^3 + \\frac{1}{x^3}$ এর মান নির্ণয় করো।</li>
                    <li>খ) $x^3 - \\frac{1}{x^3}$ এর মান বের করো।</li>
                    <li>গ) দেখাও যে, $x^5 + \\frac{1}{x^5} = ${(q.k*q.k - 2)*(Math.pow(q.k,3) - 3*q.k) - q.k}$।</li>
                `;
                const cube = Math.pow(q.k, 3) - 3 * q.k;
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> $x^3 + 1/x^3 = (x + 1/x)^3 - 3(x + 1/x) = ${q.k}^3 - 3(${q.k}) = ${cube}$</div>
                    <div class="step-item"><span class="step-title">খ ও গ এর সমাধান:</span> সূত্র প্রয়োগের মাধ্যমে সহজেই ধাপে ধাপে মান বের করা যায়।</div>
                `;
            } else if (q.pattern === 'P3') {
                editInputs = `
                    <div class="input-group"><label>মান a + b:</label><input type="number" value="${q.a}" oninput="algApp.updateParam(${q.id}, 'a', this.value)"></div>
                    <div class="input-group"><label>মান ab:</label><input type="number" value="${q.b}" oninput="algApp.updateParam(${q.id}, 'b', this.value)"></div>
                `;
                stim = `$a + b = ${q.a}$ এবং $ab = ${q.b}$`;
                subQ = `
                    <li>ক) $(a - b)^2$ এর মান কত?</li>
                    <li>খ) $a^3 + b^3$ এর মান নির্ণয় করো।</li>
                    <li>গ) $2(a^2 + b^2)$ এর মান বের করো।</li>
                `;
                const abMinusSq = q.a * q.a - 4 * q.b;
                const a3b3 = Math.pow(q.a, 3) - 3 * q.b * q.a;
                const a2b2 = 2 * (q.a * q.a - 2 * q.b);
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> $(a - b)^2 = (a + b)^2 - 4ab = ${q.a}^2 - 4(${q.b}) = ${abMinusSq}$</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> $a^3 + b^3 = (a + b)^3 - 3ab(a + b) = ${q.a}^3 - 3(${q.b})(${q.a}) = ${a3b3}$</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> $2(a^2 + b^2) = 2[(a + b)^2 - 2ab] = 2[${q.a*q.a} - ${2*q.b}] = ${a2b2}$</div>
                `;
            } else if (q.pattern === 'P4') {
                editInputs = `
                    <div class="input-group"><label>সহগ a (ax²):</label><input type="number" value="${q.coeffA}" oninput="algApp.updateParam(${q.id}, 'coeffA', this.value)"></div>
                    <div class="input-group"><label>সহগ b (bx):</label><input type="number" value="${q.coeffB}" oninput="algApp.updateParam(${q.id}, 'coeffB', this.value)"></div>
                    <div class="input-group"><label>ধ্রুবক c:</label><input type="number" value="${q.coeffC}" oninput="algApp.updateParam(${q.id}, 'coeffC', this.value)"></div>
                `;
                stim = `রাশি: $${q.coeffA}x^2 + ${q.coeffB}x ${q.coeffC >= 0 ? '+' : ''}${q.coeffC}$`;
                subQ = `
                    <li>ক) প্রদত্ত রাশিটির মিডল-টার্ম ফ্যাক্টর (উৎপাদক) করো।</li>
                    <li>খ) $x = 2$ হলে রাশির মান কত?</li>
                    <li>গ) রাশিটি $0$ হলে $x$ এর মূলদ্বয় নির্ণয় করো।</li>
                `;
                const val2 = q.coeffA * 4 + q.coeffB * 2 + q.coeffC;
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> মিডল-টার্ম ভাঙ্গন: $a \\times c = ${q.coeffA} \\times (${q.coeffC}) = ${q.coeffA*q.coeffC}$। গুণনীয়ক বিশ্লেষণ করে সমাধান করা হয়।</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> $x = 2$ বসিয়ে মান $= ${q.coeffA}(2)^2 + ${q.coeffB}(2) + (${q.coeffC}) = ${val2}$</div>
                `;
            } else {
                editInputs = `
                    <div class="input-group"><label>মান k:</label><input type="number" value="${q.k}" oninput="algApp.updateParam(${q.id}, 'k', this.value)"></div>
                `;
                stim = `$a + b + c = 0$ এবং $x + \\frac{1}{x} = ${q.k}$`;
                subQ = `
                    <li>ক) দেখাও যে, $a^3 + b^3 + c^3 = 3abc$।</li>
                    <li>খ) $x^6 + 1 = ${Math.pow(q.k, 3) - 3*q.k}x^3$ প্রমাণ করো।</li>
                    <li>গ) বীজগণিতীয় অভেদটির সত্যতা যাচাই করো।</li>
                `;
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> $a + b = -c \\implies (a + b)^3 = (-c)^3 \\implies a^3 + b^3 + 3ab(a + b) = -c^3 \\implies a^3 + b^3 + c^3 = 3abc$ (প্রমাণিত)</div>
                `;
            }

            card.innerHTML = `
                <div class="q-badge">${q.title}</div>
                <div class="edit-panel">
                    <strong style="color: #fbbf24; font-size: 0.9rem; margin-bottom: 8px; display: block;">পরামিতি পরিবর্তন (লাইভ প্র্যাকটিস):</strong>
                    <div class="grid-inputs">${editInputs}</div>
                </div>
                <div class="stimulus-box"><strong>উদ্দীপক:</strong><br>${stim}</div>
                <ul class="sub-q-list">${subQ}</ul>
                <button class="btn-solution ${q.show ? 'active' : ''}" onclick="algApp.toggleSolution(${q.id})">${q.show ? 'সমাধান বন্ধ করুন' : 'সম্পূর্ণ সমাধান (ক, খ, গ) দেখুন'}</button>
                <div class="solution-box ${q.show ? 'active' : ''}">${sol}</div>
            `;
            container.appendChild(card);
        });

        setTimeout(() => {
            if (typeof renderMathInElement === 'function') {
                renderMathInElement(document.body, { delimiters: [
                    {left: "$$", right: "$$", display: true},
                    {left: "$", right: "$", display: false}
                ]});
            }
        }, 50);
    }
};

document.addEventListener('DOMContentLoaded', () => algApp.init());
</script>
@endsection
