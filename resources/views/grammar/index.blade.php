@extends('layouts.app')

@section('title', 'ইংরেজি গ্রামার ক্লাসরুম - Master English Grammar')

@section('content')
<div class="container py-5" style="color: var(--text-main); font-family: 'Outfit', 'Inter', sans-serif;">
    <!-- Welcome Header -->
    <div style="text-align: center; margin-bottom: 50px; position: relative;">
        <!-- Glowing background blobs -->
        <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 250px; height: 250px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%); z-index: -1;"></div>

        <div style="margin-bottom: 20px;">
            <span style="background: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.3); padding: 8px 20px; border-radius: 30px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="material-icons-round" style="font-size: 1rem;">school</i> ENGLISH GRAMMAR CLASSROOM
            </span>
        </div>

        <h1 style="font-size: 3.2rem; font-weight: 800; color: #fff; margin-bottom: 15px; font-family: 'Hind Siliguri', 'Outfit', sans-serif; letter-spacing: -0.5px; line-height: 1.2; background: linear-gradient(135deg, #fff 60%, #a5b4fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            ইংরেজি গ্রামার মাস্টারক্লাস
        </h1>

        <p style="color: var(--text-muted); font-size: 1.05rem; max-width: 650px; margin: 0 auto 30px auto; line-height: 1.7; font-family: 'Hind Siliguri', sans-serif;">
            ইন্টারেক্টিভ লার্নিং মডিউলের মাধ্যমে ইংরেজি গ্রামারের খুঁটিনাটি শিখুন। প্রতিটি টপিকের রয়েছে বিস্তারিত নিয়ম, লাইভ টেস্ট এবং প্র্যাকটিস টুলস।
        </p>

        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <a href="{{ route('grammar.tense') }}" class="btn btn-primary py-3 px-5" style="border-radius: 12px; display: inline-flex; align-items: center; gap: 10px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3); transition: all 0.2s;">
                <i class="material-icons-round">history_toggle_off</i>
                <span>টেন্স প্র্যাকটিস শুরু করুন</span>
            </a>
            <a href="{{ route('grammar.checker') }}" class="btn btn-secondary py-3 px-5" style="border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: 1px solid var(--border-color); transition: all 0.2s;">
                <i class="material-icons-round">spellcheck</i>
                <span>গ্রামার চেকার টুল</span>
            </a>
        </div>
    </div>

    <!-- Syllabus Sections (Redesigned Topic Grid) -->
    <div style="margin-top: 50px;">
        <div style="margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
            <span style="width: 24px; height: 4px; background-color: var(--primary-color); display: inline-block; border-radius: 2px;"></span>
            <h3 style="color: #fff; font-weight: 800; font-size: 1.4rem; margin: 0; font-family: 'Hind Siliguri', sans-serif; letter-spacing: 0.5px;">
                লার্নিং মডিউল সমূহ (Learning Modules)
            </h3>
        </div>

        <div class="grid-3" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
            <!-- CARD 1: Tense (Active / Redesigned) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">history_toggle_off</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Tense (কাল)</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        ইংরেজি ভাষার প্রাণ হচ্ছে Tense। এই মডিউলে ১২টি টেন্সের বিস্তারিত গঠনপ্রণালী, উদাহরণ, টাইমলাইন চিত্রের মাধ্যমে চমৎকার ব্যাখ্যা এবং একটি ইন্টারেক্টিভ অটো-কনভার্টার রয়েছে।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        ১২টি প্রকারভেদ ও রূপান্তর
                    </span>
                    <a href="{{ route('grammar.tense') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>মডিউলে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 2: Parts of Speech (Coming Soon / Disabled style) -->
            <!-- CARD 2: Parts of Speech (Active / Ready) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">category</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Parts of Speech (পদ প্রকরণ)</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        বাক্যের প্রতিটি শব্দ চিহ্নিতকরণ, ৮টি পদের বিস্তারিত নিয়ম, উদাহরণ, কমন মিস্টেক এবং স্মার্ট ওয়ার্ড-বাই-ওয়ার্ড আইডেন্টিফায়ার সলভার।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        ৮ প্রকার পদ & Smart Solver
                    </span>
                    <a href="{{ route('grammar.parts_of_speech') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>মডিউলে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 3: Narration Change (Active / Redesigned) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">record_voice_over</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Narration (উক্তি পরিবর্তন)</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        বক্তার বক্তব্য প্রকাশের ধরনকে উক্তি বা Narration বলে। এই মডিউলে Direct থেকে Indirect উক্তি পরিবর্তনের নিয়মকানুন ও লাইভ কনভার্টার রয়েছে।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        Direct & Indirect Speech
                    </span>
                    <a href="{{ route('grammar.narration') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>মডিউলে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 3B: Narration Solver (Active / Solver Module) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">psychology</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Narration Solver</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        একক বাক্য বা প্যাসেজ ন্যারেশন সলভার। ৯টি স্টেপের নিয়ম বিশ্লেষণ, ওয়াটারমার্কড অ্যানসার শিট ও কনফিডেন্স স্কোর রিপোর্ট।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        বোর্ড প্রশ্ন & সলভার
                    </span>
                    <a href="{{ route('grammar.narration_solver') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>সলভারে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 4: Right of Verb (Subject) (Active / Learning Module) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">auto_stories</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Right of Verb (Subject)</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        Verb-এর পর Subject/Object ব্যবহারের সকল নিয়ম, ৮টি ধরন, স্টেপ-বাই-স্টেপ এনালাইজার ও বাক্যের ধরন পরিবর্তনের ইন্টারেক্টিভ লার্নিং মডিউল।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        ৮ প্রকার & কনভার্টার
                    </span>
                    <a href="{{ route('grammar.right_of_verb') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>মডিউলে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 5: Right Form of Verbs Solver (Active / Solver Module) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">spellcheck</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Right Form of Verbs Solver</h4>
                    <a href="{{ route('grammar.right_form_of_verbs') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>সলভারে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>

            <!-- CARD 6: Articles Master (Active / Ready) -->
            <div class="glass glass-interactive" style="display: flex; flex-direction: column; justify-content: space-between; padding: 30px; min-height: 280px; border-radius: 20px; border: 1px solid rgba(99, 102, 241, 0.25); background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(0, 0, 0, 0.4) 100%); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Glowing corner accent -->
                <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0) 70%);"></div>

                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.3);">
                            <i class="material-icons-round" style="color: #a5b4fc; font-size: 1.6rem;">article</i>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ready</span>
                    </div>

                    <h4 style="color: #fff; font-weight: 800; font-size: 1.35rem; margin-bottom: 12px; font-family: 'Hind Siliguri', sans-serif;">Articles (A, An, The & Cross Article)</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; font-family: 'Hind Siliguri', sans-serif;">
                        A, An, The এবং Zero Article (x)-এর সকল নিয়ম, উচ্চারণগত ব্যতিক্রম, বোর্ড প্যাসেজ সলভার ও ডিজিটাল অ্যানসার শিট।
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; margin-top: auto;">
                    <span style="color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="material-icons-round" style="font-size: 1.1rem; opacity: 0.7;">layers</i>
                        A, An, The, Cross (x) & Solver
                    </span>
                    <a href="{{ route('grammar.articles') }}" style="color: var(--primary-hover); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; font-family: 'Hind Siliguri', sans-serif; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">
                        <span>মডিউলে প্রবেশ করুন</span>
                        <i class="material-icons-round" style="font-size: 1.1rem;">arrow_forward</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-interactive:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        border-color: rgba(99, 102, 241, 0.5) !important;
    }
</style>
@endsection