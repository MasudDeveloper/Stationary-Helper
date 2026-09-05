@extends('layouts.app')

@section('title', 'Narration (Direct -> Indirect Speech) - Full Details & Auto-Converter')

@section('content')
<div class="narration-hub-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
    <!-- Back Link & Header -->
    <div style="margin-bottom: 25px;">
        <a href="{{ route('grammar.index') }}" style="color: #0052cc; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem;">
            <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">ব্যাক টু ক্লাসরুম</span>
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <span style="color: #0052cc; font-size: 0.8rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 6px;">ENGLISH GRAMMAR MASTER GUIDE</span>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            NARRATION (DIRECT ➔ INDIRECT SPEECH) – FULL DETAILS
        </h1>
        <p style="color: #64748b; font-size: 1rem; margin-top: 10px; line-height: 1.6; max-width: 850px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            Direct থেকে Indirect Speech উক্তি পরিবর্তনের সকল নিয়মকানুন, ২৫টি পূর্ণাঙ্গ বক্স, লাইভ অটো-ডিটেক্ট কনভার্টার এবং ধাপে ধাপে ৯টি স্টেপে রূপান্তর করার মাস্টার গাইড।
        </p>
    </div>

    <!-- Navigation Tabs -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap;">
        <button type="button" class="tab-btn active" id="tab-converter" onclick="switchTab('converter')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #0052cc; border-bottom: 3px solid #0052cc; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">auto_awesome</i>
            <span>লাইভ অটো-ডিটেক্ট কনভার্টার</span>
        </button>
        <button type="button" class="tab-btn" id="tab-guide" onclick="switchTab('guide')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">menu_book</i>
            <span>২৫টি নিয়ম ও পূর্ণাঙ্গ গাইডবুক</span>
        </button>
        <button type="button" class="tab-btn" id="tab-verbs" onclick="switchTab('verbs')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">list_alt</i>
            <span>Reporting Verbs & Quick Chart</span>
        </button>
    </div>

    <!-- TAB 1: CONVERTER PANEL -->
    <div id="panel-converter" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.15fr; gap: 30px; align-items: start;">
            
            <!-- Left Input & Options -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; display: flex; flex-direction: column; justify-content: space-between; min-height: 540px; color: #0f172a !important;">
                <div>
                    <!-- Mode Switcher -->
                    <div style="display: flex; gap: 10px; margin-bottom: 18px; background: #f1f5f9; padding: 4px; border-radius: 10px;">
                        <button type="button" id="btn-mode-d2i" onclick="setConversionMode('d2i')" style="flex: 1; border: none; padding: 8px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: #0052cc; color: white; font-family: 'Hind Siliguri', sans-serif;">Direct ➔ Indirect</button>
                        <button type="button" id="btn-mode-i2d" onclick="setConversionMode('i2d')" style="flex: 1; border: none; padding: 8px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; background: transparent; color: #475569; font-family: 'Hind Siliguri', sans-serif;">Indirect ➔ Direct</button>
                    </div>

                    <!-- Preset Selector -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: flex; justify-content: space-between; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">
                            <span>উদাহরণ বাক্য নির্বাচন করুন (Preset Examples)</span>
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

                    <!-- Input Box -->
                    <div style="margin-bottom: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label id="input-label" style="font-weight: 700; font-size: 0.88rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">Direct Speech ইনপুট দিন</label>
                            <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">● Live Auto-Detect</span>
                        </div>
                        <textarea id="narration-input" rows="5" placeholder='যেমন: Rahim said, "I am happy."' style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 12px 15px; font-size: 0.95rem; background: #ffffff; color: #0f172a; resize: none; outline: none; line-height: 1.5; font-family: 'Outfit', sans-serif;" oninput="onNarrationInput()"></textarea>
                    </div>
                </div>

                <button type="button" onclick="convertNarration()" style="width: 100%; border-radius: 10px; background: #0052cc; color: #ffffff; border: none; padding: 14px; font-size: 1rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(0,82,204,0.25);">
                    <span>উক্তি এনালাইজ ও রূপান্তর করুন</span>
                    <i class="material-icons-round" style="font-size: 1.2rem;">auto_awesome</i>
                </button>
            </div>

            <!-- Right Results Panel -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; min-height: 540px; display: flex; flex-direction: column; color: #0f172a !important;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: #0f172a; margin: 0; font-family: 'Hind Siliguri', sans-serif;">রূপান্তরের ফলাফল ও এনালাইসিস</h4>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" onclick="copyResultText()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; gap: 4px; font-family: 'Hind Siliguri', sans-serif;" title="Copy result">
                            <i class="material-icons-round" style="font-size: 1.1rem;">content_copy</i> কপি
                        </button>
                        <button type="button" onclick="speakResultText()" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; gap: 4px; font-family: 'Hind Siliguri', sans-serif;" title="Listen to pronunciation">
                            <i class="material-icons-round" style="font-size: 1.1rem;">volume_up</i> শুনুন
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="result-empty" style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 40px 20px;">
                    <div style="width: 72px; height: 72px; border-radius: 50%; background: #eff6ff; border: 2px dashed #bfdbfe; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; color: #0052cc;">
                        <i class="material-icons-round" style="font-size: 2.2rem;">record_voice_over</i>
                    </div>
                    <h5 style="font-weight: 700; font-size: 1.05rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">ফলাফল দেখার জন্য প্রস্তুত</h5>
                    <p style="color: #64748b; font-size: 0.88rem; max-width: 340px; line-height: 1.5; margin-top: 6px; font-family: 'Hind Siliguri', sans-serif;">
                        বাম পাশে একটি ডিরেক্ট বা ইনডিরেক্ট বাক্য টাইপ করুন অথবা Presets থেকে বেছে নিন।
                    </p>
                </div>

                <!-- Result Active State -->
                <div id="result-active" class="d-none" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <!-- Badges -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">
                            <div style="background: #eff6ff; border: 1px solid #dbeafe; color: #2563eb; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <span>TYPE:</span>
                                <span id="detected-type-badge">Assertive Sentence</span>
                            </div>
                            <div style="background: #faf5ff; border: 1px solid #e9d5ff; color: #6b21a8; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="material-icons-round" style="font-size: 0.9rem;">swap_horiz</i>
                                <span id="mode-badge">Direct ➔ Indirect Speech</span>
                            </div>
                        </div>

                        <!-- Main Converted Output Box -->
                        <div style="background: #0f172a; border-radius: 12px; padding: 20px; color: #ffffff; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(15,23,42,0.15);">
                            <div style="font-size: 0.75rem; font-weight: 700; color: #38bdf8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">রূপান্তরিত বাক্য (Converted Speech)</div>
                            <h3 id="result-converted-speech" style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin: 0; line-height: 1.5; font-family: 'Outfit', sans-serif;"></h3>
                        </div>

                        <!-- 9-Step Full Conversion Process Breakdown (Box 19) -->
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px; margin-bottom: 15px;">
                            <h6 style="font-weight: 800; color: #1e40af; margin: 0 0 10px 0; font-size: 0.9rem; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 6px;">
                                <i class="material-icons-round" style="font-size: 1.1rem;">fact_check</i>
                                <span>ধাপে ধাপে ৯টি স্টেপে রূপান্তর (9-Step Breakdown)</span>
                            </h6>
                            <div id="step-breakdown-container" style="display: flex; flex-direction: column; gap: 6px; font-size: 0.84rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- TAB 2: DETAILED GUIDEBOOK (ALL 25 BOXES INCLUDED) -->
    <div id="panel-guide" class="tab-panel d-none">
        
        <!-- Box 1, 2, 3 Intro Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 25px;">
            <!-- Box 1 -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 1</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 8px 0; font-family: 'Hind Siliguri', sans-serif;">
                    1. NARRATION কী?
                </h3>
                <p style="color: #475569; font-size: 0.9rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    Narration হলো কারো বলা কথা অন্যভাবে প্রকাশ করা।
                </p>
                <div style="background: #f8fafc; border-left: 4px solid #0052cc; padding: 10px 14px; border-radius: 4px; margin-top: 8px; font-size: 0.85rem;">
                    <strong>Direct Speech:</strong> বক্তার কথা হুবহু উদ্ধৃতি দেওয়া থাকে।<br>
                    <em>Example: Rahim said, "I am happy."</em><br><br>
                    <strong>Indirect Speech:</strong> বক্তার কথাকে নিজের ভাষায় প্রকাশ করা হয়।<br>
                    <em>Example: Rahim said that he was happy.</em>
                </div>
            </div>

            <!-- Box 2 -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 2</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 8px 0; font-family: 'Hind Siliguri', sans-serif;">
                    2. NARRATION-এর প্রধান অংশ
                </h3>
                <div style="font-size: 0.88rem; line-height: 1.6; color: #334155; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>A. Reporting Speech:</strong> যে অংশে বক্তা/কথা বলার বিষয়টি থাকে। (e.g. <code>Rahim said</code>)<br>
                    <strong>B. Reported Speech:</strong> যে কথাটি বলা হয়েছে। (e.g. <code>"I am happy."</code>)<br>
                    <hr style="margin: 8px 0;">
                    <strong>সম্পূর্ণ বাক্য:</strong> Rahim said, "I am happy."
                </div>
            </div>

            <!-- Box 3 -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 3</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 8px 0; font-family: 'Hind Siliguri', sans-serif;">
                    3. BASIC RULE: INVERTED COMMA
                </h3>
                <p style="color: #475569; font-size: 0.88rem; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    Direct Speech-এর <code>" "</code> Indirect Speech-এ উঠে যায় এবং প্রয়োজন অনুযায়ী: <code>that</code>, <code>if / whether</code>, <code>wh-word</code>, <code>to</code> বসে।
                </p>
                <div style="background: #eff6ff; padding: 8px 12px; border-radius: 6px; font-size: 0.85rem; color: #1e40af;">
                    <strong>Direct:</strong> He said, "I am busy."<br>
                    <strong>Indirect:</strong> He said that he was busy.
                </div>
            </div>
        </div>

        <!-- Box 5, 6, 7, 8, 9 Core Rules Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <!-- Box 5: Person Change Rules -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0;">
                <span style="background: #0052cc; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 5</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    5. PERSON CHANGE RULES (SON Rule)
                </h3>
                <div style="font-size: 0.88rem; line-height: 1.7; color: #334155; font-family: 'Hind Siliguri', sans-serif;">
                    • <strong>1st Person</strong> (I, me, my, we, us, our) ➔ Reporting verb-এর <strong>Subject</strong> অনুযায়ী<br>
                    • <strong>2nd Person</strong> (You, your, yours) ➔ Reporting verb-এর <strong>Object</strong> অনুযায়ী<br>
                    • <strong>3rd Person</strong> (He, she, it, they, etc.) ➔ <strong>অপরিবর্তিত</strong> থাকে
                    <div style="background: #f8fafc; border-left: 3px solid #0052cc; padding: 8px 12px; margin-top: 8px;">
                        <strong>Example:</strong> Rahim said to me, "I like you."<br>
                        ➔ Rahim told me that <strong>he</strong> liked <strong>me</strong>.
                    </div>
                </div>
            </div>

            <!-- Box 6: Tense Change Rules Table -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0;">
                <span style="background: #0052cc; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 6</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    6. TENSE CHANGE RULES (Past Tense-এ Reporting Verb থাকলে)
                </h3>
                <div style="overflow-x: auto;">
                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.82rem;">
                        <thead style="background: #0f172a; color: white;">
                            <tr><th>Direct Speech</th><th>Indirect Speech</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Present Simple (play)</td><td>Past Simple (played)</td></tr>
                            <tr><td>Present Continuous (am playing)</td><td>Past Continuous (was playing)</td></tr>
                            <tr><td>Present Perfect (have finished)</td><td>Past Perfect (had finished)</td></tr>
                            <tr><td>Present Perfect Cont. (have been)</td><td>Past Perfect Cont. (had been)</td></tr>
                            <tr><td>Past Simple (went)</td><td>Past Perfect (had gone)</td></tr>
                            <tr><td>Past Continuous (was reading)</td><td>Past Perfect Cont. (had been reading)</td></tr>
                            <tr><td>Past Perfect / Cont.</td><td>অপরিবর্তিত (No Change)</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Box 7, 8, 9, 10 Modals & Time Place -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <!-- Box 7 & 8: Future & Modals -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0;">
                <span style="background: #0052cc; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 7 & 8</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    7 & 8. MODAL VERB CHANGE RULES
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.85rem; font-family: 'Outfit', sans-serif;">
                    <div><code>will</code> ➔ <code>would</code></div>
                    <div><code>shall</code> ➔ <code>should / would</code></div>
                    <div><code>can</code> ➔ <code>could</code></div>
                    <div><code>may</code> ➔ <code>might</code></div>
                    <div><code>must</code> ➔ <code>had to / must</code></div>
                    <div><code>could/would/should</code> ➔ Unchanged</div>
                </div>
                <div style="margin-top: 15px; background: #fffbebf5; border: 1px solid #fef3c7; border-radius: 8px; padding: 10px; color: #92400e; font-size: 0.84rem; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>BOX 9 (Tense Change হবে না যখন):</strong><br>
                    ১. Reporting Verb Present/Future হলে (e.g. He says, "I am busy." ➔ He says that he is busy.)<br>
                    ২. চিরন্তন সত্য (Universal Truth) হলে।
                </div>
            </div>

            <!-- Box 10: Time & Place Words Table -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0;">
                <span style="background: #0052cc; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 10</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    10. TIME & PLACE CHANGE (সময় ও স্থান পরিবর্তন)
                </h3>
                <div style="overflow-x: auto;">
                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.82rem;">
                        <thead style="background: #0f172a; color: white;">
                            <tr><th>Direct Word</th><th>Indirect Word</th><th>Direct Word</th><th>Indirect Word</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>now</td><td>then</td><td>today</td><td>that day</td></tr>
                            <tr><td>tonight</td><td>that night</td><td>yesterday</td><td>the previous day</td></tr>
                            <tr><td>tomorrow</td><td>the next day</td><td>ago</td><td>before</td></tr>
                            <tr><td>last night</td><td>previous night</td><td>next week</td><td>the following week</td></tr>
                            <tr><td>here</td><td>there</td><td>this / these</td><td>that / those</td></tr>
                            <tr><td>come</td><td>go</td><td>-</td><td>-</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Box 11 - 18: Sentence Wise Rules Grid -->
        <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="color: #0052cc;">segment</i>
            <span>১১ থেকে ১৮: বাক্যভিত্তিক রূপান্তরের নিয়ম (Sentence Wise Rules)</span>
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Box 11 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 11</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">11. ASSERTIVE SENTENCE</h4>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>Structure:</strong> <code>said + that</code> or <code>said to ➔ told</code><br>
                    Direct: He said to me, "I am busy."<br>
                    ➔ Indirect: <strong>He told me that he was busy.</strong>
                </div>
            </div>

            <!-- Box 12 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 12</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">12. INTERROGATIVE SENTENCE</h4>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>Reporting Verb:</strong> <code>asked</code><br>
                    <strong>A. Yes/No:</strong> <code>if / whether</code> (He asked me if I was happy.)<br>
                    <strong>B. WH Question:</strong> <code>wh-word</code> (He asked me where I lived.)
                </div>
            </div>

            <!-- Box 13, 17, 18 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 13, 17, 18</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">13, 17, 18. IMPERATIVE SENTENCE</h4>
                <div style="font-size: 0.84rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • Order: <code>ordered + to + V1</code><br>
                    • Request (Please): <code>requested + to + V1</code><br>
                    • Advice: <code>advised + to + V1</code><br>
                    • Prohibition (Do Not): <code>told/advised + not to + V1</code>
                </div>
            </div>

            <!-- Box 14 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 14</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">14. OPTATIVE SENTENCE</h4>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>Reporting Verb:</strong> <code>wished / prayed / blessed / cursed</code><br>
                    <strong>Connector:</strong> <code>that</code> + Subject + <code>might</code> + V1<br>
                    <em>Ex: He prayed that Allah might help me.</em>
                </div>
            </div>

            <!-- Box 15 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 15</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">15. EXCLAMATORY SENTENCE</h4>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • Joy: <code>exclaimed with joy that</code><br>
                    • Sorrow: <code>exclaimed with sorrow that</code><br>
                    • Wonder: <code>exclaimed with wonder that</code><br>
                    <em>Ex: He exclaimed with joy that they had won.</em>
                </div>
            </div>

            <!-- Box 16 -->
            <div style="background: #ffffff; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0;">
                <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">BOX 16</span>
                <h4 style="font-weight: 800; font-size: 1.1rem; color: #0f172a; margin: 8px 0; font-family: 'Hind Siliguri', sans-serif;">16. LET-এর ব্যবহার</h4>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>A. Let us (Suggestion):</strong> <code>proposed/suggested + that + they should + V1</code><br>
                    <strong>B. Let me (Permission):</strong> <code>requested to be allowed to + V1</code>
                </div>
            </div>
        </div>

        <!-- Box 19 & 21: Steps & Mistakes -->
        <div style="display: grid; grid-template-columns: 1.1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <!-- Box 19: 9 Steps Conversion Process -->
            <div style="background: #0f172a; color: white; border-radius: 14px; padding: 22px;">
                <span style="background: #38bdf8; color: #0f172a; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 19</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #38bdf8; margin: 10px 0 12px 0; font-family: 'Hind Siliguri', sans-serif;">
                    19. FULL CONVERSION PROCESS (৯টি ধাপ)
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 0.84rem; font-family: 'Hind Siliguri', sans-serif;">
                    <div>Step 1: Sentence-এর ধরন নির্ণয়</div>
                    <div>Step 2: Reporting verb পরিবর্তন</div>
                    <div>Step 3: Inverted comma উঠানো</div>
                    <div>Step 4: Connector বসানো</div>
                    <div>Step 5: Person (Pronoun) পরিবর্তন</div>
                    <div>Step 6: Tense পরিবর্তন</div>
                    <div>Step 7: Time/Place word পরিবর্তন</div>
                    <div>Step 8: Pronoun সমন্বয়</div>
                    <div>Step 9: Structure পরীক্ষা করা</div>
                </div>
            </div>

            <!-- Box 21: Common Mistakes -->
            <div style="background: #ffffff; border-radius: 14px; padding: 22px; border: 1px solid #e2e8f0;">
                <span style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 21</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    21. COMMON MISTAKES (সাধারণ ভুল)
                </h3>
                <div style="overflow-x: auto;">
                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.82rem;">
                        <thead class="table-danger">
                            <tr><th>Wrong (ভুল)</th><th>Correct (সঠিক)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="text-danger">He said me that...</td><td class="text-success font-weight-bold">He told me that...</td></tr>
                            <tr><td class="text-danger">He asked me where did you go.</td><td class="text-success font-weight-bold">He asked me where I had gone.</td></tr>
                            <tr><td class="text-danger">He said that I am happy.</td><td class="text-success font-weight-bold">He said that he was happy.</td></tr>
                            <tr><td class="text-danger">He said me not to go.</td><td class="text-success font-weight-bold">He told me not to go.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- TAB 3: REPORTING VERBS & QUICK CHART (BOX 4, 24, 25) -->
    <div id="panel-verbs" class="tab-panel d-none">
        <!-- Box 4: Reporting Verbs Grid -->
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 4</span>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 6px 0 0 0; font-family: 'Hind Siliguri', sans-serif;">
                        4. COMMON REPORTING VERBS (৫০+ তালিকা)
                    </h3>
                </div>
                <input type="text" id="verb-search" placeholder="Search verb... (যেমন: say, ask, order)" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 8px 14px; font-size: 0.9rem; outline: none; width: 260px;" onkeyup="searchVerbs(this.value)">
            </div>

            <div id="verbs-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px;">
            </div>
        </div>

        <!-- Box 25: Quick Reference Chart -->
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 25</span>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 8px 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">
                25. QUICK REFERENCE CHART (সংক্ষিপ্ত সামারি চার্ট)
            </h3>
            <div style="overflow-x: auto;">
                <table class="table table-striped table-hover mb-0" style="font-size: 0.88rem;">
                    <thead style="background: #0f172a; color: white;">
                        <tr><th>Sentence Type</th><th>Comma Rule</th><th>Connector</th><th>Reporting Verb</th><th>Tense/Time Change</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Assertive</strong></td><td>Remove comma</td><td>that</td><td>said / told</td><td>As per tense rules</td></tr>
                        <tr><td><strong>Interrogative</strong></td><td>Remove comma</td><td>if / whether / wh-word</td><td>asked</td><td>As per tense rules</td></tr>
                        <tr><td><strong>Imperative</strong></td><td>Remove comma</td><td>to / not to</td><td>ordered / requested / advised</td><td>V1 remains base</td></tr>
                        <tr><td><strong>Optative</strong></td><td>Remove comma</td><td>that</td><td>wished / prayed</td><td>may ➔ might</td></tr>
                        <tr><td><strong>Exclamatory</strong></td><td>Remove comma</td><td>that</td><td>exclaimed with joy/sorrow</td><td>As per tense rules</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- CSS STYLING & HIGH CONTRAST FIXES -->
