@extends('layouts.app')

@section('title', 'Parts of Speech Master - ইংরেজি Grammar-এর ভিত্তি মজবুত করুন')

@section('content')
<div class="parts-of-speech-page" style="background-color: #f8fafc !important; min-height: 100vh; color: #0f172a !important; font-family: 'Outfit', 'Inter', sans-serif; padding: 25px; border-radius: 20px;">
    <!-- Back Link & Header -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('grammar.index') }}" style="color: #2563eb; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem;">
            <i class="material-icons-round" style="font-size: 1.1rem;">arrow_back</i>
            <span style="font-family: 'Hind Siliguri', sans-serif;">ব্যাক টু ক্লাসরুম</span>
        </a>
    </div>

    <!-- HERO BANNER (Exact Design matching uploaded image) -->
    <div style="background: linear-gradient(135deg, #0b1329 0%, #1e293b 100%); border-radius: 20px; padding: 35px 40px; color: #ffffff; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); display: grid; grid-template-columns: 1.3fr 1fr; gap: 30px; align-items: center; position: relative; overflow: hidden;">
        <!-- Background decorative accent -->
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(37,99,235,0.2) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none;"></div>

        <div>
            <span style="background: rgba(37,99,235,0.3); color: #60a5fa; border: 1px solid rgba(96,165,250,0.4); padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 12px;">ENGLISH GRAMMAR CORE MODULE</span>
            <h1 style="font-size: 2.8rem; font-weight: 900; margin: 0 0 8px 0; letter-spacing: -1px; font-family: 'Outfit', sans-serif; color: #ffffff;">
                PARTS OF SPEECH
            </h1>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: #93c5fd; margin: 0 0 18px 0; font-family: 'Hind Siliguri', sans-serif;">
                ইংরেজি Grammar-এর ভিত্তি মজবুত করুন
            </h3>

            <ul style="list-style: none; padding: 0; margin: 0 0 25px 0; font-size: 0.95rem; color: #cbd5e1; font-family: 'Hind Siliguri', sans-serif; display: flex; flex-direction: column; gap: 8px;">
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #38bdf8; font-size: 1.1rem;">check_circle</i>
                    Basic থেকে HSC Level পর্যন্ত সম্পূর্ণ বিস্তারিত নিয়ম
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #38bdf8; font-size: 1.1rem;">check_circle</i>
                    বাংলায় ব্যাখ্যা, উদাহরণ ও visual chart সহ
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #38bdf8; font-size: 1.1rem;">check_circle</i>
                    প্র্যাকটিস, পরীক্ষা ও Smart Solver সহ
                </li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <i class="material-icons-round" style="color: #38bdf8; font-size: 1.1rem;">check_circle</i>
                    Book / Google / Board-style question-এর contextual analysis
                </li>
            </ul>

            <button type="button" onclick="switchTab('solver')" style="background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(37,99,235,0.4); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <span>শেখা ও সলভ শুরু করুন</span>
                <i class="material-icons-round">arrow_forward</i>
            </button>
        </div>

        <!-- Right Side: 8 Parts Stacked Buttons (Exact visual like reference image) -->
        <div style="display: flex; flex-direction: column; gap: 8px; max-width: 320px; justify-self: end; width: 100%;">
            <div onclick="filterByPart('noun')" style="background: #ea580c; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(234,88,12,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">NOUN</div>
            <div onclick="filterByPart('pronoun')" style="background: #9333ea; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(147,51,234,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">PRONOUN</div>
            <div onclick="filterByPart('adjective')" style="background: #eab308; color: #0f172a; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(234,179,8,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">ADJECTIVE</div>
            <div onclick="filterByPart('verb')" style="background: #16a34a; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(22,163,74,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">VERB</div>
            <div onclick="filterByPart('adverb')" style="background: #0284c7; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(2,132,199,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">ADVERB</div>
            <div onclick="filterByPart('preposition')" style="background: #c026d3; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(192,38,211,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">PREPOSITION</div>
            <div onclick="filterByPart('conjunction')" style="background: #2563eb; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(37,99,235,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">CONJUNCTION</div>
            <div onclick="filterByPart('interjection')" style="background: #7c3aed; color: white; padding: 9px 18px; border-radius: 10px; font-weight: 900; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; text-align: center; box-shadow: 0 3px 10px rgba(124,58,237,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">INTERJECTION</div>
        </div>
    </div>

    <!-- 8 Parts of Speech Colored Header Grid (Matching Screenshot) -->
    <div style="margin-bottom: 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0; font-family: 'Outfit', sans-serif;">8 Parts of Speech</h3>
            <span style="color: #2563eb; font-weight: 700; font-size: 0.88rem; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;" onclick="switchTab('lessons')">সবগুলো বিবরণ দেখুন →</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px;">
            <!-- Noun Card -->
            <div onclick="filterByPart('noun')" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(22,163,74,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">1</div>
                <div style="font-size: 1.1rem; font-weight: 900; margin: 2px 0;">NOUN</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">বিশেষ্য</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">👤</div>
            </div>

            <!-- Pronoun Card -->
            <div onclick="filterByPart('pronoun')" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(37,99,235,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">2</div>
                <div style="font-size: 1.1rem; font-weight: 900; margin: 2px 0;">PRONOUN</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">সর্বনাম</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">👫</div>
            </div>

            <!-- Adjective Card -->
            <div onclick="filterByPart('adjective')" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(234,88,12,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">3</div>
                <div style="font-size: 1.1rem; font-weight: 900; margin: 2px 0;">ADJECTIVE</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">বিশেষণ</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">✨</div>
            </div>

            <!-- Verb Card -->
            <div onclick="filterByPart('verb')" style="background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(147,51,234,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">4</div>
                <div style="font-size: 1.1rem; font-weight: 900; margin: 2px 0;">VERB</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">ক্রিয়া</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">🏃</div>
            </div>

            <!-- Adverb Card -->
            <div onclick="filterByPart('adverb')" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(236,72,153,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">5</div>
                <div style="font-size: 1.1rem; font-weight: 900; margin: 2px 0;">ADVERB</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">ক্রিয়া বিশেষণ</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">⚡</div>
            </div>

            <!-- Preposition Card -->
            <div onclick="filterByPart('preposition')" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(13,148,136,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">6</div>
                <div style="font-size: 1.05rem; font-weight: 900; margin: 2px 0;">PREPOSITION</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">পদান্বয়ী অব্যয়</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">🔗</div>
            </div>

            <!-- Conjunction Card -->
            <div onclick="filterByPart('conjunction')" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(217,119,6,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">7</div>
                <div style="font-size: 1.05rem; font-weight: 900; margin: 2px 0;">CONJUNCTION</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">সংযোজক অব্যয়</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">🤝</div>
            </div>

            <!-- Interjection Card -->
            <div onclick="filterByPart('interjection')" style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; border-radius: 14px; padding: 18px 12px; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(79,70,229,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 0.75rem; opacity: 0.8; font-weight: 800;">8</div>
                <div style="font-size: 1.05rem; font-weight: 900; margin: 2px 0;">INTERJECTION</div>
                <div style="font-size: 0.8rem; font-family: 'Hind Siliguri', sans-serif;">আবেগসূচক অব্যয়</div>
                <div style="font-size: 1.4rem; margin-top: 6px;">❗</div>
            </div>
        </div>
    </div>

    <!-- Quick Features Sub-Bar (Matching Screenshot) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
        <div onclick="switchTab('lessons')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">menu_book</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Rules with Examples</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">প্রতিটি বিষয়ের নিয়ম ও উদাহরণ</div>
            </div>
        </div>

        <div onclick="switchTab('visual')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fdf4ff; color: #c026d3; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">collections</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Images & Charts</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">সহজে বোঝার জন্য ছবি ও chart</div>
            </div>
        </div>

        <div onclick="switchTab('practice')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">edit_note</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">Practice Exercises</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">বহু অনুশীলন করে শিখুন</div>
            </div>
        </div>

        <div onclick="switchTab('solver')" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center;">
                <i class="material-icons-round">psychology</i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">AI Smart Solver</div>
                <div style="font-size: 0.76rem; color: #64748b; font-family: 'Hind Siliguri', sans-serif;">যেকোনো প্রশ্নের context-based সমাধান</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div id="parts-nav-bar" style="display: flex; gap: 20px; margin-bottom: 25px; border-bottom: 1px solid #cbd5e1; flex-wrap: wrap; scroll-margin-top: 20px;">
        <button type="button" class="tab-btn active" id="tab-btn-solver" onclick="switchTab('solver')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #2563eb; border-bottom: 3px solid #2563eb; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">auto_awesome</i>
            <span>স্মার্ট সলভার & আইডেন্টিফায়ার (Smart Solver)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-visual" onclick="switchTab('visual')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">image</i>
            <span>ছবি দেখে শিখি (Visual Learning)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-lessons" onclick="switchTab('lessons')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">menu_book</i>
            <span>সম্পূর্ণ লেসন & নিয়মাবলি (All Lessons)</span>
        </button>
        <button type="button" class="tab-btn" id="tab-btn-practice" onclick="switchTab('practice')" style="background: none; border: none; padding: 12px 16px; font-size: 0.95rem; font-weight: 800; color: #64748b; border-bottom: 3px solid transparent; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.15rem;">quiz</i>
            <span>অনুশীলন ও কুইজ (Practice Quiz)</span>
        </button>
    </div>

    <!-- TAB 1: SMART SOLVER INTERFACE -->
    <div id="panel-solver" class="tab-panel">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 25px; align-items: start;">
            
            <!-- Left Question Box -->
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                
                <div style="margin-bottom: 18px;">
                    <label style="display: flex; justify-content: space-between; font-weight: 800; font-size: 0.9rem; color: #0f172a; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;">
                        <span>উদাহরণ নির্বাচন করুন (Preset Sentences)</span>
                        <span style="color: #2563eb; cursor: pointer; font-size: 0.8rem;" onclick="loadRandomPreset()">🎲 র্যান্ডম উদাহরণ</span>
                    </label>
                    <select id="preset-selector" style="width: 100%; border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 14px; font-size: 0.9rem; outline: none; background: #f8fafc; font-family: 'Outfit', sans-serif;" onchange="applyPreset(this.value)">
                        <option value="">-- একটি নমুনা বাক্য নির্বাচন করুন --</option>
                        <option value="ex1">1. The boy runs quickly into the park before lunch.</option>
                        <option value="ex2">2. He is a very good student.</option>
                        <option value="ex3">3. Please water the plants because water is essential for life.</option>
                        <option value="ex4">4. This is a fast train so it runs very fast.</option>
                        <option value="ex5">5. Hurrah! We won the grand match easily.</option>
                        <option value="ex6">6. I will go after he arrives home.</option>
                        <option value="ex7">7. She works hard every single day.</option>
                    </select>
                </div>

                <!-- Input Textarea -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="font-weight: 800; font-size: 0.9rem; color: #0f172a; font-family: 'Hind Siliguri', sans-serif;">যেকোনো ইংরেজি বাক্য লিখুন (Enter Sentence)</label>
                        <span style="font-size: 0.75rem; color: #16a34a; font-weight: 800;">● Live Auto Analysis</span>
                    </div>
                    <textarea id="sentence-input" rows="5" placeholder="যেমন: The boy runs quickly into the park before lunch." style="width: 100%; border-radius: 12px; border: 1px solid #cbd5e1; padding: 14px; font-size: 0.98rem; background: #ffffff; color: #0f172a; outline: none; line-height: 1.6; font-family: 'Outfit', sans-serif;" oninput="analyzeSentence()"></textarea>
                </div>

                <button type="button" onclick="analyzeSentence()" style="width: 100%; border-radius: 12px; background: #2563eb; color: white; border: none; padding: 14px; font-size: 1rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; box-shadow: 0 4px 15px rgba(37,99,235,0.25);">
                    <span>শব্দভিত্তিক পার্ট অব স্পিচ বিশ্লেষণ করুন</span>
                    <i class="material-icons-round">psychology</i>
                </button>
            </div>

            <!-- Right Results Box -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- TOP CARD: Color-Coded Word Pills -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="background: #2563eb; color: white; padding: 4px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">Word-by-Word Color Pills</span>
                        <span id="display-confidence" style="color: #16a34a; font-weight: 800; font-size: 0.85rem;">Confidence: High (99%)</span>
                    </div>

                    <!-- Rendered Pills Container -->
                    <div id="display-pills-container" style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 15px; padding: 15px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 70px;">
                        <span style="color: #94a3b8; font-size: 0.88rem; font-family: 'Hind Siliguri', sans-serif;">উপরে একটি বাক্য লিখুন বা পছন্দ করুন...</span>
                    </div>
                </div>

                <!-- BOTTOM CARD: Detailed Analysis Table -->
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="background: #0f172a; color: white; padding: 4px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">📋 Parts of Speech Analysis Sheet</span>
                    </div>

                    <!-- Summary Counts Pill Bar -->
                    <div id="display-summary-counts" style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 15px;"></div>

                    <!-- Table -->
                    <div style="overflow-x: auto;">
                        <table class="table table-bordered mb-0" style="font-size: 0.85rem; width: 100%;">
                            <thead style="background: #0f172a; color: white;">
                                <tr>
                                    <th style="width: 35px;">#</th>
                                    <th>Word</th>
                                    <th>Part of Speech</th>
                                    <th>Category / Type</th>
                                    <th>Grammar Rule</th>
                                </tr>
                            </thead>
                            <tbody id="display-table-body">
                                <tr><td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">কোনো ফলাফল রেন্ডার হয়নি।</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- TAB 2: VISUAL LEARNING (Exact Image & Chart Grid from Screenshot) -->
    <div id="panel-visual" class="tab-panel d-none">
        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                ছবি দেখে শিখি (Visual Learning)
            </h3>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0; font-family: 'Hind Siliguri', sans-serif;">
                আইকন, উদাহরণ ও visual chart-এর মাধ্যমে সহজে ৮ প্রকার পার্ট অব স্পিচ মনে রাখুন।
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            
            <!-- Noun Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #16a34a; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Noun (বিশেষ্য)
                </div>
                <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 8px;">👤 💼 🌳</div>
                    <div style="font-size: 0.85rem; font-weight: 800; color: #15803d; font-family: 'Outfit', sans-serif;">person • book • tree</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    যেকোনো ব্যক্তি, বস্তু, স্থান, প্রাণী, পদার্থ বা গুণাবলীর নামকে Noun বলে।
                </div>
            </div>

            <!-- Pronoun Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #2563eb; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Pronoun (সর্বনাম)
                </div>
                <div style="background: #eff6ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 8px;">👤 ➔ 👨</div>
                    <div style="font-size: 1.1rem; font-weight: 900; color: #1d4ed8; font-family: 'Outfit', sans-serif;">He / She / They</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    Noun-এর পরিবর্তে যে সকল শব্দ ব্যবহৃত হয় তাকে Pronoun বলে।
                </div>
            </div>

            <!-- Adjective Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #ea580c; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Adjective (বিশেষণ)
                </div>
                <div style="background: #fff7ed; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="display: inline-block; background: #ea580c; color: white; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 0.8rem; margin-right: 6px;">CAR</div>
                    <span style="font-weight: 900; font-size: 1rem; color: #c2410c;">beautiful</span>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    Noun বা Pronoun-এর দোষ, গুণ, অবস্থা, সংখ্যা বা পরিমাণ প্রকাশ করে।
                </div>
            </div>

            <!-- Verb Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #9333ea; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Verb (ক্রিয়া)
                </div>
                <div style="background: #fdf4ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.5rem; margin-bottom: 8px;">🏃 🏃‍♀️</div>
                    <div style="font-size: 1.1rem; font-weight: 900; color: #7e22ce; font-family: 'Outfit', sans-serif;">RUN / EAT / PLAY</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    যে শব্দ দ্বারা কোনো কিছু করা, হওয়া, যাওয়া বা কোন কাজ প্রকাশ পায়।
                </div>
            </div>

            <!-- Adverb Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #ec4899; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Adverb (ক্রিয়া বিশেষণ)
                </div>
                <div style="background: #fdf2f8; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 0.85rem; font-weight: 800; color: #be185d;">How? When? Where?</div>
                    <div style="font-size: 1rem; font-weight: 900; color: #be185d; margin-top: 4px;">quickly / now / here</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    Verb, Adjective বা অন্য কোনো Adverb কীভাবে, কখন বা কোথায় ঘটছে তা নির্দেশ করে।
                </div>
            </div>

            <!-- Preposition Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #0d9488; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Preposition (পদান্বয়ী অব্যয়)
                </div>
                <div style="background: #f0fdfa; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.2rem; margin-bottom: 4px;">📦 ➔ 🐱</div>
                    <div style="font-size: 0.95rem; font-weight: 900; color: #0f766e;">in / on / under / into</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    Noun বা Pronoun-এর পূর্বে বসে বাক্যের অন্যান্য শব্দের সাথে সম্পর্ক স্থাপন করে।
                </div>
            </div>

            <!-- Conjunction Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #d97706; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Conjunction (সংযোজক অব্যয়)
                </div>
                <div style="background: #fffbeb; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.2rem; margin-bottom: 4px;">🔗</div>
                    <div style="font-size: 0.95rem; font-weight: 900; color: #b45309;">and / but / or / because</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    দুই বা ততধিক শব্দ, বাক্যাংশ বা বাক্যকে যুক্ত করতে ব্যবহৃত হয়।
                </div>
            </div>

            <!-- Interjection Card -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="text-align: center; font-weight: 800; color: #4f46e5; font-size: 1.1rem; margin-bottom: 15px; font-family: 'Hind Siliguri', sans-serif;">
                    Interjection (আবেগসূচক অব্যয়)
                </div>
                <div style="background: #eef2ff; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 15px;">
                    <div style="font-size: 2.2rem; margin-bottom: 4px;">🎉 😱 ❗</div>
                    <div style="font-size: 0.95rem; font-weight: 900; color: #4338ca;">Hurrah! / Alas! / Oh!</div>
                </div>
                <div style="font-size: 0.85rem; color: #334155; line-height: 1.5; font-family: 'Hind Siliguri', sans-serif;">
                    মনের আকস্মিক আবেগ, আনন্দ, দুঃখ, বিস্ময় বা ঘৃণা প্রকাশ করে।
                </div>
            </div>

        </div>
    </div>

    <!-- TAB 3: ALL LESSONS & RULES -->
    <div id="panel-lessons" class="tab-panel d-none">
        <div style="margin-bottom: 25px; background: #0f172a; color: white; padding: 22px; border-radius: 16px;">
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #60a5fa; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                ৮ প্রকার Parts of Speech – সম্পূর্ণ লেসন ও পজিশনাল নিয়ম
            </h2>
            <p style="margin: 0; color: #cbd5e1; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                প্রতিটি পদের শ্রেণীবিভাগ, বাক্যে অবস্থান (Position Rules) এবং কমন মিস্টেক বিশ্লেষণ।
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Noun Section -->
            <div id="part-sec-noun" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #16a34a; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">1. NOUN (বিশেষ্য)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>Noun-এর প্রধান ৫ প্রকার:</strong><br>
                    ১. <strong>Proper Noun:</strong> নির্দিষ্ট ব্যক্তি/স্থানের নাম (Dhaka, Rahim, Bangladesh)<br>
                    ২. <strong>Common Noun:</strong> একজাতীয় সকলের সাধারণ নাম (boy, city, river, student)<br>
                    ৩. <strong>Collective Noun:</strong> সমষ্টির নাম (team, class, jury, family)<br>
                    ৪. <strong>Material Noun:</strong> বস্তু বা পদার্থের নাম যা গণনা করা যায় না, মাপা যায় (water, gold, milk)<br>
                    ৫. <strong>Abstract Noun:</strong> অদৃশ্য গুণ, অবস্থা বা ধারণার নাম (honesty, love, freedom, beauty)
                </p>
                <div style="background: #f8fafc; border-left: 4px solid #16a34a; padding: 10px 14px; font-size: 0.85rem; color: #0f172a; margin-top: 10px;">
                    <strong>Position Rule:</strong> Article (a/an/the) + Noun / Preposition + Noun / Possessive (my, his) + Noun.
                </div>
            </div>

            <!-- Pronoun Section -->
            <div id="part-sec-pronoun" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #2563eb; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">2. PRONOUN (সর্বনাম)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    <strong>Pronoun-এর প্রকারভেদ:</strong><br>
                    • <strong>Personal:</strong> I, we, you, he, she, they, it<br>
                    • <strong>Demonstrative:</strong> this, that, these, those<br>
                    • <strong>Relative:</strong> who, which, that, whom, whose<br>
                    • <strong>Interrogative:</strong> Who, what, which (প্রশ্ন করতে)<br>
                    • <strong>Indefinite:</strong> someone, anyone, nobody, all, many
                </p>
            </div>

            <!-- Adjective Section -->
            <div id="part-sec-adjective" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #ea580c; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">3. ADJECTIVE (বিশেষণ)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    Noun বা Pronoun-কে বিশেষায়িত করে।<br>
                    <strong>Position Rule:</strong> Noun-এর ঠিক পূর্বে বসে (Determiner + Adjective + Noun)।<br>
                    <em>উদাহরণ:</em> He is a <strong>good</strong> boy. (boy Noun-কে modify করছে)
                </p>
            </div>

            <!-- Verb Section -->
            <div id="part-sec-verb" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #9333ea; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">4. VERB (ক্রিয়া)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • <strong>Finite Verb:</strong> Tense ও Subject অনুযায়ী পরিবর্তিত হয় (go, plays, wrote)<br>
                    • <strong>Non-Finite Verb:</strong> Tense অনুযায়ী বদলায় না (Infinitive: to go, Participle: running, Gerund: swimming)<br>
                    • <strong>Auxiliary / Helping:</strong> am, is, are, was, were, have, has, can, could
                </p>
            </div>

            <!-- Adverb Section -->
            <div id="part-sec-adverb" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #ec4899; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">5. ADVERB (ক্রিয়া বিশেষণ)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    Verb, Adjective বা অন্য Adverb-কে বিশেষায়িত করে।<br>
                    • <strong>Adverb of Manner (কীভাবে):</strong> quickly, slowly, hard, fast<br>
                    • <strong>Adverb of Time (কখন):</strong> now, yesterday, soon, today<br>
                    • <strong>Adverb of Place (কোথায়):</strong> here, there, everywhere
                </p>
            </div>

            <!-- Preposition Section -->
            <div id="part-sec-preposition" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #0d9488; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">6. PREPOSITION (পদান্বয়ী অব্যয়)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    in, on, at, into, before, after, with, without, by, for, of, from, to.<br>
                    <strong>Rule:</strong> Preposition-এর পর সর্বদাই Noun, Pronoun বা Verb+ing (Gerund) বসে।
                </p>
            </div>

            <!-- Conjunction Section -->
            <div id="part-sec-conjunction" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #d97706; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">7. CONJUNCTION (সংযোজক অব্যয়)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    • <strong>Coordinating:</strong> and, but, or, so, for, nor<br>
                    • <strong>Subordinating:</strong> because, although, if, since, as, after, before (যখন ২টি clause যুক্ত করে)
                </p>
            </div>

            <!-- Interjection Section -->
            <div id="part-sec-interjection" class="lesson-sec-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #4f46e5; color: white; padding: 4px 12px; border-radius: 6px; font-weight: 900; font-size: 0.85rem;">8. INTERJECTION (আবেগসূচক অব্যয়)</span>
                </div>
                <p style="color: #334155; font-size: 0.92rem; line-height: 1.6; font-family: 'Hind Siliguri', sans-serif;">
                    Hurrah!, Alas!, Oh!, Wow!, Bravo!, Ouch!<br>
                    <strong>Rule:</strong> এদের পর সাধারণত Note of Exclamation (!) বসে।
                </p>
            </div>
        </div>
    </div>

    <!-- TAB 4: PRACTICE QUIZ -->
    <div id="panel-practice" class="tab-panel d-none">
        <div style="margin-bottom: 25px; background: #16a34a; color: white; padding: 22px; border-radius: 16px;">
            <h2 style="font-size: 1.6rem; font-weight: 800; margin: 0 0 6px 0; font-family: 'Hind Siliguri', sans-serif;">
                Parts of Speech Practice Quiz
            </h2>
            <p style="margin: 0; color: #dcfce7; font-size: 0.92rem; font-family: 'Hind Siliguri', sans-serif;">
                নিচের বাক্যে চিহ্নিত শব্দটি কোন Part of Speech নির্বাচন করুন এবং লাইভ উত্তর যাচাই করুন।
            </p>
        </div>

        <div id="quiz-container" style="display: flex; flex-direction: column; gap: 20px;"></div>
    </div>

</div>

<!-- JAVASCRIPT SOLVER & ANALYSIS ENGINE -->
<script>
// ADVANCED POS GRAMMAR SETS & COMPREHENSIVE VOCABULARY
const PRONOUNS = new Set([
    "i", "me", "my", "mine", "myself",
    "we", "us", "our", "ours", "ourselves",
    "you", "your", "yours", "yourself", "yourselves",
    "he", "him", "his", "himself",
    "she", "her", "hers", "herself",
    "it", "its", "itself",
    "they", "them", "their", "theirs", "themselves",
    "who", "whom", "whose", "which", "that", "what",
    "this", "that", "these", "those",
    "someone", "somebody", "something",
    "anyone", "anybody", "anything",
    "everyone", "everybody", "everything",
    "no one", "nobody", "nothing",
    "each", "every", "either", "neither", "all", "any", "both", "few", "many", "much", "several", "some"
]);

const AUXILIARY_VERBS = new Set([
    "am", "is", "are", "was", "were", "be", "been", "being",
    "have", "has", "had", "do", "does", "did",
    "can", "could", "may", "might", "shall", "should", "will", "would", "must", "ought", "need", "dare"
]);

const PREPOSITIONS = new Set([
    "about", "above", "across", "after", "against", "along", "among", "around", "at",
    "before", "behind", "below", "beneath", "beside", "besides", "between", "beyond", "by",
    "despite", "down", "during", "except", "for", "from", "in", "inside", "into", "like",
    "near", "of", "off", "on", "onto", "out", "outside", "over", "past", "since",
    "through", "throughout", "till", "to", "toward", "towards", "under", "underneath", "until",
    "up", "upon", "with", "within", "without"
]);

const CONJUNCTIONS = new Set([
    "and", "but", "or", "nor", "for", "yet", "so",
    "although", "as", "because", "before", "even", "if", "once", "provided", "since",
    "than", "that", "though", "unless", "until", "when", "whenever", "where", "whereas", "wherever", "whether", "while"
]);

const INTERJECTIONS = new Set([
    "hurrah", "alas", "oh", "wow", "bravo", "ouch", "ah", "hey", "hello", "oops", "yay", "phew"
]);

const ARTICLES_DETERMINERS = new Set(["a", "an", "the", "this", "that", "these", "those", "my", "his", "her", "their", "our", "your"]);

const COMMON_ADJECTIVES = new Set([
    "quick", "slow", "fast", "brown", "red", "blue", "green", "yellow", "black", "white",
    "big", "small", "tall", "short", "long", "lazy", "active", "happy", "sad", "good", "bad",
    "beautiful", "ugly", "smart", "intelligent", "brave", "rich", "poor", "old", "new", "young",
    "high", "low", "hot", "cold", "warm", "dark", "bright", "clean", "dirty", "hard", "soft",
    "heavy", "light", "strong", "weak", "quiet", "loud", "great", "grand", "essential",
    "clever", "wise", "foolish", "honest", "dishonest", "kind", "cruel", "true", "false",
    "deep", "shallow", "easy", "difficult", "fresh", "stale", "healthy", "sick", "first",
    "second", "third", "last", "next", "every", "single", "whole", "entire", "fine", "nice"
]);

const COMMON_VERBS = new Set([
    "call", "calls", "called", "calling",
    "reach", "reaches", "reached", "reaching",
    "run", "runs", "ran", "running",
    "jump", "jumps", "jumped", "jumping",
    "see", "sees", "saw", "seen", "seeing",
    "look", "looks", "looked", "looking",
    "walk", "walks", "walked", "walking",
    "eat", "eats", "ate", "eaten", "eating",
    "drink", "drinks", "drank", "drunk", "drinking",
    "sleep", "sleeps", "slept", "sleeping",
    "speak", "speaks", "spoke", "spoken", "speaking",
    "write", "writes", "wrote", "written", "writing",
    "read", "reads", "reading",
    "play", "plays", "played", "playing",
    "work", "works", "worked", "working",
    "live", "lives", "lived", "living",
    "love", "loves", "loved", "loving",
    "think", "thinks", "thought", "thinking",
    "know", "knows", "knew", "known", "knowing",
    "take", "takes", "took", "taken", "taking",
    "give", "gives", "gave", "given", "giving",
    "make", "makes", "made", "making",
    "come", "comes", "came", "coming",
    "go", "goes", "went", "gone", "going",
    "find", "finds", "found", "finding",
    "tell", "tells", "told", "telling",
    "ask", "asks", "asked", "asking",
    "feel", "feels", "felt", "feeling",
    "try", "tries", "tried", "trying",
    "leave", "leaves", "left", "leaving",
    "show", "shows", "showed", "shown", "showing",
    "meet", "meets", "met", "meeting",
    "help", "helps", "helped", "helping",
    "start", "starts", "started", "starting",
    "turn", "turns", "turned", "turning",
    "move", "moves", "moved", "moving",
    "hear", "hears", "heard", "hearing",
    "stand", "stands", "stood", "standing",
    "arrive", "arrives", "arrived", "arriving",
    "win", "wins", "won", "winning",
    "want", "wants", "wanted", "wanting",
    "use", "uses", "used", "using",
    "put", "puts", "putting",
    "begin", "begins", "began", "begun", "beginning",
    "seem", "seems", "seemed", "seeming",
    "talk", "talks", "talked", "talking",
    "believe", "believes", "believed", "believing",
    "bring", "brings", "brought", "bringing",
    "happen", "happens", "happened", "happening",
    "sit", "sits", "sat", "sitting",
    "pay", "pays", "paid", "paying",
    "include", "includes", "included", "including",
    "continue", "continues", "continued", "continuing",
    "set", "sets", "setting",
    "learn", "learns", "learnt", "learned", "learning",
    "change", "changes", "changed", "changing",
    "lead", "leads", "led", "leading",
    "understand", "understands", "understood", "understanding",
    "watch", "watches", "watched", "watching",
    "follow", "follows", "followed", "following",
    "stop", "stops", "stopped", "stopping",
    "create", "creates", "created", "creating",
    "allow", "allows", "allowed", "allowing",
    "add", "adds", "added", "adding",
    "spend", "spends", "spent", "spending",
    "grow", "grows", "grew", "grown", "growing",
    "open", "opens", "opened", "opening",
    "offer", "offers", "offered", "offering",
    "remember", "remembers", "remembered", "remembering",
    "consider", "considers", "considered", "considering",
    "appear", "appears", "appeared", "appearing",
    "buy", "buys", "bought", "buying",
    "wait", "waits", "waited", "waiting",
    "serve", "serves", "served", "serving",
    "die", "dies", "died", "dying",
    "send", "sends", "sent", "sending",
    "expect", "expects", "expected", "expecting",
    "build", "builds", "built", "building",
    "stay", "stays", "stayed", "staying",
    "fall", "falls", "fell", "fallen", "falling",
    "cut", "cuts", "cutting",
    "kill", "kills", "killed", "killing",
    "remain", "remains", "remained", "remaining"
]);

const PRESET_SENTENCES = {
    "ex1": "The boy runs quickly into the park before lunch.",
    "ex2": "He is a very good student.",
    "ex3": "Please water the plants because water is essential for life.",
    "ex4": "This is a fast train so it runs very fast.",
    "ex5": "Hurrah! We won the grand match easily.",
    "ex6": "I will go after he arrives home.",
    "ex7": "She works hard every single day."
};

const POS_COLORS = {
    "Noun": { bg: "#dcfce7", text: "#15803d", border: "#86efac" },
    "Pronoun": { bg: "#dbeafe", text: "#1e40af", border: "#93c5fd" },
    "Adjective": { bg: "#ffedd5", text: "#c2410c", border: "#fdba74" },
    "Verb": { bg: "#f3e8ff", text: "#6b21a8", border: "#d8b4fe" },
    "Adverb": { bg: "#fce7f3", text: "#be185d", border: "#f9a8d4" },
    "Preposition": { bg: "#ccfbf1", text: "#0f766e", border: "#5eead4" },
    "Conjunction": { bg: "#fef3c7", text: "#b45309", border: "#fcd34d" },
    "Interjection": { bg: "#e0e7ff", text: "#3730a3", border: "#a5b4fc" }
};

function switchTab(tabName) {
    document.querySelectorAll('.tab-panel').forEach(p => {
        p.classList.add('d-none');
    });

    const targetPanel = document.getElementById('panel-' + tabName);
    if (targetPanel) {
        targetPanel.classList.remove('d-none');
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.style.color = "#64748b";
        btn.style.borderBottom = "3px solid transparent";
        btn.classList.remove('active');
    });

    const activeBtn = document.getElementById('tab-btn-' + tabName);
    if (activeBtn) {
        activeBtn.style.color = "#2563eb";
        activeBtn.style.borderBottom = "3px solid #2563eb";
        activeBtn.classList.add('active');
    }

    const navBar = document.getElementById('parts-nav-bar');
    if (navBar) {
        navBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function filterByPart(partName) {
    switchTab('lessons');
    setTimeout(() => {
        const targetSec = document.getElementById('part-sec-' + partName);
        if (targetSec) {
            targetSec.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetSec.style.border = "2px solid #2563eb";
            targetSec.style.boxShadow = "0 0 18px rgba(37,99,235,0.3)";
            setTimeout(() => { 
                targetSec.style.border = "1px solid #e2e8f0";
                targetSec.style.boxShadow = "none";
            }, 3000);
        }
    }, 150);
}

function applyPreset(key) {
    if (!key) return;
    const text = PRESET_SENTENCES[key];
    if (text) {
        document.getElementById('sentence-input').value = text;
        analyzeSentence();
    }
}

function loadRandomPreset() {
    const keys = Object.keys(PRESET_SENTENCES);
    applyPreset(keys[Math.floor(Math.random() * keys.length)]);
}

// MAIN WORD-BY-WORD CONTEXTUAL ANALYZER (ROBUST SYNTAX & VOCABULARY ENGINE)
function analyzeSentence() {
    const text = document.getElementById('sentence-input').value.trim();
    if (!text) return;

    const tokens = text.split(/\s+/);
    let analyzedWords = [];
    let summaryCounts = { Noun: 0, Pronoun: 0, Adjective: 0, Verb: 0, Adverb: 0, Preposition: 0, Conjunction: 0, Interjection: 0 };

    tokens.forEach((rawToken, idx) => {
        const cleanWord = rawToken.replace(/^["'“”]+|["'”.,!?;:()]+$/g, '');
        const lowerWord = cleanWord.toLowerCase();
        if (!cleanWord) return;

        let pos = "Noun";
        let type = "Common Noun";
        let rule = "Default Noun role in sentence.";

        // CONTEXTUAL HOMONYM & SYNTAX RULES ENGINE
        if (lowerWord === "water") {
            if (idx === 0 || (idx > 0 && tokens[idx-1].toLowerCase() === "please")) {
                pos = "Verb"; type = "Imperative Verb"; rule = "Used as action verb at command start.";
            } else if (idx > 0 && (tokens[idx-1].toLowerCase() === "the" || tokens[idx-1].toLowerCase() === "clean")) {
                pos = "Noun"; type = "Material Noun"; rule = "Preceded by determiner/adj.";
            } else {
                pos = "Noun"; type = "Material Noun"; rule = "Subject of 'is'.";
            }
        } else if (lowerWord === "fast") {
            if (idx > 0 && (tokens[idx-1].toLowerCase() === "a" || tokens[idx-1].toLowerCase() === "the" || tokens[idx-1].toLowerCase() === "very")) {
                if (idx < tokens.length - 1 && tokens[idx+1].toLowerCase().replace(/[.,!?;:"'()]/g, '') === "train") {
                    pos = "Adjective"; type = "Adjective of Quality"; rule = "Modifies Noun 'train'.";
                } else {
                    pos = "Adverb"; type = "Adverb of Manner"; rule = "Modifies Verb 'runs'.";
                }
            } else {
                pos = "Adverb"; type = "Adverb of Manner"; rule = "Modifies Action Verb.";
            }
        } else if (lowerWord === "hard") {
            pos = "Adverb"; type = "Adverb of Manner"; rule = "Modifies Verb 'works'.";
        }
        // 1. Articles / Determiners
        else if (ARTICLES_DETERMINERS.has(lowerWord)) {
            pos = "Adjective";
            type = (lowerWord === "a" || lowerWord === "an" || lowerWord === "the") ? "Definite Article / Determiner" : "Demonstrative / Possessive";
            rule = "Determiner modifying noun phrase.";
        }
        // 2. Interjections
        else if (INTERJECTIONS.has(lowerWord) || rawToken.includes("!")) {
            pos = "Interjection";
            type = "Exclamation of Joy/Emotion";
            rule = "Expresses sudden emotion/exclamation.";
        }
        // 3. Preceding Determiner + Adjective + Noun Syntax Rule!
        // Example: "The quick brown fox" -> "quick" (Adjective), "brown" (Adjective), "fox" (Noun)
        else if (idx > 0 && ARTICLES_DETERMINERS.has(tokens[idx-1].toLowerCase().replace(/[.,!?;:"'()]/g, '')) && COMMON_ADJECTIVES.has(lowerWord)) {
            pos = "Adjective";
            type = "Adjective of Quality";
            rule = "Modifies succeeding Noun.";
        }
        else if (idx > 1 && ARTICLES_DETERMINERS.has(tokens[idx-2].toLowerCase().replace(/[.,!?;:"'()]/g, '')) && COMMON_ADJECTIVES.has(tokens[idx-1].toLowerCase().replace(/[.,!?;:"'()]/g, '')) && COMMON_ADJECTIVES.has(lowerWord)) {
            pos = "Adjective";
            type = "Adjective of Quality";
            rule = "Modifies succeeding Noun.";
        }
        // 4. Modal Verb / Auxiliary + Main Verb Syntax Rule!
        // Example: "will call" -> "will" (Modal Verb), "call" (Action Verb)
        else if (idx > 0 && AUXILIARY_VERBS.has(tokens[idx-1].toLowerCase().replace(/[.,!?;:"'()]/g, ''))) {
            if (COMMON_VERBS.has(lowerWord) || lowerWord.endsWith("ed") || lowerWord.endsWith("ing") || lowerWord.endsWith("en")) {
                pos = "Verb";
                type = "Main Action Verb";
                rule = "Main verb following auxiliary/modal verb.";
            } else if (COMMON_ADJECTIVES.has(lowerWord)) {
                pos = "Adjective";
                type = "Adjective of Quality";
                rule = "Predicate adjective following linking verb.";
            }
        }
        // 5. Subject Pronoun + Verb Syntax Rule!
        // Example: "I reach", "He arrives", "They play"
        else if (idx > 0 && PRONOUNS.has(tokens[idx-1].toLowerCase().replace(/[.,!?;:"'()]/g, '')) && (COMMON_VERBS.has(lowerWord) || lowerWord.endsWith("s") || lowerWord.endsWith("ed") || lowerWord.endsWith("es"))) {
            pos = "Verb";
            type = "Action Verb";
            rule = "Action verb performed by Subject pronoun.";
        }
        // 6. Adjectives List
        else if (COMMON_ADJECTIVES.has(lowerWord)) {
            pos = "Adjective";
            type = "Adjective of Quality";
            rule = "Describes quality of Noun/Pronoun.";
        }
        // 7. Verbs List
        else if (COMMON_VERBS.has(lowerWord) || AUXILIARY_VERBS.has(lowerWord)) {
            pos = "Verb";
            type = AUXILIARY_VERBS.has(lowerWord) ? "Auxiliary / Modal Verb" : "Action Verb";
            rule = AUXILIARY_VERBS.has(lowerWord) ? "Helping verb in sentence." : "Main action verb.";
        }
        // 8. Prepositions List
        else if (PREPOSITIONS.has(lowerWord)) {
            if ((lowerWord === "after" || lowerWord === "before") && idx < tokens.length - 1 && PRONOUNS.has(tokens[idx+1].toLowerCase().replace(/[.,!?;:"'()]/g, ''))) {
                pos = "Conjunction";
                type = "Subordinating Conjunction";
                rule = "Joins clause starting with Subject pronoun.";
            } else {
                pos = "Preposition";
                type = "Preposition of Direction/Place/Time";
                rule = "Precedes Noun/Pronoun object.";
            }
        }
        // 9. Conjunctions List
        else if (CONJUNCTIONS.has(lowerWord)) {
            pos = "Conjunction";
            type = "Coordinating / Subordinating Conjunction";
            rule = "Connects words, phrases or clauses.";
        }
        // 10. Pronouns List
        else if (PRONOUNS.has(lowerWord)) {
            pos = "Pronoun";
            type = (lowerWord === "i" || lowerWord === "we" || lowerWord === "you" || lowerWord === "he" || lowerWord === "she" || lowerWord === "they" || lowerWord === "it") ? "Personal Pronoun (Subject)" : "Personal / Object Pronoun";
            rule = "Replaces Noun in Subject/Object position.";
        }
        // 11. Suffix Heuristics
        else if (lowerWord.endsWith("ly")) {
            pos = "Adverb"; type = "Adverb of Manner"; rule = "Suffix '-ly' indicates adverb.";
        }
        else if (lowerWord.endsWith("tion") || lowerWord.endsWith("ment") || lowerWord.endsWith("ness") || lowerWord.endsWith("ity") || lowerWord.endsWith("ship") || lowerWord.endsWith("er") || lowerWord.endsWith("or")) {
            pos = "Noun"; type = "Abstract / Common Noun"; rule = "Noun suffix pattern.";
        }
        else if (lowerWord.endsWith("ful") || lowerWord.endsWith("ous") || lowerWord.endsWith("ive") || lowerWord.endsWith("able") || lowerWord.endsWith("ish") || lowerWord.endsWith("less")) {
            pos = "Adjective"; type = "Adjective of Quality"; rule = "Adjective suffix pattern.";
        }
        else if (lowerWord.endsWith("ed") || lowerWord.endsWith("ing") || lowerWord.endsWith("es")) {
            pos = "Verb"; type = "Action Verb"; rule = "Verb tense suffix.";
        }

        if (summaryCounts[pos] !== undefined) summaryCounts[pos]++;

        analyzedWords.push({
            id: idx + 1,
            original: rawToken,
            clean: cleanWord,
            pos: pos,
            type: type,
            rule: rule
        });
    });

    // Render Color Pills
    const pillsContainer = document.getElementById('display-pills-container');
    pillsContainer.innerHTML = "";

    analyzedWords.forEach(w => {
        const styleObj = POS_COLORS[w.pos] || POS_COLORS["Noun"];
        const pill = document.createElement('div');
        pill.style.cssText = `background: ${styleObj.bg}; color: ${styleObj.text}; border: 1px solid ${styleObj.border}; padding: 6px 12px; border-radius: 10px; font-size: 0.9rem; font-weight: 800; display: inline-flex; flex-direction: column; align-items: center; cursor: pointer;`;
        pill.innerHTML = `
            <span>${w.clean}</span>
            <span style="font-size: 0.68rem; opacity: 0.85; text-transform: uppercase; font-weight: 900;">${w.pos}</span>
        `;
        pillsContainer.appendChild(pill);
    });

    // Render Summary Counts
    const countsContainer = document.getElementById('display-summary-counts');
    countsContainer.innerHTML = "";
    Object.keys(summaryCounts).forEach(k => {
        if (summaryCounts[k] > 0) {
            const styleObj = POS_COLORS[k];
            const badge = document.createElement('span');
            badge.style.cssText = `background: ${styleObj.bg}; color: ${styleObj.text}; padding: 3px 10px; border-radius: 6px; font-size: 0.76rem; font-weight: 800; font-family: 'Outfit', sans-serif;`;
            badge.innerText = `${k}: ${summaryCounts[k]}`;
            countsContainer.appendChild(badge);
        }
    });

    // Render Analysis Table
    const tbody = document.getElementById('display-table-body');
    tbody.innerHTML = "";

    analyzedWords.forEach(w => {
        const styleObj = POS_COLORS[w.pos] || POS_COLORS["Noun"];
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="text-align: center; font-weight: bold; background: #f8fafc; color: #64748b;">${w.id}</td>
            <td style="font-weight: 800; color: #0f172a;">${w.clean}</td>
            <td><span style="background: ${styleObj.bg}; color: ${styleObj.text}; border: 1px solid ${styleObj.border}; padding: 2px 8px; border-radius: 6px; font-weight: 800; font-size: 0.8rem;">${w.pos}</span></td>
            <td style="font-weight: 700; color: #334155;">${w.type}</td>
            <td style="font-size: 0.8rem; color: #475569;">${w.rule}</td>
        `;
        tbody.appendChild(tr);
    });
}

// PRACTICE QUIZ ENGINE
const QUIZ_QUESTIONS = [
    { q: "1. The boy runs <u>quickly</u> into the park.", word: "quickly", options: ["Noun", "Verb", "Adverb", "Adjective"], answer: "Adverb", exp: "'quickly' Verb 'runs'-কে modify করছে (কীভাবে দৌড়ায়)।" },
    { q: "2. Please <u>water</u> the plants daily.", word: "water", options: ["Noun", "Verb", "Adjective", "Preposition"], answer: "Verb", exp: "বাক্যের শুরুতে 'water' আদেশমূলক কাজ (ক্রিয়া) হিসেবে ব্যবহৃত হয়েছে।" },
    { q: "3. Honesty is the <u>best</u> policy.", word: "best", options: ["Noun", "Adjective", "Adverb", "Pronoun"], answer: "Adjective", exp: "'best' Noun 'policy'-র গুণ নির্দেশক Superlative Adjective।" },
    { q: "4. He arrived <u>after</u> the train had left.", word: "after", options: ["Preposition", "Conjunction", "Adverb", "Verb"], answer: "Conjunction", exp: "এখানে 'after' ২টি আলাদা clause-কে যুক্ত করেছে।" },
    { q: "5. <u>Hurrah!</u> We won the match.", word: "Hurrah!", options: ["Interjection", "Conjunction", "Noun", "Adverb"], answer: "Interjection", exp: "আবেগ ও আনন্দ প্রকাশক শব্দ।" }
];

function renderQuiz() {
    const container = document.getElementById('quiz-container');
    container.innerHTML = "";

    QUIZ_QUESTIONS.forEach((item, idx) => {
        const card = document.createElement('div');
        card.style.cssText = "background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);";
        
        let optsHtml = "";
        item.options.forEach(opt => {
            optsHtml += `
                <button type="button" onclick="checkQuiz(${idx}, '${opt}', this)" style="background: #f8fafc; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; color: #0f172a; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#2563eb'">${opt}</button>
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
    const item = QUIZ_QUESTIONS[idx];
    const ansBox = document.getElementById(`quiz-ans-${idx}`);
    ansBox.classList.remove('d-none');

    if (selectedOpt === item.answer) {
        btn.style.background = "#22c55e"; btn.style.color = "white"; btn.style.borderColor = "#16a34a";
        ansBox.style.background = "#dcfce7"; ansBox.style.color = "#15803d";
        ansBox.innerHTML = `✅ সঠিক উত্তর! <strong>${item.answer}</strong> — ${item.exp}`;
    } else {
        btn.style.background = "#ef4444"; btn.style.color = "white"; btn.style.borderColor = "#dc2626";
        ansBox.style.background = "#fee2e2"; ansBox.style.color = "#991b1b";
        ansBox.innerHTML = `❌ ভুল উত্তর। সঠিক উত্তর: <strong>${item.answer}</strong> — ${item.exp}`;
    }
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    renderQuiz();
    document.getElementById('sentence-input').value = "The boy runs quickly into the park before lunch.";
    analyzeSentence();
});
</script>
@endsection
