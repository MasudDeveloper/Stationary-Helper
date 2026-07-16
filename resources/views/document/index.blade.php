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

<div class="container" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 12px; margin-bottom: 8px;">ডকুমেন্ট ও ফর্ম</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">যেকোনো ফর্ম বা দলিল খুব সহজেই তৈরি করুন।</p>
        </div>
        
        <div style="display: flex; gap: 10px; background: rgba(255,255,255,0.05); padding: 5px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('document.index') }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: #fff; background: rgba(255,255,255,0.1); box-shadow: 0 2px 5px rgba(0,0,0,0.2);">সকল ডকুমেন্ট</a>
            <a href="{{ route('document.favorites') }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: var(--text-muted); transition: all 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">আমার প্রিয় <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; color: #f43f5e;">favorite</i></a>
        </div>
    </div>
    
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="padding: 0; overflow-x: auto; border-radius: 12px;">
        <table class="template-table" style="margin-top: 0;">
            <thead style="background: rgba(255,255,255,0.03);">
                <tr>
                    <th style="padding: 18px 24px;">#</th>
                    <th style="padding: 18px 24px;">নাম</th>
                    <th style="padding: 18px 24px;">ক্যাটাগরি</th>
                    <th style="padding: 18px 24px;">ভাষা</th>
                    <th style="padding: 18px 24px;">ফিল্ডস</th>
                    <th style="padding: 18px 24px; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $index => $template)
                <tr style="transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="color: var(--text-muted); padding: 18px 24px;">{{ $index + 1 }}</td>
                    <td style="padding: 18px 24px;">
                        <div style="font-weight: 600; font-size: 1.05rem; margin-bottom: 5px; color: #fff;">
                            {{ $template->name }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.85rem;">{{ $template->description }}</div>
                    </td>
                    <td style="padding: 18px 24px;"><span class="badge badge-yellow" style="font-weight: 500;">{{ $template->category->name ?? 'N/A' }}</span></td>
                    <td style="padding: 18px 24px;"><span class="badge badge-green" style="font-weight: 500;">{{ $template->language }}</span></td>
                    <td style="padding: 18px 24px; color: #e2e8f0; font-weight: 500;">{{ $template->total_fields }}</td>
                    <td style="padding: 18px 24px; text-align: right; display: flex; justify-content: flex-end; gap: 10px; align-items: center; border-bottom: none;">
                        @php
                            $isFavorite = Auth::user()->favoriteDocuments()->where('document_template_id', $template->id)->exists();
                        @endphp
                        <form action="{{ route('document.favorite.toggle', $template->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" title="{{ $isFavorite ? 'ফেভারিট থেকে সরান' : 'ফেভারিটে যুক্ত করুন' }}" style="background: transparent; border: none; cursor: pointer; padding: 5px; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="material-icons-round" style="font-size: 1.5rem; color: {{ $isFavorite ? '#f43f5e' : 'rgba(255,255,255,0.2)' }};">{{ $isFavorite ? 'favorite' : 'favorite_border' }}</i>
                            </button>
                        </form>
                        <a href="{{ route('document.fill', $template->id) }}" class="btn" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 8px 16px; font-size: 0.85rem; border-radius: 8px; font-weight: 600;">
                            <i class="material-icons-round" style="font-size: 1.1rem; vertical-align: middle;">edit</i> তৈরি করুন
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                        <i class="material-icons-round" style="font-size: 3rem; color: #334155; margin-bottom: 15px; display: block;">description</i>
                        কোনো ডকুমেন্ট পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
