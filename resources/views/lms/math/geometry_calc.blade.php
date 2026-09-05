@extends('layouts.app')

@section('title', 'জ্যামিতি ও ত্রিকোণমিতি - ১০০টি প্রশ্ন ও Step-by-Step Calculator')

@section('content')
<!-- KaTeX for Professional Math Rendering -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

<div class="geometry-wrapper" style="color: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif;">
    <!-- Page Header -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('math.index') }}" class="btn btn-outline-light btn-sm rounded-xl mb-3" style="text-decoration: none;">
            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">arrow_back</i> অধ্যায় তালিকায় ফিরে যান
        </a>
        <h2 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin: 0 0 8px 0;">
            জ্যামিতি ও ত্রিকোণমিতি (Geometry & Trigonometry) 📐
        </h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            ১০০টি জ্যামিতিক সৃজনশীল প্রশ্ন এবং ডেমোর মতো সম্পূর্ণ Step-by-Step 2D/3D চিত্র সলভার।
        </p>
    </div>

    <!-- Main Module Tabs (Creative vs Interactive Calculator) -->
    <div class="d-flex gap-3 mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
        <button id="tabCreativeBtn" onclick="geoApp.switchMainTab('creative')" class="active-tab-btn" style="padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 1rem; border: none; cursor: pointer; transition: all 0.3s;">
            ✍️ জ্যামিতি সৃজনশীল (১০০টি প্রশ্ন)
        </button>
        <button id="tabCalcBtn" onclick="geoApp.switchMainTab('calc')" class="inactive-tab-btn" style="padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 1rem; border: none; cursor: pointer; transition: all 0.3s;">
            📐 2D/3D জ্যামিতি ক্যালকুলেটর (Full Demo)
        </button>
    </div>

    <!-- TAB 1: CREATIVE QUESTIONS SECTION -->
    <div id="tabCreativeSection">
        <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
            <!-- Main Content Questions List (Left Side) -->
            <div style="flex: 1; min-width: 320px;">
                <div id="questionsContainer"></div>
            </div>

            <!-- Sidebar Question Jumper (Right Side - Fixed Width) -->
            <div style="width: 310px; max-width: 100%; flex-shrink: 0;">
                <div style="position: sticky; top: 90px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.08); padding: 18px; max-height: calc(100vh - 120px); overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 style="color: #fbbf24; font-weight: 800; font-size: 1.05rem; margin: 0; display: flex; align-items: center; gap: 6px;">
                            <i class="material-icons-round" style="font-size: 1.2rem;">category</i>
                            <span>জ্যামিতি নেভিগেশন</span>
                        </h5>
                        <span style="background: rgba(37,99,235,0.2); color: #60a5fa; padding: 2px 10px; border-radius: 10px; font-size: 0.78rem; font-weight: 800;">
                            ১০০টি প্রশ্ন
                        </span>
                    </div>

                    <!-- Nav Mode Toggle Button -->
                    <button id="navModeBtn" onclick="geoApp.toggleNavMode()" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 7px 10px; border-radius: 8px; font-size: 0.78rem; font-weight: 700; cursor: pointer; width: 100%; margin-bottom: 12px;">
                        🔄 নেভিগেশন মোড: প্যাটার্নভিত্তিক
                    </button>

                    <!-- Search Input Box -->
                    <div class="mb-3">
                        <input type="number" id="searchInput" placeholder="প্রশ্ন নম্বর লিখুন (১-১০০)..." oninput="geoApp.renderCreative()" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); background: rgba(30, 41, 59, 0.9); color: #fff; font-size: 0.88rem; outline: none;">
                    </div>

                    <!-- Grouped Categorized Nav Grid -->
                    <div id="navGroupedGrid"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: FULL DEMO 2D/3D GEOMETRY CALCULATOR SECTION -->
    <div id="tabCalcSection" style="display: none;">
        <!-- Demo Sub-Nav Bar -->
        <div style="position: sticky; top: 80px; z-index: 40; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(10px); padding: 12px; border-radius: 14px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1); display: flex; gap: 8px; overflow-x: auto;">
            <button class="geo-sub-tab active" onclick="geoApp.scrollToSec('angles')">📐 কোণ</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('parallel')">📏 সমান্তরাল রেখা</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('triangle')">🔺 ত্রিভুজ</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('quadrilateral')">▱ চতুর্ভুজ</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('circle')">⭕ বৃত্ত</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('polygon')">⬡ বহুভুজ</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('mensuration')">📦 ঘনবস্তু (3D)</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('coordinate')">📍 স্থানাঙ্ক</button>
            <button class="geo-sub-tab" onclick="geoApp.scrollToSec('trig')">📐 ত্রিকোণমিতি</button>
        </div>

        <!-- Section 1: Angles -->
        <div id="angles" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">📐 কোণের সকল গুরুত্বপূর্ণ Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">কোণের ধরন, পূরক-সম্পূরক, বিপ্রতীপ ও সরলকোণ—সবগুলোর ধাপে ধাপে সমাধান ও চিত্র।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">কোণের প্রকার</span>
                    <h4 style="color:#fff;">কোণের প্রকার নির্ণয়</h4>
                    <div class="geo-formula">০° &lt; θ &lt; ৯০° → সূক্ষ্মকোণ · ৯০° → সমকোণ · ৯০° &lt; θ &lt; ১৮০° → স্থূলকোণ</div>
                    <div class="geo-field"><label>কোণ θ (ডিগ্রি)</label><input id="atype" type="number" value="36"></div>
                    <div id="atypeSol" class="geo-sol"></div>
                    <div class="diagram-box" id="atypeDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">পূরক ও সম্পূরক</span>
                    <h4 style="color:#fff;">পূরক ও সম্পূরক কোণ</h4>
                    <div class="geo-formula">পূরক = ৯০° − θ · সম্পূরক = ১৮০° − θ</div>
                    <div class="geo-field"><label>কোণ θ (ডিগ্রি)</label><input id="comp" type="number" value="60"></div>
                    <div id="compSol" class="geo-sol"></div>
                    <div class="diagram-box" id="compDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">বিপ্রতীপ</span>
                    <h4 style="color:#fff;">বিপ্রতীপ ও সন্নিহিত কোণ</h4>
                    <div class="geo-formula">বিপ্রতীপ কোণ = সমান · সন্নিহিত কোণ = ১৮০° − θ</div>
                    <div class="geo-field"><label>কোণ θ (ডিগ্রি)</label><input id="vert" type="number" value="70"></div>
                    <div id="vertSol" class="geo-sol"></div>
                    <div class="diagram-box" id="vertDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">সরলকোণ</span>
                    <h4 style="color:#fff;">Linear Pair / সরলকোণ</h4>
                    <div class="geo-formula">x + θ = ১৮০°</div>
                    <div class="geo-field"><label>কোণ θ (ডিগ্রি)</label><input id="linear" type="number" value="115"></div>
                    <div id="linearSol" class="geo-sol"></div>
                    <div class="diagram-box" id="linearDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 2: Parallel Lines -->
        <div id="parallel" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">📏 সমান্তরাল সরলরেখা ও ছেদক</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">Corresponding, Alternate এবং Co-interior—প্রতিটি সম্পর্কের হিসাব।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Corresponding</span>
                    <h4 style="color:#fff;">অনুরূপ কোণ</h4>
                    <div class="geo-field"><label>কোণ θ</label><input id="corresponding" type="number" value="60"></div>
                    <div id="corSol" class="geo-sol"></div>
                    <div class="diagram-box" id="parallelDia1"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Alternate</span>
                    <h4 style="color:#fff;">একান্তর কোণ</h4>
                    <div class="geo-field"><label>কোণ θ</label><input id="alternate" type="number" value="60"></div>
                    <div id="altSol" class="geo-sol"></div>
                    <div class="diagram-box" id="parallelDia2"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Co-interior</span>
                    <h4 style="color:#fff;">অন্তঃকোণ</h4>
                    <div class="geo-field"><label>কোণ θ</label><input id="coin" type="number" value="60"></div>
                    <div id="coSol" class="geo-sol"></div>
                    <div class="diagram-box" id="parallelDia3"></div>
                </div>
            </div>
        </div>

        <!-- Section 3: Triangle -->
        <div id="triangle" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">🔺 ত্রিভুজের সম্পূর্ণ Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">কোণের সমষ্টি, পিথাগোরাস, ক্ষেত্রফল, পরিসীমা ও Heron-এর সূত্র।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Angle Sum</span>
                    <h4 style="color:#fff;">ত্রিভুজের ৩য় কোণ</h4>
                    <div class="geo-field"><label>কোণ A</label><input id="ta" type="number" value="50"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>কোণ B</label><input id="tb" type="number" value="60"></div>
                    <div id="triAngSol" class="geo-sol"></div>
                    <div class="diagram-box" id="triAngDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Pythagoras</span>
                    <h4 style="color:#fff;">সমকোণী ত্রিভুজ — অতিভুজ</h4>
                    <div class="geo-field"><label>লম্ব a</label><input id="pa" type="number" value="3"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>ভূমি b</label><input id="pb" type="number" value="4"></div>
                    <div id="pySol" class="geo-sol"></div>
                    <div class="diagram-box" id="pyDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Heron</span>
                    <h4 style="color:#fff;">Heron-এর সূত্রে ক্ষেত্রফল</h4>
                    <div class="geo-field"><label>বাহু a</label><input id="ha" type="number" value="5"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>বাহু b</label><input id="hb" type="number" value="6"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>বাহু c</label><input id="hc" type="number" value="7"></div>
                    <div id="heronSol" class="geo-sol"></div>
                    <div class="diagram-box" id="heronDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 4: Quadrilateral -->
        <div id="quadrilateral" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">▱ চতুর্ভুজের সকল Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">আয়ত, বর্গ, সামান্তরিক, রম্বস, ট্রাপিজিয়াম ও ঘুড়ি—ক্ষেত্রফল ও পরিসীমা।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Rectangle</span>
                    <h4 style="color:#fff;">আয়তের ক্ষেত্রফল ও পরিসীমা</h4>
                    <div class="geo-field"><label>দৈর্ঘ্য l</label><input id="rl" type="number" value="12"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>প্রস্থ w</label><input id="rw" type="number" value="5"></div>
                    <div id="rectSol" class="geo-sol"></div>
                    <div class="diagram-box" id="rectDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Square</span>
                    <h4 style="color:#fff;">বর্গের ক্ষেত্রফল ও পরিসীমা</h4>
                    <div class="geo-field"><label>বাহু a</label><input id="sq" type="number" value="7"></div>
                    <div id="sqSol" class="geo-sol"></div>
                    <div class="diagram-box" id="sqDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Rhombus</span>
                    <h4 style="color:#fff;">রম্বস</h4>
                    <div class="geo-field"><label>কর্ণ d₁</label><input id="rd1" type="number" value="10"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>কর্ণ d₂</label><input id="rd2" type="number" value="8"></div>
                    <div id="rhombSol" class="geo-sol"></div>
                    <div class="diagram-box" id="rhombDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 5: Circle -->
        <div id="circle" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">⭕ বৃত্তের সম্পূর্ণ Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">ব্যাসার্ধ, ব্যাস, চাপের দৈর্ঘ্য ও বৃত্তাংশ।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Circle</span>
                    <h4 style="color:#fff;">ব্যাসার্ধ থেকে পরিধি ও ক্ষেত্রফল</h4>
                    <div class="geo-field"><label>ব্যাসার্ধ r</label><input id="cr" type="number" value="7"></div>
                    <div id="circleSol" class="geo-sol"></div>
                    <div class="diagram-box" id="circleDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Diameter</span>
                    <h4 style="color:#fff;">ব্যাস দেওয়া থাকলে</h4>
                    <div class="geo-field"><label>ব্যাস d</label><input id="cd" type="number" value="14"></div>
                    <div id="diamSol" class="geo-sol"></div>
                    <div class="diagram-box" id="diamDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 6: Polygon -->
        <div id="polygon" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">⬡ বহুভুজের Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">অন্তঃকোণের সমষ্টি ও সুষম বহুভুজের কোণ।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Interior Angles</span>
                    <h4 style="color:#fff;">অন্তঃকোণের সমষ্টি</h4>
                    <div class="geo-field"><label>বাহুর সংখ্যা n</label><input id="pn" type="number" value="6"></div>
                    <div id="polySol" class="geo-sol"></div>
                    <div class="diagram-box" id="polyDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 7: Mensuration (3D Geometry) -->
        <div id="mensuration" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">📦 3D ঘনবস্তু / Mensuration</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">সিলিন্ডার, গোলক, ঘনক ও শঙ্কু।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Cylinder</span>
                    <h4 style="color:#fff;">সিলিন্ডারের আয়তন</h4>
                    <div class="geo-field"><label>ব্যাসার্ধ r</label><input id="cyr" type="number" value="7"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>উচ্চতা h</label><input id="cyh" type="number" value="10"></div>
                    <div id="cylSol" class="geo-sol"></div>
                    <div class="diagram-box" id="cylDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Sphere</span>
                    <h4 style="color:#fff;">গোলকের আয়তন ও পৃষ্ঠতল</h4>
                    <div class="geo-field"><label>ব্যাসার্ধ r</label><input id="spr" type="number" value="7"></div>
                    <div id="sphereSol" class="geo-sol"></div>
                    <div class="diagram-box" id="sphereDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 8: Coordinate Geometry -->
        <div id="coordinate" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">📍 স্থানাঙ্ক জ্যামিতি</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">Distance</span>
                    <h4 style="color:#fff;">দুই বিন্দুর দূরত্ব</h4>
                    <div class="geo-field"><label>x₁, y₁</label><input id="x1" type="number" value="1" style="width:48%; display:inline;"> <input id="y1" type="number" value="2" style="width:48%; display:inline;"></div>
                    <div class="geo-field" style="margin-top:6px;"><label>x₂, y₂</label><input id="x2" type="number" value="4" style="width:48%; display:inline;"> <input id="y2" type="number" value="6" style="width:48%; display:inline;"></div>
                    <div id="distSol" class="geo-sol"></div>
                    <div class="diagram-box" id="distDia"></div>
                </div>
            </div>
        </div>

        <!-- Section 9: Trigonometry -->
        <div id="trig" class="demo-geo-sec" style="margin-bottom: 40px;">
            <h3 style="color:#60a5fa; font-weight:800; margin-bottom:6px;">📐 ত্রিকোণমিতির সম্পূর্ণ Step-by-Step Calculator</h3>
            <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:16px;">sin, cos, tan অনুপাত ও অভেদ।</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                <div class="geo-card">
                    <span class="geo-tag">sin / cos / tan</span>
                    <h4 style="color:#fff;">ত্রিকোণমিতিক অনুপাত</h4>
                    <div class="geo-field"><label>কোণ θ (ডিগ্রি)</label><input id="tangle" type="number" value="30"></div>
                    <div id="trigSol" class="geo-sol"></div>
                    <div class="diagram-box" id="trigDia"></div>
                </div>
                <div class="geo-card">
                    <span class="geo-tag">Identity</span>
                    <h4 style="color:#fff;">ত্রিকোণমিতিক মৌলিক অভেদ</h4>
                    <div class="geo-field"><label>কোণ θ</label><input id="idangle" type="number" value="30"></div>
                    <div id="idSol" class="geo-sol"></div>
                    <div class="diagram-box" id="idDia"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.active-tab-btn {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4) !important;
}
.inactive-tab-btn {
    background: rgba(30, 41, 59, 0.7) !important;
    color: #94a3b8 !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}

.geo-sub-tab {
    background: rgba(30, 41, 59, 0.7);
    border: 1px solid rgba(255,255,255,0.1);
    color: #cbd5e1;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
}
.geo-sub-tab:hover,
.geo-sub-tab.active {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
}

.geo-card {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 20px;
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.geo-tag {
    background: rgba(37, 99, 235, 0.2);
    color: #60a5fa;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 800;
    display: inline-block;
    margin-bottom: 8px;
}

.geo-formula {
    background: rgba(30, 41, 59, 0.8);
    border-radius: 8px;
    padding: 8px 12px;
    color: #fbbf24;
    font-weight: 700;
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.geo-field label {
    font-size: 11px;
    color: #cbd5e1;
    font-weight: 700;
    display: block;
    margin-bottom: 3px;
}

.geo-field input {
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(30, 41, 59, 0.9);
    color: #60a5fa;
    font-weight: 700;
    outline: none;
}

.geo-sol {
    margin-top: 14px;
    padding: 14px;
    background: rgba(5, 150, 105, 0.12);
    border-left: 4px solid #059669;
    border-radius: 8px;
    color: #34d399;
    font-weight: 600;
    font-size: 0.95rem;
}

.diagram-box {
    margin-top: 14px;
    background: rgba(30, 41, 59, 0.4);
    border: 1px dashed rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 140px;
}
.diagram-box svg {
    max-width: 100%;
    height: 140px;
}

.geometry-wrapper .q-card {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 20px;
    padding: 26px;
    margin-bottom: 26px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-top: 5px solid #2563eb;
}

.geometry-wrapper .q-badge {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-weight: 800;
    margin-bottom: 15px;
    display: inline-block;
}

.geometry-wrapper .edit-panel {
    background: rgba(30, 41, 59, 0.6);
    border: 1px dashed rgba(245, 158, 11, 0.4);
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 20px;
}

.geometry-wrapper .grid-inputs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
}

.geometry-wrapper .input-group {
    display: flex;
    flex-direction: column;
}

.geometry-wrapper .input-group label {
    font-size: 11px;
    color: #cbd5e1;
    font-weight: 700;
    margin-bottom: 3px;
}

.geometry-wrapper .input-group input {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(15, 23, 42, 0.9);
    color: #60a5fa;
    font-weight: 700;
    outline: none;
}

.geometry-wrapper .stimulus-box {
    background: rgba(30, 58, 138, 0.2);
    padding: 20px;
    border-left: 5px solid #3b82f6;
    border-radius: 0 12px 12px 0;
    margin: 20px 0;
    font-size: 1.05rem;
    line-height: 1.7;
    color: #f1f5f9;
}

.geometry-wrapper .sub-q-list {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.geometry-wrapper .sub-q-list li {
    margin-bottom: 12px;
    font-weight: 600;
    color: #e2e8f0;
    font-size: 1.02rem;
}

.geometry-wrapper .btn-solution {
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
}

.geometry-wrapper .btn-solution.active {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.geometry-wrapper .solution-box {
    display: none;
    margin-top: 20px;
    padding: 22px;
    background: rgba(15, 23, 42, 0.9);
    border: 1.5px solid #059669;
    border-radius: 14px;
}

.geometry-wrapper .solution-box.active {
    display: block;
}

.geometry-wrapper .step-item {
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding-bottom: 14px;
}

.geometry-wrapper .step-title {
    color: #34d399;
    font-weight: 700;
    font-size: 1.05rem;
    display: block;
    margin-bottom: 8px;
}

.geometry-wrapper .sidebar-group-title {
    color: #fbbf24;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    margin: 16px 0 8px 0;
    padding-bottom: 4px;
    border-bottom: 1px solid rgba(245, 158, 11, 0.2);
}

.geometry-wrapper .nav-btn-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 5px;
}

.geometry-wrapper .nav-btn {
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

.geometry-wrapper .nav-btn:hover,
.geometry-wrapper .nav-btn.active {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
}
</style>

<script>
const dbExercises = @json($customExercises ?? []);
const n = id => Number(document.getElementById(id)?.value || 0);
const f = x => Number.isFinite(x) ? (Math.abs(x - Math.round(x)) < 1e-10 ? String(Math.round(x)) : x.toFixed(2)) : '—';
const pi = Math.PI;

function escSvg(v){return String(v??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}

function svgEngine(kind, labels=[]){
  const blue='#3b82f6', orange='#fbbf24', purple='#818cf8', green='#34d399', line='rgba(255,255,255,0.2)', dark='#f8fafc';
  const text=(x,y,t,c=dark,sz=12)=>`<text x="${x}" y="${y}" fill="${c}" font-size="${sz}" font-weight="800">${escSvg(t)}</text>`;
  const base=`<svg viewBox="0 0 520 180">`;
  const end='</svg>';

  if(kind==='angle'){
    const deg=Math.max(0,Math.min(360,Number(labels[0])||0)), rad=deg*Math.PI/180;
    const cx=125,cy=140,L=100,ex=cx+L*Math.cos(rad),ey=cy-L*Math.sin(rad);
    const large=deg>180?1:0;
    const a1x=cx+35,a1y=cy, a2x=cx+35*Math.cos(rad),a2y=cy-35*Math.sin(rad);
    const arc=deg===0?'':`<path d="M ${a1x} ${a1y} A 35 35 0 ${large} 0 ${a2x} ${a2y}" fill="none" stroke="${orange}" stroke-width="3"/>`;
    return base+`<line x1="${cx}" y1="${cy}" x2="400" y2="${cy}" stroke="${line}" stroke-width="3"/><line x1="${cx}" y1="${cy}" x2="${ex}" y2="${ey}" stroke="${blue}" stroke-width="4"/><circle cx="${cx}" cy="${cy}" r="5" fill="${orange}"/>${arc}${text(cx+45,cy-15,deg+'°',orange,14)}${text(320,35,'θ = '+deg+'°',blue,14)}${end}`;
  }
  if(kind==='parallel'){
    const a=Number(labels[0])||60,b=Number(labels[1])||60;
    return base+`<line x1="70" y1="50" x2="450" y2="50" stroke="${line}" stroke-width="3"/><line x1="70" y1="130" x2="450" y2="130" stroke="${line}" stroke-width="3"/><line x1="190" y1="15" x2="330" y2="165" stroke="${purple}" stroke-width="3"/>${text(260,75,a+'°',blue)}${text(325,115,b+'°',orange)}${end}`;
  }
  if(kind==='tri'){
    return base+`<polygon points="95,145 425,145 270,25" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/><line x1="270" y1="25" x2="270" y2="145" stroke="${orange}" stroke-width="2" stroke-dasharray="6 5"/>${text(250,20,'A',orange)}${text(75,160,'B',orange)}${text(430,160,'C',orange)}${end}`;
  }
  if(kind==='rect'){
    const l=labels[0]||10,w=labels[1]||5;
    return base+`<rect x="125" y="40" width="270" height="100" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/>${text(240,30,'l = '+l,orange)}${text(405,95,'w = '+w,green)}${end}`;
  }
  if(kind==='square'){
    const a=labels[0]||7; return base+`<rect x="185" y="30" width="110" height="110" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/>${text(225,20,'a = '+a,orange)}${end}`;
  }
  if(kind==='circle'){
    const r=labels[0]||7; return base+`<circle cx="250" cy="90" r="60" fill="rgba(5,150,105,0.15)" stroke="${green}" stroke-width="3"/><line x1="250" y1="90" x2="310" y2="90" stroke="${orange}" stroke-width="3"/><circle cx="250" cy="90" r="4" fill="${orange}"/>${text(270,82,'r = '+r,orange)}${end}`;
  }
  if(kind==='polygon'){
    const nside=Math.max(3,Math.min(12,Math.round(Number(labels[0])||6))),cx=250,cy=90,r=60;
    let pts=[]; for(let i=0;i<nside;i++){let a=-Math.PI/2+i*2*Math.PI/nside;pts.push(`${cx+r*Math.cos(a)},${cy+r*Math.sin(a)}`)}
    return base+`<polygon points="${pts.join(' ')}" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/>${text(340,55,'n = '+nside,orange)}${end}`;
  }
  if(kind==='cylinder'){
    const r=labels[0]||7, h=labels[1]||10;
    return base+`<ellipse cx="250" cy="40" rx="70" ry="18" fill="rgba(37,99,235,0.25)" stroke="${blue}" stroke-width="3"/><line x1="180" y1="40" x2="180" y2="130" stroke="${blue}" stroke-width="3"/><line x1="320" y1="40" x2="320" y2="130" stroke="${blue}" stroke-width="3"/><ellipse cx="250" cy="130" rx="70" ry="18" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/><line x1="250" y1="40" x2="320" y2="40" stroke="${orange}" stroke-width="3"/>${text(275,35,'r = '+r,orange)}${text(330,90,'h = '+h,green)}${end}`;
  }
  if(kind==='sphere'){
    const r=labels[0]||7;
    return base+`<circle cx="250" cy="90" r="60" fill="rgba(245,158,11,0.2)" stroke="${orange}" stroke-width="3"/><ellipse cx="250" cy="90" rx="60" ry="20" fill="none" stroke="rgba(245,158,11,0.5)" stroke-width="2" stroke-dasharray="4"/><line x1="250" y1="90" x2="310" y2="90" stroke="${green}" stroke-width="3"/>${text(270,83,'r = '+r,green)}${end}`;
  }
  if(kind==='coordinate'){
    return base+`<line x1="60" y1="130" x2="450" y2="130" stroke="${line}" stroke-width="2"/><line x1="190" y1="160" x2="190" y2="20" stroke="${line}" stroke-width="2"/><line x1="210" y1="110" x2="350" y2="40" stroke="${purple}" stroke-width="4"/><circle cx="210" cy="110" r="5" fill="${blue}"/><circle cx="350" cy="40" r="5" fill="${orange}"/>${text(215,125,'A',blue)}${text(355,50,'B',orange)}${end}`;
  }
  if(kind==='trig'){
    return base+`<polygon points="120,150 380,150 380,40" fill="rgba(37,99,235,0.15)" stroke="${blue}" stroke-width="3"/><text x="140" y="140" fill="${orange}" font-size="14" font-weight="800">θ</text>${text(230,165,'ভূমি',green)}${text(390,95,'লম্ব',orange)}${end}`;
  }
  return base+end;
}

const geoApp = {
    questions: [],
    navMode: 'pattern',

    init() {
        if (dbExercises && dbExercises.length > 0) {
            this.loadFromDb();
        } else {
            this.generate100Questions();
        }
        this.renderNav();
        this.renderCreative();
        this.runAllCalc();
        this.bindEvents();
    },

    switchMainTab(tab) {
        const cBtn = document.getElementById('tabCreativeBtn');
        const calcBtn = document.getElementById('tabCalcBtn');
        const cSec = document.getElementById('tabCreativeSection');
        const calcSec = document.getElementById('tabCalcSection');

        if (tab === 'creative') {
            cBtn.className = 'active-tab-btn';
            calcBtn.className = 'inactive-tab-btn';
            cSec.style.display = 'block';
            calcSec.style.display = 'none';
        } else {
            cBtn.className = 'inactive-tab-btn';
            calcBtn.className = 'active-tab-btn';
            cSec.style.display = 'none';
            calcSec.style.display = 'block';
            this.runAllCalc();
        }
    },

    scrollToSec(secId) {
        const el = document.getElementById(secId);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
        this.questions = [];
        dbExercises.forEach((ex, idx) => {
            let opts = ex.options;
            if (typeof opts === 'string') {
                try { opts = JSON.parse(opts); } catch(e) { opts = {}; }
            }
            if (!opts || typeof opts !== 'object') opts = {};

            const pattern = opts.p || 'P1';
            let q = {
                id: ex.id,
                title: ex.title,
                pattern: pattern,
                angle: opts.angle !== undefined ? opts.angle : (30 + (idx * 3) % 120),
                sideA: opts.sideA !== undefined ? opts.sideA : (3 + (idx % 5)),
                sideB: opts.sideB !== undefined ? opts.sideB : (4 + (idx % 4)),
                length: opts.length !== undefined ? opts.length : (8 + (idx % 6)),
                width: opts.width !== undefined ? opts.width : (5 + (idx % 4)),
                radius: opts.radius !== undefined ? opts.radius : (7 + (idx % 7)),
                r: opts.r !== undefined ? opts.r : (5 + (idx % 5)),
                h: opts.h !== undefined ? opts.h : (10 + (idx % 8)),
                show: false
            };
            this.questions.push(q);
        });
    },

    generate100Questions() {
        this.questions = [];
        for (let i = 1; i <= 100; i++) {
            const mod = (i - 1) % 5;
            let p = 'P' + (mod + 1);

            this.questions.push({
                id: i,
                title: `জ্যামিতি সৃজনশীল প্রশ্ন নং: ${i}`,
                pattern: p,
                angle: 30 + (i * 3) % 120,
                sideA: 3 + (i % 5),
                sideB: 4 + (i % 4),
                length: 8 + (i % 6),
                width: 5 + (i % 4),
                radius: 7 + (i % 7),
                r: 5 + (i % 5),
                h: 10 + (i % 8),
                show: false
            });
        }
    },

    renderNav() {
        const container = document.getElementById('navGroupedGrid');
        container.innerHTML = '';

        if (this.navMode === 'serial') {
            const total = this.questions.length;
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
                        this.renderCreative(); 
                        window.scrollTo({ top: 120, behavior: 'smooth' }); 
                    };
                    gridEl.appendChild(b);
                }
                container.appendChild(gridEl);
            }
        } else {
            const groups = [
                { key: 'P1', title: 'প্যাটার্ন ১: কোণ, পূরক ও সম্পূরক' },
                { key: 'P2', title: 'প্যাটার্ন ২: ত্রিভুজ ও পিথাগোরাস' },
                { key: 'P3', title: 'প্যাটার্ন ৩: চতুর্ভুজ ও ট্রাপিজিয়াম' },
                { key: 'P4', title: 'প্যাটার্ন ৪: বৃত্ত, স্পর্শক ও বৃত্তচাপ' },
                { key: 'P5', title: 'প্যাটার্ন ৫: ঘনবস্তু ও 3D পরিমিতি' },
            ];

            groups.forEach((g, gIdx) => {
                const qList = this.questions.filter((q, idx) => (q.pattern === g.key) || (!q.pattern && (idx % 5 === gIdx)));
                if (qList.length > 0) {
                    const titleEl = document.createElement('div');
                    titleEl.className = 'sidebar-group-title';
                    titleEl.innerText = `${g.title} (${qList.length}টি)`;
                    container.appendChild(titleEl);

                    const gridEl = document.createElement('div');
                    gridEl.className = 'nav-btn-grid';

                    qList.forEach(q => {
                        const qNo = this.questions.indexOf(q) + 1;
                        const b = document.createElement('button');
                        b.className = 'nav-btn';
                        b.innerText = qNo;
                        b.onclick = () => { 
                            document.getElementById('searchInput').value = qNo; 
                            this.renderCreative(); 
                            window.scrollTo({ top: 120, behavior: 'smooth' }); 
                        };
                        gridEl.appendChild(b);
                    });

                    container.appendChild(gridEl);
                }
            });
        }
    },

    updateParam(id, key, val) {
        const q = this.questions.find(item => item.id === id);
        if (q) {
            q[key] = parseFloat(val) || 0;
            this.renderCreative();
        }
    },

    toggleSolution(id) {
        const q = this.questions.find(item => item.id === id);
        if (q) {
            q.show = !q.show;
            this.renderCreative();
        }
    },

    renderCreative() {
        const container = document.getElementById('questionsContainer');
        const search = document.getElementById('searchInput').value;
        container.innerHTML = '';

        this.questions.forEach((q, idx) => {
            const qNo = idx + 1;
            if (search && qNo != search && q.id != search) return;

            const card = document.createElement('div');
            card.className = 'q-card';

            let stim = '', subQ = '', sol = '', editInputs = '';

            if (q.pattern === 'P1') {
                editInputs = `<div class="input-group"><label>কোণ θ (°):</label><input type="number" value="${q.angle}" oninput="geoApp.updateParam(${q.id}, 'angle', this.value)"></div>`;
                stim = `একটি কোণের মান $\\theta = ${q.angle}^\\circ$।`;
                subQ = `
                    <li>ক) $\\theta$ কোণটির পূরক কোণ নির্ণয় করো।</li>
                    <li>খ) $\\theta$ কোণটির সম্পূরক কোণ নির্ণয় করো।</li>
                    <li>গ) কোণটি সূক্ষ্মকোণ, সমকোণ না স্থূলকোণ তা নির্দেশ করো।</li>
                `;
                const comp = 90 - q.angle;
                const supp = 180 - q.angle;
                const typeName = q.angle < 90 ? 'সূক্ষ্মকোণ' : (q.angle === 90 ? 'সমকোণ' : 'স্থূলকোণ');
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> পূরক কোণ $= 90^\\circ - ${q.angle}^\\circ = ${comp}^\\circ$</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> সম্পূরক কোণ $= 180^\\circ - ${q.angle}^\\circ = ${supp}^\\circ$</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> যেহেতু $\\theta = ${q.angle}^\\circ$, তাই এটি একটি <strong>${typeName}</strong>।</div>
                `;
            } else if (q.pattern === 'P2') {
                editInputs = `
                    <div class="input-group"><label>লম্ব a:</label><input type="number" value="${q.sideA}" oninput="geoApp.updateParam(${q.id}, 'sideA', this.value)"></div>
                    <div class="input-group"><label>ভূমি b:</label><input type="number" value="${q.sideB}" oninput="geoApp.updateParam(${q.id}, 'sideB', this.value)"></div>
                `;
                stim = `একটি সমকোণী ত্রিভুজের লম্ব $a = ${q.sideA}$ সেমি এবং ভূমি $b = ${q.sideB}$ সেমি।`;
                subQ = `
                    <li>ক) ত্রিভুজটির ক্ষেত্রফল নির্ণয় করো।</li>
                    <li>খ) পিথাগোরাসের উপপাদ্য ব্যবহার করে অতিভুজ $c$ নির্ণয় করো।</li>
                    <li>গ) অতিভুজের ওপর অঙ্কিত বর্গের ক্ষেত্রফল কত?</li>
                `;
                const area = 0.5 * q.sideA * q.sideB;
                const hyp = Math.sqrt(q.sideA*q.sideA + q.sideB*q.sideB).toFixed(2);
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> ক্ষেত্রফল $= \\frac{1}{2} \\times a \\times b = \\frac{1}{2} \\times ${q.sideA} \\times ${q.sideB} = ${area}$ বর্গ সেমি।</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> অতিভুজ $c = \\sqrt{a^2 + b^2} = \\sqrt{${q.sideA}^2 + ${q.sideB}^2} = ${hyp}$ সেমি।</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> বর্গের ক্ষেত্রফল $= c^2 = ${q.sideA*q.sideA + q.sideB*q.sideB}$ বর্গ সেমি।</div>
                `;
            } else if (q.pattern === 'P3') {
                editInputs = `
                    <div class="input-group"><label>দৈর্ঘ্য l:</label><input type="number" value="${q.length}" oninput="geoApp.updateParam(${q.id}, 'length', this.value)"></div>
                    <div class="input-group"><label>প্রস্থ w:</label><input type="number" value="${q.width}" oninput="geoApp.updateParam(${q.id}, 'width', this.value)"></div>
                `;
                stim = `একটি আয়তক্ষেত্রের দৈর্ঘ্য $l = ${q.length}$ মিটার এবং প্রস্থ $w = ${q.width}$ মিটার।`;
                subQ = `
                    <li>ক) আয়তক্ষেত্রটির পরিসীমা কত?</li>
                    <li>খ) ক্ষেত্রটির ক্ষেত্রফল নির্ণয় করো।</li>
                    <li>গ) কর্ণের দৈর্ঘ্য নির্ণয় করো।</li>
                `;
                const peri = 2 * (q.length + q.width);
                const area = q.length * q.width;
                const diag = Math.sqrt(q.length*q.length + q.width*q.width).toFixed(2);
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> পরিসীমা $= 2(l + w) = 2(${q.length} + ${q.width}) = ${peri}$ মিটার।</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> ক্ষেত্রফল $= l \\times w = ${q.length} \\times ${q.width} = ${area}$ বর্গ মিটার।</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> কর্ণ $= \\sqrt{l^2 + w^2} = \\sqrt{${q.length}^2 + ${q.width}^2} = ${diag}$ মিটার।</div>
                `;
            } else if (q.pattern === 'P4') {
                editInputs = `<div class="input-group"><label>ব্যাসার্ধ r:</label><input type="number" value="${q.radius}" oninput="geoApp.updateParam(${q.id}, 'radius', this.value)"></div>`;
                stim = `একটি বৃত্তের ব্যাসার্ধ $r = ${q.radius}$ সেমি।`;
                subQ = `
                    <li>ক) বৃত্তটির ব্যাস কত?</li>
                    <li>খ) বৃত্তের পরিধি নির্ণয় করো।</li>
                    <li>গ) বৃত্তটির ক্ষেত্রফল নির্ণয় করো।</li>
                `;
                const dia = 2 * q.radius;
                const peri = (2 * Math.PI * q.radius).toFixed(2);
                const area = (Math.PI * q.radius * q.radius).toFixed(2);
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> ব্যাস $= 2r = 2 \\times ${q.radius} = ${dia}$ সেমি।</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> পরিধি $= 2\\pi r = 2 \\times 3.1416 \\times ${q.radius} = ${peri}$ সেমি।</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> ক্ষেত্রফল $= \\pi r^2 = 3.1416 \\times ${q.radius}^2 = ${area}$ বর্গ সেমি।</div>
                `;
            } else {
                editInputs = `
                    <div class="input-group"><label>ব্যাসার্ধ r:</label><input type="number" value="${q.r}" oninput="geoApp.updateParam(${q.id}, 'r', this.value)"></div>
                    <div class="input-group"><label>উচ্চতা h:</label><input type="number" value="${q.h}" oninput="geoApp.updateParam(${q.id}, 'h', this.value)"></div>
                `;
                stim = `একটি সিলিন্ডারের ভূমির ব্যাসার্ধ $r = ${q.r}$ সেমি এবং উচ্চতা $h = ${q.h}$ সেমি।`;
                subQ = `
                    <li>ক) সিলিন্ডারের ভূমির ক্ষেত্রফল কত?</li>
                    <li>খ) সিলিন্ডারের আয়তন (Volume) নির্ণয় করো।</li>
                    <li>গ) সমগ্র তলের ক্ষেত্রফল নির্ণয় করো।</li>
                `;
                const baseArea = (Math.PI * q.r * q.r).toFixed(2);
                const vol = (Math.PI * q.r * q.r * q.h).toFixed(2);
                const totalArea = (2 * Math.PI * q.r * (q.r + q.h)).toFixed(2);
                sol = `
                    <div class="step-item"><span class="step-title">ক এর সমাধান:</span> ভূমির ক্ষেত্রফল $= \\pi r^2 = 3.1416 \\times ${q.r}^2 = ${baseArea}$ বর্গ সেমি।</div>
                    <div class="step-item"><span class="step-title">খ এর সমাধান:</span> আয়তন $V = \\pi r^2 h = 3.1416 \\times ${q.r}^2 \\times ${q.h} = ${vol}$ ঘন সেমি।</div>
                    <div class="step-item"><span class="step-title">গ এর সমাধান:</span> সমগ্র তলের ক্ষেত্রফল $= 2\\pi r(r + h) = 2 \\times 3.1416 \\times ${q.r}(${q.r} + ${q.h}) = ${totalArea}$ বর্গ সেমি।</div>
                `;
            }

            card.innerHTML = `
                <div class="q-badge">${q.title}</div>
                <div class="edit-panel">
                    <strong style="color: #fbbf24; font-size: 0.9rem; margin-bottom: 8px; display: block;">পরামিতি পরিবর্তন (লাইভ প্র্যাকটিস):</strong>
                    <div class="grid-inputs">${editInputs}</div>
                </div>
                <div class="stimulus-box"><strong>উদ্দীপক:</strong><br>${stim}</div>
                <ul class="sub-q-list">${subQ}</ul>
                <button class="btn-solution ${q.show ? 'active' : ''}" onclick="geoApp.toggleSolution(${q.id})">${q.show ? 'সমাধান বন্ধ করুন' : 'সম্পূর্ণ সমাধান (ক, খ, গ) দেখুন'}</button>
                <div class="solution-box ${q.show ? 'active' : ''}">${sol}</div>
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

    // ---------------- Full Calculator Engine Methods ----------------
    bindEvents() {
        const inputs = ['atype','comp','vert','linear','corresponding','alternate','coin','ta','tb','pa','pb','ha','hb','hc','rl','rw','sq','rd1','rd2','cr','cd','pn','cyr','cyh','spr','x1','y1','x2','y2','tangle','idangle'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', () => this.runAllCalc());
        });
    },

    putHtml(id, html) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    },

    runAllCalc() {
        // Angles
        let x = n('atype');
        let type = x>0&&x<90?'সূক্ষ্মকোণ (Acute Angle)':x===90?'সমকোণ (Right Angle)':x>90&&x<180?'স্থূলকোণ (Obtuse Angle)':x===180?'সরলকোণ (Straight Angle)':'কোণটি ০°–১৮০° এর মধ্যে দিন';
        this.putHtml('atypeSol', `<b>ফলাফল:</b> ${f(x)}° হলো একটি <strong>${type}</strong>।`);
        this.putHtml('atypeDia', svgEngine('angle', [f(x)]));

        let compVal = n('comp');
        this.putHtml('compSol', `<b>পূরক কোণ (90° - θ):</b> ${f(90-compVal)}° <br> <b>সম্পূরক কোণ (180° - θ):</b> ${f(180-compVal)}°`);
        this.putHtml('compDia', svgEngine('parallel', [f(compVal), f(180-compVal)]));

        let vertVal = n('vert');
        this.putHtml('vertSol', `<b>বিপ্রতীপ কোণ:</b> ${f(vertVal)}° <br> <b>সন্নিহিত কোণ:</b> ${f(180-vertVal)}°`);
        this.putHtml('vertDia', svgEngine('parallel', [f(vertVal), f(180-vertVal)]));

        let linVal = n('linear');
        this.putHtml('linearSol', `<b>x = 180° - ${f(linVal)}° =</b> ${f(180-linVal)}°`);
        this.putHtml('linearDia', svgEngine('angle', [f(linVal)]));

        // Parallel Lines
        let corVal = n('corresponding');
        this.putHtml('corSol', `<b>অনুরূপ কোণ (Corresponding):</b> ${f(corVal)}°`);
        this.putHtml('parallelDia1', svgEngine('parallel', [f(corVal), f(corVal)]));

        let altVal = n('alternate');
        this.putHtml('altSol', `<b>একান্তর কোণ (Alternate):</b> ${f(altVal)}°`);
        this.putHtml('parallelDia2', svgEngine('parallel', [f(altVal), f(altVal)]));

        let coinVal = n('coin');
        this.putHtml('coSol', `<b>অন্তঃকোণ:</b> 180° - ${f(coinVal)}° = ${f(180-coinVal)}°`);
        this.putHtml('parallelDia3', svgEngine('parallel', [f(coinVal), f(180-coinVal)]));

        // Triangle
        let ta = n('ta'), tb = n('tb'), tc = 180 - ta - tb;
        this.putHtml('triAngSol', `<b>৩য় কোণ C:</b> 180° - ${f(ta)}° - ${f(tb)}° = <strong>${f(tc)}°</strong>`);
        this.putHtml('triAngDia', svgEngine('tri'));

        let pa = n('pa'), pb = n('pb'), pc = Math.sqrt(pa*pa + pb*pb);
        this.putHtml('pySol', `<b>c = √(a² + b²) = √(${f(pa)}² + ${f(pb)}²) =</b> <strong>${f(pc)}</strong>`);
        this.putHtml('pyDia', svgEngine('tri'));

        let ha = n('ha'), hb = n('hb'), hc = n('hc'), s = (ha+hb+hc)/2, hA = Math.sqrt(Math.max(0, s*(s-ha)*(s-hb)*(s-hc)));
        this.putHtml('heronSol', `<b>অর্ধ-পরিসীমা s:</b> ${f(s)} <br> <b>ক্ষেত্রফল:</b> <strong>${f(hA)}</strong>`);
        this.putHtml('heronDia', svgEngine('tri'));

        // Quadrilateral
        let rl = n('rl'), rw = n('rw');
        this.putHtml('rectSol', `<b>ক্ষেত্রফল:</b> ${f(rl*rw)} <br> <b>পরিসীমা:</b> ${f(2*(rl+rw))}`);
        this.putHtml('rectDia', svgEngine('rect', [f(rl), f(rw)]));

        let sqA = n('sq');
        this.putHtml('sqSol', `<b>ক্ষেত্রফল:</b> ${f(sqA*sqA)} <br> <b>পরিসীমা:</b> ${f(4*sqA)}`);
        this.putHtml('sqDia', svgEngine('square', [f(sqA)]));

        let rd1 = n('rd1'), rd2 = n('rd2');
        this.putHtml('rhombSol', `<b>রম্বসের ক্ষেত্রফল (½d₁d₂):</b> ${f(0.5*rd1*rd2)}`);
        this.putHtml('rhombDia', svgEngine('square', [f(rd1)]));

        // Circle
        let cr = n('cr');
        this.putHtml('circleSol', `<b>পরিধি (2πr):</b> ${f(2*pi*cr)} <br> <b>ক্ষেত্রফল (πr²):</b> ${f(pi*cr*cr)}`);
        this.putHtml('circleDia', svgEngine('circle', [f(cr)]));

        let cd = n('cd'), cr2 = cd / 2;
        this.putHtml('diamSol', `<b>ব্যাসার্ধ r:</b> ${f(cr2)} <br> <b>পরিধি (πd):</b> ${f(pi*cd)} <br> <b>ক্ষেত্রফল (πr²):</b> ${f(pi*cr2*cr2)}`);
        this.putHtml('diamDia', svgEngine('circle', [f(cr2)]));

        // Polygon
        let pn = n('pn'), polySum = (pn - 2) * 180;
        this.putHtml('polySol', `<b>অন্তঃকোণের সমষ্টি S = (n-2)×180°:</b> <strong>${f(polySum)}°</strong>`);
        this.putHtml('polyDia', svgEngine('polygon', [f(pn)]));

        // Mensuration
        let cyr = n('cyr'), cyh = n('cyh');
        this.putHtml('cylSol', `<b>আয়তন (Volume):</b> ${f(pi*cyr*cyr*cyh)} ঘন একক`);
        this.putHtml('cylDia', svgEngine('cylinder', [f(cyr), f(cyh)]));

        let spr = n('spr');
        this.putHtml('sphereSol', `<b>3D আয়তন:</b> ${f((4/3)*pi*Math.pow(spr,3))} ঘন একক`);
        this.putHtml('sphereDia', svgEngine('sphere', [f(spr)]));

        // Coordinate Geometry
        let x1 = n('x1'), y1 = n('y1'), x2 = n('x2'), y2 = n('y2');
        let dist = Math.hypot(x2 - x1, y2 - y1);
        this.putHtml('distSol', `<b>দূরত্ব d = √[(x₂-x₁)² + (y₂-y1)²]:</b> <strong>${f(dist)}</strong>`);
        this.putHtml('distDia', svgEngine('coordinate'));

        // Trigonometry
        let tangle = n('tangle'), rad = tangle * pi / 180;
        let sinVal = Math.sin(rad), cosVal = Math.cos(rad), tanVal = Math.tan(rad);
        this.putHtml('trigSol', `<b>sin(${tangle}°):</b> ${f(sinVal)} <br> <b>cos(${tangle}°):</b> ${f(cosVal)} <br> <b>tan(${tangle}°):</b> ${f(tanVal)}`);
        this.putHtml('trigDia', svgEngine('trig'));

        let idangle = n('idangle');
        this.putHtml('idSol', `<b>sin²(${idangle}°) + cos²(${idangle}°):</b> <strong>1.00</strong> ✓`);
        this.putHtml('idDia', svgEngine('trig'));
    }
};

document.addEventListener('DOMContentLoaded', () => geoApp.init());
</script>
@endsection
