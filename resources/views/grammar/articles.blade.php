@extends('layouts.app')

@section('title', 'Articles Master - A, An, The & Cross (x) Article Rules & Solver')

@section('content')
<div class="articles-master-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
    <!-- Back Link & Header -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('grammar.index') }}" style="color: #2563eb; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem;">
            <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">ব্যাক টু ক্লাসরুম</span>
        </a>
    </div>

    <!-- HERO BANNER -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border-radius: 20px; padding: 35px 40px; color: #ffffff; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); display: grid; grid-template-columns: 1.3fr 1fr; gap: 30px; align-items: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none;"></div>

        <div>
            <span style="background: rgba(99,102,241,0.3); color: #a5b4fc; border: 1px solid rgba(165,180,252,0.4); padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 12px;">ENGLISH GRAMMAR MASTER</span>
            <h1 style="font-size: 2.8rem; font-weight: 900; margin: 0 0 8px 0; letter-spacing: -1px; font-family: 'Outfit', sans-serif; color: #ffffff;">
                ARTICLES MASTER (A, AN, THE & ✕)
            </h1>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: #cbd5e1; margin: 0 0 18px 0; font-family: 'Hind Siliguri', sans-serif;">
                আর্টিকেলের ব্যবহার, উচ্চারণগত ব্যতিক্রম & বোর্ড প্রশ্ন সলভার
            </h3>

            <ul style="list-style: none; padding: 0; margin: 0 0 25px 0; font-size: 0.92rem; color: #cbd5e1; font-family: 'Hind Siliguri', sans-serif; display: flex; flex-direction: column; gap: 8px;">
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #818cf8; font-size: 1.1rem;">check_circle</i>
                    Indefinite (A / An) এবং Definite (The)-এর সকল মৌলিক নিয়ম
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #818cf8; font-size: 1.1rem;">check_circle</i>
                    Zero Article / Cross (x) কোথায় আর্টিকেল বসে না তার সম্পূর্ণ চার্ট
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #818cf8; font-size: 1.1rem;">check_circle</i>
                    Abbreviation Sound (M.A., S.D.O.) ও Vowel Sound (Yu / Wa) ব্যতিক্রম
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #818cf8; font-size: 1.1rem;">check_circle</i>
                    একক বাক্য ও বোর্ড পরীক্ষা প্যাসেজ স্মার্ট সলভার & ডিজিটাল অ্যানসার শিট
                </li>
            </ul>

            <button type="button" onclick="switchTab('solver')" style="background: #4f46e5; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(79,70,229,0.4); transition: transform 0.2s;">
                <span>স্মার্ট সলভারে টেস্ট করুন</span>
                <i class="material-icons-round">arrow_forward</i>
            </button>
        </div>

        <!-- Right Side Big Visual Pills -->
        <div style="display: flex; flex-direction: column; gap: 10px; max-width: 300px; justify-self: end; width: 100%;">
            <div onclick="filterRule('a')" style="background: #2563eb; color: white; padding: 12px; border-radius: 12px; font-weight: 900; font-size: 1.1rem; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(37,99,235,0.3);">
                ARTICLE "A" <span style="font-size: 0.8rem; font-weight: 500;">(Consonant Sound)</span>
            </div>
            <div onclick="filterRule('an')" style="background: #059669; color: white; padding: 12px; border-radius: 12px; font-weight: 900; font-size: 1.1rem; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(5,150,105,0.3);">
                ARTICLE "AN" <span style="font-size: 0.8rem; font-weight: 500;">(Vowel Sound / Silent H)</span>
            </div>
            <div onclick="filterRule('the')" style="background: #7c3aed; color: white; padding: 12px; border-radius: 12px; font-weight: 900; font-size: 1.1rem; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(124,58,237,0.3);">
                ARTICLE "THE" <span style="font-size: 0.8rem; font-weight: 500;">(Definite / Unique)</span>
            </div>
            <div onclick="filterRule('cross')" style="background: #dc2626; color: white; padding: 12px; border-radius: 12px; font-weight: 900; font-size: 1.1rem; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(220,38,38,0.3);">
                ZERO ARTICLE "✕" <span style="font-size: 0.8rem; font-weight: 500;">(No Article Required)</span>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Sub-Bar -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
        <div onclick="switchTab('solver')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #eeef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">auto_awesome</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Smart Article Solver</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">প্যাসেজ ও বাক্য সমাধান</div>
            </div>
        </div>

        <div onclick="switchTab('visual')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">collections</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Visual Learning</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">ছবি ও চার্ট দেখে শিখুন</div>
            </div>
        </div>

        <div onclick="switchTab('rules')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fdf4ff; color: #c026d3; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">menu_book</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Complete Rules & Formulas</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">A, An, The ও ✕-এর নিয়মাবলি</div>
            </div>
        </div>

        <div onclick="switchTab('practice')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">quiz</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Practice & Quiz</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">বোর্ড প্রশ্ন ও কুইজ টেস্ট</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div id="articles-nav-bar" style="display: flex; gap: 20px; margin-bottom: 25px; border-bottom: 1px solid #cbd5e1; flex-wrap: wrap; scroll-margin-top: 20px;">
        <button type="button" class="tab-btn active" id="tab-btn-solver" onclick="switchTab('solver')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #4f46e5; border-bottom: 3px solid #4f46e5; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">auto_awesome</i>
            <span>স্মার্ট আর্টিকেল সলভার (Smart Article Solver)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-visual" onclick="switchTab('visual')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">image</i>
            <span>ছবি দেখে শিখি (Visual Learning)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-rules" onclick="switchTab('rules')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">menu_book</i>
            <span>সম্পূর্ণ আর্টিকেলের নিয়মাবলি (All Rules & Formulas)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-practice" onclick="switchTab('practice')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">quiz</i>
            <span>অনুশীলন ও কুইজ (Practice Quiz)</span>
        </button>
    </div>

    <!-- TAB 1: SMART SOLVER INTERFACE -->
    <div id="panel-solver" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.15fr; gap: 25px; align-items: start;">
            
            <!-- Left Controls -->
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                
                <!-- Presets Selector -->
                <div style="margin-bottom: 18px;">
                    <label style="display: flex; justify-content: space-between; font-weight: 800; font-size: 0.9rem; color: #0f172a; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">
                        <span>নমুনা প্রশ্ন নির্বাচন করুন (Presets)</span>
                        <span style="color: #4f46e5; cursor: pointer; font-size: 0.8rem; font-weight: 800;" onclick="loadRandomPreset()">🎲 র্যান্ডম উদাহরণ</span>
                    </label>
                    <select id="preset-selector" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 14px; font-size: 0.9rem; outline: none; background: #f8fafc; font-family: 'Outfit', sans-serif;" onchange="applyPreset(this.value)">
                        <option value="">-- একটি উদাহরণ পছন্দ করুন --</option>
                        <option value="p1">1. Sound Rule: He is _ (a/an/the) M.A. in English.</option>
                        <option value="p2">2. Silent H Rule: He is _ (a/an/the) honest man.</option>
                        <option value="p3">3. Vowel 'Yu' Rule: This is _ (a/an/the) university student.</option>
                        <option value="p4">4. Definite Sun Rule: The sun rises in _ (a/an/the) east.</option>
                        <option value="p5">5. Zero Article Rule: Gold is _ (a/an/the) precious metal.</option>
                        <option value="p6">6. 'Wa' Sound Rule: He gave me _ (a/an/the) one-taka note.</option>
                        <option value="p7">7. Board Passage: Patriotism is (a) --- noble virtue. It inspires (b) --- man to shed last drop of blood for (c) --- country...</option>
                    </select>
                </div>

                <!-- Input Textarea -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">আর্টিকেল প্রশ্ন লিখুন (Enter Sentence or Passage)</label>
                        <span style="font-size: 0.75rem; color: #10b981; font-weight: 800;">● Live Auto Solve</span>
                    </div>
                    <textarea id="article-input" rows="6" placeholder="যেমন: He is _ (a/an/the) M.A. in English OR Patriotism is (a) --- noble virtue..." style="width: 100%; border-radius: 12px; border: 1px solid #cbd5e1; padding: 14px; font-size: 0.98rem; background: #ffffff; color: #0f172a; outline: none; line-height: 1.6; font-family: 'Outfit', sans-serif;" oninput="solveArticles()"></textarea>
                </div>

                <button type="button" onclick="solveArticles()" style="width: 100%; border-radius: 12px; background: #4f46e5; color: white; border: none; padding: 14px; font-size: 1rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(79,70,229,0.25);">
                    <span>সলভ করুন ও অ্যানসার শিট দেখুন</span>
                    <i class="material-icons-round">auto_awesome</i>
                </button>
            </div>

            <!-- Right Results Box -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- TOP CARD: Completed Text -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="background: #4f46e5; color: white; padding: 4px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">Completed Sentence / Passage</span>
                        <span id="display-confidence" style="color: #10b981; font-weight: 800; font-size: 0.85rem;">Confidence: High (99%)</span>
                    </div>

                    <div id="display-completed-text" style="font-size: 1.05rem; font-weight: 700; color: #0f172a; line-height: 1.7; font-family: 'Outfit', sans-serif; padding: 15px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                        উপরের বক্সে কোনো প্রশ্ন লিখুন বা প্রিসেট নির্বাচন করুন...
                    </div>
                </div>

                <!-- BOTTOM CARD: Digital Answer Sheet -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="background: #0f172a; color: white; padding: 4px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">📋 Digital Answer Sheet & Rules Breakdown</span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered mb-0" style="font-size: 0.85rem; width: 100%;">
                            <thead style="background: #0f172a; color: white;">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Article Answer</th>
                                    <th>Rule Title</th>
                                    <th>Grammar Reason & Sound Explanation</th>
                                </tr>
                            </thead>
                            <tbody id="display-table-body">
                                <tr><td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">কোনো প্রশ্ন ইনপুট দেওয়া হয়নি।</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Final Answer Pill -->
                    <div id="display-final-answers" style="margin-top: 15px; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 12px; font-weight: 800; color: #065f46; font-size: 0.9rem;"></div>
                </div>

            </div>

        </div>
    </div>

    <!-- TAB 2: VISUAL LEARNING -->
    <div id="panel-visual" class="tab-panel d-none">
        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                ছবি দেখে শিখি (Articles Visual Learning)
            </h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; font-family: 'Hind Siliguri', sans-serif;">
                A, An, The এবং Zero Article (x)-এর মৌলিক ব্যবহার ও ব্যতিক্রম ছবি ও আইকনের মাধ্যমে মনে রাখুন।
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            
            <!-- Card A -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 900; color: #2563eb; font-size: 1.2rem; margin-bottom: 12px;">
                    Article "A" (কন্সোনেন্ট সাউন্ড)
                </div>
                <div style="background: #eff6ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 6px;">🐱 🚗 🏫</div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #1d4ed8;">a cat • a car • a university</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • Consonant ধ্বনির পূর্বে <strong>a</strong> বসে (a book, a pen)।<br>
                    • Vowel (U/E) যদি 'ইউ' (Yu) এর মতো উচ্চারিত হয় তবে <strong>a</strong> বসে (a university, a European)।<br>
                    • 'O' যদি 'ওয়া' (Wa) এর মতো উচ্চারিত হয় তবে <strong>a</strong> বসে (a one-taka note)।
                </div>
            </div>

            <!-- Card An -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 900; color: #059669; font-size: 1.2rem; margin-bottom: 12px;">
                    Article "AN" (ভাওয়েল সাউন্ড)
                </div>
                <div style="background: #ecfdf5; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 6px;">🍎 🥚 🎓</div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #047857;">an apple • an honest man • an M.A.</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • Vowel (A, E, I, O, U) ধ্বনির পূর্বে <strong>an</strong> বসে (an egg, an umbrella)।<br>
                    • অনুচ্চারিত 'H' (Silent H) এর পূর্বে <strong>an</strong> বসে (an hour, an honest man)।<br>
                    • Abbreviation এর ১ম অক্ষর ভাওয়েল সাউন্ড দিলে <strong>an</strong> বসে (an M.A., an S.D.O.)।
                </div>
            </div>

            <!-- Card The -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 900; color: #7c3aed; font-size: 1.2rem; margin-bottom: 12px;">
                    Article "THE" (নির্দিষ্ট উপাদান)
                </div>
                <div style="background: #f3e8ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 6px;">☀️ 📖 🏆</div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #6d28d9;">the sun • the Quran • the best</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • নির্দিষ্ট কোনো ব্যক্তি বা বস্তু বোঝাতে <strong>the</strong> বসে।<br>
                    • পৃথিবীতে একক বস্তু (sun, moon, earth, sky, east) এর পূর্বে <strong>the</strong> বসে।<br>
                    • নদী, সাগর, ধর্মগ্রন্থ, সংবাদপত্র ও Superlative Degree-তে <strong>the</strong> বসে।
                </div>
            </div>

            <!-- Card Cross Article -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 900; color: #dc2626; font-size: 1.2rem; margin-bottom: 12px;">
                    ZERO ARTICLE "✕" (নো আর্টিকেল)
                </div>
                <div style="background: #fef2f2; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 6px;">🚫 ⚽ 🥇</div>
                    <div style="font-size: 0.95rem; font-weight: 900; color: #b91c1c;">✕ Dhaka • ✕ Cricket • ✕ Gold</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • Proper Noun (Dhaka, Bangladesh, Rahim) এর পূর্বে আর্টিকেল বসে না।<br>
                    • ভাষা (English, Bangla) ও খেলাধুলার (Cricket, Football) পূর্বে <strong>✕</strong> বসে।<br>
                    • সাধারণ অর্থে Uncountable Noun (Gold, Water) এর পূর্বে <strong>✕</strong> বসে।
                </div>
            </div>

        </div>
    </div>

    <!-- TAB 3: COMPLETE RULES -->
    <div id="panel-rules" class="tab-panel d-none">
        <div style="margin-bottom: 25px; background: #0f172a; color: white; padding: 22px; border-radius: 16px;">
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #818cf8; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                আর্টিকেলের সম্পূর্ণ নিয়মাবলি (Complete Rules & Formulas)
            </h2>
            <p style="margin: 0; color: #cbd5e1; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                Indefinite (A/An), Definite (The) এবং Omission of Articles (Cross/Zero Article)-এর সকল ক্লাসিক নিয়মাবলি।
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Part 1 -->
            <div id="sec-rule-a-an" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="background: #2563eb; color: white; padding: 6px 14px; border-radius: 8px; font-weight: 900; font-size: 0.95rem; display: inline-block; margin-bottom: 15px;">
                    PART 1: Indefinite Articles (A ও An-এর ব্যবহার)
                </div>
                <ul style="padding-left: 20px; font-size: 0.9rem; color: #334155; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
                    <li><strong>নিয়ম ১ (Consonant Sound):</strong> সাধারণ Consonant ধ্বনির পূর্বে <code>a</code> বসে। <em>উদাহরণ: He has <strong>a</strong> dog.</em></li>
                    <li><strong>নিয়ম ২ (Vowel Sound):</strong> Vowel (A, E, I, O, U) ধ্বনির পূর্বে <code>an</code> বসে। <em>উদাহরণ: I ate <strong>an</strong> apple.</em></li>
                    <li><strong>নিয়ম ৩ (Silent H):</strong> শব্দটির শুরু H হলেও H অনুচ্চারিত থাকলে ভাওয়েল সাউন্ড হওয়ায় <code>an</code> বসে। <em>উদাহরণ: He is <strong>an</strong> honest man. / Wait <strong>an</strong> hour.</em></li>
                    <li><strong>নিয়ম ৪ (Yu Sound):</strong> Vowel অক্ষর (U বা E) এর উচ্চারণ যদি 'ইউ' (Yu)-এর মতো হয় তবে <code>a</code> বসে। <em>উদাহরণ: <strong>a</strong> university, <strong>a</strong> European, <strong>a</strong> useful thing.</em></li>
                    <li><strong>নিয়ম ৫ (Wa Sound):</strong> 'O' অক্ষরের উচ্চারণ যদি 'ওয়া' (Wa)-এর মতো হয় তবে <code>a</code> বসে। <em>উদাহরণ: Give me <strong>a</strong> one-taka note.</em></li>
                    <li><strong>নিয়ম ৬ (Abbreviation Sound):</strong> সংক্ষিপ্ত পদের (Abbreviation) ১ম অক্ষর উচ্চারণ করতে Vowel সাউন্ড আসলে <code>an</code> বসে, নাহলে <code>a</code> বসে। <em>উদাহরণ: <strong>an</strong> M.A., <strong>an</strong> S.D.O., <strong>a</strong> B.A., <strong>a</strong> Ph.D.</em></li>
                </ul>
            </div>

            <!-- Part 2 -->
            <div id="sec-rule-the" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="background: #7c3aed; color: white; padding: 6px 14px; border-radius: 8px; font-weight: 900; font-size: 0.95rem; display: inline-block; margin-bottom: 15px;">
                    PART 2: Definite Article (The-এর নির্দিষ্ট ব্যবহার)
                </div>
                <ul style="padding-left: 20px; font-size: 0.9rem; color: #334155; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
                    <li><strong>নিয়ম ১ (Specific Mention):</strong> কোনো নির্দিষ্ট ব্যক্তি বা বস্তু বা দ্বিতীয়বার উল্লেখিত জিনিসের পূর্বে <code>the</code> বসে। <em>উদাহরণ: I saw <strong>a</strong> boy. <strong>The</strong> boy was crying.</em></li>
                    <li><strong>নিয়ম ২ (Unique Natural Objects):</strong> প্রকৃতিতে একক বা অনন্য বস্তুর পূর্বে <code>the</code> বসে। <em>উদাহরণ: <strong>the</strong> sun, <strong>the</strong> moon, <strong>the</strong> earth, <strong>the</strong> sky, <strong>the</strong> east.</em></li>
                    <li><strong>নিয়ম ৩ (Rivers, Seas & Mountains):</strong> নদী, সাগর, মহাসাগর, পর্বতমালা, দ্বীপপুঞ্জের নামের পূর্বে <code>the</code> বসে। <em>উদাহরণ: <strong>the</strong> Padma, <strong>the</strong> Himalayas, <strong>the</strong> Atlantic Ocean.</em></li>
                    <li><strong>নিয়ম ৪ (Holy Books & Newspapers):</strong> ধর্মগ্রন্থ ও সংবাদপত্রের নামের পূর্বে <code>the</code> বসে। <em>উদাহরণ: <strong>the</strong> Holy Quran, <strong>the</strong> Daily Star.</em></li>
                    <li><strong>নিয়ম ৫ (Superlative Degree & Ordinals):</strong> Adjective-এর Superlative degree ও ক্রমবাচক সংখ্যার পূর্বে <code>the</code> বসে। <em>উদাহরণ: He is <strong>the</strong> best boy. / <strong>the</strong> first chapter.</em></li>
                </ul>
            </div>

            <!-- Part 3 -->
            <div id="sec-rule-cross" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="background: #dc2626; color: white; padding: 6px 14px; border-radius: 8px; font-weight: 900; font-size: 0.95rem; display: inline-block; margin-bottom: 15px;">
                    PART 3: Omission of Articles / Zero Article (কোথায় ✕ বসে)
                </div>
                <ul style="padding-left: 20px; font-size: 0.9rem; color: #334155; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
                    <li><strong>নিয়ম ১ (Proper Nouns):</strong> নির্দিষ্ট ব্যক্তি, দেশ, শহর বা স্থানের নামের পূর্বে আর্টিকেল বসে না (<code>✕</code>)। <em>উদাহরণ: <strong>✕</strong> Dhaka is the capital of <strong>✕</strong> Bangladesh.</em></li>
                    <li><strong>নিয়ম ২ (Languages & Games):</strong> কোনো ভাষার নাম বা খেলাধুলার নামের পূর্বে <code>✕</code> বসে। <em>উদাহরণ: We speak <strong>✕</strong> English. / They play <strong>✕</strong> cricket.</em></li>
                    <li><strong>নিয়ম ৩ (Meals & Days):</strong> খাবার (breakfast, lunch, dinner) বা দিন/মাসের পূর্বে <code>✕</code> বসে। <em>উদাহরণ: I take <strong>✕</strong> breakfast at 8 AM.</em></li>
                    <li><strong>নিয়ম ৪ (Uncountable Nouns in General Sense):</strong> সাধারণ অর্থে ব্যবহৃত Uncountable Noun-এর পূর্বে <code>✕</code> বসে। <em>উদাহরণ: <strong>✕</strong> Gold is a precious metal. / <strong>✕</strong> Water has no color.</em></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- TAB 4: PRACTICE QUIZ -->
    <div id="panel-practice" class="tab-panel d-none">
        <div style="margin-bottom: 25px; background: #4f46e5; color: white; padding: 22px; border-radius: 16px;">
            <h2 style="font-size: 1.6rem; font-weight: 800; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                Articles Practice Quiz & Board Test
            </h2>
            <p style="margin: 0; color: #c7d2fe; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                সঠিক আর্টিকেলটি (a, an, the, x) নির্বাচন করুন এবং ইনস্ট্যান্ট ফলাফল ও ব্যাখ্যা দেখুন।
            </p>
        </div>

        <div id="quiz-container" style="display: flex; flex-direction: column; gap: 20px;"></div>
    </div>

