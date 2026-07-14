@extends('layouts.app')

@section('title', 'ডকুমেন্ট ও ফর্ম - Smart Stationary')

@section('content')
<style>
    .template-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .template-table th, .template-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; }
    .template-table th { color: var(--text-muted); font-weight: 500; border-bottom: 2px solid rgba(255,255,255,0.1); }
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; }
    .badge-yellow { background: rgba(234, 179, 8, 0.1); color: #eab308; }
    .badge-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1200px;">
    <div style="margin-bottom: 30px;">
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">ডকুমেন্ট ও ফর্ম</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">যেকোনো ফর্ম বা দলিল খুব সহজেই তৈরি করুন।</p>
    </div>

    <div class="glass" style="padding: 20px; overflow-x: auto;">
        <table class="template-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>নাম</th>
                    <th>ক্যাটাগরি</th>
                    <th>ভাষা</th>
                    <th>ফিল্ডস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $index => $template)
                <tr>
                    <td style="color: var(--text-muted);">{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: bold; font-size: 1.1rem; margin-bottom: 5px;">
                            <i class="material-icons-round" style="font-size: 1.1rem; color: var(--primary-color); vertical-align: middle;">star_border</i>
                            {{ $template->name }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">{{ $template->description }}</div>
                    </td>
                    <td><span class="badge badge-yellow">{{ $template->category->name ?? 'N/A' }}</span></td>
                    <td><span class="badge badge-green">{{ $template->language }}</span></td>
                    <td>{{ $template->total_fields }}</td>
                    <td>
                        <a href="{{ route('document.fill', $template->id) }}" class="btn btn-primary" style="padding: 8px 15px; font-size: 0.9rem; border-radius: 20px;">
                            <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">edit</i> তৈরি করুন
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
