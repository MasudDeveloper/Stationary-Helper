@extends('layouts.admin')

@section('title', 'ইংরেজি গ্রামার সলভার কন্ট্রোল')

@section('content')
<div class="content-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h2 class="text-white fw-bold">ইংরেজি গ্রামার সলভার কন্ট্রোল ⚙️</h2>
        <p class="text-muted">Class 3 থেকে Class 10 এর ইংরেজি গ্রামার কারিকুলাম ও কুইজ প্রশ্নাবলী ম্যানেজ করুন।</p>
    </div>
    <div>
        <a href="{{ route('admin.grammar-lessons.create') }}" class="btn btn-primary d-flex align-items-center gap-1 rounded-xl px-4 py-2" style="background-color: var(--primary-color); border: none;">
            <i class="material-icons-round">add</i>
            <span>নতুন লেভেল যোগ করুন</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 bg-emerald-500/10 text-emerald-400 rounded-xl mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="glass p-4 rounded-2xl">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
            <thead>
                <tr class="text-muted" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <th class="py-3" style="width: 80px;">লেভেল নং</th>
                    <th class="py-3">ক্যাটাগরি / ক্লাস গ্রুপ</th>
                    <th class="py-3">লেভেল শিরোনাম</th>
                    <th class="py-3 text-center" style="width: 100px;">প্রশ্ন সংখ্যা</th>
                    <th class="py-3 text-center" style="width: 100px;">অবস্থা</th>
                    <th class="py-3 text-end" style="width: 250px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                        <td class="py-3 fw-bold text-indigo-400">#{{ $lesson->level_no }}</td>
                        <td class="py-3 text-slate-300 small">{{ $lesson->category }}</td>
                        <td class="py-3 text-white fw-semibold">{{ $lesson->level_name }}</td>
                        <td class="py-3 text-center text-slate-300">
                            <span class="badge bg-slate-800 text-slate-400 border border-slate-700">{{ $lesson->exercises_count }}টি</span>
                        </td>
                        <td class="py-3 text-center">
                            @if($lesson->is_active)
                                <span class="badge bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                            @else
                                <span class="badge bg-red-500/10 text-red-400 border border-red-500/20">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.grammar-lessons.exercises', $lesson->id) }}" class="btn btn-sm btn-outline-info rounded-lg d-flex align-items-center gap-1" title="কুইজ প্রশ্ন সমূহ">
                                    <i class="material-icons-round" style="font-size: 0.95rem;">quiz</i>
                                    <span>কুইজ ({{ $lesson->exercises_count }})</span>
                                </a>
                                <a href="{{ route('admin.grammar-lessons.edit', $lesson->id) }}" class="btn btn-sm btn-outline-warning rounded-lg d-flex align-items-center gap-1" title="সম্পাদনা">
                                    <i class="material-icons-round" style="font-size: 0.95rem;">edit</i>
                                    <span>এডিট</span>
                                </a>
                                <form action="{{ route('admin.grammar-lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this level? All questions will be permanently deleted!')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-lg d-flex align-items-center gap-1" title="মুছে ফেলুন">
                                        <i class="material-icons-round" style="font-size: 0.95rem;">delete</i>
                                        <span>ডিলিট</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="material-icons-round" style="font-size: 3rem;">spellcheck</i>
                            <p class="mt-2 mb-0">কোনো লেভেল পাওয়া যায়নি। নতুন লেভেল যোগ করুন।</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
