@extends('layouts.app')

@section('title', 'ফ্রি ইংলিশ গ্রামার চেকার ও পার্টস অফ স্পিচ অ্যানালাইজার - penghor.com')

@section('content')
<!-- Import compromise.js for NLP and Typo.js for Hunspell spellchecking -->
<script src="https://unpkg.com/compromise"></script>
<script src="https://cdn.jsdelivr.net/npm/typo-js@1.2.3/typo.min.js"></script>

<div class="container py-4" style="color: var(--text-main);">
    <!-- Header -->
    <div class="glass mb-4 p-4">
        <h1 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0; font-family: 'Hind Siliguri', sans-serif; display: inline-flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <span>ইংরেজি গ্রামার চেকার ও POS অ্যানালাইজার</span>
            <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Free Tool</span>
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 8px; font-family: 'Hind Siliguri', sans-serif;">আপনার ইংরেজি বাক্য বিশ্লেষণ করুন, গ্রামার ভুল সংশোধন করুন এবং প্রতিটি শব্দের Parts of Speech (POS) বিস্তারিতভাবে জানুন।</p>
    </div>

    <!-- Main Workspace Grid -->
    <div class="checker-layout-grid">
        <!-- Input Area (Left) -->
        <div class="input-panel-column">
            <div class="glass p-4" style="min-height: 400px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5 style="color: #fff; font-weight: 700; font-size: 0.95rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                            <i class="material-icons-round" style="color: var(--primary-hover); font-size: 1.15rem;">subject</i>
                            <span>Input English Text</span>
                        </h5>
                        <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid var(--border-color); padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold;">Auto-detect</span>
                    </div>
                    
                    <!-- Textarea with character counter -->
                    <div style="position: relative; margin-bottom: 15px;">
                        <textarea class="form-control" id="sentence-input" rows="8" placeholder="Type or paste your English sentence here... (e.g., He goes to schools everyday.)" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6; background: rgba(0, 0, 0, 0.3); padding-bottom: 35px; border: 1px solid var(--border-color) !important;" oninput="updateCharCount()" maxlength="500"></textarea>
                        <span id="char-counter" style="position: absolute; right: 15px; bottom: 10px; color: var(--text-muted); font-size: 0.75rem;">0 / 500</span>
                    </div>

                    <!-- Quick Pre-filled Examples -->
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 20px;">
                        <span style="color: var(--text-muted); font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">উদাহরণ দেখতে ক্লিক করুন:</span>
                        <button type="button" class="btn btn-secondary px-3 py-1.5" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadExample('He play football and he is good in it.')">Example 1 (S-V Agr)</button>
                        <button type="button" class="btn btn-secondary px-3 py-1.5" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadExample('She is an university student who ate a apple.')">Example 2 (Article)</button>
                        <button type="button" class="btn btn-secondary px-3 py-1.5" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadExample('I don\'t need no recieve calendar.')">Example 3 (Adv/Adj)</button>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; align-items: center; width: 100%;">
                    <button type="button" class="btn btn-secondary d-none py-3 px-4" id="clear-btn" onclick="clearInput()" style="border-radius: 10px;">Clear</button>
                    <button type="button" class="btn btn-primary py-3" onclick="runAnalysis()" style="flex: 1; border-radius: 10px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 700;">
                        <i class="material-icons-round" style="font-size: 1.15rem;">analytics</i>
                        <span>Analyze & Correct</span>
                    </button>
                </div>
            </div>

            <!-- Tips Banner -->
            <div style="margin-top: 20px; padding: 15px; background: rgba(255, 255, 255, 0.01); border: 1px solid var(--border-color); border-radius: 12px; display: flex; align-items: flex-start; gap: 10px;">
                <i class="material-icons-round" style="color: var(--success); font-size: 1.3rem; margin-top: 2px;">lightbulb</i>
                <div>
                    <h6 style="color: #fff; font-weight: 700; font-size: 0.85rem; margin-bottom: 3px; font-family: 'Hind Siliguri', sans-serif;">টিপস</h6>
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0; line-height: 1.4; font-family: 'Hind Siliguri', sans-serif;">জটিল বাক্য বিশ্লেষণের জন্য ছোট ছোট বাক্যে ভাগ করে ইনপুট দিন।</p>
                </div>
            </div>
        </div>

        <!-- Output Area (Right) -->
        <div class="output-panel-column">
            <div class="glass p-4" style="min-height: 480px;">
                <h4 style="color: #fff; font-weight: 700; font-size: 1.15rem; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">অ্যানালাইসিস ফলাফল (Analysis Output)</h4>

                <!-- Prompt state before analyze -->
                <div id="empty-state" style="text-align: center; padding: 80px 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(99, 102, 241, 0.05); border: 2px dashed rgba(99, 102, 241, 0.2); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <i class="material-icons-round" style="font-size: 2.5rem; color: var(--text-muted);">search</i>
                    </div>
                    <h5 style="color: #fff; font-weight: 700; font-size: 1.05rem; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">Ready to Analyze</h5>
                    <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 320px; line-height: 1.5; margin: 0; font-family: 'Hind Siliguri', sans-serif;">বাক্য টাইপ করে 'Analyze' বাটনে ক্লিক করুন। এখানে আপনার বাক্যের বিস্তারিত विश्लेषण এবং ভুলগুলোর সংশোধন দেখানো হবে।</p>
                </div>

                <!-- Analysis results wrapper -->
                <div id="results-state" class="d-none" style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- POS Tagging Output -->
                    <div>
                        <h6 style="color: #fff; font-weight: 700; font-size: 0.95rem; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">১. পার্টস অফ স্পিচ হাইলাইটার (Click for details)</h6>
                        <div id="pos-highlighted-box" style="padding: 15px; background: rgba(0, 0, 0, 0.2); border: 1px solid var(--border-color); border-radius: 12px; min-height: 60px; line-height: 2.2; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                            <!-- Highlighted words go here -->
                        </div>
                    </div>

                    <!-- Word definition description panel -->
                    <div class="d-none" id="word-detail-panel" style="transition: all 0.2s;">
                        <div style="padding: 15px; border: 1px solid var(--border-hover); background: rgba(99, 102, 241, 0.05); border-radius: 12px;">
                            <h6 id="word-detail-title" style="color: #fff; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Word: ...</h6>
                            <p id="word-detail-pos" style="color: var(--primary-hover); font-size: 0.8rem; font-weight: bold; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Part of Speech: ...</p>
                            <p id="word-detail-desc" style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4; margin: 0; font-family: 'Hind Siliguri', sans-serif;">...</p>
                        </div>
                    </div>

                    <!-- Sentence structures (Tense, Voice, Type) -->
                    <div>
                        <h6 style="color: #fff; font-weight: 700; font-size: 0.95rem; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">২. সেন্টেন্সের গঠন বিশ্লেষণ (Sentence Structure)</h6>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                            <div style="padding: 12px; background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.1); border-radius: 8px; text-align: center;">
                                <div style="color: var(--primary-hover); font-size: 0.75rem; font-weight: bold; margin-bottom: 4px; text-transform: uppercase;">Tense</div>
                                <div id="structure-tense" style="color: #fff; font-weight: bold; font-size: 0.85rem;">-</div>
                            </div>
                            <div style="padding: 12px; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); border-radius: 8px; text-align: center;">
                                <div style="color: var(--success); font-size: 0.75rem; font-weight: bold; margin-bottom: 4px; text-transform: uppercase;">Voice</div>
                                <div id="structure-voice" style="color: #fff; font-weight: bold; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif;">-</div>
                            </div>
                            <div style="padding: 12px; background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1); border-radius: 8px; text-align: center;">
                                <div style="color: var(--danger); font-size: 0.75rem; font-weight: bold; margin-bottom: 4px; text-transform: uppercase;">Sentence Type</div>
                                <div id="structure-type" style="color: #fff; font-weight: bold; font-size: 0.85rem; font-family: 'Hind Siliguri', sans-serif;">-</div>
                            </div>
                        </div>
                        <div id="tense-formula-panel" class="d-none" style="padding: 12px; background: rgba(0, 0, 0, 0.2); border: 1px solid var(--border-color); border-radius: 8px; margin-top: 10px;">
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.4; font-family: 'Hind Siliguri', sans-serif;">
                                <strong style="color: var(--primary-hover);">টেন্সের গঠন সূত্র:</strong> <span id="tense-formula-text"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Corrections & Suggestions list -->
                    <div>
                        <h6 style="color: #fff; font-weight: 700; font-size: 0.95rem; margin-bottom: 10px; font-family: 'Hind Siliguri', sans-serif;">৩. ভুল সংশোধন ও পরামর্শ (Corrections)</h6>
                        <div id="corrections-list-container" style="display: flex; flex-direction: column; gap: 12px;">
                            <!-- Corrections list goes here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checker-layout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }
    .pos-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: inline-block;
        transition: transform 0.1s;
    }
    .pos-badge:hover {
        transform: scale(1.05);
    }
    @media (max-width: 1024px) {
        .checker-layout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    let spellingDict = null;

    async function initSpellingDict() {
        const affUrl = "https://cdn.jsdelivr.net/gh/cfinke/Typo.js@master/typo/dictionaries/en_US/en_US.aff";
        const dicUrl = "https://cdn.jsdelivr.net/gh/cfinke/Typo.js@master/typo/dictionaries/en_US/en_US.dic";
        
        try {
            console.log("Loading Hunspell English dictionary files asynchronously...");
            const [affData, dicData] = await Promise.all([
                fetch(affUrl).then(r => r.text()),
                fetch(dicUrl).then(r => r.text())
            ]);
            spellingDict = new Typo("en_US", affData, dicData);
            console.log("Hunspell English dictionary loaded successfully via Typo.js!");
        } catch(e) {
            console.error("Failed to load spelling dictionary asynchronously:", e);
        }
    }
    
    initSpellingDict();

    function loadExample(text) {
        document.getElementById('sentence-input').value = text;
        updateCharCount();
        runAnalysis();
    }

    function toggleClearBtn() {
        const input = document.getElementById('sentence-input').value;
        const clearBtn = document.getElementById('clear-btn');
        if (input.trim().length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }
    }

    function updateCharCount() {
        const input = document.getElementById('sentence-input').value;
        document.getElementById('char-counter').innerText = `${input.length} / 500`;
        toggleClearBtn();
    }

    function clearInput() {
        document.getElementById('sentence-input').value = '';
        updateCharCount();
        document.getElementById('empty-state').classList.remove('d-none');
        document.getElementById('results-state').classList.add('d-none');
        document.getElementById('word-detail-panel').classList.add('d-none');
    }

    // POS mapping database
    const posMeta = {
        'Noun': {
            class: 'bg-blue-600/20 text-blue-400 border border-blue-500/30',
            name: 'Noun (বিশেষ্য)',
            desc: 'Noun দ্বারা কোনো ব্যক্তি, বস্তু, স্থান, গুণ, অবস্থা বা দলের নাম বোঝায়। (যেমন: Rahim, Dhaka, water, honesty)'
        },
        'Pronoun': {
            class: 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30',
            name: 'Pronoun (সর্বনাম)',
            desc: 'Noun-এর পুনরাবৃত্তি এড়াতে তার পরিবর্তে যে শব্দ বসে তাকে Pronoun বলে। (যেমন: He, she, they, I, we, who)'
        },
        'Verb': {
            class: 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30',
            name: 'Verb (ক্রিয়া)',
            desc: 'যে শব্দ দ্বারা কোনো কাজ করা, হওয়া বা অস্তিত্ব থাকা বোঝায় তাকে Verb বলে। (যেমন: play, read, is, have, can)'
        },
        'Adjective': {
            class: 'bg-amber-600/20 text-amber-400 border border-amber-500/30',
            name: 'Adjective (বিশেষণ)',
            desc: 'Noun বা Pronoun-এর দোষ, গুণ, অবস্থা, পরিমাণ বা সংখ্যা নির্দেশকারী শব্দকে Adjective বলে। (যেমন: good, rich, poor, beautiful)'
        },
        'Adverb': {
            class: 'bg-purple-600/20 text-purple-400 border border-purple-500/30',
            name: 'Adverb (ক্রিয়া বিশেষণ)',
            desc: 'যে শব্দ Verb, Adjective বা অন্য Adverb-কে বিশেষিত করে (কখন, কীভাবে, কোথায় কাজটি হচ্ছে)। (যেমন: slowly, quickly, fast, yesterday)'
        },
        'Preposition': {
            class: 'bg-rose-600/20 text-rose-400 border border-rose-500/30',
            name: 'Preposition (পدان্বয়ী অব্যয়)',
            desc: 'Noun/Pronoun-এর পূর্বে বসে বাক্যের অন্যান্য পদের সাথে সম্পর্ক নির্দেশক শব্দকে Preposition বলে। (যেমন: in, on, at, by, with, of)'
        },
        'Conjunction': {
            class: 'bg-teal-600/20 text-teal-400 border border-teal-500/30',
            name: 'Conjunction (সংযোজক অব্যয়)',
            desc: 'দুই বা ততোধিক শব্দ, বাক্যাংশ বা ক্লজকে যুক্তকারী সংযোগমূলক শব্দকে Conjunction বলে। (যেমন: and, but, or, because, although)'
        },
        'Determiner': {
            class: 'bg-orange-600/20 text-orange-400 border border-orange-500/30',
            name: 'Determiner / Article (নির্দেশক)',
            desc: 'Noun-এর পূর্বে বসে তার নির্দিষ্টতা, অনির্দিষ্টতা বা সংখ্যা নির্দেশক শব্দ (যেমন: a, an, the, this, some)'
        },
        'Other': {
            class: 'bg-slate-700/20 text-slate-400 border border-slate-600/30',
            name: 'Other (অন্যান্য)',
            desc: 'অন্যান্য অব্যয় বা পাংচুয়েশন।'
        }
    };

    function runAnalysis() {
        const sentence = document.getElementById('sentence-input').value.trim();
        if (sentence.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'ফাঁকা ইনপুট',
                text: 'অনুগ্রহ করে বিশ্লেষণ করার জন্য একটি সেন্টেন্স লিখুন।',
                confirmButtonColor: 'var(--primary-color)'
            });
            return;
        }

        // Parse using compromise
        let doc = nlp(sentence);
        let sentences = doc.json();
        let terms = [];
        sentences.forEach(s => {
            if (s.terms) {
                terms = terms.concat(s.terms);
            }
        });

        // 1. Render POS Highlighting
        const highlightBox = document.getElementById('pos-highlighted-box');
        highlightBox.innerHTML = '';

        terms.forEach(term => {
            let tag = 'Other';
            let wordTags = term.tags || [];
            if (wordTags.includes('Noun')) tag = 'Noun';
            else if (wordTags.includes('Pronoun')) tag = 'Pronoun';
            else if (wordTags.includes('Verb')) tag = 'Verb';
            else if (wordTags.includes('Adjective')) tag = 'Adjective';
            else if (wordTags.includes('Adverb')) tag = 'Adverb';
            else if (wordTags.includes('Preposition')) tag = 'Preposition';
            else if (wordTags.includes('Conjunction')) tag = 'Conjunction';
            else if (wordTags.includes('Determiner') || wordTags.includes('Article')) tag = 'Determiner';

            const cleanWord = term.text.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()?]/g,"");
            const badgeMeta = posMeta[tag];

            const span = document.createElement('span');
            span.className = `pos-badge ${badgeMeta.class}`;
            span.innerText = term.text;
            span.onclick = () => showWordDetail(cleanWord, tag);
            highlightBox.appendChild(span);
        });

        // 2. Sentence Structure (Tense, Voice, Type)
        let type = 'Assertive Sentence (বর্ণনামূলক বাক্য)';
        if (sentence.endsWith('?')) {
            type = 'Interrogative Sentence (প্রশ্নবোধক বাক্য)';
        } else if (sentence.endsWith('!')) {
            type = 'Exclamatory Sentence (আবেগসূচক বাক্য)';
        } else {
            const firstTerm = terms[0];
            if (firstTerm && (firstTerm.tags || []).includes('Verb') && !(firstTerm.tags || []).includes('Auxiliary')) {
                type = 'Imperative Sentence (আদেশ/অনুরোধমূলক বাক্য)';
            }
        }
        document.getElementById('structure-type').innerText = type;

        let detectedTense = 'Present Indefinite Tense';
        let tenseFormula = 'Subject + V1 + Object (সাবজেক্ট ৩য় পুরুষ একবচন হলে verb-এর শেষে s/es বসে)';
        let isPassive = false;

        const wordsLower = terms.map(t => t.text.toLowerCase().replace(/[.,\/#!$%\^&\*;:{}=\-_`~()?]/g,""));
        
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
        
        let hasBeVerb = hasAmIsAre || hasWasWere || hasBeen || wordsLower.includes('be') || wordsLower.includes('being');
        let hasV3 = terms.some((t, idx) => {
            if (idx > 0) {
                let prev = wordsLower[idx-1];
                let isPrevBe = presents.includes(prev) || pasts.includes(prev) || prev === 'been' || prev === 'be' || prev === 'being';
                let wordTags = t.tags || [];
                if (isPrevBe && (wordTags.includes('PastTense') || wordTags.includes('Participle') || t.text.endsWith('ed') || ['done','written','broken','seen','given','taken','known','made','sung'].includes(t.text.toLowerCase()))) {
                    return true;
                }
            }
            return false;
        });

        let hasPerfectV3 = terms.some((t, idx) => {
            if (idx > 0) {
                let prev = wordsLower[idx-1];
                let isPrevHave = ['have', 'has', 'had', 'having'].includes(prev);
                let wordTags = t.tags || [];
                if (isPrevHave && (wordTags.includes('PastTense') || wordTags.includes('Participle') || t.text.endsWith('ed') || ['done','written','broken','seen','given','taken','known','made','sung','eaten','played','gone'].includes(t.text.toLowerCase()))) {
                    return true;
                }
            }
            return false;
        });

        if (hasBeVerb && hasV3) {
            isPassive = true;
        }

        if (hasWillShall) {
            if (wordsLower.includes('have') && hasBeen && hasIng) {
                detectedTense = 'Future Perfect Continuous Tense';
                tenseFormula = 'Subject + shall/will + have been + V-ing + Object';
            } else if (wordsLower.includes('have') && hasPerfectV3) {
                detectedTense = 'Future Perfect Tense';
                tenseFormula = 'Subject + shall/will + have + V3 + Object';
            } else if (wordsLower.includes('be') && hasIng) {
                detectedTense = 'Future Continuous Tense';
                tenseFormula = 'Subject + shall/will + be + V-ing + Object';
            } else {
                detectedTense = 'Future Indefinite Tense';
                tenseFormula = 'Subject + shall/will + V1 + Object';
            }
        } else if (hasHad) {
            if (hasBeen && hasIng) {
                detectedTense = 'Past Perfect Continuous Tense';
                tenseFormula = 'Subject + had been + V-ing + Object';
            } else if (hasPerfectV3) {
                detectedTense = 'Past Perfect Tense';
                tenseFormula = 'Subject + had + V3 + Object';
            } else {
                detectedTense = 'Past Indefinite Tense';
                tenseFormula = 'Subject + had + Object (had এখানে মূল verb হিসেবে কাজ করছে)';
            }
        } else if (hasHasHave) {
            if (hasBeen && hasIng) {
                detectedTense = 'Present Perfect Continuous Tense';
                tenseFormula = 'Subject + have/has been + V-ing + Object';
            } else if (hasPerfectV3) {
                detectedTense = 'Present Perfect Tense';
                tenseFormula = 'Subject + have/has + V3 + Object';
            } else {
                detectedTense = 'Present Indefinite Tense';
                tenseFormula = 'Subject + have/has + Object (have/has এখানে মূল verb হিসেবে কাজ করছে)';
            }
        } else if (hasAmIsAre) {
            if (hasIng) {
                detectedTense = 'Present Continuous Tense';
                tenseFormula = 'Subject + am/is/are + V-ing + Object';
            } else {
                detectedTense = 'Present Indefinite Tense';
                tenseFormula = 'Subject + V1 + Object (linking verb "be" state)';
            }
        } else if (hasWasWere) {
            if (hasIng) {
                detectedTense = 'Past Continuous Tense';
                tenseFormula = 'Subject + was/were + V-ing + Object';
            } else {
                detectedTense = 'Past Indefinite Tense';
                tenseFormula = 'Subject + was/were + past state';
            }
        } else {
            let hasPastVerb = terms.some(t => (t.tags || []).includes('PastTense'));
            if (hasPastVerb) {
                detectedTense = 'Past Indefinite Tense';
                tenseFormula = 'Subject + V2 + Object';
            } else {
                detectedTense = 'Present Indefinite Tense';
                tenseFormula = 'Subject + V1 + Object (সাবজেক্ট ৩য় পুরুষ একবচন হলে verb-এর শেষে s/es বসে)';
            }
        }

        document.getElementById('structure-tense').innerText = detectedTense;
        document.getElementById('structure-voice').innerText = isPassive ? 'Passive Voice (कर्मবাচ্য)' : 'Active Voice (কর্তৃবাচ্য)';
        document.getElementById('tense-formula-text').innerText = tenseFormula;
        document.getElementById('tense-formula-panel').classList.remove('d-none');

        // 3. Error Corrector & Grammar Suggestions
        const correctionsContainer = document.getElementById('corrections-list-container');
        correctionsContainer.innerHTML = '';
        let errorsFound = [];

        const vowels = ['a', 'e', 'i', 'o', 'u'];
        const exceptionsAnToA = ['university', 'union', 'one', 'useful', 'european', 'unicorn'];
        const exceptionsAToAn = ['honest', 'hour', 'honorable', 'heir'];

        for (let i = 0; i < wordsLower.length - 1; i++) {
            let current = wordsLower[i];
            let next = wordsLower[i + 1];

            if (current === 'a') {
                let firstLetter = next.charAt(0);
                let isException = exceptionsAnToA.some(ex => next.startsWith(ex));
                let isVowel = vowels.includes(firstLetter);
                let isVowelException = exceptionsAToAn.some(ex => next.startsWith(ex));

                if ((isVowel && !isException) || isVowelException) {
                    errorsFound.push({
                        type: 'Article Error (আর্টিকেল ভুল)',
                        mistake: `a ${terms[i+1].text}`,
                        correction: `an ${terms[i+1].text}`,
                        rule: `Vowel Sound-এর পূর্বে "an" বসে। যেহেতু "${terms[i+1].text}" শব্দটির প্রারম্ভিক উচ্চারণ ভাওয়েল ধ্বনিযুক্ত, তাই এখানে "an" বসবে।`
                    });
                }
            } else if (current === 'an') {
                let firstLetter = next.charAt(0);
                let isConsonant = !vowels.includes(firstLetter);
                let isException = exceptionsAnToA.some(ex => next.startsWith(ex));
                let isConsonantException = exceptionsAToAn.some(ex => next.startsWith(ex));

                if ((isConsonant && !isConsonantException) || isException) {
                    errorsFound.push({
                        type: 'Article Error (আর্টিকেল ভুল)',
                        mistake: `an ${terms[i+1].text}`,
                        correction: `a ${terms[i+1].text}`,
                        rule: `Consonant Sound-এর পূর্বে "a" বসে। "${terms[i+1].text}" শব্দটির প্রারম্ভিক উচ্চারণ ইউ (Yew) বা ওয়া (Wa) এর মতো হওয়ায় এর পূর্বে "a" বসবে।`
                    });
                }
            }
        }

        const singularPronouns = ['he', 'she', 'it'];
        const baseVerbs = ['play', 'go', 'eat', 'run', 'read', 'write', 'come', 'do', 'want', 'like', 'see', 'make', 'work'];
        const baseVerbsCorrection = {
            'play': 'plays', 'go': 'goes', 'eat': 'eats', 'run': 'runs', 'read': 'reads', 
            'write': 'writes', 'come': 'comes', 'do': 'does', 'want': 'wants', 
            'like': 'likes', 'see': 'sees', 'make': 'makes', 'work': 'works'
        };

        for (let i = 0; i < wordsLower.length - 1; i++) {
            let current = wordsLower[i];
            let next = wordsLower[i + 1];

            if (singularPronouns.includes(current) && baseVerbs.includes(next)) {
                errorsFound.push({
                    type: 'Subject-Verb Agreement (কর্তা-ক্রিয়া সংগতি)',
                    mistake: `${terms[i].text} ${terms[i+1].text}`,
                    correction: `${terms[i].text} ${baseVerbsCorrection[next]}`,
                    rule: `সাবজেক্ট যদি Third Person Singular Number (যেমন: He, She, It) হয়, তবে Present Indefinite Tense-এ মূল Verb-এর শেষে s/es যোগ করতে হয়।`
                });
            }

            if (singularPronouns.includes(current) && (next === "don't" || next === "dont")) {
                errorsFound.push({
                    type: 'Subject-Verb Agreement (কর্তা-ক্রিয়া সংগতি)',
                    mistake: `${terms[i].text} ${terms[i+1].text}`,
                    correction: `${terms[i].text} doesn't`,
                    rule: `Third Person Singular Subject (He, She, It)-এর সাথে negative sentence-এ auxiliary verb হিসেবে "doesn't" বসে।`
                });
            }
            
            if (current === 'i' && Object.values(baseVerbsCorrection).includes(next)) {
                let base = Object.keys(baseVerbsCorrection).find(key => baseVerbsCorrection[key] === next);
                if (base) {
                    errorsFound.push({
                        type: 'Subject-Verb Agreement (কর্তা-ক্রিয়া সংগতি)',
                        mistake: `${terms[i].text} ${terms[i+1].text}`,
                        correction: `${terms[i].text} ${base}`,
                        rule: `First Person "I"-এর সাথে সাধারণ Present Tense-এ Verb-এর বেস ফর্ম (s/es ছাড়া) বসে।`
                    });
                }
            }

            if (current === 'i' && next === 'is') {
                errorsFound.push({
                    type: 'Subject-Verb Agreement (কর্তা-ক্রিয়া সংগতি)',
                    mistake: `I is`,
                    correction: `I am`,
                    rule: `First Person singular "I" এর সাথে Be-verb হিসেবে সর্বদা "am" বসে।`
                });
            }
        }

        const prepChecks = [
            { wrong: 'good in', right: 'good at', rule: 'কোনো বিষয়ে দক্ষতা বোঝাতে "good at" Appropriate Preposition বসে।' },
            { wrong: 'afraid from', right: 'afraid of', rule: 'ভীত প্রকাশ করতে "afraid of" বসে।' },
            { wrong: 'proud for', right: 'proud of', rule: 'গর্বিত হওয়া অর্থে "proud of" বসে।' },
            { wrong: 'interested on', right: 'interested in', rule: 'আگاهی প্রকাশ করতে "interested in" বসে।' },
            { wrong: 'listen at', right: 'listen to', rule: 'মনোযোগ দিয়ে শোনা অর্থে "listen to" বসে।' },
            { wrong: 'depend of', right: 'depend on', rule: 'নির্ভর করা বোঝাতে "depend on" বসে।' },
            { wrong: 'suffering with', right: 'suffering from', rule: 'রোগে বা কষ্টে ভোগা বোঝাতে "suffering from" বসে।' }
        ];

        let sentenceFullLower = wordsLower.join(' ');
        prepChecks.forEach(check => {
            if (sentenceFullLower.includes(check.wrong)) {
                errorsFound.push({
                    type: 'Appropriate Preposition (উপযুক্ত অব্যয় ভুল)',
                    mistake: check.wrong,
                    correction: check.right,
                    rule: check.rule
                });
            }
        });

        const phraseChecks = [
            { wrong: 'instead than', right: 'instead of', rule: '"instead"-এর পর সাধারণত "of" প্রিপজিশন বসে।' },
            { wrong: 'go to home', right: 'go home', rule: '"home" শব্দের পূর্বে সাধারণত "to" প্রিপজিশন বসে না (যেমন: "go home" সঠিক)।' },
            { wrong: 'for buy', right: 'to buy / for buying', rule: 'উদ্দেশ্য বোঝাতে "to + V1" (Infinitive) অথবা "for + V-ing" বসে।' }
        ];

        phraseChecks.forEach(check => {
            if (sentenceFullLower.includes(check.wrong)) {
                errorsFound.push({
                    type: 'Grammar / Preposition Error (ব্যাকরণগত ভুল)',
                    mistake: check.wrong,
                    correction: check.right,
                    rule: check.rule
                });
            }
        });

        if (sentenceFullLower.includes("don't") || sentenceFullLower.includes("doesn't") || sentenceFullLower.includes("didn't") || sentenceFullLower.includes("cannot")) {
            if (wordsLower.includes('no')) {
                errorsFound.push({
                    type: 'Double Negative Error (দ্বৈত না-বোধক ভুল)',
                    mistake: `don't / negative verb + no`,
                    correction: `change "no" to "any"`,
                    rule: `ইংরেজিতে একটি ক্লোজে দুটি নেগেটিভ শব্দ (যেমন: don't এবং no) একসাথে ব্যবহৃত হয়ে অর্থ পরিবর্তন করে ফেলে। তাই নেগেটিভ ভার্বের পর "any" ব্যবহার করতে হবে।`
                });
            }
        }

        const commonSpellErrors = {
            'recieve': 'receive', 'seperate': 'separate', 'accomodation': 'accommodation',
            'goverment': 'government', 'tommorrow': 'tomorrow', 'untill': 'until',
            'truely': 'truly', 'definitly': 'definitely', 'calender': 'calendar',
            'wierd': 'weird', 'girlfried': 'girlfriend', 'boyfried': 'boyfriend',
            'freind': 'friend', 'happines': 'happiness', 'studing': 'studying',
            'plaing': 'playing', 'grammer': 'grammar', 'sentense': 'sentence',
            'writting': 'writing', 'speach': 'speech'
        };

        wordsLower.forEach((w, idx) => {
            let cleanWord = w.trim();
            // Check only words consisting of letters and longer than 1 character
            if (cleanWord.length > 1 && /^[a-z]+$/.test(cleanWord)) {
                // Skip proper nouns, names, acronyms
                let term = terms[idx];
                let tags = term.tags || [];
                let isCapitalized = /^[A-Z]/.test(term.text || '');
                let isFirstWord = idx === 0;
                
                if (tags.includes('ProperNoun') || tags.includes('Acronym') || tags.includes('Person') || tags.includes('Place') || tags.includes('Organization') || (isCapitalized && !isFirstWord)) {
                    return;
                }

                if (spellingDict) {
                    let isCorrect = spellingDict.check(cleanWord);
                    if (!isCorrect) {
                        let suggestions = spellingDict.suggest(cleanWord) || [];
                        let correction = suggestions.length > 0 ? suggestions.slice(0, 3).join(', ') : 'No suggestions';
                        errorsFound.push({
                            type: 'Spelling Error (বানান ভুল)',
                            mistake: term.text,
                            correction: correction,
                            rule: `এটি একটি বানান ভুল বলে মনে হচ্ছে। ডিকশনারি অনুযায়ী সম্ভাব্য সঠিক বানান: "${correction}"।`
                        });
                    }
                } else {
                    // Fallback to local common spell dictionary if Typo.js is still loading
                    if (commonSpellErrors[cleanWord]) {
                        errorsFound.push({
                            type: 'Spelling Error (বানান ভুল)',
                            mistake: term.text,
                            correction: commonSpellErrors[cleanWord],
                            rule: `এটি একটি বহুল পরিচিত বানান ভুল। সঠিক বানান হলো: "${commonSpellErrors[cleanWord]}"।`
                        });
                    }
                }
            }
        });

        if (errorsFound.length === 0) {
            correctionsContainer.innerHTML = `<div style="padding: 15px; rounded; text-align: center; color: var(--success); background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.15); border-radius: 8px; font-family: 'Hind Siliguri', sans-serif;">
                                                    <i class="material-icons-round align-middle me-1">check_circle</i>
                                                    <strong>সেন্টেন্সে কোনো ব্যাকরণগত বা বানান ভুল পাওয়া যায়নি! এটি সম্পূর্ণ সঠিক।</strong>
                                              </div>`;
        } else {
            errorsFound.forEach(err => {
                const card = document.createElement('div');
                card.className = 'p-3 rounded border';
                card.style.borderColor = 'rgba(239, 68, 68, 0.2)';
                card.style.background = 'rgba(239, 68, 68, 0.03)';
                card.style.borderRadius = '12px';
                card.style.padding = '15px';
                card.style.marginBottom = '12px';
                card.innerHTML = `<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">${err.type}</span>
                                  </div>
                                  <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 4px;">ভুল: <span style="color: var(--danger); text-decoration: line-through;">${err.mistake}</span></p>
                                  <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 8px;">সংশোধন: <strong style="color: var(--success);">${err.correction}</strong></p>
                                  <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; font-family: 'Hind Siliguri', sans-serif;"><strong style="color: var(--primary-hover);">ব্যাখ্যা:</strong> ${err.rule}</p>`;
                correctionsContainer.appendChild(card);
            });
        }

        document.getElementById('empty-state').classList.add('d-none');
        document.getElementById('results-state').classList.remove('d-none');
        
        document.getElementById('word-detail-panel').classList.add('d-none');
    }

    function showWordDetail(word, tag) {
        const panel = document.getElementById('word-detail-panel');
        const title = document.getElementById('word-detail-title');
        const posText = document.getElementById('word-detail-pos');
        const desc = document.getElementById('word-detail-desc');

        panel.classList.remove('d-none');
        title.innerText = `শব্দ: "${word}"`;
        posText.innerText = `শ্রেণী: ${posMeta[tag].name}`;
        desc.innerText = posMeta[tag].desc;
        
        if(window.innerWidth < 768) {
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
</script>
@endsection
