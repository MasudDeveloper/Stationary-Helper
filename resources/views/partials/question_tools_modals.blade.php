<!-- Question Builder Tools Modals & Scripts (Must be included at root body level) -->
<style>
    /* Absolute z-index hierarchy for Bootstrap modals to prevent backdrop trapping */
    .modal-backdrop {
        z-index: 1050 !important;
        background-color: rgba(0, 0, 0, 0.65) !important;
    }
    .modal {
        z-index: 1055 !important;
    }
    .modal-dialog {
        z-index: 1056 !important;
        pointer-events: auto !important;
    }
    .modal-content {
        background: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.8) !important;
        pointer-events: auto !important;
    }
</style>

<!-- 1. Math Formatting Guide Modal -->
<div class="modal fade" id="mathGuideModal" tabindex="-1" aria-labelledby="mathGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
                <h5 class="modal-title d-flex align-items-center gap-2" id="mathGuideModalLabel" style="font-weight: 700; color: #60a5fa;">
                    <i class="material-icons-round">functions</i> গণিত (Math) ও বৈজ্ঞানিক সূত্র লেখার গাইডলাইন
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px; font-size: 0.95rem; line-height: 1.6;">
                <div class="alert alert-info mb-4" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2); color: #93c5fd;">
                    <strong>কিভাবে লিখবেন?</strong> আমাদের সিস্টেমে বিশ্বমানের <b>LaTeX & MathJax</b> ইন্টিগ্রেটেড রয়েছে। যেকোনো গাণিতিক সূত্র বা প্রতীক লেখার জন্য সূত্রটিকে জাস্ট দুটি ডলার চিহ্নের ভেতরে <code>$...$</code> রাখবেন। যেমন: <code>$x^2 + y^2 = r^2$</code> লিখলে সেটি স্বয়ংক্রিয়ভাবে সুন্দর সূত্রের মতো দেখাবে!
                </div>

                <h6 style="color: #fbbf24; font-weight: 700; margin-bottom: 15px;"><i class="material-icons-round" style="font-size: 16px; vertical-align: text-top;">lightbulb</i> প্রয়োজনীয় সূত্রের উদাহরণ ও কোড (কপি করে ব্যবহার করুন):</h6>

                <div class="table-responsive">
                    <table class="table table-dark table-bordered table-hover" style="border-color: rgba(255,255,255,0.1); font-size: 0.9rem;">
                        <thead style="background: rgba(0,0,0,0.3); color: #38bdf8;">
                            <tr>
                                <th style="width: 25%;">বিভাগ</th>
                                <th style="width: 45%;">কী লিখবেন (LaTeX কোড)</th>
                                <th style="width: 30%;">আউটপুট কেমন দেখাবে</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>ঘাত ও সূচক (Powers)</strong></td>
                                <td><code>$x^2 + y^3 = z^n$</code><br><code>$a_{1} + b_{2} = c_{n}$</code></td>
                                <td style="font-size: 1.1rem;">$x^2 + y^3 = z^n$<br>$a_{1} + b_{2} = c_{n}$</td>
                            </tr>
                            <tr>
                                <td><strong>বীজগণিত ও রাশি (Algebra)</strong></td>
                                <td><code>$4a^2b^2 - 16ab^2c^2 + 16b^2c^2$</code><br><code>$(x-y)^2$ এবং $x^2+y^2$</code><br><code>$2a^2+2b^2$ এবং $ab$</code></td>
                                <td style="font-size: 1.1rem;">$4a^2b^2 - 16ab^2c^2 + 16b^2c^2$<br>$(x-y)^2$ এবং $x^2+y^2$<br>$2a^2+2b^2$ এবং $ab$</td>
                            </tr>
                            <tr>
                                <td><strong>ভগ্নাংশ (Fractions)</strong></td>
                                <td><code>$\frac{a}{b} + \frac{x+1}{y-1}$</code><br><code>$\frac{-b \pm \sqrt{b^2-4ac}}{2a}$</code></td>
                                <td style="font-size: 1.1rem;">$\frac{a}{b} + \frac{x+1}{y-1}$<br>$\frac{-b \pm \sqrt{b^2-4ac}}{2a}$</td>
                            </tr>
                            <tr>
                                <td><strong>বর্গমূল ও ঘনমূল (Roots)</strong></td>
                                <td><code>$\sqrt{x} + \sqrt{a^2 + b^2}$</code><br><code>$\sqrt[3]{27} = 3$</code></td>
                                <td style="font-size: 1.1rem;">$\sqrt{x} + \sqrt{a^2 + b^2}$<br>$\sqrt[3]{27} = 3$</td>
                            </tr>
                            <tr>
                                <td><strong>ত্রিকোণমিতি (Trig)</strong></td>
                                <td><code>$\sin^2\theta + \cos^2\theta = 1$</code><br><code>$\tan(\alpha + \beta)$</code></td>
                                <td style="font-size: 1.1rem;">$\sin^2\theta + \cos^2\theta = 1$<br>$\tan(\alpha + \beta)$</td>
                            </tr>
                            <tr>
                                <td><strong>কোণ ও জ্যামিতি (Geometry)</strong></td>
                                <td><code>$\angle ABC = 90^\circ$</code><br><code>$\triangle ABC \cong \triangle DEF$</code></td>
                                <td style="font-size: 1.1rem;">$\angle ABC = 90^\circ$<br>$\triangle ABC \cong \triangle DEF$</td>
                            </tr>
                            <tr>
                                <td><strong>গাণিতিক প্রতীক (Symbols)</strong></td>
                                <td><code>$\pm, \times, \div, \approx, \neq$</code><br><code>$\leq, \geq, \infty, \pm$</code></td>
                                <td style="font-size: 1.1rem;">$\pm, \times, \div, \approx, \neq$<br>$\leq, \geq, \infty, \pm$</td>
                            </tr>
                            <tr>
                                <td><strong>গ্রিক অক্ষর (Greek Letters)</strong></td>
                                <td><code>$\alpha, \beta, \gamma, \delta, \theta, \pi, \sigma, \omega$</code></td>
                                <td style="font-size: 1.1rem;">$\alpha, \beta, \gamma, \delta, \theta, \pi, \sigma, \omega$</td>
                            </tr>
                            <tr>
                                <td><strong>রসায়ন (Chemistry)</strong></td>
                                <td><code>$H_2O, CO_2, H_2SO_4$</code><br><code>$2H_2 + O_2 \rightarrow 2H_2O$</code></td>
                                <td style="font-size: 1.1rem;">$H_2O, CO_2, H_2SO_4$<br>$2H_2 + O_2 \rightarrow 2H_2O$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 p-3" style="background: rgba(255,255,255,0.03); border-radius: 6px; border: 1px dashed rgba(255,255,255,0.2);">
                    <strong style="color: #a7f3d0;">টিপস:</strong> প্রশ্ন বা অপশনে লেখার সাথে সাথেই ডানপাশের প্রিভিউ প্যানেলে সূত্রটি রেন্ডার হয়ে যাবে। কোনো সূত্র বুঝতে সমস্যা হলে কোডের দুই পাশে <code>$</code> দিতে ভুলবেন না।
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">বুঝেছি (Close)</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Bijoy to Unicode Converter Modal -->
<div class="modal fade" id="bijoyConverterModal" tabindex="-1" aria-labelledby="bijoyConverterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
                <h5 class="modal-title d-flex align-items-center gap-2" id="bijoyConverterModalLabel" style="font-weight: 700; color: #34d399;">
                    <i class="material-icons-round">translate</i> বিজয় (SutonnyMJ) ⇄ ইউনিকোড কনভার্টার
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="alert alert-success mb-3" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #6ee7b7; font-size: 0.9rem;">
                    <strong>কেন লেখা ভেঙে যায়?</strong> এমএস ওয়ার্ড (MS Word) বা বিজয় বায়ান্ন (Bijoy 52) দিয়ে লেখার সময় SutonnyMJ ফন্ট ব্যবহার করা হয়, যা ANSI এনকোডিং। আধুনিক ওয়েবসাইট ও ব্রাউজারে ইউনিকোড (Unicode) চলে। তাই বিজয়ের লেখা সরাসরি কপি-পেস্ট করলে ভেঙে যায় বা ইংলিশ অক্ষর (যেমন: <code>cÖkœ</code>) দেখায়। নিচের বক্সে পেস্ট করলেই তা নিখুঁত ইউনিকোডে রূপান্তর হয়ে যাবে!
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #f59e0b;">১. বিজয় (SutonnyMJ) টেক্সট এখানে পেস্ট করুন:</label>
                        <textarea id="bijoy_modal_input" class="form-control" rows="6" placeholder="এখানে বিজয়ের লেখা পেস্ট করুন... (যেমন: cÖkœcÎ tgKvi)" style="background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.15); font-size: 1rem;"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #10b981;">২. ইউনিকোড আউটপুট (স্বয়ংক্রিয়ভাবে তৈরি হবে):</label>
                        <textarea id="unicode_modal_output" class="form-control" rows="6" readonly placeholder="ইউনিকোড বাংলা এখানে আসবে..." style="background: rgba(16, 185, 129, 0.05); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 1.05rem; font-weight: 500; font-family: 'Kalpurush', 'SolaimanLipi', sans-serif;"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="button" onclick="clearBijoyModal()" class="btn btn-outline-danger btn-sm">
                        <i class="material-icons-round" style="font-size: 16px; vertical-align: middle;">delete</i> মুছে ফেলুন (Clear)
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" onclick="convertModalText()" class="btn btn-primary px-4">
                            <i class="material-icons-round" style="font-size: 18px; vertical-align: middle;">sync_alt</i> কনভার্ট করুন
                        </button>
                        <button type="button" onclick="copyUnicodeOutput()" class="btn btn-success px-4" id="btn_copy_unicode">
                            <i class="material-icons-round" style="font-size: 18px; vertical-align: middle;">content_copy</i> কপি করুন
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">বন্ধ করুন (Close)</button>
            </div>
        </div>
    </div>
