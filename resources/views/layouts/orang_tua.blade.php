<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Orang Tua — Jurnal SMEA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --sidebar-bg: #384972;
            --sidebar-active: #4a5e8c;
            --sidebar-text: #b6c5e3;
            --sidebar-text-active: #ffffff;
            --body-bg: #cbd3e0;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --sidebar-width: 250px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            width: 100%;
            overflow-x: clip;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            z-index: 100;
            box-shadow: 2px 0 15px rgba(0,0,0,0.08);
        }

        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .logo-icon {
            width: 92px; height: 92px;
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            overflow: visible;
            padding: 0;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.4));
        }

        .logo-text h2 {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .logo-text span {
            font-size: 11.5px;
            color: #93a5cc;
            font-weight: 600;
        }

        .sidebar-menu {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-category {
            font-size: 11px;
            font-weight: 700;
            color: #7b8ea8;
            letter-spacing: 0.05em;
            padding: 12px 14px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            color: var(--sidebar-text-active);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-item.active {
            color: var(--sidebar-text-active);
            background: var(--sidebar-active);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .nav-item i {
            font-size: 15px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #9aa8c7;
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
        }

        .user-info .name {
            font-size: 12.5px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }
        .user-info .role {
            font-size: 10.5px;
            color: #a0b2db;
            font-weight: 600;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 2px;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 9px;
            font-size: 11.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #c0cdf0;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .btn-footer-action.btn-icon-only {
            width: 36px;
            height: 36px;
            padding: 0;
            flex: 0 0 36px;
            font-size: 14px;
        }

        .btn-footer-action i {
            font-size: 13px;
        }

        .btn-footer-action:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .btn-footer-action.btn-logout {
            color: #f87171;
            background: rgba(239, 68, 68, 0.15);
        }

        .btn-footer-action.btn-logout:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #ffffff;
        }

        /* SweetAlert2 Logout Modal Styling */
        .swal2-logout-popup {
            border-radius: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            padding: 24px 20px !important;
        }
        .swal2-logout-popup .swal2-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 6px !important;
        }
        .swal2-logout-popup .swal2-html-container {
            font-size: 0.95rem !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            margin: 6px 0 0 0 !important;
        }
        .swal2-logout-popup .swal2-actions {
            margin-top: 20px !important;
            gap: 10px !important;
        }
        .swal2-logout-confirm {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            padding: 10px 20px !important;
            background-color: #ef4444 !important;
        }
        .swal2-logout-cancel {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            padding: 10px 20px !important;
            background-color: #64748b !important;
        }

        .btn-footer-action.active {
            background: var(--sidebar-active);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100vw - var(--sidebar-width));
            overflow-x: clip;
            box-sizing: border-box;
        }

        /* Topbar Header */
        .topbar {
            min-height: 64px;
            height: auto;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            width: 100%;
            box-sizing: border-box;
            flex-wrap: wrap;
            gap: 12px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-search {
            position: relative;
            width: 280px;
        }

        .topbar-search input {
            width: 100%;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 8px 14px 8px 36px;
            border-radius: 10px;
            font-size: 13px;
            font-family: inherit;
            color: #334155;
            outline: none;
            transition: all 0.2s ease;
        }

        .topbar-search input:focus {
            background: #ffffff;
            border-color: #384972;
            box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.1);
        }

        .topbar-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .semester-pill {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 7px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .notification-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .notification-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* Content Area */
        .content-body {
            padding: 24px 28px;
            flex: 1;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .sidebar-close-btn,
        .btn-sidebar-toggle {
            display: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .sidebar { 
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 270px !important;
                max-width: 82vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                max-height: 100dvh !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1050 !important;
                box-shadow: 4px 0 25px rgba(0,0,0,0.3);
                display: flex !important;
                flex-direction: column !important;
                overflow: hidden !important;
                overscroll-behavior: contain !important;
            }
            .sidebar.open {
                transform: translateX(0) !important;
            }
            .sidebar-brand {
                flex-shrink: 0 !important;
                padding: 16px 18px !important;
            }
            .sidebar-menu {
                flex: 1 1 auto !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
            }
            .sidebar-footer {
                flex-shrink: 0 !important;
                margin-top: auto !important;
                padding: 12px 14px !important;
            }
            .sidebar-overlay {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                height: 100dvh !important;
                touch-action: none !important;
                overscroll-behavior: none !important;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                overflow-x: clip !important;
            }
            .topbar {
                height: auto !important;
                min-height: unset !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 1000 !important;
                background: #ffffff !important;
                padding: 8px 10px !important;
                gap: 6px 8px !important;
                display: grid !important;
                grid-template-columns: auto 1fr auto !important;
                align-items: center !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                border-bottom: 1px solid var(--border-color) !important;
            }
            .topbar-right {
                display: contents !important;
            }
            .topbar-left {
                grid-column: 1 / 2 !important;
                grid-row: 1 / 2 !important;
                display: flex !important;
                align-items: center !important;
                gap: 6px !important;
                justify-self: start !important;
                align-self: center !important;
            }
            .btn-sidebar-toggle {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                width: 38px !important;
                height: 38px !important;
                border-radius: 10px !important;
                background: #f1f5f9;
                border: 1px solid #cbd5e1;
                color: #1e293b;
                font-size: 16px !important;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 1px 2px rgba(0,0,0,0.04);
                flex-shrink: 0;
                margin: 0 !important;
            }
            .btn-sidebar-toggle:hover, .btn-sidebar-toggle:active {
                background: #e2e8f0;
                color: #0f172a;
            }
            .semester-pill {
                grid-column: 2 / 3 !important;
                grid-row: 1 / 2 !important;
                justify-self: end !important;
                align-self: center !important;
                padding: 6px 10px !important;
                font-size: 11.5px !important;
                height: 38px !important;
                border-radius: 10px !important;
                gap: 6px !important;
                display: inline-flex !important;
                align-items: center !important;
                margin: 0 !important;
                box-sizing: border-box !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                max-width: 100% !important;
            }
            .notification-btn {
                grid-column: 3 / 4 !important;
                grid-row: 1 / 2 !important;
                justify-self: end !important;
                align-self: center !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 38px !important;
                height: 38px !important;
                border-radius: 10px !important;
                font-size: 15px !important;
                margin: 0 !important;
                flex-shrink: 0 !important;
            }
            .live-clock-wrapper {
                grid-column: 1 / -1 !important;
                grid-row: 2 / 3 !important;
                width: 100% !important;
                margin: 0 !important;
            }
            .content-body {
                padding: 10px 12px !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                box-sizing: border-box;
                overflow-x: clip !important;
            }
            body.sidebar-open {
                overflow: hidden;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 6px 8px !important;
                gap: 5px 6px !important;
            }
            .btn-sidebar-toggle {
                width: 36px !important;
                height: 36px !important;
                font-size: 15px !important;
                border-radius: 9px !important;
            }
            .semester-pill {
                padding: 4px 8px !important;
                font-size: 10.5px !important;
                height: 36px !important;
                gap: 4px !important;
                border-radius: 9px !important;
            }
            .notification-btn {
                width: 36px !important;
                height: 36px !important;
                font-size: 14px !important;
                border-radius: 9px !important;
            }
            .content-body {
                padding: 8px 8px !important;
                overflow-x: clip !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="orangTuaSidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
            </div>
            <div class="logo-text">
                <h2>Jurnal SMEA</h2>
                <span>SMK Ekonomi & Bisnis</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>

            <a href="{{ route('orang-tua.dashboard') }}" class="nav-item {{ request()->routeIs('orang-tua.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Dashboard Orang Tua</span>
            </a>

            <a href="{{ route('orang-tua.monitoring-presensi') }}" class="nav-item {{ request()->routeIs('orang-tua.monitoring-presensi') ? 'active' : '' }}">
                <i class="fa-solid fa-users-viewfinder"></i>
                <span>Monitoring Presensi</span>
                <span class="badge" style="margin-left: auto; background: #22c55e; color: #ffffff; font-size: 9px; font-weight: 900; padding: 2px 7px; border-radius: 12px; letter-spacing: 0.5px; text-transform: uppercase;">
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
                    <div class="name" title="{{ Auth::user()->name ?? 'Orang tua' }}">
                        {{ Auth::user()->name ?? 'Orang tua' }}
                    </div>
                    <div class="role">
                        ROLE: ORANG TUA
                    </div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="button" class="btn-footer-action btn-logout" title="Keluar dari sistem" style="width:100%;" onclick="confirmLogout(event)">
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

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-sidebar-toggle" id="sidebarToggleBtn" aria-label="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div class="topbar-right">
                <div class="semester-pill">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b; font-size: 14px;"></i>
                    <span>T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - Semester {{ $activeTahunAjaran->semester ?? 'Ganjil' }}</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px; color: #94a3b8;"></i>
                </div>
                <button type="button" class="notification-btn" title="Notifikasi">
                    <i class="fa-regular fa-bell"></i>
                </button>
                @include('partials.live-clock')
            </div>
        </header>

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
        (function() {
            const sidebar = document.getElementById('orangTuaSidebar');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            let scrollY = 0;

            function openSidebar() {
                if (sidebar) sidebar.classList.add('open');
                if (sidebarOverlay) sidebarOverlay.classList.add('active');
                scrollY = window.pageYOffset || document.documentElement.scrollTop;
                document.body.style.top = `-${scrollY}px`;
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.classList.add('sidebar-open');
                document.documentElement.classList.add('sidebar-open');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('open');
                if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.width = '';
                document.body.classList.remove('sidebar-open');
                document.documentElement.classList.remove('sidebar-open');
                window.scrollTo(0, scrollY);
            }

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', openSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
                sidebarOverlay.addEventListener('touchmove', function(e) {
                    e.preventDefault();
                }, { passive: false });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            if (sidebar) {
                const navLinks = sidebar.querySelectorAll('.nav-item, .user-profile, .btn-footer-action');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (this.classList.contains('btn-logout') || this.closest('form#logout-form')) {
                            return;
                        }
                        if (window.innerWidth <= 992) {
                            closeSidebar();
                        }
                    });
                });
            }
        })();

        // Global Confirmation Modal for Logout
        function confirmLogout(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const form = (event && event.currentTarget) ? event.currentTarget.closest('form') : (document.getElementById('logout-form') || document.querySelector('form[action*="logout"]'));

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar dari akun Anda?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 6px;"></i> Ya, Keluar',
                    cancelButtonText: '<i class="fa-solid fa-xmark" style="margin-right: 6px;"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'swal2-logout-popup',
                        confirmButton: 'swal2-logout-confirm',
                        cancelButton: 'swal2-logout-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (form) {
                            form.submit();
                        } else {
                            const fallbackForm = document.createElement('form');
                            fallbackForm.method = 'POST';
                            fallbackForm.action = '{{ route("logout") }}';
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            fallbackForm.appendChild(csrfInput);
                            document.body.appendChild(fallbackForm);
                            fallbackForm.submit();
                        }
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari akun Anda?')) {
                    if (form) form.submit();
                }
            }
            return false;
        }
    </script>
    @yield('scripts')
</body>
</html>
