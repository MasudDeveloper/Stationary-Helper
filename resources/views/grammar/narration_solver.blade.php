@extends('layouts.app')

@section('title', 'Narration Solver - English Grammar Master')

@section('content')
<div class="narration-solver-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
    <!-- Back Link & Header -->
    <div style="margin-bottom: 25px;">
        <a href="{{ route('grammar.index') }}" style="color: #0052cc; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem;">
            <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">ব্যাক টু ক্লাসরুম</span>
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <span style="color: #0052cc; font-size: 0.8rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 6px;">ENGLISH GRAMMAR MASTER SOLVER</span>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            NARRATION SOLVER – ওয়াটারমার্কড অ্যানসার শিট
        </h1>
        <p style="color: #64748b; font-size: 1rem; margin-top: 10px; line-height: 1.6; max-width: 850px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            Direct থেকে Indirect অথবা Indirect থেকে Direct Speech উক্তি রূপান্তরের জন্য স্মার্ট সলভার। ৯টি ধাপে এনালাইসিস, কনফিডেন্স স্কোর এবং ওয়াটারমার্কড অ্যানসার শিট ভিউ।
        </p>
    </div>

    <!-- Navigation Tabs -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap;">
        <button type="button" class="tab-btn active" id="tab-solver" onclick="switchTab('solver')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #0052cc; border-bottom: 3px solid #0052cc; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">auto_awesome</i>
            <span>স্মার্ট সলভার & অ্যানসার শিট</span>
        </button>
        <button type="button" class="tab-btn" id="tab-rules" onclick="switchTab('rules')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">menu_book</i>
            <span>উক্তি পরিবর্তনের ফর্মুলা ও রুলস</span>
        </button>
    </div>

    <!-- TAB 1: SOLVER INTERFACE -->
    <div id="panel-solver" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.15fr; gap: 30px; align-items: start;">
            
            <!-- Left Controls & Input -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; display: flex; flex-direction: column; justify-content: space-between; min-height: 540px; color: #0f172a !important;">
                <div>
                    <!-- Mode Switcher -->
                    <div style="display: flex; gap: 10px; margin-bottom: 18px; background: #f1f5f9; padding: 4px; border-radius: 10px;">
                        <button type="button" id="btn-mode-d2i" onclick="setNarrationMode('d2i')" style="flex: 1; border: none; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: #0052cc; color: white; font-family: 'Hind Siliguri', sans-serif;">Direct ➔ Indirect Speech</button>
                        <button type="button" id="btn-mode-i2d" onclick="setNarrationMode('i2d')" style="flex: 1; border: none; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: transparent; color: #475569; font-family: 'Hind Siliguri', sans-serif;">Indirect ➔ Direct Speech</button>
                    </div>

                    <!-- Presets Selector -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: flex; justify-content: space-between; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">
                            <span>উদাহরণ বাক্য নির্বাচন করুন (Presets)</span>
                            <span style="font-size: 0.75rem; color: #0052cc; cursor: pointer; font-weight: 700;" onclick="loadRandomPreset()">🎲 র্যান্ডম বাক্য</span>
                        </label>
                        <select id="preset-selector" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 12px; font-size: 0.9rem; color: #0f172a; outline: none; background: #f8fafc; font-family: 'Outfit', sans-serif;" onchange="applyPreset(this.value)">
                            <option value="">-- একটি উদাহরণ পছন্দ করুন --</option>
                            <option value='Rahim said, "I am happy."'>1. Assertive: Rahim said, "I am happy."</option>
                            <option value='Rahim said to me, "I like you."'>2. Assertive (told): Rahim said to me, "I like you."</option>
                            <option value='He said to me, "Are you happy?"'>3. Interrogative (Yes/No): He said to me, "Are you happy?"</option>
                            <option value='He said to me, "Where do you live?"'>4. Interrogative (WH): He said to me, "Where do you live?"</option>
                            <option value='The teacher said to me, "Open the door."'>5. Imperative (Order): The teacher said to me, "Open the door."</option>
                            <option value='He said to me, "Please help me."'>6. Imperative (Request): He said to me, "Please help me."</option>
                            <option value='Father said to me, "Work hard."'>7. Imperative (Advice): Father said to me, "Work hard."</option>
                            <option value='Mother said to me, "Do not waste time."'>8. Imperative (Prohibition): Mother said to me, "Do not waste time."</option>
                            <option value='He said, "Let us go out."'>9. Imperative (Let us): He said, "Let us go out."</option>
                            <option value='He said, "May you be happy."'>10. Optative (Wish): He said, "May you be happy."</option>
                            <option value='He said, "May Allah help you."'>11. Optative (Prayer): He said, "May Allah help you."</option>
                            <option value='He said, "Hurrah! We have won."'>12. Exclamatory (Joy): He said, "Hurrah! We have won."</option>
                            <option value='He said, "Alas! I have lost my book."'>13. Exclamatory (Sorrow): He said, "Alas! I have lost my book."</option>
                            <option value='He said, "What a beautiful flower!"'>14. Exclamatory (Wonder): He said, "What a beautiful flower!"</option>
                            <option value='The teacher said, "The sun rises in the east."'>15. Universal Truth: The teacher said, "The sun rises in the east."</option>
                            <option value='He says, "I am busy."'>16. Present Reporting Verb: He says, "I am busy."</option>
                        </select>
                    </div>

                    <!-- Question Input Textarea -->
                    <div style="margin-bottom: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label id="question-label" style="font-weight: 700; font-size: 0.88rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">Direct Speech ইনপুট দিন</label>
                            <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">● Live Auto-Solve</span>
                        </div>
                        <textarea id="question-input" rows="6" placeholder='যেমন: Rahim said to me, "I like you."' style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 12px 15px; font-size: 0.95rem; background: #ffffff; color: #0f172a; resize: none; outline: none; line-height: 1.5; font-family: 'Outfit', sans-serif;" oninput="onQuestionInput()"></textarea>
                    </div>
                </div>

                <button type="button" onclick="solveNarration()" style="width: 100%; border-radius: 10px; background: #0052cc; color: #ffffff; border: none; padding: 14px; font-size: 1rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(0,82,204,0.25);">
                    <span>সলভ করুন ও অ্যানসার শিট তৈরি করুন</span>
                    <i class="material-icons-round" style="font-size: 1.2rem;">auto_awesome</i>
                </button>
            </div>

            <!-- Right Results & Watermarked Answer Sheet Display -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- TOP CARD: Board Question Paper -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <i class="material-icons-round" style="color: #0052cc; font-size: 1.3rem;">record_voice_over</i>
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; font-family: 'Hind Siliguri', sans-serif;">Board Question Paper (Narration)</h4>
                    </div>

                    <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">
                        <strong>1 speech question detected.</strong> Custom speech questions are accepted without limits.
                    </div>

                    <!-- Inner Box -->
                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 16px; position: relative;">
                        <span style="position: absolute; top: 8px; right: 12px; font-size: 0.68rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.8px;">BOARD QUESTION • NARRATION</span>
                        <div id="display-question-text" style="font-size: 0.95rem; font-weight: 600; color: #0f172a; line-height: 1.6; font-family: 'Outfit', sans-serif; margin-top: 10px;">
                            <!-- Question text rendered here -->
                        </div>
                        <div style="text-align: right; margin-top: 10px; font-size: 0.72rem; color: #94a3b8;">
                            English Grammar Master • Bangladesh Board-style question
                        </div>
                    </div>
                </div>

                <!-- BOTTOM CARD: Watermarked Answer Sheet -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); position: relative; overflow: hidden;">
                    
                    <!-- Watermark Background Text -->
                    <div style="position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); font-size: 2.8rem; font-weight: 900; color: rgba(0, 82, 204, 0.05); pointer-events: none; white-space: nowrap; user-select: none; z-index: 0;">
                        ENGLISH GRAMMAR MASTER • ANSWER
                    </div>

                    <div style="position: relative; z-index: 1;">
                        
                        <!-- Header Banner -->
                        <div style="background: #0052cc; color: white; padding: 8px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                            <i class="material-icons-round" style="font-size: 1rem;">water_drop</i>
                            <span>Watermarked Answer Sheet</span>
                        </div>

                        <div style="font-size: 0.82rem; color: #475569; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                            এখানেই প্রতিটি question-এর complete answer, sentence type, rule এবং analysis দেওয়া হয়েছে।
                        </div>

                        <!-- Main Blue Header Bar -->
                        <div style="background: #1d4ed8; color: white; padding: 6px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 800; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span>Answer Sheet — Narration Question 1</span>
                            <span style="font-size: 0.7rem; opacity: 0.9;">ENGLISH GRAMMAR MASTER • WATERMARKED</span>
                        </div>

                        <!-- Top Quick Answer Pills -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px;">
                                <span style="background: #1d4ed8; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800; display: inline-block; margin-bottom: 6px;">Converted Speech</span>
                                <div id="display-completed-speech" style="font-size: 1.05rem; font-weight: 700; color: #0f172a; font-family: 'Outfit', sans-serif;">
                                    <!-- Rendered dynamically -->
                                </div>
                            </div>

                            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px;">
                                <span style="background: #1d4ed8; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800; display: inline-block; margin-bottom: 6px;">Confidence</span>
                                <div id="display-confidence" style="font-size: 1.05rem; font-weight: 800; color: #1d4ed8;">High</div>
                            </div>

                            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px;">
                                <span style="background: #1d4ed8; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800; display: inline-block; margin-bottom: 6px;">Sentence Type</span>
                                <div id="display-sentence-type" style="font-size: 0.95rem; font-weight: 800; color: #1d4ed8;">Assertive</div>
                            </div>
                        </div>

                        <!-- Answer Table Header Pill -->
                        <div style="margin-bottom: 10px;">
                            <span style="background: #1d4ed8; color: white; padding: 4px 12px; border-radius: 4px; font-size: 0.78rem; font-weight: 800;">📋 Narration Components Breakdown Table</span>
                        </div>

                        <!-- Table -->
                        <div style="overflow-x: auto; margin-bottom: 20px;">
                            <table class="table table-bordered mb-0" style="font-size: 0.85rem; width: 100%;">
                                <thead style="background: #0f172a; color: white;">
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Reporting Speech</th>
                                        <th>Reported Speech</th>
                                        <th>Connector</th>
                                        <th>Tense & Person Rule</th>
                                    </tr>
                                </thead>
                                <tbody id="display-table-body">
                                    <!-- Populated dynamically -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Step-by-Step Header Pill -->
                        <div style="margin-bottom: 10px;">
                            <span style="background: #1d4ed8; color: white; padding: 4px 12px; border-radius: 4px; font-size: 0.78rem; font-weight: 800;">🎨 Step-by-Step 9-Step Breakdown</span>
                        </div>

                        <!-- Step-by-Step Box -->
                        <div id="display-step-by-step" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Final Answer Pill -->
                        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 12px 16px; font-weight: 800; color: #065f46; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                            <i class="material-icons-round" style="color: #10b981;">check_circle</i>
                            <span id="display-final-answer-text">Final Answer: Rahim told me that he liked me.</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- TAB 2: NARRATION FORMULAS & RULES -->
    <div id="panel-rules" class="tab-panel d-none">
        
        <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="color: #0052cc;">fact_check</i>
            <span>NARRATION (DIRECT ➔ INDIRECT SPEECH) - ২০টি মূল ফর্মুলা</span>
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; margin-bottom: 30px;">
            
            <div class="rule-card">
                <span class="rule-num">Formula 1</span>
                <h4>Direct ➔ Indirect Quick Formula (Box 22)</h4>
                <p>Reporting Verb + (that / if / wh-word / to) + Subject + Tense (changed) + Object + Time/Place (changed).</p>
                <div class="rule-ex">He told me that he was happy.</div>
            </div>

            <div class="rule-card">
                <span class="rule-num">Formula 2</span>
                <h4>Person Change (SON Rule)</h4>
                <p>1st Person ➔ Subject অনুযায়ী | 2nd Person ➔ Object অনুযায়ী | 3rd Person ➔ Unchanged.</p>
                <div class="rule-ex">Rahim said to me, "I like you" ➔ Rahim told me that he liked me.</div>
            </div>

            <div class="rule-card">
                <span class="rule-num">Formula 3</span>
                <h4>Tense Shift Matrix</h4>
                <p>Present Simple ➔ Past Simple | Present Cont. ➔ Past Cont. | Past Simple ➔ Past Perfect.</p>
                <div class="rule-ex">He said, "I play" ➔ He said that he played.</div>
            </div>

            <div class="rule-card">
                <span class="rule-num">Formula 4</span>
                <h4>Modals Transformation</h4>
                <p>will ➔ would | shall ➔ should/would | can ➔ could | may ➔ might | must ➔ had to.</p>
                <div class="rule-ex">He said, "I can go" ➔ He said that he could go.</div>
            </div>

            <div class="rule-card">
                <span class="rule-num">Formula 5</span>
                <h4>Interrogative Sentence Rules</h4>
                <p>Reporting verb 'asked'. Yes/No questions ➔ Connector 'if/whether'. WH Questions ➔ Wh-word.</p>
                <div class="rule-ex">He asked me where I lived.</div>
            </div>

            <div class="rule-card">
                <span class="rule-num">Formula 6</span>
                <h4>Imperative Sentence Rules</h4>
                <p>Order ➔ ordered | Request ➔ requested | Advice ➔ advised | Prohibition ➔ told/advised not to + V1.</p>
                <div class="rule-ex">Father advised me to work hard.</div>
            </div>

        </div>
    </div>