</div>

<!-- Bijoy to Unicode Translation Engine & Handlers -->
<script>
// Standard Bijoy to Unicode Mapping Engine
function convertBijoyToUnicode(text) {
    if (!text) return "";
    
    // Protect LaTeX math expressions ($...$, \(...\), \[...\]) from being modified during conversion!
    let mathBlocks = [];
    let subText = text.replace(/(\$[^$\r\n]+?\$|\\\(.*?\\\)|\\\[.*?\\\])/g, function(match) {
        mathBlocks.push(match);
        return String.fromCharCode(0xE000 + (mathBlocks.length - 1));
    });

    let bijoy = [
        "vq", "vq", "we", "iv", "iv", "ev", "ev", "cÖ", "cÖ", "cÖ", "cÖ", "cÖ", "cÖ", "cÖ", "cÖ", "kœ", "kœ", "kœ",
        "w³", "w³", "w³", "w³", "d¬", "d¬", "wæ", "wæ", "wæ", "wæ", "wYé", "wYé", "Yé", "Yé", "Yé",
        "å", "å", "å", "å", "„", "„", "„", "„", "…", "…", "…", "…", "†", "†", "†", "†", "‡", "‡", "‡", "‡", "ˆ", "ˆ", "ˆ", "ˆ",
        "‰", "‰", "‰", "‰", "Š", "Š", "Š", "Š", "v", "v", "v", "v", "w", "w", "w", "w", "x", "x", "x", "x", "y", "y", "y", "y",
        "z", "z", "z", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
        "_", "`", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "•", "–", "—", "™", "š", "›", "œ", "Ÿ", "¡", "¢", "£", "¤", "¥", "¦", "§", "¨", "©", "ª", "«", "¬", "­", "®", "¯", "°", "±", "²", "³", "´", "µ", "¶", "·", "¸", "¹", "º", "»", "¼", "½", "¾", "¿", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "×", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "Þ", "ß", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "÷", "ø", "ù", "ú", "û", "ü", "ý", "þ", "ÿ",
        "Œ", "œ", "Š", "š", "Ÿ", "ƒ", "ˆ", "˜", "™", "š", "›", "œ", "•", "·", "‚", "„", "…", "†", "‡", "‰", "‹", "Œ", "Ž", "•", "–", "—", "™", "š", "›", "œ", "Ÿ", "¡", "¢", "£", "¤", "¥", "¦", "§", "¨", "©", "ª", "«", "¬", "­", "®", "¯", "°", "±", "²", "³", "´", "µ", "¶", "·", "¸", "¹", "º", "»", "¼", "½", "¾", "¿"
    ];

    let unicode = [
        "য়", "য়", "বি", "রা", "রা", "বা", "বা", "প্র", "প্র", "প্র", "প্র", "প্র", "প্র", "প্র", "প্র", "শ্ন", "শ্ন", "শ্ন",
        "ক্তি", "ক্তি", "ক্তি", "ক্তি", "ফ্ল", "ফ্ল", "দ্ধি", "দ্ধি", "দ্ধি", "দ্ধি", "ণ্ঠি", "ণ্ঠি", "ণ্ঠ", "ণ্ঠ", "ণ্ঠ",
        "ভ্র", "ভ্র", "ভ্র", "ভ্র", "ৃ", "ৃ", "ৃ", "ৃ", "ৃ", "ৃ", "ৃ", "ৃ", "ে", "ে", "ে", "ে", "ে", "ে", "ে", "ে", "ৈ", "ৈ", "ৈ", "ৈ",
        "ৈ", "ৈ", "ৈ", "ৈ", "ৌ", "ৌ", "ৌ", "ৌ", "া", "া", "া", "া", "ি", "ি", "ি", "ি", "ী", "ী", "ী", "ী", "ু", "ু", "ু", "ু",
        "ূ", "ূ", "ূ", "ূ", "অ", "ই", "ঈ", "উ", "ঊ", "ঋ", "এ", "ঐ", "ও", "ঔ", "ক", "খ", "গ", "ঘ", "ঙ", "চ", "ছ", "জ", "ঝ", "ঞ", "ট", "ঠ", "ড", "ঢ", "ণ", "ত",
        "থ", "দ", "ধ", "ন", "প", "ফ", "ব", "ভ", "ম", "য", "র", "ল", "শ", "ষ", "স", "হ", "ড়", "ঢ়", "য়", "ৎ", "ং", "ঃ", "ঁ", "া", "ি", "ী", "ু", "ূ",
        "০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "ঙ্ম", "হ্ম", "হ্ণ", "হ্ব", "হ্ল", "হ্র", "শ্ন", "শ্ব", "শ্ল", "ষ্ক", "ষ্ট", "ষ্ঠ", "ষ্ণ", "ষ্প", "ষ্ফ", "স্ম", "স্ন", "স্প", "স্ফ", "স্ল", "স্ব", "স্ক", "স্খ", "স্ত", "স্থ", "স্ন", "স্প", "স্ফ", "স্ল", "স্ব", "হু", "হৃ", "হ্ন", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ", "ক্ষ", "ক্ষ্ম", "ক্ষ্য", "ক্স", "গু", "গ্ধ", "গ্ন", "গ্ম", "গ্ল", "গ্র", "ঘ্ন", "ঙ্ক", "ঙ্গ", "ঙ্খ", "ঙ্ঘ", "চ্চ", "চ্ছ", "জ্ঝ", "জ্জ", "জ্ঞ", "জ্ব", "ঞ্চ", "ঞ্ছ", "ঞ্জ", "ট্ট", "ট্ব", "ট্ম", "ট্য", "ড্ড", "ঢ্য", "ণ্ঠ", "ণ্ড", "ণ্ন", "ণ্ম", "ত্ত", "ত্থ", "ত্ন", "ত্ম", "ত্ব", "ত্য", "ত্র", "দ্দ", "দ্ধ", "দ্ব", "দ্ম", "দ্য", "দ্র", "ধ্ন", "ধ্ব", "ধ্ম", "ধ্য", "ধ্র", "ন্ট", "ন্ঠ", "ন্ড", "ন্ত", "ন্থ", "ন্দ", "ন্ধ", "ন্ন", "ন্ম", "ন্য", "ন্ব",
        "শ্ন", "শ্ন", "শ্ল", "শ্ল", "শ্ব", "রু", "রূ", "গ্র", "হ্ব", "শ্ল", "শ্ল", "শ্ন", "ঙ্ম", "হ্র", "হ্ল", "ৃ", "ৃ", "ে", "ে", "ৈ", "ৈ", "শ্ন", "শ্ব", "ঙ্ম", "হ্ম", "হ্ণ", "হ্ব", "হ্ল", "হ্র", "শ্ন", "শ্ব", "শ্ল", "ষ্ক", "ষ্ট", "ষ্ঠ", "ষ্ণ", "ষ্প", "ষ্ফ", "স্ম", "স্ন", "স্প", "স্ফ", "স্ল", "স্ব", "স্ক", "স্খ", "স্ত", "স্থ", "স্ন", "স্প", "স্ফ", "স্ল", "স্ব", "হু", "হৃ", "হ্ন", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ", "হ্ম", "হ্ল", "হ্র", "হ্ব", "হ্ণ"
    ];

    // subText initialized above with math protection
    subText = subText.replace(/‡([^v\s‡†ˆ‰Š]+?)v/g, function(match, p1) { return p1 + "ো"; });
    subText = subText.replace(/†([^v\s‡†ˆ‰Š]+?)v/g, function(match, p1) { return p1 + "ো"; });
    subText = subText.replace(/‡([^Š\s‡†ˆ‰vw]+?)Š/g, function(match, p1) { return p1 + "ৌ"; });
    subText = subText.replace(/[‡†]([^\s‡†ˆ‰Švw]+)/g, function(match, p1) { return p1 + "ে"; });
    subText = subText.replace(/[ˆ‰]([^\s‡†ˆ‰Švw]+)/g, function(match, p1) { return p1 + "ৈ"; });
    subText = subText.replace(/w([^\s‡†ˆ‰Švw]+)/g, function(match, p1) { return p1 + "ি"; });

    let commonBijoyMap = {
        "cÖkœ": "প্রশ্ন", "cÖkœcÎ": "প্রশ্নপত্র", "cÎ": "পত্র", "Î": "ত্র", "tgKvi": "মেকার", "evsjv": "বাংলা",
        "cÖ_g": "প্রথম", "wØZxq": "দ্বিতীয়", "Z…Zxq": "তৃতীয়", "PZy_©": "চতুর্থ",
        "cÂg": "পঞ্চম", "cix¶v": "পরীক্ষা", "mgq": "সময়", "c~Y©gvb": "পূর্ণমান",
        "DÏxcK": "উদ্দীপক", "Ávbg~jK": "জ্ঞানমূলক", "Abyavebg~jK": "অনুধাবনমূলক",
        "cÖ‡qvMg~jK": "প্রয়োগমূলক", "D”PZi": "উচ্চতর", "`¶Zv": "দক্ষতা",
        "K(": "ক(", "L(": "খ(", "M(": "গ(", "N(": "ঘ("
    };

    for (let key in commonBijoyMap) {
        let escKey = key.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        let regex = new RegExp(escKey, "g");
        subText = subText.replace(regex, commonBijoyMap[key]);
    }

    let mapPairs = [];
    for (let i = 0; i < bijoy.length; i++) {
        if (bijoy[i] && unicode[i]) mapPairs.push({ b: bijoy[i], u: unicode[i] });
    }
    mapPairs.sort((x, y) => y.b.length - x.b.length);

    for (let pair of mapPairs) {
        let esc = pair.b.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        let reg = new RegExp(esc, "g");
        subText = subText.replace(reg, pair.u);
    }

    subText = subText.replace(/ো/g, "ো");
    subText = subText.replace(/ৌ/g, "ৌ");
    subText = subText.replace(/াে/g, "ো");
    
    mathBlocks.forEach((val, idx) => {
        subText = subText.split(String.fromCharCode(0xE000 + idx)).join(val);
    });
    
    return subText;
}