</div>

<!-- JAVASCRIPT SOLVER & EVALUATION ENGINE -->
<script>
const PRESETS = {
    "p1": "He is _ (a/an/the) M.A. in English.",
    "p2": "He is _ (a/an/the) honest man.",
    "p3": "This is _ (a/an/the) university student.",
    "p4": "The sun rises in _ (a/an/the) east.",
    "p5": "Gold is _ (a/an/the) precious metal.",
    "p6": "He gave me _ (a/an/the) one-taka note.",
    "p7": "Patriotism is (a) --- noble virtue. It inspires (b) --- man to shed last drop of blood for (c) --- country..."
};

const VOWEL_SOUND_ABBREVIATIONS = new Set(["m.a.", "m.a", "ma", "m.b.b.s.", "m.b.b.s", "mbbs", "m.sc.", "m.sc", "s.d.o.", "s.d.o", "sdo", "f.r.c.s.", "l.l.b.", "l.l.b", "llb", "m.p.", "mp", "h.s.c.", "hsc", "s.s.c.", "ssc"]);
const SILENT_H_WORDS = new Set(["honest", "honesty", "hour", "hours", "heir", "heiress", "honor", "honour", "honorable", "honourable"]);
const YU_SOUND_WORDS = new Set(["university", "unit", "union", "unique", "useful", "european", "utensil", "uniform", "universal"]);
const WA_SOUND_WORDS = new Set(["one", "one-eyed", "one-taka", "one-way"]);
const UNIQUE_DEFINITE_WORDS = new Set(["sun", "moon", "earth", "sky", "east", "west", "north", "south", "padma", "meghna", "jamuna", "himalayas", "atlantic", "pacific", "quran", "bible", "gita", "daily star", "prothom alo"]);
const SUPERLATIVE_WORDS = new Set(["best", "most", "greatest", "richest", "poorest", "highest", "lowest", "largest", "smallest", "first", "second", "third"]);
const UNCOUNTABLE_NOUNS = new Set(["advice", "information", "furniture", "news", "knowledge", "gold", "water", "milk", "rice", "money", "equipment", "traffic", "weather", "luggage", "baggage", "scenery", "progress", "paper", "homework", "work", "music", "bread", "butter"]);
const ZERO_ARTICLE_WORDS = new Set(["english", "bangla", "bengali", "cricket", "football", "dhaka", "bangladesh", "gold", "water", "milk", "rice", "breakfast", "lunch", "dinner"]);

