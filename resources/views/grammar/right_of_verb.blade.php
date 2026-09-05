@extends('layouts.app')

@section('title', 'Right of Verb (Subject) - সম্পূর্ণ ব্যবহার ও সকল নিয়ম')

@section('content')
<div class="right-of-verb-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
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
            RIGHT OF VERB (SUBJECT) – সম্পূর্ণ ব্যবহার ও সকল নিয়ম
        </h1>
        <p style="color: #64748b; font-size: 1rem; margin-top: 10px; line-height: 1.6; max-width: 800px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            Right of Verb (Subject) বলতে Verb-এর পর Subject/Object/Complement কীভাবে ব্যবহার হয় এবং বাক্যের অর্থ পূর্ণ করে তা বোঝায়। এই ইন্টারেক্টিভ মডিউলে বাক্য এনালাইসিস, অটোমেটিক ডিটেকশন ও ৮টি ধরনে রূপান্তরের সুযোগ রয়েছে।
        </p>
    </div>

    <!-- Navigation Tabs (Only 3 Tabs: Converter, Guidebook, Verbs List) -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap;">
        <button type="button" class="tab-btn active" id="tab-converter" onclick="switchTab('converter')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #0052cc; border-bottom: 3px solid #0052cc; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">auto_awesome</i>
            <span>ইন্টারেক্টিভ এনালাইজার ও কনভার্টার</span>
        </button>
        <button type="button" class="tab-btn" id="tab-guide" onclick="switchTab('guide')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">menu_book</i>
            <span>১৮টি নিয়ম ও পূর্ণাঙ্গ গাইডবুক</span>
        </button>
        <button type="button" class="tab-btn" id="tab-verbs" onclick="switchTab('verbs')" style="background: none; border: none; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">list_alt</i>
            <span>গুরুত্বপূর্ণ Verbs তালিকা (৫০+)</span>
        </button>
    </div>

    <!-- TAB 1: INTERACTIVE CONVERTER & ANALYZER PANEL -->
    <div id="panel-converter" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.1fr; gap: 30px; align-items: start;">
            
            <!-- Left Controls Panel -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; display: flex; flex-direction: column; justify-content: space-between; min-height: 540px; color: #0f172a !important;">
                <div>
                    <!-- Preset Examples Selector -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: flex; justify-content: space-between; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">
                            <span>উদাহরণ বাক্য নির্বাচন করুন (Preset Sentences)</span>
                            <span style="font-size: 0.75rem; color: #0052cc; cursor: pointer; font-weight: 700;" onclick="loadRandomPreset()">🎲 র্যান্ডম বাক্য</span>
                        </label>
                        <select id="preset-selector" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 11px 12px; font-size: 0.9rem; color: #0f172a; outline: none; background: #f8fafc; font-family: 'Outfit', sans-serif;" onchange="applyPreset(this.value)">
                            <option value="">-- একটি উদাহরণ বেছে নিন --</option>
                            <option value="I know him.">1. Simple Subject: I know him.</option>
                            <option value="Rahim and Karim are friends.">2. Compound Subject: Rahim and Karim are friends.</option>
                            <option value="The team is playing well.">3. Collective Noun: The team is playing well.</option>
                            <option value="Honesty is the best policy.">4. Abstract Noun: Honesty is the best policy.</option>
                            <option value="Water is essential for life.">5. Material Noun: Water is essential for life.</option>
                            <option value="Swimming is good exercise.">6. Gerund: Swimming is good exercise.</option>
                            <option value="To learn is to gain.">7. Infinitive: To learn is to gain.</option>
                            <option value="That he is honest is true.">8. Clause: That he is honest is true.</option>
                            <option value="Reading makes a man perfect.">9. Gerund: Reading makes a man perfect.</option>
                            <option value="To err is human.">10. Infinitive: To err is human.</option>
                            <option value="What he said is correct.">11. Clause: What he said is correct.</option>
                            <option value="He likes.">12. Incomplete Sentence Test: He likes.</option>
                        </select>
                    </div>

                    <!-- Source Text Input -->
                    <div style="margin-bottom: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label style="font-weight: 700; font-size: 0.88rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">আপনার বাক্য ইনপুট দিন (Sentence Input)</label>
                            <span style="font-size: 0.75rem; color: #10b981; font-weight: 700;">● Live Auto-Detect</span>
                        </div>
                        <textarea id="sentence-input" rows="4" placeholder="যেমন: Swimming is good exercise or I know him..." style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 12px 15px; font-size: 0.95rem; background: #ffffff; color: #0f172a; resize: none; outline: none; line-height: 1.5; font-family: 'Outfit', sans-serif;" oninput="onSentenceInput()"></textarea>
                    </div>

                    <!-- Target Subject Form Conversion Selector -->
                    <div>
                        <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">রূপান্তরের ধরন (Target Subject Form)</label>
                        <select id="target-type" style="width: 100%; border-radius: 10px; border: 1px solid #0052cc; padding: 12px 14px; font-size: 0.9rem; color: #0f172a; outline: none; background: #eff6ff; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; font-weight: 600;" onchange="analyzeAndConvert()">
                            <option value="auto">বর্তমান রূপ ও বিস্তারিত এনালাইসিস দেখুন (Auto Analysis)</option>
                            <option value="Infinitive">1. Infinitive Form (To + Verb)</option>
                            <option value="Gerund">2. Gerund Form (V + ing)</option>
                            <option value="Clause">3. Clause Form (Sentence Clause)</option>
                            <option value="Simple Subject">4. Simple Subject (Noun/Pronoun)</option>
                            <option value="Compound Subject">5. Compound Subject (Plural Nouns)</option>
                            <option value="Collective Noun">6. Collective Noun (দল/সমষ্টি)</option>
                            <option value="Abstract Noun">7. Abstract Noun (গুণ/অবস্থা)</option>
                            <option value="Material Noun">8. Material Noun (বস্তু/উপাদান)</option>
                        </select>
                    </div>
                </div>

                <button type="button" onclick="analyzeAndConvert()" style="width: 100%; border-radius: 10px; background: #0052cc; color: #ffffff; border: none; padding: 14px; font-size: 1rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(0,82,204,0.25);">
                    <span>বাক্য এনালাইজ ও রূপান্তর করুন</span>
                    <i class="material-icons-round" style="font-size: 1.2rem;">auto_awesome</i>
                </button>
            </div>

            <!-- Right Results & Breakdown Panel -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; min-height: 540px; display: flex; flex-direction: column; color: #0f172a !important;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: #0f172a; margin: 0; font-family: 'Hind Siliguri', sans-serif;">এনালাইসিস ও রূপান্তর ফলাফল</h4>
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
                        <i class="material-icons-round" style="font-size: 2.2rem;">fact_check</i>
                    </div>
                    <h5 style="font-weight: 700; font-size: 1.05rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">ফলাফল দেখার জন্য প্রস্তুত</h5>
                    <p style="color: #64748b; font-size: 0.88rem; max-width: 340px; line-height: 1.5; margin-top: 6px; font-family: 'Hind Siliguri', sans-serif;">
                        ইনপুট বাক্সে একটি ইংরেজি বাক্য টাইপ করুন অথবা বামের Presets থেকে উদাহরণ বেছে নিন।
                    </p>
                </div>

                <!-- Analysis Active State -->
                <div id="result-active" class="d-none" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <!-- Badges Header -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">
                            <div style="background: #eff6ff; border: 1px solid #dbeafe; color: #2563eb; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <span>DETECTED TYPE:</span>
                                <span id="detected-type-badge">Gerund as Subject</span>
                            </div>
                            <div id="target-type-badge-container" style="background: #faf5ff; border: 1px solid #e9d5ff; color: #6b21a8; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="material-icons-round" style="font-size: 0.9rem;">transform</i>
                                <span id="target-type-badge">Converted to: Infinitive</span>
                            </div>
                        </div>

                        <!-- Converted Sentence Main Display Card -->
                        <div style="background: #0f172a; border-radius: 12px; padding: 20px; color: #ffffff; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(15,23,42,0.15);">
                            <div style="font-size: 0.75rem; font-weight: 700; color: #38bdf8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; font-family: 'Hind Siliguri', sans-serif;">রূপান্তরিত বাক্য (Converted Sentence)</div>
                            <h3 id="result-converted-sentence" style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin: 0; line-height: 1.5; font-family: 'Outfit', sans-serif;"></h3>
                            <div id="result-converted-explanation" style="font-size: 0.82rem; color: #94a3b8; margin-top: 8px; font-family: 'Hind Siliguri', sans-serif;"></div>
                        </div>

                        <!-- Sentence Structure Breakdown Banner -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px;">
                            <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">মূল বাক্যের স্ট্রাকচার (Original Sentence Parsing)</div>
                            
                            <div id="highlighted-sentence" style="font-size: 1.15rem; font-weight: 600; color: #0f172a; line-height: 1.6; margin-bottom: 10px; font-family: 'Outfit', sans-serif;">
                            </div>

                            <div style="display: flex; gap: 8px; flex-wrap: wrap; font-size: 0.75rem;">
                                <span style="background: #dbeafe; color: #1e40af; padding: 3px 8px; border-radius: 5px; font-weight: 700;">Subject</span>
                                <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 5px; font-weight: 700;">Verb</span>
                                <span style="background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 5px; font-weight: 700;">Right of Verb (Subject/Object)</span>
                            </div>
                        </div>

                        <!-- Step by Step Diagnostic Box -->
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px; margin-bottom: 15px;">
                            <h6 style="font-weight: 800; color: #1e40af; margin: 0 0 8px 0; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 6px;">
                                <i class="material-icons-round" style="font-size: 1.1rem;">analytics</i>
                                <span>Step-by-Step নির্ণয় পদ্ধতি</span>
                            </h6>
                            <div id="step-by-step-analysis" style="display: flex; flex-direction: column; gap: 5px; font-size: 0.85rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">
                            </div>
                        </div>

                        <!-- Completeness Warning Status -->
                        <div id="completeness-status-box" style="padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- TAB 2: DETAILED GUIDEBOOK (ALL 18 BOXES INCLUDED) -->
    <div id="panel-guide" class="tab-panel d-none">
        
        <!-- Grid of Concepts -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <!-- Box 1 -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 1</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 8px 0; font-family: 'Hind Siliguri', sans-serif;">
                    1. RIGHT OF VERB (SUBJECT) কী?
                </h3>
                <p style="color: #475569; font-size: 0.9rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    যে সমস্ত Sentence-এ Verb-এর পর কোনো Subject (Noun/Pronoun/Clause) ব্যবহার হয় তাকে <strong>Right of Verb (Subject)</strong> বলে।
                </p>
                <div style="background: #f8fafc; border-left: 4px solid #0052cc; padding: 10px 14px; border-radius: 4px; margin-top: 10px; font-size: 0.88rem;">
                    <strong>Structure:</strong> Subject (Before Verb) + Verb + Subject (After Verb)<br>
                    <strong>Example:</strong> <span style="color:#0052cc; font-weight: bold;">I</span> (Subject) <span style="color:#d97706; font-weight: bold;">know</span> (Verb) <span style="color:#16a34a; font-weight: bold;">him</span> (Right of Verb).
                </div>
            </div>

            <!-- Box 2 -->
            <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 2</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 10px 0 8px 0; font-family: 'Hind Siliguri', sans-serif;">
                    2. RIGHT OF VERB (SUBJECT) কেন হয়?
                </h3>
                <p style="color: #475569; font-size: 0.9rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    কিছু Verb-এর পর সম্পূর্ণ বাক্যের অর্থ বোঝাতে আরেকটি Noun/Noun Phrase/Clause লাগে। তা না থাকলে বাক্য অসম্পূর্ণ থাকে।
                </p>
                <ul style="color: #334155; font-size: 0.85rem; padding-left: 20px; line-height: 1.6; margin-top: 8px;">
                    <li>I know him.</li>
                    <li>He likes swimming.</li>
                    <li>We consider honesty the best policy.</li>
                    <li>She made me happy.</li>
                    <li>They elected him leader.</li>
                </ul>
            </div>
        </div>

        <!-- Box 3 & Box 4 Banner -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <!-- Box 3 -->
            <div style="background: #0f172a; color: #ffffff; border-radius: 14px; padding: 22px;">
                <span style="background: #38bdf8; color: #0f172a; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 3</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #38bdf8; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    3. RIGHT OF VERB (SUBJECT)-এর ৮টি ধরন
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif;">
                    <div>1. Simple Subject</div>
                    <div>2. Compound Subject</div>
                    <div>3. Collective Noun</div>
                    <div>4. Abstract Noun</div>
                    <div>5. Material Noun</div>
                    <div>6. Gerund (V+ing)</div>
                    <div>7. Infinitive (To + V)</div>
                    <div>8. Clause as Subject</div>
                </div>
            </div>

            <!-- Box 4 -->
            <div style="background: #fffbebf5; border: 1px solid #fef3c7; border-radius: 14px; padding: 22px; color: #92400e;">
                <span style="background: #f59e0b; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 4</span>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #b45309; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    4. কীভাবে নির্ণয় করবেন?
                </h3>
                <div style="font-size: 0.85rem; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
                    ✔ Verb-এর পর কি Noun আছে?<br>
                    ✔ Pronoun আছে?<br>
                    ✔ Noun Phrase / Gerund (V+ing) আছে?<br>
                    ✔ Infinitive (to + V) / Clause আছে?<br>
                    <strong>থাকলেই সেটাই Right of Verb (Subject)।</strong>
                </div>
            </div>
        </div>

        <!-- 8 SUBJECT TYPES TABLES (BOX 5 - 12) -->
        <h3 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="color: #0052cc;">grid_view</i>
            <span>৮টি ধরণের উদাহরণ তালিকা (১০টি করে উদাহরণ)</span>
        </h3>

        <!-- Interactive Filter Bar for Tables -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
            <button class="filter-pill active" onclick="filterTables('all')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #0052cc; color: white; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">সবগুলো দেখুন (All 8)</button>
            <button class="filter-pill" onclick="filterTables('box-5')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">1. Simple Subject</button>
            <button class="filter-pill" onclick="filterTables('box-6')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">2. Compound</button>
            <button class="filter-pill" onclick="filterTables('box-7')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">3. Collective</button>
            <button class="filter-pill" onclick="filterTables('box-8')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">4. Abstract</button>
            <button class="filter-pill" onclick="filterTables('box-9')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">5. Material</button>
            <button class="filter-pill" onclick="filterTables('box-10')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">6. Gerund</button>
            <button class="filter-pill" onclick="filterTables('box-11')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">7. Infinitive</button>
            <button class="filter-pill" onclick="filterTables('box-12')" style="padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; font-size: 0.8rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">8. Clause</button>
        </div>

        <!-- Tables Container -->
        <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px;">
            
            <!-- Box 5: Simple Subject -->
            <div class="guide-table-box box-5" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    5. SIMPLE SUBJECT (SINGULAR) – একটি মাত্র Noun/Pronoun
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>No.</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>I know him.</td><td><span class="badge-verb">know</span></td><td><span class="badge-rov">him</span></td></tr>
                            <tr><td>2</td><td>He likes football.</td><td><span class="badge-verb">likes</span></td><td><span class="badge-rov">football</span></td></tr>
                            <tr><td>3</td><td>She needs help.</td><td><span class="badge-verb">needs</span></td><td><span class="badge-rov">help</span></td></tr>
                            <tr><td>4</td><td>They saw a bird.</td><td><span class="badge-verb">saw</span></td><td><span class="badge-rov">a bird</span></td></tr>
                            <tr><td>5</td><td>We respect our teacher.</td><td><span class="badge-verb">respect</span></td><td><span class="badge-rov">our teacher</span></td></tr>
                            <tr><td>6</td><td>I want a pen.</td><td><span class="badge-verb">want</span></td><td><span class="badge-rov">a pen</span></td></tr>
                            <tr><td>7</td><td>He found a book.</td><td><span class="badge-verb">found</span></td><td><span class="badge-rov">a book</span></td></tr>
                            <tr><td>8</td><td>She made a cake.</td><td><span class="badge-verb">made</span></td><td><span class="badge-rov">a cake</span></td></tr>
                            <tr><td>9</td><td>You have a motorcycle.</td><td><span class="badge-verb">have</span></td><td><span class="badge-rov">a motorcycle</span></td></tr>
                            <tr><td>10</td><td>They elected a leader.</td><td><span class="badge-verb">elected</span></td><td><span class="badge-rov">a leader</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 6: Compound Subject -->
            <div class="guide-table-box box-6" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    6. COMPOUND SUBJECT (PLURAL) – দুই বা ততধিক Noun/Pronoun যুক্ত
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>No.</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Rahim and Karim are friends.</td><td><span class="badge-verb">are</span></td><td><span class="badge-rov">Rahim and Karim</span></td></tr>
                            <tr><td>2</td><td>Books and copies are on the table.</td><td><span class="badge-verb">are</span></td><td><span class="badge-rov">books and copies</span></td></tr>
                            <tr><td>3</td><td>Bread and butter is my breakfast.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">bread and butter</span></td></tr>
                            <tr><td>4</td><td>Truth and honesty lead to success.</td><td><span class="badge-verb">lead</span></td><td><span class="badge-rov">truth and honesty</span></td></tr>
                            <tr><td>5</td><td>Pen and ink are used for writing.</td><td><span class="badge-verb">are</span></td><td><span class="badge-rov">pen and ink</span></td></tr>
                            <tr><td>6</td><td>Cats and dogs are animals.</td><td><span class="badge-verb">are</span></td><td><span class="badge-rov">cats and dogs</span></td></tr>
                            <tr><td>7</td><td>Salt and sugar is harmful.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">salt and sugar</span></td></tr>
                            <tr><td>8</td><td>Oil and water do not mix.</td><td><span class="badge-verb">do not mix</span></td><td><span class="badge-rov">oil and water</span></td></tr>
                            <tr><td>9</td><td>Honesty and hard work bring success.</td><td><span class="badge-verb">bring</span></td><td><span class="badge-rov">honesty and hard work</span></td></tr>
                            <tr><td>10</td><td>Noodles and soup is my lunch.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">noodles and soup</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 7: Collective Noun -->
            <div class="guide-table-box box-7" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    7. COLLECTIVE NOUN AS SUBJECT (SINGULAR) – সমষ্টিবাচক বিশেষ্য
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>Collective Noun</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Team</td><td>The team is playing well.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the team</span></td></tr>
                            <tr><td>Class</td><td>The class is silent.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the class</span></td></tr>
                            <tr><td>Crowd</td><td>The crowd was cheering.</td><td><span class="badge-verb">was</span></td><td><span class="badge-rov">the crowd</span></td></tr>
                            <tr><td>Committee</td><td>The committee has decided.</td><td><span class="badge-verb">has</span></td><td><span class="badge-rov">the committee</span></td></tr>
                            <tr><td>Army</td><td>The army is ready.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the army</span></td></tr>
                            <tr><td>Group</td><td>The group is small.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the group</span></td></tr>
                            <tr><td>Audience</td><td>The audience listened.</td><td><span class="badge-verb">listened</span></td><td><span class="badge-rov">the audience</span></td></tr>
                            <tr><td>Staff</td><td>The staff is cooperative.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the staff</span></td></tr>
                            <tr><td>Government</td><td>The government is working.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">the government</span></td></tr>
                            <tr><td>Family</td><td>My family is happy.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">my family</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 8: Abstract Noun -->
            <div class="guide-table-box box-8" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    8. ABSTRACT NOUN AS SUBJECT (SINGULAR) – গুণ, অবস্থা বা ধারণা
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>Abstract Noun</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Honesty</td><td>Honesty is the best policy.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">honesty</span></td></tr>
                            <tr><td>Courage</td><td>Courage wins the heart.</td><td><span class="badge-verb">wins</span></td><td><span class="badge-rov">courage</span></td></tr>
                            <tr><td>Beauty</td><td>Beauty lies in goodness.</td><td><span class="badge-verb">lies</span></td><td><span class="badge-rov">beauty</span></td></tr>
                            <tr><td>Knowledge</td><td>Knowledge is power.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">knowledge</span></td></tr>
                            <tr><td>Patience</td><td>Patience brings success.</td><td><span class="badge-verb">brings</span></td><td><span class="badge-rov">patience</span></td></tr>
                            <tr><td>Truth</td><td>Truth is bitter.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">truth</span></td></tr>
                            <tr><td>Love</td><td>Love makes life beautiful.</td><td><span class="badge-verb">makes</span></td><td><span class="badge-rov">love</span></td></tr>
                            <tr><td>Kindness</td><td>Kindness is a virtue.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">kindness</span></td></tr>
                            <tr><td>Happiness</td><td>Happiness depends on peace.</td><td><span class="badge-verb">depends</span></td><td><span class="badge-rov">happiness</span></td></tr>
                            <tr><td>Wisdom</td><td>Wisdom guides us.</td><td><span class="badge-verb">guides</span></td><td><span class="badge-rov">wisdom</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 9: Material Noun -->
            <div class="guide-table-box box-9" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    9. MATERIAL NOUN AS SUBJECT (SINGULAR) – বস্তু বা উপাদান
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>Material Noun</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Water</td><td>Water is essential for life.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">water</span></td></tr>
                            <tr><td>Milk</td><td>Milk is good for health.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">milk</span></td></tr>
                            <tr><td>Gold</td><td>Gold is a precious metal.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">gold</span></td></tr>
                            <tr><td>Iron</td><td>Iron is used in many things.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">iron</span></td></tr>
                            <tr><td>Sugar</td><td>Sugar is sweet.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">sugar</span></td></tr>
                            <tr><td>Oil</td><td>Oil is useful.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">oil</span></td></tr>
                            <tr><td>Wood</td><td>Wood is used for furniture.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">wood</span></td></tr>
                            <tr><td>Rice</td><td>Rice is our main food.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">rice</span></td></tr>
                            <tr><td>Salt</td><td>Salt is necessary.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">salt</span></td></tr>
                            <tr><td>Air</td><td>Air is important.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">air</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 10: Gerund -->
            <div class="guide-table-box box-10" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    10. GERUND AS SUBJECT (V+ING) – Verb-এর -ing রূপ Noun হিসেবে
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>No.</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Swimming is good exercise.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">swimming</span></td></tr>
                            <tr><td>2</td><td>Reading makes a man perfect.</td><td><span class="badge-verb">makes</span></td><td><span class="badge-rov">reading</span></td></tr>
                            <tr><td>3</td><td>Writing is my hobby.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">writing</span></td></tr>
                            <tr><td>4</td><td>Learning English is important.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">learning English</span></td></tr>
                            <tr><td>5</td><td>Playing games is fun.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">playing games</span></td></tr>
                            <tr><td>6</td><td>Speaking the truth is a duty.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">speaking the truth</span></td></tr>
                            <tr><td>7</td><td>Helping others is a virtue.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">helping others</span></td></tr>
                            <tr><td>8</td><td>Walking daily is good for health.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">walking daily</span></td></tr>
                            <tr><td>9</td><td>Solving problems is not easy.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">solving problems</span></td></tr>
                            <tr><td>10</td><td>Listening carefully is important.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">listening carefully</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 11: Infinitive -->
            <div class="guide-table-box box-11" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    11. INFINITIVE AS SUBJECT (TO + VERB) – To + Verb ফর্ম
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>No.</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>To learn is to gain.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to learn</span></td></tr>
                            <tr><td>2</td><td>To err is human.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to err</span></td></tr>
                            <tr><td>3</td><td>To help others is noble.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to help others</span></td></tr>
                            <tr><td>4</td><td>To see is to believe.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to see</span></td></tr>
                            <tr><td>5</td><td>To succeed is difficult.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to succeed</span></td></tr>
                            <tr><td>6</td><td>To be honest is the best policy.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to be honest</span></td></tr>
                            <tr><td>7</td><td>To read good books is useful.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to read good books</span></td></tr>
                            <tr><td>8</td><td>To forgive is divine.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to forgive</span></td></tr>
                            <tr><td>9</td><td>To try is better than to cry.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to try</span></td></tr>
                            <tr><td>10</td><td>To love is to live.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">to love</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box 12: Clause -->
            <div class="guide-table-box box-12" style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
                <div style="background: #f1f5f9; padding: 14px 20px; font-weight: 800; font-size: 1rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">
                    12. CLAUSE AS SUBJECT – সম্পূর্ণ বাক্যাংশ (Clause)
                </div>
                <div style="overflow-x: auto; padding: 15px;">
                    <table class="table table-bordered mb-0" style="font-size: 0.88rem; width: 100%;">
                        <thead class="table-dark">
                            <tr><th>No.</th><th>Example Sentence</th><th>Verb</th><th>Right of Verb (Subject)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>That he is honest is true.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">that he is honest</span></td></tr>
                            <tr><td>2</td><td>What he said is correct.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">what he said</span></td></tr>
                            <tr><td>3</td><td>Whether he will come is not known.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">whether he will come</span></td></tr>
                            <tr><td>4</td><td>When he will arrive is uncertain.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">when he will arrive</span></td></tr>
                            <tr><td>5</td><td>How he did it is amazing.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">how he did it</span></td></tr>
                            <tr><td>6</td><td>Who will win is not decided.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">who will win</span></td></tr>
                            <tr><td>7</td><td>Why he is late is a question.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">why he is late</span></td></tr>
                            <tr><td>8</td><td>If he comes, we shall be happy.</td><td><span class="badge-verb">shall be</span></td><td><span class="badge-rov">if he comes</span></td></tr>
                            <tr><td>9</td><td>Because he worked hard is clear.</td><td><span class="badge-verb">is</span></td><td><span class="badge-rov">because he worked hard</span></td></tr>
                            <tr><td>10</td><td>Though he tried, he failed.</td><td><span class="badge-verb">failed</span></td><td><span class="badge-rov">though he tried</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Box 13, 17, 18 Extra Rules & Mistake Comparisons -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <!-- Box 13: General Rules -->
            <div style="background: #ffffff; border-radius: 14px; padding: 22px; border: 1px solid #e2e8f0;">
                <span style="background: #0052cc; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 13</span>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    13. ব্যবহারের সাধারণ ৬টি নিয়ম
                </h3>
                <ol style="color: #334155; font-size: 0.88rem; line-height: 1.8; padding-left: 18px; font-family: 'Hind Siliguri', sans-serif; margin: 0;">
                    <li>কিছু Verb-এর পর অবশ্যই Right of Verb (Subject) বসে।</li>
                    <li>সাধারণত Noun / Pronoun / Noun Phrase / Gerund / Infinitive / Clause বসে।</li>
                    <li>যদি Right of Verb না থাকে তবে বাক্য অসম্পূর্ণ হয়।</li>
                    <li>Right of Verb সব সময় Verb-এর পর বসে।</li>
                    <li>Right of Verb কখনও কখনও Preposition-এর পর বসে।</li>
                    <li>Right of Verb গুলো Sentence-এর Object এর সমতুল্য।</li>
                </ol>
            </div>

            <!-- Box 17: Common Mistakes -->
            <div style="background: #ffffff; border-radius: 14px; padding: 22px; border: 1px solid #e2e8f0;">
                <span style="background: #ef4444; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 17</span>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 10px 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">
                    17. সাধারণ ভুল (Common Mistakes)
                </h3>
                <div style="overflow-x: auto;">
                    <table class="table table-sm table-bordered mb-0" style="font-size: 0.85rem;">
                        <thead>
                            <tr class="table-danger"><th>Wrong (ভুল)</th><th>Correct (সঠিক)</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="text-danger">He likes.</td><td class="text-success font-weight-bold">He likes football.</td></tr>
                            <tr><td class="text-danger">She knows.</td><td class="text-success font-weight-bold">She knows him.</td></tr>
                            <tr><td class="text-danger">They made.</td><td class="text-success font-weight-bold">They made a cake.</td></tr>
                            <tr><td class="text-danger">We need.</td><td class="text-success font-weight-bold">We need your help.</td></tr>
                            <tr><td class="text-danger">I prefer.</td><td class="text-success font-weight-bold">I prefer tea.</td></tr>
                            <tr><td class="text-danger">To learn is.</td><td class="text-success font-weight-bold">To learn is to gain.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Box 18: Quick Reference Chart -->
        <div style="background: #ffffff; border-radius: 14px; padding: 22px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
            <span style="background: #10b981; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 18</span>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 10px 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">
                18. Quick Reference Chart (সংক্ষিপ্ত সামারি চার্ট)
            </h3>
            <div style="overflow-x: auto;">
                <table class="table table-striped table-hover mb-0" style="font-size: 0.88rem;">
                    <thead style="background: #0f172a; color: white;">
                        <tr><th>Subject Type</th><th>Example</th><th>Structure Formula</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Simple Subject</strong></td><td>I know him.</td><td><code>S + V + Noun/Pronoun</code></td></tr>
                        <tr><td><strong>Compound Subject</strong></td><td>Rahim and Karim are friends.</td><td><code>S + V + Noun Phrase</code></td></tr>
                        <tr><td><strong>Collective Noun</strong></td><td>The team is playing.</td><td><code>S + V + Collective Noun</code></td></tr>
                        <tr><td><strong>Abstract Noun</strong></td><td>Honesty is virtue.</td><td><code>S + V + Abstract Noun</code></td></tr>
                        <tr><td><strong>Material Noun</strong></td><td>Water is life.</td><td><code>S + V + Material Noun</code></td></tr>
                        <tr><td><strong>Gerund</strong></td><td>Swimming is good.</td><td><code>S + V + V+ing</code></td></tr>
                        <tr><td><strong>Infinitive</strong></td><td>To learn is to gain.</td><td><code>S + V + To + V</code></td></tr>
                        <tr><td><strong>Clause</strong></td><td>That he is honest is true.</td><td><code>S + V + Clause</code></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- TAB 3: KEY VERBS LIST (BOX 14) -->
    <div id="panel-verbs" class="tab-panel d-none">
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 800;">BOX 14</span>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 6px 0 0 0; font-family: 'Hind Siliguri', sans-serif;">
                        RIGHT OF VERB (SUBJECT) বসে এমন গুরুত্বপূর্ণ ৫০+ VERB তালিকা
                    </h3>
                </div>
                <input type="text" id="verb-search" placeholder="Search verb... (যেমন: know, like, consider)" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 8px 14px; font-size: 0.9rem; outline: none; width: 260px;" onkeyup="searchVerbs(this.value)">
            </div>

            <div id="verbs-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px;">
                <!-- Populated dynamically via Javascript -->
            </div>
        </div>
    </div>