// Modal text converter Live Handler
document.addEventListener('DOMContentLoaded', function() {
    const bijoyInput = document.getElementById('bijoy_modal_input');
    if (bijoyInput) {
        bijoyInput.addEventListener('input', function() {
            convertModalText();
        });
    }
});

function convertModalText() {
    const input = document.getElementById('bijoy_modal_input').value;
    const output = convertBijoyToUnicode(input);
    document.getElementById('unicode_modal_output').value = output;
}

function clearBijoyModal() {
    document.getElementById('bijoy_modal_input').value = '';
    document.getElementById('unicode_modal_output').value = '';
    document.getElementById('bijoy_modal_input').focus();
}

function copyUnicodeOutput() {
    const output = document.getElementById('unicode_modal_output');
    if (!output.value) {
        if (typeof Swal !== 'undefined') Swal.fire('কোনো টেক্সট নেই! প্রথমে বিজয়ের লেখা পেস্ট করুন।');
        else alert('কোনো টেক্সট নেই! প্রথমে বিজয়ের লেখা পেস্ট করুন।');
        return;
    }
    output.select();
    document.execCommand('copy');
    
    const btn = document.getElementById('btn_copy_unicode');
    const origHtml = btn.innerHTML;
    btn.innerHTML = '<i class="material-icons-round" style="font-size: 18px; vertical-align: middle;">check</i> কপি হয়েছে!';
    btn.classList.remove('btn-success');
    btn.classList.add('btn-info');
    
    setTimeout(() => {
        btn.innerHTML = origHtml;
        btn.classList.remove('btn-info');
        btn.classList.add('btn-success');
    }, 2000);
}

