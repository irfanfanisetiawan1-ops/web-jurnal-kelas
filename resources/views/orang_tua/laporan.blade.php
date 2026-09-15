@extends('layouts.orang_tua')

@section('title', 'Laporan Kehadiran Akademik — Jurnal SMEA')

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

    .laporan-wrapper {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    /* Page Header */
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
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
    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--c-gray-slate);
        margin: 0;
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
        margin: 4px 0 0;
        color: var(--c-gray-muted);
        font-size: 13.5px;
        font-weight: 600;
    }

    /* Filter Controls */
    .filter-group-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-select-box {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--c-white);
        border: 1.5px solid var(--c-gray-border-light);
        padding: 6px 12px;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    .filter-select-box select {
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        color: var(--c-navy-deep);
        background: transparent;
        cursor: pointer;
    }
    .btn-print-action {
        background: var(--c-white);
        border: 1.5px solid var(--c-gray-border-light);
        color: var(--c-navy-deep);
        padding: 8px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .btn-print-action:hover {
        background: var(--c-gray-bg-soft);
        border-color: var(--c-blue-light);
        color: var(--c-blue-primary);
        transform: translateY(-1px);
    }

    /* Student Info Strip */
    .student-info-strip {
        background: var(--c-white);
        border-radius: 18px;
        padding: 18px 24px;
        border: 1.5px solid var(--c-gray-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.03);
    }
    .student-info-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .student-mini-avatar {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--c-navy-brand);
        border: 2px solid var(--c-gray-border-light);
        flex-shrink: 0;
        overflow: hidden;
    }
    .student-mini-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 6 Summary Stat Cards Grid */
    .summary-cards-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }
    @media (max-width: 1100px) {
        .summary-cards-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 650px) {
        .summary-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .mini-stat-card {
        background: var(--c-white);
        border-radius: 15px;
        padding: 14px 16px;
        border: 1.5px solid var(--c-gray-border);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .mini-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.06);
    }
    .mini-stat-card .stat-head {
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--c-gray-muted);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .mini-stat-card .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: var(--c-gray-slate);
        line-height: 1;
        margin-bottom: 4px;
    }
    .mini-stat-card .stat-sub {
        font-size: 11px;
        font-weight: 600;
        color: var(--c-gray-muted);
    }

    .mini-total  { border-top: 3px solid var(--c-navy-brand); }
    .mini-hadir  { border-top: 3px solid #16a34a; }
    .mini-hadir .stat-val { color: #15803d; }
    .mini-sakit  { border-top: 3px solid #2563eb; }
    .mini-sakit .stat-val { color: #1d4ed8; }
    .mini-izin   { border-top: 3px solid #d97706; }
    .mini-izin .stat-val { color: #b45309; }
    .mini-alpa   { border-top: 3px solid #dc2626; }
    .mini-alpa .stat-val { color: #b91c1c; }
    .mini-dispen { border-top: 3px solid #9333ea; }
    .mini-dispen .stat-val { color: #7e22ce; }

    /* Custom Card */
    .custom-card {
        background: var(--c-white);
        border-radius: 18px;
        padding: 22px 26px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.03);
        border: 1.5px solid var(--c-gray-border);
    }
    .card-title-header {
        font-size: 16px;
        font-weight: 800;
        color: var(--c-gray-slate);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Bar Chart Component */
    .bar-chart-container {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 180px;
        padding: 0 20px;
        border-bottom: 2px solid var(--c-gray-border);
        position: relative;
    }
    .chart-bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        width: 80px;
        height: 100%;
        justify-content: flex-end;
    }
    .chart-bar-pillar {
        width: 100%;
        max-width: 54px;
        border-radius: 8px 8px 0 0;
        transition: height 0.5s ease;
    }

    /* Tables */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        text-align: left;
    }
    .custom-table thead tr th {
        background: var(--c-gray-bg-soft);
        color: var(--c-gray-dark);
        font-size: 13px;
        font-weight: 800;
        padding: 12px 16px;
        border-bottom: 2px solid var(--c-gray-border-light);
    }
    .custom-table tbody tr td {
        padding: 13px 16px;
        border-bottom: 1px solid var(--c-gray-border);
        font-size: 13px;
        color: var(--c-gray-dark);
        font-weight: 600;
        vertical-align: middle;
    }
    .custom-table tbody tr:hover td {
        background: var(--c-gray-bg-light);
    }

    /* Status Badge Pills */
    .status-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 0.3px;
    }
    .pill-hadir  { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .pill-sakit  { background: #eff6ff; color: #1d4ed8; border: 1px solid #93c5fd; }
    .pill-izin   { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .pill-alpa   { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }
    .pill-dispen { background: #faf5ff; color: #7e22ce; border: 1px solid #d8b4fe; }

    /* Print Kop Header */
    .print-only-kop {
        display: none;
    }

    /* Print Styles */
    @media print {
        .sidebar, .topbar, .btn-print-action, .filter-group-wrapper, .page-breadcrumb {
            display: none !important;
        }
        body {
            background: #ffffff !important;
            color: #000000 !important;
        }
        .main-wrapper {
            margin-left: 0 !important;
        }
        .content-body {
            padding: 0 !important;
        }
        .laporan-wrapper {
            gap: 14px !important;
        }
        .custom-card, .student-info-strip {
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
            margin-bottom: 12px !important;
            break-inside: avoid;
        }
        .print-only-kop {
            display: block !important;
            text-align: center;
            border-bottom: 3px double #000000;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }
        .print-only-kop h2 {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
        }
        .print-only-kop p {
            font-size: 11.5px;
            margin: 2px 0 0 0;
        }
        .print-signature-area {
            display: flex !important;
            justify-content: space-between;
            margin-top: 30px;
            padding: 0 40px;
            page-break-inside: avoid;
        }
    }
</style>
@endsection

@section('content')
<div class="laporan-wrapper">

    <!-- Kop Surat untuk Mode Cetak (Print Only) -->
    <div class="print-only-kop">
        <h2>SMK EKONOMI &amp; BISNIS (SMK SMEA)</h2>
        <p style="font-weight: 700;">LAPORAN REKAPITULASI KEHADIRAN AKADEMIK SISWA</p>
        <p style="font-style: italic; font-size: 11px;">Periode: {{ $rekapBulan['nama_bulan'] }} • Tahun Ajaran {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - Semester {{ $activeTahunAjaran->semester ?? 'Ganjil' }}</p>
    </div>

    <!-- Top Page Header -->
    <div class="page-header-box">
        <div>
            <div class="page-breadcrumb">
                <a href="{{ route('orang-tua.dashboard') }}">Jurnal SMEA</a>
                <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                <span>Laporan Kehadiran</span>
            </div>
            <h1 class="page-title">
                <span class="page-title-icon">
                    <i class="fa-solid fa-chart-column"></i>
                </span>
                <span>Laporan Kehadiran Akademik Siswa</span>
            </h1>
            <p class="page-subtitle">
                Rekapitulasi presensi bulanan dan rincian kehadiran anak berdasarkan catatan Jurnal Guru.
            </p>
        </div>

        <div class="filter-group-wrapper">
            <!-- Filter Dropdown Form -->
            <form method="GET" action="{{ route('orang-tua.laporan') }}" style="display: flex; align-items: center; gap: 8px; margin: 0;">
                <div class="filter-select-box">
                    <i class="fa-regular fa-calendar" style="color: var(--c-blue-primary);"></i>
                    <select name="bulan" onchange="this.form.submit()">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $filterBulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(2026, $m, 1)->locale('id')->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="filter-select-box">
                    <select name="tahun" onchange="this.form.submit()">
                        <option value="2025" {{ $filterTahun == 2025 ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ $filterTahun == 2026 ? 'selected' : '' }}>2026</option>
                        <option value="2027" {{ $filterTahun == 2027 ? 'selected' : '' }}>2027</option>
                    </select>
                </div>
            </form>

            <button type="button" onclick="window.print()" class="btn-print-action" title="Cetak Laporan Kehadiran">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </div>

    @if($siswa)
        <!-- Student Information Strip -->
        <div class="student-info-strip">
            <div class="student-info-left">
                <div class="student-mini-avatar">
                    @if($siswa->foto_url)
                        <img src="{{ $siswa->foto_url }}" alt="{{ $siswa->nama_siswa }}">
                    @else
                        <i class="fa-solid fa-user-graduate"></i>
                    @endif
                </div>
                <div>
                    <h2 style="font-size: 18px; font-weight: 800; color: var(--c-gray-slate); margin: 0 0 2px 0; text-transform: uppercase;">
                        {{ $siswa->nama_siswa }}
                    </h2>
                    <div style="font-size: 13px; color: var(--c-gray-muted); font-weight: 600; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span>Kelas: <strong style="color: var(--c-gray-dark);">{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></span>
                        <span>•</span>
                        <span>NISN: <strong style="color: var(--c-gray-dark);">{{ $siswa->nisn ?? '-' }}</strong></span>
                        @if($siswa->nis)
                            <span>•</span>
                            <span>NIS: <strong style="color: var(--c-gray-dark);">{{ $siswa->nis }}</strong></span>
                        @endif
                        <span>•</span>
                        <span>Jurusan: <strong style="color: var(--c-gray-dark);">{{ $siswa->kelas->jurusan->nama_jurusan ?? ($siswa->jurusan ?? 'SMK SMEA') }}</strong></span>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 800;">
                    <i class="fa-solid fa-circle-check"></i> Siswa Aktif
                </span>
                <span style="background: var(--c-navy-brand); color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">
                    <i class="fa-solid fa-user-tie"></i> Wali Kelas: {{ $siswa->kelas->waliKelas->nama_guru ?? ($siswa->kelas->wali_kelas ?? 'Sulistyowati, S.Pd') }}
                </span>
                <span style="background: var(--c-gray-bg-soft); color: var(--c-navy-deep); border: 1px solid var(--c-gray-border); padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">
                    T.A. {{ $activeTahunAjaran->tahun_ajaran ?? '2026/2027' }} - {{ $activeTahunAjaran->semester ?? 'Ganjil' }}
                </span>
            </div>
        </div>

        <!-- 6 Summary Stat Cards Grid -->
        <div class="summary-cards-grid">
            <!-- Total Pertemuan KBM -->
            <div class="mini-stat-card mini-total">
                <div class="stat-head">
                    <span>Total KBM</span>
                    <i class="fa-solid fa-calendar-check" style="color: var(--c-navy-brand);"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['total'] }}</div>
                <div class="stat-sub">Sesi Pembelajaran</div>
            </div>

            <!-- Hadir -->
            <div class="mini-stat-card mini-hadir">
                <div class="stat-head">
                    <span style="color: #16a34a;">Hadir</span>
                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['hadir'] }}</div>
                <div class="stat-sub">{{ $rekapBulan['persen_hadir'] }}% Kehadiran</div>
            </div>

            <!-- Sakit -->
            <div class="mini-stat-card mini-sakit">
                <div class="stat-head">
                    <span style="color: #2563eb;">Sakit</span>
                    <i class="fa-solid fa-hospital-user" style="color: #2563eb;"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['sakit'] }}</div>
                <div class="stat-sub">{{ $rekapBulan['persen_sakit'] }}% dari Total KBM</div>
            </div>

            <!-- Izin -->
            <div class="mini-stat-card mini-izin">
                <div class="stat-head">
                    <span style="color: #d97706;">Izin</span>
                    <i class="fa-solid fa-envelope-open-text" style="color: #d97706;"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['izin'] }}</div>
                <div class="stat-sub">{{ $rekapBulan['persen_izin'] }}% dari Total KBM</div>
            </div>

            <!-- Alpa -->
            <div class="mini-stat-card mini-alpa">
                <div class="stat-head">
                    <span style="color: #dc2626;">Alpa</span>
                    <i class="fa-solid fa-triangle-exclamation" style="color: #dc2626;"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['alfa'] }}</div>
                <div class="stat-sub">{{ $rekapBulan['persen_alfa'] }}% Tanpa Ket.</div>
            </div>

            <!-- Dispen -->
            <div class="mini-stat-card mini-dispen">
                <div class="stat-head">
                    <span style="color: #9333ea;">Dispen</span>
                    <i class="fa-solid fa-file-signature" style="color: #9333ea;"></i>
                </div>
                <div class="stat-val">{{ $rekapBulan['dispen'] }}</div>
                <div class="stat-sub">{{ $rekapBulan['persen_dispen'] }}% Resmi Disetujui</div>
            </div>
        </div>

        <!-- 1. Ringkasan Kehadiran Bulanan Card (Diagram Batang Visual) -->
        <div class="custom-card">
            <div class="card-title-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-simple" style="color: var(--c-blue-primary);"></i>
                    <span>RINGKASAN KEHADIRAN BULAN {{ $rekapBulan['nama_bulan'] }}</span>
                </div>
                <span style="font-size: 12.5px; font-weight: 800; color: var(--c-navy-deep); background: var(--c-gray-bg-soft); padding: 5px 14px; border-radius: 10px; border: 1px solid var(--c-gray-border);">
                    TOTAL PERTEMUAN: {{ $rekapBulan['total'] }} JURNAL
                </span>
            </div>

            <!-- Bar Chart Visualization -->
            <div class="bar-chart-container">
                <!-- Hadir Bar -->
                <div class="chart-bar-col">
                    <div style="font-size: 11.5px; font-weight: 800; color: #166534;">
                        {{ $rekapBulan['hadir'] }} ({{ $rekapBulan['persen_hadir'] }}%)
                    </div>
                    <div class="chart-bar-pillar" style="height: {{ max(16, $rekapBulan['persen_hadir']) }}%; background: #16a34a; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);"></div>
                </div>

                <!-- Sakit Bar -->
                <div class="chart-bar-col">
                    <div style="font-size: 11.5px; font-weight: 800; color: #2563eb;">
                        {{ $rekapBulan['sakit'] }} ({{ $rekapBulan['persen_sakit'] }}%)
                    </div>
                    <div class="chart-bar-pillar" style="height: {{ max(8, $rekapBulan['persen_sakit'] > 0 ? $rekapBulan['persen_sakit'] : ($rekapBulan['sakit'] > 0 ? 15 : 4)) }}%; background: #3b82f6;"></div>
                </div>

                <!-- Izin Bar -->
                <div class="chart-bar-col">
                    <div style="font-size: 11.5px; font-weight: 800; color: #d97706;">
                        {{ $rekapBulan['izin'] }} ({{ $rekapBulan['persen_izin'] }}%)
                    </div>
                    <div class="chart-bar-pillar" style="height: {{ max(8, $rekapBulan['persen_izin'] > 0 ? $rekapBulan['persen_izin'] : ($rekapBulan['izin'] > 0 ? 15 : 4)) }}%; background: #f59e0b;"></div>
                </div>

                <!-- Alfa Bar -->
                <div class="chart-bar-col">
                    <div style="font-size: 11.5px; font-weight: 800; color: #dc2626;">
                        {{ $rekapBulan['alfa'] }} ({{ $rekapBulan['persen_alfa'] }}%)
                    </div>
                    <div class="chart-bar-pillar" style="height: {{ max(8, $rekapBulan['persen_alfa'] > 0 ? $rekapBulan['persen_alfa'] : ($rekapBulan['alfa'] > 0 ? 15 : 4)) }}%; background: #ef4444;"></div>
                </div>

                <!-- Dispen Bar -->
                <div class="chart-bar-col">
                    <div style="font-size: 11.5px; font-weight: 800; color: #9333ea;">
                        {{ $rekapBulan['dispen'] }} ({{ $rekapBulan['persen_dispen'] }}%)
                    </div>
                    <div class="chart-bar-pillar" style="height: {{ max(8, $rekapBulan['persen_dispen'] > 0 ? $rekapBulan['persen_dispen'] : ($rekapBulan['dispen'] > 0 ? 15 : 4)) }}%; background: #a855f7;"></div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-around; margin-top: 14px; text-align: center;">
                <div style="width: 80px; font-size: 12px; font-weight: 800; color: #166534;">HADIR</div>
                <div style="width: 80px; font-size: 12px; font-weight: 800; color: #2563eb;">SAKIT</div>
                <div style="width: 80px; font-size: 12px; font-weight: 800; color: #d97706;">IZIN</div>
                <div style="width: 80px; font-size: 12px; font-weight: 800; color: #dc2626;">ALPA</div>
                <div style="width: 80px; font-size: 12px; font-weight: 800; color: #9333ea;">DISPEN</div>
            </div>
        </div>

        <!-- 2. Tabel Rekapitulasi Kehadiran Harian Siswa -->
        <div class="custom-card">
            <div class="card-title-header">
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: var(--c-gray-slate); margin: 0 0 3px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-calendar-days" style="color: var(--c-blue-primary);"></i>
                        <span>Rekapitulasi Kehadiran Harian Siswa</span>
                    </h3>
                    <p style="font-size: 12.5px; color: var(--c-gray-muted); margin: 0; font-weight: 500;">
                        Ringkasan kehadiran anak pada setiap hari efektif pembelajaran di sekolah.
                    </p>
                </div>
                <div style="font-size: 12px; font-weight: 700; color: var(--c-gray-dark); background: var(--c-gray-bg-soft); padding: 5px 12px; border-radius: 8px; border: 1px solid var(--c-gray-border);">
                    {{ count($rekapHarian) }} Hari KBM Tercatat
                </div>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Tanggal & Hari</th>
                            <th style="width: 18%;">Jumlah Sesi KBM</th>
                            <th style="width: 22%;">Status Kehadiran</th>
                            <th style="width: 35%;">Keterangan & Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapHarian as $rh)
                        <tr>
                            <td style="font-weight: 700; color: var(--c-gray-slate);">
                                <div>{{ $rh->tanggal }}</div>
                                <div style="font-size: 11.5px; color: var(--c-gray-muted); font-weight: 600;">{{ $rh->hari }}</div>
                            </td>
                            <td style="font-weight: 700; color: var(--c-navy-deep);">
                                <i class="fa-regular fa-clock" style="color: var(--c-blue-primary);"></i> {{ $rh->total_kbm }} Sesi KBM
                            </td>
                            <td>
                                <span class="status-badge-pill {{ $rh->pill_class }}">
                                    @if($rh->pill_class === 'pill-hadir')
                                        <i class="fa-solid fa-circle-check"></i>
                                    @elseif($rh->pill_class === 'pill-sakit')
                                        <i class="fa-solid fa-hospital-user"></i>
                                    @elseif($rh->pill_class === 'pill-izin')
                                        <i class="fa-solid fa-envelope-open-text"></i>
                                    @elseif($rh->pill_class === 'pill-alpa')
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    @else
                                        <i class="fa-solid fa-file-signature"></i>
                                    @endif
                                    <span>{{ $rh->status_utama }}</span>
                                </span>
                            </td>
                            <td style="font-size: 12.5px; color: var(--c-gray-dark);">
                                {{ $rh->keterangan }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 28px; color: var(--c-gray-muted);">
                                Belum ada data catatan kehadiran harian untuk bulan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Tabel Rincian Presensi per Mata Pelajaran (KBM Jurnal Guru) -->
        <div class="custom-card">
            <div class="card-title-header">
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: var(--c-gray-slate); margin: 0 0 3px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-book-open-reader" style="color: var(--c-blue-primary);"></i>
                        <span>Rincian Presensi per Mata Pelajaran (Jurnal Guru)</span>
                    </h3>
                    <p style="font-size: 12.5px; color: var(--c-gray-muted); margin: 0; font-weight: 500;">
                        Catatan status presensi anak pada setiap sesi mata pelajaran yang diisi oleh guru di kelas.
                    </p>
                </div>
                <div style="font-size: 12px; font-weight: 700; color: var(--c-gray-dark); background: var(--c-gray-bg-soft); padding: 5px 12px; border-radius: 8px; border: 1px solid var(--c-gray-border);">
                    Total {{ count($rincianPerMapel) }} Sesi KBM
                </div>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 15%;">Jam & Ruangan</th>
                            <th style="width: 25%;">Mata Pelajaran & Guru</th>
                            <th style="width: 25%;">Materi Pembelajaran</th>
                            <th style="width: 20%;">Status Presensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rincianPerMapel as $p)
                        <tr>
                            <td style="font-weight: 700; color: var(--c-gray-slate);">
                                <div>{{ $p->tanggal }}</div>
                                <div style="font-size: 11px; color: var(--c-gray-muted); font-weight: 600;">{{ $p->hari }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--c-navy-deep);">Jam Ke-{{ $p->jam_ke }}</div>
                                <div style="font-size: 11.5px; color: var(--c-gray-muted);">{{ $p->ruangan }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: var(--c-gray-slate);">{{ $p->mapel }}</div>
                                <div style="font-size: 11.5px; color: var(--c-gray-muted); font-weight: 600;">
                                    <i class="fa-solid fa-chalkboard-user" style="font-size: 10px;"></i> {{ $p->guru }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12.5px; color: var(--c-gray-dark); font-weight: 600;">
                                    {{ $p->materi }}
                                    @if($p->pertemuan_ke)
                                        <span style="font-size: 10px; background: #e2e8f0; color: var(--c-navy-deep); padding: 1px 5px; border-radius: 4px; font-weight: 800;">
                                            {{ $p->pertemuan_ke }}
                                        </span>
                                    @endif
                                </div>
                                @if($p->catatan)
                                    <div style="font-size: 11.5px; color: var(--c-gray-muted); margin-top: 2px;">
                                        <em>Catatan: {{ $p->catatan }}</em>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $pClass = 'pill-hadir';
                                    $stLow = strtolower($p->status_presensi);
                                    if ($stLow === 'sakit') $pClass = 'pill-sakit';
                                    elseif ($stLow === 'izin') $pClass = 'pill-izin';
                                    elseif ($stLow === 'alpa' || $stLow === 'alpha') $pClass = 'pill-alpa';
                                    elseif ($stLow === 'dispen') $pClass = 'pill-dispen';
                                @endphp
                                <span class="status-badge-pill {{ $pClass }}">
                                    <i class="fa-solid {{ $p->icon }}"></i>
                                    <span>{{ strtoupper($p->status_presensi) }}</span>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 28px; color: var(--c-gray-muted);">
                                Tidak ditemukan data pembelajaran untuk bulan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Catatan Khusus Lintas Role (Dispen, Telat, Surat Izin) Jika Ada -->
        @if($dispenBulanIni->isNotEmpty() || $telatBulanIni->isNotEmpty() || $suratIzinBulanIni->isNotEmpty())
        <div class="custom-card">
            <div class="card-title-header">
                <div>
                    <h3 style="font-size: 16.5px; font-weight: 800; color: var(--c-gray-slate); margin: 0 0 3px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-network-wired" style="color: var(--c-blue-primary);"></i>
                        <span>Catatan Khusus Presensi & Dispen Bulan Ini</span>
                    </h3>
                    <p style="font-size: 12.5px; color: var(--c-gray-muted); margin: 0; font-weight: 500;">
                        Integrasi data perizinan orang tua, persetujuan dispensasi kesiswaan, dan catatan piket.
                    </p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($dispenBulanIni as $dp)
                    <div style="background: #faf5ff; border: 1.5px solid #d8b4fe; color: #6b21a8; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-file-circle-check" style="font-size: 18px; color: #9333ea; flex-shrink: 0;"></i>
                        <div>
                            <span>Dispensasi Kesiswaan ({{ \Carbon\Carbon::parse($dp->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}): <strong>{{ $dp->alasan ?? 'Dispensasi Kegiatan' }}</strong> • Jam {{ substr($dp->jam_keluar, 0, 5) }} - {{ substr($dp->jam_kembali, 0, 5) }} WIB</span>
                        </div>
                    </div>
                @endforeach

                @foreach($telatBulanIni as $tl)
                    <div style="background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-user-clock" style="font-size: 18px; color: #d97706; flex-shrink: 0;"></i>
                        <div>
                            <span>Catatan Siswa Telat ({{ \Carbon\Carbon::parse($tl->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}): Pukul <strong>{{ $tl->jam_terlambat }} WIB</strong> • Alasan: <em>{{ $tl->alasan ?? 'Terlambat Masuk' }}</em></span>
                        </div>
                    </div>
                @endforeach

                @foreach($suratIzinBulanIni as $si)
                    <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-envelope-open-text" style="font-size: 18px; color: #2563eb; flex-shrink: 0;"></i>
                        <div>
                            <span>Surat Izin Orang Tua ({{ \Carbon\Carbon::parse($si->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}): Kategori <strong>{{ $si->kategori }}</strong> • Keterangan: <em>{{ $si->keterangan ?? '-' }}</em></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Area Tanda Tangan Cetak (Print Only) -->
        <div class="print-signature-area" style="display: none;">
            <div style="text-align: center; width: 220px;">
                <p style="margin: 0; font-size: 12px; font-weight: 600;">Mengetahui,</p>
                <p style="margin: 0; font-size: 12px; font-weight: 700;">Orang Tua / Wali Siswa</p>
                <div style="height: 60px;"></div>
                <p style="margin: 0; font-size: 12px; font-weight: 700; text-decoration: underline;">( .................................................. )</p>
            </div>

            <div style="text-align: center; width: 220px;">
                <p style="margin: 0; font-size: 12px; font-weight: 600;">Wali Kelas {{ $siswa->kelas->nama_kelas ?? 'XI RPL 1' }},</p>
                <p style="margin: 0; font-size: 12px; font-weight: 700;">SMK SMEA</p>
                <div style="height: 60px;"></div>
                <p style="margin: 0; font-size: 12px; font-weight: 700; text-decoration: underline;">{{ $siswa->kelas->waliKelas->nama_guru ?? 'Sulistyowati, S.Pd' }}</p>
            </div>
        </div>

    @else
        <!-- Unlinked State Card -->
        <div style="background: var(--c-white); border-radius: 20px; padding: 48px 24px; text-align: center; color: var(--c-gray-muted); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1.5px solid var(--c-gray-border);">
            <div style="font-size: 32px; color: #94a3b8; margin-bottom: 12px;">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <h2 style="margin: 0 0 6px 0; color: var(--c-gray-slate); font-size: 18px; font-weight: 800;">Akun Orang Tua Belum Terhubung</h2>
            <p style="margin: 0; font-size: 13.5px; color: var(--c-gray-muted);">Akun ini belum terhubung dengan data siswa aktif. Silakan hubungi admin sekolah.</p>
        </div>
    @endif

</div>
@endsection
