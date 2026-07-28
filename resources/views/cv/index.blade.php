@extends('layouts.app')

@section('title', 'সিভি মেকার - penghor.com')

@section('content')
<div class="content-header" style="margin-top: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 15px;">
    <div>
        <h2 style="color: #fff; margin: 0; font-size: 2rem; font-weight: 700;">সিভি মেকার</h2>
        <p style="color: var(--text-muted); margin: 8px 0 0 0; font-size: 1rem;">প্রফেশনাল সিভি তৈরি করুন সহজেই</p>
    </div>
    <div style="display: flex; gap: 10px; background: rgba(255,255,255,0.05); padding: 5px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); flex-wrap: wrap;">
        <a href="{{ route('cv.index') }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: #fff; background: rgba(255,255,255,0.1); box-shadow: 0 2px 5px rgba(0,0,0,0.2);">সকল সিভি</a>
        <a href="{{ route('saved-documents.index', ['type' => 'cv']) }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: #818cf8; background: rgba(79, 70, 229, 0.15); border: 1px solid rgba(79, 70, 229, 0.3); transition: all 0.2s;">সংরক্ষিত সিভি <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle;">folder_special</i></a>
    </div>
</div>

<div class="grid-3" style="gap: 20px;">
    @forelse($templates as $template)
        <div class="glass glass-interactive" style="padding: 25px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div style="background: rgba(99, 102, 241, 0.1); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #818cf8;">
                        <i class="material-icons-round" style="font-size: 1.8rem;">contact_page</i>
                    </div>
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                        {{ $template->credit_cost }} Credits
                    </div>
                </div>
                
                <h3 style="color: #fff; margin: 0 0 10px 0; font-size: 1.2rem; font-weight: 600;">{{ $template->name }}</h3>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px;">
                    <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem;">
                        <i class="material-icons-round" style="font-size: 0.9rem; vertical-align: middle; margin-right: 4px;">language</i>
                        {{ strtoupper($template->language) }}
                    </span>
                    <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem;">
                        <i class="material-icons-round" style="font-size: 0.9rem; vertical-align: middle; margin-right: 4px;">article</i>
                        {{ $template->format ?? 'Standard' }}
                    </span>
                    @if($template->design_name)
                    <span style="background: rgba(255,255,255,0.05); color: var(--text-muted); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem;">
                        <i class="material-icons-round" style="font-size: 0.9rem; vertical-align: middle; margin-right: 4px;">palette</i>
                        {{ $template->design_name }}
                    </span>
                    @endif
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <a href="{{ route('cv.fill', $template->id) }}" class="btn w-100" style="background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 12px; border-radius: 8px; font-weight: 600;">
                    এই ফরম্যাটটি ব্যবহার করুন
                </a>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; padding: 50px; text-align: center; background: rgba(255,255,255,0.02); border-radius: 15px; border: 1px dashed rgba(255,255,255,0.1);">
            <i class="material-icons-round" style="font-size: 4rem; color: var(--text-muted); margin-bottom: 15px;">contact_page</i>
            <h3 style="color: #fff; margin-bottom: 10px;">কোনো সিভি টেমপ্লেট পাওয়া যায়নি</h3>
            <p style="color: var(--text-muted);">অ্যাডমিন প্যানেল থেকে সিভি টেমপ্লেট যোগ করা হলে এখানে দেখাবে।</p>
        </div>
    @endforelse
</div>
@endsection
