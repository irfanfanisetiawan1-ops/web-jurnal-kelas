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

        .sidebar-brand .logo-text h2 {
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .sidebar-brand .logo-text span {
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
            padding: 14px 12px 6px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #c0cdf0;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
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
            font-weight: 700;
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
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #9aa8c7;
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.2);
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
            font-size: 10px;
            color: #a0b2db;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-footer-actions {
            display: flex;
            align-items: center;
            gap: 6px;
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

        .btn-footer-action:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .btn-footer-action.btn-logout {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.15);
        }

        .btn-footer-action.btn-logout:hover {
            background: rgba(239, 68, 68, 0.3);
            color: #ffffff;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar Header */
        .topbar {
            height: 64px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
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

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar-search { width: 180px; }
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
            <div class="topbar-left">
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

    @yield('scripts')
</body>
</html>
