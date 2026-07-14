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
                <div class="icon-wrapper">
                    <i class="material-icons-round" style="font-size: 2rem;">storefront</i>
                </div>
                <span class="text-gradient">Smart Stationary</span>
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
                    <a href="{{ route('accounting.calculator') }}" class="sidebar-link {{ request()->routeIs('accounting.calculator') ? 'active' : '' }}">
                        <i class="material-icons-round">calculate</i><span>ক্যাশ ক্যালকুলেটর</span>
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

            <div class="sidebar-user">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div style="flex: 1; min-width: 0;">
                    <p style="font-weight: 600; font-size: 0.95rem; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0;">{{ Auth::user()->name }}</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin: 0; letter-spacing: 0.05em;">{{ Auth::user()->role }}</p>
                </div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--danger); display: flex; align-items: center; padding: 8px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="material-icons-round">logout</i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <div class="app-content">
            <header class="top-navbar no-print">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="material-icons-round">menu</i>
                </button>
                
                <div class="credit-badge">
                    <i class="material-icons-round" style="font-size: 1.2rem;">stars</i> 
                    <span>৳{{ Auth::user()->credits }} ক্রেডিট</span>
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
