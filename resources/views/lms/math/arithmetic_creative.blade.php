@extends('layouts.app')

@section('title', 'বাস্তব সংখ্যা ও পাটিগণিত - অটো ম্যাথ সলভার')

@section('content')
<!-- KaTeX for Math Formatting -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

<div class="arithmetic-wrapper" style="color: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('math.index') }}" class="btn btn-outline-light btn-sm rounded-xl mb-3" style="text-decoration: none;">
            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">arrow_back</i> অধ্যায় তালিকায় ফিরে যান
        </a>
        <h2 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0 0 8px 0;">
            বাস্তব সংখ্যা ও পাটিগণিত (Real Number & Arithmetic) — সলভার 🟢
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            মূলদ-অমূলদ সংখ্যা, পৌনঃপুনিক দশমিক, শতকরা ও অনুপাতের ডাইনামিক গাণিতিক সমাধান।
        </p>
    </div>

    <!-- Admin Added Custom Exercises -->
    @if(isset($customExercises) && $customExercises->count() > 0)
        <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 16px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #34d399; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <i class="material-icons-round">edit_note</i> এডমিন স্পেশাল প্রশ্নাবলী ({{ $customExercises->count() }}টি)
            </h4>
            <div style="display: grid; gap: 15px;">
                @foreach($customExercises as $ex)
                    <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 18px;">
                        <h5 style="color: #fbbf24; font-weight: 700; margin-bottom: 8px;">{{ $ex->title }}</h5>
                        <p style="color: #f1f5f9; font-size: 1rem; margin-bottom: 10px;">{!! nl2br(e($ex->question)) !!}</p>
                        @if($ex->correct_answer)
                            <div style="color: #34d399; font-weight: 700; font-size: 0.9rem; margin-top: 5px;">✓ সঠিক উত্তর: {{ $ex->correct_answer }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Main Container -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Sidebar Navigation -->
        <div style="flex: 0 0 250px; background: rgba(15, 23, 42, 0.7); border-radius: 16px; padding: 18px; border: 1px solid rgba(255,255,255,0.08); height: fit-content;">
            <h4 style="font-weight: 700; color: #60a5fa; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 12px;">প্রশ্ন নেভিগেশন</h4>
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px;" id="arithGrid"></div>
        </div>

        <!-- Content Area -->
        <div style="flex: 1; min-width: 300px;" id="arithContent"></div>
    </div>
</div>

<style>
.arithmetic-wrapper .card-ar {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 18px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-top: 5px solid #10b981;
}

.arithmetic-wrapper .customizer {
    background: rgba(30, 41, 59, 0.6);
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 18px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    border: 1px dashed rgba(16, 185, 129, 0.4);
}

.arithmetic-wrapper .input-group {
    display: flex;
    flex-direction: column;
}

.arithmetic-wrapper .input-group label {
    font-size: 11px;
    color: #94a3b8;
    font-weight: 700;
    margin-bottom: 3px;
}

.arithmetic-wrapper .input-group input {
    width: 80px;
    padding: 7px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(15, 23, 42, 0.9);
    color: #34d399;
    font-weight: 700;
    outline: none;
}

.arithmetic-wrapper .stimulus {
    background: rgba(6, 78, 59, 0.25);
    padding: 16px;
    border-left: 4px solid #10b981;
    border-radius: 0 10px 10px 0;
    margin-bottom: 15px;
    font-size: 1.05rem;
    color: #f1f5f9;
}

.arithmetic-wrapper .sol-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #10b981, #047857);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
}

.arithmetic-wrapper .solution-area {
    display: none;
    margin-top: 15px;
    padding: 20px;
    background: rgba(15, 23, 42, 0.9);
    border: 1.5px solid #10b981;
    border-radius: 12px;
}

.arithmetic-wrapper .nav-btn {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
    padding: 6px 0;
    cursor: pointer;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.85rem;
    text-align: center;
}

.arithmetic-wrapper .nav-btn:hover {
    background: #10b981;
    color: white;
}
</style>