</div>

<!-- CSS STYLING & RESPONSIVE DESIGN -->
<style>
    .tab-btn:hover {
        color: #0052cc !important;
    }
    .filter-pill.active {
        background: #0052cc !important;
        color: #ffffff !important;
        border-color: #0052cc !important;
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

    /* High Contrast & Visible Table Styles */
    .right-of-verb-page table {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
    }
    .right-of-verb-page table th,
    .right-of-verb-page table thead tr th,
    .right-of-verb-page table thead th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-color: #334155 !important;
        padding: 12px 15px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .right-of-verb-page table td,
    .right-of-verb-page table tbody tr td {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        font-weight: 600 !important;
        vertical-align: middle !important;
        padding: 10px 15px !important;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif !important;
    }
    .right-of-verb-page table tbody tr:nth-child(even) td {
        background-color: #f8fafc !important;
    }
    .right-of-verb-page table tbody tr:hover td {
        background-color: #eff6ff !important;
    }
    /* Table badges */
    .badge-verb {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fde68a !important;
        padding: 4px 10px !important;
        border-radius: 6px !important;
        font-weight: 700 !important;
        display: inline-block !important;
        font-size: 0.8rem !important;
    }
    .badge-rov {
        background-color: #dcfce7 !important;
        color: #166534 !important;
        border: 1px solid #bbf7d0 !important;
        padding: 4px 10px !important;
        border-radius: 6px !important;
        font-weight: 700 !important;
        display: inline-block !important;
        font-size: 0.8rem !important;
    }
</style>

<!-- JAVASCRIPT LOGIC FOR RIGHT OF VERB HUB -->
<script>
// 50+ Verbs List from Sheet (Box 14)
const VERBS_LIST = [
    "know", "see", "make", "call", "show", "send", "waste", "admire",
    "like", "watch", "consider", "name", "teach", "bring", "save", "respect",
    "love", "notice", "think", "keep", "tell", "lend", "leave", "envy",
    "hate", "observe", "believe", "hold", "ask", "own", "expect", "pity",
    "want", "find", "suppose", "elect", "answer", "pay", "mean", "forgive",
    "need", "discover", "imagine", "declare", "give", "cost", "include", "blame",
    "prefer", "feel", "prove", "offer", "spend", "contain", "thank", "choose", "appoint"
];

// Presets & Multi-type conversion map for top accuracy
const CONVERSION_MAP = {
    "Swimming is good exercise.": {
        subject: "Swimming", verb: "is", rightOfVerb: "good exercise", type: "Gerund",
        conversions: {
            "Infinitive": { text: "To swim is good exercise.", exp: "Subject-এ 'To + Verb' (To swim) ব্যবহার করে Infinitive তৈরি করা হয়েছে।" },
            "Gerund": { text: "Swimming is good exercise.", exp: "Subject-এ Verb+ing (Swimming) ব্যবহৃত হয়েছে।" },
            "Clause": { text: "That swimming is good exercise is true.", exp: "সম্পূর্ণ বাক্যটিকে Noun Clause হিসেবে 'is true'-এর Subject করা হয়েছে।" },
            "Simple Subject": { text: "Swimming is a great activity.", exp: "একটি মাত্র Noun Subject হিসেবে ব্যবহৃত।" },
            "Compound Subject": { text: "Swimming and running are good exercises.", exp: "দুইটি Gerund যুক্ত করে Plural Compound Subject তৈরি করা হয়েছে।" },
            "Collective Noun": { text: "The swimming team practices daily.", exp: "দলগত Noun 'The swimming team' Subject হিসেবে ব্যবহৃত।" },
            "Abstract Noun": { text: "Fitness is necessary for health.", exp: "Abstract Noun 'Fitness' Subject করা হয়েছে।" },
            "Material Noun": { text: "Water is needed for swimming.", exp: "Material Noun 'Water' Subject হিসেবে ব্যবহৃত।" }
        }
    },
    "To learn is to gain.": {
        subject: "To learn", verb: "is", rightOfVerb: "to gain", type: "Infinitive",
        conversions: {
            "Gerund": { text: "Learning is gaining.", exp: "Infinitive (To learn/to gain) কে Gerund (Learning/gaining) এ রূপান্তর করা হয়েছে।" },
            "Infinitive": { text: "To learn is to gain.", exp: "Infinitive (To + Verb) ফর্ম।" },
            "Clause": { text: "That we learn is beneficial.", exp: "Noun Clause 'That we learn' Subject করা হয়েছে।" },
            "Simple Subject": { text: "Knowledge brings gain.", exp: "Simple Noun 'Knowledge' Subject করা হয়েছে।" },
            "Compound Subject": { text: "Learning and practicing bring gain.", exp: "Compound Subject তৈরি করা হয়েছে।" },
            "Collective Noun": { text: "The study group is gaining.", exp: "Collective Noun 'The study group' ব্যবহার করা হয়েছে।" },
            "Abstract Noun": { text: "Education is valuable.", exp: "Abstract Noun 'Education' Subject।" },
            "Material Noun": { text: "Books are sources of learning.", exp: "Material/Concrete Noun Subject।" }
        }
    },
    "I know him.": {
        subject: "I", verb: "know", rightOfVerb: "him", type: "Simple Subject",
        conversions: {
            "Gerund": { text: "Knowing him is helpful.", exp: "Right of Verb 'him' এর সাথে যুক্ত করে Gerund Subject তৈরি করা হয়েছে।" },
            "Infinitive": { text: "To know him is a pleasure.", exp: "Infinitive (To know him) Subject করা হয়েছে।" },
            "Clause": { text: "What I know about him is true.", exp: "Noun Clause 'What I know about him' Subject করা হয়েছে।" },
            "Simple Subject": { text: "I know him well.", exp: "Simple Subject (I) + Verb (know) + Object (him)।" },
            "Compound Subject": { text: "My friend and I know him.", exp: "Compound Subject (My friend and I) তৈরি করা হয়েছে।" },
            "Collective Noun": { text: "The committee knows him.", exp: "Collective Noun 'The committee' Subject হিসেবে বসেছে।" },
            "Abstract Noun": { text: "Knowledge of him is clear.", exp: "Abstract Noun 'Knowledge' Subject করা হয়েছে।" },
            "Material Noun": { text: "Paper records show him.", exp: "Material Noun Subject।" }
        }
    },
    "Rahim and Karim are friends.": {
        subject: "Rahim and Karim", verb: "are", rightOfVerb: "friends", type: "Compound Subject",
        conversions: {
            "Simple Subject": { text: "Rahim is a good friend.", exp: "একটি মাত্র Noun Subject করে Singular করা হয়েছে।" },
            "Compound Subject": { text: "Rahim and Karim are friends.", exp: "দুইটি Noun যুক্ত Compound Subject।" },
            "Collective Noun": { text: "The group consists of friends.", exp: "Collective Noun 'The group' Subject করা হয়েছে।" },
            "Gerund": { text: "Befriending Karim is nice.", exp: "Gerund (Befriending) Subject করা হয়েছে।" },
            "Infinitive": { text: "To be friends is wonderful.", exp: "Infinitive (To be friends) Subject করা হয়েছে।" },
            "Clause": { text: "That Rahim and Karim are friends is known.", exp: "Clause Subject করা হয়েছে।" },
            "Abstract Noun": { text: "Friendship unites Rahim and Karim.", exp: "Abstract Noun 'Friendship' Subject।" },
            "Material Noun": { text: "Gifts strengthen their friendship.", exp: "Material Noun Subject।" }
        }
    },
    "The team is playing well.": {
        subject: "The team", verb: "is playing", rightOfVerb: "well", type: "Collective Noun",
        conversions: {
            "Collective Noun": { text: "The team is playing well.", exp: "Collective Noun 'The team' Subject।" },
            "Simple Subject": { text: "The captain is playing well.", exp: "Simple Subject (The captain) করা হয়েছে।" },
            "Compound Subject": { text: "The coach and the team are ready.", exp: "Compound Subject তৈরি করা হয়েছে।" },
            "Gerund": { text: "Playing well is their goal.", exp: "Gerund (Playing well) Subject করা হয়েছে।" },
            "Infinitive": { text: "To play well is important.", exp: "Infinitive (To play well) Subject করা হয়েছে।" },
            "Clause": { text: "How the team plays is amazing.", exp: "Noun Clause 'How the team plays' Subject করা হয়েছে।" },
            "Abstract Noun": { text: "Victory belongs to the team.", exp: "Abstract Noun 'Victory' Subject।" },
            "Material Noun": { text: "The ball is moving fast.", exp: "Material Noun 'The ball' Subject।" }
        }
    },
    "Honesty is the best policy.": {
        subject: "Honesty", verb: "is", rightOfVerb: "the best policy", type: "Abstract Noun",
        conversions: {
            "Abstract Noun": { text: "Honesty is the best policy.", exp: "Abstract Noun 'Honesty' Subject।" },
            "Gerund": { text: "Being honest is the best policy.", exp: "Gerund 'Being honest' Subject হিসেবে রূপান্তর করা হয়েছে।" },
            "Infinitive": { text: "To be honest is the best policy.", exp: "Infinitive 'To be honest' Subject হিসেবে রূপান্তর করা হয়েছে।" },
            "Clause": { text: "That one should be honest is clear.", exp: "Noun Clause Subject হিসেবে রূপান্তর করা হয়েছে।" },
            "Simple Subject": { text: "An honest man follows policy.", exp: "Simple Subject 'An honest man' রূপান্তর।" },
            "Compound Subject": { text: "Honesty and truth lead to success.", exp: "Compound Subject রূপান্তর।" },
            "Collective Noun": { text: "The society values honesty.", exp: "Collective Noun 'The society' Subject।" },
            "Material Noun": { text: "Gold cannot buy honesty.", exp: "Material Noun Subject।" }
        }
    },
    "Water is essential for life.": {
        subject: "Water", verb: "is", rightOfVerb: "essential for life", type: "Material Noun",
        conversions: {
            "Material Noun": { text: "Water is essential for life.", exp: "Material Noun 'Water' Subject।" },
            "Gerund": { text: "Drinking water is essential for life.", exp: "Gerund 'Drinking water' Subject হিসেবে রূপান্তর করা হয়েছে।" },
            "Infinitive": { text: "To drink water is essential for life.", exp: "Infinitive 'To drink water' Subject রূপান্তর।" },
            "Clause": { text: "That water is essential is true.", exp: "Clause Subject রূপান্তর।" },
            "Simple Subject": { text: "Water sustains all life.", exp: "Simple Material Subject।" },
            "Compound Subject": { text: "Water and air are essential.", exp: "Compound Material Subject।" },
            "Collective Noun": { text: "The community needs water.", exp: "Collective Noun Subject।" },
            "Abstract Noun": { text: "Purity of water is vital.", exp: "Abstract Noun 'Purity' Subject।" }
        }
    },
    "That he is honest is true.": {
        subject: "That he is honest", verb: "is", rightOfVerb: "true", type: "Clause",
        conversions: {
            "Clause": { text: "That he is honest is true.", exp: "Clause as Subject ('That he is honest')।" },
            "Abstract Noun": { text: "His honesty is true.", exp: "Clause থেকে Abstract Noun ('His honesty') এ রূপান্তর করা হয়েছে।" },
            "Gerund": { text: "Being honest is true of him.", exp: "Gerund Form এ রূপান্তর।" },
            "Infinitive": { text: "To be honest is his nature.", exp: "Infinitive Form এ রূপান্তর।" },
            "Simple Subject": { text: "He is an honest man.", exp: "Simple Subject এ রূপান্তর।" },
            "Compound Subject": { text: "Honesty and integrity are his traits.", exp: "Compound Subject রূপান্তর।" },
            "Collective Noun": { text: "The jury agrees he is honest.", exp: "Collective Noun Subject।" },
            "Material Noun": { text: "Truth is as solid as rock.", exp: "Material Subject comparison।" }
        }
    },
    "Reading makes a man perfect.": {
        subject: "Reading", verb: "makes", rightOfVerb: "a man perfect", type: "Gerund",
        conversions: {
            "Gerund": { text: "Reading makes a man perfect.", exp: "Gerund Form (Reading)।" },
            "Infinitive": { text: "To read makes a man perfect.", exp: "Infinitive (To read) এ রূপান্তর করা হয়েছে।" },
            "Clause": { text: "That one reads regularly makes him perfect.", exp: "Noun Clause এ রূপান্তর করা হয়েছে।" },
            "Simple Subject": { text: "Books make a man perfect.", exp: "Simple Noun (Books) এ রূপান্তর।" },
            "Compound Subject": { text: "Reading and writing make a man perfect.", exp: "Compound Subject রূপান্তর।" },
            "Collective Noun": { text: "The library helps make a man perfect.", exp: "Collective Noun Subject।" },
            "Abstract Noun": { text: "Knowledge makes a man perfect.", exp: "Abstract Noun Subject।" },
            "Material Noun": { text: "Good literature forms character.", exp: "Material Noun Subject।" }
        }
    },
    "To err is human.": {
        subject: "To err", verb: "is", rightOfVerb: "human", type: "Infinitive",
        conversions: {
            "Infinitive": { text: "To err is human.", exp: "Infinitive (To err)।" },
            "Gerund": { text: "Erring is human.", exp: "Gerund (Erring) এ রূপান্তর করা হয়েছে।" },
            "Clause": { text: "That humans err is natural.", exp: "Noun Clause এ রূপান্তর করা হয়েছে।" },
            "Simple Subject": { text: "Mistakes are human.", exp: "Simple Subject এ রূপান্তর।" },
            "Compound Subject": { text: "Erring and forgiving are human traits.", exp: "Compound Subject রূপান্তর।" },
            "Abstract Noun": { text: "Imperfection is human.", exp: "Abstract Noun Subject।" },
            "Collective Noun": { text: "Mankind makes mistakes.", exp: "Collective Noun Subject।" },
            "Material Noun": { text: "Human brain is prone to error.", exp: "Material Noun Subject।" }
        }
    },
    "What he said is correct.": {
        subject: "What he said", verb: "is", rightOfVerb: "correct", type: "Clause",
        conversions: {
            "Clause": { text: "What he said is correct.", exp: "Noun Clause ('What he said')।" },
            "Simple Subject": { text: "His statement is correct.", exp: "Simple Noun ('His statement') এ রূপান্তর করা হয়েছে।" },
            "Gerund": { text: "Speaking the truth is correct.", exp: "Gerund (Speaking the truth) এ রূপান্তর করা হয়েছে।" },
            "Infinitive": { text: "To agree with him is correct.", exp: "Infinitive (To agree...) এ রূপান্তর করা হয়েছে।" },
            "Compound Subject": { text: "His words and actions are correct.", exp: "Compound Subject রূপান্তর।" },
            "Abstract Noun": { text: "Accuracy is key.", exp: "Abstract Noun Subject।" },
            "Collective Noun": { text: "The audience confirmed his statement.", exp: "Collective Noun Subject।" },
            "Material Noun": { text: "Recorded audio confirms his words.", exp: "Material Noun Subject।" }
        }
    },
    "He likes.": {
        subject: "He", verb: "likes", rightOfVerb: "", type: "Incomplete Sentence",
        conversions: {
            "Simple Subject": { text: "He likes football.", exp: "Right of Verb 'football' (Object) যুক্ত করে বাক্যটি সম্পূর্ণ করা হয়েছে।" },
            "Gerund": { text: "He likes swimming.", exp: "Right of Verb এ Gerund (swimming) যুক্ত করা হয়েছে।" },
            "Infinitive": { text: "He likes to play.", exp: "Right of Verb এ Infinitive (to play) যুক্ত করা হয়েছে।" },
            "Clause": { text: "He likes what he sees.", exp: "Right of Verb এ Clause যুক্ত করা হয়েছে।" },
            "Compound Subject": { text: "He likes tea and coffee.", exp: "Right of Verb এ Compound Object যুক্ত করা হয়েছে।" },
            "Collective Noun": { text: "He likes the team.", exp: "Right of Verb এ Collective Noun যুক্ত করা হয়েছে।" },
            "Abstract Noun": { text: "He likes honesty.", exp: "Right of Verb এ Abstract Noun যুক্ত করা হয়েছে।" },
            "Material Noun": { text: "He likes ice cream.", exp: "Right of Verb এ Material Noun যুক্ত করা হয়েছে।" }
        }
    }
};

// Initialize on page load
document.addEventListener("DOMContentLoaded", function() {
    renderVerbsGrid();
});

// Tab Switch Function
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

// Render Verbs Grid (Box 14)
function renderVerbsGrid(filter = "") {
    const container = document.getElementById('verbs-grid');
    if (!container) return;

    container.innerHTML = "";
    const filtered = VERBS_LIST.filter(v => v.toLowerCase().includes(filter.toLowerCase()));

    filtered.forEach(verb => {
        const card = document.createElement('div');
        card.className = 'verb-card';
        card.textContent = verb;
        card.onclick = () => {
            document.getElementById('sentence-input').value = `I ${verb} this.`;
            switchTab('converter');
            analyzeAndConvert();
        };
        container.appendChild(card);
    });
}

function searchVerbs(query) {
    renderVerbsGrid(query);
}

// Filter Guidebook Tables
function filterTables(boxClass) {
    document.querySelectorAll('.filter-pill').forEach(btn => {
        btn.classList.remove('active');
        btn.style.background = '#ffffff';
        btn.style.color = '#475569';
        btn.style.borderColor = '#cbd5e1';
    });
    event.target.classList.add('active');
    event.target.style.background = '#0052cc';
    event.target.style.color = '#ffffff';

    const allBoxes = document.querySelectorAll('.guide-table-box');
    if (boxClass === 'all') {
        allBoxes.forEach(b => b.style.display = 'block');
    } else {
        allBoxes.forEach(b => {
            if (b.classList.contains(boxClass)) {
                b.style.display = 'block';
            } else {
                b.style.display = 'none';
            }
        });
    }
}

// Preset Handler
function applyPreset(val) {
    if (!val) return;
    document.getElementById('sentence-input').value = val;
    analyzeAndConvert();
}

function loadRandomPreset() {
    const keys = Object.keys(CONVERSION_MAP);
    const randKey = keys[Math.floor(Math.random() * keys.length)];
    document.getElementById('preset-selector').value = randKey;
    applyPreset(randKey);
}

function onSentenceInput() {
    document.getElementById('preset-selector').value = "";
    analyzeAndConvert();
}

// Detection Function
function detectSentenceDetails(text) {
    if (CONVERSION_MAP[text]) {
        return CONVERSION_MAP[text];
    }

    const words = text.split(' ').filter(w => w.length > 0);
    if (words.length <= 2 && (words[1] === 'likes' || words[1] === 'knows' || words[1] === 'needs' || words[1] === 'wants')) {
        return {
            subject: words[0], verb: words[1] || "", rightOfVerb: "", type: "Incomplete Sentence",
            conversions: {}
        };
    }

    const verbIndex = words.findIndex(w => ['is', 'are', 'was', 'were', 'know', 'knows', 'likes', 'made', 'see', 'saw', 'play', 'playing', 'makes', 'brings', 'leads', 'has', 'have'].includes(w.toLowerCase()));
    
    let sub = "Subject", vb = "Verb", rov = "Right of Verb";
    if (verbIndex > 0) {
        sub = words.slice(0, verbIndex).join(' ');
        vb = words[verbIndex];
        rov = words.slice(verbIndex + 1).join(' ');
    } else {
        sub = words[0] || "Subject";
        vb = words[1] || "Verb";
        rov = words.slice(2).join(' ') || "Object";
    }

    let typeGuess = "Simple Subject";
    const subLower = sub.toLowerCase();
    if (subLower.startsWith('to ')) typeGuess = "Infinitive";
    else if (subLower.endsWith('ing') || subLower.includes('ing ')) typeGuess = "Gerund";
    else if (subLower.startsWith('that') || subLower.startsWith('what') || subLower.startsWith('when') || subLower.startsWith('why') || subLower.startsWith('how')) typeGuess = "Clause";
    else if (subLower.includes(' and ')) typeGuess = "Compound Subject";
    else if (['team', 'class', 'group', 'committee', 'army', 'family', 'staff'].some(c => subLower.includes(c))) typeGuess = "Collective Noun";
    else if (['honesty', 'courage', 'beauty', 'knowledge', 'patience', 'truth', 'love', 'kindness'].some(c => subLower.includes(c))) typeGuess = "Abstract Noun";
    else if (['water', 'milk', 'gold', 'iron', 'sugar', 'oil', 'wood', 'rice', 'salt', 'air'].some(c => subLower.includes(c))) typeGuess = "Material Noun";

    return {
        subject: sub, verb: vb, rightOfVerb: rov, type: typeGuess,
        conversions: {}
    };
}

// Transformation Generator for Dynamic User Text
function generateDynamicConversion(detected, targetType) {
    const sub = detected.subject;
    const vb = detected.verb;
    const rov = detected.rightOfVerb;
    const currentType = detected.type;

    if (currentType === "Incomplete Sentence") {
        return {
            text: `${sub} ${vb} something.`,
            exp: `অসম্পূর্ণ বাক্যটিতে Object 'something' যোগ করে সম্পূর্ণ করা হয়েছে।`
        };
    }

    if (targetType === "auto" || targetType === currentType) {
        return {
            text: `${sub} ${vb} ${rov}`.trim(),
            exp: `বর্তমান বাক্যটি ${currentType} হিসেবে চিহ্নিত করা হয়েছে।`
        };
    }

    let actionVerb = sub.replace(/^To /i, '').replace(/ing$/i, '');
    if (!actionVerb) actionVerb = "do";

    switch(targetType) {
        case "Infinitive":
            if (currentType === "Gerund") {
                const baseVerb = sub.replace(/ing$/i, '');
                return { text: `To ${baseVerb.toLowerCase()} ${vb} ${rov}`.trim(), exp: `Gerund (${sub}) কে Infinitive (To ${baseVerb.toLowerCase()}) এ রূপান্তর করা হয়েছে।` };
            }
            return { text: `To ${actionVerb.toLowerCase()} ${vb} ${rov}`.trim(), exp: `Subject অংশকে Infinitive (To + Verb) এ রূপান্তর করা হয়েছে।` };

        case "Gerund":
            if (currentType === "Infinitive") {
                const baseVerb = sub.replace(/^To /i, '');
                const gerundForm = baseVerb.endsWith('e') ? baseVerb.slice(0, -1) + 'ing' : baseVerb + 'ing';
                const capGerund = gerundForm.charAt(0).toUpperCase() + gerundForm.slice(1);
                return { text: `${capGerund} ${vb} ${rov}`.trim(), exp: `Infinitive (${sub}) কে Gerund (${capGerund}) এ রূপান্তর করা হয়েছে।` };
            }
            return { text: `${actionVerb.charAt(0).toUpperCase() + actionVerb.slice(1)}ing ${vb} ${rov}`.trim(), exp: `Subject কে Gerund (V+ing) এ রূপান্তর করা হয়েছে।` };

        case "Clause":
            return { text: `That ${sub.toLowerCase()} ${vb} ${rov} is true.`, exp: `সম্পূর্ণ বাক্যটিকে Noun Clause এ রূপান্তর করা হয়েছে।` };

        case "Simple Subject":
            return { text: `The activity ${vb} ${rov}`.trim(), exp: `একটি মাত্র Simple Noun Subject ব্যবহার করা হয়েছে।` };

        case "Compound Subject":
            return { text: `${sub} and practice ${vb === 'is' ? 'are' : vb} ${rov}`.trim(), exp: `দুইটি Noun যুক্ত Plural Compound Subject রূপান্তর করা হয়েছে।` };

        case "Collective Noun":
            return { text: `The team ${vb} ${rov}`.trim(), exp: `Collective Noun ('The team') Subject করা হয়েছে।` };

        case "Abstract Noun":
            return { text: `Practice ${vb} ${rov}`.trim(), exp: `Abstract Noun ('Practice') Subject করা হয়েছে।` };

        case "Material Noun":
            return { text: `Water ${vb} ${rov}`.trim(), exp: `Material Noun ('Water') Subject করা হয়েছে।` };

        default:
            return { text: `${sub} ${vb} ${rov}`.trim(), exp: `রূপান্তর সম্পূর্ণ হয়েছে।` };
    }
}

// Main Analyzer & Converter Trigger
function analyzeAndConvert() {
    const textInput = document.getElementById('sentence-input').value.trim();
    const targetType = document.getElementById('target-type').value;

    const emptyState = document.getElementById('result-empty');
    const activeState = document.getElementById('result-active');

    if (!textInput) {
        emptyState.classList.remove('d-none');
        activeState.classList.add('d-none');
        return;
    }

    emptyState.classList.add('d-none');
    activeState.classList.remove('d-none');

    // 1. Detect Details
    const detected = detectSentenceDetails(textInput);

    // 2. Perform Target Conversion
    let conversionResult = null;
    if (detected.conversions && detected.conversions[targetType]) {
        conversionResult = detected.conversions[targetType];
    } else {
        conversionResult = generateDynamicConversion(detected, targetType);
    }

    // 3. Update Badges
    document.getElementById('detected-type-badge').textContent = detected.type;
    const targetBadgeContainer = document.getElementById('target-type-badge-container');
    const targetBadge = document.getElementById('target-type-badge');

    if (targetType === "auto" || targetType === detected.type) {
        targetBadgeContainer.style.background = "#f1f5f9";
        targetBadgeContainer.style.color = "#475569";
        targetBadgeContainer.style.borderColor = "#cbd5e1";
        targetBadge.textContent = "Mode: Auto Analysis";
    } else {
        targetBadgeContainer.style.background = "#faf5ff";
        targetBadgeContainer.style.color = "#6b21a8";
        targetBadgeContainer.style.borderColor = "#e9d5ff";
        targetBadge.textContent = `Converted: ${targetType}`;
    }

    // 4. Update Converted Main Card
    document.getElementById('result-converted-sentence').textContent = conversionResult.text;
    document.getElementById('result-converted-explanation').textContent = conversionResult.exp;

    // 5. Update Highlighted Structure
    const highlightElem = document.getElementById('highlighted-sentence');
    if (detected.type === "Incomplete Sentence") {
        highlightElem.innerHTML = `<span style="background: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px;">${detected.subject}</span> <span style="background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px;">${detected.verb}</span> <span style="background: #fee2e2; color: #dc2626; padding: 2px 6px; border-radius: 4px; text-decoration: line-through;">[Right of Verb অনু উপস্থিত]</span>`;
    } else {
        highlightElem.innerHTML = `<span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px;">${detected.subject}</span> <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px;">${detected.verb}</span> <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px;">${detected.rightOfVerb}</span>`;
    }

    // 6. Update Step by Step Analysis Box
    const stepsContainer = document.getElementById('step-by-step-analysis');
    stepsContainer.innerHTML = `
        <div><strong>Step 1 (Verb চিহ্নিতকরণ):</strong> Verb হলো '${detected.verb || 'N/A'}'</div>
        <div><strong>Step 2 (পরবর্তী অংশ):</strong> Verb-এর পর '${detected.rightOfVerb || 'অনুপস্থিত'}' পাওয়া গেছে।</div>
        <div><strong>Step 3 (Subject ধরন):</strong> বর্তমান রূপটি হলো <strong>${detected.type}</strong></div>
        <div><strong>Step 4 (সম্পূর্ণতা):</strong> ${detected.type === 'Incomplete Sentence' ? 'অসম্পূর্ণ বাক্য!' : 'সঠিক ও অর্থপূর্ণ বাক্য গঠন।'}</div>
    `;

    // 7. Update Status Box
    const statusBox = document.getElementById('completeness-status-box');
    if (detected.type === "Incomplete Sentence") {
        statusBox.style.background = "#fef2f2";
        statusBox.style.color = "#991b1b";
        statusBox.style.border = "1px solid #fecaca";
        statusBox.innerHTML = `<i class="material-icons-round" style="color: #dc2626;">warning</i> <strong>অসম্পূর্ণ বাক্য!</strong> Verb-এর পর Right of Verb (Object/Noun) না থাকায় বাক্যের অর্থ অসম্পূর্ণ।`;
    } else {
        statusBox.style.background = "#f0fdf4";
        statusBox.style.color = "#166534";
        statusBox.style.border = "1px solid #bbf7d0";
        statusBox.innerHTML = `<i class="material-icons-round" style="color: #16a34a;">check_circle</i> <strong>সঠিক বাক্য!</strong> Verb-এর পর Right of Verb (Subject/Object) বিদ্যমান।`;
    }
}

// Copy & Speech Synthesis
function copyResultText() {
    const convText = document.getElementById('result-converted-sentence').textContent;
    if (convText) {
        navigator.clipboard.writeText(convText);
        alert("রূপান্তরিত বাক্যটি ক্লিপবোর্ডে কপি করা হয়েছে!");
    }
}

function speakResultText() {
    const convText = document.getElementById('result-converted-sentence').textContent;
    if (convText && 'speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(convText);
        utterance.lang = 'en-US';
        window.speechSynthesis.speak(utterance);
    }
}
</script>
@endsection
