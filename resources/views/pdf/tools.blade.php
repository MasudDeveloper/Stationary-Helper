@extends('layouts.app')

@section('title', 'পিডিএফ ও ইমেজ টুলস - penghor.com')

@section('content')
<style>
    .tools-container {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .tools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 40px 20px;
        justify-items: center;
    }

    .tool-card-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 150px;
        text-decoration: none;
        position: relative;
    }

    .tool-squircle {
        width: 120px;
        height: 120px;
        border-radius: 35px; /* Squircle effect */
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
    }

    .tool-squircle i {
        font-size: 3.5rem;
        color: #fff;
    }

    .tool-card-wrapper:hover .tool-squircle {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 15px 25px rgba(0,0,0,0.3);
    }

    .tool-title {
        margin-top: 15px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
        text-align: center;
        line-height: 1.3;
    }

    .tool-card-wrapper:hover .tool-title {
        color: var(--primary-hover);
    }

    /* Gradients matching the image */
    .grad-purple { background: linear-gradient(135deg, #7c3aed, #c084fc); }
    .grad-pink { background: linear-gradient(135deg, #db2777, #f472b6); }
    .grad-red { background: linear-gradient(135deg, #dc2626, #fb7185); }
    .grad-green { background: linear-gradient(135deg, #16a34a, #4ade80); }
    .grad-teal { background: linear-gradient(135deg, #0d9488, #2dd4bf); }
    .grad-cyan { background: linear-gradient(135deg, #0891b2, #22d3ee); }
    .grad-blue { background: linear-gradient(135deg, #2563eb, #60a5fa); }

    /* Star button at bottom right of squircle */
    .star-btn {
        position: absolute;
        bottom: -10px;
        right: -10px;
        width: 32px;
        height: 32px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        border: 2px solid #f1f5f9;
        color: #cbd5e1;
        transition: color 0.3s, transform 0.2s;
        z-index: 2;
    }

    .star-btn i {
        font-size: 1.1rem !important;
        color: inherit !important;
    }

    .tool-card-wrapper:hover .star-btn {
        color: #f59e0b;
        transform: scale(1.1);
    }

    /* Hot Badge */
    .hot-badge {
        position: absolute;
        top: -8px;
        left: -8px;
        background: #ef4444;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.4);
        z-index: 2;
    }

    @media (max-width: 768px) {
        .tool-squircle {
            width: 100px;
            height: 100px;
            border-radius: 28px;
        }
        .tool-squircle i { font-size: 2.8rem; }
        .tools-grid { gap: 30px 15px; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); }
        .tool-title { font-size: 0.75rem; }
    }
</style>

<div class="tools-container">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-size: 2.2rem; font-weight: 700; color: #fff; margin-bottom: 10px;">ছবি ও পিডিএফ টুলস</h2>
        <p style="color: var(--text-muted); font-size: 1rem;">আপনার দৈনন্দিন কাজের জন্য সবচেয়ে দরকারি সকল টুলস একসাথে</p>
    </div>

    <!-- Category Filter Tabs -->
    <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; flex-wrap: wrap;">
        <button onclick="filterTools('all', this)" class="filter-tab active" style="padding: 10px 24px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.2); background: rgba(99, 102, 241, 0.2); color: #fff; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.2rem; color: #818cf8;">grid_view</i> সকল টুলস
        </button>
        <button onclick="filterTools('pdf', this)" class="filter-tab" style="padding: 10px 24px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.2rem; color: #f43f5e;">picture_as_pdf</i> পিডিএফ টুলস ({{ $pdfTools->count() }})
        </button>
        <button onclick="filterTools('image', this)" class="filter-tab" style="padding: 10px 24px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
            <i class="material-icons-round" style="font-size: 1.2rem; color: #10b981;">image</i> ছবি ও ইমেজ টুলস ({{ $imageTools->count() }})
        </button>
    </div>

    <!-- PDF Tools Section -->
    <div id="section-pdf" class="tool-section" style="margin-bottom: 50px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid rgba(244, 63, 94, 0.3); padding-bottom: 12px;">
            <div style="background: rgba(244, 63, 94, 0.15); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f43f5e;">
                <i class="material-icons-round" style="font-size: 1.5rem;">picture_as_pdf</i>
            </div>
            <h3 style="color: #fff; font-size: 1.5rem; font-weight: 700; margin: 0;">পিডিএফ টুলস (PDF Tools)</h3>
        </div>
        <div class="tools-grid">
            @foreach($pdfTools as $tool)
            <a href="{{ $tool->route_name ? route($tool->route_name) : '#' }}" class="tool-card-wrapper">
                @if($tool->is_hot)
                <div class="hot-badge">হট</div>
                @endif
                <div class="tool-squircle {{ $tool->gradient_class }}">
                    <i class="material-icons-round">{{ $tool->icon }}</i>
                    <div class="star-btn"><i class="material-icons-round">star_border</i></div>
                </div>
                <div class="tool-title">{{ $tool->title }}</div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Image Tools Section -->
    <div id="section-image" class="tool-section" style="margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid rgba(16, 185, 129, 0.3); padding-bottom: 12px;">
            <div style="background: rgba(16, 185, 129, 0.15); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #10b981;">
                <i class="material-icons-round" style="font-size: 1.5rem;">image</i>
            </div>
            <h3 style="color: #fff; font-size: 1.5rem; font-weight: 700; margin: 0;">ছবি ও ইমেজ টুলস (Image & Photo Tools)</h3>
        </div>
        <div class="tools-grid">
            @foreach($imageTools as $tool)
            <a href="{{ $tool->route_name ? route($tool->route_name) : '#' }}" class="tool-card-wrapper">
                @if($tool->is_hot)
                <div class="hot-badge">হট</div>
                @endif
                <div class="tool-squircle {{ $tool->gradient_class }}">
                    <i class="material-icons-round">{{ $tool->icon }}</i>
                    <div class="star-btn"><i class="material-icons-round">star_border</i></div>
                </div>
                <div class="tool-title">{{ $tool->title }}</div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<script>
function filterTools(category, btn) {
    document.querySelectorAll('.filter-tab').forEach(t => {
        t.style.background = 'rgba(255,255,255,0.05)';
        t.style.borderColor = 'rgba(255,255,255,0.1)';
        t.style.color = 'var(--text-muted)';
        t.classList.remove('active');
    });
    btn.style.background = 'rgba(99, 102, 241, 0.2)';
    btn.style.borderColor = 'rgba(255,255,255,0.2)';
    btn.style.color = '#fff';
    btn.classList.add('active');

    if(category === 'all') {
        document.getElementById('section-pdf').style.display = 'block';
        document.getElementById('section-image').style.display = 'block';
    } else if(category === 'pdf') {
        document.getElementById('section-pdf').style.display = 'block';
        document.getElementById('section-image').style.display = 'none';
    } else if(category === 'image') {
        document.getElementById('section-pdf').style.display = 'none';
        document.getElementById('section-image').style.display = 'block';
    }
}
</script>

@endsection
