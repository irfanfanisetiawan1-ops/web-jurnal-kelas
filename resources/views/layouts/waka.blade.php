<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Wakil Kepala — Jurnal SMEA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --sidebar-bg: #2b3957;
            --sidebar-active: #405178;
            --sidebar-text: #b6c5e3;
            --sidebar-text-active: #ffffff;
            --body-bg: #f3f6fc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary-blue: #2563eb;
            --sidebar-width: 250px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            width: 100%;
            max-width: 100%;
            overflow-x: clip;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            background-image: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.04) 0%, transparent 40%);
            color: var(--text-dark);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            width: 100%;
            max-width: 100%;
            overflow-x: clip;
            box-sizing: border-box;
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
            width: 92px;
            height: 92px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: visible;
        }

        .sidebar-brand .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.4));
        }

        .sidebar-brand h2 {
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .sidebar-brand span {
            font-size: 11px;
            color: #93a5cc;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-category {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #93a5cc;
            padding: 12px 12px 4px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #c0cdf0;
            text-decoration: none;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item span:not(.sidebar-badge-notify) {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-badge-notify {
            background-color: #ef4444;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.45);
            flex-shrink: 0;
            margin-left: auto;
        }

        .nav-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-item.active {
            color: #ffffff;
            background: var(--sidebar-active);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: rgba(0, 0, 0, 0.15);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #475569;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .user-role {
            font-size: 10.5px;
            color: #93a5cc;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 9px;
            font-size: 12px;
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
            width: 34px;
            height: 34px;
            padding: 0;
            flex: 0 0 34px;
            font-size: 13px;
        }

        .btn-footer-action:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .btn-logout-footer {
            color: #f87171;
        }

        .btn-logout-footer:hover {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.15);
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
        }

        /* Top Bar Header */
        .topbar {
            min-height: 64px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            flex-wrap: wrap;
            gap: 12px;
            width: 100%;
            box-sizing: border-box;
        }

        .search-box {
            position: relative;
            width: 360px;
        }

        .search-box input {
            width: 100%;
            padding: 9px 16px 9px 40px;
            background: #f1f5f9;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 13px;
            color: var(--text-dark);
            outline: none;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .semester-pill {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
        }

        /* Content Body */
        .content-body {
            padding: 24px 28px;
            flex: 1;
            min-width: 0;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
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

        .pagination-container nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-container nav > div:first-child:not(:only-child) {
            display: none !important;
        }

        .pagination-container nav svg {
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
        .pagination-list .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 10px;
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
        .pagination-list .page-item:not(.active):not(.disabled) .page-link:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .pagination-container nav span[aria-current="page"] > span,
        .pagination-container nav .active > span,
        .pagination-list .page-item.active .page-link {
            background: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        .pagination-container nav span[aria-disabled="true"] > span,
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

        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
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
            body.sidebar-open {
                overflow: hidden;
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
                padding: 6px 10px !important;
                gap: 5px 6px !important;
                display: grid !important;
                grid-template-columns: auto 1fr !important;
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
                width: 32px !important;
                height: 32px !important;
                border-radius: 8px !important;
                background: #f1f5f9;
                border: 1px solid #cbd5e1;
                color: #1e293b;
                font-size: 13px !important;
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
                padding: 4px 8px !important;
                font-size: 11px !important;
                height: 32px !important;
                border-radius: 8px !important;
                gap: 5px !important;
                display: inline-flex !important;
                align-items: center !important;
                margin: 0 !important;
                box-sizing: border-box !important;
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
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 5px 8px !important;
                gap: 4px 6px !important;
            }
            .btn-sidebar-toggle {
                width: 30px !important;
                height: 30px !important;
                font-size: 12px !important;
            }
            .semester-pill {
                padding: 3px 6px !important;
                font-size: 10.5px !important;
                height: 30px !important;
                gap: 4px !important;
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
    <aside class="sidebar" id="wakaSidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
            </div>
            <div>
                <h2>Jurnal SMEA</h2>
                <span>SMK Ekonomi & Bisnis</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">Utama</div>
            <a href="{{ route('waka.dashboard') }}" class="nav-item {{ request()->routeIs('waka.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">Data Master</div>
            <a href="{{ route('waka.siswa') }}" class="nav-item {{ request()->routeIs('waka.siswa*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Data Siswa</span>
            </a>
            <a href="{{ route('waka.jadwal') }}" class="nav-item {{ request()->routeIs('waka.jadwal*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal</span>
            </a>
            <a href="{{ route('waka.persetujuan-izin') }}" class="nav-item {{ request()->routeIs('waka.persetujuan-izin*') || request()->routeIs('waka.siswa-dispen*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Persetujuan Izin</span>
                @php
                    $pendingDispenNotifyCount = $wakaPendingDispenCount ?? \App\Models\SiswaDispen::where(function($q) {
                        $q->where('status_waka', 'pending')->orWhereNull('status_waka');
                    })->count();
                @endphp
                @if($pendingDispenNotifyCount > 0)
                    <span class="sidebar-badge-notify" title="{{ $pendingDispenNotifyCount }} permohonan dispen siswa menunggu persetujuan">{{ $pendingDispenNotifyCount }}</span>
                @endif
            </a>

            <div class="menu-category">Akademik</div>
            <a href="{{ route('waka.pengumuman') }}" class="nav-item {{ request()->routeIs('waka.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
            <a href="{{ route('waka.rekap-jurnal') }}" class="nav-item {{ request()->routeIs('waka.rekap-jurnal*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Rekap Jurnal Mengajar</span>
            </a>
            <a href="{{ route('waka.rekap-kehadiran') }}" class="nav-item {{ request()->routeIs('waka.rekap-kehadiran*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-check"></i>
                <span>Rekap Kehadiran Siswa</span>
            </a>
            <a href="{{ route('waka.pelanggaran-siswa') }}" class="nav-item {{ request()->routeIs('waka.pelanggaran-siswa*') ? 'active' : '' }}">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Pelanggaran Siswa</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="Foto Profile">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'W', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="user-name" title="{{ Auth::user()->name ?? 'Waka' }}">{{ Auth::user()->name ?? 'Waka' }}</div>
                    <div class="user-role">ROLE: {{ strtoupper(Auth::user()->role_label ?? 'WAKA') }}</div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="button" class="btn-footer-action btn-logout-footer" style="width:100%;" title="Keluar dari Sistem" onclick="confirmLogout(event)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" title="Pengaturan Profil">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only" title="Bantuan & Customer Service">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar Header -->
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

                {{-- Live Date & Time Widget Component (Standar Seluruh Role) --}}
                @include('partials.live-clock')
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
        (function() {
            const sidebar = document.getElementById('wakaSidebar');
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
                        if (this.classList.contains('btn-logout') || this.classList.contains('btn-logout-footer') || this.closest('form#logout-form')) {
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
                    confirmButtonText: '<i class="fa-solid fa-right-from-bracket" style="margin-right: 6px;"></i> Ya, Keluar',
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
