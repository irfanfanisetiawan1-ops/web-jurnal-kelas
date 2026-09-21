@extends('layouts.guru')

@php
    $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
    $currentHourMin = $currentTime->format('H:i');
    $todayDateStr = $currentTime->toDateString();

    $daysId = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $monthsId = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $formattedDateStr = $daysId[$currentTime->dayOfWeek] . ', ' . $currentTime->day . ' ' . $monthsId[$currentTime->month] . ' ' . $currentTime->year;
@endphp

@section('title', ($isWaliKelas && $kelasWali) ? 'Beranda Guru & Wali Kelas — EDU JOURNAL' : 'Beranda Guru Mengajar — EDU JOURNAL')
@section('header_title', 'Beranda Guru')

@section('styles')
<style>
    /* Dashboard Page Header Style */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.25;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 5px;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-header-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
    }

    .btn-header-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-header-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .btn-header-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Role & Status Badges in Header */
    .header-status-badge {
        display: inline-flex;
        align-items: center;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.2px;
    }

    .badge-wali {
        background: #f1f5f9;
        color: #1e293b;
        border: 1px solid #cbd5e1;
    }

    .badge-weekend {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    /* Scope Tabs for Wali Kelas - Modern Segmented Control */
    .scope-tab-bar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 4px;
        border-radius: 12px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .scope-tab-btn {
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid transparent;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .scope-tab-btn:hover {
        color: #0f172a;
        background: rgba(255, 255, 255, 0.7);
    }

    .scope-tab-btn.active {
        background: #ffffff;
        color: #0f172a;
        border-color: #cbd5e1;
        font-weight: 800;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
    }

    /* Stats Card Container */
    .stats-container {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 22px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.02);
    }

    .stats-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stats-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
    }

    .stats-title-group i {
        color: #2563eb;
        font-size: 18px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-title {
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 6px;
        line-height: 1.2;
    }

    .stat-sub {
        font-size: 11.5px;
        color: #475569;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Weekly Badges */
    .weekly-badges {
        display: flex;
        gap: 5px;
        margin-top: 8px;
    }

    .badge-week {
        flex: 1;
        text-align: center;
        background: #e2e8f0;
        color: #334155;
        font-size: 10.5px;
        font-weight: 800;
        padding: 4px 2px;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
    }

    .badge-week.active {
        background: #2563eb;
        color: #ffffff;
    }

    .badge-week span.count {
        font-size: 9px;
        font-weight: 700;
        opacity: 0.9;
    }

    /* Weekend Alert Banner */
    .weekend-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Main Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 24px;
    }
    
    @media (max-width: 1100px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Schedule Card */
    .card-schedule {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.02);
    }

    .schedule-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .schedule-header-row h2 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Day Navigation Pills */
    .day-nav-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .day-pill-btn {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .day-pill-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .day-pill-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Table Schedule */
    .table-schedule {
        width: 100%;
        border-collapse: collapse;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 12px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        letter-spacing: 0.4px;
    }

    .table-schedule td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-schedule tr:hover td {
        background: #f8fafc;
    }

    .time-badge {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .btn-jurnal {
        background: #2563eb;
        color: #ffffff;
        padding: 7px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        border: none;
        cursor: pointer;
    }

    .btn-jurnal:hover {
        background: #1d4ed8;
    }

    .btn-disabled {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11.5px;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-lock-time {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .btn-lock-time:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .badge-filled {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action-view {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .btn-action-view:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* Right Sidebar Widgets */
    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.02);
    }

    .widget-next-class {
        background: linear-gradient(135deg, #1e293b 0%, #384972 100%);
        color: #ffffff;
        border: none;
    }

    .widget-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 14.5px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .widget-next-class .widget-header {
        color: #ffffff;
    }

    .next-class-box {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 14px;
        padding: 16px;
        backdrop-filter: blur(4px);
    }

    .next-class-title {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .next-class-time {
        font-size: 12.5px;
        background: rgba(255, 255, 255, 0.22);
        padding: 3px 9px;
        border-radius: 6px;
        font-weight: 700;
    }

    .next-class-desc {
        font-size: 12.5px;
        color: #cbd5e1;
        margin-top: 8px;
        line-height: 1.45;
    }

    /* News & Announcements List */
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .news-item {
        padding: 12px 14px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        transition: all 0.15s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .news-item:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .news-title {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
    }

    .news-meta {
        font-size: 11px;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Quick Shortcuts */
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .quick-link-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        text-decoration: none;
        color: #1e293b;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 6px;
        transition: all 0.15s ease;
    }

    .quick-link-btn:hover {
        background: #ffffff;
        border-color: #2563eb;
        color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.08);
    }

    .quick-link-btn i {
        font-size: 18px;
        color: #384972;
    }

    .quick-link-btn:hover i {
        color: #2563eb;
    }

    /* Homeroom (Wali Kelas) Monitoring Card */
    .homeroom-overview-box {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 18px;
        padding: 22px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.02);
    }

    .homeroom-metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-top: 14px;
        margin-bottom: 18px;
    }

    @media (max-width: 900px) {
        .homeroom-metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .homeroom-metric-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
    }

    .homeroom-metric-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 4px;
    }

    .homeroom-metric-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 600px;
        max-height: 88vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border: 1px solid #cbd5e1;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endsection

@section('content')

    <!-- 1. Page Location Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>
                @if($isWaliKelas && $kelasWali)
                    Dashboard Guru &amp; Wali Kelas
                @else
                    Dashboard Guru Mengajar
                @endif
            </h1>
            <p>
                <span>{{ $formattedDateStr }}</span>
                <span>&bull;</span>
                <span>Ringkasan operasional KBM &amp; jadwal mengajar terintegrasi</span>
                @if($isWaliKelas && $kelasWali)
                    <span class="header-status-badge badge-wali">
                        Wali Kelas: {{ $kelasWali->nama_kelas }}
                    </span>
                @endif
                @if($isWeekend)
                    <span class="header-status-badge badge-weekend">
                        Libur Akhir Pekan
                    </span>
                @endif
            </p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('guru.export-rekap-csv') }}" class="btn-header-action btn-header-secondary" title="Unduh Arsip & Rekap Jurnal Mengajar CSV">
                <i class="fa-solid fa-file-csv" style="color: #15803d; font-size: 15px;"></i>
                <span>Ekspor Rekap</span>
            </a>
            <a href="{{ route('guru.jurnal-harian') }}" class="btn-header-action btn-header-primary">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Isi Jurnal Harian</span>
            </a>
        </div>
    </div>

    <!-- 2. Scope Tabs for Wali Kelas (Mengajar vs Perwalian) -->
    @if($isWaliKelas && $kelasWali)
        <div class="scope-tab-bar">
            <button type="button" class="scope-tab-btn active" id="btnTabMengajar" onclick="switchMainTab('mengajar')">
                <span>Ringkasan Mengajar Saya</span>
            </button>
            <button type="button" class="scope-tab-btn" id="btnTabPerwalian" onclick="switchMainTab('perwalian')">
                <span>Pantauan Kelas Perwalian ({{ $kelasWali->nama_kelas }})</span>
            </button>
        </div>
    @endif

    <!-- SECTION 1: RINGKASAN MENGAJAR SAYA -->
    <div id="sectionMengajar">

        <!-- Statistik Mengajar -->
        <div class="stats-container">
            <div class="stats-header">
                <div class="stats-title-group">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Statistik Mengajar &amp; Progres Jurnal</span>
                </div>
                <div style="font-size: 12px; color: #64748b; font-weight: 700;">
                    T.A. 2025/2026 &bull; Semester Genap
                </div>
            </div>

            <div class="stats-grid">
                <!-- Card 1: Total Jurnal Terisi -->
                <div class="stat-card">
                    <div class="stat-title">
                        <span>Total Jurnal Terisi</span>
                        <i class="fa-solid fa-book-open" style="color: #2563eb;"></i>
                    </div>
                    <div class="stat-value">{{ $stats['totalJurnalTerisi'] }}</div>
                    <div class="stat-sub">{{ $stats['subTotalJurnal'] }}</div>
                </div>

                <!-- Card 2: Total Kelas Diajar -->
                <div class="stat-card">
                    <div class="stat-title">
                        <span>Total Kelas Diajar</span>
                        <i class="fa-solid fa-school" style="color: #384972;"></i>
                    </div>
                    <div class="stat-value">{{ $stats['totalKelasDiajar'] }}</div>
                    <div class="stat-sub">{{ $stats['subKelasDiajar'] }}</div>
                </div>

                <!-- Card 3: Absensi Rata-rata Siswa -->
                <div class="stat-card">
                    <div class="stat-title">
                        <span>Absensi Rata-rata Siswa</span>
                        <i class="fa-solid fa-user-check" style="color: #16a34a;"></i>
                    </div>
                    <div class="stat-value" style="color: #16a34a;">{{ $stats['absensiRataRata'] }}</div>
                    <div class="stat-sub">Tingkat kehadiran siswa di kelas Anda</div>
                </div>

                <!-- Card 4: Jurnal Terisi per Minggu (M1-M5) -->
                <div class="stat-card">
                    <div class="stat-title">
                        <span>Jurnal per Minggu</span>
                        <i class="fa-solid fa-calendar-week" style="color: #a855f7;"></i>
                    </div>
                    <div class="weekly-badges">
                        @foreach($stats['jurnalPerMinggu'] as $mKey => $mVal)
                            <div class="badge-week {{ $mVal['is_current'] ? 'active' : '' }}" title="{{ $mVal['range'] }}: {{ $mVal['count'] }} Jurnal Terisi">
                                <span>{{ $mKey }}</span>
                                <span class="count">{{ $mVal['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="stat-sub" style="margin-top: 6px;">
                        Progres bulan {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekend Notice Banner (Jika Hari Ini Akhir Pekan) -->
        @if($isWeekend && !request('hari'))
            <div class="weekend-banner">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div>
                        <div style="font-size: 14.5px; font-weight: 800; color: #0369a1;">
                            Hari Ini Libur Akhir Pekan ({{ $todayIndo }}, {{ $formattedDateStr }})
                        </div>
                        <div style="font-size: 12.5px; color: #475569; margin-top: 2px;">
                            Tidak ada jadwal kegiatan belajar mengajar aktif hari ini. Tabel di bawah menampilkan <strong>Jadwal Mengajar Hari Kerja Berikutnya (Senin)</strong>.
                        </div>
                    </div>
                </div>
                <a href="{{ route('guru.jadwal') }}" class="btn-action-view" style="padding: 8px 14px; font-size: 12px; text-decoration: none;">
                    <i class="fa-solid fa-calendar-days"></i> Lihat Jadwal Lengkap
                </a>
            </div>
        @endif

        <!-- Main Dashboard Grid (Left Table, Right Widgets) -->
        <div class="dashboard-grid">
            
            <!-- Left: Jadwal Mengajar Card -->
            <div class="card-schedule">
                <div class="schedule-header-row">
                    <h2>
                        <i class="fa-solid fa-calendar-check" style="color: #2563eb;"></i>
                        <span>Jadwal Mengajar ({{ $isViewingAllDays ? 'Semua' : ucfirst($hariAktif) }})</span>
                    </h2>

                    <!-- Day Navigation Pills -->
                    <div class="day-nav-pills">
                        <a href="{{ route('guru.dashboard', ['hari' => 'senin']) }}" class="day-pill-btn {{ $hariAktif === 'senin' && !$isViewingAllDays ? 'active' : '' }}">Senin</a>
                        <a href="{{ route('guru.dashboard', ['hari' => 'selasa']) }}" class="day-pill-btn {{ $hariAktif === 'selasa' ? 'active' : '' }}">Selasa</a>
                        <a href="{{ route('guru.dashboard', ['hari' => 'rabu']) }}" class="day-pill-btn {{ $hariAktif === 'rabu' ? 'active' : '' }}">Rabu</a>
                        <a href="{{ route('guru.dashboard', ['hari' => 'kamis']) }}" class="day-pill-btn {{ $hariAktif === 'kamis' ? 'active' : '' }}">Kamis</a>
                        <a href="{{ route('guru.dashboard', ['hari' => 'jumat']) }}" class="day-pill-btn {{ $hariAktif === 'jumat' ? 'active' : '' }}">Jumat</a>
                        <a href="{{ route('guru.dashboard', ['hari' => 'semua']) }}" class="day-pill-btn {{ $isViewingAllDays ? 'active' : '' }}">Semua</a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table-schedule">
                        <thead>
                            <tr>
                                <th style="width: 150px;">JAM KE-</th>
                                @if($isViewingAllDays)
                                    <th style="width: 100px;">HARI</th>
                                @endif
                                <th style="width: 130px;">KELAS</th>
                                <th>MAPEL</th>
                                <th>RUANGAN</th>
                                <th style="width: 160px; text-align: center;">AKSI JURNAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $j)
                                @php
                                    $waktuMulai   = $j->waktu_mulai_effective;
                                    $waktuSelesai = $j->waktu_selesai_effective;
                                    $isTodaySchedule = (strtolower(trim($j->hari)) === strtolower(trim($todayIndo)));
                                    $sudahMasuk   = $isTodaySchedule && $j->sudah_masuk_jam;
                                    $sudahDiisi   = $isTodaySchedule && $j->isDiisiHariIni();
                                    $jurnalToday  = $sudahDiisi ? $j->jurnal_hari_ini : null;
                                @endphp
                                <tr>
                                    <td>
                                        <strong>Jam ke-{{ $j->jam_range }}</strong>
                                        <div class="time-badge">
                                            {{ $waktuMulai }} - {{ $waktuSelesai }} WIB
                                        </div>
                                    </td>
                                    @if($isViewingAllDays)
                                        <td><strong style="color: #2563eb;">{{ $j->hari }}</strong></td>
                                    @endif
                                    <td>
                                        <strong style="color: #0f172a;">{{ $j->kelas->nama_kelas ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong>
                                        @if(!empty($j->is_guru_pengganti))
                                            <div style="font-size: 11px; font-weight: 800; color: #2563eb; margin-top: 2px;">
                                                <i class="fa-solid fa-user-shield"></i> Penugasan Guru Pengganti (Menggantikan {{ $j->guru->nama_guru ?? 'Guru' }})
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; color: #475569;">
                                            {{ $j->ruangan->nama_ruangan ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($sudahDiisi)
                                            <div style="display: inline-flex; align-items: center; gap: 6px;">
                                                <span class="badge-filled">
                                                    <i class="fa-solid fa-circle-check"></i> Sudah Diisi
                                                </span>
                                                @if($jurnalToday)
                                                    <button type="button" class="btn-action-view" onclick='openModalDetailJurnal(@json($jurnalToday), "{{ addslashes($j->kelas->nama_kelas ?? "-") }}", "{{ addslashes($j->mapel->nama_mapel ?? "-") }}")' title="Lihat Detail Jurnal">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @elseif($isTodaySchedule && ($sudahMasuk || !empty($j->is_guru_pengganti)))
                                            <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) }}" class="btn-jurnal" title="Isi Jurnal Mengajar Sekarang">
                                                <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal
                                            </a>
                                        @elseif($isTodaySchedule && !$sudahMasuk)
                                            <button type="button" class="btn-lock-time" onclick="showBelumJamModal('{{ addslashes($j->mapel->nama_mapel ?? '-') }}', '{{ addslashes($j->kelas->nama_kelas ?? '-') }}', 'Hari Ini ({{ $j->hari }})', '{{ $waktuMulai }} - {{ $waktuSelesai }} WIB', 'belum_jam')" title="Klik untuk informasi jam KBM">
                                                <i class="fa-solid fa-lock"></i> Belum Jam-nya
                                            </button>
                                        @else
                                            <button type="button" class="btn-lock-time" onclick="showBelumJamModal('{{ addslashes($j->mapel->nama_mapel ?? '-') }}', '{{ addslashes($j->kelas->nama_kelas ?? '-') }}', 'Hari {{ $j->hari }}', '{{ $waktuMulai }} - {{ $waktuSelesai }} WIB', 'bukan_hari')" title="Klik untuk informasi jadwal pelajaran">
                                                <i class="fa-solid fa-clock"></i> Belum Jadwalnya
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isViewingAllDays ? 6 : 5 }}" style="text-align: center; color: #94a3b8; padding: 36px 20px;">
                                        <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                        <div style="font-size: 14px; font-weight: 800; color: #334155;">Tidak Ada Jadwal Mengajar</div>
                                        <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">
                                            Anda tidak memiliki jam mengajar pada hari {{ ucfirst($hariAktif) }}.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column Widgets -->
            <div>
                <!-- Widget 1: Jadwal Jam Berikutnya -->
                <div class="widget-card widget-next-class">
                    <div class="widget-header">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-clock"></i>
                            <span>Jadwal Jam Berikutnya</span>
                        </span>
                        @if($jadwalBerikutnya)
                            <span style="font-size: 11px; background: rgba(255,255,255,0.2); padding: 2px 7px; border-radius: 4px;">
                                {{ $jadwalBerikutnya->hari }}
                            </span>
                        @endif
                    </div>

                    @if($jadwalBerikutnya)
                        @php
                            $cTime = $currentTimeStr ?? \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                            $isJadwalBerikutnyaHariIni = (!$isWeekend && strtolower(trim($jadwalBerikutnya->hari)) === strtolower(trim($todayIndo)));
                            $isJadwalBerikutnyaMasuk = $isJadwalBerikutnyaHariIni && ($cTime >= $jadwalBerikutnya->waktu_mulai_effective || !empty($jadwalBerikutnya->is_guru_pengganti));
                        @endphp
                        <div class="next-class-box">
                            <div class="next-class-title">
                                <span>{{ $jadwalBerikutnya->kelas->nama_kelas ?? '-' }}</span>
                                <span class="next-class-time">{{ $jadwalBerikutnya->waktu_mulai_effective ?? '-' }} WIB</span>
                            </div>
                            <div class="next-class-desc">
                                Jam ke-{{ $jadwalBerikutnya->jam_range }} &bull; <strong>{{ $jadwalBerikutnya->mapel->nama_mapel ?? '-' }}</strong><br>
                                Ruang: {{ $jadwalBerikutnya->ruangan->nama_ruangan ?? '-' }} &bull; Harap isi jurnal tepat waktu saat KBM berlangsung.
                            </div>
                            <div style="margin-top: 14px;">
                                @if($isJadwalBerikutnyaMasuk)
                                    <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $jadwalBerikutnya->id_jadwal]) }}" class="btn-jurnal" style="background: #ffffff; color: #0f172a; width: 100%; justify-content: center; font-weight: 800;">
                                        <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Kelas Ini
                                    </a>
                                @elseif($isJadwalBerikutnyaHariIni)
                                    <button type="button" class="btn-jurnal" onclick="showBelumJamModal('{{ addslashes($jadwalBerikutnya->mapel->nama_mapel ?? '-') }}', '{{ addslashes($jadwalBerikutnya->kelas->nama_kelas ?? '-') }}', 'Hari {{ $jadwalBerikutnya->hari }}', '{{ $jadwalBerikutnya->waktu_mulai_effective }} - {{ $jadwalBerikutnya->waktu_selesai_effective }} WIB', 'belum_jam')" style="background: rgba(255,255,255,0.15); color: #ffffff; width: 100%; justify-content: center; font-weight: 800; border: 1px solid rgba(255,255,255,0.35); cursor: pointer;" title="Klik untuk informasi jam KBM">
                                        <i class="fa-solid fa-lock"></i> Belum Memasuki Jam KBM
                                    </button>
                                @else
                                    <button type="button" class="btn-jurnal" onclick="showBelumJamModal('{{ addslashes($jadwalBerikutnya->mapel->nama_mapel ?? '-') }}', '{{ addslashes($jadwalBerikutnya->kelas->nama_kelas ?? '-') }}', 'Hari {{ $jadwalBerikutnya->hari }}', '{{ $jadwalBerikutnya->waktu_mulai_effective }} - {{ $jadwalBerikutnya->waktu_selesai_effective }} WIB', 'bukan_hari')" style="background: rgba(255,255,255,0.15); color: #ffffff; width: 100%; justify-content: center; font-weight: 800; border: 1px solid rgba(255,255,255,0.35); cursor: pointer;" title="Klik untuk informasi jadwal pelajaran">
                                        <i class="fa-solid fa-clock"></i> Belum Memasuki Jam KBM
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="next-class-box">
                            <div class="next-class-title">
                                <span>Tidak Ada Jam</span>
                            </div>
                            <div class="next-class-desc">
                                Seluruh jadwal jam mengajar Anda telah selesai dilaksanakan.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Widget 2: Berita & Pengumuman Sekolah -->
                <div class="widget-card">
                    <div class="widget-header" style="color: #0f172a;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-bullhorn" style="color: #2563eb;"></i>
                            <span>Berita &amp; Pengumuman</span>
                        </span>
                        <a href="{{ route('guru.pengumuman') }}" style="font-size: 11.5px; color: #2563eb; text-decoration: none; font-weight: 700;">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    
                    <div class="news-list">
                        @forelse($pengumumanList as $p)
                            @php
                                $isRead = in_array($p->id_pengumuman, $readAnnouncementIds);
                            @endphp
                            <div class="news-item" onclick='openModalDetailPengumuman(@json($p))'>
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                    <span style="font-size: 10.5px; font-weight: 800; color: #3730a3; background: #e0e7ff; padding: 2px 7px; border-radius: 4px;">
                                        {{ $p->kategori ?? 'Umum' }}
                                    </span>
                                    @if(!$isRead)
                                        <span style="font-size: 10px; font-weight: 800; color: #e11d48; background: #ffe4e6; padding: 2px 6px; border-radius: 10px;">
                                            BARU
                                        </span>
                                    @endif
                                </div>
                                <div class="news-title">{{ $p->judul }}</div>
                                <div class="news-meta">
                                    <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span>{{ $p->pembuat->nama_guru ?? 'Waka Kurikulum' }}</span>
                                </div>
                            </div>
                        @empty
                            <div style="font-size: 12.5px; color: #94a3b8; text-align: center; padding: 14px 0;">
                                Belum ada pengumuman terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Widget 3: Akses Cepat Menu Portal Guru -->
                <div class="widget-card">
                    <div class="widget-header" style="color: #0f172a;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-compass" style="color: #2563eb;"></i>
                            <span>Pintasan Menu Utama</span>
                        </span>
                    </div>

                    <div class="quick-links-grid">
                        <a href="{{ route('guru.absensi-siswa') }}" class="quick-link-btn">
                            <i class="fa-solid fa-user-check"></i>
                            <span>Presensi Siswa</span>
                        </a>
                        <a href="{{ route('guru.nilai-rapor') }}" class="quick-link-btn">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Nilai Siswa</span>
                        </a>
                        <a href="{{ route('guru.riwayat-jurnal') }}" class="quick-link-btn">
                            <i class="fa-solid fa-book-bookmark"></i>
                            <span>Riwayat Jurnal</span>
                        </a>
                        <a href="{{ route('guru.surat-dispen') }}" class="quick-link-btn">
                            <i class="fa-solid fa-envelope-open-text"></i>
                            <span>Surat Dispen</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- SECTION 2: PANTAUAN KELAS PERWALIAN (HANYA MUNCUL JIKA WALI KELAS) -->
    @if($isWaliKelas && $kelasWali && $waliKelasData)
        <div id="sectionPerwalian" style="display: none;">
            
            <div class="homeroom-overview-box">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">
                    <div>
                        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i>
                            <span>Pantauan KBM &amp; Presensi Kelas {{ $kelasWali->nama_kelas }}</span>
                        </h2>
                        <p style="font-size: 12.5px; color: #64748b; margin: 4px 0 0 0;">
                            Monitoring kehadiran peserta didik dan pengisian jurnal guru pengajar di kelas perwalian Anda
                        </p>
                    </div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-header-action btn-header-secondary" style="padding: 7px 14px; font-size: 12px;" title="Buka Rekap Presensi & Perkembangan Kelas">
                            <i class="fa-solid fa-id-card-clip" style="color: #2563eb;"></i> Presensi Kelas
                        </a>
                        <a href="{{ route('guru.absensi-siswa') }}" class="btn-header-action btn-header-secondary" style="padding: 7px 14px; font-size: 12px;" title="Presensi Siswa">
                            <i class="fa-solid fa-user-check" style="color: #16a34a;"></i> Presensi Siswa
                        </a>
                        <a href="{{ route('guru.nilai-rapor') }}" class="btn-header-action btn-header-secondary" style="padding: 7px 14px; font-size: 12px;" title="Buku Nilai Siswa">
                            <i class="fa-solid fa-graduation-cap" style="color: #384972;"></i> Nilai Siswa
                        </a>
                        <a href="{{ route('guru.surat-dispen') }}" class="btn-header-action btn-header-secondary" style="padding: 7px 14px; font-size: 12px;" title="Surat Dispensasi Siswa">
                            <i class="fa-solid fa-envelope-open-text" style="color: #ea580c;"></i> Surat Dispen
                        </a>
                    </div>
                </div>

                <!-- 4 Highlight Metrics Kelas Perwalian -->
                <div class="homeroom-metrics-grid">
                    <div class="homeroom-metric-item">
                        <div class="homeroom-metric-label">Total Peserta Didik</div>
                        <div class="homeroom-metric-val">{{ $waliKelasData['totalSiswa'] }} Siswa</div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">Kelas {{ $kelasWali->nama_kelas }} &bull; Aktif Terdaftar</div>
                    </div>

                    <div class="homeroom-metric-item">
                        <div class="homeroom-metric-label">Kehadiran Hari Ini</div>
                        <div class="homeroom-metric-val" style="color: #16a34a;">
                            {{ $waliKelasData['totalHadir'] }} <span style="font-size: 13px; font-weight: 600; color: #64748b;">({{ $waliKelasData['persenHadir'] }}%)</span>
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">Siswa hadir KBM di kelas</div>
                    </div>

                    <div class="homeroom-metric-item" style="cursor: pointer; transition: all 0.15s ease;" onclick="openModalDetailKetidakhadiranWali()" title="Klik untuk melihat rincian nama siswa tidak hadir">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="homeroom-metric-label">Ketidakhadiran Hari Ini</div>
                            <span style="font-size: 10.5px; font-weight: 800; color: #2563eb; background: #eff6ff; padding: 1px 6px; border-radius: 4px;">Lihat &rarr;</span>
                        </div>
                        <div class="homeroom-metric-val" style="color: #ea580c; font-size: 16px; font-weight: 800;">
                            {{ $waliKelasData['rekapAbsen']['sakit'] }} S &bull; {{ $waliKelasData['rekapAbsen']['izin'] }} I &bull; {{ $waliKelasData['rekapAbsen']['alpa'] }} A &bull; {{ $waliKelasData['rekapAbsen']['dispen'] }} D
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">Sakit, Izin, Alpa, Dispen (Klik rincian)</div>
                    </div>

                    <div class="homeroom-metric-item">
                        <div class="homeroom-metric-label">Jurnal Guru Hari Ini</div>
                        <div class="homeroom-metric-val" style="color: #2563eb;">
                            {{ $waliKelasData['jurnalTerisi'] }} / {{ max($waliKelasData['totalJadwal'], 1) }}
                        </div>
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">Mapel KBM terisi hari {{ $waliKelasData['hariPantau'] }}</div>
                    </div>
                </div>

                <!-- Live Table of Homeroom Schedule & Journal Status with Day Filter -->
                <div style="margin-top: 18px;">
                    <div class="schedule-header-row" style="margin-bottom: 12px;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i>
                            <span id="labelJadwalWali">Jadwal &amp; Status Jurnal KBM Kelas {{ $kelasWali->nama_kelas }}</span>
                        </h3>

                        <!-- Day Navigation Pills for Homeroom Class -->
                        <div class="day-nav-pills">
                            <button type="button" class="day-pill-btn" onclick="filterJadwalWali('senin', this)">Senin</button>
                            <button type="button" class="day-pill-btn" onclick="filterJadwalWali('selasa', this)">Selasa</button>
                            <button type="button" class="day-pill-btn" onclick="filterJadwalWali('rabu', this)">Rabu</button>
                            <button type="button" class="day-pill-btn" onclick="filterJadwalWali('kamis', this)">Kamis</button>
                            <button type="button" class="day-pill-btn" onclick="filterJadwalWali('jumat', this)">Jumat</button>
                            <button type="button" class="day-pill-btn active" onclick="filterJadwalWali('semua', this)">Semua</button>
                        </div>
                    </div>

                    <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                        <table class="table-schedule" id="tableJadwalWali">
                            <thead>
                                <tr>
                                    <th style="width: 140px;">JAM KE-</th>
                                    <th style="width: 90px;" class="col-hari-wali">HARI</th>
                                    <th>MATA PELAJARAN</th>
                                    <th>GURU PENGAJAR</th>
                                    <th>RUANGAN</th>
                                    <th style="width: 170px; text-align: center;">STATUS JURNAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($waliKelasData['semuaJadwals'] as $jw)
                                    @php
                                        $jwDiisi = $jw->isDiisiHariIni();
                                        $jwJurnalToday = $jwDiisi ? $jw->jurnal_hari_ini : null;
                                        $jwHariLower = strtolower(trim($jw->hari));
                                    @endphp
                                    <tr class="row-jadwal-wali" data-day="{{ $jwHariLower }}">
                                        <td>
                                            <strong>Jam ke-{{ $jw->jam_range }}</strong>
                                            <div class="time-badge">{{ $jw->waktu_mulai_effective }} - {{ $jw->waktu_selesai_effective }} WIB</div>
                                        </td>
                                        <td class="col-hari-wali"><strong style="color: #2563eb;">{{ $jw->hari }}</strong></td>
                                        <td><strong>{{ $jw->mapel->nama_mapel ?? '-' }}</strong></td>
                                        <td>
                                            <span>{{ $jw->guru->nama_guru ?? '-' }}</span>
                                            @if(Auth::user()->id_guru && $jw->id_guru == Auth::user()->id_guru)
                                                <span style="font-size: 10px; font-weight: 800; background: #eff6ff; color: #1d4ed8; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Anda</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-size: 12px; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; color: #475569;">
                                                {{ $jw->ruangan->nama_ruangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($jwDiisi)
                                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                                    <span class="badge-filled">
                                                        <i class="fa-solid fa-circle-check"></i> Terisi
                                                    </span>
                                                    @if($jwJurnalToday)
                                                        <button type="button" class="btn-action-view" onclick='openModalDetailJurnal(@json($jwJurnalToday), "{{ addslashes($kelasWali->nama_kelas) }}", "{{ addslashes($jw->mapel->nama_mapel ?? "-") }}")' title="Lihat Catatan KBM & Presensi">
                                                            <i class="fa-solid fa-eye"></i> Detail
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                @if(Auth::user()->id_guru && $jw->id_guru == Auth::user()->id_guru && $jwHariLower === strtolower(trim($todayIndo)) && $jw->sudah_masuk_jam)
                                                    <a href="{{ route('guru.jurnal-harian', ['id_jadwal' => $jw->id_jadwal]) }}" class="btn-jurnal" style="padding: 5px 10px; font-size: 11.5px;">
                                                        <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal
                                                    </a>
                                                @else
                                                    <span class="btn-disabled" style="color: #9a3412; background: #fff7ed; border-color: #ffedd5;">
                                                        <i class="fa-solid fa-clock"></i> Belum Diisi
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 28px;">
                                            Belum ada data jadwal KBM untuk kelas {{ $kelasWali->nama_kelas }}.
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="rowJadwalWaliEmpty" style="display: none;">
                                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 28px;">
                                        Tidak ada jadwal KBM di kelas {{ $kelasWali->nama_kelas }} pada hari yang dipilih.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    @endif

    <!-- MODAL 1: DETAIL JURNAL MENGAJAR -->
    <div class="modal-backdrop-custom" id="modalDetailJurnal" onclick="if(event.target === this) closeModalDetailJurnal()">
        <div class="modal-box-custom">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 18px 18px 0 0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="color: #2563eb; font-size: 18px;"></i>
                    <h3 style="font-size: 15.5px; font-weight: 800; color: #0f172a; margin: 0;">Detail Catatan Jurnal Mengajar</h3>
                </div>
                <button type="button" onclick="closeModalDetailJurnal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div style="background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b;">Kelas &amp; Mapel</div>
                        <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;" id="mdlKelasMapel">-</div>
                    </div>
                    <div style="background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b;">Tanggal &amp; Pertemuan</div>
                        <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;" id="mdlTglPertemuan">-</div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Materi Pembelajaran</div>
                    <div id="mdlMateri" style="font-size: 13px; font-weight: 600; color: #1e293b; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 12px 14px; line-height: 1.5;">-</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Catatan KBM / Kelas</div>
                    <div id="mdlCatatan" style="font-size: 12.5px; color: #475569; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 14px;">-</div>
                </div>

                <div>
                    <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Rekap Ketidakhadiran Siswa</div>
                    <div id="mdlAbsenList" style="font-size: 12.5px;">-</div>
                </div>
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; background: #f8fafc; border-radius: 0 0 18px 18px;">
                <button type="button" onclick="closeModalDetailJurnal()" class="btn-action-view" style="padding: 8px 18px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: DETAIL PENGUMUMAN -->
    <div class="modal-backdrop-custom" id="modalDetailPengumuman" onclick="if(event.target === this) closeModalDetailPengumuman()">
        <div class="modal-box-custom">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 18px 18px 0 0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-bullhorn" style="color: #2563eb; font-size: 18px;"></i>
                    <h3 style="font-size: 15.5px; font-weight: 800; color: #0f172a; margin: 0;">Detail Pengumuman Sekolah</h3>
                </div>
                <button type="button" onclick="closeModalDetailPengumuman()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span id="mdlPengumumanKategori" style="font-size: 11px; font-weight: 800; color: #3730a3; background: #e0e7ff; padding: 3px 9px; border-radius: 6px;">Umum</span>
                    <span id="mdlPengumumanTanggal" style="font-size: 12px; color: #64748b; font-weight: 700;">-</span>
                </div>

                <h3 id="mdlPengumumanJudul" style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 14px; line-height: 1.4;"></h3>

                <div id="mdlPengumumanIsi" style="font-size: 13px; color: #334155; line-height: 1.6; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; white-space: pre-line; max-height: 250px; overflow-y: auto;">
                </div>
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border-radius: 0 0 18px 18px;">
                <a href="{{ route('guru.pengumuman') }}" style="font-size: 12.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                    Buka Halaman Pengumuman &rarr;
                </a>
                <button type="button" onclick="closeModalDetailPengumuman()" class="btn-action-view" style="padding: 8px 18px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: INFORMASI WAKTU PENGISIAN JURNAL (WAKTU BELUM MASUK / BUKAN HARI INI) -->
    <div class="modal-backdrop-custom" id="modalTimeLock" onclick="if(event.target === this) closeModalTimeLock()">
        <div class="modal-box-custom" style="max-width: 520px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 18px 18px 0 0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 style="font-size: 15.5px; font-weight: 800; color: #0f172a; margin: 0;">Informasi Pengisian Jurnal</h3>
                </div>
                <button type="button" onclick="closeModalTimeLock()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px;">
                <div style="display: flex; align-items: flex-start; gap: 14px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px 16px; margin-bottom: 18px;">
                    <i class="fa-solid fa-circle-info" style="color: #2563eb; font-size: 20px; margin-top: 2px;"></i>
                    <div style="font-size: 13px; color: #1e3a8a; line-height: 1.5;">
                        <strong id="timeLockAlertTitle" style="display: block; font-size: 13.5px; margin-bottom: 3px; color: #1e40af;">Fitur Pengisian Jurnal Belum Aktif</strong>
                        <span id="timeLockAlertMessage">Pengisian jurnal KBM hanya dapat diakses pada saat jam pelajaran guru mengajar berlangsung sesuai jadwal.</span>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 12.5px;">
                        <div>
                            <span style="display: block; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Mata Pelajaran &amp; Kelas</span>
                            <strong style="color: #0f172a; font-size: 13px;" id="timeLockMapelKelas">-</strong>
                        </div>
                        <div>
                            <span style="display: block; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase;">Jadwal Pelajaran</span>
                            <strong style="color: #2563eb; font-size: 13px;" id="timeLockWaktu">-</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; background: #f8fafc; border-radius: 0 0 18px 18px;">
                <button type="button" onclick="closeModalTimeLock()" class="btn-action-view" style="padding: 8px 18px;">Mengerti &amp; Tutup</button>
            </div>
        </div>
    </div>

    @if($isWaliKelas && $kelasWali && $waliKelasData)
    <!-- MODAL 4: DETAIL KETIDAKHADIRAN SISWA KELAS PERWALIAN -->
    <div class="modal-backdrop-custom" id="modalDetailKetidakhadiranWali" onclick="if(event.target === this) closeModalDetailKetidakhadiranWali()">
        <div class="modal-box-custom" style="max-width: 680px;">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border-radius: 18px 18px 0 0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 17px;">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 15.5px; font-weight: 800; color: #0f172a; margin: 0;">Rincian Ketidakhadiran Peserta Didik</h3>
                        <div style="font-size: 12px; color: #64748b; margin-top: 1px;">Kelas {{ $kelasWali->nama_kelas }} &bull; {{ $formattedDateStr }}</div>
                    </div>
                </div>
                <button type="button" onclick="closeModalDetailKetidakhadiranWali()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px;">
                @if(empty($waliKelasData['siswaTidakHadirList']))
                    <div style="text-align: center; padding: 32px 20px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 40px; color: #16a34a; margin-bottom: 10px;"></i>
                        <div style="font-size: 15px; font-weight: 800; color: #15803d;">Kehadiran Lengkap (100%)</div>
                        <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
                            Seluruh peserta didik kelas {{ $kelasWali->nama_kelas }} terdata hadir pada kegiatan KBM hari ini.
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 14px; font-size: 13px; color: #334155; font-weight: 700; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                        <span>Daftar Siswa Tidak Hadir (Total: {{ count($waliKelasData['siswaTidakHadirList']) }} Siswa)</span>
                        <span style="font-size: 11.5px; color: #64748b;">{{ $waliKelasData['rekapAbsen']['sakit'] }} S &bull; {{ $waliKelasData['rekapAbsen']['izin'] }} I &bull; {{ $waliKelasData['rekapAbsen']['alpa'] }} A &bull; {{ $waliKelasData['rekapAbsen']['dispen'] }} D</span>
                    </div>

                    <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px;">
                        <table class="table-schedule" style="font-size: 12.5px;">
                            <thead>
                                <tr>
                                    <th style="width: 40px; text-align: center;">NO</th>
                                    <th>NAMA SISWA</th>
                                    <th style="width: 110px;">NISN / NIS</th>
                                    <th style="width: 90px; text-align: center;">STATUS</th>
                                    <th>KETERANGAN / SUMBER</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waliKelasData['siswaTidakHadirList'] as $idx => $sAbsen)
                                    @php
                                        $stLower = strtolower($sAbsen['status']);
                                        $badgeColor = '#475569';
                                        $badgeBg = '#f1f5f9';
                                        if ($stLower === 'sakit') {
                                            $badgeColor = '#0369a1'; $badgeBg = '#e0f2fe';
                                        } elseif ($stLower === 'izin') {
                                            $badgeColor = '#4338ca'; $badgeBg = '#e0e7ff';
                                        } elseif ($stLower === 'dispen') {
                                            $badgeColor = '#c2410c'; $badgeBg = '#ffedd5';
                                        } elseif ($stLower === 'alpa') {
                                            $badgeColor = '#b91c1c'; $badgeBg = '#fee2e2';
                                        }
                                    @endphp
                                    <tr>
                                        <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                                        <td><strong style="color: #0f172a;">{{ $sAbsen['nama'] }}</strong></td>
                                        <td style="color: #64748b;">{{ $sAbsen['nisn'] }}</td>
                                        <td style="text-align: center;">
                                            <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: {{ $badgeBg }}; color: {{ $badgeColor }}; text-transform: uppercase;">
                                                {{ $sAbsen['status'] }}
                                            </span>
                                        </td>
                                       <td>
                                           <div style="font-size: 12px; color: #334155;">{{ $sAbsen['keterangan'] }}</div>
                                           <div style="font-size: 10.5px; color: #64748b; font-weight: 700; margin-top: 2px;">Sumber: {{ $sAbsen['sumber'] }}</div>
                                       </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border-radius: 0 0 18px 18px;">
                <a href="{{ route('guru.kehadiran-kelas') }}" style="font-size: 12.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                    Buka Halaman Presensi &amp; Perkembangan Kelas &rarr;
                </a>
                <button type="button" onclick="closeModalDetailKetidakhadiranWali()" class="btn-action-view" style="padding: 8px 18px;">Tutup</button>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')
<script>
    // Tab Switcher for Wali Kelas
    function switchMainTab(tab) {
        const secMengajar = document.getElementById('sectionMengajar');
        const secPerwalian = document.getElementById('sectionPerwalian');
        const btnMengajar = document.getElementById('btnTabMengajar');
        const btnPerwalian = document.getElementById('btnTabPerwalian');

        if (tab === 'perwalian' && secPerwalian) {
            if (secMengajar) secMengajar.style.display = 'none';
            secPerwalian.style.display = 'block';
            if (btnMengajar) btnMengajar.classList.remove('active');
            if (btnPerwalian) btnPerwalian.classList.add('active');
            try { localStorage.setItem('guru_active_tab', 'perwalian'); } catch(e){}
        } else {
            if (secMengajar) secMengajar.style.display = 'block';
            if (secPerwalian) secPerwalian.style.display = 'none';
            if (btnMengajar) btnMengajar.classList.add('active');
            if (btnPerwalian) btnPerwalian.classList.remove('active');
            try { localStorage.setItem('guru_active_tab', 'mengajar'); } catch(e){}
        }
    }

    // Filter Jadwal Kelas Perwalian by Day
    function filterJadwalWali(day, btn) {
        document.querySelectorAll('#sectionPerwalian .day-pill-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const rows = document.querySelectorAll('.row-jadwal-wali');
        let visibleCount = 0;

        rows.forEach(r => {
            if (day === 'semua' || r.dataset.day === day) {
                r.style.display = '';
                visibleCount++;
            } else {
                r.style.display = 'none';
            }
        });

        const emptyRow = document.getElementById('rowJadwalWaliEmpty');
        if (emptyRow) {
            emptyRow.style.display = (visibleCount === 0) ? '' : 'none';
        }
    }

    // Modal 1: Detail Jurnal Mengajar
    function openModalDetailJurnal(jurnal, kelasNama, mapelNama) {
        if (!jurnal) return;
        document.getElementById('mdlKelasMapel').textContent = kelasNama + ' • ' + mapelNama;
        document.getElementById('mdlTglPertemuan').textContent = (jurnal.tanggal || '-') + ' • Pertemuan Ke-' + (jurnal.pertemuan_ke || '1');
        document.getElementById('mdlMateri').textContent = jurnal.materi || '-';
        document.getElementById('mdlCatatan').textContent = jurnal.catatan || 'Tidak ada catatan khusus.';

        const absenContainer = document.getElementById('mdlAbsenList');
        if (jurnal.detail_ketidakhadiran && jurnal.detail_ketidakhadiran.length > 0) {
            let html = '<div style="display:flex; flex-direction:column; gap:6px;">';
            jurnal.detail_ketidakhadiran.forEach(d => {
                const sName = d.siswa ? d.siswa.nama_siswa : 'Siswa';
                html += '<div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:6px 10px; border-radius:6px; display:flex; justify-content:space-between;">' +
                    '<span><strong>' + sName + '</strong></span>' +
                    '<span style="font-weight:800; font-size:11px; text-transform:uppercase;">' + (d.keterangan || d.status || 'Absen') + '</span>' +
                    '</div>';
            });
            html += '</div>';
            absenContainer.innerHTML = html;
        } else {
            absenContainer.innerHTML = '<span style="color:#16a34a; font-weight:700;"><i class="fa-solid fa-check"></i> Seluruh siswa hadir lengkap (100%).</span>';
        }

        document.getElementById('modalDetailJurnal').style.display = 'flex';
    }

    function closeModalDetailJurnal() {
        document.getElementById('modalDetailJurnal').style.display = 'none';
    }

    // Modal 2: Detail Pengumuman
    function openModalDetailPengumuman(pengumuman) {
        if (!pengumuman) return;
        document.getElementById('mdlPengumumanKategori').textContent = pengumuman.kategori || 'Umum';
        document.getElementById('mdlPengumumanTanggal').textContent = pengumuman.tanggal || '-';
        document.getElementById('mdlPengumumanJudul').textContent = pengumuman.judul || '-';
        document.getElementById('mdlPengumumanIsi').textContent = pengumuman.isi || '-';

        document.getElementById('modalDetailPengumuman').style.display = 'flex';
    }

    function closeModalDetailPengumuman() {
        document.getElementById('modalDetailPengumuman').style.display = 'none';
    }

    // Modal 3: Time Lock Information
    function showBelumJamModal(mapel, kelas, hari, waktu, tipe) {
        document.getElementById('timeLockMapelKelas').textContent = mapel + ' (' + kelas + ')';
        document.getElementById('timeLockWaktu').textContent = hari + ', ' + waktu;

        if (tipe === 'belum_jam') {
            document.getElementById('timeLockAlertTitle').textContent = 'Belum Memasuki Jam Pelajaran';
            document.getElementById('timeLockAlertMessage').textContent = 'Jam pelajaran ini belum dimulai. Fitur pengisian jurnal otomatis aktif dan dapat diisi setelah memasuki jam pelajaran (' + waktu + ').';
        } else {
            document.getElementById('timeLockAlertTitle').textContent = 'Bukan Jadwal Hari Ini';
            document.getElementById('timeLockAlertMessage').textContent = 'Jadwal pelajaran ini berlangsung pada ' + hari + '. Sesuai alur sistem, pengisian jurnal mengajar hanya dapat diakses dan diisi pada hari jadwal tersebut saat jam pelajaran berlangsung.';
        }

        document.getElementById('modalTimeLock').style.display = 'flex';
    }

    function closeModalTimeLock() {
        document.getElementById('modalTimeLock').style.display = 'none';
    }

    // Modal 4: Detail Ketidakhadiran Siswa Perwalian
    function openModalDetailKetidakhadiranWali() {
        const m = document.getElementById('modalDetailKetidakhadiranWali');
        if (m) m.style.display = 'flex';
    }

    function closeModalDetailKetidakhadiranWali() {
        const m = document.getElementById('modalDetailKetidakhadiranWali');
        if (m) m.style.display = 'none';
    }

    // Keyboard ESC to close modals & restore saved tab
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalDetailJurnal();
            closeModalDetailPengumuman();
            closeModalTimeLock();
            closeModalDetailKetidakhadiranWali();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const secPerwalian = document.getElementById('sectionPerwalian');
        const secMengajar = document.getElementById('sectionMengajar');

        if (!secPerwalian) {
            // Pengguna bukan Wali Kelas -> selalu tampilkan Ringkasan Mengajar secara penuh
            if (secMengajar) secMengajar.style.display = 'block';
            try { localStorage.removeItem('guru_active_tab'); } catch(e){}
        } else {
            try {
                const savedTab = localStorage.getItem('guru_active_tab');
                if (savedTab === 'perwalian') {
                    switchMainTab('perwalian');
                } else {
                    switchMainTab('mengajar');
                }
            } catch(e) {
                switchMainTab('mengajar');
            }
        }
    });
</script>
@endsection