function fixAllBijoyInForm() {
    let count = 0;
    const inputs = document.querySelectorAll('.sidebar-content input[type="text"], .sidebar-content textarea');
    
    inputs.forEach(input => {
        const val = input.value;
        if (!val) return;
        if (/[cÖkœtgKvievsjvZ…wØPZy_©cÂmgqc~Y©ÁvbAbyavebD”P`¶]/i.test(val) || /[vqw‡†ˆ‰Š•–—™š›œŸ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿]/.test(val)) {
            const converted = convertBijoyToUnicode(val);
            if (converted !== val) {
                input.value = converted;
                count++;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
    });

    if (count > 0) {
        if (typeof updateSheetHeader === 'function') updateSheetHeader();
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'সফলভাবে ঠিক করা হয়েছে!',
                text: `${count} টি ইনপুট বক্সের ভাঙা বিজয় টেক্সট ইউনিকোডে কনভার্ট করা হয়েছে।`,
                timer: 2500,
                showConfirmButton: false
            });
        } else {
            alert(`${count} টি ইনপুট বক্সের ভাঙা বিজয় টেক্সট ইউনিকোডে কনভার্ট করা হয়েছে!`);
        }
    } else {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'কোনো ভাঙা বিজয় টেক্সট পাওয়া যায়নি',
                text: 'আপনার ফর্মের সব লেখা ইতোমধ্যে ইউনিকোডে ঠিক আছে অথবা কোনো বিজয় ফন্টের ভাঙা লেখা পাওয়া যায়নি।',
                timer: 2500,
                showConfirmButton: false
            });
        } else {
            alert('আপনার ফর্মের সব লেখা ইতোমধ্যে ইউনিকোডে ঠিক আছে!');
        }
    }
}
</script>
