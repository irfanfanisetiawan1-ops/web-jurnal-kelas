<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru — EDU JOURNAL')</title>
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
            font-size: 17px;
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
            min-height: 64px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 28px;
            position: sticky;
            top: 0;
            z-index: 90;
            border-bottom: 1px solid #e2e8f0;
            gap: 16px;
            flex-wrap: wrap;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-search {
            position: relative;
            width: 320px;
        }

        .topbar-search input {
            width: 100%;
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 9px 16px 9px 38px;
            border-radius: 12px;
            font-size: 13px;
            font-family: inherit;
            color: #334155;
            outline: none;
            transition: all 0.2s ease;
        }

        .topbar-search input:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .topbar-search i {
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
            gap: 14px;
        }

        .semester-pill {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
            color: #475569;
            white-space: nowrap;
        }

        .notification-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .notification-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .breadcrumb-text {
            font-size: 14px;
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

        /* Global Page Header Container (Top-Left Title & Subtitle) */
        .page-header-container,
        .dashboard-page-header,
        .page-title-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title-group h1,
        .page-header-title h1,
        .header-left h1,
        .page-title-box h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 4px 0;
        }

        .page-title-group p,
        .page-header-title p,
        .header-left p,
        .page-title-box p {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 600;
            margin: 0;
        }

        /* Global Table Header Filter Bar (Matching Permintaan Izin / Image Example) */
        .filter-bar-container {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 16px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .filter-bar-container form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
        }

        .filter-input {
            padding: 9px 14px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 12.5px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-filter-dark {
            background: #384972;
            color: #ffffff;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

        .btn-reset-light {
            background: #e2e8f0;
            color: #475569;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

        .btn-trash-pink {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

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
            <div class="logo-icon">
                <img src="{{ asset('images/logo_jurnal_side_bar.png') }}" alt="EDU JOURNAL Logo">
            </div>
            <div>
                <h2>EDU JOURNAL</h2>
                <span>Portal Presensi Digital</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            @if(Auth::check() && Auth::user()->isWaka())
                <div class="menu-category">MENU WAKA</div>
                <a href="{{ route('waka.dashboard') }}" class="nav-item {{ request()->routeIs('waka.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Dashboard Waka</span>
                </a>
            @elseif(Auth::check() && Auth::user()->isKepalaSekolah())
                <div class="menu-category">MENU KEPALA SEKOLAH</div>
                <a href="{{ route('kepala-sekolah.dashboard') }}" class="nav-item {{ request()->routeIs('kepala-sekolah.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Dashboard Kepsek</span>
                </a>
            @elseif(Auth::check() && Auth::user()->isSatpam())
                @php
                    $countPendingValidasiSatpam = \App\Models\SiswaDispen::whereDate('tanggal', \Carbon\Carbon::today())
                        ->where(function($q) {
                            $q->where('status_waka', 'approved')
                              ->orWhere('status_wali_kelas', 'approved');
                        })
                        ->where('status_satpam', 'belum_keluar')
                        ->count();
                @endphp

                <div class="menu-category">UTAMA</div>
                <a href="{{ route('satpam.dashboard') }}" class="nav-item {{ request()->routeIs('satpam.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-grip"></i>
                    <span>Dashboard Satpam</span>
                </a>

                <div class="menu-category">DATA MASTER</div>
                <a href="{{ route('satpam.validasi') }}" class="nav-item {{ request()->routeIs('satpam.validasi*') ? 'active' : '' }}">
                    <i class="fa-solid fa-qrcode"></i>
                    <span>Validasi</span>
                    @if($countPendingValidasiSatpam > 0)
                        <span class="badge" style="margin-left: auto; background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 900; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4); padding: 0;">
                            {{ $countPendingValidasiSatpam }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('satpam.lapor-siswa') }}" class="nav-item {{ request()->routeIs('satpam.lapor-siswa*') ? 'active' : '' }}">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Lapor Siswa</span>
                </a>

                <a href="{{ route('satpam.log-aktivitas') }}" class="nav-item {{ request()->routeIs('satpam.log-aktivitas*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Log Aktivitas</span>
                </a>
            @elseif(Auth::check() && Auth::user()->isOrangTua())
                <div class="menu-category">MENU ORANG TUA</div>
                <a href="{{ route('orang-tua.dashboard') }}" class="nav-item {{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Portal Orang Tua</span>
                </a>
            @elseif(Auth::check() && Auth::user()->isGuruPiket())
                @php
                    $uObj = Auth::user();
                    $tglNow = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                    $gId = $uObj->id_guru ?? null;
                    if (!$gId && $uObj->nip) {
                        $gFind = \App\Models\Guru::where('nip', $uObj->nip)->first();
                        if ($gFind) $gId = $gFind->id_guru;
                    }

                    $piketAktifList = collect();
                    if ($gId) {
                        $piketAktifList = \App\Models\PenugasanGuruPengganti::where('status', 'aktif')
                            ->where('id_guru_pengganti', $gId)
                            ->whereDate('tanggal', $tglNow)
                            ->get();
                    }

                    $hasActivePenggantiPiket = $piketAktifList->isNotEmpty();

                    $penugasanUrgent = null;
                    foreach ($piketAktifList as $pUk) {
                        if ($pUk->hampir_habis) {
                            $penugasanUrgent = $pUk;
                            break;
                        }
                    }
                @endphp

                <div class="menu-category">MENU PETUGAS PIKET</div>
                
                <a href="{{ route('piket.dashboard') }}" class="nav-item {{ request()->routeIs('piket.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>

                @if($hasActivePenggantiPiket)
                    <a href="{{ route('piket.isi-jurnal-pengganti') }}" class="nav-item {{ request()->routeIs('piket.isi-jurnal-pengganti*') ? 'active' : '' }}" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24;">
                        <i class="fa-solid fa-file-pen" style="color: #fbbf24;"></i>
                        <span>Jurnal & Presensi Pengganti</span>
                        <span class="badge" style="margin-left: auto; background: #d97706; color: #fff; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: 800;">Aktif</span>
                    </a>
                @endif

                <a href="{{ route('piket.jurnal-mengajar') }}" class="nav-item {{ request()->routeIs('piket.jurnal-mengajar*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open-reader"></i>
                    <span>Jurnal Mengajar</span>
                </a>

                <a href="{{ route('piket.guru-pengganti') }}" class="nav-item {{ request()->routeIs('piket.guru-pengganti*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Guru Pengganti</span>
                </a>

                @php
                    $countPendingIzinPiket = \App\Models\GuruIzin::where('is_pengajuan_guru', 1)->where('status_piket', 'pending')->count();
                @endphp

                <a href="{{ route('piket.permintaan-izin') }}" class="nav-item {{ request()->routeIs('piket.permintaan-izin*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Permintaan Izin Guru</span>
                    @if($countPendingIzinPiket > 0)
                        <span class="badge" style="margin-left: auto; background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 900; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4); padding: 0;">
                            {{ $countPendingIzinPiket }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="nav-item {{ request()->routeIs('piket.guru-izin-tidak-hadir*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-check"></i>
                    <span>Guru Izin Tidak Hadir</span>
                </a>

                <a href="{{ route('piket.surat-izin-siswa') }}" class="nav-item {{ request()->routeIs('piket.surat-izin-siswa*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <span>Surat Izin Siswa</span>
                </a>

                <a href="{{ route('piket.dispensasi-siswa') }}" class="nav-item {{ request()->routeIs('piket.dispensasi-siswa*') ? 'active' : '' }}">
                    <i class="fa-solid fa-id-card-clip"></i>
                    <span>Dispensasi Siswa</span>
                </a>

                <a href="{{ route('piket.siswa-telat') }}" class="nav-item {{ request()->routeIs('piket.siswa-telat*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-clock"></i>
                    <span>Siswa Telat</span>
                </a>

                <a href="{{ route('piket.jadwal') }}" class="nav-item {{ request()->routeIs('piket.jadwal*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Hari Ini</span>
                </a>

                <a href="{{ route('piket.rekap-kehadiran') }}" class="nav-item {{ request()->routeIs('piket.rekap-kehadiran*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Rekap Kehadiran</span>
                </a>

                <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>Pengaturan</span>
                </a>
            @else
                @php
                    $unreadPengumumanCount = 0;
                    if (Auth::check()) {
                        $uId = Auth::id();
                        $unreadPengumumanCount = \App\Models\Pengumuman::where('status', 'aktif')
                            ->whereNull('deleted_at')
                            ->whereDoesntHave('reads', function($q) use ($uId) {
                                $q->where('user_id', $uId);
                            })->count();
                    }
                @endphp

                <div class="menu-category">MENU UTAMA</div>

                <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('guru.pengumuman') }}" class="nav-item {{ request()->routeIs('guru.pengumuman*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Pengumuman</span>
                    @if($unreadPengumumanCount > 0)
                        <span class="badge" style="margin-left: auto; background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 900; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4); padding: 0;">
                            {{ $unreadPengumumanCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('guru.jadwal') }}" class="nav-item {{ request()->routeIs('guru.jadwal') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Mengajar</span>
                </a>

                <a href="{{ route('guru.jurnal-harian') }}" class="nav-item {{ request()->routeIs('guru.jurnal-harian') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Jurnal Harian</span>
                </a>

                <a href="{{ route('guru.absensi-siswa') }}" class="nav-item {{ request()->routeIs('guru.absensi-siswa') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-check"></i>
                    <span>Presensi Siswa</span>
                </a>

                <a href="{{ route('guru.permintaan-izin') }}" class="nav-item {{ request()->routeIs('guru.permintaan-izin*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <span>Permintaan Izin Saya</span>
                </a>

                <a href="{{ route('guru.nilai-rapor') }}" class="nav-item {{ request()->routeIs('guru.nilai-rapor*') ? 'active' : '' }}">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Nilai & Rapor</span>
                </a>

                <a href="{{ route('guru.riwayat-jurnal') }}" class="nav-item {{ request()->routeIs('guru.riwayat-jurnal') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Riwayat Jurnal</span>
                </a>

                <a href="{{ route('guru.beralih-ke-guru-piket') }}" class="nav-item {{ request()->routeIs('guru.beralih-ke-guru-piket*') ? 'active' : '' }}">
                    <i class="fa-solid fa-right-left"></i>
                    <span>Beralih ke Guru Piket</span>
                </a>

                <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>Pengaturan Profil</span>
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
                <div class="avatar" style="overflow: hidden;">
                    @if(Auth::check() && Auth::user()->foto_url)
                        <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    @endif
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
            <div class="topbar-left">
            </div>

            <div class="topbar-right">
                <div class="semester-pill">
                    <i class="fa-solid fa-graduation-cap" style="color: #64748b; font-size: 14px;"></i>
                    <span>T.A. 2025/2026 - Semester Genap</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:11px; color: #94a3b8;"></i>
                </div>
                <button type="button" class="notification-btn" title="Notifikasi" style="position: relative;">
                    <i class="fa-regular fa-bell"></i>
                    @if(Auth::check() && Auth::user()->isSatpam() && isset($countPendingValidasiSatpam) && $countPendingValidasiSatpam > 0)
                        <span style="position: absolute; top: 4px; right: 4px; background: #ef4444; color: #ffffff; font-size: 10px; font-weight: 900; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.5); line-height: 1;">
                            {{ $countPendingValidasiSatpam }}
                        </span>
                    @endif
                </button>
                @include('partials.live-clock')
            </div>
        </header>

        <main class="content-body">
            @if(isset($penugasanUrgent) && $penugasanUrgent)
                <div class="alert alert-warning" style="background:#fffbebf0; border:1px solid #fde68a; color:#b45309; font-weight:700; border-radius:14px; margin-bottom:20px; padding:14px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px; box-shadow:0 4px 15px rgba(217,119,6,0.15);">
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div style="width:40px; height:40px; background:#fef3c7; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa-solid fa-bell fa-bounce" style="font-size:20px; color:#d97706;"></i>
                        </div>
                        <div>
                            <div style="font-size:14px; font-weight:800; color:#92400e;">PERINGATAN WAKTU JAM PELAJARAN (Tinggal {{ max($penugasanUrgent->sisa_menit_selesai, 0) }} Menit Lagi)</div>
                            <div style="font-size:12.5px; font-weight:600; color:#b45309; margin-top:2px;">
                                Jam pelajaran <strong>{{ $penugasanUrgent->jadwal->mapel->nama_mapel ?? ($penugasanUrgent->guruTidakHadir->mapel->nama_mapel ?? 'Mata Pelajaran') }}</strong> ({{ $penugasanUrgent->kelas->nama_kelas ?? 'Kelas' }}) akan berakhir pukul <strong>{{ $penugasanUrgent->waktu_selesai_effective }} WIB</strong> dan Jurnal belum diisi! Mohon segera lengkapi jurnal & presensi siswa.
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('piket.isi-jurnal-pengganti', ['id_penugasan' => $penugasanUrgent->id_penugasan]) }}" class="btn" style="background:#d97706; color:#ffffff; font-weight:800; padding:9px 18px; border-radius:10px; text-decoration:none; font-size:12.5px; white-space:nowrap; box-shadow:0 2px 6px rgba(217,119,6,0.3);">
                        <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Sekarang
                    </a>
                </div>
            @endif

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
