<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Waka SDM — EduJournal')</title>
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

        .sidebar-brand h2 {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .sidebar-brand span {
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
            flex-shrink: 0;
        }

        .nav-item span:not(.sidebar-badge-notify) {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-badge-notify {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            min-width: 20px !important;
            height: 20px !important;
            padding: 0 6px !important;
            border-radius: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.45) !important;
            flex-shrink: 0 !important;
            margin-left: auto !important;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11px;
            color: #93a5cc;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-footer-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
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
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .btn-logout-footer {
            flex: 1;
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.1);
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
            box-sizing: border-box;
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
            padding: 28px;
            flex: 1;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Global Pagination SVG Fix & Styling */
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .pagination-container {
            width: 100%;
            margin-top: 20px;
        }

        .pagination-container nav {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
        }

        .pagination-container p, 
        .pagination-container .small,
        .pagination-container div > p {
            margin: 0 !important;
            font-size: 13px !important;
            color: #64748b !important;
            font-weight: 600 !important;
            line-height: 1.5 !important;
        }

        .pagination-container ul.pagination, 
        .pagination-container div > ul,
        .pagination-container nav ul {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .pagination-container ul.pagination li, 
        .pagination-container div > ul li,
        .pagination-container nav ul li {
            display: inline-block !important;
            margin: 0 !important;
        }

        .pagination-container ul.pagination li a, 
        .pagination-container ul.pagination li span,
        .pagination-container div > ul li a,
        .pagination-container div > ul li span,
        .pagination-container nav ul li a,
        .pagination-container nav ul li span {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #334155 !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: all 0.15s ease !important;
        }

        .pagination-container ul.pagination li.active span,
        .pagination-container div > ul li.active span,
        .pagination-container ul.pagination li.active a,
        .pagination-container div > ul li.active a,
        .pagination-container nav ul li.active span {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }

        .pagination-container ul.pagination li a:hover,
        .pagination-container div > ul li a:hover,
        .pagination-container nav ul li a:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #94a3b8 !important;
        }

        .pagination-container ul.pagination li.disabled span,
        .pagination-container div > ul li.disabled span,
        .pagination-container nav ul li.disabled span {
            background: #f8fafc !important;
            color: #cbd5e1 !important;
            border-color: #e2e8f0 !important;
            cursor: not-allowed !important;
        }

        /* Custom Pagination Bar Styling */
        .custom-pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-info {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        .pagination-list {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination-list .page-item {
            display: inline-block;
            margin: 0;
            flex-shrink: 0;
        }

        .pagination-list .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .pagination-list .page-item.active .page-link {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .pagination-list .page-item a.page-link:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .pagination-list .page-item.disabled .page-link {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #e2e8f0;
            cursor: not-allowed;
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

            /* Responsive Pagination for Mobile */
            .custom-pagination-bar {
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                gap: 12px !important;
                margin-top: 18px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .pagination-info {
                font-size: 12px !important;
                text-align: center !important;
                width: 100% !important;
            }

            .pagination-list {
                display: flex !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                max-width: 100% !important;
                width: 100% !important;
                justify-content: flex-start !important;
                padding: 4px 4px 8px 4px !important;
                gap: 4px !important;
                box-sizing: border-box !important;
                scrollbar-width: thin !important;
            }

            .pagination-list::-webkit-scrollbar {
                height: 4px !important;
            }

            .pagination-list::-webkit-scrollbar-thumb {
                background: #cbd5e1 !important;
                border-radius: 4px !important;
            }

            .pagination-list .page-link {
                min-width: 32px !important;
                height: 32px !important;
                padding: 0 8px !important;
                font-size: 12px !important;
                border-radius: 8px !important;
                flex-shrink: 0 !important;
                box-sizing: border-box !important;
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

    <!-- Sidebar Waka SDM Navigation -->
    <aside class="sidebar" id="wakaSdmSidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-user-shield\' style=\'font-size:32px; color:#60a5fa;\'></i>';">
            </div>
            <div>
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi Digital</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>
            <a href="{{ route('waka-sdm.dashboard') }}" class="nav-item {{ request()->routeIs('waka-sdm.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Dashboard SDM</span>
            </a>

            <div class="menu-category">MANAJEMEN SDM</div>
            <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="nav-item {{ request()->routeIs('waka-sdm.persetujuan-izin*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Persetujuan Izin Guru</span>
                @php
                    $pendingGuruIzinNotifyCount = $wakaSdmPendingIzinCount ?? \App\Models\GuruIzin::where(function($q) {
                        $q->where('status_waka_sdm', 'pending')->orWhereNull('status_waka_sdm');
                    })->count();
                @endphp
                @if($pendingGuruIzinNotifyCount > 0)
                    <span class="sidebar-badge-notify" title="{{ $pendingGuruIzinNotifyCount }} permohonan izin guru menunggu persetujuan Waka SDM">{{ $pendingGuruIzinNotifyCount }}</span>
                @endif
            </a>
            <a href="{{ route('waka-sdm.kehadiran-guru') }}" class="nav-item {{ request()->routeIs('waka-sdm.kehadiran-guru*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Kehadiran & KBM</span>
            </a>
            <a href="{{ route('waka-sdm.data-guru') }}" class="nav-item {{ request()->routeIs('waka-sdm.data-guru*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                <span>Direktori SDM</span>
            </a>

            <div class="menu-category">INFORMASI</div>
            <a href="{{ route('waka-sdm.pengumuman') }}" class="nav-item {{ request()->routeIs('waka-sdm.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman SDM</span>
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
                    <div class="user-name" title="{{ Auth::user()->name ?? 'Waka SDM' }}">{{ Auth::user()->name ?? 'Waka SDM' }}</div>
                    <div class="user-role">ROLE: WAKA SDM</div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="flex:1; display:flex; margin:0;">
                    @csrf
                    <button type="button" class="btn-footer-action btn-logout-footer" style="width:100%;" title="Keluar dari Sistem" onclick="confirmLogout(event)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" title="Pengaturan Profil">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('customer-service.*') ? 'active' : '' }}" title="Bantuan & Customer Service">
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
            @if(View::hasSection('page-header'))
                <div style="margin-bottom: 20px;">
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; margin: 0 0 4px 0; line-height: 1.3;">@yield('page-header')</h1>
                    @if(View::hasSection('page-subheader'))
                        <p style="font-size: 13px; color: #64748b; margin: 0; font-weight: 500; line-height: 1.4;">@yield('page-subheader')</p>
                    @endif
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        (function() {
            const sidebar = document.getElementById('wakaSdmSidebar');
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