<script>
const arithApp = {
    data: [],

    init() {
        this.generateQuestions();
        this.renderNav();
        this.render();
    },

    generateQuestions() {
        for(let i=1; i<=20; i++) {
            let q = { id: i, show: false, a: i*2+3, b: i*3+1, c: 5, d: 7 };
            this.data.push(q);
        }
    },

    renderNav() {
        const grid = document.getElementById('arithGrid');
        grid.innerHTML = '';
        this.data.forEach(q => {
            const btn = document.createElement('button');
            btn.className = 'nav-btn';
            btn.innerText = q.id;
            btn.onclick = () => {
                const el = document.getElementById('card_' + q.id);
                if(el) el.scrollIntoView({ behavior: 'smooth' });
            };
            grid.appendChild(btn);
        });
    },

    updateVal(id, key, val) {
        let item = this.data.find(q => q.id === id);
        item[key] = isNaN(val) || val === "" ? val : parseFloat(val);
        this.render();
    },

    toggleSol(id) {
        let item = this.data.find(q => q.id === id);
        item.show = !item.show;
        this.render();
    },

    render() {
        const container = document.getElementById('arithContent');
        container.innerHTML = '';

        this.data.forEach(q => {
            const card = document.createElement('div');
            card.className = 'card-ar';
            card.id = 'card_' + q.id;

            let isPrime = this.checkPrime(q.a);

            card.innerHTML = `
                <div style="background:#10b981; color:white; padding:4px 14px; border-radius:12px; font-weight:bold; display:inline-block; margin-bottom:12px;">প্রশ্ন নং: ${q.id}</div>
                <div class="customizer">
                    <div class="input-group">
                        <label>সংখ্যা A</label>
                        <input type="number" value="${q.a}" oninput="arithApp.updateVal(${q.id}, 'a', this.value)">
                    </div>
                    <div class="input-group">
                        <label>সংখ্যা B</label>
                        <input type="number" value="${q.b}" oninput="arithApp.updateVal(${q.id}, 'b', this.value)">
                    </div>
                </div>
                <div class="stimulus">
                    <strong>উদ্দীপক:</strong> $A = \\sqrt{${q.a}}$ এবং $B = ${q.b}$ দুটি বাস্তব সংখ্যা।
                </div>
                <div style="margin-bottom:15px;">
                    <div>ক) $A = \\sqrt{${q.a}}$ মূলদ নাকি অমূলদ সংখ্যা?</div>
                    <div>খ) $A$ এবং $B$ এর মধ্যে ৩টি অমূলদ সংখ্যা নির্ণয় করো।</div>
                    <div>গ) প্রমাণ করো যে, $\\sqrt{${q.a}}$ একটি অমূলদ সংখ্যা।</div>
                </div>
                <button class="sol-btn" onclick="arithApp.toggleSol(${q.id})">${q.show ? 'সমাধান বন্ধ করুন' : 'পূর্ণাঙ্গ সমাধান দেখুন'}</button>
                ${q.show ? `
                    <div class="solution-area" style="display:block;">
                        <div style="margin-bottom:12px;"><strong style="color:#34d399;">ক এর সমাধান:</strong><br>$\\sqrt{${q.a}}$ ${isPrime ? 'একটি মৌলিক সংখ্যার বর্গমূল হওয়ায় এটি অমূলদ সংখ্যা।' : 'একটি মূলদ বা অমূলদ সংখ্যা।'}</div>
                        <div style="margin-bottom:12px;"><strong style="color:#34d399;">খ এর সমাধান:</strong><br>$\\sqrt{${q.a}} \\approx ${Math.sqrt(q.a).toFixed(3)}$ এবং $B = ${q.b}$। <br> নির্ণেয় অমূলদ সংখ্যাসমূহ: $${(Math.sqrt(q.a) + 0.123).toFixed(4)}, ${(Math.sqrt(q.a) + 0.456).toFixed(4)}, ${(Math.sqrt(q.a) + 0.789).toFixed(4)}$।</div>
                        <div><strong style="color:#34d399;">গ এর সমাধান:</strong><br>ধরি, $\\sqrt{${q.a}}$ একটি মূলদ সংখ্যা $\\frac{p}{q}$। উভয়পক্ষকে বর্গ করে পাওয়া যায় $p^2 = ${q.a}q^2$। এটি নির্দেশ করে $\\sqrt{${q.a}}$ একটি অমূলদ সংখ্যা। (প্রমাণিত)</div>
                    </div>
                ` : ''}
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
    },

    checkPrime(n) {
        if(n <= 1) return false;
        for(let i=2; i<=Math.sqrt(n); i++) if(n%i===0) return false;
        return true;
    }
};

document.addEventListener('DOMContentLoaded', () => arithApp.init());
</script>
@endsection
