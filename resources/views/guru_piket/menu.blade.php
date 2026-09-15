@extends('layouts.guru')

@section('title', 'Menu Petugas Piket — SMKN 1 BOYOLANGU')
@section('header_title', 'Menu')

@section('styles')
<style>
    .menu-page-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
        max-width: 100%;
        padding-bottom: 30px;
    }

    /* ─── MOBILE PAGE TOPBAR (FORMAT PERSIS SAMA DENGAN DISPENSASI SISWA) ─── */
    .mobile-page-topbar {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-topbar-title-wrap {
        flex: 1;
        min-width: 0;
    }

    .mobile-topbar-title {
        font-size: 18px;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
        line-height: 1.2;
        letter-spacing: -0.01em;
    }

    .mobile-topbar-sub {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        display: block;
        margin-top: 2px;
        line-height: 1.3;
    }

    /* ─── DESKTOP MENU GRID (Untuk Layar Desktop / Tablet) ─── */
    .desktop-menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        width: 100%;
    }

    .desktop-menu-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.22s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        position: relative;
    }

    .desktop-menu-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px -4px rgba(37, 99, 235, 0.12);
        border-color: #93c5fd;
    }

    .desktop-menu-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .desktop-menu-icon.blue    { background: #eff6ff; color: #2563eb; }
    .desktop-menu-icon.green   { background: #ecfdf5; color: #059669; }
    .desktop-menu-icon.amber   { background: #fffbeb; color: #d97706; }
    .desktop-menu-icon.purple  { background: #f5f3ff; color: #7c3aed; }
    .desktop-menu-icon.rose    { background: #fff1f2; color: #e11d48; }
    .desktop-menu-icon.indigo  { background: #eef2ff; color: #4f46e5; }
    .desktop-menu-icon.slate   { background: #f8fafc; color: #475569; }

    .desktop-menu-info {
        flex: 1;
        min-width: 0;
    }

    .desktop-menu-info h3 {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px 0;
    }

    .desktop-menu-info p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
        line-height: 1.3;
    }

    .desktop-menu-chevron {
        color: #cbd5e1;
        font-size: 13px;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .desktop-menu-card:hover .desktop-menu-chevron {
        color: #2563eb;
        transform: translateX(3px);
    }

    /* ─── MOBILE MENU LIST (FORMAT PERSIS SAMA DENGAN BOTTOM SHEET) ─── */
    .mobile-menu-list {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .page-menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 13px 18px;
        text-decoration: none;
        border-bottom: 1px solid #f1f5f9;
        box-sizing: border-box;
        transition: background 0.15s ease;
    }

    .page-menu-item:last-child {
        border-bottom: none;
    }

    .page-menu-item:hover,
    .page-menu-item:active {
        background: #f8fafc;
    }

    .page-menu-item.active {
        background: #eff6ff;
    }

    .page-menu-left {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .page-menu-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #f1f5f9;
        flex-shrink: 0;
    }

    .page-menu-item.active .page-menu-icon {
        background: #dbeafe;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .page-menu-text {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
    }

    .page-menu-item.active .page-menu-text {
        color: #1e3a8a;
        font-weight: 800;
    }

    .page-menu-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .page-menu-badge {
        font-size: 11px;
        font-weight: 700;
        background: #fee2e2;
        color: #ef4444;
        padding: 2px 7px;
        border-radius: 9999px;
    }

    .page-menu-active-pill {
        font-size: 10.5px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .page-menu-chevron {
        font-size: 12px;
        color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .desktop-menu-grid {
            display: none !important;
        }
        .mobile-menu-list {
            display: flex !important;
        }
    }

    @media (min-width: 769px) {
        .mobile-menu-list {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="menu-page-container">

    <!-- ─── HEADER HALAMAN MENU (FORMAT PERSIS SAMA DENGAN DISPENSASI SISWA) ─── -->
    <div class="mobile-page-topbar">
        <div class="mobile-topbar-title-wrap">
            <h1 class="mobile-topbar-title">Menu</h1>
            <span class="mobile-topbar-sub">Akses semua fitur dan menu petugas piket</span>
        </div>
    </div>

    <!-- ─── MOBILE VIEW: LIST DAFTAR 10 MENU ─── -->
    <div class="mobile-menu-list">
        {{-- 1. Jurnal Mengajar --}}
        <a href="{{ route('piket.jurnal-mengajar') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <span class="page-menu-text">Jurnal Mengajar</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 2. Guru Pengganti --}}
        <a href="{{ route('piket.guru-pengganti') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <span class="page-menu-text">Guru Pengganti</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 3. Permintaan Izin Guru --}}
        <a href="{{ route('piket.permintaan-izin') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <span class="page-menu-text">Permintaan Izin Guru</span>
            </div>
            <div class="page-menu-right">
                @if(isset($countPendingIzinPiket) && $countPendingIzinPiket > 0)
                    <span class="page-menu-badge">{{ $countPendingIzinPiket }}</span>
                @endif
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 4. Guru Izin Tidak Hadir --}}
        <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <span class="page-menu-text">Guru Izin Tidak Hadir</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 5. Surat Izin Siswa --}}
        <a href="{{ route('piket.surat-izin-siswa') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <span class="page-menu-text">Surat Izin Siswa</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 6. Dispensasi Siswa --}}
        <a href="{{ route('piket.dispensasi-siswa') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <span class="page-menu-text">Dispensasi Siswa</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 7. Siswa Telat --}}
        <a href="{{ route('piket.siswa-telat') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <span class="page-menu-text">Siswa Telat</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 8. Jadwal Hari Ini --}}
        <a href="{{ route('piket.jadwal') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="page-menu-text">Jadwal Hari Ini</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 9. Rekap Kehadiran --}}
        <a href="{{ route('piket.rekap-kehadiran') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
                <span class="page-menu-text">Rekap Kehadiran</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>

        {{-- 10. Pengaturan --}}
        <a href="{{ route('pengaturan.index') }}" class="page-menu-item">
            <div class="page-menu-left">
                <div class="page-menu-icon">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <span class="page-menu-text">Pengaturan</span>
            </div>
            <div class="page-menu-right">
                <i class="fa-solid fa-chevron-right page-menu-chevron"></i>
            </div>
        </a>
    </div>

    <!-- ─── DESKTOP VIEW: GRID 10 KARTU MENU FITUR ─── -->
    <div class="desktop-menu-grid">
        <a href="{{ route('piket.jurnal-mengajar') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon blue">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Jurnal Mengajar</h3>
                <p>Monitoring & kelola jurnal mengajar harian</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.guru-pengganti') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon amber">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Guru Pengganti</h3>
                <p>Kelola penugasan guru pengganti piket</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.permintaan-izin') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon purple">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Permintaan Izin Guru</h3>
                <p>Verifikasi & persetujuan izin ketidakhadiran</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon green">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Guru Izin Tidak Hadir</h3>
                <p>Daftar guru yang berhalangan hadir hari ini</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.surat-izin-siswa') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon indigo">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Surat Izin Siswa</h3>
                <p>Input & riwayat surat izin ketidakhadiran siswa</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.dispensasi-siswa') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon blue">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Dispensasi Siswa</h3>
                <p>Kelola permohonan dispensasi keluar sekolah</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.siswa-telat') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon rose">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Siswa Telat</h3>
                <p>Pencatatan & riwayat keterlambatan siswa</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.jadwal') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon amber">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Jadwal Hari Ini</h3>
                <p>Jadwal pelajaran & status KBM sekolah hari ini</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('piket.rekap-kehadiran') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon green">
                <i class="fa-solid fa-chart-column"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Rekap Kehadiran</h3>
                <p>Presensi guru & rekapitulasi data KBM</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>

        <a href="{{ route('pengaturan.index') }}" class="desktop-menu-card">
            <div class="desktop-menu-icon slate">
                <i class="fa-solid fa-gear"></i>
            </div>
            <div class="desktop-menu-info">
                <h3>Pengaturan</h3>
                <p>Profil akun, keamanan & preferensi sistem</p>
            </div>
            <i class="fa-solid fa-chevron-right desktop-menu-chevron"></i>
        </a>
    </div>

</div>
@endsection
