<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kepala Sekolah — Jurnal SMEA')</title>
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
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary-blue: #2563eb;
            --accent-coral: #e06d6d;
            --sidebar-width: 260px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            background-image: radial-gradient(circle at 90% 10%, rgba(56, 73, 114, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at 10% 90%, rgba(224, 109, 109, 0.04) 0%, transparent 40%);
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
            gap: 12px;
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
            color: #b6c5e3;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 3px;
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
            padding: 11px 14px;
            color: #c0cdf0;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-item i {
            font-size: 15px;
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

        /* User Profile & Footer Sidebar */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0, 0, 0, 0.12);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #475569;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
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
            font-size: 13.5px;
            font-weight: 800;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 10.5px;
            color: #b6c5e3;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 1px;
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
            gap: 8px;
            padding: 8px 12px;
            border-radius: 10px;
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
            width: 38px;
            height: 38px;
            padding: 0;
            flex: 0 0 38px;
            font-size: 15px;
        }

        .btn-footer-action i {
            font-size: 14px;
        }

        .btn-footer-action:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .btn-footer-action.btn-logout {
            color: #f87171;
            background: rgba(239, 68, 68, 0.18);
        }

        .btn-footer-action.btn-logout:hover {
            background: rgba(239, 68, 68, 0.35);
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
            height: 68px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .search-box {
            position: relative;
            width: 320px;
        }

        .search-box input {
            width: 100%;
            padding: 9px 16px 9px 38px;
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
            border-color: var(--primary-blue);
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

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .icon-btn:hover {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        .icon-btn .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        /* Content Body */
        .content-body {
            padding: 24px 28px;
            flex: 1;
        }

        /* Alert notifications */
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
            <div>
                <h2>Jurnal SMEA</h2>
                <span>SMK Ekonomi & Bisnis</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">UTAMA</div>
            <a href="{{ route('kepala-sekolah.dashboard') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Dashboard Kepala Sekolah</span>
            </a>

            @php
                $pendingCount = \App\Models\GuruIzin::where('status_kepsek', 'pending')->count();
            @endphp
            <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.persetujuan-izin*') ? 'active' : '' }}" style="display: flex; align-items: center;">
                <i class="fa-solid fa-signature"></i>
                <span>Persetujuan Izin</span>
                @if($pendingCount > 0)
                    <span style="margin-left: auto; background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; min-width: 18px; height: 18px; line-height: 1;">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('kepala-sekolah.kehadiran-guru') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.kehadiran-guru*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-check"></i>
                <span>Kehadiran Guru</span>
            </a>

            <a href="{{ route('kepala-sekolah.guru-izin-tidak-hadir') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.guru-izin-tidak-hadir*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-slash"></i>
                <span>Guru Izin Tidak Hadir</span>
            </a>

            <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.kehadiran-siswa*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Kehadiran Siswa</span>
            </a>

            <a href="{{ route('kepala-sekolah.siswa-izin') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.siswa-izin*') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card"></i>
                <span>siswa yang sedang izin</span>
            </a>

            <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.jurnal-pembelajaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>Jurnal pembelajaran</span>
            </a>

            <a href="{{ route('kepala-sekolah.laporan') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.laporan*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'K', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <div class="user-name" title="{{ Auth::user()->name ?? 'Kepala Sekolah' }}">
                        {{ Auth::user()->name ?? 'Kepala Sekolah' }}
                    </div>
                    <div class="user-role">
                        ROLE: KEPALA SEKOLAH
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
            <div></div>

            <div class="topbar-right">
                <div class="semester-pill">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b; font-size: 14px;"></i>
                    <span>T.A. 2025/2026 - Semester Genap</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px; color: #94a3b8;"></i>
                </div>

                <a href="{{ route('kepala-sekolah.persetujuan-izin') }}" class="icon-btn" title="Notifikasi Persetujuan Izin" style="text-decoration: none; position: relative;">
                    <i class="fa-regular fa-bell"></i>
                    @if($pendingCount > 0)
                        <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: #ffffff; font-size: 10.5px; font-weight: 800; border-radius: 50%; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; line-height: 1; border: 2px solid #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                @include('partials.live-clock')
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert-custom alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-custom alert-error">
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
