@extends('layouts.app')

@section('title', 'লেনদেন সমাধানকারী - ' . $exercise->title)

@section('content')
<div class="container-fluid" style="margin-top: 30px; margin-bottom: 40px; max-width: 1400px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-slate-800">
        <div>
            <h2 class="text-white fw-bold mb-1">{{ $exercise->title }}</h2>
            <p class="text-slate-400 text-sm mb-0">{{ $exercise->lesson->title }}</p>
        </div>
        <a href="{{ route('accounting.solver.index') }}" class="btn btn-outline-light rounded-xl btn-sm d-flex align-items-center gap-2">
            <i class="material-icons-round fs-6">arrow_back</i> ক্লাসরুমে ফিরুন
        </a>
    </div>

    <div class="row">
        <!-- Problem Stimulus (Left Side) -->
        <div class="col-lg-5 mb-4">
            <div class="glass p-4 rounded-2xl h-100 border border-slate-800" style="background: rgba(30, 41, 59, 0.4);">
                <h4 class="text-white fw-bold mb-3 d-flex align-items-center gap-2 pb-2 border-bottom border-slate-800">
                    <i class="material-icons-round text-emerald-400">description</i> হিসাব উদ্দীপক (উদ্দীপক)
                </h4>
                <div class="stimulus-content text-slate-300 lh-lg" style="font-size: 1.05rem;">
                    {!! $exercise->stimulus !!}
                </div>

                @if($submission && $submission->is_correct)
                    <div class="alert alert-success mt-4 bg-emerald-500/10 border-emerald-500/20 text-emerald-400 rounded-xl d-flex align-items-center gap-3">
                        <i class="material-icons-round">check_circle</i>
                        <div>
                            <strong>অভিনন্দন!</strong> আপনি এই অনুশীলনীর সঠিক সমাধান করেছেন। স্কোর: {{ $submission->score }}%
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Solve Panel (Right Side Worksheet) -->
        <div class="col-lg-7 mb-4">
            <div class="glass p-4 rounded-2xl border border-slate-800" style="background: rgba(30, 41, 59, 0.4);">
                <h4 class="text-white fw-bold mb-3 d-flex align-items-center gap-2 pb-2 border-bottom border-slate-800">
                    <i class="material-icons-round text-indigo-400">edit_note</i> সমাধান ওয়ার্কশিট (Worksheet)
                </h4>
                
                <form id="solver-form">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle" style="min-width: 650px;">
                            <thead>
                                <tr class="text-slate-400 text-sm border-bottom border-slate-800">
                                    <th class="py-3" style="width: 250px;">হিসাবের নাম</th>
                                    <th class="py-3" style="width: 150px;">শ্রেণী/প্রকৃতি</th>
                                    <th class="py-3" style="width: 130px;">ডেবিট/ক্রেডিট</th>
                                    <th class="py-3 text-end" style="width: 120px;">টাকা (৳)</th>
                                    <th class="py-3 text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <datalist id="account-suggestions">
                                <option value="নগদান হিসাব"></option>
                                <option value="ব্যাংক হিসাব"></option>
                                <option value="আসবাবপত্র হিসাব"></option>
                                <option value="যন্ত্রপাতি হিসাব"></option>
                                <option value="দেনাদার হিসাব"></option>
                                <option value="পাওনাদার হিসাব"></option>
                                <option value="মূলধন হিসাব"></option>
                                <option value="উত্তোলন হিসাব"></option>
                                <option value="ক্রয় হিসাব"></option>
                                <option value="বিক্রয় হিসাব"></option>
                                <option value="বেতন হিসাব"></option>
                                <option value="ভাড়া হিসাব"></option>
                                <option value="বিজ্ঞাপন হিসাব"></option>
                                <option value="বিমা সেলামি হিসাব"></option>
                                <option value="প্রাপ্ত কমিশন হিসাব"></option>
                                <option value="বিনিয়োগের সুদ হিসাব"></option>
                            </datalist>
                            <tbody id="worksheet-body">
                                @if($submission && isset($submission->submitted_answers))
                                    @foreach($submission->submitted_answers as $idx => $entry)
                                        <tr class="entry-row" data-row-idx="{{ $idx }}">
                                            <td>
                                                <input type="text" name="entries[{{ $idx }}][account]" value="{{ $entry['account'] }}" list="account-suggestions" class="form-control bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-account" placeholder="যেমন: নগদান হিসাব" onchange="detectNature(this, {{ $idx }})" required>
                                            </td>
                                            <td>
                                                <select name="entries[{{ $idx }}][nature]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-nature" required>
                                                    <option value="Asset" {{ $entry['nature'] === 'Asset' ? 'selected' : '' }}>সম্পদ</option>
                                                    <option value="Liability" {{ $entry['nature'] === 'Liability' ? 'selected' : '' }}>দায়</option>
                                                    <option value="Equity" {{ $entry['nature'] === 'Equity' ? 'selected' : '' }}>মালিকানাস্বত্ব</option>
                                                    <option value="Revenue" {{ $entry['nature'] === 'Revenue' ? 'selected' : '' }}>আয়</option>
                                                    <option value="Expense" {{ $entry['nature'] === 'Expense' ? 'selected' : '' }}>ব্যয়</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="entries[{{ $idx }}][type]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-type" required>
                                                    <option value="Dr" {{ $entry['type'] === 'Dr' ? 'selected' : '' }}>ডেবিট</option>
                                                    <option value="Cr" {{ $entry['type'] === 'Cr' ? 'selected' : '' }}>ক্রেডিট</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="entries[{{ $idx }}][amount]" value="{{ $entry['amount'] }}" class="form-control bg-slate-900 border-slate-800 text-white text-end rounded-xl py-2 px-3 text-sm val-amount" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" onclick="removeRow(this)" class="btn btn-link text-danger p-0 border-0"><i class="material-icons-round">delete_outline</i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="entry-row" data-row-idx="0">
                                        <td>
                                            <input type="text" name="entries[0][account]" list="account-suggestions" class="form-control bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-account" placeholder="যেমন: নগদান হিসাব" onchange="detectNature(this, 0)" required>
                                        </td>
                                        <td>
                                            <select name="entries[0][nature]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-nature" required>
                                                <option value="Asset">সম্পদ</option>
                                                <option value="Liability">দায়</option>
                                                <option value="Equity">মালিকানাস্বত্ব</option>
                                                <option value="Revenue">আয়</option>
                                                <option value="Expense">ব্যয়</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="entries[0][type]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-type" required>
                                                <option value="Dr">ডেবিট</option>
                                                <option value="Cr">ক্রেডিট</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="entries[0][amount]" class="form-control bg-slate-900 border-slate-800 text-white text-end rounded-xl py-2 px-3 text-sm val-amount" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" onclick="removeRow(this)" class="btn btn-link text-danger p-0 border-0"><i class="material-icons-round">delete_outline</i></button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-slate-800">
                        <button type="button" onclick="addRow()" class="btn btn-outline-indigo d-flex align-items-center gap-2 rounded-xl text-sm btn-sm">
                            <i class="material-icons-round fs-6">add</i> সারি যোগ করুন
                        </button>
                        <button type="submit" class="btn btn-success d-flex align-items-center gap-2 rounded-xl px-4 text-sm font-semibold">
                            <i class="material-icons-round fs-6">fact_check</i> উত্তর যাচাই করুন
                        </button>
                    </div>
                </form>

                <!-- Feedback area -->
                <div id="solver-feedback" class="mt-4" style="display: none;">
                    <div class="p-4 rounded-xl border" id="feedback-card">
                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2 text-white">
                            <i class="material-icons-round">analytics</i> ফলাফল বিশ্লেষণ
                        </h5>
                        <div id="feedback-details" class="space-y-2 text-slate-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let rowCounter = document.querySelectorAll('.entry-row').length;

    function addRow() {
        const tbody = document.getElementById('worksheet-body');
        const tr = document.createElement('tr');
        tr.className = 'entry-row';
        tr.setAttribute('data-row-idx', rowCounter);
        tr.innerHTML = `
            <td>
                <input type="text" name="entries[${rowCounter}][account]" list="account-suggestions" class="form-control bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-account" placeholder="যেমন: নগদান হিসাব" onchange="detectNature(this, ${rowCounter})" required>
            </td>
            <td>
                <select name="entries[${rowCounter}][nature]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-nature" required>
                    <option value="Asset">সম্পদ</option>
                    <option value="Liability">দায়</option>
                    <option value="Equity">মালিকানাস্বত্ব</option>
                    <option value="Revenue">আয়</option>
                    <option value="Expense">ব্যয়</option>
                </select>
            </td>
            <td>
                <select name="entries[${rowCounter}][type]" class="form-select bg-slate-900 border-slate-800 text-white rounded-xl py-2 px-3 text-sm val-type" required>
                    <option value="Dr">ডেবিট</option>
                    <option value="Cr">ক্রেডিট</option>
                </select>
            </td>
            <td>
                <input type="number" name="entries[${rowCounter}][amount]" class="form-control bg-slate-900 border-slate-800 text-white text-end rounded-xl py-2 px-3 text-sm val-amount" required>
            </td>
            <td class="text-center">
                <button type="button" onclick="removeRow(this)" class="btn btn-link text-danger p-0 border-0"><i class="material-icons-round">delete_outline</i></button>
            </td>
        `;
        tbody.appendChild(tr);
        rowCounter++;
    }

    function removeRow(btn) {
        const row = btn.closest('tr');
        if(document.querySelectorAll('.entry-row').length > 1) {
            row.remove();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'দুঃখিত',
                text: 'অন্তত একটি সারি অবশ্যই থাকতে হবে।'
            });
        }
    }

    document.getElementById('solver-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Remove error markings first
        document.querySelectorAll('.entry-row input, .entry-row select').forEach(el => {
            el.classList.remove('border-danger', 'border-success');
        });

        const formData = new FormData(this);
        
        fetch("{{ route('accounting.solver.verify', $exercise->id) }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            const feedbackSection = document.getElementById('solver-feedback');
            const feedbackCard = document.getElementById('feedback-card');
            const feedbackDetails = document.getElementById('feedback-details');
            
            feedbackDetails.innerHTML = '';
            feedbackSection.style.display = 'block';

            if(data.is_correct) {
                feedbackCard.className = "p-4 rounded-xl border bg-emerald-500/10 border-emerald-500/30 text-emerald-400";
                feedbackDetails.innerHTML = `<div><i class="material-icons-round text-emerald-400 fs-5 align-middle me-1">check_circle</i> চমৎকার! আপনার দেওয়া সবগুলো দাখিলা এবং সমীকরণ প্রভাব সম্পূর্ণরূপে সঠিক হয়েছে। (স্কোর: ${data.score}%)</div>`;
                
                document.querySelectorAll('.entry-row input, .entry-row select').forEach(el => {
                    el.classList.add('border-success');
                });
            } else {
                feedbackCard.className = "p-4 rounded-xl border bg-rose-500/10 border-rose-500/30 text-rose-400";
                
                let details = `<div class="mb-2 fw-semibold text-rose-300">ভুল দাখিলা বিশ্লেষণ:</div><ul class="list-disc pl-5 space-y-1.5 text-slate-300 text-sm">`;
                
                data.feedback.forEach(err => {
                    details += `<li>সারি নম্বর ${err.row}: ${err.error}</li>`;
                    
                    // Mark inputs red
                    const rowEl = document.querySelector(`.entry-row[data-row-idx="${err.row - 1}"]`);
                    if(rowEl) {
                        if(err.field) {
                            const fieldEl = rowEl.querySelector(`.val-${err.field}`);
                            if(fieldEl) fieldEl.classList.add('border-danger');
                        } else {
                            rowEl.querySelectorAll('input, select').forEach(el => el.classList.add('border-danger'));
                        }
                    }
                });
                
                details += `</ul>`;
                feedbackDetails.innerHTML = details;
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'ভুল হয়েছে',
                text: 'অনুরোধটি সম্পন্ন করা সম্ভব হয়নি।'
            });
        });
    });

    // Account mapping engine to auto-populate class nature and debit/credit helper values
    const accountNatureMap = {
        'নগদান হিসাব': { nature: 'Asset', type: 'Dr' },
        'ব্যাংক হিসাব': { nature: 'Asset', type: 'Dr' },
        'আসবাবপত্র হিসাব': { nature: 'Asset', type: 'Dr' },
        'যন্ত্রপাতি হিসাব': { nature: 'Asset', type: 'Dr' },
        'দেনাদার হিসাব': { nature: 'Asset', type: 'Dr' },
        'ক্রয় হিসাব': { nature: 'Expense', type: 'Dr' },
        'বেতন হিসাব': { nature: 'Expense', type: 'Dr' },
        'ভাড়া হিসাব': { nature: 'Expense', type: 'Dr' },
        'বিজ্ঞাপন হিসাব': { nature: 'Expense', type: 'Dr' },
        'বিমা সেলামি হিসাব': { nature: 'Expense', type: 'Dr' },
        'পাওনাদার হিসাব': { nature: 'Liability', type: 'Cr' },
        'মূলধন হিসাব': { nature: 'Equity', type: 'Cr' },
        'উত্তোলন হিসাব': { nature: 'Equity', type: 'Dr' },
        'বিক্রয় হিসাব': { nature: 'Revenue', type: 'Cr' },
        'প্রাপ্ত কমিশন হিসাব': { nature: 'Revenue', type: 'Cr' },
        'বিনিয়োগের সুদ হিসাব': { nature: 'Revenue', type: 'Cr' }
    };

    function detectNature(input, idx) {
        const value = input.value.trim();
        const rowEl = document.querySelector(`.entry-row[data-row-idx="${idx}"]`);
        if(!rowEl) return;
        
        const mapData = accountNatureMap[value];
        if (mapData) {
            const natureSelect = rowEl.querySelector('.val-nature');
            const typeSelect = rowEl.querySelector('.val-type');
            if(natureSelect) natureSelect.value = mapData.nature;
            if(typeSelect) typeSelect.value = mapData.type;
        }
    }
</script>


<style>
    .btn-outline-indigo {
        border-color: #818cf8;
        color: #818cf8;
    }
    .btn-outline-indigo:hover {
        background: #818cf8;
        color: #fff;
    }
</style>
@endsection
