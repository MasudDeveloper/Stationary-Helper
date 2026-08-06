<!-- Math Guide Modal -->
<div class="modal fade" id="mathGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background: #1e293b; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <i class="material-icons-round text-primary">functions</i> ম্যাথ (LaTeX) লেখার গাইড ও লাইভ প্রিভিউ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd;">
                    <strong>নিয়ম:</strong> যেকোনো গাণিতিক সমীকরণ বা সূত্র লেখার সময় তার শুরুতে এবং শেষে একটি করে <code>$</code> (ডলার) চিহ্ন দিতে হবে। যেমন: <code>$a+b=c$</code>
                </div>

                <h6 class="text-white mt-4 mb-3 border-bottom pb-2 border-secondary">সাধারণ উদাহরণ (Examples)</h6>
                <div class="table-responsive">
                    <table class="table table-dark table-bordered table-sm align-middle" style="background: transparent;">
                        <thead>
                            <tr class="text-muted">
                                <th>কিসের সূত্র?</th>
                                <th>কীভাবে লিখবেন (Code)</th>
                                <th class="text-center">ফলাফল (Preview)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>সাধারণ সমীকরণ</td>
                                <td><code>$x = y + 2$</code></td>
                                <td class="text-center">$x = y + 2$</td>
                            </tr>
                            <tr>
                                <td>ভগ্নাংশ (Fraction)</td>
                                <td><code>$\frac{a}{b}$</code> অথবা <code>$\frac{1}{2}$</code></td>
                                <td class="text-center">$\frac{a}{b}$</td>
                            </tr>
                            <tr>
                                <td>পাওয়ার / স্কয়ার (Superscript)</td>
                                <td><code>$x^2$</code> অথবা <code>$a^{x+1}$</code></td>
                                <td class="text-center">$x^2$</td>
                            </tr>
                            <tr>
                                <td>বেস / সাবস্ক্রিপ্ট (Subscript)</td>
                                <td><code>$H_2O$</code> অথবা <code>$x_{i+1}$</code></td>
                                <td class="text-center">$H_2O$</td>
                            </tr>
                            <tr>
                                <td>রুট (Square Root)</td>
                                <td><code>$\sqrt{x}$</code> অথবা <code>$\sqrt[3]{8}$</code></td>
                                <td class="text-center">$\sqrt{x}$</td>
                            </tr>
                            <tr>
                                <td>জ্যামিতি / ত্রিকোণমিতি</td>
                                <td><code>$\sin(\theta)$</code> , <code>$\triangle ABC$</code> , <code>$90^\circ$</code></td>
                                <td class="text-center">$\sin(\theta)$ , $\triangle ABC$ , $90^\circ$</td>
                            </tr>
                            <tr>
                                <td>যোগফল ও গুণফল (Sum/Limit)</td>
                                <td><code>$\sum_{i=1}^{n} x_i$</code> , <code>$\lim_{x \to 0}$</code></td>
                                <td class="text-center">$\sum_{i=1}^{n} x_i$</td>
                            </tr>
                            <tr>
                                <td>ম্যাট্রিক্স (Matrix)</td>
                                <td><code>$\begin{pmatrix} 1 & 2 \\ 3 & 4 \end{pmatrix}$</code></td>
                                <td class="text-center">$\begin{pmatrix} 1 & 2 \\ 3 & 4 \end{pmatrix}$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="text-white mt-4 mb-3 border-bottom pb-2 border-secondary text-success">
                    <i class="material-icons-round" style="vertical-align: middle; font-size: 20px;">play_circle</i> লাইভ প্র্যাকটিস (Try it yourself)
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">এখানে কোড লিখুন:</label>
                        <textarea id="mathPlaygroundInput" class="form-control" rows="4" style="background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); font-family: monospace;" placeholder="যেমন: $x = \frac{-b \pm \sqrt{b^2 - 4ac}}{2a}$" onkeyup="updateMathPreview()"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted" style="font-size: 0.85rem;">লাইভ প্রিভিউ (ফলাফল):</label>
                        <div id="mathPlaygroundOutput" class="form-control d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.9); color: #000; height: 106px; border-radius: 6px; font-size: 1.2rem; overflow: auto;">
                            <!-- Preview goes here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<!-- Bijoy Converter Modal (Placeholder) -->
<div class="modal fade" id="bijoyConverterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #1e293b; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h5 class="modal-title"><i class="material-icons-round text-success">translate</i> বিজয় থেকে ইউনিকোড কনভার্টার</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">আপনার বিজয় ফন্টের লেখা নিচে পেস্ট করে কনভার্ট করুন।</p>
                <div class="mb-3">
                    <label>বিজয় (Bijoy) টেক্সট:</label>
                    <textarea id="bijoyInput" class="form-control" rows="3" style="background: rgba(0,0,0,0.3); color: #fff;"></textarea>
                </div>
                <div class="text-center mb-3">
                    <button class="btn btn-success btn-sm" onclick="alert('Converter engine needs to be linked.')">কনভার্ট করুন ↓</button>
                </div>
                <div>
                    <label>ইউনিকোড (Unicode) টেক্সট:</label>
                    <textarea id="unicodeOutput" class="form-control" rows="3" style="background: rgba(0,0,0,0.3); color: #fff;"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let mathJaxTimeout = null;
    function updateMathPreview() {
        const input = document.getElementById('mathPlaygroundInput').value;
        const output = document.getElementById('mathPlaygroundOutput');
        output.innerHTML = input;
        
        if (typeof MathJax !== 'undefined') {
            clearTimeout(mathJaxTimeout);
            mathJaxTimeout = setTimeout(() => {
                MathJax.typesetClear([output]);
                MathJax.typesetPromise([output]).catch(function (err) {
                    console.log(err.message);
                });
            }, 300);
        }
    }
    
    // Render math in the modal table when it is shown
    document.addEventListener('DOMContentLoaded', function () {
        var mathModal = document.getElementById('mathGuideModal');
        if (mathModal) {
            mathModal.addEventListener('shown.bs.modal', function () {
                if (typeof MathJax !== 'undefined') {
                    MathJax.typesetPromise([mathModal]).catch(function (err) {
                        console.log(err.message);
                    });
                }
            });
        }
    });
</script>
