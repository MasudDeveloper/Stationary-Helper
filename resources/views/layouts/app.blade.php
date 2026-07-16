<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Stationary')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Material Icons for Modern Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>
<body>
    @auth
    <div class="app-container">
        
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="app-sidebar no-print" id="appSidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div class="sidebar-logo-title">
                    <span class="text-white">Smart</span><span class="text-gradient">Station</span>
                </div>
                <div class="sidebar-logo-subtitle">ADMIN CONSOLE</div>
            </a>
            
            <ul class="sidebar-menu">
                <li class="sidebar-section-title">মেনু</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="material-icons-round">dashboard</i><span>ড্যাশবোর্ড</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('document.index') }}" class="sidebar-link {{ request()->routeIs('document.index') ? 'active' : '' }}">
                        <i class="material-icons-round">description</i><span>ডকুমেন্ট এডিটর</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pdf.editor') }}" class="sidebar-link {{ request()->routeIs('pdf.editor') ? 'active' : '' }}">
                        <i class="material-icons-round">edit_note</i><span>পিডিএফ এডিটর</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pdf.tools') }}" class="sidebar-link {{ request()->routeIs('pdf.tools') ? 'active' : '' }}">
                        <i class="material-icons-round">library_books</i><span>পিডিএফ টুলস</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounting.index') }}" class="sidebar-link {{ request()->routeIs('accounting.index') ? 'active' : '' }}">
                        <i class="material-icons-round">account_balance_wallet</i><span>আয়-ব্যয় হিসাব</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('accounting.receipt') }}" class="sidebar-link {{ request()->routeIs('accounting.receipt') ? 'active' : '' }}">
                        <i class="material-icons-round">receipt</i><span>মানি রিসিট</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounting.memo') }}" class="sidebar-link {{ request()->routeIs('accounting.memo') ? 'active' : '' }}">
                        <i class="material-icons-round">article</i><span>ক্যাশ মেমো</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tickets.index') }}" class="sidebar-link {{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'active' : '' }}">
                        <i class="material-icons-round">support_agent</i><span>যোগাযোগ ও হায়ার</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.editor') }}" class="sidebar-link {{ request()->routeIs('design.editor') ? 'active' : '' }}">
                        <i class="material-icons-round">brush</i><span>ডিজাইন এডিটর</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.ai_hub') }}" class="sidebar-link {{ request()->routeIs('design.ai_hub') ? 'active' : '' }}">
                        <i class="material-icons-round">psychology</i><span>এআই হাব</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.ai_templates') }}" class="sidebar-link {{ request()->routeIs('design.ai_templates') || request()->routeIs('design.ai_templates.customize') ? 'active' : '' }}">
                        <i class="material-icons-round">auto_stories</i><span>এআই টেমপ্লেট</span>
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

                @if (Auth::user()->role === 'admin')
                <li class="sidebar-section-title">অ্যাডমিন মোড</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color); border: 1px solid rgba(99, 102, 241, 0.2); font-weight: bold;">
                        <i class="material-icons-round">security</i><span>অ্যাডমিন প্যানেল ⚙️</span>
                    </a>
                </li>
                @endif
            </ul>

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
                        <span>Credits: {{ number_format(Auth::user()->credits) }}</span>
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
                <!-- Top Ad Slot -->
                <div class="container no-print" style="margin-bottom: 30px; text-align: center;">
                    @php
                        $topAd = \App\Models\LocalAd::where('is_active', true)->where('slot', 'top')->first();
                    @endphp
                    @if ($topAd)
                        <a href="{{ $topAd->target_url }}" target="_blank">
                            <img src="{{ asset($topAd->image_path) }}" alt="{{ $topAd->title }}" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: var(--card-shadow);">
                        </a>
                    @endif
                </div>
                @endif

                @yield('content')

                @if(!request()->is('login') && !request()->is('register'))
                <!-- Bottom Ad Slot -->
                <div class="container no-print" style="margin-top: 40px; text-align: center;">
                    @php
                        $bottomAd = \App\Models\LocalAd::where('is_active', true)->where('slot', 'bottom')->first();
                    @endphp
                    @if ($bottomAd)
                        <a href="{{ $bottomAd->target_url }}" target="_blank">
                            <img src="{{ asset($bottomAd->image_path) }}" alt="{{ $bottomAd->title }}" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: var(--card-shadow);">
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <script>
        function toggleSidebar() {
            document.getElementById('appSidebar').classList.toggle('active');
            document.getElementById('mobileOverlay').classList.toggle('active');
        }
    </script>
</body>
</html>