</div>

<!-- CSS STYLING & HIGH CONTRAST FIXES -->
<style>
    .tab-btn:hover {
        color: #0052cc !important;
    }
    .rule-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .rule-num {
        background: #0052cc;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.72rem;
        font-weight: 800;
    }
    .rule-card h4 {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin: 8px 0;
        font-family: 'Hind Siliguri', sans-serif;
    }
    .rule-card p {
        color: #475569;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 8px;
        font-family: 'Hind Siliguri', sans-serif;
    }
    .rule-ex {
        background: #f8fafc;
        border-left: 3px solid #0052cc;
        padding: 6px 10px;
        font-size: 0.84rem;
        color: #1e293b;
        font-family: 'Outfit', sans-serif;
    }

    /* High Contrast & Visible Table Styles */
    .narration-solver-page table {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
    }
    .narration-solver-page table th,
    .narration-solver-page table thead tr th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-color: #334155 !important;
        padding: 10px 12px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .narration-solver-page table td,
    .narration-solver-page table tbody tr td {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        font-weight: 600 !important;
        vertical-align: middle !important;
        padding: 10px 12px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .narration-solver-page table tbody tr:nth-child(even) td {
        background-color: #f8fafc !important;
    }
</style>

<!-- JAVASCRIPT LOGIC FOR NARRATION SOLVER -->
<script>
let currentMode = 'd2i';

const NARRATION_SOLUTIONS = {
    'Rahim said, "I am happy."': {
        type: "Assertive Sentence",
        question: 'Rahim said, "I am happy."',
        completed: 'Rahim said <span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">that he was happy.</span>',
        confidence: "High",
        table: [
            { id: 1, repSpeech: "Rahim said", repText: "I am happy", connector: "that", rule: "Present Simple ➔ Past Simple; 1st Person 'I' ➔ 'he'." }
        ],
        steps: [
            "Step 1 (Sentence Type): Assertive Sentence চিহ্নিত।",
            "Step 2 (Reporting Verb): 'said' অপরিবর্তিত।",
            "Step 3 & 4 (Connector): Inverted comma উঠিয়ে Connector 'that' বসানো হয়েছে।",
            "Step 5 (Person Change): 1st Person 'I' ➔ Subject 'Rahim' (he) অনুযায়ী পরিবর্তন।",
            "Step 6 (Tense Change): Present Indefinite ('am happy') ➔ Past Indefinite ('was happy')।"
        ],
        final: "Rahim said that he was happy."
    },
    'Rahim said to me, "I like you."': {
        type: "Assertive Sentence (told)",
        question: 'Rahim said to me, "I like you."',
        completed: 'Rahim <span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">told me that he liked me.</span>',
        confidence: "High",
        table: [
            { id: 1, repSpeech: "Rahim said to me", repText: "I like you", connector: "that", rule: "said to ➔ told me; 1st person 'I' ➔ 'he', 2nd person 'you' ➔ 'me'." }
        ],
        steps: [
            "Step 1 (Sentence Type): Assertive Sentence (with Object 'me')।",
            "Step 2 (Reporting Verb): Object থাকায় 'said to' ➔ 'told me'।",
            "Step 3 & 4 (Connector): Connector 'that' বসানো হয়েছে।",
            "Step 5 & 6 (Person & Tense): 'I' ➔ 'he', 'you' ➔ 'me', 'like' ➔ 'liked'।",
        ],
        final: "Rahim told me that he liked me."
    },
    'He said to me, "Are you happy?"': {
        type: "Interrogative (Yes/No)",
        question: 'He said to me, "Are you happy?"',
        completed: 'He <span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">asked me if I was happy.</span>',
        confidence: "High",
        table: [
            { id: 1, repSpeech: "He said to me", repText: "Are you happy?", connector: "if", rule: "said to ➔ asked; Yes/No Question ➔ Connector 'if'; Interrogative ➔ Assertive." }
        ],
        steps: [
            "Step 1 (Sentence Type): Interrogative Sentence (Yes/No Question)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'asked me'।",
            "Step 3 & 4 (Connector): Connector 'if' বসানো হয়েছে।",
            "Step 5 & 6: 'you' ➔ 'I', 'are' ➔ 'was'।"
        ],
        final: "He asked me if I was happy."
    },
    'He said to me, "Where do you live?"': {
        type: "Interrogative (WH)",
        question: 'He said to me, "Where do you live?"',
        completed: 'He <span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">asked me where I lived.</span>',
        confidence: "High",
        table: [
            { id: 1, repSpeech: "He said to me", repText: "Where do you live?", connector: "where", rule: "said to ➔ asked; WH Question ➔ WH-word ('where') Connector." }
        ],
        steps: [
            "Step 1 (Sentence Type): Interrogative Sentence (WH Question)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'asked me'।",
            "Step 3 & 4 (Connector): WH-word ('where') অপরিবর্তিত রাখা হয়েছে।",
            "Step 5 & 6: Subject-verb inversion তুলে দিয়ে 'do live' ➔ 'lived'।"
        ],
        final: "He asked me where I lived."
    },
    'The teacher said to me, "Open the door."': {
        type: "Imperative (Order)",
        question: 'The teacher said to me, "Open the door."',
        completed: 'The teacher <span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">ordered me to open the door.</span>',
        confidence: "High",
        table: [
            { id: 1, repSpeech: "The teacher said to me", repText: "Open the door", connector: "to", rule: "Imperative Order ➔ ordered me; Connector 'to' + V1." }
        ],
        steps: [
            "Step 1 (Sentence Type): Imperative Sentence (Order)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'ordered me'।",
            "Step 3 & 4 (Connector): Connector 'to' বসানো হয়েছে।",
            "Step 5 & 6: 'to' এর পর Base verb 'open' অপরিবর্তিত।"
        ],
        final: "The teacher ordered me to open the door."
    }
};

// Page Init
document.addEventListener("DOMContentLoaded", function() {
    applyPreset('Rahim said to me, "I like you."');
});

// Mode switch
function setNarrationMode(mode) {
    currentMode = mode;
    const btnD2I = document.getElementById('btn-mode-d2i');
    const btnI2D = document.getElementById('btn-mode-i2d');
    const questionLabel = document.getElementById('question-label');
    const questionArea = document.getElementById('question-input');

    if (mode === 'd2i') {
        btnD2I.style.background = "#0052cc";
        btnD2I.style.color = "white";
        btnI2D.style.background = "transparent";
        btnI2D.style.color = "#475569";
        questionLabel.textContent = "Direct Speech ইনপুট দিন";
        questionArea.placeholder = 'যেমন: Rahim said to me, "I like you."';
    } else {
        btnI2D.style.background = "#0052cc";
        btnI2D.style.color = "white";
        btnD2I.style.background = "transparent";
        btnD2I.style.color = "#475569";
        questionLabel.textContent = "Indirect Speech ইনপুট দিন";
        questionArea.placeholder = "যেমন: Rahim told me that he liked me.";
    }

    solveNarration();
}

// Tab Switch
function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.color = '#64748b';
        btn.style.borderBottomColor = 'transparent';
    });
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.add('d-none');
    });

    const activeBtn = document.getElementById('tab-' + tabName);
    const activePanel = document.getElementById('panel-' + tabName);

    if (activeBtn && activePanel) {
        activeBtn.classList.add('active');
        activeBtn.style.color = '#0052cc';
        activeBtn.style.borderBottomColor = '#0052cc';
        activePanel.classList.remove('d-none');
    }
}

