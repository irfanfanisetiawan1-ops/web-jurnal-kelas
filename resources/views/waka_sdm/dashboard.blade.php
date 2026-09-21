@extends('layouts.waka_sdm')

@section('title', 'Dashboard SDM — EduJournal')
@section('page-header', 'Dashboard Waka SDM')
@section('page-subheader', 'Ringkasan performa kepegawaian, pengajuan izin guru, dan monitoring KBM terpadu')

@section('styles')
<style>
    :root {
        --slate-dark: #1e293b;
        --slate-medium: #334155;
        --slate-light: #475569;
        --slate-muted: #64748b;
        --gray-bg: #f8fafc;
        --gray-surface: #f1f5f9;
        --gray-border: #e2e8f0;
        --gray-border-subtle: #cbd5e1;
        --primary-accent: #2563eb;
    }

    /* Elegant Gray Slate Banner */
    .gray-welcome-banner {
        background: linear-gradient(135deg, #1e293b 0%, #334155 55%, #475569 100%);
        border-radius: 18px;
        padding: 24px 28px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px -5px rgba(30, 41, 59, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .gray-welcome-banner::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -40px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .welcome-text h2 {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
    }

    .welcome-text p {
        font-size: 13.5px;
        color: #cbd5e1;
        margin: 0;
        font-weight: 500;
        line-height: 1.5;
    }
    /* Primary Stats Grid (Refined Gray & Warm Gray Palette) */
    .primary-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .primary-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
        transition: all 0.25s ease;
        position: relative;
    }

    .primary-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }

    .primary-stat-card .card-top {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .primary-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .primary-stat-icon.slate { background: #28334a; color: #ffffff; }
    .primary-stat-icon.warm-gray { background: #d3be9e; color: #ffffff; }
    .primary-stat-icon.taupe { background: #cfbe9f; color: #ffffff; }

    .primary-stat-card .card-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .primary-stat-card .card-val-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-top: 14px;
    }

    .primary-stat-card .card-value {
        font-size: 34px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .primary-stat-card .card-unit {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
    }

    .primary-stat-card .card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        text-decoration: none;
        margin-top: 14px;
        transition: color 0.15s;
    }

    .primary-stat-card .card-link:hover {
        color: #0f172a;
    }

    /* Secondary Monitoring Strip in Soft Neutral Slate Gray */
    .monitoring-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .strip-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease;
    }

    .strip-item:hover {
        transform: translateY(-2px);
    }

    .strip-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .strip-icon.green { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .strip-icon.purple { background: #faf5ff; color: #9333ea; border: 1px solid #f3e8ff; }
    .strip-icon.teal { background: #f0fdfa; color: #0d9488; border: 1px solid #ccfbf1; }
    .strip-icon.slate { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }

    .strip-info h4 {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin: 0;
    }

    .strip-info p {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin: 3px 0 0 0;
    }

    /* Dashboard Layout Grid */
    .dashboard-layout {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    /* Gray Modern Tabs Navigation */
    .tab-navigation {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 6px;
        border-radius: 14px;
        margin-bottom: 20px;
        overflow-x: auto;
    }

    .tab-btn {
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .tab-btn i {
        font-size: 14px;
    }

    .tab-btn:hover {
        color: #0f172a;
        background: #ffffff;
    }

    .tab-btn.active {
        background: #1e293b;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(30, 41, 59, 0.25);
    }

    .tab-btn .tab-badge {
        background: rgba(255,255,255,0.2);
        color: #ffffff;
        padding: 2px 7px;
        border-radius: 12px;
        font-size: 10.5px;
        font-weight: 800;
    }

    .tab-btn:not(.active) .tab-badge {
        background: #e2e8f0;
        color: #334155;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        margin-bottom: 24px;
    }

    .card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-head h3 {
        font-size: 15.5px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-head h3 i {
        color: #334155;
    }

    .head-link {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .head-link:hover {
        color: #0f172a;
        text-decoration: underline;
    }

    /* Custom Tables */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 12px 14px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 13px 14px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge {
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        line-height: 1.2;
    }

    .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-approved { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-rejected { background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; }
    .badge-process { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .badge-final-approved { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border: 1px solid #1d4ed8; box-shadow: 0 2px 5px rgba(37, 99, 235, 0.22); }
    .badge-slate { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
    .badge-teal { background: #f0fdfa; color: #0d9488; border: 1px solid #ccfbf1; }
    .badge-blue-soft { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* =========================================================================
       REFINED ACTION BUTTONS (BLUE, WHITE, BRIGHT LIGHT GRAY & SOFT ACCENTS)
       ========================================================================= */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .btn-action {
        padding: 7px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
        line-height: 1.2;
        white-space: nowrap;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    /* Tombol Setujui: Kombinasi Biru & Putih Elegan */
    .btn-approve {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        border: 1px solid #1d4ed8;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.28);
    }

    .btn-approve:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        transform: translateY(-1.5px);
        color: #ffffff !important;
    }

    .btn-approve:active {
        transform: translateY(0);
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.3);
    }

    /* Tombol Tolak: Putih & Merah Cerah dengan Border Halus */
    .btn-reject {
        background: #ffffff;
        color: #e11d48;
        border: 1.5px solid #fecdd3;
        box-shadow: 0 1px 4px rgba(225, 29, 72, 0.08);
    }

    .btn-reject:hover {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fda4af;
        box-shadow: 0 3px 10px rgba(225, 29, 72, 0.2);
        transform: translateY(-1.5px);
    }

    .btn-reject:active {
        transform: translateY(0);
    }

    /* Tombol Detail: Abu-Abu Muda Cerah & Slate Blue */
    .btn-detail {
        background: #f8fafc;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        padding: 7px 12px;
    }

    .btn-detail:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        transform: translateY(-1.5px);
    }

    .btn-detail:active {
        transform: translateY(0);
    }

    /* Quick Links in Sidebar */
    .quick-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quick-link-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.2s;
    }

    .quick-link-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateX(3px);
    }

    .quick-link-item .icon-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-link-item .icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        background: #e2e8f0;
        color: #334155;
    }

    /* Announcement Items */
    .announcement-item {
        padding: 13px 15px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 3px solid #475569;
        margin-bottom: 10px;
        transition: background 0.15s;
    }

    .announcement-item:hover {
        background: #f1f5f9;
    }

    .announcement-item h4 {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .announcement-item p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }

    .announcement-item .announcement-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 6px;
        font-size: 10.5px;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Modals */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 90%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.95);
        transition: transform 0.25s ease;
    }

    .modal-backdrop.active .modal-card {
        transform: scale(1);
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-radius: 0 0 20px 20px;
    }

    .btn-secondary {
        padding: 9px 16px;
        border-radius: 9px;
        background: #e2e8f0;
        color: #475569;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    @media (max-width: 1100px) {
        .primary-stats-grid { grid-template-columns: repeat(2, 1fr); }
        .monitoring-strip { grid-template-columns: repeat(2, 1fr); }
        .dashboard-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .primary-stats-grid { grid-template-columns: 1fr; }
        .monitoring-strip { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Elegant Slate Gray Welcome Banner -->
<div class="gray-welcome-banner">
    <div class="welcome-text">
        <h2>
            <i class="fa-solid fa-users-viewfinder" style="color: #cbd5e1;"></i>
            Selamat datang, {{ Auth::user()->name ?? 'Setiyo Winarko, S.Pd' }}!
        </h2>
        <p>Anda masuk sebagai <strong>Waka SDM</strong>. Kelola SDM Pendidik & Tenaga Kependidikan dengan efektif, terstruktur, dan terintegrasi sistem.</p>
    </div>
</div>

<!-- Primary Stats Grid (Tiga Kartu Utama Sesuai Referensi Gambar) -->
<div class="primary-stats-grid">
    <!-- Card 1: Permohonan Izin Menunggu -->
    <div class="primary-stat-card">
        <div class="card-top">
            <div class="primary-stat-icon slate">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div>
                <div class="card-title">Permohonan Izin Menunggu</div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">Menunggu Approval Waka SDM</div>
            </div>
        </div>
        <div class="card-val-row">
            <span class="card-value">{{ $countPendingApproval }}</span>
            <span class="card-unit">permohonan</span>
        </div>
        <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'pending']) }}" class="card-link">
            Lihat detail <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Card 2: Izin Diterima Bulan Ini -->
    <div class="primary-stat-card">
        <div class="card-top">
            <div class="primary-stat-icon warm-gray">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="card-title">Izin Diterima Bulan Ini</div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">Disetujui Waka SDM & Final</div>
            </div>
        </div>
        <div class="card-val-row">
            <span class="card-value">{{ $countApprovedBulanIni }}</span>
            <span class="card-unit">permohonan</span>
        </div>
        <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'approved']) }}" class="card-link">
            Lihat detail <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Card 3: Total Guru & SDM -->
    <div class="primary-stat-card">
        <div class="card-top">
            <div class="primary-stat-icon taupe">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <div>
                <div class="card-title">Guru Aktif</div>
                <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">Direktori Pendidik & SDM</div>
            </div>
        </div>
        <div class="card-val-row">
            <span class="card-value">{{ $totalGuru }}</span>
            <span class="card-unit">guru</span>
        </div>
        <a href="{{ route('waka-sdm.data-guru') }}" class="card-link">
            Lihat detail <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Secondary Monitoring Strip (Operasional SDM & KBM Terkoneksi) -->
<div class="monitoring-strip">
    <div class="strip-item">
        <div class="strip-icon green">
            <i class="fa-solid fa-chalkboard-user"></i>
        </div>
        <div class="strip-info">
            <h4>{{ $guruHadirHariIni }}</h4>
            <p>Guru Hadir Mengajar ({{ $selectedHari }})</p>
        </div>
    </div>

    <div class="strip-item">
        <div class="strip-icon purple">
            <i class="fa-solid fa-user-clock"></i>
        </div>
        <div class="strip-info">
            <h4>{{ $guruIzinHariIniCount }}</h4>
            <p>Guru Izin Tidak Hadir ({{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M') }})</p>
        </div>
    </div>

    <div class="strip-item">
        <div class="strip-icon teal">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="strip-info">
            <h4>{{ $guruPenggantiHariIni }}</h4>
            <p>Guru Pengganti Aktif Hari Ini</p>
        </div>
    </div>

    <div class="strip-item">
        <div class="strip-icon slate">
            <i class="fa-solid fa-chart-pie"></i>
        </div>
        <div class="strip-info">
            <h4>{{ $persentaseKbm }}%</h4>
            <p>KBM Terlaksana ({{ $jurnalTerisiHariIni }}/{{ $totalJadwalHariIni }} Jam)</p>
        </div>
    </div>
</div>

<!-- Main Dashboard Layout Grid -->
<div class="dashboard-layout">
    <!-- Left Column: Interactive Nav Tabs & Tables -->
    <div>
        <!-- Modern Gray Tabs Navigation -->
        <div class="tab-navigation">
            <button type="button" class="tab-btn active" onclick="switchDashboardTab('tab-approval', this)">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Approval Izin SDM</span>
                @if($countPendingApproval > 0)
                    <span class="tab-badge">{{ $countPendingApproval }}</span>
                @endif
            </button>
            <button type="button" class="tab-btn" onclick="switchDashboardTab('tab-piket', this)">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Terkoneksi Guru Piket</span>
                <span class="tab-badge">{{ $guruIzinHariIniCount + $guruPenggantiHariIni }}</span>
            </button>
            <button type="button" class="tab-btn" onclick="switchDashboardTab('tab-tu', this)">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Terkoneksi TU (Jadwal & Jam)</span>
                <span class="tab-badge">{{ $totalJadwalHariIni }}</span>
            </button>
            <button type="button" class="tab-btn" onclick="switchDashboardTab('tab-kbm', this)">
                <i class="fa-solid fa-chart-line"></i>
                <span>Realtime Monitoring KBM</span>
                <span class="tab-badge">{{ $jurnalTerisiHariIni }}</span>
            </button>
        </div>

        <!-- TAB 1: APPROVAL IZIN WAKA SDM & RIWAYAT PERSETUJUAN -->
        <div id="tab-approval" class="tab-content-pane">
            <!-- 1. Antrean Pengajuan Izin Menunggu Waka SDM -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-clipboard-question"></i>
                        Pengajuan Izin Guru (Menunggu Approval Waka SDM)
                    </h3>
                    <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="head-link">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th>Tanggal Izin</th>
                                <th>Kategori / Alasan</th>
                                <th>Status Waka SDM</th>
                                <th style="width: 1%; white-space: nowrap; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingGuruIzin as $izin)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $izin->tanggal_formatted }}</div>
                                        <span style="font-size: 11px; color: #64748b;">{{ $izin->durasi_formatted }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate" style="text-transform: uppercase;">{{ $izin->kategori_izin ?? 'biasa' }}</span>
                                        <div style="font-size: 12px; color: #334155; margin-top: 4px;">{{ Str::limit($izin->alasan, 40) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-pending">
                                            <i class="fa-solid fa-hourglass-half"></i> Pending Waka SDM
                                        </span>
                                    </td>
                                    <td style="white-space: nowrap; text-align: center;">
                                        <div class="action-btn-group">
                                            <button type="button" class="btn-action btn-approve" onclick="openApproveModal('{{ $izin->id_guru_izin }}', '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Setujui Pengajuan Izin">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                            <button type="button" class="btn-action btn-reject" onclick="openRejectModal('{{ $izin->id_guru_izin }}', '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Tolak Pengajuan Izin">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                            <button type="button" class="btn-action btn-detail" onclick="openDetailModal({{ json_encode($izin) }})" title="Lihat Rincian Pengajuan">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 32px;">
                                        <i class="fa-solid fa-circle-check" style="font-size: 32px; color: #16a34a; margin-bottom: 8px; display: block;"></i>
                                        Tidak ada antrean pengajuan izin yang menunggu persetujuan Waka SDM saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Riwayat Persetujuan Izin Guru Terakhir (Sesuai Referensi Gambar) -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-clock-rotate-left" style="color: #2563eb;"></i>
                        Riwayat Persetujuan Izin Guru Terakhir
                    </h3>
                    <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="head-link" style="color: #2563eb;">
                        Lihat Riwayat Lengkap <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Guru</th>
                                <th>Tanggal Izin</th>
                                <th style="text-align: center;">Waka Kur</th>
                                <th style="text-align: center;">Waka SDM</th>
                                <th style="text-align: center;">Kepsek</th>
                                <th style="text-align: center;">Status Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPengajuan as $r)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">{{ $r->guru->nama_guru ?? 'Guru' }}</div>
                                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 3px;">
                                            <span class="badge badge-slate" style="font-size: 10px; padding: 2px 7px; text-transform: uppercase;">{{ $r->kategori_izin ?? 'Izin' }}</span>
                                            <span style="font-size: 11px; color: #64748b;">NIP: {{ $r->guru->nip ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">
                                            <i class="fa-solid fa-calendar-day" style="color: #94a3b8; font-size: 11.5px; margin-right: 4px;"></i>
                                            {{ $r->tanggal_formatted }}
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if(in_array($r->status_waka, ['approved', 'Disetujui']))
                                            <span class="badge badge-approved"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif(in_array($r->status_waka, ['rejected', 'Ditolak']))
                                            <span class="badge badge-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if(in_array($r->status_waka_sdm, ['approved', 'Disetujui']))
                                            <span class="badge badge-approved"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif(in_array($r->status_waka_sdm, ['rejected', 'Ditolak']))
                                            <span class="badge badge-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if(in_array($r->status_kepsek, ['approved', 'Disetujui']))
                                            <span class="badge badge-approved"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif(in_array($r->status_kepsek, ['rejected', 'Ditolak']))
                                            <span class="badge badge-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @php
                                            $isAllApproved = ($r->status_waka === 'approved' && $r->status_waka_sdm === 'approved' && $r->status_kepsek === 'approved');
                                            $isAnyRejected = ($r->status_waka === 'rejected' || $r->status_waka_sdm === 'rejected' || $r->status_kepsek === 'rejected' || $r->status_final === 'rejected');
                                        @endphp
                                        @if($isAllApproved || $r->status_final === 'approved')
                                            <span class="badge badge-final-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Resmi</span>
                                        @elseif($isAnyRejected)
                                            <span class="badge badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge badge-process"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Belum ada riwayat persetujuan izin guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: TERINTEGRASI ROLE GURU PIKET -->
        <div id="tab-piket" class="tab-content-pane" style="display: none;">
            <!-- Subcard 1: Guru Izin Tidak Hadir Hari Ini -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-user-xmark" style="color: #b45309;"></i>
                        Guru Izin Tidak Hadir (Resmi Disetujui / Aktif)
                    </h3>
                    <span class="badge badge-slate">{{ $guruIzinHariIniCount }} Guru Izin Aktif</span>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Guru</th>
                                <th>Rentang Tanggal</th>
                                <th>Kategori / Alasan</th>
                                <th>Guru Pengganti (Piket)</th>
                                <th>Jadwal Terdampak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guruIzinHariIni as $giz)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">{{ $giz->guru->nama_guru ?? 'Guru' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIP: {{ $giz->guru->nip ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $giz->tanggal_formatted }}</div>
                                        <span style="font-size: 11px; color: #64748b;">{{ $giz->durasi_formatted }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">{{ strtoupper($giz->kategori_izin ?? 'biasa') }}</span>
                                        <div style="font-size: 12px; color: #334155; margin-top: 4px;">{{ $giz->alasan }}</div>
                                    </td>
                                    <td>
                                        @if($giz->has_penugasan)
                                            @foreach($giz->penugasans_list as $png)
                                                <div style="font-size: 12px; font-weight: 700; color: #15803d; margin-bottom: 2px;">
                                                    <i class="fa-solid fa-user-check"></i> {{ $png->guruPengganti->nama_guru ?? 'Pengganti' }}
                                                </div>
                                                <div style="font-size: 10.5px; color: #64748b;">Kelas: {{ $png->kelas->nama_kelas ?? '-' }}</div>
                                            @endforeach
                                        @else
                                            <span class="badge badge-pending">
                                                <i class="fa-solid fa-circle-exclamation"></i> Belum Ada Pengganti
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">
                                            {{ count($giz->jadwals_list ?? []) }} Jadwal Mengajar
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 28px;">
                                        <i class="fa-solid fa-user-check" style="font-size: 28px; color: #16a34a; margin-bottom: 6px; display: block;"></i>
                                        Tidak ada guru yang izin tidak hadir pada tanggal terpilih (Seluruh guru hadir/standby).
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Subcard 2: Penugasan Guru Pengganti Aktif Hari Ini (Sinkronisasi Guru Piket) -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-user-shield" style="color: #0d9488;"></i>
                        Daftar Penugasan Guru Pengganti (Sinkronisasi Guru Piket)
                    </h3>
                    <span class="badge badge-approved">{{ $guruPenggantiHariIni }} Penugasan</span>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Guru Tidak Hadir</th>
                                <th>Guru Pengganti</th>
                                <th>Kelas & Mapel</th>
                                <th>Jam Pelajaran</th>
                                <th>Status Penugasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penugasanGuruPengganti as $penugasan)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #dc2626;">
                                            <i class="fa-solid fa-user-xmark"></i> {{ $penugasan->guruTidakHadir->nama_guru ?? 'Guru Utama' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #16a34a;">
                                            <i class="fa-solid fa-user-check"></i> {{ $penugasan->guruPengganti->nama_guru ?? 'Guru Pengganti' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ $penugasan->kelas->nama_kelas ?? '-' }}</div>
                                        <span style="font-size: 11px; color: #64748b;">{{ $penugasan->jadwal->mapel->nama_mapel ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">
                                            {{ $penugasan->jam_pelajaran ?? 'Jam KBM' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($penugasan->is_diisi_hari_ini)
                                            <span class="badge badge-approved"><i class="fa-solid fa-check-double"></i> Jurnal Terisi</span>
                                        @else
                                            <span class="badge badge-slate"><i class="fa-solid fa-clock"></i> Aktif Bertugas</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">
                                        Belum ada penugasan guru pengganti yang tercatat pada tanggal terpilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: TERINTEGRASI ROLE TU (JADWAL PELAJARAN & MASTER JAM) -->
        <div id="tab-tu" class="tab-content-pane" style="display: none;">
            <!-- Subcard 1: Jadwal Pelajaran Sekolah -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-calendar-week" style="color: #334155;"></i>
                        Jadwal Pelajaran KBM — Hari {{ $selectedHari }}
                    </h3>
                    <div style="display: flex; gap: 8px;">
                        <span class="badge badge-slate">{{ $totalJadwalHariIni }} Sesi KBM</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Jam Ke</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengampu</th>
                                <th>Ruangan</th>
                                <th>Status Jurnal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalList as $jadwal)
                                <tr>
                                    <td>
                                        <span class="badge badge-slate">
                                            Jam Ke {{ $jadwal->id_jam_mulai }} - {{ $jadwal->id_jam_selesai }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $jadwal->kelas->nama_kelas ?? '-' }}</strong></td>
                                    <td>{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a;">{{ $jadwal->guru->nama_guru ?? 'Guru' }}</div>
                                    </td>
                                    <td>{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td>
                                        @if($jadwal->is_jurnal_diisi)
                                            <span class="badge badge-approved"><i class="fa-solid fa-circle-check"></i> Terisi</span>
                                        @else
                                            <span class="badge badge-pending"><i class="fa-solid fa-clock"></i> Belum</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada data jadwal pada hari {{ $selectedHari }}.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Subcard 2: Master Jam Pelajaran Sekolah (Data TU) -->
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-clock" style="color: #475569;"></i>
                        Master Jam Pelajaran Sekolah (Data Tata Usaha)
                    </h3>
                    <span class="badge badge-slate">{{ $jamPelajaranList->count() }} Slot Jam</span>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Jam Ke</th>
                                <th>Waktu Senin - Kamis (40 Menit)</th>
                                <th>Waktu Jumat (30 Menit)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jamPelajaranList as $jam)
                                <tr>
                                    <td>
                                        <strong>{{ str_starts_with($jam->jam_ke, 'Jam') ? $jam->jam_ke : 'Jam Ke-' . $jam->jam_ke }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">
                                            {{ substr($jam->jam_mulai, 0, 5) }} - {{ substr($jam->jam_selesai, 0, 5) }} WIB
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">
                                            {{ substr($jam->jam_mulai_jumat, 0, 5) }} - {{ substr($jam->jam_selesai_jumat, 0, 5) }} WIB
                                        </span>
                                    </td>
                                    <td>{{ $jam->keterangan ?? 'Jam Pembelajaran' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Master jam pelajaran belum dikonfigurasi oleh TU.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 4: REALTIME MONITORING KBM GURU -->
        <div id="tab-kbm" class="tab-content-pane" style="display: none;">
            <div class="dashboard-card">
                <div class="card-head">
                    <h3>
                        <i class="fa-solid fa-book-open-reader" style="color: #16a34a;"></i>
                        Monitoring Jurnal Mengajar & Presensi KBM Hari Ini
                    </h3>
                    <a href="{{ route('waka-sdm.kehadiran-guru') }}" class="head-link">
                        Lihat Seluruh KBM <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Guru Mengajar</th>
                                <th>Kelas & Mapel</th>
                                <th>Materi / Pembahasan</th>
                                <th>Waktu Pengisian</th>
                                <th>Guru Pengganti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalMonitoring as $jurnal)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">{{ $jurnal->jadwal->guru->nama_guru ?? 'Guru' }}</div>
                                    </td>
                                    <td>
                                        <strong>{{ $jurnal->jadwal->kelas->nama_kelas ?? '-' }}</strong>
                                        <div style="font-size: 11px; color: #64748b;">{{ $jurnal->jadwal->mapel->nama_mapel ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ Str::limit($jurnal->materi, 45) }}</div>
                                        @if($jurnal->keterangan)
                                            <span style="font-size: 11px; color: #64748b;">{{ Str::limit($jurnal->keterangan, 35) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">
                                            <i class="fa-solid fa-clock"></i> {{ $jurnal->created_at ? $jurnal->created_at->format('H:i') : ($jurnal->dicatat_pada ?? '-') }} WIB
                                        </span>
                                    </td>
                                    <td>
                                        @if($jurnal->id_guru_pengganti)
                                            <span class="badge badge-teal">
                                                <i class="fa-solid fa-user-check"></i> {{ $jurnal->guruPengganti->nama_guru ?? 'Pengganti' }}
                                            </span>
                                        @else
                                            <span style="font-size: 12px; color: #94a3b8;">- (Guru Utama)</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 28px;">
                                        <i class="fa-solid fa-clipboard" style="font-size: 28px; color: #cbd5e1; margin-bottom: 6px; display: block;"></i>
                                        Belum ada data jurnal mengajar yang diinput pada tanggal terpilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Actions & Broadcast Info -->
    <div>
        <!-- Card 1: Akses Cepat SDM -->
        <div class="dashboard-card">
            <div class="card-head">
                <h3>
                    <i class="fa-solid fa-bolt" style="color: #475569;"></i>
                    Akses Cepat SDM
                </h3>
            </div>
            <div class="quick-links">
                <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="quick-link-item">
                    <div class="icon-wrapper">
                        <div class="icon-box">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <span>Persetujuan Izin Guru</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('waka-sdm.kehadiran-guru') }}" class="quick-link-item">
                    <div class="icon-wrapper">
                        <div class="icon-box">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <span>Monitoring Kehadiran Guru</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('waka-sdm.data-guru') }}" class="quick-link-item">
                    <div class="icon-wrapper">
                        <div class="icon-box">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <span>Direktori Pendidik & SDM</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('waka-sdm.pengumuman') }}" class="quick-link-item">
                    <div class="icon-wrapper">
                        <div class="icon-box">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <span>Broadcast Pengumuman SDM</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>

                <button type="button" onclick="openQuickPengumumanModal()" class="quick-link-item" style="border: 1px dashed #64748b; background: #f8fafc; cursor: pointer; text-align: left; width: 100%;">
                    <div class="icon-wrapper">
                        <div class="icon-box" style="background: #334155; color: #ffffff;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <span style="color: #1e293b;">Buat Pengumuman Kilat</span>
                    </div>
                    <i class="fa-solid fa-pen-to-square" style="font-size: 12px; color: #334155;"></i>
                </button>
            </div>
        </div>

        <!-- Card 2: Pengumuman SDM & Sekolah Terbaru -->
        <div class="dashboard-card">
            <div class="card-head">
                <h3>
                    <i class="fa-solid fa-bullhorn" style="color: #475569;"></i>
                    Pengumuman SDM & Sekolah
                </h3>
                <a href="{{ route('waka-sdm.pengumuman') }}" class="head-link" style="font-size: 12px;">Kelola</a>
            </div>
            <div>
                @forelse($pengumumanTerbaru as $p)
                    <div class="announcement-item">
                        <h4>{{ $p->judul }}</h4>
                        <p>{{ Str::limit($p->isi, 75) }}</p>
                        <div class="announcement-meta">
                            <span><i class="fa-solid fa-tag"></i> {{ $p->kategori ?? 'SDM' }}</span>
                            <span><i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at)->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 12.5px; color: #94a3b8; text-align: center; padding: 14px;">Belum ada pengumuman aktif saat ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Card 3: Status Kesiapan Guru & KBM -->
        <div class="dashboard-card" style="background: #f8fafc;">
            <div class="card-head">
                <h3>
                    <i class="fa-solid fa-chart-simple" style="color: #334155;"></i>
                    Kesiapan Guru Hari Ini
                </h3>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 700; margin-bottom: 6px;">
                    <span style="color: #475569;">Tingkat Kehadiran Guru</span>
                    <span style="color: #16a34a;">{{ $totalGuru > 0 ? round((($totalGuru - $guruIzinHariIniCount) / $totalGuru) * 100) : 100 }}%</span>
                </div>
                <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden; margin-bottom: 14px;">
                    <div style="background: #16a34a; height: 100%; width: {{ $totalGuru > 0 ? round((($totalGuru - $guruIzinHariIniCount) / $totalGuru) * 100) : 100 }}%;"></div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 700; margin-bottom: 6px;">
                    <span style="color: #475569;">Progres Pengisian Jurnal KBM</span>
                    <span style="color: #334155;">{{ $persentaseKbm }}%</span>
                </div>
                <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                    <div style="background: #334155; height: 100%; width: {{ $persentaseKbm }}%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODALS SECTION
     ========================================================================= -->

<!-- 1. Modal Setujui Izin Guru -->
<div id="approveModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-check-circle" style="color: #2563eb; margin-right: 8px;"></i> Setujui Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <form id="approveForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 14px;">
                    Apakah Anda yakin ingin menyetujui pengajuan izin untuk guru: <strong id="approveGuruName" style="color: #0f172a;"></strong>?
                </p>
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">
                        Catatan Waka SDM (Opsional):
                    </label>
                    <textarea name="catatan" class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px;" placeholder="Contoh: Disetujui oleh Waka SDM. Koordinasikan materi dengan guru piket."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('approveModal')">Batal</button>
                <button type="submit" class="btn-action btn-approve" style="padding: 9px 20px; font-size: 13px;">
                    <i class="fa-solid fa-check"></i> Ya, Setujui Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Tolak Izin Guru -->
<div id="rejectModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-triangle-exclamation" style="color: #e11d48; margin-right: 8px;"></i> Tolak Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 14px;">
                    Apakah Anda yakin ingin menolak pengajuan izin untuk guru: <strong id="rejectGuruName" style="color: #0f172a;"></strong>?
                </p>
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">
                        Alasan Penolakan Waka SDM (Wajib):
                    </label>
                    <textarea name="catatan" required class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px;" placeholder="Contoh: Jadwal padat / materi ujian tidak dapat ditinggalkan."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('rejectModal')">Batal</button>
                <button type="submit" class="btn-action" style="padding: 9px 20px; font-size: 13px; background: #e11d48; color: #ffffff; border: 1px solid #be123c; box-shadow: 0 2px 6px rgba(225, 29, 72, 0.25);">
                    <i class="fa-solid fa-xmark"></i> Tolak Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Detail Izin Guru Lengkap -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 640px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-lines" style="color: #334155; margin-right: 8px;"></i> Rincian Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="modal-body" id="detailModalContent">
            <!-- Loaded dynamically via JS -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('detailModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- 4. Modal Buat Pengumuman Kilat SDM -->
<div id="quickPengumumanModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 600px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-bullhorn" style="color: #334155; margin-right: 8px;"></i> Terbitkan Pengumuman SDM Cepat</h3>
            <button type="button" class="modal-close" onclick="closeModal('quickPengumumanModal')">&times;</button>
        </div>
        <form action="{{ route('waka-sdm.pengumuman.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div style="margin-bottom: 12px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Judul Pengumuman *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Rapat Koordinasi Kedisiplinan Guru" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Kategori *</label>
                        <select name="kategori" required style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                            <option value="SDM / Kepegawaian">SDM / Kepegawaian</option>
                            <option value="Kedisiplinan & Presensi">Kedisiplinan & Presensi</option>
                            <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Tanggal Berlaku *</label>
                        <input type="date" name="tanggal" required value="{{ $today }}" min="{{ $today }}" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                    </div>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Waktu / Jam *</label>
                    <input type="hidden" name="jam_mengajar_select" value="custom">
                    <input type="text" name="jam_mengajar_custom" required placeholder="Contoh: 08:00 - Selesai WIB" value="Sepanjang Hari" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Isi Pengumuman *</label>
                    <textarea name="isi" required rows="3" placeholder="Tuliskan isi pengumuman lengkap di sini..." style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit;"></textarea>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Keterangan Tambahan *</label>
                    <input type="text" name="keterangan" required value="Diterbitkan resmi oleh Waka SDM" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                </div>
                <input type="hidden" name="status" value="aktif">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('quickPengumumanModal')">Batal</button>
                <button type="submit" class="btn-action btn-approve" style="padding: 9px 18px; background: #1e293b;">
                    <i class="fa-solid fa-paper-plane"></i> Publikasikan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab Switcher
    function switchDashboardTab(tabId, el) {
        document.querySelectorAll('.tab-content-pane').forEach(p => p.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        const target = document.getElementById(tabId);
        if (target) {
            target.style.display = 'block';
        }
        if (el) {
            el.classList.add('active');
        }
    }

    // Modal Handlers
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
        }
    }

    function openApproveModal(id, guruName) {
        document.getElementById('approveGuruName').innerText = guruName;
        document.getElementById('approveForm').action = "{{ url('waka-sdm/izin') }}/" + id + "/approve";
        openModal('approveModal');
    }

    function openRejectModal(id, guruName) {
        document.getElementById('rejectGuruName').innerText = guruName;
        document.getElementById('rejectForm').action = "{{ url('waka-sdm/izin') }}/" + id + "/reject";
        openModal('rejectModal');
    }

    function openQuickPengumumanModal() {
        openModal('quickPengumumanModal');
    }

    function openDetailModal(izin) {
        const c = document.getElementById('detailModalContent');
        const guruName = (izin.guru && izin.guru.nama_guru) ? izin.guru.nama_guru : 'Guru';
        const nip = (izin.guru && izin.guru.nip) ? izin.guru.nip : '-';
        const fotoSurat = izin.foto_surat ? `
            <div style="margin-top: 10px;">
                <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">DOKUMEN / FOTO SURAT:</label>
                <div style="margin-top: 4px;">
                    <a href="{{ asset('uploads/guru_izin') }}/${izin.foto_surat}" target="_blank" style="font-size: 12.5px; color: #1e293b; font-weight: 700; text-decoration: underline;">
                        <i class="fa-solid fa-file-image"></i> Lihat Lampiran Surat &rarr;
                    </a>
                </div>
            </div>` : '';

        const fileTugas = izin.file_tugas ? `
            <div style="margin-top: 10px;">
                <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">BERKAS TUGAS TITIPAN:</label>
                <div style="margin-top: 4px;">
                    <a href="{{ asset('uploads/tugas_pengganti') }}/${izin.file_tugas}" target="_blank" style="font-size: 12.5px; color: #16a34a; font-weight: 700; text-decoration: underline;">
                        <i class="fa-solid fa-file-arrow-down"></i> Unduh Berkas Tugas &rarr;
                    </a>
                </div>
            </div>` : '';

        c.innerHTML = `
            <div style="background: #f8fafc; padding: 14px; border-radius: 12px; margin-bottom: 14px; border: 1px solid #e2e8f0;">
                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 2px 0;">${guruName}</h4>
                <div style="font-size: 12px; color: #64748b;">NIP: ${nip}</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kategori Izin</label>
                    <div style="font-weight: 700; font-size: 13px; text-transform: uppercase; color: #1e293b;">${izin.kategori_izin || 'biasa'}</div>
                </div>
                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Durasi / Rentang</label>
                    <div style="font-weight: 700; font-size: 13px; color: #1e293b;">${izin.tanggal_mulai} s/d ${izin.tanggal_selesai || izin.tanggal_mulai}</div>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Alasan Izin</label>
                <div style="font-size: 13px; color: #1e293b; background: #ffffff; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; margin-top: 4px;">
                    ${izin.alasan || '-'}
                </div>
            </div>

            ${izin.materi_dititipkan ? `
                <div style="margin-bottom: 14px;">
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Materi / Tugas Dititipkan</label>
                    <div style="font-size: 13px; color: #1e293b; background: #ffffff; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; margin-top: 4px;">
                        ${izin.materi_dititipkan}
                    </div>
                </div>` : ''}

            ${fotoSurat}
            ${fileTugas}

            <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <label style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase;">Status Persetujuan Berjenjang</label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 8px;">
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">WAKA KUR</div>
                        <span class="badge ${izin.status_waka === 'approved' ? 'badge-approved' : (izin.status_waka === 'rejected' ? 'badge-rejected' : 'badge-pending')}" style="margin-top: 4px;">
                            ${izin.status_waka || 'pending'}
                        </span>
                    </div>
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">WAKA SDM</div>
                        <span class="badge ${izin.status_waka_sdm === 'approved' ? 'badge-approved' : (izin.status_waka_sdm === 'rejected' ? 'badge-rejected' : 'badge-pending')}" style="margin-top: 4px;">
                            ${izin.status_waka_sdm || 'pending'}
                        </span>
                    </div>
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">KEPSEK</div>
                        <span class="badge ${izin.status_kepsek === 'approved' ? 'badge-approved' : (izin.status_kepsek === 'rejected' ? 'badge-rejected' : 'badge-pending')}" style="margin-top: 4px;">
                            ${izin.status_kepsek || 'pending'}
                        </span>
                    </div>
                </div>
            </div>
        `;
        openModal('detailModal');
    }

    // Close on Backdrop Click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.classList.remove('active');
        }
    });
</script>
@endsection
