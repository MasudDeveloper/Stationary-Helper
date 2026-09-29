{{-- 30 Accounting Formulas Reference Component --}}
<div class="accounting-formulas-container p-4 rounded-3" style="font-family: 'Hind Siliguri', 'Outfit', sans-serif; background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(59, 130, 246, 0.3); color: #e2e8f0;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 border-bottom border-slate-700 pb-3">
        <div>
            <h3 class="text-warning fw-bold m-0" style="font-size: 1.6rem;">
                <i class="material-icons-round align-middle me-2">functions</i> হিসাব বিজ্ঞানের ৩০টি আবশ্যকীয় সূত্র (30 Essential Accounting Formulas)
            </h3>
            <p class="text-slate-400 text-sm m-0">পরীক্ষা ও বাস্তব হিসাববিজ্ঞান সমাধানের সকল গাণিতিক সূত্রাবলী</p>
        </div>
        <div class="w-auto">
            <input type="text" id="formulaSearchInput" onkeyup="filterFormulas()" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="সূত্র খুঁজুন (যেমন: মূলধন, বাট্টা, ক্রয়)..." style="width: 250px;">
        </div>
    </div>

    <div class="row g-3" id="formulasGrid">

        <!-- Formula 1 -->
        <div class="col-md-6 formula-card" data-keywords="মালিকানাস্বত্ব স্বত্বাধিকার বিনিয়োগ আয় খরচ উত্তোলন">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ১</span>
                <h6 class="text-info fw-bold mb-2">মালিকানাস্বত্ব বা স্বত্বাধিকার</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9); border: 1px dashed rgba(52, 211, 153, 0.4);">
                    = (মালিকের বিনিয়োগ + ব্যবসার আয় - ব্যবসার খরচ - মালিকের ব্যক্তিগত প্রয়োজনে উত্তোলন)
                </div>
            </div>
        </div>

        <!-- Formula 2 -->
        <div class="col-md-6 formula-card" data-keywords="নগদ তহবিল নগদ উদ্বৃত্ত সমাপনী নগদ প্রারম্ভিক নগদ">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ২</span>
                <h6 class="text-info fw-bold mb-2">নগদ তহবিল / নগদ উদ্বৃত্তের পরিমাণ / সমাপনী নগদ</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9); border: 1px dashed rgba(52, 211, 153, 0.4);">
                    = (প্রারম্ভিক নগদ + নগদ প্রাপ্তি - নগদ প্রদান)
                </div>
            </div>
        </div>

        <!-- Formula 3 -->
        <div class="col-md-12 formula-card" data-keywords="মোট মূলধন মূলধনের পরিমাণ নিট মূলধন প্রকৃত মূলধন">
            <div class="p-3 rounded-3" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৩</span>
                <h6 class="text-info fw-bold mb-2">মোট মূলধন / নিট মূলধন / প্রকৃত মূলধন</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm mb-2" style="background: rgba(15, 23, 42, 0.9); border: 1px dashed rgba(52, 211, 153, 0.4);">
                    = (প্রারম্ভিক মূলধন + অতিরিক্ত মূলধন + প্রতিষ্ঠানের খরচে মালিকের প্রদান) - (উত্তোলন + আয়কর + জীবন বীমা প্রিমিয়াম)
                </div>
                <div class="text-slate-400 text-xs">
                    <b>অথবা:</b> (মূলধন + মূলধনের সুদ + নিট লাভ) - (উত্তোলন + উত্তোলন সুদ + আয়কর + পণ্য উত্তোলন + নিট ক্ষতি)
                </div>
            </div>
        </div>

        <!-- Formula 4 -->
        <div class="col-md-12 formula-card" data-keywords="হিসাব সমীকরণ মৌলিক বর্ধিত এক মালিকানা অংশীদারি কোম্পানি">
            <div class="p-3 rounded-3" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-warning text-dark mb-2">সূত্র ৪ (সমীকরণ রূপ)</span>
                <h6 class="text-warning fw-bold mb-2">হিসাব সমীকরণ (মৌলিক ও বর্ধিত রূপসমূহ)</h6>
                <div class="row g-2 text-sm">
                    <div class="col-md-4 p-2 rounded bg-slate-900 border border-slate-800 text-center">
                        <small class="text-muted d-block">মৌলিক সমীকরণ</small>
                        <b class="text-cyan-400">A = L + OE</b>
                    </div>
                    <div class="col-md-4 p-2 rounded bg-slate-900 border border-slate-800 text-center">
                        <small class="text-muted d-block">বর্ধিত সমীকরণ</small>
                        <b class="text-purple-400">A = L + C + R - E - D</b>
                    </div>
                    <div class="col-md-4 p-2 rounded bg-slate-900 border border-slate-800 text-center">
                        <small class="text-muted d-block">কোম্পানির ক্ষেত্রে</small>
                        <b class="text-emerald-400">A = L + Shareholders' Equity (SE)</b>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formula 5 & 6 -->
        <div class="col-md-6 formula-card" data-keywords="ধারে ক্রয় বাকিতে ক্রয় বাট্টা">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৫</span>
                <h6 class="text-info fw-bold mb-2">ধারে ক্রয়ের পরিমাণ</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = মোট ধারে ক্রয়কৃত পণ্য - ক্রয় বাট্টা (যদি থাকে)
                </div>
            </div>
        </div>

        <div class="col-md-6 formula-card" data-keywords="নগদে ক্রয় পরিমাণ">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৬</span>
                <h6 class="text-info fw-bold mb-2">নগদে ক্রয়ের পরিমাণ নির্ণয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = নগদে ক্রয়কৃত পণ্যের সমষ্টি
                </div>
            </div>
        </div>

        <!-- Formula 7 & 8 -->
        <div class="col-md-6 formula-card" data-keywords="মোট ক্রয় নগদে চেকে বিলে কার্বে">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৭</span>
                <h6 class="text-info fw-bold mb-2">মোট ক্রয় নির্ণয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = নগদে ক্রয় + চেকে ক্রয় + বিলে ক্রয় + কার্ডে ক্রয় + বাকিতে ক্রয় - ক্রয় বাট্টা
                </div>
            </div>
        </div>

        <div class="col-md-6 formula-card" data-keywords="নিট ক্রয় প্রকৃত ক্রয় ফেরত বিনামূল্যে বিতরণ">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৮</span>
                <h6 class="text-info fw-bold mb-2">নিট ক্রয় বা প্রকৃত ক্রয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = (মোট ক্রয়) - (ক্রয় ফেরত + ক্রয় বাট্টা + পণ্য উত্তোলন + বিনামূল্যে পণ্য বিতরণ)
                </div>
            </div>
        </div>

        <!-- Formula 9, 10, 11 -->
        <div class="col-md-4 formula-card" data-keywords="ধারে বিক্রয়">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ৯</span>
                <h6 class="text-info fw-bold mb-2">ধারে বিক্রয় নির্ণয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = মোট ধারে বিক্রয়কৃত পণ্য - বিক্রয় বাট্টা
                </div>
            </div>
        </div>

        <div class="col-md-4 formula-card" data-keywords="মোট বিক্রয়">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ১০</span>
                <h6 class="text-info fw-bold mb-2">মোট বিক্রয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = নগদে + চেকে + বিলে + কার্ডে + বাকিতে বিক্রয় - বিক্রয় বাট্টা
                </div>
            </div>
        </div>

        <div class="col-md-4 formula-card" data-keywords="নিট বিক্রয় প্রকৃত বিক্রয়">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ১১</span>
                <h6 class="text-info fw-bold mb-2">নিট বিক্রয় বা প্রকৃত বিক্রয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = (মোট বিক্রয়) - (বিক্রয় ফেরত + বিক্রয় বাট্টা)
                </div>
            </div>
        </div>

        <!-- Formula 12 & 13 -->
        <div class="col-md-6 formula-card" data-keywords="ক্রয় বাট্টা কারবারি বাট্টা">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ১২</span>
                <h6 class="text-info fw-bold mb-2">ক্রয় বাট্টার পরিমাণ</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = পণ্য ক্রয়ের সময় যে কারবারি বাট্টা পাওয়া যায় তার সমষ্টি।
                </div>
            </div>
        </div>

        <div class="col-md-6 formula-card" data-keywords="বিক্রয় বাট্টা">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ১৩</span>
                <h6 class="text-info fw-bold mb-2">বিক্রয় বাট্টা নির্ণয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = পণ্য বিক্রয়ের সময় যে কারবারি বাট্টা প্রদান করা হয় তার সমষ্টি।
                </div>
            </div>
        </div>

        <!-- Formula 14, 15, 16 -->
        <div class="col-md-4 formula-card" data-keywords="প্রারম্ভিক মূলধন সম্পদ দায়">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-info text-dark mb-2">সূত্র ১৪</span>
                <h6 class="text-info fw-bold mb-2">প্রারম্ভিক মূলধন</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = প্রারম্ভিক মোট সম্পদ - প্রারম্ভিক মোট দায়
                </div>
            </div>
        </div>

        <div class="col-md-4 formula-card" data-keywords="সমাপনী মূলধন">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-info text-dark mb-2">সূত্র ১৫</span>
                <h6 class="text-info fw-bold mb-2">সমাপনী মূলধন</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = সমাপনী মোট সম্পদ - সমাপনী মোট দায়
                </div>
            </div>
        </div>

        <div class="col-md-4 formula-card" data-keywords="লাভ ক্ষতি লাভ-ক্ষতি">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-info text-dark mb-2">সূত্র ১৬</span>
                <h6 class="text-info fw-bold mb-2">লাভ / ক্ষতি নির্ণয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-sm" style="background: rgba(15, 23, 42, 0.9);">
                    = (সমাপনী মূলধন + উত্তোলন) - (প্রারম্ভিক মূলধন + অতিরিক্ত মূলধন)
                </div>
            </div>
        </div>

        <!-- Formula 17 & 18 (Expenses) -->
        <div class="col-md-6 formula-card" data-keywords="প্রত্যক্ষ খরচ মজুরি পরিবহন শুল্ক">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-danger mb-2">সূত্র ১৭</span>
                <h6 class="text-danger fw-bold mb-2">প্রত্যক্ষ খরচ সমূহ</h6>
                <div class="p-2 rounded text-slate-300 text-xs lh-base" style="background: rgba(15, 23, 42, 0.9);">
                    = (প্রারম্ভিক মজুদ পণ্য + নিট ক্রয় + ক্রয় পরিবহন + আমদানি শুল্ক + মজুরি ও বেতন + জ্বালানি খরচ + কারখানা সংক্রান্ত খরচ - অগ্রিম খরচ)
                </div>
            </div>
        </div>

        <div class="col-md-6 formula-card" data-keywords="পরোক্ষ খরচ বেতন ভাড়া শুল্ক অডিট অনাদায়ী দেনা">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-danger mb-2">সূত্র ১৮</span>
                <h6 class="text-danger fw-bold mb-2">পরোক্ষ খরচ সমূহ</h6>
                <div class="p-2 rounded text-slate-300 text-xs lh-base" style="background: rgba(15, 23, 42, 0.9);">
                    = (বেতন ও মজুরি + ভাড়া/অফিস খরচ + রফতানি শুল্ক + কারবারী খরচ + অডিট ফি + কমিশন/বাট্টা + বীমা সেলামী + অবচয় + কুঋণ/অনাদায়ী পাওনা)
                </div>
            </div>
        </div>

        <!-- Formula 19 to 23 -->
        <div class="col-md-6 formula-card" data-keywords="পরোক্ষ আয় প্রাপ্তি প্রাপ্ত সুদ বাট্টা কমিশন">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-success mb-2">সূত্র ১৯ & ২০</span>
                <h6 class="text-success fw-bold mb-2">পরোক্ষ আয় ও মোট ব্যয়</h6>
                <div class="p-2 rounded text-emerald-300 font-monospace text-xs mb-1" style="background: rgba(15, 23, 42, 0.9);">
                    <b>পরোক্ষ আয়:</b> শিক্ষা শিক্ষানবিস সেলামি + উপভাড়া + প্রাপ্ত ভাড়া/সুদ/বাট্টা/কমিশন
                </div>
                <div class="p-2 rounded text-emerald-300 font-monospace text-xs" style="background: rgba(15, 23, 42, 0.9);">
                    <b>মোট ব্যয়:</b> (প্রত্যক্ষ খরচ + পরোক্ষ খরচ)
                </div>
            </div>
        </div>

        <div class="col-md-6 formula-card" data-keywords="মুনাফা জাতীয় আয় বিষয় আয় বিবরণী">
            <div class="p-3 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-success mb-2">সূত্র ২১, ২২, ২৩</span>
                <h6 class="text-success fw-bold mb-2">মুনাফা জাতীয় আয় ও ব্যয়</h6>
                <div class="p-2 rounded text-emerald-300 text-xs" style="background: rgba(15, 23, 42, 0.9);">
                    <b>মুনাফা জাতীয় আয়:</b> বিক্রয় + উপভাড়া + বিনিয়োগের সুদ + প্রাপ্ত কমিশন/বাট্টা<br>
                    <b>নিট আয় / বিশদ আয়:</b> মুনাফা জাতীয় আয় - মুনাফা জাতীয় ব্যয়
                </div>
            </div>
        </div>

        <!-- Formula 24 to 30 -->
        <div class="col-md-12 formula-card" data-keywords="স্থায়ী সম্পত্তি অবচয় মূলধন জাতীয় প্রাপ্তি অস্পর্শনীয় আবর্তক">
            <div class="p-3 rounded-3" style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255,255,255,0.08);">
                <span class="badge bg-primary mb-2">সূত্র ২৪ - ৩০ (সম্পত্তি ও মূলধন জাতীয় প্রাপ্তি/ব্যয়)</span>
                <div class="row g-2 text-xs mt-1">
                    <div class="col-md-6 p-2 rounded bg-slate-900 border border-slate-800">
                        <b class="text-info">২৪ & ২৫. স্থায়ী সম্পত্তি:</b> দালানকোঠা, আসবাবপত্র, জমি, যন্ত্রপাতি, ট্রেডমার্ক, পেটেন্ট, সুনাম।
                    </div>
                    <div class="col-md-6 p-2 rounded bg-slate-900 border border-slate-800">
                        <b class="text-warning">২৬ & ২৭. মূলধন জাতীয় ব্যয়/প্রাপ্তি:</b> স্থায়ী সম্পদ ক্রয়, স্থাপন ব্যয়, ব্যাংক থেকে গৃহীত ঋণ, মূলধন আনয়ন।
                    </div>
                    <div class="col-md-6 p-2 rounded bg-slate-900 border border-slate-800">
                        <b class="text-purple-300">২৯. অস্পর্শনীয় / অদৃশ্যমান খরচ:</b> সুনাম + ট্রেডমার্ক + পেটেন্ট + কপিরাইট।
                    </div>
                    <div class="col-md-6 p-2 rounded bg-slate-900 border border-slate-800">
                        <b class="text-pink-300">৩০. আবর্তক খরচ:</b> পণ্য ক্রয় + টেলিফোন বিল + পরিবহন + বেতন ও মজুরি + বিদ্যুৎ বিল।
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function filterFormulas() {
    const input = document.getElementById('formulaSearchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.formula-card');

    cards.forEach(card => {
        const keywords = card.getAttribute('data-keywords').toLowerCase();
        const text = card.innerText.toLowerCase();
        if (keywords.includes(input) || text.includes(input)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