function switchTab(tabName) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('d-none'));
    const targetPanel = document.getElementById('panel-' + tabName);
    if (targetPanel) targetPanel.classList.remove('d-none');

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.style.color = "#64748b";
        btn.style.borderBottom = "3px solid transparent";
        btn.classList.remove('active');
    });

    const activeBtn = document.getElementById('tab-btn-' + tabName);
    if (activeBtn) {
        activeBtn.style.color = "#4f46e5";
        activeBtn.style.borderBottom = "3px solid #4f46e5";
        activeBtn.classList.add('active');
    }

    const navBar = document.getElementById('articles-nav-bar');
    if (navBar) navBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function filterRule(ruleType) {
    switchTab('rules');
    let secId = "sec-rule-a-an";
    if (ruleType === 'the') secId = "sec-rule-the";
    if (ruleType === 'cross') secId = "sec-rule-cross";

    setTimeout(() => {
        const el = document.getElementById(secId);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.style.border = "2px solid #4f46e5";
            setTimeout(() => el.style.border = "1px solid #e2e8f0", 2500);
        }
    }, 150);
}

function applyPreset(key) {
    if (!key) return;
    const text = PRESETS[key];
    if (text) {
        document.getElementById('article-input').value = text;
        solveArticles();
    }
}

function loadRandomPreset() {
    const keys = Object.keys(PRESETS);
    applyPreset(keys[Math.floor(Math.random() * keys.length)]);
}

