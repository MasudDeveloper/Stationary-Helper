{{-- Accounting Dynamic Table Picker & Builder Component --}}
<div class="card bg-dark text-white border-secondary p-3 mb-4 rounded-3" style="font-family: 'Hind Siliguri', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-warning m-0">
            <i class="material-icons-round align-middle me-1">table_chart</i> হিসাববিজ্ঞান ডায়নামিক ছক বিল্ডার (Accounting Table Generator)
        </h5>
        <span class="badge bg-primary">Dynamic Template Engine</span>
    </div>

    <div class="row g-3">
        <!-- Table Type Dropdown -->
        <div class="col-md-6">
            <label class="form-label text-light fw-bold">১. ছকের ধরণ নির্বাচন করুন (Select Accounting Table Type)</label>
            <select id="accounting_table_type_select" class="form-select bg-secondary text-white border-dark" onchange="renderAccountingTableBuilder(this.value)">
                <option value="">-- ছকের ধরণ বেছে নিন --</option>
                <optgroup label="হিসাব সমীকরণ ও টেবুলার ছক">
                    <option value="statement_equation">বিবরণী ছকে হিসাব সমীকরণ (Statement Equation with Balance)</option>
                    <option value="tabular_extended">বর্ধিত হিসাব সমীকরণের টেবুলার ছক (Tabular Format)</option>
                    <option value="tabular_basic">মৌলিক হিসাব সমীকরণের টেবুলার ছক</option>
                    <option value="asset_statement">সম্পদের বিবরণী ছক (Asset Statement)</option>
                </optgroup>

                <optgroup label="প্রমাণপত্র ও ভাউচার">
                    <option value="invoice">চালান (Invoice)</option>
                    <option value="cash_memo">ক্যাশমেমো (Cash Memo)</option>
                    <option value="debit_note">ডেবিট নোট (Debit Note)</option>
                    <option value="credit_note">ক্রেডিট নোট (Credit Note)</option>
                </optgroup>
                <optgroup label="সারাংশ ও নিয়মাবলী">
                    <option value="impact_summary">হিসাবের প্রভাবের সারাংশ (Transaction Impact Summary)</option>
                    <option value="debit_credit_rules">ডেবিট-ক্রেডিট মনে রাখার নিয়ম</option>
                </optgroup>
            </select>
        </div>

        <!-- Custom Columns Config Controls -->
        <div class="col-md-6" id="column_controls_wrapper" style="display: none;">
            <label class="form-label text-light fw-bold">২. ডায়নামিক কলাম কনফিগারেশন (Add/Remove Columns)</label>
            <div class="d-flex gap-2 mb-2">
                <input type="text" id="new_asset_col_name" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="নতুন সম্পদ কলাম (যেমন: দালানকোঠা)">
                <button type="button" class="btn btn-sm btn-success" onclick="addCustomColumn('asset')">+ সম্পদ যোগ</button>
            </div>
            <div class="d-flex gap-2">
                <input type="text" id="new_liability_col_name" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="নতুন দায় কলাম (যেমন: ব্যাংক ঋণ)">
                <button type="button" class="btn btn-sm btn-warning" onclick="addCustomColumn('liability')">+ দায় যোগ</button>
            </div>
        </div>
    </div>

    <!-- Dynamic Columns Tags -->
    <div id="active_columns_tags" class="mt-3" style="display: none;">
        <small class="text-muted d-block mb-1">বর্তমান সক্রিয় সম্পদ ও দায় কলামসমূহ:</small>
        <div id="asset_tags_container" class="d-flex flex-wrap gap-1 mb-1"></div>
        <div id="liability_tags_container" class="d-flex flex-wrap gap-1"></div>
    </div>

    <!-- Live Preview Container -->
    <div class="mt-4 pt-3 border-top border-secondary">
        <h6 class="text-info d-flex justify-content-between align-items-center">
            <span><i class="material-icons-round align-middle me-1">visibility</i> ছকের লাইভ প্রিভিউ (Live Preview)</span>
            <small class="text-muted">প্রশ্নে এই ছকটি প্রদর্শিত হবে</small>
        </h6>
        <div id="accounting_live_preview_box" class="p-3 rounded border border-secondary" style="background: rgba(15, 23, 42, 0.9); min-height: 120px;">
            <div class="text-center text-muted py-4">
                উপরের ড্রপডাউন থেকে যেকোনো একটি ছক নির্বাচন করলে এখানে তা লাইভ দেখা যাবে।
            </div>
        </div>
    </div>
