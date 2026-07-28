@extends('layouts.app')

@section('title', 'সংরক্ষিত ডকুমেন্ট ও সিভি - penghor.com')

@section('content')
<style>
    .template-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .template-table th, .template-table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; }
    .template-table th { color: var(--text-muted); font-weight: 500; border-bottom: 2px solid rgba(255,255,255,0.1); }
    .badge { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; }
    .badge-yellow { background: rgba(234, 179, 8, 0.1); color: #eab308; }
    .badge-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .badge-purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 12px; margin-bottom: 8px;">সংরক্ষিত ডকুমেন্ট ও সিভি</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">আপনার পূর্বে পূরণকৃত ও সংরক্ষিত সকল ফাইল এখানে রয়েছে।</p>
        </div>
        
        <div style="display: flex; gap: 10px; background: rgba(255,255,255,0.05); padding: 5px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('saved-documents.index') }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: {{ !$type ? '#fff' : 'var(--text-muted)' }}; background: {{ !$type ? 'rgba(255,255,255,0.1)' : 'transparent' }};">সকল ফাইল</a>
            <a href="{{ route('saved-documents.index', ['type' => 'document']) }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: {{ $type == 'document' ? '#fff' : 'var(--text-muted)' }}; background: {{ $type == 'document' ? 'rgba(255,255,255,0.1)' : 'transparent' }};">শুধু ডকুমেন্ট</a>
            <a href="{{ route('saved-documents.index', ['type' => 'cv']) }}" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; color: {{ $type == 'cv' ? '#fff' : 'var(--text-muted)' }}; background: {{ $type == 'cv' ? 'rgba(255,255,255,0.1)' : 'transparent' }};">শুধু সিভি</a>
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
                    <th style="padding: 18px 24px;">শিরোনাম (Title)</th>
                    <th style="padding: 18px 24px;">টাইপ (Type)</th>
                    <th style="padding: 18px 24px;">সংরক্ষণের সময়</th>
                    <th style="padding: 18px 24px; text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($savedDocuments as $index => $doc)
                <tr style="transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="color: var(--text-muted); padding: 18px 24px;">{{ $savedDocuments->firstItem() + $index }}</td>
                    <td style="padding: 18px 24px;">
                        <div style="font-weight: 600; font-size: 1.05rem; margin-bottom: 5px; color: #fff;">
                            {{ $doc->title }}
                        </div>
                    </td>
                    <td style="padding: 18px 24px;">
                        @if($doc->type === 'cv')
                            <span class="badge badge-purple" style="font-weight: 500;">সিভি (CV)</span>
                        @else
                            <span class="badge badge-blue" style="font-weight: 500;">ডকুমেন্ট (Document)</span>
                        @endif
                    </td>
                    <td style="padding: 18px 24px; color: var(--text-muted);">
                        {{ $doc->created_at->format('d M, Y - h:i A') }}
                    </td>
                    <td style="padding: 18px 24px; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 10px; align-items: center;">
                            <a href="{{ route('saved-documents.show', $doc->id) }}" class="btn-primary" style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; background: #3b82f6; color: #fff;">
                                <i class="material-icons-round" style="font-size: 1rem;">open_in_new</i> খুলুন / প্রিন্ট
                            </a>
                            
                            <form action="{{ route('saved-documents.delete', $doc->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ফাইলটি মুছে ফেলতে চান?');" style="margin: 0;">
                                @csrf
                                <button type="submit" style="padding: 8px 12px; border-radius: 6px; background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); cursor: pointer; display: inline-flex; align-items: center;" title="মুছে ফেলুন">
                                    <i class="material-icons-round" style="font-size: 1.1rem;">delete</i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        কোনো সংরক্ষিত ডকুমেন্ট বা সিভি পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        {{ $savedDocuments->links() }}
    </div>
</div>
@endsection
