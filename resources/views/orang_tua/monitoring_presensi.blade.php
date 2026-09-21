@extends('layouts.orang_tua')

@section('title', 'Monitoring Presensi Siswa — Jurnal SMEA')

@section('styles')
<style>
    /* =========================================================
       COLOR PALETTE & DESIGN SYSTEM: ABU-ABU, BIRU, PUTIH & ACCENT
       ========================================================= */
    :root {
        --c-navy-deep: #1e293b;
        --c-navy-brand: #384972;
        --c-navy-hover: #4a5e8c;
        --c-blue-primary: #2563eb;
        --c-blue-light: #3b82f6;
        --c-blue-soft: #eff6ff;
        --c-blue-border: #bfdbfe;
        
        --c-gray-slate: #0f172a;
        --c-gray-dark: #334155;
        --c-gray-muted: #64748b;
        --c-gray-border: #e2e8f0;
        --c-gray-border-light: #cbd5e1;
        --c-gray-bg-light: #f8fafc;
        --c-gray-bg-soft: #f1f5f9;
        --c-white: #ffffff;
    }

    .monitoring-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2px;
    }
    .page-breadcrumb {
        font-size: 13px;
        font-weight: 700;
        color: var(--c-gray-muted);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-breadcrumb a {
        color: var(--c-navy-brand);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .page-breadcrumb a:hover {
        color: var(--c-blue-primary);
    }
    .page-breadcrumb span {
        color: var(--c-gray-slate);
        font-weight: 800;
    }
    .page-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }
    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--c-gray-slate);
        margin: 0 0 3px 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-title-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: var(--c-blue-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border: 1.5px solid var(--c-blue-border);
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.08);
    }
    .page-subtitle {
        margin: 0;
        color: var(--c-gray-muted);
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Controls: Date Picker & Refresh */
    .header-controls-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .date-filter-box {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--c-white);
        border: 1.5px solid var(--c-gray-border-light);
        padding: 7px 14px;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .date-filter-box:hover, .date-filter-box:focus-within {
        border-color: var(--c-blue-light);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .date-filter-box input[type="date"] {
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        color: var(--c-navy-deep);
        background: transparent;
        cursor: pointer;
    }
    .btn-action-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .btn-today-pill {
        background: var(--c-navy-brand);
        color: var(--c-white);
        box-shadow: 0 2px 6px rgba(56, 73, 114, 0.25);
    }
    .btn-today-pill:hover {
        background: var(--c-navy-hover);
        transform: translateY(-1px);
    }
    .btn-refresh-pill {
        background: var(--c-white);
        color: var(--c-blue-primary);
        border: 1.5px solid var(--c-blue-border);
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.05);
    }
    .btn-refresh-pill:hover {
        background: var(--c-blue-soft);
        border-color: var(--c-blue-primary);
        transform: translateY(-1px);
    }

    /* Student Profile Hero Card */
    .student-hero-card {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        background: var(--c-white);
        border-radius: 18px;
        padding: 18px 24px;
        border: 1.5px solid var(--c-gray-border);
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.03);
    }
    .student-avatar-box {
        width: 74px;
        height: 74px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid var(--c-gray-border-light);
        font-size: 28px;
        color: var(--c-navy-brand);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.04);
    }
    .student-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .student-name {
        margin: 0 0 5px 0;
        font-size: 20px;
        font-weight: 800;
        color: var(--c-gray-slate);
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .student-meta {
        font-size: 13px;
        font-weight: 600;
        color: var(--c-gray-muted);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .student-meta strong {
        color: var(--c-gray-dark);
        font-weight: 700;
    }
    .badge-pill-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .badge-status-aktif {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-wali-kelas {
        background: var(--c-navy-brand);
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-live-pulse {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .live-dot-green {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #16a34a;
        box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
        animation: livePulse 1.8s infinite;
    }
    @keyframes livePulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    /* === FITUR UTAMA: KARTU KEBERADAAN SISWA REAL-TIME (KOMBINASI BIRU & ABU-ABU MODERN) === */
    .live-presence-hero-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 45%, #1e293b 100%);
        border-radius: 20px;
        padding: 22px 26px;
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(30, 58, 138, 0.18);
        position: relative;
        overflow: hidden;
        border: 1.5px solid rgba(255, 255, 255, 0.15);
    }
    .live-presence-hero-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .presence-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 14px;
    }
    .presence-beacon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid rgba(74, 222, 128, 0.5);
        color: #86efac;
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .presence-content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1.1fr;
        gap: 20px;
        align-items: center;
    }
    @media (max-width: 900px) {
        .presence-content-grid { grid-template-columns: 1fr; }
    }
    .presence-main-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .presence-label {
        font-size: 11.5px;
        color: #bfdbfe;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .presence-location-title {
        font-size: 21px;
        font-weight: 800;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        text-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .presence-desc-short {
        font-size: 13.5px;
        color: #e2e8f0;
        font-weight: 500;
        line-height: 1.4;
        margin-top: 2px;
    }
    
    /* Frosted Glass Box */
    .presence-side-box {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }
    .presence-side-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12.5px;
        color: #e2e8f0;
    }
    .presence-side-row strong {
        color: #ffffff;
        font-weight: 700;
    }

    /* =========================================================
       SUMMARY STATS METRIC GRID (6 CARDS - MODERN PALETTE)
       ========================================================= */
    .summary-stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }
    @media (max-width: 1100px) {
        .summary-stats-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 650px) {
        .summary-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .stat-card-box {
        background: var(--c-white);
        border-radius: 15px;
        padding: 14px 16px;
        border: 1.5px solid var(--c-gray-border);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        border-color: var(--c-gray-border-light);
    }
    .stat-card-head {
        font-size: 11.5px;
        font-weight: 800;
        color: var(--c-gray-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .stat-icon-pill {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    .stat-card-val {
        font-size: 23px;
        font-weight: 800;
        color: var(--c-gray-slate);
        line-height: 1;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }
    .stat-card-sub {
        font-size: 11px;
        font-weight: 600;
        color: var(--c-gray-muted);
    }

    /* Individual Card Accents */
    .stat-card-total { border-top: 3px solid var(--c-navy-brand); }
    .stat-card-total .stat-icon-pill { background: #e0e7ff; color: var(--c-navy-brand); }

    .stat-card-hadir { border-top: 3px solid #16a34a; }
    .stat-card-hadir .stat-icon-pill { background: #dcfce7; color: #16a34a; }
    .stat-card-hadir .stat-card-val { color: #15803d; }

    .stat-card-sakit { border-top: 3px solid #2563eb; }
    .stat-card-sakit .stat-icon-pill { background: #dbeafe; color: #2563eb; }
    .stat-card-sakit .stat-card-val { color: #1d4ed8; }

    .stat-card-izin { border-top: 3px solid #d97706; }
    .stat-card-izin .stat-icon-pill { background: #fef3c7; color: #d97706; }
    .stat-card-izin .stat-card-val { color: #b45309; }

    .stat-card-alpa { border-top: 3px solid #dc2626; }
    .stat-card-alpa .stat-icon-pill { background: #fee2e2; color: #dc2626; }
    .stat-card-alpa .stat-card-val { color: #b91c1c; }

    .stat-card-dispen { border-top: 3px solid #9333ea; }
    .stat-card-dispen .stat-icon-pill { background: #f3e8ff; color: #9333ea; }
    .stat-card-dispen .stat-card-val { color: #7e22ce; }

    /* =========================================================
       TIMELINE & LESSON SCHEDULE CARDS (MODERN GRAY/BLUE/WHITE)
       ========================================================= */
    .timeline-container {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .lesson-schedule-card {
        background: var(--c-white);
        border-radius: 16px;
        border: 1.5px solid var(--c-gray-border);
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: all 0.2s ease;
        position: relative;
    }
    .lesson-schedule-card:hover {
        border-color: var(--c-gray-border-light);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }
    .lesson-schedule-card.is-ongoing {
        border-color: var(--c-blue-primary);
        background: #f8fbff;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.12);
    }
    .lesson-schedule-card.is-ongoing::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--c-blue-primary);
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }

    .lesson-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--c-gray-bg-soft);
    }
    .lesson-title-area {
        flex: 1;
        min-width: 240px;
    }
    .lesson-mapel-name {
        font-size: 16.5px;
        font-weight: 800;
        color: var(--c-gray-slate);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .lesson-meta-line {
        font-size: 12.5px;
        color: var(--c-gray-muted);
        font-weight: 600;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .lesson-meta-line strong {
        color: var(--c-gray-dark);
    }

    /* Badges */
    .badge-presensi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.3px;
    }
    .badge-presensi-hadir {
        background: #dcfce7;
        color: #15803d;
        border: 1.5px solid #86efac;
    }
    .badge-presensi-sakit {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1.5px solid #93c5fd;
    }
    .badge-presensi-izin {
        background: #fffbeb;
        color: #b45309;
        border: 1.5px solid #fde68a;
    }
    .badge-presensi-alpa {
        background: #fef2f2;
        color: #b91c1c;
        border: 1.5px solid #fca5a5;
    }
    .badge-presensi-dispen {
        background: #faf5ff;
        color: #7e22ce;
        border: 1.5px solid #d8b4fe;
    }
    .badge-presensi-ongoing {
        background: #e0f2fe;
        color: #0369a1;
        border: 1.5px solid #7dd3fc;
    }
    .badge-presensi-pending {
        background: var(--c-gray-bg-soft);
        color: var(--c-gray-muted);
        border: 1.5px solid var(--c-gray-border);
    }
    .badge-presensi-upcoming {
        background: var(--c-gray-bg-light);
        color: #94a3b8;
        border: 1.5px solid var(--c-gray-border);
    }

    /* Lesson Content Box - Clean Light Gray / Blue Tone */
    .lesson-content-box {
        margin-top: 12px;
        background: var(--c-gray-bg-light);
        border: 1px solid var(--c-gray-border);
        border-radius: 12px;
        padding: 13px 16px;
    }
    .lesson-materi-title {
        font-size: 13px;
        font-weight: 800;
        color: var(--c-navy-deep);
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .lesson-materi-text {
        font-size: 13px;
        color: var(--c-gray-dark);
        line-height: 1.4;
        font-weight: 500;
    }

    /* Image Preview Modal */
    .modal-img-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-img-content {
        max-width: 580px;
        width: 100%;
        background: var(--c-white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        border: 1px solid var(--c-gray-border);
    }
    .modal-img-content img {
        width: 100%;
        max-height: 420px;
        object-fit: contain;
        background: #0f172a;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="monitoring-wrapper">

    <!-- Page Header & Quick Controls -->
    <div class="page-header">
        <div class="page-breadcrumb">
            <a href="{{ route('orang-tua.dashboard') }}">Jurnal SMEA</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
            <span>Monitoring Presensi</span>
        </div>

        <div class="page-title-row">
            <div>
                <h1 class="page-title">
                    <span class="page-title-icon">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </span>
                    <span>Monitoring Presensi & Keberadaan Siswa</span>
                </h1>
                <p class="page-subtitle">
                    Pantau status kehadiran dan lokasi KBM anak secara langsung per jam pelajaran.
                </p>
            </div>

            <!-- Controls: Date Filter & Refresh -->
            <div class="header-controls-group">
                <form id="dateFilterForm" method="GET" action="{{ route('orang-tua.monitoring-presensi') }}" style="margin: 0;">
                    <div class="date-filter-box">
                        <i class="fa-regular fa-calendar-days" style="color: var(--c-blue-primary);"></i>
                        <input type="date" name="tanggal" id="filterTanggalInput" value="{{ $targetDateStr }}" onchange="document.getElementById('dateFilterForm').submit()">
                    </div>
                </form>

                @if(!$isToday)
                    <a href="{{ route('orang-tua.monitoring-presensi') }}" class="btn-action-pill btn-today-pill" title="Kembali ke Tanggal Hari Ini">
                        <i class="fa-solid fa-calendar-day"></i> Hari Ini
                    </a>
                @endif

                <button type="button" onclick="refreshMonitoringData()" class="btn-action-pill btn-refresh-pill" id="btnManualRefresh" title="Segarkan Data Real-Time">
                    <i class="fa-solid fa-rotate" id="refreshIcon"></i>
                    <span>Segarkan</span>
                </button>
            </div>
        </div>
    </div>

    @if($siswa)
        <!-- Student Profile Hero Card -->
        <div class="student-hero-card">
            <div class="student-avatar-box">
                @if($siswa->foto_url)
                    <img src="{{ $siswa->foto_url }}" alt="{{ $siswa->nama_siswa }}">
                @else
                    <i class="fa-solid fa-user-graduate"></i>
                @endif
            </div>

            <div style="flex: 1; min-width: 260px;">
                <h2 class="student-name">
                    <span>{{ $siswa->nama_siswa }}</span>
                </h2>
                <div class="student-meta">
                    <span>Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>NISN: <strong>{{ $siswa->nisn ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>NIS: <strong>{{ $siswa->nis ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>Jurusan: <strong>{{ $siswa->kelas->jurusan->nama_jurusan ?? ($siswa->jurusan ?? 'SMK SMEA') }}</strong></span>
                </div>
                <div class="badge-pill-group">
                    <span class="badge-status-aktif">
                        <i class="fa-solid fa-circle-check"></i> Siswa Aktif
                    </span>
                    <span class="badge-wali-kelas">
                        <i class="fa-solid fa-user-tie"></i> Wali Kelas: {{ $siswa->kelas->waliKelas->nama_guru ?? ($siswa->kelas->wali_kelas ?? 'Sulistyowati, S.Pd') }}
                    </span>
                    @if($isToday)
                        <span class="badge-live-pulse" title="Sistem terhubung real-time dengan Jurnal Guru">
                            <span class="live-dot-green"></span> REAL-TIME KBM
                        </span>
                    @else
                        <span style="font-size: 11.5px; font-weight: 700; color: #475569; background: #f1f5f9; padding: 4px 12px; border-radius: 20px; border: 1px solid #e2e8f0;">
                            <i class="fa-regular fa-clock-rotate-left"></i> Riwayat: {{ $formattedDate }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- === FITUR UTAMA: LIVE KEBERADAAN SISWA SAAT INI (REAL-TIME TRACKER) === -->
        @if(isset($currentLivePresence) && $currentLivePresence)
            <div class="live-presence-hero-card">
                <div class="presence-top-row">
                    <div class="presence-beacon">
                        <span class="live-dot-green"></span> KEBERADAAN SISWA SAAT INI
                    </div>
                    <div style="font-size: 12px; color: #dbeafe; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-regular fa-clock" style="color: #93c5fd;"></i>
                        <span>Terakhir Dicek: <strong id="lastUpdatedClock" style="color: #ffffff;">{{ Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }} WIB</strong></span>
                    </div>
                </div>

                <div class="presence-content-grid">
                    <div class="presence-main-info">
                        <div class="presence-label">Lokasi / Aktivitas Pembelajaran Sekarang:</div>
                        <div class="presence-location-title" id="liveLokasiTitle">
                            <i class="fa-solid {{ $currentLivePresence['status_icon'] }}" style="color: #93c5fd; font-size: 20px;"></i>
                            <span>{{ $currentLivePresence['lokasi_teks'] }}</span>
                        </div>
                        <div class="presence-desc-short" id="liveKeteranganSingkat">
                            {{ $currentLivePresence['keterangan_singkat'] }}
                        </div>
                    </div>

                    <div class="presence-side-box">
                        <div class="presence-side-row">
                            <span>Status Hadir:</span>
                            <strong style="color: #86efac;" id="liveStatusPresensi">
                                <i class="fa-solid fa-circle-check" style="font-size: 11px; margin-right: 4px;"></i> {{ strtoupper($currentLivePresence['status_presensi']) }}
                            </strong>
                        </div>
                        @if($currentLivePresence['is_active_kbm'])
                            <div class="presence-side-row">
                                <span>Guru Pengajar:</span>
                                <strong id="liveGuruName">{{ $currentLivePresence['guru'] }}</strong>
                            </div>
                            <div class="presence-side-row">
                                <span>Sesi / Waktu:</span>
                                <strong id="liveJamWaktu">{{ $currentLivePresence['jam_ke'] }} ({{ $currentLivePresence['waktu'] }})</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Summary Metric Cards Grid (6 Clean Cards) -->
        <div class="summary-stats-grid">
            <!-- Total Jam KBM -->
            <div class="stat-card-box stat-card-total">
                <div class="stat-card-head">
                    <span>Total KBM</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statTotalJam">{{ $summary['total_jam'] }}</div>
                <div class="stat-card-sub">Jadwal Hari Ini</div>
            </div>

            <!-- Jam Hadir -->
            <div class="stat-card-box stat-card-hadir">
                <div class="stat-card-head">
                    <span style="color: #16a34a;">Hadir</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statHadir">{{ $summary['hadir'] }}</div>
                <div class="stat-card-sub">Jam Pelajaran</div>
            </div>

            <!-- Jam Sakit -->
            <div class="stat-card-box stat-card-sakit">
                <div class="stat-card-head">
                    <span style="color: #2563eb;">Sakit</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statSakit">{{ $summary['sakit'] }}</div>
                <div class="stat-card-sub">Jam Pelajaran</div>
            </div>

            <!-- Jam Izin -->
            <div class="stat-card-box stat-card-izin">
                <div class="stat-card-head">
                    <span style="color: #d97706;">Izin</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statIzin">{{ $summary['izin'] }}</div>
                <div class="stat-card-sub">Jam Pelajaran</div>
            </div>

            <!-- Jam Alpa -->
            <div class="stat-card-box stat-card-alpa">
                <div class="stat-card-head">
                    <span style="color: #dc2626;">Alpa</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statAlpa">{{ $summary['alpa'] }}</div>
                <div class="stat-card-sub">Tanpa Keterangan</div>
            </div>

            <!-- Jam Dispen -->
            <div class="stat-card-box stat-card-dispen">
                <div class="stat-card-head">
                    <span style="color: #9333ea;">Dispen</span>
                    <div class="stat-icon-pill">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                </div>
                <div class="stat-card-val" id="statDispen">{{ $summary['dispen'] }}</div>
                <div class="stat-card-sub">Disetujui Waka</div>
            </div>
        </div>

        <!-- Notification Alerts (Dispen, Telat) -->
        @if($dispenHariIni->isNotEmpty())
            @foreach($dispenHariIni as $dp)
                <div style="background: #faf5ff; border: 1.5px solid #d8b4fe; color: #6b21a8; padding: 12px 18px; border-radius: 14px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 6px rgba(147, 51, 234, 0.04);">
                    <i class="fa-solid fa-file-circle-check" style="font-size: 18px; color: #9333ea; flex-shrink: 0;"></i>
                    <div>
                        <span>Pemberitahuan Waka Kesiswaan: Siswa <strong>Dispen Resmi Disetujui</strong> (Jam {{ substr($dp->jam_keluar, 0, 5) }} - {{ substr($dp->jam_kembali, 0, 5) }} WIB) • <em>{{ $dp->alasan ?? 'Dispensasi Kegiatan' }}</em></span>
                    </div>
                </div>
            @endforeach
        @endif

        @if($telatHariIni)
            <div style="background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; padding: 12px 18px; border-radius: 14px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 6px rgba(217, 119, 6, 0.04);">
                <i class="fa-solid fa-user-clock" style="font-size: 18px; color: #d97706; flex-shrink: 0;"></i>
                <div>
                    <span>Pemberitahuan Guru Piket: Siswa <strong>Terlambat Masuk</strong> (Pukul {{ $telatHariIni->jam_terlambat }} WIB) • Alasan: <em>{{ $telatHariIni->alasan ?? 'Terlambat' }}</em></span>
                </div>
            </div>
        @endif

        <!-- Timeline Section Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-top: 4px;">
            <div>
                <h3 style="font-size: 16.5px; font-weight: 800; color: var(--c-gray-slate); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-list-check" style="color: var(--c-blue-primary);"></i>
                    <span>Jadwal KBM & Presensi Siswa ({{ $formattedDate }})</span>
                </h3>
                <p style="font-size: 12.5px; color: var(--c-gray-muted); margin: 2px 0 0 0; font-weight: 500;">
                    Status kehadiran di bawah ini langsung terhubung dengan pengisian Jurnal Mengajar guru.
                </p>
            </div>

            <div style="font-size: 12px; color: var(--c-navy-deep); font-weight: 800; background: var(--c-white); border: 1.5px solid var(--c-gray-border); padding: 5px 14px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                Total {{ count($timelineKbm) }} Sesi Jam KBM
            </div>
        </div>

        <!-- Timeline Cards Container -->
        <div class="timeline-container" id="timelineContainer">
            @forelse($timelineKbm as $tItem)
                <div class="lesson-schedule-card {{ $tItem->is_ongoing ? 'is-ongoing' : '' }}" id="cardJadwal_{{ $tItem->id_jadwal }}">
                    <div class="lesson-card-header">
                        <div class="lesson-title-area">
                            <div class="lesson-mapel-name">
                                <span>{{ $tItem->mapel }}</span>
                                @if($tItem->is_ongoing)
                                    <span style="font-size: 11px; background: #dbeafe; color: #1d4ed8; padding: 2px 9px; border-radius: 6px; font-weight: 800; border: 1px solid #bfdbfe; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-satellite-dish"></i> Jam KBM Aktif
                                    </span>
                                @endif
                            </div>

                            <div class="lesson-meta-line">
                                <span><i class="fa-regular fa-clock" style="color: var(--c-blue-primary);"></i> Jam Ke-{{ $tItem->jam_ke }} (<strong>{{ $tItem->waktu }}</strong>)</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-chalkboard-user" style="color: var(--c-gray-muted);"></i> Guru: <strong>{{ $tItem->guru }}</strong></span>
                                <span>•</span>
                                <span><i class="fa-solid fa-door-open" style="color: var(--c-gray-muted);"></i> Ruangan: <strong>{{ $tItem->ruangan }}</strong></span>
                            </div>
                        </div>

                        <!-- Right Attendance Status Badge -->
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                            <span class="badge-presensi {{ $tItem->status_badge_class }}">
                                <i class="fa-solid {{ $tItem->status_icon }}"></i>
                                <span>{{ strtoupper($tItem->status_presensi) }}</span>
                            </span>
                            <span style="font-size: 11px; font-weight: 700; color: var(--c-gray-muted);">
                                {{ $tItem->status_jurnal_teks }}
                            </span>
                        </div>
                    </div>

                    <!-- Lesson Content & Material Box (Modern Light Gray/Blue Container) -->
                    <div class="lesson-content-box">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div style="flex: 1; min-width: 240px;">
                                <div class="lesson-materi-title">
                                    <i class="fa-solid fa-book-open" style="color: var(--c-blue-primary);"></i>
                                    <span>Materi Pembelajaran:</span>
                                </div>
                                <div class="lesson-materi-text">
                                    @if($tItem->materi)
                                        <strong style="color: var(--c-gray-slate);">{{ $tItem->materi }}</strong>
                                        @if($tItem->pertemuan_ke)
                                            <span style="font-size: 11px; background: #e2e8f0; color: var(--c-navy-deep); padding: 2px 7px; border-radius: 4px; margin-left: 4px; font-weight: 800;">
                                                {{ $tItem->pertemuan_ke }}
                                            </span>
                                        @endif
                                    @else
                                        <em style="color: #94a3b8;">{{ $tItem->is_ongoing ? 'Sedang melangsungkan kegiatan belajar mengajar.' : 'Materi belum dicatat guru.' }}</em>
                                    @endif
                                </div>

                                @if($tItem->catatan)
                                    <div style="margin-top: 6px; font-size: 12.5px; color: var(--c-gray-dark);">
                                        <strong style="color: var(--c-navy-deep);"><i class="fa-regular fa-comment-dots" style="color: var(--c-blue-primary);"></i> Catatan:</strong> {{ $tItem->catatan }}
                                    </div>
                                @endif

                                <div style="margin-top: 6px; font-size: 11.5px; color: var(--c-gray-muted); display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <span><i class="fa-solid fa-circle-info" style="color: var(--c-blue-primary);"></i> Status: <strong>{{ $tItem->keterangan_presensi }}</strong></span>
                                    @if($tItem->kondisi_kelas)
                                        <span>•</span>
                                        <span>Kondisi: <strong>{{ $tItem->kondisi_kelas }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            @if($tItem->dokumentasi_url)
                                <div>
                                    <button type="button" onclick="openPhotoModal('{{ $tItem->dokumentasi_url }}', '{{ $tItem->mapel }} - Jam Ke-{{ $tItem->jam_ke }}')" style="background: var(--c-white); border: 1.5px solid var(--c-gray-border); border-radius: 10px; padding: 5px 10px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.03);" title="Lihat foto bukti KBM">
                                        <div style="width: 34px; height: 34px; border-radius: 6px; overflow: hidden; background: #0f172a; flex-shrink: 0; border: 1px solid var(--c-gray-border);">
                                            <img src="{{ $tItem->dokumentasi_url }}" alt="Foto KBM" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div style="text-align: left;">
                                            <div style="font-size: 11.5px; font-weight: 800; color: var(--c-gray-slate);">Foto KBM</div>
                                            <div style="font-size: 10.5px; color: #16a34a; font-weight: 800;"><i class="fa-solid fa-eye"></i> Lihat Foto</div>
                                        </div>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="background: var(--c-white); border-radius: 16px; border: 1.5px solid var(--c-gray-border); padding: 36px 20px; text-align: center; color: var(--c-gray-muted);">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--c-gray-bg-soft); color: var(--c-gray-muted); display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px auto; border: 1px solid var(--c-gray-border);">
                        <i class="fa-regular fa-calendar-xmark"></i>
                    </div>
                    <div style="font-size: 15px; font-weight: 800; color: var(--c-gray-slate);">Tidak Ada Jadwal Pelajaran</div>
                    <div style="font-size: 13px; color: var(--c-gray-muted); margin-top: 3px;">
                        Tidak ditemukan jadwal KBM untuk kelas siswa pada {{ $formattedDate }}.
                    </div>
                </div>
            @endforelse
        </div>

    @else
        <div style="background: var(--c-white); border-radius: 16px; border: 1.5px solid var(--c-gray-border); padding: 36px 20px; text-align: center; color: var(--c-gray-muted);">
            <div style="font-size: 32px; color: #94a3b8; margin-bottom: 10px;">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div style="font-size: 16px; font-weight: 800; color: var(--c-gray-slate);">Data Siswa Tidak Ditemukan</div>
            <div style="font-size: 13px; color: var(--c-gray-muted); margin-top: 3px;">
                Akun orang tua ini belum terhubung dengan data siswa aktif. Silakan hubungi admin sekolah.
            </div>
        </div>
    @endif

</div>

<!-- Photo Preview Modal -->
<div class="modal-img-backdrop" id="photoModalBackdrop" onclick="closePhotoModal()">
    <div class="modal-img-content" onclick="event.stopPropagation()">
        <div style="padding: 12px 18px; background: var(--c-white); display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--c-gray-border);">
            <span style="font-size: 13.5px; font-weight: 800; color: var(--c-gray-slate);" id="photoModalTitle">Foto Bukti KBM</span>
            <button type="button" onclick="closePhotoModal()" style="background: none; border: none; font-size: 17px; color: var(--c-gray-muted); cursor: pointer; padding: 4px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <img id="photoModalImg" src="" alt="Bukti Foto KBM">
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openPhotoModal(url, title) {
        const modal = document.getElementById('photoModalBackdrop');
        const img = document.getElementById('photoModalImg');
        const titleEl = document.getElementById('photoModalTitle');
        if (modal && img) {
            img.src = url;
            if (titleEl) titleEl.textContent = 'Foto Bukti: ' + title;
            modal.style.display = 'flex';
        }
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModalBackdrop');
        if (modal) modal.style.display = 'none';
    }

    function refreshMonitoringData() {
        const refreshIcon = document.getElementById('refreshIcon');
        if (refreshIcon) refreshIcon.classList.add('fa-spin');

        const currentTanggal = document.getElementById('filterTanggalInput')?.value || '{{ $targetDateStr }}';
        
        fetch('{{ route("orang-tua.api-monitoring-presensi") }}?tanggal=' + currentTanggal)
            .then(res => res.json())
            .then(data => {
                if (data && data.status === 'success' && data.data) {
                    updateMonitoringDom(data.data, data.timestamp);
                }
            })
            .catch(err => console.warn('Refresh error:', err))
            .finally(() => {
                if (refreshIcon) {
                    setTimeout(() => refreshIcon.classList.remove('fa-spin'), 600);
                }
            });
    }

    function updateMonitoringDom(data, timestamp) {
        const clock = document.getElementById('lastUpdatedClock');
        if (clock && timestamp) clock.textContent = timestamp + ' WIB';

        // Update Live Presence Hero Tracker
        const cur = data.currentLivePresence;
        if (cur) {
            const elLokasi = document.getElementById('liveLokasiTitle');
            const elKet = document.getElementById('liveKeteranganSingkat');
            const elStPres = document.getElementById('liveStatusPresensi');
            const elGuru = document.getElementById('liveGuruName');
            const elJamWaktu = document.getElementById('liveJamWaktu');

            if (elLokasi) elLokasi.innerHTML = `<i class="fa-solid ${cur.status_icon}" style="color: #93c5fd; font-size: 20px;"></i> <span>${cur.lokasi_teks}</span>`;
            if (elKet) elKet.textContent = cur.keterangan_singkat;
            if (elStPres) elStPres.innerHTML = `<i class="fa-solid fa-circle-check" style="font-size: 11px; margin-right: 4px;"></i> ${cur.status_presensi.toUpperCase()}`;
            if (elGuru && cur.guru) elGuru.textContent = cur.guru;
            if (elJamWaktu && cur.jam_ke) elJamWaktu.textContent = `${cur.jam_ke} (${cur.waktu})`;
        }

        // Update Summary Stats
        const summary = data.summary;
        if (summary) {
            const elTotal = document.getElementById('statTotalJam');
            const elHadir = document.getElementById('statHadir');
            const elSakit = document.getElementById('statSakit');
            const elIzin  = document.getElementById('statIzin');
            const elAlpa  = document.getElementById('statAlpa');
            const elDispen= document.getElementById('statDispen');

            if (elTotal) elTotal.textContent = summary.total_jam;
            if (elHadir) elHadir.textContent = summary.hadir;
            if (elSakit) elSakit.textContent = summary.sakit;
            if (elIzin)  elIzin.textContent  = summary.izin;
            if (elAlpa)  elAlpa.textContent  = summary.alpa;
            if (elDispen)elDispen.textContent= summary.dispen;
        }
    }

    @if($isToday)
        setInterval(refreshMonitoringData, 15000);
    @endif
</script>
@endsection
