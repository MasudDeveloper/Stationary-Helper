@extends('layouts.app')

@section('title', 'সেট ও ফাংশন - ১০০টি সৃজনশীল সলভার')

@section('content')
<!-- KaTeX Math Rendering -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

<div class="set-function-wrapper" style="color: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif;">
    <!-- Page Header -->
    <div style="margin-bottom: 25px;">
        <a href="{{ route('math.index') }}" class="btn btn-outline-light btn-sm rounded-xl mb-3" style="text-decoration: none;">
            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">arrow_back</i> অধ্যায় তালিকায় ফিরে যান
        </a>
        <h2 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0 0 8px 0;">
            সেট ও ফাংশন (Set & Function) — ডাইনামিক সলভার 🔷
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            সাইডবার থেকে প্যাটার্ন বা সিরিয়াল অনুযায়ী নেভিগেশন মোড সুইচের মাধ্যমে প্রশ্ন সলভ করুন।
        </p>
    </div>

    <!-- 2-Column Right Sidebar Flex Layout -->
    <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
        <!-- Main Content Questions List (Left Side) -->
        <div style="flex: 1; min-width: 320px;">
            <div id="questionsList"></div>
        </div>

        <!-- Sidebar Question Jumper (Right Side - Fixed Width) -->
        <div style="width: 310px; max-width: 100%; flex-shrink: 0;">
            <div style="position: sticky; top: 90px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08); padding: 18px; max-height: calc(100vh - 120px); overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 style="color: #fbbf24; font-weight: 800; font-size: 1.05rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.2rem;">grid_view</i>
                        <span>প্রশ্ন নেভিগেশন</span>
                    </h5>
                    <span id="totalBadge" style="background: rgba(37,99,235,0.2); color: #60a5fa; padding: 2px 10px; border-radius: 10px; font-size: 0.78rem; font-weight: 800;">
                        {{ isset($customExercises) ? $customExercises->count() : 0 }}টি প্রশ্ন
                    </span>
                </div>

                <!-- Nav Mode Toggle Button -->
                <button id="navModeBtn" onclick="sfApp.toggleNavMode()" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 7px 10px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; width: 100%; margin-bottom: 12px; transition: all 0.2s;">
                    🔄 নেভিগেশন মোড: প্যাটার্নভিত্তিক
                </button>

                <!-- Search Input Box -->
                <div class="mb-3">
                    <input type="number" id="searchInput" placeholder="প্রশ্ন নম্বর লিখুন..." oninput="sfApp.render()" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); background: rgba(30, 41, 59, 0.9); color: #fff; font-size: 0.88rem; outline: none;">
                </div>

                <!-- Grouped Categorized Nav Grid -->
                <div id="navGroupedGrid"></div>
            </div>
        </div>
    </div>
</div>

