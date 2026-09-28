<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Orang Tua — Jurnal SMEA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-active: #eef2ff;
            --sidebar-text: #475569;
            --sidebar-text-active: #0f172a;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --sidebar-width: 224px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar Navigation: Full Height, Compact, Non-Scrollable */
        .sidebar {
            width: 224px;
            min-width: 224px;
            max-width: 224px;
            background: #ffffff;
            border-right: 1px solid rgba(226, 232, 240, 0.85);
            border-left: 1px solid rgba(226, 232, 240, 0.85);
            border-top: none;
            border-bottom: none;
            box-shadow: 2px 0 12px -2px rgba(0, 0, 0, 0.04);
            color: #1e293b;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 10px;
            bottom: 0;
            height: 100vh;
            max-height: 100vh;
            border-radius: 0;
            overflow: hidden;
            box-sizing: border-box;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-content {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 8px 10px 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon {
            width: 100%;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
            padding: 0;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon img {
            width: 58px;
            max-width: 62px;
            height: auto;
            object-fit: contain;
            transition: transform 0.2s;
        }

        .sidebar-brand .logo-text {
            display: none;
        }

        .sidebar-menu {
            padding: 0 8px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
            scrollbar-width: none;
        }

        .sidebar-menu::-webkit-scrollbar {
            display: none;
        }

        .menu-category {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 4px 6px 2px 6px;
            flex-shrink: 0;
        }

        .menu-category:first-child {
            padding-top: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 34px;
            padding: 0 8px;
            box-sizing: border-box;
            color: #475569;
            text-decoration: none;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .nav-item i,
        .nav-item svg {
            font-size: 15px;
            width: 18px;
            text-align: center;
            color: #94a3b8;
            transition: color 0.2s ease;
            flex-shrink: 0;
        }

        .nav-item span:not(.badge):not(.badge-count) {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-item:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .nav-item:hover i,
        .nav-item:hover svg {
            color: #2563eb;
        }

        .nav-item.active {
            color: #0f172a;
            background: #eef2ff;
            font-weight: 700;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            bottom: 5px;
            width: 3.5px;
            background-color: #2563eb;
            border-top-right-radius: 9999px;
            border-bottom-right-radius: 9999px;
        }

        .nav-item.active i,
        .nav-item.active svg {
            color: #1e293b;
        }

        .nav-item .badge,
        .nav-item .badge-count {
            margin-left: auto;
            flex-shrink: 0;
            line-height: 1.2;
        }

        /* Sidebar Bottom Profile & Controls */
        .sidebar-footer {
            padding: 6px 10px;
            border-top: 1px solid #f1f5f9;
            background: #ffffff;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
            margin-top: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            padding: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 11px;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.15);
        }

        .user-info {
            overflow: hidden;
            min-width: 0;
        }

        .user-info .name,
        .user-info .user-name {
            font-size: 11.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .user-info .role,
        .user-info .user-role {
            font-size: 9px;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1px;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            padding-top: 0;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4px 6px;
            height: 30px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-family: inherit;
            box-sizing: border-box;
        }

        .btn-footer-action.btn-icon-only {
            width: 30px;
            height: 30px;
            padding: 0;
            flex: 0 0 30px;
            font-size: 11px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            border-radius: 7px;
        }

        .btn-footer-action.btn-icon-only:hover {
            background: #f8fafc;
            color: #2563eb;
            border-color: #cbd5e1;
        }

        .btn-footer-action.btn-logout {
            color: #e11d48;
            background: #fff1f2;
            flex: 1;
        }

        .btn-footer-action.btn-logout:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .btn-footer-action.active {
            background: #eef2ff;
            color: #2563eb;
            border-color: #c7d2fe;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 234px;
            width: calc(100% - 234px);
            max-width: calc(100% - 234px);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            padding: 0 10px 3.5rem 10px;
            background-color: rgba(248, 250, 252, 0.6);
            box-sizing: border-box;
        }

        /* Topbar Header Container */
        .topbar, .header {
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-top: none;
            border-radius: 0 0 14px 14px;
            padding: 8px 18px;
            min-height: 52px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
            margin: 0 auto 20px auto;
            position: sticky;
            top: 0;
            z-index: 80;
            backdrop-filter: blur(8px);
            box-sizing: border-box;
        }

        .topbar-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .title-section,
        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 0 1 auto;
            min-width: 0;
        }

        .title-section h1,
        .header-title h1,
        .page-header-main-title {
            font-size: 17px !important;
            font-weight: 700 !important;
            color: #0f2744 !important;
            letter-spacing: -0.01em !important;
            line-height: 1.2 !important;
            margin: 0 !important;
        }

        .title-section p,
        .header-title p,
        .page-header-sub-title {
            font-size: 11px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            margin: 1px 0 0 0 !important;
            line-height: 1.2 !important;
        }

        .title-section-content {
            min-width: 0;
            flex: 0 1 auto;
        }

        .header-controls {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            width: fit-content;
        }

        .header-control {
            flex: 0 0 auto;
            box-sizing: border-box;
        }

        .btn-mobile-sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .btn-mobile-sidebar-toggle:hover {
            background: #f1f5f9;
            color: #2563eb;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            z-index: 95;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.active {
            display: block;
            opacity: 1;
        }

        /* 3 Header Compact Containers - Final Clean Implementation */
        .ta-selector.academic-year.header-control,
        .academic-year,
        .ta-selector {
            width: 220px;
            min-width: 220px;
            max-width: 220px;
            flex: 0 0 220px;
            height: 36px;
            padding: 0 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            white-space: nowrap;
            box-sizing: border-box;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .ta-selector.academic-year.header-control:hover,
        .academic-year:hover,
        .ta-selector:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .academic-year i.fa-graduation-cap,
        .ta-selector i.fa-graduation-cap {
            font-size: 13px;
            color: #475569;
            flex-shrink: 0;
            margin-right: 5px;
        }

        .academic-year span,
        .ta-selector span {
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .academic-year i.fa-chevron-down,
        .ta-selector i.fa-chevron-down {
            font-size: 9px;
            color: #94a3b8;
            margin-left: auto;
            flex-shrink: 0;
        }

        .live-clock-card.date-time.header-control,
        .date-time,
        .live-clock-card {
            width: 220px;
            min-width: 220px;
            max-width: 220px;
            flex: 0 0 220px;
            height: 36px;
            padding: 0 8px;
            box-sizing: border-box;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .live-clock-wrapper {
            display: contents !important;
        }

        /* Content Area */
        .content-body {
            padding: 0;
            flex: 1;
            width: 100%;
            margin: 0 auto;
        }

        /* Alert notifications */
        .alert,
        .alert-custom {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            font-weight: 600;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Universal Modern Pagination Styles */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            width: 100%;
        }

        .pagination-container nav,
        .pagination-bar nav,
        nav[role="navigation"] {
            display: flex !important;
            align-items: center !important;
            gap: 6px;
        }

        .pagination-container nav > div:first-child:not(:only-child),
        .pagination-bar nav > div:first-child,
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }

        .pagination-container nav svg,
        .pagination-bar nav svg,
        nav[role="navigation"] svg {
            width: 14px;
            height: 14px;
            display: inline-block;
            vertical-align: middle;
        }

        .pagination-container nav a,
        .pagination-container nav span[aria-current="page"] > span,
        .pagination-container nav span[aria-disabled="true"] > span,
        .pagination-container nav > div:last-child span,
        .pagination-container nav > div:last-child a,
        .pagination-bar nav span,
        .pagination-bar nav a,
        nav[role="navigation"] span,
        nav[role="navigation"] a,
        .pagination-list .page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            line-height: 1;
        }

        .pagination-container nav a:hover,
        .pagination-bar nav a:hover,
        nav[role="navigation"] a:hover,
        .pagination-list .page-item:not(.active):not(.disabled) .page-link:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .pagination-container nav span[aria-current="page"] > span,
        .pagination-container nav .active > span,
        .pagination-bar nav span[aria-current="page"],
        nav[role="navigation"] span[aria-current="page"],
        .pagination-list .page-item.active .page-link {
            background: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        .pagination-container nav span[aria-disabled="true"] > span,
        .pagination-bar nav span[aria-disabled="true"],
        nav[role="navigation"] span[aria-disabled="true"],
        .pagination-list .page-item.disabled .page-link {
            color: #94a3b8 !important;
            background: #f8fafc !important;
            border-color: #f1f5f9 !important;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .pagination-list {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        @media (max-width: 1024px) {
            .sidebar {
                left: 0;
                transform: translateX(-100%);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                z-index: 1050;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 10px;
                padding-right: 10px;
                padding-top: 0;
            }
            .topbar {
                top: 0;
                margin-bottom: 16px;
                padding: 8px 14px;
                border-radius: 0 0 12px 12px;
            }
            .btn-mobile-sidebar-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 900px) {
            .topbar-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .header-controls {
                margin-left: 0;
                width: 100%;
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 2px;
                gap: 8px;
                -webkit-overflow-scrolling: touch;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 12px 14px;
            }
            .title-section {
                width: 100%;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Backdrop for Mobile Sidebar -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-content">
            <!-- Brand Header -->
            <div class="sidebar-brand">
                <div class="logo-icon">
                    <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
                </div>
            </div>

            <!-- Menus -->
            <nav class="sidebar-menu">
                <div class="menu-category">UTAMA</div>

                <a href="{{ route('orang-tua.dashboard') }}" class="nav-item {{ request()->routeIs('orang-tua.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i>
                    <span>Dashboard Orang Tua</span>
                </a>

                <a href="{{ route('orang-tua.monitoring-presensi') }}" class="nav-item {{ request()->routeIs('orang-tua.monitoring-presensi') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-viewfinder"></i>
                    <span>Monitoring Presensi</span>
                    <span class="badge" style="margin-left: auto; background: #22c55e; color: #ffffff; font-size: 9px; font-weight: 800; padding: 1px 6px; border-radius: 12px; letter-spacing: 0.5px; text-transform: uppercase;">
                        LIVE
                    </span>
                </a>

                <div class="menu-category">DATA MASTER</div>

                <a href="{{ route('orang-tua.data-anak') }}" class="nav-item {{ request()->routeIs('orang-tua.data-anak') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Data Anak</span>
                </a>

                <a href="{{ route('orang-tua.izin') }}" class="nav-item {{ request()->routeIs('orang-tua.izin') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Izin</span>
                </a>

                <a href="{{ route('orang-tua.laporan') }}" class="nav-item {{ request()->routeIs('orang-tua.laporan') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Laporan Kehadiran</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar" style="overflow: hidden;">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="name" title="{{ Auth::user()->name ?? 'Orang Tua' }}">{{ Auth::user()->name ?? 'Orang Tua' }}</div>
                    <div class="role">ROLE: {{ strtoupper(Auth::user()->role_label ?? 'ORANG TUA') }}</div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="btn-footer-action btn-logout" title="Keluar dari sistem" style="width:100%;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" title="Pengaturan">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('customer-service.*') ? 'active' : '' }}" title="Customer Service & Bantuan">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-container">
                <div class="title-section header-title">
                    <button type="button" class="btn-mobile-sidebar-toggle" onclick="toggleSidebar()" aria-label="Buka Menu Navigasi" title="Menu Navigasi">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="title-section-content">
                        @yield('topbar_left')
                    </div>
                </div>

                <div class="header-controls">
                    <div class="ta-selector academic-year header-control">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2025/2026' }} – Semester {{ $activeTahunAjaran->semester ?? 'Genap' }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    @include('partials.live-clock')
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('open');
            if (backdrop) backdrop.classList.toggle('active');
        }
    </script>
    @yield('scripts')
</body>
</html>