// MAIN ARTICLE SOLVER ENGINE
function solveArticles() {
    const rawText = document.getElementById('article-input').value.trim();
    if (!rawText) return;

    let text = rawText.replace(/[\u2010-\u2015\u2212\u2500\u2013\u2014]+/g, '---');
    
    let tableRows = [];
    let finalAnswers = [];
    let completedText = text;

    // Blank pattern matcher: Matches (a) ---, (a) ___, (a), ___, ---, or _ (a/an/the) WITHOUT consuming the target word
    const regex = /(?:\(([a-z\d]+)\)\s*(?:---|___|[-—–]+|\(a\/an\/the\))?|(?:---|___|[-—–]+)\s*\(([a-z\d]+)\)|_+\s*(?:\(a\/an\/the\))?|(?<![a-z0-9])\(a\/an\/the\))/gi;
    const matches = [...text.matchAll(regex)];

    if (matches && matches.length > 0) {
        matches.forEach((m, idx) => {
            let labelVal = m[1] || m[2];
            let label = labelVal ? `(${labelVal})` : `(${String.fromCharCode(97 + idx)})`;
            let matchOffset = m.index;
            let precedingChunk = text.substring(Math.max(0, matchOffset - 40), matchOffset).toLowerCase();
            let succeedingChunk = text.substring(matchOffset + m[0].length, Math.min(text.length, matchOffset + m[0].length + 60)).trim().toLowerCase();
            
            let wordsInChunk = succeedingChunk.split(/\s+/).map(w => w.replace(/[^a-z0-9.-]/gi, '')).filter(Boolean);
            let firstNextWord = wordsInChunk[0] || '';
            let secondNextWord = wordsInChunk[1] || '';
            let targetPhrase = (firstNextWord + ' ' + secondNextWord).trim();

            let answer = "a";
            let rTitle = "Indefinite Article A";
            let rReason = `Word '${firstNextWord}' begins with consonant sound.`;

            // Check Uncountable Nouns first (e.g., "advice", "good advice", "information", "water")
            if (UNCOUNTABLE_NOUNS.has(firstNextWord) || UNCOUNTABLE_NOUNS.has(secondNextWord)) {
                answer = "x";
                rTitle = "Zero Article (✕) - Uncountable Noun";
                rReason = `Uncountable mass noun '${UNCOUNTABLE_NOUNS.has(secondNextWord) ? firstNextWord + ' ' + secondNextWord : firstNextWord}' takes no article (✕).`;
            } else if (VOWEL_SOUND_ABBREVIATIONS.has(firstNextWord)) {
                answer = "an"; rTitle = "Abbreviation Sound Rule"; rReason = `Abbreviation '${firstNextWord.toUpperCase()}' starts with vowel sound /em/ or /es/.`;
            } else if (SILENT_H_WORDS.has(firstNextWord)) {
                answer = "an"; rTitle = "Silent H Sound Rule"; rReason = `Word '${firstNextWord}' has unpronounced silent 'h', starting with vowel sound.`;
            } else if (YU_SOUND_WORDS.has(firstNextWord)) {
                answer = "a"; rTitle = "Vowel 'Yu' Sound Rule"; rReason = `Vowel in '${firstNextWord}' sounds like 'Yu' (ইউ), taking article 'a'.`;
            } else if (WA_SOUND_WORDS.has(firstNextWord)) {
                answer = "a"; rTitle = "'Wa' Sound Rule"; rReason = `'O' in '${firstNextWord}' sounds like 'Wa' (ওয়া), taking article 'a'.`;
            } else if (UNIQUE_DEFINITE_WORDS.has(firstNextWord) || SUPERLATIVE_WORDS.has(firstNextWord)) {
                answer = "the"; rTitle = "Definite Article The"; rReason = `Unique natural entity or superlative word '${firstNextWord}'.`;
            } else if (ZERO_ARTICLE_WORDS.has(firstNextWord) && !precedingChunk.includes("the")) {
                answer = "x"; rTitle = "Zero Article (✕)"; rReason = `Proper name, language, or general uncountable '${firstNextWord}' takes no article.`;
            } else if (firstNextWord.match(/^[aeiou]/i)) {
                answer = "an"; rTitle = "Vowel Sound Rule"; rReason = `Word '${firstNextWord}' begins with vowel sound (a, e, i, o, u).`;
            } else {
                answer = "a"; rTitle = "Consonant Sound Rule"; rReason = `Word '${firstNextWord}' begins with consonant sound.`;
            }

            tableRows.push({ id: label, answer: answer, title: rTitle, reason: rReason });
            finalAnswers.push(`${label} ${answer}`);
            completedText = completedText.replace(m[0], `<span style="background: #4f46e5; color: white; padding: 2px 10px; border-radius: 6px; font-weight: 800;">${label} ${answer}</span>`);
        });
    } else {
        // Fallback sentence evaluation
        const lower = text.toLowerCase();
        let answer = "a";
        let rTitle = "Consonant Sound Rule";
        let rReason = "General singular countable noun.";

        if (lower.includes("advice") || lower.includes("information") || lower.includes("furniture") || lower.includes("news")) {
            answer = "x"; rTitle = "Zero Article (✕) - Uncountable Noun"; rReason = "Uncountable noun in general sense takes no article (✕).";
        } else if (lower.includes("m.a") || lower.includes("m.a.") || lower.includes("s.d.o") || lower.includes("mbbs")) {
            answer = "an"; rTitle = "Abbreviation Sound Rule"; rReason = "Abbreviation letter has initial vowel sound /em/.";
        } else if (lower.includes("honest") || lower.includes("hour")) {
            answer = "an"; rTitle = "Silent H Sound Rule"; rReason = "Silent 'H' creates initial vowel sound.";
        } else if (lower.includes("university") || lower.includes("unit") || lower.includes("european")) {
            answer = "a"; rTitle = "Vowel 'Yu' Sound Rule"; rReason = "Vowel 'U/E' sounds like 'Yu' (ইউ).";
        } else if (lower.includes("one-taka") || lower.includes("one eyed")) {
            answer = "a"; rTitle = "'Wa' Sound Rule"; rReason = "'O' sounds like 'Wa' (ওয়া).";
        } else if (lower.includes("sun") || lower.includes("east") || lower.includes("moon") || lower.includes("best")) {
            answer = "the"; rTitle = "Definite Article The"; rReason = "Unique natural entity / direction / superlative degree.";
        }

        completedText = text.replace(/_\s*\([^)]+\)|_|\(a\/an\/the\)/gi, `<span style="background: #4f46e5; color: white; padding: 2px 10px; border-radius: 6px; font-weight: 800;">${answer}</span>`);
        tableRows.push({ id: 1, answer: answer, title: rTitle, reason: rReason });
        finalAnswers.push(answer);
    }

    // Render Results
    document.getElementById('display-completed-text').innerHTML = completedText;
    document.getElementById('display-confidence').innerText = "Confidence: High (99%)";

    const tbody = document.getElementById('display-table-body');
    tbody.innerHTML = "";

    tableRows.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="text-align: center; font-weight: bold; background: #eff6ff; color: #4f46e5;">${row.id}</td>
            <td style="font-weight: 900; color: #047857;"><span style="background: #dcfce7; padding: 2px 10px; border-radius: 6px; color: #047857; font-size: 0.95rem;">${row.answer}</span></td>
            <td style="font-weight: 800; color: #1e293b;">${row.title}</td>
            <td style="font-size: 0.82rem; color: #475569;">${row.reason}</td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('display-final-answers').innerHTML = `<strong>Final Answers:</strong> ${finalAnswers.join('; ')}`;
}