<style>
.set-function-wrapper .card-sf {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 20px;
    padding: 26px;
    margin-bottom: 26px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.set-function-wrapper .q-badge {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-weight: 800;
    margin-bottom: 15px;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.set-function-wrapper .editor {
    background: rgba(30, 41, 59, 0.6);
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
    border: 1px dashed rgba(59, 130, 246, 0.4);
}

.set-function-wrapper .edit-box {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.set-function-wrapper .edit-box label {
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
}

.set-function-wrapper .edit-box input {
    padding: 8px 10px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(15, 23, 42, 0.9);
    border-radius: 8px;
    font-weight: 700;
    color: #60a5fa;
    outline: none;
}

.set-function-wrapper .stimulus {
    background: rgba(30, 58, 138, 0.2);
    padding: 20px;
    border-left: 5px solid #3b82f6;
    border-radius: 0 12px 12px 0;
    margin: 20px 0;
    font-size: 1.05rem;
    line-height: 1.7;
    color: #f1f5f9;
}

.set-function-wrapper .questions {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.set-function-wrapper .questions li {
    margin-bottom: 12px;
    font-weight: 600;
    color: #e2e8f0;
    font-size: 1.02rem;
}

.set-function-wrapper .btn-sol {
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

.set-function-wrapper .btn-sol.active {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.set-function-wrapper .solution-area {
    display: none;
    margin-top: 20px;
    padding: 22px;
    background: rgba(15, 23, 42, 0.9);
    border: 1.5px solid #059669;
    border-radius: 14px;
}

.set-function-wrapper .solution-area.active {
    display: block;
}

.set-function-wrapper .sol-step {
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding-bottom: 14px;
}

.set-function-wrapper .sol-h {
    color: #34d399;
    font-weight: 700;
    font-size: 1.05rem;
    display: block;
    margin-bottom: 8px;
}

.set-function-wrapper .sidebar-group-title {
    color: #fbbf24;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    margin: 16px 0 8px 0;
    padding-bottom: 4px;
    border-bottom: 1px solid rgba(245, 158, 11, 0.2);
}

.set-function-wrapper .nav-btn-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 5px;
}

.set-function-wrapper .nav-btn {
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

.set-function-wrapper .nav-btn:hover,
.set-function-wrapper .nav-btn.active {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
}
</style>

<script>
const dbExercises = @json($customExercises ?? []);

const sfApp = {
    data: [],
    navMode: 'pattern', // 'pattern' or 'serial'

    init() {
        if (dbExercises && dbExercises.length > 0) {
            this.loadFromDb();
        } else {
            this.generate100Questions();
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
        this.data = [];
        dbExercises.forEach((ex, idx) => {
            let opts = ex.options;
            if (typeof opts === 'string') {
                try { opts = JSON.parse(opts); } catch(e) { opts = {}; }
            }
            if (!opts || typeof opts !== 'object') opts = {};
            
            const type = idx % 5;
            
            let q = {
                id: ex.id,
                show: false,
                dbTitle: ex.title,
                p: opts.p || (type === 0 ? 'P1' : (type === 1 ? 'P2' : (type === 2 ? 'P3' : (type === 3 ? 'P4' : 'P5')))),
                s1: opts.s1 || 'A',
                s2: opts.s2 || 'B',
                fn: opts.fn || 'f',
                vr: opts.vr || 'x',
                aLim: opts.aLim !== undefined ? opts.aLim : 11,
                b1: opts.b1 !== undefined ? opts.b1 : 9,
                b2: opts.b2 !== undefined ? opts.b2 : 130,
                c1: opts.c1 !== undefined ? opts.c1 : 3,
                c2: opts.c2 !== undefined ? opts.c2 : 1,
                c3: opts.c3 !== undefined ? opts.c3 : 3,
                c4: opts.c4 !== undefined ? opts.c4 : -1,
                uLim: opts.uLim !== undefined ? opts.uLim : 10,
                p1: opts.p1 !== undefined ? opts.p1 : 12,
                q1: opts.q1 !== undefined ? opts.q1 : 3,
                q2: opts.q2 !== undefined ? opts.q2 : 9,
                kRel: opts.kRel !== undefined ? opts.kRel : 2,
                fA: opts.fA !== undefined ? opts.fA : 1,
                fB: opts.fB !== undefined ? opts.fB : 5,
                fC: opts.fC !== undefined ? opts.fC : -3,
                sqLim: opts.sqLim !== undefined ? opts.sqLim : 4,
                gn: opts.gn !== undefined ? opts.gn : 6,
                kVal: opts.kVal !== undefined ? opts.kVal : 1,
                tPow: opts.tPow !== undefined ? opts.tPow : 3
            };
            this.data.push(q);
        });
    },

    generate100Questions() {
        this.data = [];
        for (let i = 1; i <= 100; i++) {
            const type = (i - 1) % 5;
            let q = { id: i, show: false, s1: 'A', s2: 'B', fn: 'f', vr: 'x' };

            if (type === 0) { 
                q.p = 'P1'; q.aLim = 11; q.b1 = 9; q.b2 = 130; q.c1 = 3; q.c2 = 1; q.c3 = 3; q.c4 = -1;
            } else if (type === 1) { 
                q.p = 'P2'; q.s1 = 'P'; q.s2 = 'Q'; q.fn = 'g'; q.vr = 'y'; q.uLim = 10; q.p1 = 12; q.q1 = 3; q.q2 = 9;
            } else if (type === 2) { 
                q.p = 'P3'; q.s1 = 'S'; q.s2 = 'A'; q.fn = 'F'; q.kRel = 2; q.fA = 1; q.fB = 5; q.fC = -3;
            } else if (type === 3) { 
                q.p = 'P4'; q.fn = 'f'; q.c1 = 2; q.c2 = 3; q.c3 = 2; q.c4 = -1; q.sqLim = 4; q.gn = 6;
            } else { 
                q.p = 'P5'; q.fn = 'g'; q.vr = 't'; q.kVal = 1; q.tPow = 3;
            }
            this.data.push(q);
        }
    },

    renderNav() {
        const container = document.getElementById('navGroupedGrid');
        container.innerHTML = '';

        if (this.navMode === 'serial') {
            const total = this.data.length;
            const chunkSize = 20;
            
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
            const patternGroups = [
                { key: 'P1', title: 'প্যাটার্ন ১: মৌলিক সংখ্যা ও ভগ্নাংশ' },
                { key: 'P2', title: 'প্যাটার্ন ২: গুণনীয়ক, গুণিতক ও এক-এক' },
                { key: 'P3', title: 'প্যাটার্ন ৩: ক্রমজোড় অন্বয় ও বহুপদী' },
                { key: 'P4', title: 'প্যাটার্ন ৪: সেট গঠন ও শক্তি সেট' },
                { key: 'P5', title: 'প্যাটার্ন ৫: ভেনচিত্র ও পাওয়ার ফাংশন' },
            ];

            patternGroups.forEach((group, groupIdx) => {
                const groupQuestions = this.data.filter((q, idx) => (q.p === group.key) || (!q.p && (idx % 5 === groupIdx)));

                if (groupQuestions.length > 0) {
                    const titleEl = document.createElement('div');
                    titleEl.className = 'sidebar-group-title';
                    titleEl.innerText = `${group.title} (${groupQuestions.length}টি)`;
                    container.appendChild(titleEl);

                    const gridEl = document.createElement('div');
                    gridEl.className = 'nav-btn-grid';

                    groupQuestions.forEach(q => {
                        const qNo = this.data.indexOf(q) + 1;
                        const b = document.createElement('button');
                        b.className = 'nav-btn';
                        b.innerText = qNo;
                        b.title = q.dbTitle || `প্রশ্ন ${qNo}`;
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

    update(id, key, val) {
        const item = this.data.find(q => q.id === id);
        if (item) {
            item[key] = isNaN(val) || val === "" ? val : parseFloat(val);
            this.render();
        }
    },

    toggle(id) {
        const item = this.data.find(q => q.id === id);
        if (item) {
            item.show = !item.show;
            this.render();
        }
    },

    getPrimes(n) { return [2, 3, 5, 7, 11, 13, 17, 19, 23].filter(p => p <= n); },
    getDivisors(n) { let d = []; for(let i=1; i<=n; i++) if(n%i===0) d.push(i); return d; },

    render() {
        const list = document.getElementById('questionsList');
        const search = document.getElementById('searchInput').value;
        list.innerHTML = '';

        this.data.forEach((q, idx) => {
            const qNo = idx + 1;
            if (search && qNo != search && q.id != search) return;

            const card = document.createElement('div');
            card.className = 'card-sf';
            
            let editBox = '', stim = '', ques = '', sol = '';

            if (q.p === 'P1') {
                editBox = this.createEdit(q, [['s1','সেট A'],['s2','সেট B'],['fn','ফাংশন'],['aLim','মৌলিক সীমা'],['c1','লব সহগ']]);
                stim = `$${q.s1} = \\{${q.vr} \\in \\mathbb{N} : ${q.vr} \\text{ মৌলিক এবং } ${q.vr} \\le ${q.aLim} \\}$, $${q.s2} = \\{${q.vr} \\in \\mathbb{N} : ${q.vr}^2 > ${q.b1}, ${q.vr}^3 < ${q.b2} \\}$ এবং $${q.fn}(${q.vr}) = \\frac{${q.c1}${q.vr} + ${q.c2}}{${q.c3}${q.vr} + (${q.c4})}$`;
                ques = `<li>ক) $${q.s1}$ সেটটিকে তালিকা পদ্ধতিতে প্রকাশ করো।</li><li>খ) প্রমাণ করো যে, $P(${q.s1} \\cap ${q.s2})$ এর উপাদান সংখ্যা $2^n$ কে সমর্থন করে।</li><li>গ) $${q.fn}(${q.vr})$ ফাংশনটির ডোমেন এবং রেঞ্জ নির্ণয় করো।</li>`;
                
                const A = this.getPrimes(q.aLim);
                const B = []; for(let x=1; x<10; x++) if(x*x > q.b1 && x*x*x < q.b2) B.push(x);
                const cap = A.filter(x => B.includes(x));
                
                sol = `
                    <div class="sol-step"><span class="sol-h">ক এর সমাধান:</span> $${q.s1} = \\{${q.vr} \\in \\mathbb{N} : ${q.vr} \\text{ মৌলিক এবং } ${q.vr} \\le ${q.aLim} \\}$। <br> $${q.aLim}$ পর্যন্ত মৌলিক সংখ্যাগুলো হলো: $${A.join(', ')}$। <br> $\\therefore ${q.s1} = \\{${A.join(', ')}\\}$ (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">খ এর সমাধান:</span> $${q.s1} = \\{${A.join(',')}\\}$ এবং $${q.s2} = \\{${B.join(',')}\\}$। <br> $\\therefore ${q.s1} \\cap ${q.s2} = \\{${cap.length ? cap.join(',') : '\\emptyset'}\\}$। <br> এখানে উপাদান সংখ্যা $n = ${cap.length}$। উপসেট সংখ্যা $= 2^n = 2^{${cap.length}} = ${Math.pow(2, cap.length)}$। এটি $2^n$ কে সমর্থন করে। (প্রমাণিত)</div>
                    <div class="sol-step"><span class="sol-h">গ এর সমাধান:</span> ডোমেন: হর $0$ হতে পারবে না। $${q.c3}${q.vr} + (${q.c4}) = 0 \\implies ${q.vr} = ${(-q.c4/q.c3).toFixed(2)}$। <br> $\\therefore Dom = \\mathbb{R} - \\{${(-q.c4/q.c3).toFixed(2)}\\}$। <br> রেঞ্জ: $y = \\frac{${q.c1}${q.vr}+${q.c2}}{${q.c3}${q.vr}+${q.c4}} \\implies Range = \\mathbb{R} - \\{ \\frac{${q.c1}}{${q.c3}} \\} = \\mathbb{R} - \\{${(q.c1/q.c3).toFixed(2)}\\}$।</div>`;
            }
            else if (q.p === 'P2') {
                editBox = this.createEdit(q, [['s1','সেট P'],['s2','সেট Q'],['p1','গুণনীয়ক'],['q1','গুণিতক']]);
                stim = `$U = \\{x \\in \\mathbb{N} : x < ${q.uLim} \\}$, $${q.s1} = \\{x : x, ${q.p1} \\text{ এর গুণনীয়ক} \\}$, $${q.s2} = \\{x : x, ${q.q1} \\text{ এর গুণিতক}, x \\le ${q.q2} \\}$ এবং $${q.fn}(${q.vr}) = \\frac{${q.vr}^2-3${q.vr}+1}{${q.vr}(1-${q.vr})}$`;
                ques = `<li>ক) $${q.s1} \\cap ${q.s2}$ এর মান নির্ণয় করো।</li><li>খ) প্রমাণ করো যে, $P(${q.s1} \\setminus ${q.s2})$ এর উপাদান সংখ্যা $2^n$ কে সমর্থন করে।</li><li>গ) দেখাও যে, ফাংশনটি এক-এক এবং সার্বিক।</li>`;
                
                const P = this.getDivisors(q.p1);
                const Q = []; for(let x=q.q1; x<=q.q2; x+=q.q1) Q.push(x);
                const cap = P.filter(x => Q.includes(x));
                const diff = P.filter(x => !Q.includes(x));
                
                sol = `
                    <div class="sol-step"><span class="sol-h">ক এর সমাধান:</span> $${q.s1} = \\{${P.join(',')}\\}$ এবং $${q.s2} = \\{${Q.join(',')}\\}$। <br> $\\therefore ${q.s1} \\cap ${q.s2} = \\{${cap.join(',')}\\}$ (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">খ এর সমাধান:</span> $${q.s1} \\setminus ${q.s2} = \\{${diff.join(',')}\\}$। <br> উপাদান সংখ্যা $n = ${diff.length}$। উপসেট সংখ্যা $= 2^{${diff.length}} = ${Math.pow(2, diff.length)}$। এটি $2^n$ কে সমর্থন করে।</div>
                    <div class="sol-step"><span class="sol-h">গ এর সমাধান:</span> ফাংশনটি এক-এক কারণ প্রতিটি ভিন্ন ইনপুটের জন্য ভিন্ন আউটপুট পাওয়া যায়। রেঞ্জ ও কো-ডোমেন সমান হওয়ায় এটি সার্বিক ফাংশন।</div>`;
            }
            else if (q.p === 'P3') {
                editBox = this.createEdit(q, [['fn','ফাংশন'],['vr','চলক'],['kRel','y=kx'],['fB','x^2 সহগ']]);
                stim = `$${q.s1} = \\{(x, y) : x \\in ${q.s2}, y \\in ${q.s2} \\text{ এবং } y = ${q.kRel}x \\}$, $${q.s2} = \\{-1, 0, 1, 2, 3 \\}$ এবং $${q.fn}(x) = x^4 + ${q.fB}x^2 ${q.fC >= 0 ? '+' : ''}${q.fC}$`;
                ques = `<li>ক) $${q.fn}(-1/2)$ এর মান বের করো।</li><li>খ) $${q.s1}$ অন্বয়টিকে তালিকা পদ্ধতিতে প্রকাশ করো এবং ডোমেন নির্ণয় করো।</li><li>গ) $${q.fn}(x)$ ফাংশনটির ডোমেন ও রেঞ্জ বের করো।</li>`;
                
                const val = (Math.pow(-0.5, 4) + q.fB*Math.pow(-0.5, 2) + q.fC).toFixed(4);
                sol = `
                    <div class="sol-step"><span class="sol-h">ক এর সমাধান:</span> $${q.fn}(-1/2) = (-1/2)^4 + ${q.fB}(-1/2)^2 + (${q.fC}) = 0.0625 + ${q.fB*0.25} ${q.fC} = ${val}$ (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">খ এর সমাধান:</span> $y = ${q.kRel}x$ শর্তে ক্রমজোড়সমূহ: $(0,0), (1,${q.kRel})$। <br> $\\therefore ${q.s1} = \\{(0,0), (1,${q.kRel})\\}$। ডোমেন = $\\{0, 1\\}$। (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">গ এর সমাধান:</span> বহুপদী ফাংশনের ডোমেন সবসময় $\\mathbb{R}$। এখানে সর্বনিম্ন মান $x=0$ এর জন্য $y=${q.fC}$। রেঞ্জ: $[${q.fC}, \\infty)$।</div>`;
            }
            else if (q.p === 'P4') {
                editBox = this.createEdit(q, [['fn','ফাংশন'],['sqLim','x^2 limit'],['gn','গুণনীয়ক']]);
                stim = `$${q.fn}(${q.vr}) = \\frac{${q.c1}${q.vr} + ${q.c2}}{${q.c3}${q.vr} + ${q.c4}}$, $A = \\{x \\in \\mathbb{Z} : x^2 \\le ${q.sqLim} \\}$ এবং $B = \\{x \\in \\mathbb{N} : x, ${q.gn} \\text{ এর গুণনীয়ক} \\}$`;
                ques = `<li>ক) $B$ সেটটিকে গঠন পদ্ধতিতে প্রকাশ করো।</li><li>খ) $P(A \\cap B)$ নির্ণয় করো।</li><li>গ) দেখাও যে, ফাংশনটি এক-এক এবং সার্বিক।</li>`;
                
                const A_set = [-2,-1,0,1,2];
                const B_set = this.getDivisors(q.gn);
                const cap = A_set.filter(x => B_set.includes(x));
                
                sol = `
                    <div class="sol-step"><span class="sol-h">ক এর সমাধান:</span> $B = \\{x \\in \\mathbb{N} : x \\text{ হলো } ${q.gn} \\text{ এর গুণনীয়ক}\\}$ (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">খ এর সমাধান:</span> $A = \\{-2,-1,0,1,2\\}$ এবং $B = \\{${B_set.join(',')}\\}$। <br> $\\therefore A \\cap B = \\{${cap.join(',')}\\}$। <br> উপসেট $P(A \\cap B) = \\{${cap.length ? '\\emptyset, \\{1\\}, \\{2\\}, \\{1,2\\}' : '\\emptyset'}\\}$</div>
                    <div class="sol-step"><span class="sol-h">গ এর সমাধান:</span> $f(x_1) = f(x_2) \\implies x_1 = x_2$ প্রমাণিত হলে ফাংশনটি এক-এক। রেঞ্জ = কো-ডোমেন হলে সার্বিক।</div>`;
            }
            else {
                editBox = this.createEdit(q, [['fn','ফাংশন'],['vr','চলক'],['kVal','Default k'],['tPow','পাওয়ার']]);
                stim = `ভেনচিত্রে $n(A) = n(B \\cap C)$ এবং $${q.fn}(${q.vr}) = \\frac{${q.vr}^{${q.tPow}} + k}{${q.vr}^2}$`;
                ques = `<li>ক) $${q.fn}(-1) = 0$ হলে $k$ এর মান কত?</li><li>খ) প্রমাণ করো যে, $P(A \\cap B)$ এর উপাদান সংখ্যা $2^n$ কে সমর্থন করে।</li><li>গ) $${q.fn}(${q.vr})$ ফাংশনটির ডোমেন এবং রেঞ্জ নির্ণয় করো।</li>`;
                
                sol = `
                    <div class="sol-step"><span class="sol-h">ক এর সমাধান:</span> $${q.fn}(-1) = \\frac{(-1)^{${q.tPow}} + k}{(-1)^2} = 0 \\implies \\frac{${q.tPow % 2 === 0 ? 1 : -1} + k}{1} = 0 \\implies k = ${q.tPow % 2 === 0 ? -1 : 1}$। (উত্তর)</div>
                    <div class="sol-step"><span class="sol-h">খ এর সমাধান:</span> ভেনচিত্র হতে $A \\cap B$ এর উপাদান সংখ্যা $n$ বের করে $2^n$ উপসেট সংখ্যা প্রমাণ করা যায়।</div>
                    <div class="sol-step"><span class="sol-h">গ এর সমাধান:</span> হর $0$ হতে পারবে না, তাই $${q.vr} \\ne 0$। ডোমেন = $\\mathbb{R} - \\{0\\}$। রেঞ্জ ও একইভাবে নির্ণয় করা যাবে।</div>`;
            }

            card.innerHTML = `
                <div class="q-badge">${q.dbTitle || ('সৃজনশীল প্রশ্ন নং: ' + qNo)}</div>
                <div class="editor"><strong>ইনপুট পরামিতি পরিবর্তন (লাইভ প্র্যাকটিস):</strong> ${editBox}</div>
                <div class="stimulus"><strong>উদ্দীপক:</strong><br>${stim}</div>
                <ul class="questions">${ques}</ul>
                <button class="btn-sol ${q.show ? 'active' : ''}" onclick="sfApp.toggle(${q.id})">${q.show ? 'সমাধান বন্ধ করুন' : 'পূর্ণাঙ্গ সমাধান (ক, খ, গ) দেখুন'}</button>
                <div class="solution-area ${q.show ? 'active' : ''}">${sol}</div>
            `;
            list.appendChild(card);
        });

        setTimeout(() => {
            if (typeof renderMathInElement === 'function') {
                renderMathInElement(document.body, { delimiters: [
                    {left: "$$", right: "$$", display: true},
                    {left: "$", right: "$", display: false}
                ]});
            }
        }, 50);
    },

    createEdit(conf, fields) {
        return fields.map(f => {
            const isT = ['s1','s2','fn','vr'].includes(f[0]);
            return `<div class="edit-box"><label>${f[1]}</label><input type="${isT?'text':'number'}" value="${conf[f[0]]}" oninput="sfApp.update(${conf.id}, '${f[0]}', this.value)"></div>`;
        }).join('');
    }
};

document.addEventListener('DOMContentLoaded', () => sfApp.init());
</script>
@endsection
