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

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            background-image: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.04) 0%, transparent 40%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
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
        }

        .nav-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
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

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            flex-wrap: wrap;
            gap: 12px;
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
            padding: 28px;
            flex: 1;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .topbar { padding: 12px 16px; }
            .content-body { padding: 16px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
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
                <span>Dashboard WAKA</span>
            </a>

            <div class="menu-category">Data Master</div>
            <a href="{{ route('waka.jadwal') }}" class="nav-item {{ request()->routeIs('waka.jadwal') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal</span>
            </a>
            <a href="{{ route('waka.persetujuan-izin') }}" class="nav-item {{ request()->routeIs('waka.persetujuan-izin') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Persetujuan Izin</span>
            </a>

            <div class="menu-category">Akademik</div>
            <a href="{{ route('waka.pengumuman') }}" class="nav-item {{ request()->routeIs('waka.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
            <a href="{{ route('waka.jadwal-mengajar') }}" class="nav-item {{ request()->routeIs('waka.jadwal-mengajar') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Jadwal Mengajar</span>
            </a>
            <a href="{{ route('waka.rekap-jurnal') }}" class="nav-item {{ request()->routeIs('waka.rekap-jurnal') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Rekap Jurnal & Kehadiran</span>
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
                <form action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="btn-footer-action btn-logout-footer" style="width:100%;" title="Keluar dari Sistem">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>

                <a href="{{ route('pengaturan.index') }}" class="btn-footer-action btn-icon-only" title="Pengaturan Profil">
                    <i class="fa-solid fa-gear"></i>
                </a>

                <a href="{{ route('customer-service.index') }}" class="btn-footer-action btn-icon-only" title="Bantuan & Customer Service">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar Header -->
        <header class="topbar">
            <div></div>

            <div class="topbar-right">
                <div class="semester-pill">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b; font-size: 14px;"></i>
                    <span>T.A. 2025/2026 - Semester Genap</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px; color: #94a3b8;"></i>
                </div>

                {{-- Live Date & Time Widget Component (Standar Seluruh Role) --}}
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
