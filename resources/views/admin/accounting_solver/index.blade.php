@extends('layouts.admin')

@section('title', 'হিসাববিজ্ঞান সমাধানকারী কন্ট্রোল প্যানেল')

@section('content')
<style>
    /* Premium glass accordion and modern table resets */
    .solver-accordion .accordion-item {
        background: rgba(30, 41, 59, 0.45) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        margin-bottom: 20px !important;
        overflow: hidden;
        backdrop-filter: blur(15px);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
    }
    
    .solver-accordion .accordion-button {
        background: transparent !important;
        color: #f8fafc !important;
        font-size: 1.1rem;
        font-weight: 700;
        padding: 22px 25px;
        box-shadow: none !important;
    }
    
    .solver-accordion .accordion-button:not(.collapsed) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .solver-accordion .accordion-button::after {
        filter: invert(1);
    }

    .admin-table {
        margin-bottom: 0;
    }
    
    .admin-table th {
        background: rgba(15, 23, 42, 0.3) !important;
        color: #94a3b8 !important;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .admin-table td {
        padding: 18px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #e2e8f0;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }
    
    .btn-action-edit {
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        color: #818cf8;
    }
    .btn-action-edit:hover {
        background: #6366f1;
        color: #fff;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #f87171;
    }
    .btn-action-delete:hover {
        background: #ef4444;
        color: #fff;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
</style>

<div class="content-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="text-white fw-bold mb-1">হিসাববিজ্ঞান সমাধানকারী অনুশীলনী</h2>
            <p class="text-muted">অধ্যায়ভিত্তিক অনুশীলনী যোগ করুন ও পরিচালনা করুন</p>
        </div>
        <a href="{{ route('admin.accounting-solver.create') }}" class="btn" style="background: linear-gradient(135deg, var(--primary-color), #4f46e5); color: #fff; font-weight: 600; padding: 12px 24px; border-radius: 12px; box-shadow: 0 4px 15px var(--primary-glow); border: none;">
            <i class="material-icons-round align-middle me-1">add</i> অনুশীলনী তৈরি করুন
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success bg-emerald-500/10 border-emerald-500/30 text-emerald-400 p-4 rounded-xl mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="solver-accordion" id="chaptersAccordion">
    @forelse($lessons as $lesson)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{ $lesson->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $lesson->id }}" aria-expanded="false" aria-controls="collapse-{{ $lesson->id }}">
                    অধ্যায় {{ $lesson->chapter_no }} : {{ $lesson->title }} ({{ $lesson->exercises->count() }}টি অনুশীলনী)
                </button>
            </h2>
            <div id="collapse-{{ $lesson->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $lesson->id }}" data-bs-parent="#chaptersAccordion">
                <div class="accordion-body p-4">
                    <p class="text-sm text-slate-400 mb-4">{{ $lesson->description }}</p>
                    
                    @if($lesson->exercises->count() > 0)
                        <div class="table-responsive" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.08);">
                            <table class="table table-dark table-hover admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">অনুশীলনী নাম</th>
                                        <th style="width: 60%;">প্রশ্ন বিবরণী (Stimulus)</th>
                                        <th class="text-end" style="width: 15%;">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lesson->exercises as $exercise)
                                        <tr>
                                            <td class="align-middle fw-semibold text-white">{{ $exercise->title }}</td>
                                            <td class="align-middle text-sm text-slate-400">{!! Str::limit(strip_tags($exercise->stimulus), 120) !!}</td>
                                            <td class="align-middle text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('admin.accounting-solver.edit', $exercise->id) }}" class="btn-action btn-action-edit" title="সম্পাদনা">
                                                        <i class="material-icons-round fs-5">edit</i>
                                                    </a>
                                                    <form action="{{ route('admin.accounting-solver.destroy', $exercise->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত এটি মুছতে চান?')" class="m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action btn-action-delete" title="মুছে ফেলুন">
                                                            <i class="material-icons-round fs-5">delete</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-slate-500 bg-slate-900/20 rounded-xl border border-dashed border-slate-800">কোনো অনুশীলনী যোগ করা হয়নি।</div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-slate-500">অধ্যায় ডেটা লোড করা সম্ভব হয়নি।</div>
    @endforelse
</div>
@endsection
