<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard TU — EDU JOURNAL')</title>
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
        }

        .sidebar-brand .logo-text span {
            font-size: 11px;
            color: #a5b6dc;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 12px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .menu-category {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #93a5cc;
            padding: 16px 12px 6px 12px;
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
        }

        .nav-item .badge-count {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* Dropdown Accordion Sidebar */
        .sidebar-dropdown {
            display: flex;
            flex-direction: column;
        }

        .sidebar-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .sidebar-dropdown-toggle .toggle-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            text-decoration: none;
            color: inherit;
        }

        .sidebar-dropdown-toggle .chevron-btn {
            background: transparent;
            border: none;
            color: #93a5cc;
            font-size: 11px;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 6px;
            transition: transform 0.25s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-dropdown-toggle .chevron-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
        }

        .sidebar-dropdown.open .chevron-btn i {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease;
            opacity: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-top: 2px;
            padding-left: 14px;
            border-left: 2px solid rgba(255, 255, 255, 0.15);
            margin-left: 22px;
        }

        .sidebar-dropdown.open .sidebar-submenu {
            max-height: 200px;
            opacity: 1;
        }

        .sidebar-submenu .submenu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: #b6c5e3;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sidebar-submenu .submenu-item i {
            font-size: 13px;
            width: 16px;
            text-align: center;
        }

        .sidebar-submenu .submenu-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-submenu .submenu-item.active {
            color: #ffffff;
            background: #4a5e8c;
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
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-box {
            position: relative;
            width: 320px;
        }

        .search-box input {
            width: 100%;
            background: #f1f5f9;
            border: none;
            padding: 10px 16px 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-family: inherit;
            color: #334155;
            outline: none;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .ta-selector {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Content Area */
        .content-body {
            padding: 24px 28px;
            flex: 1;
        }

        /* Global Page Header Container (Top-Left Title & Subtitle) */
        .page-header-container,
        .dashboard-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title-group h1,
        .page-header-title h1,
        .header-left h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 4px 0;
        }

        .page-title-group p,
        .page-header-title p,
        .header-left p {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 600;
            margin: 0;
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

        /* Fix Laravel Default Pagination Giant SVGs & Unstyled Links */
        .pagination-bar svg,
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }

        .pagination-bar nav,
        nav[role="navigation"] {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 4px !important;
        }

        .pagination-bar nav > div:first-child,
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }

        .pagination-bar nav > div:last-child,
        nav[role="navigation"] > div:last-child {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .pagination-bar nav span,
        .pagination-bar nav a,
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }

        .pagination-bar nav a:hover,
        nav[role="navigation"] a:hover {
            background: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        .pagination-bar nav span[aria-current="page"],
        nav[role="navigation"] span[aria-current="page"] {
            background: #1f293d !important;
            color: #ffffff !important;
            border-color: #1f293d !important;
        }

        .pagination-bar nav span[aria-disabled="true"],
        nav[role="navigation"] span[aria-disabled="true"] {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #f8fafc !important;
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
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
            </div>
            <div class="logo-text">
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi Digital</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">MASTER DATA</div>
            <a href="{{ route('admin.verifikasi-guru') }}" class="nav-item {{ (request()->routeIs('admin.verifikasi-guru') || request()->routeIs('admin.pengguna') || request()->routeIs('admin.users-trash')) ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Pengguna</span>
                @php
                    $pendingCount = \App\Models\User::where('status_verifikasi', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge-count">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('siswa.index') }}" class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Siswa</span>
            </a>

            {{-- Dropdown Menu Guru --}}
            <div class="sidebar-dropdown {{ (request()->routeIs('guru.*') || request()->routeIs('admin.guru-piket') || request()->routeIs('admin.wali-kelas-list')) ? 'open' : '' }}" id="guruDropdown">
                <div class="nav-item sidebar-dropdown-toggle {{ (request()->routeIs('guru.index') && !request('role')) ? 'active' : '' }}">
                    <a href="{{ route('guru.index') }}" class="toggle-left">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Guru</span>
                    </a>
                    <button type="button" class="chevron-btn" onclick="toggleGuruSubmenu(event)" title="Buka/Tutup Submenu Guru">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="sidebar-submenu" id="guruSubmenu">
                    <a href="{{ route('admin.guru-piket') }}" class="submenu-item {{ request()->routeIs('admin.guru-piket') || (request()->routeIs('guru.index') && request('role') == 'piket') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-user"></i>
                        <span>Guru Piket</span>
                    </a>
                    <a href="{{ route('admin.wali-kelas-list') }}" class="submenu-item {{ request()->routeIs('admin.wali-kelas-list') || (request()->routeIs('guru.index') && request('role') == 'wali_kelas') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card-clip"></i>
                        <span>Wali Kelas</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('kelas.index') }}" class="nav-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <i class="fa-solid fa-school"></i>
                <span>Kelas</span>
            </a>
            <a href="{{ route('mapel.index') }}" class="nav-item {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i>
                <span>Mapel</span>
            </a>
            <a href="{{ route('jam-pelajaran.index') }}" class="nav-item {{ request()->routeIs('jam-pelajaran.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i>
                <span>Master Jam Pelajaran</span>
            </a>

            <div class="menu-category">AKADEMIK</div>
            <a href="{{ route('jadwal.index') }}" class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="{{ route('admin.jurnal-mengajar') }}" class="nav-item {{ request()->routeIs('admin.jurnal-mengajar*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>Jurnal Mengajar</span>
            </a>
            <a href="{{ route('admin.jurnal-piket') }}" class="nav-item {{ request()->routeIs('admin.jurnal-piket*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Jurnal Piket</span>
            </a>
            @if(Auth::check() && !Auth::user()->isTu())
            <a href="{{ route('admin.monitoring-kehadiran') }}" class="nav-item {{ request()->routeIs('admin.monitoring-kehadiran*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Monitoring Kehadiran</span>
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar" style="overflow: hidden;">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="name" title="{{ Auth::user()->name ?? 'Admin Tata Usaha' }}">{{ Auth::user()->name ?? 'Admin Tata Usaha' }}</div>
                    <div class="role">ROLE: {{ strtoupper(Auth::user()->role_label ?? 'TU') }}</div>
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
            <div></div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="ta-selector">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i>
                    <span>T.A. 2025/2026 - Semester Genap</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px;"></i>
                </div>

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
        function toggleGuruSubmenu(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const dropdown = document.getElementById('guruDropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