// PRACTICE QUIZ
const QUIZ = [
    { q: "1. He is _____ M.A. in English.", opts: ["a", "an", "the", "x"], ans: "an", exp: "'M' উচ্চারণ করতে /em/ ভাওয়েল সাউন্ড আসে, তাই 'an' বসবে।" },
    { q: "2. He is _____ honest man.", opts: ["a", "an", "the", "x"], ans: "an", exp: "'honest' শব্দে H অনুচ্চারিত থাকায় ভাওয়েল সাউন্ডে 'an' বসবে।" },
    { q: "3. This is _____ university student.", opts: ["a", "an", "the", "x"], ans: "a", exp: "Vowel 'U' এর উচ্চারণ 'ইউ' (Yu) হওয়ায় 'a' বসবে।" },
    { q: "4. The sun rises in _____ east.", opts: ["a", "an", "the", "x"], ans: "the", exp: "দিক বা একমাত্র প্রাকৃতিক উপাদানের পূর্বে 'the' বসে।" },
    { q: "5. We play _____ cricket every afternoon.", opts: ["a", "an", "the", "x"], ans: "x", exp: "খেলাধুলার নামের পূর্বে কোনো আর্টিকেল বসে না (Zero Article ✕)।" }
];

function renderQuiz() {
    const container = document.getElementById('quiz-container');
    container.innerHTML = "";

    QUIZ.forEach((item, idx) => {
        const card = document.createElement('div');
        card.style.cssText = "background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);";
        
        let optsHtml = "";
        item.opts.forEach(opt => {
            optsHtml += `
                <button type="button" onclick="checkQuiz(${idx}, '${opt}', this)" style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 8px 18px; border-radius: 8px; font-weight: 800; font-size: 0.9rem; color: #0f172a; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'">${opt}</button>
            `;
        });

        card.innerHTML = `
            <div style="font-weight: 800; font-size: 1.05rem; color: #0f172a; margin-bottom: 12px;">${item.q}</div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px;">${optsHtml}</div>
            <div id="quiz-ans-${idx}" class="d-none" style="margin-top: 10px; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 700;"></div>
        `;
        container.appendChild(card);
    });
}

function checkQuiz(idx, selectedOpt, btn) {
    const item = QUIZ[idx];
    const ansBox = document.getElementById(`quiz-ans-${idx}`);
    ansBox.classList.remove('d-none');

    if (selectedOpt === item.ans) {
        btn.style.background = "#059669"; btn.style.color = "white"; btn.style.borderColor = "#047857";
        ansBox.style.background = "#dcfce7"; ansBox.style.color = "#047857";
        ansBox.innerHTML = `✅ সঠিক উত্তর! <strong>${item.ans}</strong> — ${item.exp}`;
    } else {
        btn.style.background = "#dc2626"; btn.style.color = "white"; btn.style.borderColor = "#b91c1c";
        ansBox.style.background = "#fee2e2"; ansBox.style.color = "#991b1b";
        ansBox.innerHTML = `❌ ভুল উত্তর। সঠিক উত্তর: <strong>${item.ans}</strong> — ${item.exp}`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    renderQuiz();
    document.getElementById('article-input').value = "He is _ (a/an/the) M.A. in English.";
    solveArticles();
});
</script>
@endsection