</div>

<script>
let currentAccountingCols = {
    assets: ['নগদ', 'ব্যাংক', 'দেনাদার', 'আসবাবপত্র'],
    liabilities: ['পাওনাদার']
};

function renderAccountingTableBuilder(type) {
    const colControls = document.getElementById('column_controls_wrapper');
    const tagsWrapper = document.getElementById('active_columns_tags');
    const previewBox = document.getElementById('accounting_live_preview_box');

    if (!type) {
        colControls.style.display = 'none';
        tagsWrapper.style.display = 'none';
        previewBox.innerHTML = '<div class="text-center text-muted py-4">উপরের ড্রপডাউন থেকে যেকোনো একটি ছক নির্বাচন করলে এখানে তা লাইভ দেখা যাবে।</div>';
        return;
    }

    if (type === 'statement_equation') {
        colControls.style.display = 'block';
        tagsWrapper.style.display = 'block';
        updateColumnTagsUI();
        previewBox.innerHTML = generateStatementEquationHTML(currentAccountingCols);
    } else if (type.startsWith('tabular')) {
        colControls.style.display = 'block';
        tagsWrapper.style.display = 'block';
        updateColumnTagsUI();
        previewBox.innerHTML = generateTabularTableHTML(currentAccountingCols);
    } else if (type === 'invoice') {
        colControls.style.display = 'none';
        tagsWrapper.style.display = 'none';
        previewBox.innerHTML = generateInvoiceHTML();
    } else if (type === 'cash_memo') {
        colControls.style.display = 'none';
        tagsWrapper.style.display = 'none';
        previewBox.innerHTML = generateCashMemoHTML();
    } else if (type === 'impact_summary') {
        colControls.style.display = 'none';
        tagsWrapper.style.display = 'none';
        previewBox.innerHTML = generateImpactSummaryHTML();
    } else {
        colControls.style.display = 'none';
        tagsWrapper.style.display = 'none';
        previewBox.innerHTML = '<div class="alert alert-info mb-0">নির্বাচিত টেমপ্লেটের ডায়নামিক ছক তৈরি হয়েছে।</div>';
    }
}

