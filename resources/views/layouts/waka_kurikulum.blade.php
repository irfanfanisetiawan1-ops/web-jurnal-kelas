<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Wakil Kurikulum — Jurnal SMEA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #384972;
            --sidebar-active: #4a5e8c;
            --sidebar-text: #b6c5e3;
            --sidebar-text-active: #ffffff;
            --body-bg: #eef2f6;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --primary-blue: #2563eb;
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
            overflow-x: hidden;
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
            width: 44px;
            height: 44px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
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
            padding: 11px 16px;
            color: #c0cdf0;
            text-decoration: none;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            position: relative;
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
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: rgba(0, 0, 0, 0.08);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #7c8ba9;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.15);
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
            color: #9aa8c7;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2px;
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
            overflow-x: hidden;
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
            z-index: 90;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            flex-wrap: wrap;
            gap: 12px;
            width: 100%;
            box-sizing: border-box;
        }

        .topbar-badge-role {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
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
            display: flex;
            align-items: center;
            gap: 6px;
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

        /* Universal Pagination Styles */
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

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; width: 100%; max-width: 100%; }
            .topbar { padding: 12px 16px; }
            .content-body { padding: 16px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Waka Kurikulum Navigation -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo" onerror="this.onerror=null; this.parentNode.innerHTML='<i class=\'fa-solid fa-graduation-cap\' style=\'font-size:30px; color:#38bdf8;\'></i>';">
            </div>
            <div>
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi Digital</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>
            <a href="{{ route('waka-kurikulum.dashboard') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">AKADEMIK &amp; KBM</div>
            <a href="{{ route('waka-kurikulum.persetujuan-izin') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.persetujuan-izin*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Persetujuan Izin</span>
                @if(isset($wakaKurikulumPendingIzinCount) && $wakaKurikulumPendingIzinCount > 0)
                    <span class="sidebar-badge-notify">{{ $wakaKurikulumPendingIzinCount }}</span>
                @endif
            </a>
            <a href="{{ route('waka-kurikulum.jadwal') }}" class="nav-item {{ (request()->routeIs('waka-kurikulum.jadwal*') && !request()->routeIs('waka-kurikulum.jadwal-piket*')) ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('waka-kurikulum.jadwal-piket') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.jadwal-piket*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Jadwal Guru Piket</span>
            </a>
            <a href="{{ route('waka-kurikulum.rekap-jurnal') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.rekap-jurnal*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Rekap Jurnal Mengajar</span>
            </a>
            <a href="{{ route('waka-kurikulum.jam-pelajaran') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.jam-pelajaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i>
                <span>Alokasi Jam Pelajaran</span>
            </a>

            <div class="menu-category">INFORMASI</div>
            <a href="{{ route('waka-kurikulum.pengumuman') }}" class="nav-item {{ request()->routeIs('waka-kurikulum.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="Foto Profile">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'H', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="user-name" title="{{ Auth::user()->name ?? 'Hardini Indahing Budi, S.E., M.Pd.' }}">{{ Auth::user()->name ?? 'Hardini Indahing Budi, S.E., M.Pd.' }}</div>
                    <div class="user-role">ROLE: {{ strtoupper(Auth::user()->role_label ?? 'WAKA KURIKULUM') }}</div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form action="{{ route('logout') }}" method="POST" style="flex:1; display:flex; margin:0;">
                    @csrf
                    <button type="submit" class="btn-footer-action btn-logout" style="width:100%;" title="Keluar dari Sistem">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('pengaturan*') ? 'active' : '' }}" title="Pengaturan Profil">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only {{ request()->routeIs('customer-service*') ? 'active' : '' }}" title="Bantuan & Customer Service">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar Header -->
        <header class="topbar">
            <div class="topbar-left"></div>

            <div class="topbar-right">
                <div class="semester-pill">
                    <i class="fa-solid fa-calendar-check" style="color: #64748b; font-size: 13px;"></i>
                    <span>T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - Semester {{ $activeTahunAjaran->semester ?? 'Ganjil' }}</span>
                </div>

                {{-- Live Date & Time Widget Standar Seluruh Role --}}
                @include('partials.live-clock')
            </div>
        </header>

        <!-- Content Body -->
        <main class="content-body">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
