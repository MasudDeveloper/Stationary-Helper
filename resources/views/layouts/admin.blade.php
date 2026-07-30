<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন প্যানেল - @yield('title', 'সহজ কাজ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- SweetAlert2 for beautiful popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Admin custom overrides for distinct branding */
        :root {
            --primary-color: #6366f1; /* Vibrant Indigo */
            --primary-hover: #4f46e5;
            --primary-glow: rgba(99, 102, 241, 0.3);
            --bg-color: #0b0f19;
        }
        
        .admin-sidebar {
            width: 280px;
            background: #0f172a; /* Solid color to replace translucent+blur */
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 24px 16px;
            transition: left 0.3s ease;
        }

        .app-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                left: -320px;
            }
            .admin-sidebar.active {
                left: 0;
            }
            .app-content {
                margin-left: 0;
            }
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            margin-bottom: 35px;
            padding-left: 8px;
        }

        .admin-logo span {
            color: var(--primary-color);
        }

        .admin-sidebar .sidebar-link {
            color: #cbd5e1; /* Brighter text for better contrast */
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .admin-link:hover, .admin-link.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, transparent 100%);
            color: #ffffff;
        }

        .admin-link.active {
            border-left: 4px solid var(--primary-color);
            border-radius: 0 8px 8px 0;
            box-shadow: inset 20px 0 30px -20px var(--primary-glow);
        }

        .admin-link i {
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .admin-link:hover i, .admin-link.active i {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>

        <!-- Admin Sidebar -->
        <aside class="admin-sidebar no-print" id="appSidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-logo">
                <i class="material-icons-round" style="color: var(--primary-color);">admin_panel_settings</i>
                <span>সহজ কাজ অ্যাডমিন</span>
            </a>
            <button class="mobile-menu-btn" onclick="toggleSidebar()" style="position: absolute; right: 15px; top: 15px; display: none; background: transparent; border: none; color: var(--text-muted); cursor: pointer;" id="closeSidebarBtn">
                <i class="material-icons-round">close</i>
            </button>
            
            <ul class="sidebar-menu">
                <li class="sidebar-section-title">কন্ট্রোল সেন্টার</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="material-icons-round">analytics</i>ড্যাশবোর্ড
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payments') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                        <i class="material-icons-round">payments</i>পেমেন্ট রিকোয়েস্ট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.business_upgrades') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.business_upgrades') ? 'active' : '' }}">
                        <i class="material-icons-round">storefront</i>বিজনেস আপগ্রেড
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="material-icons-round">assignment</i>অর্ডার ম্যানেজমেন্ট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.recharge-packages.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.recharge-packages.*') ? 'active' : '' }}">
                        <i class="material-icons-round">inventory_2</i>রিচার্জ প্যাকেজ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.templates.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.templates.*') || request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="material-icons-round">dashboard_customize</i>ডকুমেন্ট টেমপ্লেট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cv-templates.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.cv-templates.*') ? 'active' : '' }}">
                        <i class="material-icons-round">contact_page</i>সিভি টেমপ্লেট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.typing-test.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.typing-test.*') ? 'active' : '' }}">
                        <i class="material-icons-round">keyboard</i>টাইপিং টেস্ট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tickets') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.tickets') || request()->routeIs('admin.tickets.show') ? 'active' : '' }}">
                        <i class="material-icons-round">forum</i>টিকিট ম্যানেজমেন্ট
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ads') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.ads') ? 'active' : '' }}">
                        <i class="material-icons-round">campaign</i>বিজ্ঞাপন কন্ট্রোল
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ai_templates') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.ai_templates') ? 'active' : '' }}">
                        <i class="material-icons-round">collections</i>এআই টেমপ্লেট কন্ট্রোল
                    </a>
                </li>

                <li class="sidebar-section-title">ন্যাভিগেশন</li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="material-icons-round">settings</i> Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link mt-4" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                        <i class="material-icons-round">arrow_back</i>মূল সাইটে যান
                    </a>
                </li>
            </ul>

            <div class="sidebar-user">
                <div class="user-avatar" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div style="flex: 1; min-width: 0;">
                    <p style="font-weight: 600; font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0; color: #fff;">{{ Auth::user()->name }}</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin: 0;">অ্যাডমিনিস্ট্রেটর</p>
                </div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--danger); display: flex; align-items: center;">
                    <i class="material-icons-round">logout</i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Admin Content Area -->
        <div class="app-content" style="background-color: var(--bg-color);">
            <header class="top-navbar no-print" style="background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div style="font-weight: 600; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()" style="margin-right: 15px;">
                        <i class="material-icons-round">menu</i>
                    </button>
                    <i class="material-icons-round">security</i> অ্যাডমিন মোড
                </div>
            </header>

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    
    <style>
        @media (max-width: 1024px) {
            #closeSidebarBtn {
                display: block !important;
            }
        }
    </style>
    <script>
        function toggleSidebar() {
            document.getElementById('appSidebar').classList.toggle('active');
            document.getElementById('mobileOverlay').classList.toggle('active');
        }

        document.addEventListener("DOMContentLoaded", function() {
            let activeLink = document.querySelector('.admin-link.active');
            if(activeLink) {
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
</body>
</html>