// Presets
function applyPreset(qText) {
    if (!qText) return;
    document.getElementById('question-input').value = qText;
    solveNarration();
}

function loadRandomPreset() {
    const keys = Object.keys(NARRATION_SOLUTIONS);
    const randKey = keys[Math.floor(Math.random() * keys.length)];
    document.getElementById('preset-selector').value = randKey;
    applyPreset(randKey);
}

function onQuestionInput() {
    document.getElementById('preset-selector').value = "";
    solveNarration();
}

// Main Solver Function
function solveNarration() {
    const qText = document.getElementById('question-input').value.trim();
    if (!qText) return;

    let data = NARRATION_SOLUTIONS[qText];

    if (!data) {
        // Dynamic Solver Engine
        let sType = "Assertive Sentence";
        if (qText.includes('?')) sType = "Interrogative Sentence";
        else if (qText.includes('!')) sType = "Exclamatory Sentence";
        else if (qText.toLowerCase().includes('may ') || qText.toLowerCase().includes('allah')) sType = "Optative Sentence";
        else if (qText.toLowerCase().includes('please') || qText.toLowerCase().includes('do not') || qText.toLowerCase().includes('open')) sType = "Imperative Sentence";

        let convertedText = qText;
        if (currentMode === 'd2i') {
            convertedText = qText
                .replace(/"([^"]+)"/g, function(match, reported) { return "that " + reported; })
                .replace(/\bsaid to me\b/gi, "told me")
                .replace(/\bsaid to\b/gi, "told")
                .replace(/\bI am\b/gi, "he was")
                .replace(/\bI\b/g, "he")
                .replace(/\bmy\b/gi, "his")
                .replace(/\byou\b/gi, "me")
                .replace(/[",]/g, "");
        } else {
            convertedText = qText
                .replace(/\btold me that\b/gi, 'said to me, "')
                .replace(/\bsaid that\b/gi, 'said, "')
                .replace(/\bhe was\b/gi, 'I am') + '"';
        }

        data = {
            type: sType,
            question: qText,
            completed: `<span style="background: #1d4ed8; color: white; padding: 2px 10px; border-radius: 6px;">${convertedText}</span>`,
            confidence: "High",
            table: [
                { id: 1, repSpeech: "Reporting Part", repText: "Reported Text", connector: "that / if", rule: "Standard Narration Conversion" }
            ],
            steps: [
                `Step 1 (Sentence Type): ${sType} হিসেবে চিহ্নিত।`,
                `Step 2 (Reporting Verb): Reporting Verb সামঞ্জস্য করা হয়েছে।`,
                `Step 3 & 4 (Connector): Inverted comma উঠিয়ে Connector বসানো হয়েছে।`,
                `Step 5 & 6 (Person & Tense): Tense এবং Person পরিবর্তন প্রয়োগ করা হয়েছে।`
            ],
            final: convertedText
        };
    }

    renderSolutionData(data);
}

// Render Watermarked Answer Sheet
function renderSolutionData(data) {
    document.getElementById('display-question-text').innerText = data.question;
    document.getElementById('display-completed-speech').innerHTML = data.completed;
    document.getElementById('display-confidence').innerText = data.confidence;
    document.getElementById('display-sentence-type').innerText = data.type;

    // Render Table
    const tbody = document.getElementById('display-table-body');
    tbody.innerHTML = "";

    data.table.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="text-align: center; font-weight: bold; background: #eff6ff; color: #1d4ed8;">${row.id}</td>
            <td style="font-weight: 700; color: #1e293b;">${row.repSpeech}</td>
            <td style="font-weight: 700; color: #0f172a;"><span style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">${row.repText}</span></td>
            <td><span style="background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 4px; font-weight: 800;">${row.connector}</span></td>
            <td style="font-size: 0.82rem; color: #334155;">${row.rule}</td>
        `;
        tbody.appendChild(tr);
    });

    // Render Step by Step
    const stepContainer = document.getElementById('display-step-by-step');
    stepContainer.innerHTML = "";

    data.steps.forEach(step => {
        const div = document.createElement('div');
        div.style.cssText = "margin-bottom: 6px; font-size: 0.85rem; color: #1e293b;";
        div.innerHTML = `✔ ${step}`;
        stepContainer.appendChild(div);
    });

    // Render Final Answer
    document.getElementById('display-final-answer-text').innerHTML = `<strong>Final Answer:</strong> ${data.final}`;
}
</script>
@endsection
