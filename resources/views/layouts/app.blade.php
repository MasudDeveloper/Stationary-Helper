<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'penghor.com')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Material Icons for Modern Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- SweetAlert2 for beautiful popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @auth
    <div class="app-container">
        
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="app-sidebar no-print" id="appSidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('images/logo.png') }}" alt="penghor.com Logo" style="height: 38px; width: auto; object-fit: contain;">
                    <div class="sidebar-logo-title" style="margin: 0; line-height: 1.2;">
                        <span class="text-white" style="font-size: 1.35rem; font-weight: 800; letter-spacing: 0.5px;">penghor</span><span class="text-gradient" style="font-size: 1.35rem; font-weight: 800;">.com</span>
                    </div>
                </div>
                <div class="sidebar-logo-subtitle" style="margin-top: 4px; letter-spacing: 2px;">DIGITAL PLATFORM</div>
            </a>
            
            <ul class="sidebar-menu">
                <li class="sidebar-section-title">মেনু</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="material-icons-round">dashboard</i><span>ড্যাশবোর্ড</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('saved-documents.index') }}" class="sidebar-link {{ request()->routeIs('saved-documents.*') ? 'active' : '' }}" style="background: rgba(79, 70, 229, 0.15); border: 1px solid rgba(79, 70, 229, 0.3); color: #818cf8; font-weight: 700;">
                        <i class="material-icons-round" style="color: #818cf8;">folder_special</i><span>সংরক্ষিত ফাইল (Saved)</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('document.index') }}" class="sidebar-link {{ request()->routeIs('document.index') ? 'active' : '' }}">
                        <i class="material-icons-round">description</i> ডকুমেন্ট এডিটর
                    </a>
                </li>
                <li>
                    <a href="{{ route('cv.index') }}" class="sidebar-link {{ request()->routeIs('cv.index') ? 'active' : '' }}">
                        <i class="material-icons-round">contact_page</i> সিভি মেকার
                    </a>

                    <a href="{{ route('share.index') }}" class="sidebar-link {{ request()->routeIs('share.index') ? 'active' : '' }}">
                        <i class="material-icons-round">share</i> কুইক শেয়ার
                    </a>
                </li>
                <li>
                    <a href="{{ route('photo.index') }}" class="sidebar-link {{ request()->routeIs('photo.index') ? 'active' : '' }}">
                        <i class="material-icons-round">portrait</i><span>ছবি মেকার</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pdf.tools') }}" class="sidebar-link {{ request()->routeIs('pdf.tools') ? 'active' : '' }}">
                        <i class="material-icons-round">build_circle</i><span>ছবি ও পিডিএফ টুলস</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounting.index') }}" class="sidebar-link {{ request()->routeIs('accounting.index') ? 'active' : '' }}">
                        <i class="material-icons-round">account_balance_wallet</i><span>আয়-ব্যয় হিসাব</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('accounting.memo') }}" class="sidebar-link {{ request()->routeIs('accounting.memo') || request()->routeIs('accounting.receipt') ? 'active' : '' }}">
                        <i class="material-icons-round">receipt_long</i><span>ইনভয়েস / ক্যাশ মেমো</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tickets.index') }}" class="sidebar-link {{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'active' : '' }}">
                        <i class="material-icons-round">support_agent</i><span>যোগাযোগ ও হায়ার</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.ai_hub') }}" class="sidebar-link {{ request()->routeIs('design.ai_hub') ? 'active' : '' }}">
                        <i class="material-icons-round">auto_awesome</i> AI Hub
                    </a>

                    <a href="{{ route('ocr.index') }}" class="sidebar-link {{ request()->routeIs('ocr.index') ? 'active' : '' }}">
                        <i class="material-icons-round">document_scanner</i> AI Document OCR
                    </a>
                </li>
                <li>
                    <a href="{{ route('questions.index') }}" class="sidebar-link {{ request()->routeIs('questions.index') || request()->routeIs('questions.create') || request()->routeIs('questions.show') ? 'active' : '' }}">
                        <i class="material-icons-round">quiz</i><span>প্রশ্নপত্র মেকার</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('recharge') }}" class="sidebar-link {{ request()->routeIs('recharge') ? 'active' : '' }}">
                        <i class="material-icons-round">payment</i><span>ক্রেডিট রিচার্জ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('typing-test.index') }}" class="sidebar-link {{ request()->routeIs('typing-test.*') ? 'active' : '' }}">
                        <i class="material-icons-round">keyboard</i><span>টাইপিং স্পিড টেস্ট</span>
                    </a>
                </li>

                @if (Auth::user()->role === 'admin')
                <li class="sidebar-section-title">অ্যাডমিন মোড</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color); border: 1px solid rgba(99, 102, 241, 0.2); font-weight: bold;">
                        <i class="material-icons-round">security</i><span>অ্যাডমিন প্যানেল ⚙️</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Sidebar Ad Slot -->
            @php
                $sidebarAds = \App\Models\LocalAd::where('is_active', true)->where('slot', 'sidebar')->get();
            @endphp
            @if ($sidebarAds->count() === 1)
                @php $ad = $sidebarAds->first(); @endphp
                <div style="padding: 15px; text-align: center;">
                    <a href="{{ $ad->target_url }}" target="_blank">
                        <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: var(--card-shadow);">
                    </a>
                </div>
            @elseif ($sidebarAds->count() > 1)
                <div style="padding: 15px; text-align: center;">
                    <div class="ad-slider-container" id="ad-slider-sidebar" style="position: relative; overflow: hidden; border-radius: 10px; box-shadow: var(--card-shadow); display: inline-block; max-width: 100%; width: 100%;">
                        @foreach ($sidebarAds as $index => $ad)
                        <div class="ad-slide ad-slide-sidebar {{ $index === 0 ? 'active' : '' }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                            <a href="{{ $ad->target_url }}" target="_blank" style="display: block;">
                                <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; width: 100%; height: auto; border-radius: 10px; display: block; margin: 0 auto;">
                            </a>
                        </div>
                        @endforeach
                        <div style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); display: flex; gap: 5px; z-index: 10; background: rgba(0,0,0,0.4); padding: 3px 6px; border-radius: 12px;">
                            @foreach ($sidebarAds as $index => $ad)
                            <span class="ad-dot ad-dot-sidebar {{ $index === 0 ? 'active' : '' }}" style="width: 6px; height: 6px; border-radius: 50%; background: {{ $index === 0 ? '#10b981' : 'rgba(255,255,255,0.4)' }}; transition: all 0.3s; display: inline-block;"></span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Logout form for when user logs out -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </aside>

        <div class="app-content">
            <header class="top-navbar no-print">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="material-icons-round">menu</i>
                </button>
                
                <div style="flex: 1; display: flex; justify-content: flex-start; padding-left: 20px;">
                    <div style="position: relative; width: 100%; max-width: 400px;">
                        <i class="material-icons-round" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1.2rem;">search</i>
                        <input type="text" placeholder="Search tools or files..." style="width: 100%; padding: 10px 20px 10px 45px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05); background: rgba(255,255,255,0.03); color: #fff; font-size: 0.9rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='rgba(255,255,255,0.05)'">
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 20px;">
                    <div class="credit-badge" style="background: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.3); color: var(--secondary-color);">
                        <i class="material-icons-round" style="font-size: 1.1rem;">account_balance_wallet</i> 
                        <span style="font-weight: bold; font-size: 1rem;" id="credit-balance">{{ Auth::user()->credits }}</span>
                        <span style="font-size: 0.75rem; opacity: 0.8;">ক্রেডিট</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 15px; color: var(--text-muted);">
                        <i class="material-icons-round" style="cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">notifications_none</i>
                        <i class="material-icons-round" style="cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">help_outline</i>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding-left: 10px; border-left: 1px solid rgba(255,255,255,0.1);" onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();" title="Logout">
                        <div style="text-align: right;">
                            <div style="font-size: 0.9rem; font-weight: 600; color: #fff;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2d3748&color=fff&size=40" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                    </div>
                </div>
            </header>

            <div class="content-body">
                @if(!request()->is('login') && !request()->is('register'))
                <!-- Top Ad Slot (Multi-Banner Slider) -->
                <div class="container no-print" style="margin-bottom: 30px; text-align: center;">
                    @php
                        $topAds = \App\Models\LocalAd::where('is_active', true)->where('slot', 'top')->get();
                    @endphp
                    @if ($topAds->count() === 1)
                        @php $ad = $topAds->first(); @endphp
                        <a href="{{ $ad->target_url }}" target="_blank">
                            <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: var(--card-shadow); display: inline-block;">
                        </a>
                    @elseif ($topAds->count() > 1)
                        <div class="ad-slider-container" id="ad-slider-top" style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: var(--card-shadow); display: inline-block; max-width: 100%; width: 100%; background: rgba(0,0,0,0.1);">
                            @foreach ($topAds as $index => $ad)
                            <div class="ad-slide ad-slide-top {{ $index === 0 ? 'active' : '' }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                <a href="{{ $ad->target_url }}" target="_blank" style="display: block;">
                                    <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; width: 100%; height: auto; border-radius: 12px; display: block; margin: 0 auto;">
                                </a>
                            </div>
                            @endforeach
                            <div style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10; background: rgba(0,0,0,0.4); padding: 4px 8px; border-radius: 15px;">
                                @foreach ($topAds as $index => $ad)
                                <span class="ad-dot ad-dot-top {{ $index === 0 ? 'active' : '' }}" style="width: 8px; height: 8px; border-radius: 50%; background: {{ $index === 0 ? '#10b981' : 'rgba(255,255,255,0.4)' }}; transition: all 0.3s; display: inline-block;"></span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                @yield('content')

                @if(!request()->is('login') && !request()->is('register'))
                <!-- Bottom Ad Slot (Multi-Banner Slider) -->
                <div class="container no-print" style="margin-top: 40px; text-align: center;">
                    @php
                        $bottomAds = \App\Models\LocalAd::where('is_active', true)->where('slot', 'bottom')->get();
                    @endphp
                    @if ($bottomAds->count() === 1)
                        @php $ad = $bottomAds->first(); @endphp
                        <a href="{{ $ad->target_url }}" target="_blank">
                            <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: var(--card-shadow); display: inline-block;">
                        </a>
                    @elseif ($bottomAds->count() > 1)
                        <div class="ad-slider-container" id="ad-slider-bottom" style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: var(--card-shadow); display: inline-block; max-width: 100%; width: 100%; background: rgba(0,0,0,0.1);">
                            @foreach ($bottomAds as $index => $ad)
                            <div class="ad-slide ad-slide-bottom {{ $index === 0 ? 'active' : '' }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                <a href="{{ $ad->target_url }}" target="_blank" style="display: block;">
                                    <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->title }}" style="max-width: 100%; width: 100%; height: auto; border-radius: 12px; display: block; margin: 0 auto;">
                                </a>
                            </div>
                            @endforeach
                            <div style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10; background: rgba(0,0,0,0.4); padding: 4px 8px; border-radius: 15px;">
                                @foreach ($bottomAds as $index => $ad)
                                <span class="ad-dot ad-dot-bottom {{ $index === 0 ? 'active' : '' }}" style="width: 8px; height: 8px; border-radius: 50%; background: {{ $index === 0 ? '#10b981' : 'rgba(255,255,255,0.4)' }}; transition: all 0.3s; display: inline-block;"></span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <style>
        @keyframes adFade {
            0% { opacity: 0.3; transform: scale(0.99); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>

    <script>
        function toggleSidebar() {
            document.getElementById('appSidebar').classList.toggle('active');
            document.getElementById('mobileOverlay').classList.toggle('active');
        }

        document.addEventListener("DOMContentLoaded", function() {
            let activeLink = document.querySelector('.sidebar-link.active');
            if(activeLink) {
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // Automatic Multi-Banner Ad Slider
            function initAdSlider(slideClassName, dotClassName, intervalMs = 4000) {
                const slides = document.querySelectorAll('.' + slideClassName);
                const dots = document.querySelectorAll('.' + dotClassName);
                if (slides.length <= 1) return; // Fixed if single banner

                let currentIdx = 0;
                setInterval(() => {
                    slides[currentIdx].style.display = 'none';
                    if (dots[currentIdx]) dots[currentIdx].style.background = 'rgba(255,255,255,0.4)';
                    
                    currentIdx = (currentIdx + 1) % slides.length;
                    
                    slides[currentIdx].style.display = 'block';
                    slides[currentIdx].style.animation = 'adFade 0.8s ease-in-out';
                    if (dots[currentIdx]) dots[currentIdx].style.background = '#10b981';
                }, intervalMs);
            }

            initAdSlider('ad-slide-top', 'ad-dot-top', 4000);
            initAdSlider('ad-slide-bottom', 'ad-dot-bottom', 4000);
            initAdSlider('ad-slide-sidebar', 'ad-dot-sidebar', 4000);
        });
    </script>
</body>
</html>
