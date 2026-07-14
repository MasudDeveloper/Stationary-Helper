<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন প্যানেল - @yield('title', 'সহজ কাজ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        /* Admin custom overrides for distinct branding */
        :root {
            --primary-color: #3b82f6; /* Admin theme color - sleek blue */
            --primary-hover: #2563eb;
            --primary-glow: rgba(59, 130, 246, 0.15);
        }
        
        .admin-sidebar {
            width: 280px;
            background-color: #0f172a;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            padding: 24px 16px;
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

        .admin-link:hover, .admin-link.active {
            background-color: rgba(59, 130, 246, 0.08);
            color: var(--primary-color);
        }

        .admin-link.active {
            box-shadow: inset 3px 0 0 var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar no-print">
            <a href="{{ route('admin.dashboard') }}" class="admin-logo">
                <i class="material-icons-round" style="color: var(--primary-color);">admin_panel_settings</i>
                <span>সহজ কাজ অ্যাডমিন</span>
            </a>
            
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
                    <a href="{{ route('admin.templates.index') }}" class="sidebar-link admin-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
                        <i class="material-icons-round">dashboard_customize</i>টেমপ্লেট ম্যানেজমেন্ট
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
                    <a href="{{ route('dashboard') }}" class="sidebar-link admin-link">
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
        <div class="app-content" style="background-color: #0b0f19;">
            <header class="top-navbar no-print" style="background-color: rgba(15, 23, 42, 0.8);">
                <div style="font-weight: 600; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                    <i class="material-icons-round">security</i> অ্যাডমিন মোড
                </div>
            </header>

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
