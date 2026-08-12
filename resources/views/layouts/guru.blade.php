<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru — Jurnal ESEMKITA')</title>
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
            --text-dark: #0f172a;
            --text-muted: #475569;
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
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand h2 {
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .sidebar-brand span {
            font-size: 12px;
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
            background: #7c8ba9;
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
            color: #9aa8c7;
            font-weight: 600;
            margin-top: 2px;
            text-transform: uppercase;
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
        }

        /* Topbar Header */
        .topbar {
            height: 64px;
            background: #ffffff;
            display: flex;
            align-items: center;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            border-bottom: 1px solid #e2e8f0;
        }

        .breadcrumb-text {
            font-size: 15px;
            color: #475569;
            font-weight: 600;
        }
        .breadcrumb-text span {
            color: #0f172a;
            font-weight: 800;
        }

        /* Content Body */
        .content-body {
            padding: 24px 28px;
            flex: 1;
        }

        /* Alerts */
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

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>Jurnal ESEMKITA</h2>
            <span>Portal Presensi Digital</span>
        </div>

        <nav class="sidebar-menu">
            @if(Auth::check() && Auth::user()->isGuruPiket())
                <div class="menu-category">MENU PETUGAS PIKET</div>
                
                <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i>
                    <span>Dashboard Piket</span>
                </a>

                <a href="{{ route('jurnal-piket.index') }}" class="nav-item {{ request()->routeIs('jurnal-piket.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Jurnal Piket</span>
                </a>

                <a href="{{ route('guru.kehadiran-kelas') }}" class="nav-item {{ request()->routeIs('guru.kehadiran-kelas') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-viewfinder"></i>
                    <span>Monitoring Kehadiran</span>
                </a>
            @else
                <div class="menu-category">MENU UTAMA</div>

                <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i>
                    <span>Dashboard Guru</span>
                </a>

                <a href="{{ route('guru.riwayat-jurnal') }}" class="nav-item {{ request()->routeIs('guru.riwayat-jurnal') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Riwayat Jurnal</span>
                </a>

                @if(Auth::check() && Auth::user()->isWaliKelas())
                    <div class="menu-category">WALI KELAS</div>

                    <a href="{{ route('guru.kehadiran-kelas') }}" class="nav-item {{ request()->routeIs('guru.kehadiran-kelas') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card-clip"></i>
                        <span>Presensi & Perkembangan Kelas</span>
                    </a>
                @endif
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="name" title="{{ Auth::user()->name ?? 'Pengguna' }}">
                        {{ Auth::user()->name ?? 'Pengguna' }}
                    </div>
                    <div class="role">
                        ROLE: {{ strtoupper(Auth::user()->role_label ?? Auth::user()->role) }}
                    </div>
                </div>
            </div>

            <div class="sidebar-footer-actions">
                <form action="{{ route('logout') }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="btn-footer-action btn-logout" title="Keluar dari sistem" style="width:100%;">
                        <i class="fa-solid fa-right-from-bracket"></i>
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
            <div class="breadcrumb-text">
                Jurnal ESEMKITA > <span>@yield('header_title', 'Dashboard')</span>
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