function generateStatementEquationHTML(cols) {
    const assetColsTH = cols.assets.map(c => `<th style="border: 1px solid #0f172a; padding: 5px;">${c}</th>`).join('');
    const liabColsTH = cols.liabilities.map(c => `<th style="border: 1px solid #0f172a; padding: 5px;">${c}</th>`).join('');

    return `
    <div style="font-family: 'Hind Siliguri', sans-serif; background: #ffffff; color: #1e293b; padding: 12px; border-radius: 8px; border: 2px solid #0f172a;">
        <div style="font-weight: bold; margin-bottom: 8px;">কাজের সমাধান : বিবরণী ছকে হিসাব সমীকরণের উপর লেনদেনের প্রভাব নিম্নরূপ :</div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: center; border: 2px solid #0f172a;">
                <thead>
                    <tr style="border-bottom: 2px solid #0f172a; background: #f1f5f9;">
                        <th style="border: 1px solid #0f172a; padding: 6px;" rowspan="2">তারিখ</th>
                        <th style="border: 1px solid #0f172a; padding: 6px;" colspan="${cols.assets.length}">সম্পদ</th>
                        <th style="border: 1px solid #0f172a; padding: 6px;" rowspan="2">=</th>
                        <th style="border: 1px solid #0f172a; padding: 6px;" colspan="${cols.liabilities.length}">দায়</th>
                        <th style="border: 1px solid #0f172a; padding: 6px;" rowspan="2">+</th>
                        <th style="border: 1px solid #0f172a; padding: 6px;" rowspan="2">মালিকানাস্বত্ব</th>
                    </tr>
                    <tr style="border-bottom: 2px solid #0f172a; background: #f1f5f9;">
                        ${assetColsTH}
                        ${liabColsTH}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #0f172a; padding: 4px;">২০১৭ মার্চ ১</td>
                        ${cols.assets.map((_, i) => `<td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">${i === 0 ? '২০,০০০' : '—'}</td>`).join('')}
                        <td style="border: 1px solid #0f172a; padding: 4px;">=</td>
                        ${cols.liabilities.map(() => `<td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">—</td>`).join('')}
                        <td style="border: 1px solid #0f172a; padding: 4px;">+</td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">২০,০০০</td>
                    </tr>
                    <tr style="background: #f8fafc; font-weight: bold;">
                        <td style="border: 1px solid #0f172a; padding: 4px;">উদ্বৃত্ত</td>
                        ${cols.assets.map((_, i) => `<td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">${i === 0 ? '২০,০০০' : '—'}</td>`).join('')}
                        <td style="border: 1px solid #0f172a; padding: 4px;">=</td>
                        ${cols.liabilities.map(() => `<td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">—</td>`).join('')}
                        <td style="border: 1px solid #0f172a; padding: 4px;">+</td>
                        <td style="border: 1px solid #0f172a; padding: 4px; text-align: right;">২০,০০০</td>
                    </tr>
                    <tr style="font-weight: bold; background: #e2e8f0;">
                        <td style="border: 1px solid #0f172a; padding: 6px;">মোট</td>
                        <td style="border: 1px solid #0f172a; padding: 6px; text-decoration: underline; text-decoration-style: double;" colspan="${cols.assets.length}">৳ ২০,০০০</td>
                        <td style="border: 1px solid #0f172a; padding: 6px;">=</td>
                        <td style="border: 1px solid #0f172a; padding: 6px; text-decoration: underline; text-decoration-style: double;" colspan="${cols.liabilities.length + 2}">৳ ২০,০০০</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>`;
}


function updateColumnTagsUI() {
    const assetContainer = document.getElementById('asset_tags_container');
    const liabilityContainer = document.getElementById('liability_tags_container');

    assetContainer.innerHTML = '<span class="badge bg-info text-dark">সম্পদ:</span> ' + 
        currentAccountingCols.assets.map((col, idx) => `<span class="badge bg-secondary me-1">${col} <a href="#" onclick="removeCol('assets', ${idx}); return false;" class="text-danger fw-bold text-decoration-none">×</a></span>`).join('');

    liabilityContainer.innerHTML = '<span class="badge bg-warning text-dark">দায়:</span> ' + 
        currentAccountingCols.liabilities.map((col, idx) => `<span class="badge bg-secondary me-1">${col} <a href="#" onclick="removeCol('liabilities', ${idx}); return false;" class="text-danger fw-bold text-decoration-none">×</a></span>`).join('');
}

function addCustomColumn(type) {
    if (type === 'asset') {
        const inp = document.getElementById('new_asset_col_name');
        if (inp.value.trim()) {
            currentAccountingCols.assets.push(inp.value.trim());
            inp.value = '';
        }
    } else {
        const inp = document.getElementById('new_liability_col_name');
        if (inp.value.trim()) {
            currentAccountingCols.liabilities.push(inp.value.trim());
            inp.value = '';
        }
    }
    const typeSelect = document.getElementById('accounting_table_type_select').value;
    renderAccountingTableBuilder(typeSelect);
}

function removeCol(category, index) {
    currentAccountingCols[category].splice(index, 1);
    const typeSelect = document.getElementById('accounting_table_type_select').value;
    renderAccountingTableBuilder(typeSelect);
}

function generateTabularTableHTML(cols) {
    const assetColsTH = cols.assets.map(c => `<th style="border: 1px solid #334155; padding: 6px;">${c}</th>`).join('');
    const liabColsTH = cols.liabilities.map(c => `<th style="border: 1px solid #334155; padding: 6px;">${c}</th>`).join('');
    
    return `
    <div style="overflow-x: auto; color: #cbd5e1;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: center;">
            <thead>
                <tr style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
                    <th style="border: 1px solid #334155; padding: 8px;" rowspan="2">তারিখ</th>
                    <th style="border: 1px solid #334155; padding: 8px;" rowspan="2">বিবরণ</th>
                    <th style="border: 1px solid #334155; padding: 8px;" colspan="${cols.assets.length}">সম্পদ (A)</th>
                    <th style="border: 1px solid #334155; padding: 8px;" colspan="${cols.liabilities.length}">দায় (L)</th>
                    <th style="border: 1px solid #334155; padding: 8px;" colspan="4">মালিকানাস্বত্ব (OE)</th>
                </tr>
                <tr style="background: rgba(30, 41, 59, 0.9);">
                    ${assetColsTH}
                    ${liabColsTH}
                    <th style="border: 1px solid #334155; padding: 6px;">মূলধন (C)</th>
                    <th style="border: 1px solid #334155; padding: 6px;">আয় (R)</th>
                    <th style="border: 1px solid #334155; padding: 6px;">ব্যয় (E)</th>
                    <th style="border: 1px solid #334155; padding: 6px;">উত্তোলন (D)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #334155; padding: 6px;">০১/০১/২০২৬</td>
                    <td style="border: 1px solid #334155; padding: 6px;">প্রারম্ভিক মূলধন</td>
                    ${cols.assets.map((_, i) => `<td style="border: 1px solid #334155; padding: 6px;">${i === 0 ? '৫০,০০০' : '—'}</td>`).join('')}
                    ${cols.liabilities.map(() => `<td style="border: 1px solid #334155; padding: 6px;">—</td>`).join('')}
                    <td style="border: 1px solid #334155; padding: 6px;">৫০,০০০</td>
                    <td style="border: 1px solid #334155; padding: 6px;">—</td>
                    <td style="border: 1px solid #334155; padding: 6px;">—</td>
                    <td style="border: 1px solid #334155; padding: 6px;">—</td>
                </tr>
            </tbody>
        </table>
    </div>`;
}

function generateInvoiceHTML() {
    return `
    <div style="color: #cbd5e1; font-size: 0.85rem;">
        <div style="text-align: center; font-weight: bold; font-size: 1.1rem; color: #f43f5e; margin-bottom: 8px;">চালান (INVOICE)</div>
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background: rgba(30, 41, 59, 0.9);">
                    <th style="border: 1px solid #334155; padding: 6px;">ক্রম</th>
                    <th style="border: 1px solid #334155; padding: 6px; text-align: left;">পণ্যের বিবরণ</th>
                    <th style="border: 1px solid #334155; padding: 6px;">পরিমাণ</th>
                    <th style="border: 1px solid #334155; padding: 6px;">দর</th>
                    <th style="border: 1px solid #334155; padding: 6px;">মোট (টাকা)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #334155; padding: 6px;">১</td>
                    <td style="border: 1px solid #334155; padding: 6px; text-align: left;">নমুনা পণ্য / বিষয়বস্তু</td>
                    <td style="border: 1px solid #334155; padding: 6px;">১০</td>
                    <td style="border: 1px solid #334155; padding: 6px;">১০০</td>
                    <td style="border: 1px solid #334155; padding: 6px;">১,০০০</td>
                </tr>
            </tbody>
        </table>
    </div>`;
}

function generateCashMemoHTML() {
    return `
    <div style="color: #cbd5e1; font-size: 0.85rem;">
        <div style="text-align: center; font-weight: bold; font-size: 1.1rem; color: #38bdf8; margin-bottom: 8px;">ক্যাশমেমো (CASH MEMO)</div>
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background: rgba(30, 41, 59, 0.9);">
                    <th style="border: 1px solid #334155; padding: 6px;">ক্রম</th>
                    <th style="border: 1px solid #334155; padding: 6px; text-align: left;">বিবরণ</th>
                    <th style="border: 1px solid #334155; padding: 6px;">পরিমাণ</th>
                    <th style="border: 1px solid #334155; padding: 6px;">মূল্য</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #334155; padding: 6px;">১</td>
                    <td style="border: 1px solid #334155; padding: 6px; text-align: left;">নগদে বিক্রিত পণ্য</td>
                    <td style="border: 1px solid #334155; padding: 6px;">১</td>
                    <td style="border: 1px solid #334155; padding: 6px;">৫০০</td>
                </tr>
            </tbody>
        </table>
    </div>`;
}

function generateImpactSummaryHTML() {
    return `
    <div style="color: #cbd5e1; font-size: 0.85rem;">
        <div style="text-align: center; font-weight: bold; font-size: 1.1rem; color: #facc15; margin-bottom: 8px;">হিসাবের প্রভাবের সারাংশ</div>
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background: rgba(30, 41, 59, 0.9);">
                    <th style="border: 1px solid #334155; padding: 6px; text-align: left;">ঘটনা</th>
                    <th style="border: 1px solid #334155; padding: 6px;">সম্পদ (A)</th>
                    <th style="border: 1px solid #334155; padding: 6px;">দায় (L)</th>
                    <th style="border: 1px solid #334155; padding: 6px;">মালিকানাস্বত্ব (OE)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #334155; padding: 6px; text-align: left;">নগদে পণ্য ক্রয়</td>
                    <td style="border: 1px solid #334155; color: #f87171;">↓ (নগদ হ্রাস)</td>
                    <td style="border: 1px solid #334155;">—</td>
                    <td style="border: 1px solid #334155; color: #f87171;">↓ (ব্যয় বৃদ্ধি)</td>
                </tr>
            </tbody>
        </table>
    </div>`;
}
</script>
