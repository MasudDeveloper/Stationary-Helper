@extends('layouts.app')

@section('title', 'Tense Converter - Linguist')

@section('content')
<script src="https://unpkg.com/compromise"></script>

<div class="tense-hub-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
    <!-- Back Link & Header -->
    <div style="margin-bottom: 25px;">
        <a href="{{ route('grammar.index') }}" style="color: #0052cc; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem;">
            <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">ব্যাক টু ক্লাসরুম</span>
        </a>
    </div>

    <div style="margin-bottom: 30px;">
        <span style="color: #0052cc; font-size: 0.8rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 6px;">ক্রিয়ার কাল পরিবর্তন (TIME TRAVEL FOR VERBS)</span>
        <h1 style="font-size: 2.8rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;">Tense Converter</h1>
        <p style="color: #64748b; font-size: 1rem; margin-top: 10px; line-height: 1.6; max-width: 750px; font-family: 'Hind Siliguri', 'Outfit', sans-serif;">
            Shift your sentences seamlessly across time. Select your target tense, and our linguistic engine will adapt the structure while preserving your meaning. (আপনার বাক্যগুলোকে অনায়াসে বিভিন্ন কালে পরিবর্তন করুন।)
        </p>
    </div>

    <!-- Tabs -->
    <div style="display: flex; gap: 25px; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0;">
        <button type="button" class="tab-btn active" id="tab-converter" onclick="switchTab('converter')" style="background: none; border: none; padding: 12px 5px; font-size: 0.95rem; font-weight: 700; color: #0052cc; border-bottom: 3px solid #0052cc; cursor: pointer; font-family: 'Outfit', sans-serif;">Tense Converter</button>
        <button type="button" class="tab-btn" id="tab-guide" onclick="switchTab('guide')" style="background: none; border: none; padding: 12px 5px; font-size: 0.95rem; font-weight: 700; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Outfit', sans-serif;">Detailed Guide</button>
    </div>

    <!-- TENSE CONVERTER TAB -->
    <div id="panel-converter" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; align-items: start;">
            
            <!-- Left Panel (Inputs) -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; display: flex; flex-direction: column; justify-content: space-between; min-height: 520px; color: #0f172a !important;">
                <div>
                    <!-- Source Text -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="font-weight: 700; font-size: 0.88rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">Source Text (মূল বাক্য)</label>
                        <span style="font-size: 0.75rem; color: #94a3b8;">Max 250 words</span>
                    </div>
                    <textarea id="sentence-input" rows="6" placeholder="Type or paste your sentence here... e.g., 'The quick brown fox jumps over the lazy dog.'" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 15px; font-size: 0.95rem; background: #f8fafc; color: #0f172a; resize: none; outline: none; line-height: 1.6;" oninput="onInputChange()"></textarea>

                    <!-- Current Tense display -->
                    <div style="margin-top: 20px; position: relative;">
                        <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">Current Tense (বর্তমান কাল)</label>
                        <div style="width: 100%; border-radius: 10px; border: 1px solid #e2e8f0; background: #f1f5f9; padding: 12px 15px; font-size: 0.92rem; color: #475569; display: flex; justify-content: space-between; align-items: center;">
                            <span id="current-tense-display">Auto-detect (Detecting...)</span>
                            <i class="material-icons-round" style="color: #64748b; font-size: 1.2rem;">unfold_more</i>
                        </div>
                    </div>

                    <!-- Swap Spacer with Icon -->
                    <div style="display: flex; justify-content: center; margin: 15px 0;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #eff6ff; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center; color: #0052cc;">
                            <i class="material-icons-round" style="font-size: 1.2rem;">swap_vert</i>
                        </div>
                    </div>

                    <!-- Target Tense Dropdown -->
                    <div>
                        <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1e293b; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">Target Tense (লক্ষ্য কাল)</label>
                        <select id="target-tense" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 12px 15px; font-size: 0.92rem; color: #0f172a; outline: none; background: #ffffff; cursor: pointer;" onchange="convertTense()">
                            <option value="all">সবগুলো ১২টি টেন্স একসাথে দেখুন (Show All Tenses)</option>
                            <option value="Present Indefinite">Present Simple (সাধারণ বর্তমান)</option>
                            <option value="Present Continuous">Present Continuous (ঘটমান বর্তমান)</option>
                            <option value="Present Perfect">Present Perfect (পুরাঘটিত বর্তমান)</option>
                            <option value="Present Perfect Continuous">Present Perfect Continuous (পুরাঘটিত ঘটমান)</option>
                            <option value="Past Indefinite">Past Simple (সাধারণ অতীত)</option>
                            <option value="Past Continuous">Past Continuous (ঘটমান অতীত)</option>
                            <option value="Past Perfect">Past Perfect (পুরাঘটিত অতীত)</option>
                            <option value="Past Perfect Continuous">Past Perfect Continuous (পুরাঘটিত ঘটমান)</option>
                            <option value="Future Indefinite">Future Simple (সাধারণ ভবিষ্যৎ)</option>
                            <option value="Future Continuous">Future Continuous (ঘটমান ভবিষ্যৎ)</option>
                            <option value="Future Perfect">Future Perfect (পুরাঘটিত ভবিষ্যৎ)</option>
                            <option value="Future Perfect Continuous">Future Perfect Continuous (পুরাঘটিত ঘটমান)</option>
                        </select>
                    </div>
                </div>

                <button type="button" onclick="convertTense()" style="width: 100%; border-radius: 10px; background: #0052cc; color: #ffffff; border: none; padding: 14px; font-size: 1rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 25px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">
                    <span>Convert Sentence (রূপান্তর করুন)</span>
                    <i class="material-icons-round" style="font-size: 1.2rem;">auto_awesome</i>
                </button>
            </div>

            <!-- Right Panel (Results) -->
            <div style="background: #ffffff !important; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; padding: 25px; min-height: 520px; display: flex; flex-direction: column; color: #0f172a !important;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h4 style="font-weight: 700; font-size: 1.2rem; color: #0f172a; margin: 0; font-family: 'Hind Siliguri', sans-serif;">Result (ফলাফল)</h4>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" onclick="copyResult()" style="background: none; border: none; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px;" title="Copy to clipboard" class="result-action-btn">
                            <i class="material-icons-round" style="font-size: 1.25rem;">content_copy</i>
                        </button>
                        <button type="button" onclick="speakResult()" style="background: none; border: none; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px;" title="Listen to pronunciation" class="result-action-btn">
                            <i class="material-icons-round" style="font-size: 1.25rem;">volume_up</i>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="result-empty" style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 40px 20px;">
                    <div style="width: 72px; height: 72px; border-radius: 50%; background: #f8fafc; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #94a3b8;">
                        <i class="material-icons-round" style="font-size: 2.2rem;">history_toggle_off</i>
                    </div>
                    <h5 style="font-weight: 700; font-size: 1rem; color: #1e293b; font-family: 'Hind Siliguri', sans-serif;">ফলাফল দেখার জন্য প্রস্তুত</h5>
                    <p style="color: #64748b; font-size: 0.85rem; max-width: 320px; line-height: 1.5; margin-top: 5px; font-family: 'Hind Siliguri', sans-serif;">বাম পাশের ফিল্ডে বাক্য ইনপুট দিয়ে Convert বাটনে ক্লিক করুন।</p>
                </div>

                <!-- Single Result Layout -->
                <div id="result-single" class="d-none" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <!-- Badges -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                            <div style="background: #eff6ff; border: 1px solid #dbeafe; color: #2563eb; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <span style="opacity: 0.85;">AUTO_DETECT</span>
                                <span style="font-weight: bold;" id="detected-badge-text">Present Simple</span>
                            </div>
                            <div style="background: #e0e7ff; border: 1px solid #c7d2fe; color: #4f46e5; padding: 6px 12px; border-radius: 8px; font-size: 0.78rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="material-icons-round" style="font-size: 0.9rem;">check_circle</i>
                                <span id="target-badge-text">Converted: Past Simple</span>
                            </div>
                        </div>

                        <!-- Converted Sentence display area -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; min-height: 80px; display: flex; align-items: center; margin-bottom: 20px;">
                            <h3 id="result-sentence" style="font-size: 1.35rem; font-weight: 600; color: #1e293b; line-height: 1.6; margin: 0; width: 100%;"></h3>
                        </div>

                        <!-- Dynamic Uses and Signal Words card -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div style="padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; font-family: 'Hind Siliguri', sans-serif;">Uses (ব্যবহার)</div>
                                <div id="result-tense-uses" style="font-size: 0.82rem; color: #1e293b; line-height: 1.4; font-family: 'Hind Siliguri', sans-serif;">-</div>
                            </div>
                            <div style="padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; font-family: 'Hind Siliguri', sans-serif;">Signal Words</div>
                                <div id="result-tense-signals" style="font-size: 0.82rem; color: #1e293b; line-height: 1.4;">-</div>
                            </div>
                        </div>

                        <!-- Sentence Forms (Affirmative, Negative, Interrogative) -->
                        <div style="margin-bottom: 20px;">
                            <h6 style="color: #0f172a; font-weight: 700; font-size: 0.85rem; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">রূপান্তরের অন্যান্য রূপ (Sentence Forms)</h6>
                            <div style="display: grid; grid-template-columns: 1fr; gap: 8px;">
                                <div style="padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; display: flex; justify-content: space-between;">
                                    <strong style="color: #0052cc; font-family: 'Hind Siliguri', sans-serif; min-width: 90px;">Affirmative:</strong>
                                    <span id="form-affirmative" style="color: #334155; flex-grow: 1; text-align: left;">-</span>
                                </div>
                                <div style="padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; display: flex; justify-content: space-between;">
                                    <strong style="color: #ef4444; font-family: 'Hind Siliguri', sans-serif; min-width: 90px;">Negative:</strong>
                                    <span id="form-negative" style="color: #334155; flex-grow: 1; text-align: left;">-</span>
                                </div>
                                <div style="padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.82rem; display: flex; justify-content: space-between;">
                                    <strong style="color: #10b981; font-family: 'Hind Siliguri', sans-serif; min-width: 90px;">Interrogative:</strong>
                                    <span id="form-interrogative" style="color: #334155; flex-grow: 1; text-align: left;">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline (সময়রেখা) -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 700; font-size: 0.85rem; color: #64748b; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Timeline (সময়রেখা)</label>
                        <div style="position: relative; padding: 10px 0;">
                            <div style="position: absolute; top: 50%; left: 0; right: 0; height: 4px; background: #e2e8f0; transform: translateY(-50%); border-radius: 2px;"></div>
                            <div id="timeline-active-bar" style="position: absolute; top: 50%; left: 0; height: 4px; background: #0052cc; transform: translateY(-50%); border-radius: 2px; width: 50%; transition: width 0.3s ease;"></div>
                            
                            <div style="display: flex; justify-content: space-between; position: relative; z-index: 2;">
                                <!-- Past dot -->
                                <div style="text-align: center;">
                                    <div id="timeline-dot-past" class="timeline-dot" style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; border: 3px solid #ffffff; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;"></div>
                                    <span style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 700; margin-top: 6px;">Past</span>
                                </div>
                                <!-- Present dot -->
                                <div style="text-align: center;">
                                    <div id="timeline-dot-present" class="timeline-dot" style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; border: 3px solid #ffffff; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;"></div>
                                    <span style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 700; margin-top: 6px;">Present</span>
                                </div>
                                <!-- Future dot -->
                                <div style="text-align: center;">
                                    <div id="timeline-dot-future" class="timeline-dot" style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; border: 3px solid #ffffff; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s;"></div>
                                    <span style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 700; margin-top: 6px;">Future</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rule Applied card -->
                    <div style="background: #eff6ff; border-left: 4px solid #0052cc; border-radius: 8px; padding: 15px 20px; display: flex; gap: 15px; align-items: flex-start; margin-top: auto;">
                        <i class="material-icons-round" style="color: #0052cc; font-size: 1.3rem; margin-top: 2px;">info</i>
                        <div>
                            <h6 id="rule-title" style="margin: 0 0 4px 0; font-weight: 700; font-size: 0.9rem; color: #1e3a8a; font-family: 'Hind Siliguri', sans-serif;">Rule Applied (প্রযুক্ত নিয়ম): Past Simple</h6>
                            <p id="rule-desc" style="margin: 0; font-size: 0.85rem; color: #1e40af; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;"></p>
                        </div>
                    </div>
                </div>

                <!-- Multi Result Table Layout -->
                <div id="result-multi" class="d-none" style="flex: 1; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 10px 5px; color: #475569; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; width: 25%;">টেন্স</th>
                                <th style="padding: 10px 5px; color: #475569; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; width: 50%;">রূপান্তরিত বাক্য</th>
                                <th style="padding: 10px 5px; color: #475569; font-weight: 700; font-family: 'Hind Siliguri', sans-serif; width: 25%;">অন্যান্য রূপ (Affirmative / Negative / Interrogative)</th>
                            </tr>
                        </thead>
                        <tbody id="multi-tbody">
                            <!-- Rows will be populated via JS -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- DETAILED GUIDE TAB -->
    <div id="panel-guide" class="tab-panel d-none">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
            <!-- Card templates for tenses -->
            <div class="tense-guide-card">
                <h5>1. Present Simple</h5>
                <div class="guide-structure">S + V1 (s/es) + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> সাধারণ সত্য বা অভ্যাসগত কোনো কাজ বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He plays football.</p>
            </div>
            <div class="tense-guide-card">
                <h5>2. Present Continuous</h5>
                <div class="guide-structure">S + am/is/are + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> বর্তমানে কোনো কাজ চলছে এমন বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He is playing football.</p>
            </div>
            <div class="tense-guide-card">
                <h5>3. Present Perfect</h5>
                <div class="guide-structure">S + have/has + V3 + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> কোনো কাজ এইমাত্র শেষ হয়েছে কিন্তু তার ফল এখনও আছে।</p>
                <p class="guide-english"><strong>Example:</strong> He has played football.</p>
            </div>
            <div class="tense-guide-card">
                <h5>4. Present Perfect Continuous</h5>
                <div class="guide-structure">S + have/has been + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> অতীতে শুরু হওয়া কোনো কাজ এখনও দীর্ঘ সময় ধরে চলছে।</p>
                <p class="guide-english"><strong>Example:</strong> He has been playing football for 2 hours.</p>
            </div>
            <div class="tense-guide-card">
                <h5>5. Past Simple</h5>
                <div class="guide-structure">S + V2 + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> অতীতে কোনো কাজ ঘটেছিল বা অভ্যাস ছিল বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He played football yesterday.</p>
            </div>
            <div class="tense-guide-card">
                <h5>6. Past Continuous</h5>
                <div class="guide-structure">S + was/were + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> অতীতে কোনো কাজ চলছিল বা ঘটছিল বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He was playing football.</p>
            </div>
            <div class="tense-guide-card">
                <h5>7. Past Perfect</h5>
                <div class="guide-structure">S + had + V3 + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> অতীতে সংঘটিত দুটি কাজের মধ্যে অপেক্ষাকৃত পূর্বে ঘটে যাওয়া কাজটি প্রকাশ করতে।</p>
                <p class="guide-english"><strong>Example:</strong> He had played football before we came.</p>
            </div>
            <div class="tense-guide-card">
                <h5>8. Past Perfect Continuous</h5>
                <div class="guide-structure">S + had been + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> অতীতে কোনো একটি কাজের পূর্বে দীর্ঘ সময় ধরে চলা আরেকটি কাজ বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He had been playing football for 2 hours.</p>
            </div>
            <div class="tense-guide-card">
                <h5>9. Future Simple</h5>
                <div class="guide-structure">S + shall/will + V1 + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> ভবিষ্যতে কোনো কাজ সাধারণভাবে ঘটবে বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He will play football tomorrow.</p>
            </div>
            <div class="tense-guide-card">
                <h5>10. Future Continuous</h5>
                <div class="guide-structure">S + shall/will be + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> ভবিষ্যতে কোনো কাজ চলতে থাকবে এমন বোঝালে।</p>
                <p class="guide-english"><strong>Example:</strong> He will be playing football.</p>
            </div>
            <div class="tense-guide-card">
                <h5>11. Future Perfect</h5>
                <div class="guide-structure">S + shall/will have + V3 + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> ভবিষ্যতে কোনো কাজ নির্দিষ্ট সময়ের মধ্যে শেষ হয়ে থাকবে এমন বোঝাতে।</p>
                <p class="guide-english"><strong>Example:</strong> He will have played football by then.</p>
            </div>
            <div class="tense-guide-card">
                <h5>12. Future Perfect Continuous</h5>
                <div class="guide-structure">S + shall/will have been + V-ing + O</div>
                <p class="guide-bengali"><strong>ব্যবহার:</strong> ভবিষ্যতে দীর্ঘ সময় ধরে চলতে থাকা কাজ যা আরেকটি নির্দিষ্ট সময়ে শেষ হবে।</p>
                <p class="guide-english"><strong>Example:</strong> He will have been playing football for 2 hours.</p>
            </div>
        </div>
    </div>

