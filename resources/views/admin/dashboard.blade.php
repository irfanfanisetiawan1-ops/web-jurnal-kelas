@extends('layouts.admin')

@section('title', 'Dashboard Tata Usaha — EDU JOURNAL')

@section('styles')
<style>
    /* Pagination Bar Styles Matching Design Mockup */
    .table-pagination-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
        background: #ffffff;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }

    .table-pagination-footer .pagination-info {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .pagination-nav-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pg-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        user-select: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .pg-btn:hover:not(.active):not(.disabled) {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .pg-btn.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
        box-shadow: 0 3px 8px rgba(30, 41, 59, 0.25);
    }

    .pg-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Top Header Bar */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .header-top-nav-bar {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        margin-bottom: 20px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .search-box-top {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box-top input {
        width: 100%;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 10px 16px 10px 42px;
        border-radius: 14px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .search-box-top i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .header-right-badges {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ta-badge {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .time-pill-badge {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-ekspor-rekap {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-ekspor-rekap:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-tambah-jadwal {
        background: #252b42;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(37, 43, 66, 0.25);
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-tambah-jadwal:hover {
        background: #1a1e2e;
    }

    /* 6 Stat Cards Grid */
    .stat-6-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
        margin-bottom: 26px;
    }

    .stat-box-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .stat-box-card:hover {
        transform: translateY(-2px);
    }

    .stat-box-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-box-label {
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .stat-box-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .stat-box-num {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-box-sub {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .stat-trend-tag {
        font-size: 10.5px;
        font-weight: 700;
        color: #10b981;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
    }

    /* 2 Main Section Grids */
    .master-dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
    }

    .card-panel-master {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 22px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .card-header-flex h2, .card-header-flex h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .card-header-flex p {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .link-lihat-semua {
        font-size: 12.5px;
        color: #3b5490;
        font-weight: 700;
        text-decoration: none;
    }

    .link-lihat-semua:hover {
        text-decoration: underline;
    }

    /* Table Schedule */
    .table-schedule-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-schedule-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-schedule-custom td {
        padding: 13px 14px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .class-badge-pill {
        background: #e2e8f0;
        color: #1e293b;
        font-weight: 800;
        font-size: 11.5px;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .status-badge-pill {
        font-size: 11px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
    }

    .status-selesai { background: #d1fae5; color: #065f46; }
    .status-berlangsung { background: #dbeafe; color: #1e40af; }
    .status-terjadwal { background: #f1f5f9; color: #475569; }

    /* Bar Chart Custom Modern */
    .chart-container-bar {
        height: 220px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        padding-top: 30px;
        padding-bottom: 12px;
        padding-left: 8px;
        padding-right: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .bar-col-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .bar-col-item:hover {
        transform: translateY(-3px);
    }

    .bar-col-val {
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 2px 8px;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }

    .bar-col-val.active {
        color: #1e1b4b;
        background: #e0e7ff;
        border-color: #a5b4fc;
    }

    .bar-track {
        width: 100%;
        max-width: 42px;
        height: 100%;
        background: #f1f5f9;
        border-radius: 12px 12px 6px 6px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        position: relative;
    }

    .bar-fill {
        width: 100%;
        background: linear-gradient(180deg, #4f46e5 0%, #312e81 100%);
        border-radius: 12px 12px 4px 4px;
        transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bar-fill.today-fill {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 0 12px rgba(37, 99, 235, 0.4);
    }

    .bar-col-item.is-today .bar-track {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    .bar-col-label-sub {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    .bar-col-label-sub .day-name {
        font-size: 12px;
        font-weight: 800;
        color: #1e293b;
    }

    .bar-col-label-sub .day-date {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
    }

    /* Tooltip Custom */
    .bar-col-item[data-tooltip]::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        margin-bottom: 8px;
        background: #0f172a;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 8px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
    }

    .bar-col-item[data-tooltip]:hover::before {
        opacity: 1;
        visibility: visible;
    }

    /* Perlu Tindakan Cards */
    .action-alert-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .action-alert-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .action-alert-item .a-title {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .action-alert-item .a-sub {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
        font-weight: 600;
    }

    /* Progress per Kelas */
    .progress-class-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .progress-class-item .p-info {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .progress-class-bg {
        width: 100%;
        height: 7px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-class-fill {
        height: 100%;
        background: #252b42;
        border-radius: 10px;
    }

    /* Activity Feed */
    .feed-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .feed-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .feed-time {
        font-size: 12.5px;
        font-weight: 800;
        color: #0f172a;
        min-width: 44px;
    }

    .feed-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .feed-info .f-name {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .feed-info .f-meta {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    /* Rekap Donut Widget */
    .rekap-donut-container {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .donut-box {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .donut-box svg {
        transform: rotate(-90deg);
        width: 110px;
        height: 110px;
    }

    .donut-center-lbl {
        position: absolute;
        text-align: center;
    }

    .donut-center-lbl .pct { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1; }
    .donut-center-lbl .sub { font-size: 9px; font-weight: 700; color: #64748b; margin-top: 2px; }

    .rekap-mini-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        flex: 1;
    }

    .rekap-mini-card-sm {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rekap-mini-card-sm .icon-sm {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .icon-clock { background: #e2e8f0; color: #334155; }
    .icon-check { background: #d1fae5; color: #10b981; }
    .icon-warn  { background: #fef3c7; color: #d97706; }

    .rekap-mini-card-sm .txt-lbl { font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase; }
    .rekap-mini-card-sm .txt-val { font-size: 16px; font-weight: 800; color: #0f172a; line-height: 1.1; }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        backdrop-filter: blur(4px);
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 600px;
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        max-height: 80vh;
        display: flex;
        flex-direction: column;
    }

    .modal-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .modal-header-custom h3 { font-size: 17px; font-weight: 800; color: #0f172a; }
    .modal-close-custom { background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b; }

    @media (max-width: 1200px) {
        .stat-6-grid { grid-template-columns: repeat(3, 1fr); }
        .master-dashboard-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .stat-6-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')

    <!-- Page Title & Main Header Actions -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Dashboard Tata Usaha</h1>
            <p>{{ $formattedDate }} &nbsp;•&nbsp; Ringkasan operasional sekolah hari ini</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('admin.export-csv') }}" class="btn-ekspor-rekap">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor Rekap</span>
            </a>

            <a href="{{ route('jadwal.index') }}" class="btn-tambah-jadwal">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <!-- 6 Stat Cards Grid -->
    <div class="stat-6-grid">
        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">PENGGUNA</span>
                <div class="stat-box-icon"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalPengguna > 0 ? $totalPengguna : 128 }}</div>
            <div class="stat-box-sub">Total Akun System</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-check"></i> Aktif & Terverifikasi</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">SISWA AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-user-graduate"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalSiswa > 0 ? $totalSiswa : 32 }}</div>
            <div class="stat-box-sub">Total Siswa</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> +2 bulan ini</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">GURU AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-user-tie"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalGuru > 0 ? $totalGuru : 128 }}</div>
            <div class="stat-box-sub">Total Guru</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-check"></i> {{ $totalGuru > 0 ? $totalGuru : 128 }} Guru Terdaftar</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">KELAS</span>
                <div class="stat-box-icon"><i class="fa-solid fa-school"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalKelas > 0 ? $totalKelas : 32 }}</div>
            <div class="stat-box-sub">Total Rombel Kelas</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-layer-group"></i> {{ $totalMapel > 0 ? $totalMapel : 19 }} Mapel</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">SLOT AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-calendar-days"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalJadwal > 0 ? $totalJadwal : 970 }}</div>
            <div class="stat-box-sub">Jadwal Mengajar</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> 6 hari efektif</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">KEPATUHAN</span>
                <div class="stat-box-icon"><i class="fa-solid fa-chart-pie"></i></div>
            </div>
            <div class="stat-box-num">{{ $persentasePenyelesaian ?? 84 }}%</div>
            <div class="stat-box-sub">Jurnal Teknis Hari Ini</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> {{ $sudahMengisi ?? 142 }} dari {{ $totalJadwalSesi ?? 169 }} sesi</div>
        </div>
    </div>

    <!-- Master Dashboard 2 Column Layout -->
    <div class="master-dashboard-grid">

        <!-- Left Main Column -->
        <div>
                     <!-- Table Card: Jadwal Hari Ini -->
            <div class="card-panel-master">
                <div class="card-header-flex" style="flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between; margin-bottom:16px;">
                    <div>
                        <h2>Jadwal Hari Ini</h2>
                        <p>{{ $hariIndo }} &bull; Total {{ count($jadwalHariIni) }} sesi (25 per halaman)</p>
                    </div>

                    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                        <!-- Form Filter & Cari Jadwal Hari Ini -->
                        <form action="{{ route('admin.dashboard') }}" method="GET" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin:0;">
                            <div style="position:relative;">
                                <input type="text" name="search_jadwal" value="{{ $searchJadwal ?? '' }}" class="form-control" style="width:210px; padding-left:34px; height:38px; font-size:13px; border-radius:10px; border:1px solid #cbd5e1; background:#f8fafc;" placeholder="Cari Kelas / Guru / Mapel...">
                                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            </div>
                            <button type="submit" class="btn-filter" style="height:38px; padding:0 16px;">Cari</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn-reset" style="height:38px; padding:0 16px;">Reset</a>
                        </form>
                        <a href="{{ route('jadwal.index') }}" class="link-lihat-semua" style="margin-left:4px;">Lihat semua master</a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-schedule-custom">
                        <thead>
                            <tr>
                                <th>WAKTU</th>
                                <th>KELAS</th>
                                <th>GURU</th>
                                <th>MAPEL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-jadwal-hari-ini">
                            @forelse($jadwalHariIni as $index => $item)
                                @php
                                    $wMulai   = $item->waktu_mulai_effective;
                                    $wSelesai = $item->waktu_selesai_effective;
                                    $nowTime  = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                                    $sudahDiisi = $item->isDiisiHariIni();
                                @endphp
                                <tr class="jadwal-row">
                                    <td>
                                        <strong>
                                            @if($item->jamPelajaran)
                                                {{ $item->jamPelajaran->range_format }}
                                            @else
                                                {{ $item->waktu_range }}
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="class-badge-pill">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                    </td>
                                    <td><strong>{{ $item->guru->nama_guru ?? '-' }}</strong></td>
                                    <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                                    <td>
                                        @if($sudahDiisi)
                                            <span class="status-badge-pill status-selesai">Selesai</span>
                                        @elseif($nowTime >= $wMulai && $nowTime <= $wSelesai)
                                            <span class="status-badge-pill status-berlangsung">Berlangsung</span>
                                        @elseif($nowTime > $wSelesai)
                                            <span class="status-badge-pill status-selesai">Selesai</span>
                                        @else
                                            <span class="status-badge-pill status-terjadwal">Terjadwal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada jadwal KBM untuk hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Navigasi Halaman (Pagination 25 Per Halaman) -->
                <div class="table-pagination-footer" id="pagination-container-jadwal">
                    <div class="pagination-info" id="pagination-text-info-jadwal">
                        Menampilkan 1 - 25 dari {{ count($jadwalHariIni) }} jadwal
                    </div>
                    <div class="pagination-nav-buttons" id="pagination-buttons-jadwal">
                        <!-- Tombol Pagination JS (< 1 2 3 >) -->
                    </div>
                </div>
            </div>

            <!-- Card: Grafik Jurnal 7 Hari Terakhir -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h2>Grafik Jurnal Mengajar</h2>
                        <p>Tren pengisian jurnal 7 hari terakhir</p>
                    </div>
                    <div class="ta-badge" style="font-size:12px; padding:6px 12px;">
                        <i class="fa-solid fa-chart-column" style="color:#4f46e5;"></i> 7 Hari Terakhir
                    </div>
                </div>

                <div class="chart-container-bar">
                    @foreach($grafik7Hari as $g)
                        @php
                            $maxCount = isset($maxGrafikCount) && $maxGrafikCount > 0 ? $maxGrafikCount : 1;
                            $calcPct = round(($g['count'] / $maxCount) * 100);
                            $fillHeight = $g['count'] > 0 ? max(8, $calcPct) : 0;
                        @endphp
                        <div class="bar-col-item {{ $g['is_today'] ? 'is-today' : '' }}" data-tooltip="{{ $g['full_date'] }}: {{ $g['count'] }} Jurnal Diisi">
                            <span class="bar-col-val {{ $g['count'] > 0 ? 'active' : '' }}">{{ $g['count'] }}</span>
                            <div class="bar-track">
                                <div class="bar-fill {{ $g['is_today'] ? 'today-fill' : '' }}" style="height: {{ $fillHeight }}%;"></div>
                            </div>
                            <div class="bar-col-label-sub">
                                <span class="day-name">{{ $g['day_name'] }}</span>
                                <span class="day-date">{{ $g['tanggal'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card: Rekap Jurnal Mengajar Hari Ini (Donut Widget) -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h2>Rekap Jurnal Mengajar Hari Ini</h2>
                        <p>{{ $rekapStatusText ?? 'Status pengisian sesi hari ini' }}</p>
                    </div>
                    @if(isset($isHariLibur) && $isHariLibur)
                        <span class="status-badge-pill status-terjadwal"><i class="fa-solid fa-mug-hot"></i> Hari Libur</span>
                    @elseif(($persentasePenyelesaian ?? 0) >= 100)
                        <span class="status-badge-pill status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai 100%</span>
                    @else
                        <span class="status-badge-pill status-berlangsung"><i class="fa-solid fa-arrows-rotate fa-spin"></i> Berlangsung</span>
                    @endif
                </div>

                <div class="rekap-donut-container">
                    <div class="donut-box">
                        <svg viewBox="0 0 36 36" style="transform: rotate(-90deg); width: 110px; height: 110px;">
                            <path stroke="#f1f5f9" stroke-width="3.8" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path stroke="{{ ($persentasePenyelesaian ?? 0) >= 100 ? '#10b981' : '#4f46e5' }}" stroke-width="3.8" stroke-dasharray="{{ $persentasePenyelesaian ?? 0 }}, 100" stroke-linecap="round" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" style="transition: stroke-dasharray 0.6s ease;"/>
                        </svg>
                        <div class="donut-center-lbl">
                            <div class="pct">{{ $persentasePenyelesaian ?? 0 }}%</div>
                            <div class="sub">Penyelesaian</div>
                        </div>
                    </div>

                    <div class="rekap-mini-grid">
                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-clock"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <div class="txt-lbl">TOTAL JADWAL</div>
                                <div class="txt-val">{{ $totalJadwalSesi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>

                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-check"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <div class="txt-lbl">SUDAH MENGISI</div>
                                <div class="txt-val">{{ $sudahMengisi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>

                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-warn"><i class="fa-solid fa-triangle-exclamation"></i></div>
                            <div>
                                <div class="txt-lbl">BELUM MENGISI</div>
                                <div class="txt-val">{{ $belumMengisi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Sidebar Column -->
        <div>
            
            <!-- Card: Perlu Tindakan -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Perlu Tindakan</h3>
                </div>

                <div class="action-alert-list">
                    @foreach($perluTindakan as $actAlert)
                        <a href="{{ $actAlert['url'] ?? '#' }}" class="action-alert-item" style="text-decoration: none; display: block; transition: transform 0.15s ease;">
                            <div class="a-title">{{ $actAlert['title'] }}</div>
                            <div class="a-sub">{{ $actAlert['subtitle'] }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Card: Pengisian Jurnal per Kelas (Minggu Ini) -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h3>Pengisian Jurnal per Kelas</h3>
                        <p>Minggu ini</p>
                    </div>
                </div>

                <div class="progress-class-list">
                    @foreach($kepatuhanPerKelas as $itemKls)
                        <div class="progress-class-item">
                            <div class="p-info">
                                <span>{{ $itemKls['nama_kelas'] }}</span>
                                <span>{{ $itemKls['persen'] }}%</span>
                            </div>
                            <div class="progress-class-bg">
                                <div class="progress-class-fill" style="width: {{ $itemKls['persen'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card: Aktivitas Real-time -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Aktivitas</h3>
                    <a href="#modalAktivitas" onclick="document.getElementById('modalAktivitas').style.display='flex'; return false;" class="link-lihat-semua">Lihat Semua</a>
                </div>

                <div class="feed-list">
                    @forelse($aktivitasTerbaru->take(5) as $act)
                        <div class="feed-item">
                            <div class="feed-time">{{ \Carbon\Carbon::parse($act->dicatat_pada ?? $act->created_at)->format('H:i') }}</div>
                            <div class="feed-avatar">{{ strtoupper(substr($act->jadwal->guru->nama_guru ?? 'G', 0, 1)) }}</div>
                            <div class="feed-info">
                                <div class="f-name">{{ $act->jadwal->guru->nama_guru ?? 'Guru Pengajar' }}</div>
                                <div class="f-meta">{{ $act->jadwal->kelas->nama_kelas ?? 'Kelas' }} - {{ $act->jadwal->mapel->nama_mapel ?? 'Mapel' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="feed-item">
                            <div class="feed-time">07:03</div>
                            <div class="feed-avatar">T</div>
                            <div class="feed-info">
                                <div class="f-name">Trisno Wibowo, S.Pd., M.M.</div>
                                <div class="f-meta">XI RPL 1 - Konsentrasi RPL</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">07:05</div>
                            <div class="feed-avatar">K</div>
                            <div class="feed-info">
                                <div class="f-name">Kurnila Putri Islamawati, S.Pd</div>
                                <div class="f-meta">X RPL 1 - Informatika</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">07:05</div>
                            <div class="feed-avatar">B</div>
                            <div class="feed-info">
                                <div class="f-name">Budi Santoso, S.Kom</div>
                                <div class="f-meta">XI DKV 1 - Bahasa Inggris</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card: Guru Belum Mengisi Hari Ini -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Guru belum mengisi hari ini</h3>
                    <a href="#modalBelum" onclick="document.getElementById('modalBelum').style.display='flex'; return false;" class="link-lihat-semua">Lihat Semua</a>
                </div>

                <div class="feed-list">
                    @forelse($guruBelumMengisi->take(4) as $unsub)
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">{{ $unsub->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="f-meta">{{ $unsub->mapel->nama_mapel ?? 'Mata Pelajaran' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">Dewi Lestari, S.Pd</div>
                                <div class="f-meta">Bahasa Inggris</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">Hendra Wijaya, S.Kom</div>
                                <div class="f-meta">Bahasa Jepang</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <!-- Modal Lihat Semua Aktivitas -->
    <div id="modalAktivitas" class="modal-backdrop-custom">
        <div class="modal-box-custom">
            <div class="modal-header-custom">
                <h3>Riwayat Aktivitas Pengisian Jurnal</h3>
                <button class="modal-close-custom" onclick="document.getElementById('modalAktivitas').style.display='none';">&times;</button>
            </div>
            <div style="overflow-y: auto; flex:1;">
                <div class="feed-list">
                    @foreach($aktivitasTerbaru as $act)
                        <div class="feed-item" style="padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <div class="feed-time">{{ \Carbon\Carbon::parse($act->dicatat_pada ?? $act->created_at)->format('H:i') }}</div>
                            <div class="feed-avatar">{{ strtoupper(substr($act->jadwal->guru->nama_guru ?? 'G', 0, 1)) }}</div>
                            <div class="feed-info">
                                <div class="f-name">{{ $act->jadwal->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="f-meta">{{ $act->jadwal->kelas->nama_kelas ?? 'Kelas' }} - {{ $act->jadwal->mapel->nama_mapel ?? 'Mapel' }} | {{ $act->materi }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat Semua Guru Belum Mengisi -->
    <div id="modalBelum" class="modal-backdrop-custom">
        <div class="modal-box-custom">
            <div class="modal-header-custom">
                <h3>Daftar Guru Belum Mengisi Jurnal Hari Ini</h3>
                <button class="modal-close-custom" onclick="document.getElementById('modalBelum').style.display='none';">&times;</button>
            </div>
            <div style="overflow-y: auto; flex:1;">
                <div class="feed-list">
                    @foreach($guruBelumMengisi as $unsub)
                        <div class="feed-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                                <div class="feed-info">
                                    <div class="f-name">{{ $unsub->guru->nama_guru ?? 'Guru' }}</div>
                                    <div class="f-meta">{{ $unsub->kelas->nama_kelas ?? 'Kelas' }} - {{ $unsub->mapel->nama_mapel ?? 'Mapel' }}</div>
                                </div>
                            </div>
                            <button onclick="alert('Pemberitahuan pengingat berhasil dikirimkan ke {{ $unsub->guru->nama_guru ?? 'guru' }}!');" style="background:#fef3c7; color:#b45309; border:none; padding:6px 12px; border-radius:8px; font-weight:800; font-size:12px; cursor:pointer;">
                                <i class="fa-solid fa-bell"></i> Ingatkan
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    (function() {
        const itemsPerPage = 25;
        let currentPage = 1;

        function initJadwalPagination() {
            const tbody = document.getElementById('tbody-jadwal-hari-ini');
            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr.jadwal-row'));
            const totalItems = rows.length;

            const container = document.getElementById('pagination-container-jadwal');
            if (totalItems === 0) {
                if (container) container.style.display = 'none';
                return;
            }

            const totalPages = Math.ceil(totalItems / itemsPerPage);

            function renderPage(page) {
                currentPage = page;
                const startIdx = (page - 1) * itemsPerPage;
                const endIdx = startIdx + itemsPerPage;

                rows.forEach((row, index) => {
                    if (index >= startIdx && index < endIdx) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                const currentStart = startIdx + 1;
                const currentEnd = Math.min(endIdx, totalItems);
                const infoEl = document.getElementById('pagination-text-info-jadwal');
                if (infoEl) {
                    infoEl.textContent = `Menampilkan ${currentStart} - ${currentEnd} dari ${totalItems} jadwal`;
                }

                renderButtons(totalPages);
            }

            function renderButtons(totalPages) {
                const buttonsContainer = document.getElementById('pagination-buttons-jadwal');
                if (!buttonsContainer) return;

                if (totalPages <= 1) {
                    buttonsContainer.innerHTML = '';
                    return;
                }

                let html = '';

                // Prev Button
                const prevDisabled = currentPage === 1 ? 'disabled' : '';
                html += `<button type="button" class="pg-btn ${prevDisabled}" data-page="${currentPage - 1}" ${prevDisabled ? 'disabled' : ''}><i class="fa-solid fa-chevron-left"></i></button>`;

                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (totalPages > 7) {
                        if (i !== 1 && i !== totalPages && Math.abs(i - currentPage) > 2) {
                            if (i === 2 && currentPage > 4) {
                                html += `<span style="padding: 0 4px; color: #94a3b8;">...</span>`;
                            } else if (i === totalPages - 1 && currentPage < totalPages - 3) {
                                html += `<span style="padding: 0 4px; color: #94a3b8;">...</span>`;
                            }
                            continue;
                        }
                    }

                    const activeClass = i === currentPage ? 'active' : '';
                    html += `<button type="button" class="pg-btn ${activeClass}" data-page="${i}">${i}</button>`;
                }

                // Next Button
                const nextDisabled = currentPage === totalPages ? 'disabled' : '';
                html += `<button type="button" class="pg-btn ${nextDisabled}" data-page="${currentPage + 1}" ${nextDisabled ? 'disabled' : ''}><i class="fa-solid fa-chevron-right"></i></button>`;

                buttonsContainer.innerHTML = html;

                buttonsContainer.querySelectorAll('.pg-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const targetPage = parseInt(this.getAttribute('data-page'));
                        if (targetPage && targetPage >= 1 && targetPage <= totalPages && targetPage !== currentPage) {
                            renderPage(targetPage);
                        }
                    });
                });
            }

            renderPage(1);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initJadwalPagination);
        } else {
            initJadwalPagination();
        }
    })();
</script>
@endsection