<style>
    .tab-btn:hover {
        color: #0052cc !important;
    }
    .verb-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 12px;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        transition: all 0.2s;
        cursor: pointer;
    }
    .verb-card:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #0052cc;
        transform: translateY(-2px);
    }
    /* Table Visibility and Contrast Fixes */
    .narration-hub-page table {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
    }
    .narration-hub-page table th,
    .narration-hub-page table thead tr th,
    .narration-hub-page table thead th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-color: #334155 !important;
        padding: 10px 14px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .narration-hub-page table td,
    .narration-hub-page table tbody tr td {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        font-weight: 600 !important;
        vertical-align: middle !important;
        padding: 10px 14px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .narration-hub-page table tbody tr:nth-child(even) td {
        background-color: #f8fafc !important;
    }
</style>

<!-- JAVASCRIPT LOGIC FOR NARRATION HUB -->
<script>
// Reporting Verbs list from Box 4
const REPORTING_VERBS_LIST = [
    "say", "says", "said", "tell", "tells", "told", "ask", "asked", 
    "reply", "replied", "order", "ordered", "request", "requested", "advise", "advised",
    "forbid", "forbade", "pray", "prayed", "exclaim", "exclaimed", "suggest", "suggested",
    "propose", "proposed", "insist", "insisted", "complain", "complained", "announce", "announced"
];

// Presets database with full 9-step conversion data
const NARRATION_PRESETS = {
    'Rahim said, "I am happy."': {
        type: "Assertive Sentence",
        mode: "Direct ➔ Indirect",
        converted: "Rahim said that he was happy.",
        steps: [
            "Step 1 (Sentence Type): Assertive Sentence চিহ্নিত করা হয়েছে।",
            "Step 2 (Reporting Verb): Reporting Verb 'said' অপরিবর্তিত রাখা হয়েছে।",
            "Step 3 & 4 (Comma & Connector): Inverted comma উঠিয়ে সংযোগকারী 'that' বসানো হয়েছে।",
            "Step 5 (Person Change): Reported speech-এর 1st Person 'I' ➔ Subject 'Rahim' (he) অনুযায়ী পরিবর্তন করা হয়েছে।",
            "Step 6 (Tense Change): Present Indefinite ('am happy') ➔ Past Indefinite ('was happy') এ রূপান্তর হয়েছে।",
            "Step 7, 8, 9 (Structure Test): সম্পূর্ণ বাক্য 'Rahim said that he was happy.' সঠিকভাবে গঠিত।"
        ]
    },
    'Rahim said to me, "I like you."': {
        type: "Assertive Sentence (with Object)",
        mode: "Direct ➔ Indirect",
        converted: "Rahim told me that he liked me.",
        steps: [
            "Step 1 (Sentence Type): Assertive Sentence চিহ্নিত।",
            "Step 2 (Reporting Verb): Object 'me' থাকায় 'said to' ➔ 'told' এ পরিবর্তন হয়েছে।",
            "Step 3 & 4 (Connector): Connector 'that' যুক্ত হয়েছে।",
            "Step 5 (Person Change): 1st Person 'I' ➔ 'he', 2nd Person 'you' ➔ Object 'me' অনুযায়ী পরিবর্তন হয়েছে।",
            "Step 6 (Tense Change): Present Indefinite ('like') ➔ Past Indefinite ('liked') রূপান্তর।",
            "Step 7, 8, 9: Rahim told me that he liked me."
        ]
    },
    'He said to me, "Are you happy?"': {
        type: "Interrogative Sentence (Yes/No)",
        mode: "Direct ➔ Indirect",
        converted: "He asked me if I was happy.",
        steps: [
            "Step 1 (Sentence Type): Interrogative Sentence (Yes/No Question)।",
            "Step 2 (Reporting Verb): Reporting Verb 'said to' ➔ 'asked' এ রূপান্তর।",
            "Step 3 & 4 (Connector): Yes/No প্রশ্ন হওয়ায় Connector হিসেবে 'if' যুক্ত হয়েছে।",
            "Step 5 (Person Change): 2nd Person 'you' ➔ Object 'me' (I)।",
            "Step 6 (Tense & Order): Interrogative থেকে Assertive এ রূপান্তর করে Tense 'am/are' ➔ 'was' করা হয়েছে।"
        ]
    },
    'He said to me, "Where do you live?"': {
        type: "Interrogative Sentence (WH)",
        mode: "Direct ➔ Indirect",
        converted: "He asked me where I lived.",
        steps: [
            "Step 1 (Sentence Type): Interrogative Sentence (WH Question)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'asked'।",
            "Step 3 & 4 (Connector): WH-word ('where') সংযোগকারী হিসেবে অপরিবর্তিত রাখা হয়েছে।",
            "Step 5 & 6 (Structure & Tense): Subject-Verb inversion তুলে দিয়ে Past Indefinite ('lived') করা হয়েছে।"
        ]
    },
    'The teacher said to me, "Open the door."': {
        type: "Imperative Sentence (Order)",
        mode: "Direct ➔ Indirect",
        converted: "The teacher ordered me to open the door.",
        steps: [
            "Step 1 (Sentence Type): Imperative Sentence (আদেশ / Order)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'ordered'।",
            "Step 3 & 4 (Connector): Inverted comma উঠিয়ে Connector 'to' বসানো হয়েছে।",
            "Step 5 & 6 (Verb Form): Connector 'to'-এর পর Verb-এর Base form ('open') বজায় রয়েছে।"
        ]
    },
    'He said to me, "Please help me."': {
        type: "Imperative Sentence (Request)",
        mode: "Direct ➔ Indirect",
        converted: "He requested me to help him.",
        steps: [
            "Step 1 (Sentence Type): Imperative Sentence ('Please' সহ অনুরোধ)।",
            "Step 2 (Reporting Verb): 'Please' থাকায় Reporting Verb ➔ 'requested'।",
            "Step 3 & 4 (Connector): Connector 'to' বসানো হয়েছে এবং 'please' বর্জন করা হয়েছে।",
            "Step 5 (Person Change): 1st Person 'me' ➔ Subject 'He' (him) অনুযায়ী পরিবর্তন হয়েছে।"
        ]
    },
    'Father said to me, "Work hard."': {
        type: "Imperative Sentence (Advice)",
        mode: "Direct ➔ Indirect",
        converted: "Father advised me to work hard.",
        steps: [
            "Step 1 (Sentence Type): Imperative Sentence (উপদেশ / Advice)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'advised'।",
            "Step 3 & 4 (Connector): Connector 'to' বসিয়ে 'to work hard' তৈরি করা হয়েছে।"
        ]
    },
    'Mother said to me, "Do not waste time."': {
        type: "Imperative Sentence (Prohibition)",
        mode: "Direct ➔ Indirect",
        converted: "Mother advised me not to waste time.",
        steps: [
            "Step 1 (Sentence Type): Imperative Sentence (নিষেধ / Prohibition)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'advised' / 'forbade'।",
            "Step 3 & 4 (Connector): Negative আদেশ থাকায় Connector ➔ 'not to' বসানো হয়েছে।"
        ]
    },
    'He said, "Let us go out."': {
        type: "Imperative Sentence (Let us)",
        mode: "Direct ➔ Indirect",
        converted: "He proposed that they should go out.",
        steps: [
            "Step 1 (Sentence Type): 'Let us' যুক্ত Imperative Sentence (প্রস্তাব / Proposal)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'proposed'।",
            "Step 3 & 4 (Connector): Connector 'that' বসানো হয়েছে।",
            "Step 5, 6 (Structure): 'Let us' এর পরিবর্তে 'they should' + V1 রূপান্তর প্রয়োগ হয়েছে।"
        ]
    },
    'He said, "May you be happy."': {
        type: "Optative Sentence (Wish)",
        mode: "Direct ➔ Indirect",
        converted: "He wished that I might be happy.",
        steps: [
            "Step 1 (Sentence Type): Optative Sentence (ইচ্ছা / Wish)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'wished'।",
            "Step 3 & 4 (Connector): Connector ➔ 'that'।",
            "Step 5 & 6 (Modal Change): Subject + 'might' + V1 ('I might be happy') রূপান্তর।"
        ]
    },
    'He said, "May Allah help you."': {
        type: "Optative Sentence (Prayer)",
        mode: "Direct ➔ Indirect",
        converted: "He prayed that Allah might help me.",
        steps: [
            "Step 1 (Sentence Type): Optative Sentence (প্রার্থনা / Prayer)।",
            "Step 2 (Reporting Verb): 'Allah' থাকায় Reporting Verb ➔ 'prayed'।",
            "Step 3 & 4 (Connector): Connector ➔ 'that'।",
            "Step 5 & 6: 'Allah might help me' গঠন প্রয়োগ।"
        ]
    },
    'He said, "Hurrah! We have won."': {
        type: "Exclamatory Sentence (Joy)",
        mode: "Direct ➔ Indirect",
        converted: "He exclaimed with joy that they had won.",
        steps: [
            "Step 1 (Sentence Type): Exclamatory Sentence ('Hurrah!' - আনন্দ)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'exclaimed with joy'।",
            "Step 3 & 4 (Connector): Connector 'that' বসানো হয়েছে।",
            "Step 5 & 6: Person 'We' ➔ 'they', Present Perfect ('have won') ➔ Past Perfect ('had won')।"
        ]
    },
    'He said, "Alas! I have lost my book."': {
        type: "Exclamatory Sentence (Sorrow)",
        mode: "Direct ➔ Indirect",
        converted: "He exclaimed with sorrow that he had lost his book.",
        steps: [
            "Step 1 (Sentence Type): Exclamatory Sentence ('Alas!' - দুঃখ)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'exclaimed with sorrow'।",
            "Step 3 & 4: Connector 'that' বসানো এবং 'Alas!' বর্জন।",
            "Step 5 & 6: Present Perfect ➔ Past Perfect ('had lost his book')।"
        ]
    },
    'He said, "What a beautiful flower!"': {
        type: "Exclamatory Sentence (Wonder)",
        mode: "Direct ➔ Indirect",
        converted: "He exclaimed with wonder that it was a very beautiful flower.",
        steps: [
            "Step 1 (Sentence Type): Exclamatory Sentence (বিস্ময় / Wonder)।",
            "Step 2 (Reporting Verb): Reporting Verb ➔ 'exclaimed with wonder'।",
            "Step 3 & 4: Connector ➔ 'that'।",
            "Step 5 & 6: Exclamatory গঠন থেকে Assertive 'it was a very beautiful flower' এ রূপান্তর।"
        ]
    },
    'The teacher said, "The sun rises in the east."': {
        type: "Universal Truth (চিরন্তন সত্য)",
        mode: "Direct ➔ Indirect",
        converted: "The teacher said that the sun rises in the east.",
        steps: [
            "Step 1 (Sentence Type): Assertive Sentence (Universal Truth)।",
            "Step 2 (Reporting Verb): 'said' অপরিবর্তিত।",
            "Step 3 & 4: Connector ➔ 'that'।",
            "Step 6 (Tense Change Special): চিরন্তন সত্য হওয়ায় Reported speech-এর Tense অপরিবর্তিত রয়েছে ('rises')।"
        ]
    },
    'He says, "I am busy."': {
        type: "Present Reporting Verb",
        mode: "Direct ➔ Indirect",
        converted: "He says that he is busy.",
        steps: [
            "Step 1 & 2: Reporting Verb Present Tense ('says') এ রয়েছে।",
            "Step 3 & 4: Connector ➔ 'that'।",
            "Step 6 (Tense Change Special): Reporting Verb Present Tense হওয়ায় Reported speech-এর Tense পরিবর্তন হয়নি ('is busy')।"
        ]
    }
};

let currentMode = 'd2i';

// Page init
document.addEventListener("DOMContentLoaded", function() {
    renderVerbsGrid();
});

// Mode switch
function setConversionMode(mode) {
    currentMode = mode;
    const btnD2I = document.getElementById('btn-mode-d2i');
    const btnI2D = document.getElementById('btn-mode-i2d');
    const inputLabel = document.getElementById('input-label');
    const inputArea = document.getElementById('narration-input');

    if (mode === 'd2i') {
        btnD2I.style.background = "#0052cc";
        btnD2I.style.color = "white";
        btnI2D.style.background = "transparent";
        btnI2D.style.color = "#475569";
        inputLabel.textContent = "Direct Speech ইনপুট দিন";
        inputArea.placeholder = 'যেমন: Rahim said, "I am happy."';
    } else {
        btnI2D.style.background = "#0052cc";
        btnI2D.style.color = "white";
        btnD2I.style.background = "transparent";
        btnD2I.style.color = "#475569";
        inputLabel.textContent = "Indirect Speech ইনপুট দিন";
        inputArea.placeholder = "যেমন: Rahim said that he was happy.";
    }

    convertNarration();
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

// Render Reporting Verbs Grid (Box 4)
function renderVerbsGrid(filter = "") {
    const container = document.getElementById('verbs-grid');
    if (!container) return;

    container.innerHTML = "";
    const filtered = REPORTING_VERBS_LIST.filter(v => v.toLowerCase().includes(filter.toLowerCase()));

    filtered.forEach(verb => {
        const card = document.createElement('div');
        card.className = 'verb-card';
        card.textContent = verb;
        card.onclick = () => {
            document.getElementById('narration-input').value = `He ${verb}, "I am ready."`;
            switchTab('converter');
            convertNarration();
        };
        container.appendChild(card);
    });
}

function searchVerbs(query) {
    renderVerbsGrid(query);
}

// Preset Handler
function applyPreset(val) {
    if (!val) return;
    document.getElementById('narration-input').value = val;
    convertNarration();
}

function loadRandomPreset() {
    const keys = Object.keys(NARRATION_PRESETS);
    const randKey = keys[Math.floor(Math.random() * keys.length)];
    document.getElementById('preset-selector').value = randKey;
    applyPreset(randKey);
}

function onNarrationInput() {
    document.getElementById('preset-selector').value = "";
    convertNarration();
}

// Main Narration Conversion & Analysis Logic
function convertNarration() {
    const textInput = document.getElementById('narration-input').value.trim();
    const emptyState = document.getElementById('result-empty');
    const activeState = document.getElementById('result-active');

    if (!textInput) {
        emptyState.classList.remove('d-none');
        activeState.classList.add('d-none');
        return;
    }

    emptyState.classList.add('d-none');
    activeState.classList.remove('d-none');

    // 1. Check Presets
    let data = NARRATION_PRESETS[textInput];

    if (!data) {
        // Dynamic Fallback Converter for Custom User Speech
        let sType = "Assertive Sentence";
        if (textInput.includes('?')) sType = "Interrogative Sentence";
        else if (textInput.includes('!')) sType = "Exclamatory Sentence";
        else if (textInput.toLowerCase().includes('may ') || textInput.toLowerCase().includes('allah')) sType = "Optative Sentence";
        else if (textInput.toLowerCase().includes('please') || textInput.toLowerCase().includes('do not') || textInput.toLowerCase().includes('let us')) sType = "Imperative Sentence";

        let convertedText = textInput;
        let stepsList = [];

        if (currentMode === 'd2i') {
            // Direct -> Indirect rule application
            convertedText = textInput
                .replace(/"([^"]+)"/g, function(match, reported) {
                    return "that " + reported;
                })
                .replace(/\bsaid to me\b/gi, "told me")
                .replace(/\bsaid to\b/gi, "told")
                .replace(/\bI am\b/gi, "he was")
                .replace(/\bI\b/g, "he")
                .replace(/\bmy\b/gi, "his")
                .replace(/\byou\b/gi, "me")
                .replace(/\bthis\b/gi, "that")
                .replace(/\bnow\b/gi, "then")
                .replace(/\btoday\b/gi, "that day")
                .replace(/[",]/g, "");

            stepsList = [
                `Step 1 (Sentence Type): ${sType} হিসেবে চিহ্নিত।`,
                `Step 2 (Reporting Verb): Reporting Verb সমন্বয় করা হয়েছে।`,
                `Step 3 & 4 (Connector): Inverted comma উঠিয়ে Connector বসানো হয়েছে।`,
                `Step 5 & 6 (Person & Tense): Pronoun এবং Tense পরিবর্তন বিধি প্রয়োগ করা হয়েছে।`,
                `Step 7 & 8 (Time/Place): সময় ও স্থানবাচক শব্দ পরিবর্তন সম্পন্ন।`
            ];
        } else {
            // Indirect -> Direct rule application
            convertedText = textInput
                .replace(/\btold me that\b/gi, 'said to me, "')
                .replace(/\bsaid that\b/gi, 'said, "')
                .replace(/\bhe was\b/gi, 'I am')
                .replace(/\bhe liked me\b/gi, 'I like you')
                .replace(/\bthat day\b/gi, "today")
                .replace(/\bthen\b/gi, "now") + '"';

            stepsList = [
                `Step 1: Indirect speech থেকে Direct speech রূপান্তর।`,
                `Step 2: Connector (that/if) তুলে দিয়ে ইনভার্টেড কমা (" ") যুক্ত করা হয়েছে।`,
                `Step 3: Tense এবং Pronoun কে পূর্বের Direct রূপ প্রদান করা হয়েছে।`
            ];
        }

        data = {
            type: sType,
            mode: currentMode === 'd2i' ? "Direct ➔ Indirect" : "Indirect ➔ Direct",
            converted: convertedText,
            steps: stepsList
        };
    }

    // 2. Render Badges
    document.getElementById('detected-type-badge').textContent = data.type;
    document.getElementById('mode-badge').textContent = currentMode === 'd2i' ? "Direct ➔ Indirect Speech" : "Indirect ➔ Direct Speech";

    // 3. Render Converted Speech
    document.getElementById('result-converted-speech').textContent = data.converted;

    // 4. Render 9-Step Breakdown (Box 19)
    const breakdownContainer = document.getElementById('step-breakdown-container');
    breakdownContainer.innerHTML = "";

    data.steps.forEach(step => {
        const item = document.createElement('div');
        item.style.padding = "4px 0";
        item.innerHTML = `✔ ${step}`;
        breakdownContainer.appendChild(item);
    });
}

// Copy & Speech Synthesis
function copyResultText() {
    const textVal = document.getElementById('result-converted-speech').textContent;
    if (textVal) {
        navigator.clipboard.writeText(textVal);
        alert("রূপান্তরিত বাক্যটি ক্লিপবোর্ডে কপি করা হয়েছে!");
    }
}

function speakResultText() {
    const textVal = document.getElementById('result-converted-speech').textContent;
    if (textVal && 'speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(textVal);
        utterance.lang = 'en-US';
        window.speechSynthesis.speak(utterance);
    }
}
</script>
@endsection