</div>

<style>
    /* CSS overrides for app container dark background to guarantee clean light theme inside this page */
    .tense-hub-page select, .tense-hub-page textarea {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
    }
    .tense-hub-page select:focus, .tense-hub-page textarea:focus {
        border-color: #0052cc !important;
    }
    .result-action-btn:hover {
        background: #f1f5f9 !important;
        color: #0052cc !important;
    }
    .tense-guide-card {
        background: #ffffff !important;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02) !important;
        color: #0f172a !important;
    }
    .tense-guide-card h5 {
        margin: 0 0 10px 0;
        color: #0f172a !important;
        font-weight: 700;
    }
    .guide-structure {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: bold;
        color: #0052cc !important;
        margin-bottom: 12px;
        display: inline-block;
    }
    .guide-bengali {
        font-size: 0.82rem;
        color: #475569 !important;
        font-family: 'Hind Siliguri', sans-serif;
        line-height: 1.5;
        margin-bottom: 8px;
    }
    .guide-english {
        font-size: 0.82rem;
        color: #64748b !important;
        margin: 0;
    }
</style>

<script>
    let lastGeneratedResults = null;

    function switchTab(tabName) {
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('d-none'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.color = '#64748b';
            btn.style.borderBottomColor = 'transparent';
        });

        if (tabName === 'converter') {
            document.getElementById('panel-converter').classList.remove('d-none');
            const btn = document.getElementById('tab-converter');
            btn.style.color = '#0052cc';
            btn.style.borderBottomColor = '#0052cc';
        } else if (tabName === 'guide') {
            document.getElementById('panel-guide').classList.remove('d-none');
            const btn = document.getElementById('tab-guide');
            btn.style.color = '#0052cc';
            btn.style.borderBottomColor = '#0052cc';
        }
    }

    function onInputChange() {
        const sentence = document.getElementById('sentence-input').value.trim();
        const display = document.getElementById('current-tense-display');
        
        if (sentence.length === 0) {
            display.innerText = 'Auto-detect (Detecting...)';
            return;
        }

        const detected = detectTenseName(sentence);
        display.innerText = `Auto-detect (${detected})`;
    }

    function detectTenseName(sentence) {
        let doc = nlp(sentence);
        let sentences = doc.json();
        let terms = [];
        sentences.forEach(s => {
            if (s.terms) terms = terms.concat(s.terms);
        });

        if (terms.length === 0) return 'Present Simple';

        const wordsLower = terms.map(t => t.text.toLowerCase().replace(/[.,\/#!$%\^&\*;:{}=\-_`~()?]/g, ""));
        
        const presents = ['am', 'is', 'are'];
        const pasts = ['was', 'were'];
        const perfects = ['has', 'have'];

        let hasAmIsAre = wordsLower.some(w => presents.includes(w));
        let hasWasWere = wordsLower.some(w => pasts.includes(w));
        let hasHasHave = wordsLower.some(w => perfects.includes(w));
        let hasHad = wordsLower.includes('had');
        let hasWillShall = wordsLower.includes('will') || wordsLower.includes('shall');
        let hasBeen = wordsLower.includes('been');
        let hasIng = wordsLower.some(w => w.endsWith('ing'));

        let hasPerfectV3 = terms.some((t, idx) => {
            if (idx > 0) {
                let prev = wordsLower[idx - 1];
                let isPrevHave = ['have', 'has', 'had', 'having'].includes(prev);
                let wordTags = t.tags || [];
                if (isPrevHave && (wordTags.includes('PastTense') || wordTags.includes('Participle') || t.text.endsWith('ed') || ['done', 'written', 'broken', 'seen', 'give', 'taken', 'known', 'made', 'sung', 'eaten', 'played', 'gone'].includes(t.text.toLowerCase()))) {
                    return true;
                }
            }
            return false;
        });

        if (hasWillShall) {
            if (wordsLower.includes('have') && hasBeen && hasIng) return 'Future Perfect Continuous';
            if (wordsLower.includes('have') && hasPerfectV3) return 'Future Perfect';
            if (wordsLower.includes('be') && hasIng) return 'Future Continuous';
            return 'Future Simple';
        } else if (hasHad) {
            if (hasBeen && hasIng) return 'Past Perfect Continuous';
            if (hasPerfectV3) return 'Past Perfect';
            return 'Past Simple';
        } else if (hasHasHave) {
            if (hasBeen && hasIng) return 'Present Perfect Continuous';
            if (hasPerfectV3) return 'Present Perfect';
            return 'Present Simple';
        } else if (hasAmIsAre) {
            if (hasIng) return 'Present Continuous';
            return 'Present Simple';
        } else if (hasWasWere) {
            if (hasIng) return 'Past Continuous';
            return 'Past Simple';
        } else {
            let hasPastVerb = terms.some(t => (t.tags || []).includes('PastTense'));
            if (hasPastVerb) return 'Past Simple';
            return 'Present Simple';
        }
    }

    function addSOrEs(verb) {
        let v = verb.toLowerCase();
        if (v.endsWith('s') || v.endsWith('sh') || v.endsWith('ch') || v.endsWith('x') || v.endsWith('z') || v.endsWith('o')) {
            return verb + "es";
        }
        if (v.endsWith('y') && !['a', 'e', 'i', 'o', 'u'].includes(v.charAt(v.length - 2))) {
            return verb.substring(0, verb.length - 1) + "ies";
        }
        return verb + "s";
    }

    function checkIfThirdPersonSingular(subject) {
        let subLower = subject.toLowerCase().trim();
        if (['he', 'she', 'it'].includes(subLower)) return true;
        if (['i', 'we', 'they', 'you'].includes(subLower)) return false;
        let doc = nlp(subject);
        if (doc.nouns().isPlural().text()) return false;
        return true;
    }

    function parseSentence(sentence) {
        let doc = nlp(sentence);
        let verbs = doc.verbs().json();
        
        if (verbs.length === 0) return null;
        
        let mainVerbPhraseObj = doc.verbs().first();
        let mainVerbText = mainVerbPhraseObj.text();
        
        let sentenceText = sentence.trim();
        let verbIdx = sentenceText.indexOf(mainVerbText);
        let subject = "He";
        let rest = "";
        
        if (verbIdx !== -1) {
            subject = sentenceText.substring(0, verbIdx).trim();
            rest = sentenceText.substring(verbIdx + mainVerbText.length).trim();
        }
        
        if (!subject) subject = "I";
        
        let conjugation = mainVerbPhraseObj.conjugate()[0];
        
        let baseVerb = conjugation ? conjugation.Infinitive : null;
        if (!baseVerb) {
            baseVerb = mainVerbPhraseObj.out('normal');
            baseVerb = baseVerb.replace(/\b(am|is|are|was|were|has|have|had|been|will|shall|would|should|do|does|did|be|being)\b/gi, '').trim();
        }
        
        let v1 = baseVerb;
        let v2 = conjugation ? conjugation.PastTense : (v1 + "ed");
        let v3 = conjugation ? (conjugation.Participle || conjugation.PastTense) : (v1 + "ed");
        let v4 = conjugation ? conjugation.Gerund : (v1 + "ing");
        
        let isThirdPersonSingular = checkIfThirdPersonSingular(subject);
        
        return {
            subject: subject,
            baseVerb: baseVerb,
            v1: v1,
            v2: v2,
            v3: v3,
            v4: v4,
            isThirdPersonSingular: isThirdPersonSingular,
            rest: rest,
            originalVerbPhrase: mainVerbText
        };
    }

    const rules = {
        'Present Indefinite': {
            eng: "The simple present verb form is used. For singular subjects (he/she/it), '-s' or '-es' is added.",
            bng: "সাধারণ সত্য বা নিয়মিত কাজ বোঝাতে ভার্বের প্রেজেন্ট রূপ বসে। সাবজেক্ট থার্ড পারসন সিঙ্গুলার হলে ভার্বের শেষে s/es যুক্ত হয়।",
            uses: "সাধারণ সত্য, চিরন্তন সত্য, বা অভ্যাসগত কাজ প্রকাশে।",
            signals: "always, usually, often, sometimes, everyday, regularly"
        },
        'Present Continuous': {
            eng: "Auxiliary verbs 'am/is/are' are used with the present participle '-ing' verb form.",
            bng: "বর্তমানে কোনো কাজ চলছে বোঝাতে সাহায্যকারী ভার্ব am/is/are-এর সাথে মূল ভার্বের ing ফর্ম বসে।",
            uses: "বর্তমানে কোনো কাজ চলছে বা ঘটছে তা বোঝাতে।",
            signals: "now, at present, currently, look!, listen!"
        },
        'Present Perfect': {
            eng: "Auxiliary verbs 'has/have' are used with the past participle (V3) verb form.",
            bng: "কোনো কাজ এইমাত্র শেষ হয়েছে বোঝাতে has/have-এর সাথে মূল ভার্বের Past Participle (V3) রূপ বসে।",
            uses: "কোনো কাজ এইমাত্র শেষ হয়েছে এবং তার প্রভাব এখনও আছে তা বোঝাতে।",
            signals: "already, yet, just, ever, never, recently, lately"
        },
        'Present Perfect Continuous': {
            eng: "Helper phrase 'has/have been' is used with the present participle '-ing' form to represent ongoing duration.",
            bng: "অতীতে শুরু হওয়া কাজ এখনও চলছে বোঝাতে has/have been-এর সাথে মূল ভার্বের ing ফর্ম বসে।",
            uses: "অতীতে কোনো কাজ শুরু হয়ে এখনও চলছে তা বোঝাতে।",
            signals: "since (নির্দিষ্ট সময়), for (সময়ের ব্যপ্তি)"
        },
        'Past Indefinite': {
            eng: "The regular verb takes the '-ed' suffix (or irregular past form) to indicate action completed in the past.",
            bng: "অতীতকালে সম্পন্ন হওয়া কাজ বোঝাতে সাবজেক্টের পর ভার্বের Past Form (V2) বসে।",
            uses: "অতীতে কোনো কাজ সম্পন্ন হয়েছিল তা বোঝাতে।",
            signals: "yesterday, ago, long ago, last night, in 2010, once"
        },
        'Past Continuous': {
            eng: "Auxiliary verbs 'was/were' are used alongside the present participle '-ing' form.",
            bng: "অতীতে কোনো কাজ চলছিল বোঝাতে was/were-এর সাথে মূল ভার্বের ing ফর্ম বসে।",
            uses: "অতীতে কোনো কাজ কিছু সময় ধরে চলছিল তা বোঝাতে।",
            signals: "while, when, at that time"
        },
        'Past Perfect': {
            eng: "The helping verb 'had' is used with the past participle (V3) form.",
            bng: "অতীতে দুটি কাজের মধ্যে অপেক্ষাকৃত পূর্বে সম্পন্ন হওয়া কাজের জন্য had + V3 ফর্ম বসে।",
            uses: "অতীতে দুটি ঘটনার মধ্যে অপেক্ষাকৃত পূর্বের ঘটনাটি প্রকাশ করতে।",
            signals: "before, after, by the time"
        },
        'Past Perfect Continuous': {
            eng: "Helper phrase 'had been' is used with the present participle '-ing' form.",
            bng: "অতীতে কোনো নির্দিষ্ট সময়ের পূর্বে দীর্ঘ সময় ধরে চলা কাজের জন্য had been + V-ing বসে।",
            uses: "অতীতে কোনো কাজ দীর্ঘ সময় ধরে চলছিল তা বোঝাতে।",
            signals: "since, for, before"
        },
        'Future Indefinite': {
            eng: "Helping verbs 'shall/will' are used with the base verb form.",
            bng: "ভবিষ্যতে কোনো কাজ সাধারণভাবে ঘটবে বোঝাতে will/shall-এর সাথে ভার্বের বেস রূপ বসে।",
            uses: "ভবিষ্যতে কোনো কাজ সাধারণভাবে সম্পন্ন হবে তা বোঝাতে।",
            signals: "tomorrow, next week, soon, in future, in 2030"
        },
        'Future Continuous': {
            eng: "Helping verbs 'shall/will be' are used with the present participle '-ing' form.",
            bng: "ভবিষ্যতে কোনো কাজ চলতে থাকবে বোঝাতে shall/will be-এর সাথে মূল ভার্বের ing রূপ বসে।",
            uses: "ভবিষ্যতে কোনো কাজ চলতে থাকবে এমন বোঝাতে।",
            signals: "at this time tomorrow, continuously"
        },
        'Future Perfect': {
            eng: "Helping verbs 'shall/will have' are used with the past participle (V3) form.",
            bng: "ভবিষ্যতে নির্দিষ্ট সময়ের মধ্যে কোনো কাজ হয়ে থাকবে বোঝাতে shall/will have + V3 বসে।",
            uses: "ভবিষ্যতে কোনো নির্দিষ্ট সময়ের আগেই কাজ সম্পন্ন হয়ে থাকবে বোঝাতে।",
            signals: "by tomorrow, by next week, by this time"
        },
        'Future Perfect Continuous': {
            eng: "Helping phrase 'shall/will have been' is used alongside the present participle '-ing' form.",
            bng: "ভবিষ্যতে দীর্ঘ সময় ধরে চলতে থাকা কাজ বোঝাতে shall/will have been + V-ing বসে।",
            uses: "ভবিষ্যতে নির্দিষ্ট সময় পর্যন্ত কোনো কাজ চলতে থাকবে বোঝাতে।",
            signals: "for, by that time"
        }
    };

    function generateTenseDetails(parsed, targetTense) {
        let sub = parsed.subject;
        let subLower = sub.toLowerCase().trim();
        let rest = parsed.rest;
        
        let amIsAre = "is";
        let haveHas = "has";
        let wasWere = "was";
        let doDoes = "does";
        
        if (subLower === "i") {
            amIsAre = "am";
            haveHas = "have";
            wasWere = "was";
            doDoes = "do";
        } else if (['we', 'they', 'you'].includes(subLower)) {
            amIsAre = "are";
            haveHas = "have";
            wasWere = "were";
            doDoes = "do";
        } else {
            let isPlural = !parsed.isThirdPersonSingular;
            if (isPlural) {
                amIsAre = "are";
                haveHas = "have";
                wasWere = "were";
                doDoes = "do";
            } else {
                amIsAre = "is";
                haveHas = "has";
                wasWere = "was";
                doDoes = "does";
            }
        }
        
        let v1Present = parsed.v1;
        if (parsed.isThirdPersonSingular) v1Present = addSOrEs(parsed.v1);
        
        let details = {};
        
        details['Present Indefinite'] = {
            affirmative: `${sub} ${v1Present} ${rest}`,
            negative: `${sub} ${doDoes} not ${parsed.v1} ${rest}`,
            interrogative: `${doDoes.charAt(0).toUpperCase() + doDoes.slice(1)} ${sub.toLowerCase()} ${parsed.v1} ${rest}?`
        };
        
        details['Present Continuous'] = {
            affirmative: `${sub} ${amIsAre} ${parsed.v4} ${rest}`,
            negative: `${sub} ${amIsAre} not ${parsed.v4} ${rest}`,
            interrogative: `${amIsAre.charAt(0).toUpperCase() + amIsAre.slice(1)} ${sub.toLowerCase()} ${parsed.v4} ${rest}?`
        };
        
        details['Present Perfect'] = {
            affirmative: `${sub} ${haveHas} ${parsed.v3} ${rest}`,
            negative: `${sub} ${haveHas} not ${parsed.v3} ${rest}`,
            interrogative: `${haveHas.charAt(0).toUpperCase() + haveHas.slice(1)} ${sub.toLowerCase()} ${parsed.v3} ${rest}?`
        };
        
        details['Present Perfect Continuous'] = {
            affirmative: `${sub} ${haveHas} been ${parsed.v4} ${rest}`,
            negative: `${sub} ${haveHas} not been ${parsed.v4} ${rest}`,
            interrogative: `${haveHas.charAt(0).toUpperCase() + haveHas.slice(1)} ${sub.toLowerCase()} been ${parsed.v4} ${rest}?`
        };
        
        details['Past Indefinite'] = {
            affirmative: `${sub} ${parsed.v2} ${rest}`,
            negative: `${sub} did not ${parsed.v1} ${rest}`,
            interrogative: `Did ${sub.toLowerCase()} ${parsed.v1} ${rest}?`
        };
        
        details['Past Continuous'] = {
            affirmative: `${sub} ${wasWere} ${parsed.v4} ${rest}`,
            negative: `${sub} ${wasWere} not ${parsed.v4} ${rest}`,
            interrogative: `${wasWere.charAt(0).toUpperCase() + wasWere.slice(1)} ${sub.toLowerCase()} ${parsed.v4} ${rest}?`
        };
        
        details['Past Perfect'] = {
            affirmative: `${sub} had ${parsed.v3} ${rest}`,
            negative: `${sub} had not ${parsed.v3} ${rest}`,
            interrogative: `Had ${sub.toLowerCase()} ${parsed.v3} ${rest}?`
        };
        
        details['Past Perfect Continuous'] = {
            affirmative: `${sub} had been ${parsed.v4} ${rest}`,
            negative: `${sub} had not been ${parsed.v4} ${rest}`,
            interrogative: `Had ${sub.toLowerCase()} been ${parsed.v4} ${rest}?`
        };
        
        details['Future Indefinite'] = {
            affirmative: `${sub} will ${parsed.v1} ${rest}`,
            negative: `${sub} will not ${parsed.v1} ${rest}`,
            interrogative: `Will ${sub.toLowerCase()} ${parsed.v1} ${rest}?`
        };
        
        details['Future Continuous'] = {
            affirmative: `${sub} will be ${parsed.v4} ${rest}`,
            negative: `${sub} will not be ${parsed.v4} ${rest}`,
            interrogative: `Will ${sub.toLowerCase()} be ${parsed.v4} ${rest}?`
        };
        
        details['Future Perfect'] = {
            affirmative: `${sub} will have ${parsed.v3} ${rest}`,
            negative: `${sub} will not have ${parsed.v3} ${rest}`,
            interrogative: `Will ${sub.toLowerCase()} have ${parsed.v3} ${rest}?`
        };
        
        details['Future Perfect Continuous'] = {
            affirmative: `${sub} will have been ${parsed.v4} ${rest}`,
            negative: `${sub} will not have been ${parsed.v4} ${rest}`,
            interrogative: `Will ${sub.toLowerCase()} have been ${parsed.v4} ${rest}?`
        };
        
        return details[targetTense] || null;
    }

    function generateAllTenses(parsed) {
        let sub = parsed.subject;
        let subLower = sub.toLowerCase().trim();
        let rest = parsed.rest;
        
        let amIsAre = "is";
        let haveHas = "has";
        let wasWere = "was";
        let shallWill = "will";
        
        if (subLower === "i") {
            amIsAre = "am";
            haveHas = "have";
            wasWere = "was";
            shallWill = "will";
        } else if (['we', 'they', 'you'].includes(subLower)) {
            amIsAre = "are";
            haveHas = "have";
            wasWere = "were";
            shallWill = "will";
        } else {
            let isPlural = !parsed.isThirdPersonSingular;
            if (isPlural) {
                amIsAre = "are";
                haveHas = "have";
                wasWere = "were";
            } else {
                amIsAre = "is";
                haveHas = "has";
                wasWere = "was";
            }
        }
        
        let v1Present = parsed.v1;
        if (parsed.isThirdPersonSingular) v1Present = addSOrEs(parsed.v1);
        
        let list = {};
        
        list['Present Indefinite'] = {
            verb: v1Present,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${v1Present}</span> ${rest}`.trim(),
            plain: `${sub} ${v1Present} ${rest}`.trim(),
            formula: 'Subject + V1 (s/es) + Object',
            badgeText: 'Present Simple'
        };
        
        list['Present Continuous'] = {
            verb: `${amIsAre} ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${amIsAre} ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} ${amIsAre} ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + am/is/are + V-ing + Object',
            badgeText: 'Present Continuous'
        };
        
        list['Present Perfect'] = {
            verb: `${haveHas} ${parsed.v3}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${haveHas} ${parsed.v3}</span> ${rest}`.trim(),
            plain: `${sub} ${haveHas} ${parsed.v3} ${rest}`.trim(),
            formula: 'Subject + have/has + V3 + Object',
            badgeText: 'Present Perfect'
        };
        
        list['Present Perfect Continuous'] = {
            verb: `${haveHas} been ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${haveHas} been ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} ${haveHas} been ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + have/has been + V-ing + Object',
            badgeText: 'Present Perfect Continuous'
        };
        
        list['Past Indefinite'] = {
            verb: parsed.v2,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${parsed.v2}</span> ${rest}`.trim(),
            plain: `${sub} ${parsed.v2} ${rest}`.trim(),
            formula: 'Subject + V2 + Object',
            badgeText: 'Past Simple'
        };
        
        list['Past Continuous'] = {
            verb: `${wasWere} ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${wasWere} ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} ${wasWere} ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + was/were + V-ing + Object',
            badgeText: 'Past Continuous'
        };
        
        list['Past Perfect'] = {
            verb: `had ${parsed.v3}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">had ${parsed.v3}</span> ${rest}`.trim(),
            plain: `${sub} had ${parsed.v3} ${rest}`.trim(),
            formula: 'Subject + had + V3 + Object',
            badgeText: 'Past Perfect'
        };
        
        list['Past Perfect Continuous'] = {
            verb: `had been ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">had been ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} had been ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + had been + V-ing + Object',
            badgeText: 'Past Perfect Continuous'
        };
        
        list['Future Indefinite'] = {
            verb: `${shallWill} ${parsed.v1}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${shallWill} ${parsed.v1}</span> ${rest}`.trim(),
            plain: `${sub} ${shallWill} ${parsed.v1} ${rest}`.trim(),
            formula: 'Subject + shall/will + V1 + Object',
            badgeText: 'Future Simple'
        };
        
        list['Future Continuous'] = {
            verb: `${shallWill} be ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${shallWill} be ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} ${shallWill} be ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + shall/will be + V-ing + Object',
            badgeText: 'Future Continuous'
        };
        
        list['Future Perfect'] = {
            verb: `${shallWill} have ${parsed.v3}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${shallWill} have ${parsed.v3}</span> ${rest}`.trim(),
            plain: `${sub} ${shallWill} have ${parsed.v3} ${rest}`.trim(),
            formula: 'Subject + shall/will have + V3 + Object',
            badgeText: 'Future Perfect'
        };
        
        list['Future Perfect Continuous'] = {
            verb: `${shallWill} have been ${parsed.v4}`,
            sentence: `${sub} <span style="background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 8px; font-weight: bold; margin: 0 4px;">${shallWill} have been ${parsed.v4}</span> ${rest}`.trim(),
            plain: `${sub} ${shallWill} have been ${parsed.v4} ${rest}`.trim(),
            formula: 'Subject + shall/will have been + V-ing + Object',
            badgeText: 'Future Perfect Continuous'
        };
        
        return list;
    }

    function updateTimeline(tense) {
        document.getElementById('timeline-dot-past').style.background = '#cbd5e1';
        document.getElementById('timeline-dot-present').style.background = '#cbd5e1';
        document.getElementById('timeline-dot-future').style.background = '#cbd5e1';

        const activeBar = document.getElementById('timeline-active-bar');

        if (tense.startsWith('Past')) {
            activeBar.style.width = '0%';
            document.getElementById('timeline-dot-past').style.background = '#0052cc';
        } else if (tense.startsWith('Present')) {
            activeBar.style.width = '50%';
            document.getElementById('timeline-dot-past').style.background = '#0052cc';
            document.getElementById('timeline-dot-present').style.background = '#0052cc';
        } else if (tense.startsWith('Future')) {
            activeBar.style.width = '100%';
            document.getElementById('timeline-dot-past').style.background = '#0052cc';
            document.getElementById('timeline-dot-present').style.background = '#0052cc';
            document.getElementById('timeline-dot-future').style.background = '#0052cc';
        }
    }

    function convertTense() {
        const sentence = document.getElementById('sentence-input').value.trim();
        if (sentence.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'ফাঁকা ইনপুট',
                text: 'অনুগ্রহ করে রূপান্তরের জন্য একটি সেন্টেন্স লিখুন।',
                confirmButtonColor: '#0052cc'
            });
            return;
        }

        const parsed = parseSentence(sentence);
        if (!parsed) {
            Swal.fire({
                icon: 'error',
                title: 'ক্রিয়া সনাক্তকরণ ব্যর্থ',
                text: 'সেন্টেন্সে কোনো মূল Verb পাওয়া যায়নি। অনুগ্রহ করে সঠিক ইংরেজি সেন্টেন্স লিখুন।',
                confirmButtonColor: '#0052cc'
            });
            return;
        }

        const detected = detectTenseName(sentence);
        const results = generateAllTenses(parsed);
        const target = document.getElementById('target-tense').value;

        document.getElementById('result-empty').classList.add('d-none');

        if (target === 'all') {
            document.getElementById('result-single').classList.add('d-none');
            document.getElementById('result-multi').classList.remove('d-none');

            const tbody = document.getElementById('multi-tbody');
            tbody.innerHTML = '';

            Object.keys(results).forEach(key => {
                const item = results[key];
                const formDetail = generateTenseDetails(parsed, key);
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #f1f5f9';
                tr.innerHTML = `
                    <td style="padding: 12px 5px; font-weight: bold; color: #0052cc; vertical-align: top;">${item.badgeText}</td>
                    <td style="padding: 12px 5px; color: #1e293b; vertical-align: top;">${item.sentence}</td>
                    <td style="padding: 12px 5px; color: #475569; font-size: 0.8rem; line-height: 1.4; vertical-align: top;">
                        <strong>Aff:</strong> ${formDetail.affirmative}<br>
                        <strong>Neg:</strong> ${formDetail.negative}<br>
                        <strong>Int:</strong> ${formDetail.interrogative}
                    </td>
                `;
                tbody.appendChild(tr);
            });
            lastGeneratedResults = { plainText: Object.values(results).map(r => `${r.badgeText}: ${r.plain}`).join('\n') };
        } else {
            document.getElementById('result-multi').classList.add('d-none');
            document.getElementById('result-single').classList.remove('d-none');

            const item = results[target];
            
            // Set badges
            document.getElementById('detected-badge-text').innerText = detected;
            document.getElementById('target-badge-text').innerText = `Converted: ${item.badgeText}`;

            // Set sentence html
            document.getElementById('result-sentence').innerHTML = item.sentence;

            // Set rules
            const ruleItem = rules[target] || { eng: '', bng: '', uses: '', signals: '' };
            document.getElementById('rule-title').innerText = `Rule Applied (প্রযুক্ত নিয়ম): ${item.badgeText}`;
            document.getElementById('rule-desc').innerText = `${ruleItem.eng} (${ruleItem.bng})`;
            
            // Set dynamic Uses and Signals in results
            document.getElementById('result-tense-uses').innerText = ruleItem.uses;
            document.getElementById('result-tense-signals').innerText = ruleItem.signals;

            // Set sentence forms
            const formDetail = generateTenseDetails(parsed, target);
            if (formDetail) {
                document.getElementById('form-affirmative').innerText = formDetail.affirmative;
                document.getElementById('form-negative').innerText = formDetail.negative;
                document.getElementById('form-interrogative').innerText = formDetail.interrogative;
            }

            // Set timeline
            updateTimeline(target);

            lastGeneratedResults = { plainText: item.plain };
        }
    }

    function copyResult() {
        if (!lastGeneratedResults) return;
        navigator.clipboard.writeText(lastGeneratedResults.plainText).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'কপি হয়েছে',
                text: 'ফলাফলটি ক্লিপবোর্ডে সফলভাবে কপি হয়েছে।',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    function speakResult() {
        if (!lastGeneratedResults) return;
        const msg = new SpeechSynthesisUtterance();
        msg.text = lastGeneratedResults.plainText;
        msg.lang = 'en-US';
        window.speechSynthesis.speak(msg);
    }
</script>
@endsection