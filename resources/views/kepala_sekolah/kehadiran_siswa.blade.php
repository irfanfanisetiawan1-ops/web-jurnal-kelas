@extends('layouts.kepala_sekolah')

@section('title', 'Kehadiran Siswa — Jurnal SMEA')

@section('content')
<style>
    /* Container & Layout */
    .kehadiran-page-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding-bottom: 40px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* 1. Page Header Banner */
    .page-header-banner {
        background: #ffffff;
        padding: 24px 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        box-sizing: border-box;
    }

    .header-text-group {
        flex: 1;
        min-width: 280px;
    }

    .header-breadcrumb {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-title {
        font-size: 23px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.01em;
        line-height: 1.25;
    }

    .header-subtitle {
        margin: 6px 0 0 0;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 500;
        line-height: 1.4;
    }

    .header-action-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .btn-header-print {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(56, 73, 114, 0.25);
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-header-export {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-header-reload {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    /* 2. KPI Stat Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 16px;
        width: 100%;
        box-sizing: border-box;
    }

    .kpi-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-sizing: border-box;
    }

    .kpi-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
    }

    .kpi-value {
        font-size: 26px;
        font-weight: 900;
        line-height: 1.2;
    }

    .kpi-subtext {
        font-size: 11.5px;
        font-weight: 600;
        margin-top: 4px;
    }

    .kpi-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    /* 3. Filter Card */
    .filter-toolbar-card {
        background: #ffffff;
        padding: 18px 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
    }

    .filter-form-wrap {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 14px;
        justify-content: space-between;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-inputs-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .filter-field-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-btn-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter-apply {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-filter-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-family: inherit;
        white-space: nowrap;
    }

    /* 4. Table & Cards Section */
    .table-section-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .table-header-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
    }

    .table-controls-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pills-tingkat-wrap {
        display: flex;
        gap: 6px;
        background: #f8fafc;
        padding: 4px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .tingkat-filter-btn {
        border: none;
        background: transparent;
        color: #64748b;
        padding: 5px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
    }

    .tingkat-filter-btn.active {
        background: #384972;
        color: #ffffff;
    }

    /* Desktop Table Wrapper */
    .desktop-kelas-table-wrapper {
        display: block;
        width: 100%;
        overflow-x: auto;
    }

    .custom-kehadiran-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13.5px;
        table-layout: auto;
    }

    /* Mobile Cards Wrapper (Hidden on Desktop) */
    .mobile-kelas-cards-wrapper {
        display: none;
    }

    .mobile-kelas-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-sizing: border-box;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .mobile-kelas-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    /* ========================================================================= */
    /* RESPONSIVE MEDIA QUERIES (TABLET & MOBILE)                                */
    /* ========================================================================= */
    @media (max-width: 768px) {
        .kehadiran-page-container {
            gap: 16px;
            padding-bottom: 24px;
        }

        .page-header-banner {
            padding: 18px 20px;
            border-radius: 14px;
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
        }

        .header-title {
            font-size: 20px;
        }

        .header-subtitle {
            font-size: 12.5px;
        }

        .header-action-group {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 8px;
        }

        .btn-header-print,
        .btn-header-export {
            width: 100%;
            justify-content: center;
            padding: 10px 12px;
            font-size: 12px;
            box-sizing: border-box;
        }

        .btn-header-reload {
            width: 42px;
            height: 42px;
            padding: 0;
            box-sizing: border-box;
        }

        /* 2x2 KPI Stat Cards Grid */
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .kpi-card {
            padding: 14px 16px;
            border-radius: 12px;
            gap: 8px;
        }

        .kpi-label {
            font-size: 11px;
        }

        .kpi-value {
            font-size: 20px;
        }

        .kpi-subtext {
            font-size: 10.5px;
        }

        .kpi-icon-box {
            width: 38px;
            height: 38px;
            font-size: 16px;
            border-radius: 10px;
        }

        /* Filter Toolbar */
        .filter-toolbar-card {
            padding: 16px 18px;
            border-radius: 14px;
        }

        .filter-form-wrap {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .filter-inputs-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            width: 100%;
        }

        .filter-field-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            width: 100%;
        }

        .filter-field-item label {
            font-size: 11.5px !important;
        }

        .filter-field-item input,
        .filter-field-item select {
            width: 100% !important;
            min-width: 100% !important;
            height: 38px;
            box-sizing: border-box;
        }

        .filter-search-field {
            grid-column: span 2;
            width: 100% !important;
        }

        .filter-search-field input {
            height: 38px;
            font-size: 12.5px;
        }

        .filter-btn-group {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .btn-filter-apply,
        .btn-filter-reset {
            width: 100%;
            justify-content: center;
            height: 38px;
            font-size: 12.5px;
            box-sizing: border-box;
        }

        /* Table Section to Mobile Cards Switch */
        .table-section-card {
            padding: 16px 14px;
            border-radius: 14px;
        }

        .table-header-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .table-controls-wrap {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }

        .pills-tingkat-wrap {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            width: 100%;
            box-sizing: border-box;
        }

        .tingkat-filter-btn {
            text-align: center;
            padding: 6px 4px;
            font-size: 11.5px;
        }

        .live-search-box {
            width: 100% !important;
        }

        .live-search-box input {
            height: 36px;
            font-size: 12px;
        }

        /* Hide Desktop Table, Show Mobile Cards (Zero Horizontal Scroll!) */
        .desktop-kelas-table-wrapper {
            display: none !important;
        }

        .mobile-kelas-cards-wrapper {
            display: flex !important;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        /* Modal Responsive */
        .modal-container-responsive {
            width: 95% !important;
            max-width: 540px !important;
            border-radius: 16px !important;
        }

        .modal-body-responsive {
            padding: 16px !important;
            gap: 14px !important;
        }

        .modal-meta-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        .modal-kpi-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 6px !important;
        }

        .modal-footer-responsive {
            padding: 12px 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .modal-footer-responsive button {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px !important;
            font-size: 12.5px !important;
        }
    }

    @media (max-width: 480px) {
        .header-title {
            font-size: 18px;
        }

        .header-action-group {
            grid-template-columns: 1fr 1fr;
        }

        .btn-header-reload {
            grid-column: span 2;
            width: 100%;
            height: 38px;
        }

        .kpi-grid {
            grid-template-columns: 1fr;
        }

        .filter-inputs-group {
            grid-template-columns: 1fr;
        }

        .filter-search-field {
            grid-column: span 1;
        }

        .modal-kpi-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>

<div class="kehadiran-page-container">

    <!-- 1. Page Header Banner -->
    <div class="page-header-banner">
        <div class="header-text-group">
            <div class="header-breadcrumb">
                DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i> <span style="color: #1e293b; font-weight: 800;">kehadiran siswa</span>
            </div>
            <h1 class="header-title">
                <i class="fa-solid fa-users" style="color: #384972;"></i> Kehadiran Siswa Per Kelas & Rekapitulasi Presensi
            </h1>
            <p class="header-subtitle">
                Pemantauan langsung persentase kehadiran siswa, rekap per rombel kelas, dan status ketidakhadiran (Sakit, Izin, Alpa, Dispensasi).
            </p>
        </div>

        <!-- Action Header Buttons -->
        <div class="header-action-group">
            <button type="button" onclick="openModalCetakKehadiran()" class="btn-header-print">
                <i class="fa-solid fa-print"></i> Cetak Rekap Presensi
            </button>
            <a href="{{ route('kepala-sekolah.kehadiran-siswa', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn-header-export">
                <i class="fa-solid fa-file-excel"></i> Export CSV
            </a>
            <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" title="Muat Ulang Halaman" class="btn-header-reload">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>

    <!-- 2. KPI Executive Stat Cards -->
    <div class="kpi-grid">
        <!-- Card 1: Total Siswa -->
        <div class="kpi-card">
            <div>
                <div class="kpi-label">TOTAL SISWA TERDAFTAR</div>
                <div class="kpi-value" style="color: #0f172a;">{{ $totalSiswaReal }}</div>
                <div class="kpi-subtext" style="color: #384972;">Di Seluruh Rombel Kelas</div>
            </div>
            <div class="kpi-icon-box" style="background: #e0e7ff; color: #3730a3;">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Card 2: Rata-rata Kehadiran -->
        <div class="kpi-card">
            <div>
                <div class="kpi-label">RATA-RATA KEHADIRAN</div>
                <div class="kpi-value" style="color: #16a34a;">{{ $avgPersentase }}%</div>
                <div class="kpi-subtext" style="color: #16a34a;">Tingkat Partisipasi Siswa</div>
            </div>
            <div class="kpi-icon-box" style="background: #dcfce7; color: #16a34a;">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <!-- Card 3: Siswa Hadir -->
        <div class="kpi-card">
            <div>
                <div class="kpi-label">SISWA HADIR KBM</div>
                <div class="kpi-value" style="color: #2563eb;">{{ $grandTotalHadir }}</div>
                <div class="kpi-subtext" style="color: #2563eb;">Mengikuti Pembelajaran</div>
            </div>
            <div class="kpi-icon-box" style="background: #dbeafe; color: #2563eb;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Card 4: Siswa Tidak Hadir -->
        <div class="kpi-card">
            <div>
                <div class="kpi-label">TIDAK HADIR TODAY</div>
                <div class="kpi-value" style="color: #d97706;">{{ $grandTotalAbsen }}</div>
                <div class="kpi-subtext" style="color: #d97706;">Sakit, Izin, Alpa & Dispen</div>
            </div>
            <div class="kpi-icon-box" style="background: #fef3c7; color: #d97706;">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
        </div>
    </div>

    <!-- 3. Global Filter & Search Toolbar -->
    <div class="filter-toolbar-card">
        <form method="GET" action="{{ route('kepala-sekolah.kehadiran-siswa') }}" id="filterFormKehadiran" class="filter-form-wrap">
            <div class="filter-inputs-group">
                <!-- Filter Tanggal -->
                <div class="filter-field-item">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-calendar-day" style="color: #384972;"></i> Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ $filterTanggal }}" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; font-family: inherit;">
                </div>

                <!-- Filter Jurusan -->
                <div class="filter-field-item">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-graduation-cap" style="color: #384972;"></i> Jurusan:</label>
                    <select name="id_jurusan" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; min-width: 140px; font-family: inherit;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanList as $jur)
                            <option value="{{ $jur->id_jurusan }}" {{ request('id_jurusan') == $jur->id_jurusan ? 'selected' : '' }}>
                                {{ $jur->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Input -->
                <div class="filter-search-field" style="position: relative; flex: 1; min-width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" name="q" id="searchKelasGlobal" value="{{ request('q') }}" placeholder="Cari nama rombel kelas, wali kelas..." style="width: 100%; padding: 8px 32px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; box-sizing: border-box; font-family: inherit;">
                    @if(request('q'))
                        <button type="button" onclick="clearSearchKelasGlobal()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 12px;">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Action Buttons: Terapkan & Reset Filter -->
            <div class="filter-btn-group">
                <button type="submit" class="btn-filter-apply">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" title="Reset Semua Filter & Pencarian" class="btn-filter-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>

    <!-- 4. Table & Cards Rincian Siswa Per Rombel Kelas -->
    <div class="table-section-card">
        <div class="table-header-bar">
            <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-school" style="color: #384972;"></i> Data Rincian Siswa Per Rombel Kelas
                <span id="kelasCounterBadge" style="background: #e0e7ff; color: #3730a3; font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                    {{ count($kelasStats) }} Kelas
                </span>
            </h3>

            <!-- Quick Filter Pills & Live Table Search -->
            <div class="table-controls-wrap">
                <div class="pills-tingkat-wrap">
                    <button type="button" onclick="filterKelasTingkat('all')" class="tingkat-filter-btn active" data-tingkat="all">Semua</button>
                    <button type="button" onclick="filterKelasTingkat('X ')" class="tingkat-filter-btn" data-tingkat="X ">Kelas X</button>
                    <button type="button" onclick="filterKelasTingkat('XI ')" class="tingkat-filter-btn" data-tingkat="XI ">Kelas XI</button>
                    <button type="button" onclick="filterKelasTingkat('XII ')" class="tingkat-filter-btn" data-tingkat="XII ">Kelas XII</button>
                </div>

                <div class="live-search-box" style="position: relative; width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="liveSearchKelasTable" onkeyup="searchKelasTableRows()" placeholder="Cari di tabel kelas..." style="width: 100%; padding: 6px 28px 6px 28px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; color: #1e293b; background: #f8fafc; box-sizing: border-box; font-family: inherit;">
                    <button type="button" onclick="clearLiveSearchKelas()" id="btnResetLiveKelas" style="display: none; position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 11px;">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- A. TAMPILAN DESKTOP: TABEL STANDAR -->
        <div class="desktop-kelas-table-wrapper">
            <table id="tableKelas" class="custom-kehadiran-table">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; width: 50px; text-align: center;">No</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Rombel Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jurusan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Wali Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Jumlah Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Rincian Presensi</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Kehadiran (%)</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $idx = 1; @endphp
                    @forelse($kelasStats as $st)
                        @php
                            $progressBg = '#16a34a';
                            $pctBadgeBg = '#dcfce7';
                            $pctBadgeColor = '#166534';
                            if ($st['persentase'] < 80) {
                                $progressBg = '#dc2626';
                                $pctBadgeBg = '#fee2e2';
                                $pctBadgeColor = '#991b1b';
                            } elseif ($st['persentase'] < 90) {
                                $progressBg = '#d97706';
                                $pctBadgeBg = '#fef3c7';
                                $pctBadgeColor = '#92400e';
                            }

                            $jsonDetail = json_encode([
                                'id_kelas' => $st['id_kelas'],
                                'nama_kelas' => $st['nama_kelas'],
                                'jurusan' => $st['jurusan'],
                                'wali_kelas' => $st['wali_kelas'],
                                'nip_wali_kelas' => $st['nip_wali_kelas'],
                                'tanggal' => \Carbon\Carbon::parse($filterTanggal)->translatedFormat('l, d F Y'),
                                'tanggal_raw' => $filterTanggal,
                                'total_siswa' => $st['total_siswa'],
                                'hadir' => $st['hadir'],
                                'sakit' => $st['sakit'],
                                'izin' => $st['izin'],
                                'alpa' => $st['alpa'],
                                'dispen' => $st['dispen'],
                                'persentase' => $st['persentase'],
                                'siswas' => $st['siswas']
                            ]);
                        @endphp
                        <tr class="kelas-row" data-nama="{{ $st['nama_kelas'] }}" style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;">
                            <td class="row-num" style="padding: 14px 16px; color: #64748b; font-weight: 700; text-align: center;">{{ $idx++ }}</td>
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $st['nama_kelas'] }}</div>
                            </td>
                            <td style="padding: 14px 16px; color: #475569; font-weight: 600;">
                                {{ $st['jurusan'] }}
                            </td>
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 700; color: #1e293b;">{{ $st['wali_kelas'] }}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">NIP: {{ $st['nip_wali_kelas'] }}</div>
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <span style="background: #eef2ff; color: #384972; padding: 4px 12px; border-radius: 8px; font-weight: 800; font-size: 12.5px; border: 1px solid #c7d2fe; display: inline-block;">
                                    {{ $st['total_siswa'] }} Siswa
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; gap: 6px; flex-wrap: wrap; font-size: 11.5px; font-weight: 700;">
                                    <span style="background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px;" title="Hadir">H: {{ $st['hadir'] }}</span>
                                    <span style="background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 4px;" title="Sakit">S: {{ $st['sakit'] }}</span>
                                    <span style="background: #fef3c7; color: #92400e; padding: 2px 7px; border-radius: 4px;" title="Izin">I: {{ $st['izin'] }}</span>
                                    <span style="background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 4px;" title="Alpa">A: {{ $st['alpa'] }}</span>
                                    @if($st['dispen'] > 0)
                                        <span style="background: #e0e7ff; color: #3730a3; padding: 2px 7px; border-radius: 4px;" title="Dispensasi">D: {{ $st['dispen'] }}</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; min-width: 140px;">
                                    <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: {{ $progressBg }}; height: 100%; width: {{ $st['persentase'] }}%;"></div>
                                    </div>
                                    <span style="background: {{ $pctBadgeBg }}; color: {{ $pctBadgeColor }}; font-weight: 800; font-size: 12px; padding: 2px 8px; border-radius: 12px;">
                                        {{ $st['persentase'] }}%
                                    </span>
                                </div>
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <button type="button" onclick='showDetailPresensiKelas({!! $jsonDetail !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2); transition: all 0.2s; white-space: nowrap; font-family: inherit;">
                                    <i class="fa-solid fa-list-check"></i> Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-folder-open" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                Belum ada data rombel kelas terdaftar yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- B. TAMPILAN MOBILE: KARTU RESPONSIF (TIDAK BISA GESER KANAN-KIRI) -->
        <div class="mobile-kelas-cards-wrapper">
            @php $mIdx = 1; @endphp
            @forelse($kelasStats as $st)
                @php
                    $progressBg = '#16a34a';
                    $pctBadgeBg = '#dcfce7';
                    $pctBadgeColor = '#166534';
                    if ($st['persentase'] < 80) {
                        $progressBg = '#dc2626';
                        $pctBadgeBg = '#fee2e2';
                        $pctBadgeColor = '#991b1b';
                    } elseif ($st['persentase'] < 90) {
                        $progressBg = '#d97706';
                        $pctBadgeBg = '#fef3c7';
                        $pctBadgeColor = '#92400e';
                    }

                    $jsonDetail = json_encode([
                        'id_kelas' => $st['id_kelas'],
                        'nama_kelas' => $st['nama_kelas'],
                        'jurusan' => $st['jurusan'],
                        'wali_kelas' => $st['wali_kelas'],
                        'nip_wali_kelas' => $st['nip_wali_kelas'],
                        'tanggal' => \Carbon\Carbon::parse($filterTanggal)->translatedFormat('l, d F Y'),
                        'tanggal_raw' => $filterTanggal,
                        'total_siswa' => $st['total_siswa'],
                        'hadir' => $st['hadir'],
                        'sakit' => $st['sakit'],
                        'izin' => $st['izin'],
                        'alpa' => $st['alpa'],
                        'dispen' => $st['dispen'],
                        'persentase' => $st['persentase'],
                        'siswas' => $st['siswas']
                    ]);
                @endphp
                <div class="mobile-kelas-card kelas-row" data-nama="{{ $st['nama_kelas'] }}">
                    <!-- Card Top: No, Nama Kelas, Jumlah Siswa -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <span class="row-num-badge" style="background: #e2e8f0; color: #334155; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                #{{ $mIdx++ }}
                            </span>
                            <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
                                {{ $st['nama_kelas'] }}
                            </h4>
                        </div>
                        <span style="background: #eef2ff; color: #384972; padding: 3px 10px; border-radius: 8px; font-weight: 800; font-size: 11.5px; border: 1px solid #c7d2fe; white-space: nowrap;">
                            {{ $st['total_siswa'] }} Siswa
                        </span>
                    </div>

                    <!-- Jurusan -->
                    <div style="font-size: 12.5px; color: #475569; font-weight: 600; margin-top: 1px;">
                        <i class="fa-solid fa-graduation-cap" style="color: #384972; margin-right: 4px;"></i> {{ $st['jurusan'] }}
                    </div>
                    
                    <!-- Wali Kelas Box -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 9px 12px; margin-top: 4px;">
                        <div style="font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Wali Kelas</div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-top: 1px;">
                            {{ $st['wali_kelas'] }}
                        </div>
                        <div style="font-size: 11px; color: #64748b; font-weight: 500;">
                            NIP: {{ $st['nip_wali_kelas'] }}
                        </div>
                    </div>

                    <!-- Rincian Presensi Badges -->
                    <div style="display: flex; gap: 6px; flex-wrap: wrap; font-size: 11.5px; font-weight: 700; margin-top: 6px;">
                        <span style="background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 6px;" title="Hadir">H: {{ $st['hadir'] }}</span>
                        <span style="background: #fee2e2; color: #991b1b; padding: 3px 8px; border-radius: 6px;" title="Sakit">S: {{ $st['sakit'] }}</span>
                        <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px;" title="Izin">I: {{ $st['izin'] }}</span>
                        <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 6px;" title="Alpa">A: {{ $st['alpa'] }}</span>
                        @if($st['dispen'] > 0)
                            <span style="background: #e0e7ff; color: #3730a3; padding: 3px 8px; border-radius: 6px;" title="Dispensasi">D: {{ $st['dispen'] }}</span>
                        @endif
                    </div>

                    <!-- Kehadiran Progress Bar & Aksi Button -->
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 8px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                <span style="font-size: 11px; font-weight: 700; color: #64748b;">Kehadiran</span>
                                <span style="background: {{ $pctBadgeBg }}; color: {{ $pctBadgeColor }}; font-weight: 800; font-size: 11.5px; padding: 2px 7px; border-radius: 10px;">
                                    {{ $st['persentase'] }}%
                                </span>
                            </div>
                            <div style="background: #e2e8f0; height: 7px; border-radius: 4px; overflow: hidden;">
                                <div style="background: {{ $progressBg }}; height: 100%; width: {{ $st['persentase'] }}%;"></div>
                            </div>
                        </div>

                        <button type="button" onclick='showDetailPresensiKelas({!! $jsonDetail !!})' style="background: #384972; color: #ffffff; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2); transition: all 0.2s; white-space: nowrap; font-family: inherit;">
                            <i class="fa-solid fa-list-check"></i> Detail
                        </button>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; text-align: center; padding: 24px; color: #64748b; font-weight: 600;">
                    <i class="fa-solid fa-folder-open" style="font-size: 26px; color: #cbd5e1; display: block; margin-bottom: 6px;"></i>
                    Belum ada data rombel kelas terdaftar yang sesuai filter.
                </div>
            @endforelse
        </div>

    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL: DETAIL PRESENSI & DAFTAR SISWA ROMBEL KELAS                       -->
<!-- ========================================================================= -->
<div id="modalDetailKelasPresensi" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
    <div class="modal-container-responsive" style="background: #ffffff; width: 100%; max-width: 860px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; max-height: 92vh; box-sizing: border-box;">
        
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #1e293b, #384972); padding: 18px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; font-weight: 700;">
                    RINCIAN PRESENSI KELAS & DAFTAR SISWA
                </div>
                <h3 id="mdKelasTitle" style="margin: 4px 0 0 0; font-size: 17px; font-weight: 800; color: #ffffff; line-height: 1.3;">
                    Nama Rombel Kelas
                </h3>
            </div>
            <button onclick="closeModal('modalDetailKelasPresensi')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-left: 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body-responsive" style="padding: 22px; overflow-y: auto; display: flex; flex-direction: column; gap: 18px; font-size: 13.5px; box-sizing: border-box;">
            
            <!-- Meta Grid Info -->
            <div class="modal-meta-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; box-sizing: border-box;">
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Wali Kelas & Program Studi</div>
                    <div id="mdKelasWali" style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;">Wali: -</div>
                    <div id="mdKelasJurusan" style="font-size: 12px; color: #475569; font-weight: 600; margin-top: 2px;">Jurusan: -</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Persentase Kehadiran</div>
                    <div id="mdKelasPct" style="font-size: 24px; font-weight: 900; color: #16a34a; margin-top: 2px;">100%</div>
                </div>
            </div>

            <!-- Mini KPI Breakdown -->
            <div class="modal-kpi-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">TOTAL SISWA</div>
                    <div id="mdStatTotal" style="font-size: 17px; font-weight: 900; color: #384972; margin-top: 2px;">0</div>
                </div>
                <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 10.5px; color: #166534; font-weight: 700;">HADIR</div>
                    <div id="mdStatHadir" style="font-size: 17px; font-weight: 900; color: #166534; margin-top: 2px;">0</div>
                </div>
                <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 10px; padding: 10px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 10.5px; color: #991b1b; font-weight: 700;">SAKIT</div>
                    <div id="mdStatSakit" style="font-size: 17px; font-weight: 900; color: #991b1b; margin-top: 2px;">0</div>
                </div>
                <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; padding: 10px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 10.5px; color: #92400e; font-weight: 700;">IZIN</div>
                    <div id="mdStatIzin" style="font-size: 17px; font-weight: 900; color: #92400e; margin-top: 2px;">0</div>
                </div>
                <div style="background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; text-align: center; box-sizing: border-box;">
                    <div style="font-size: 10.5px; color: #475569; font-weight: 700;">ALPA</div>
                    <div id="mdStatAlpa" style="font-size: 17px; font-weight: 900; color: #475569; margin-top: 2px;">0</div>
                </div>
            </div>

            <!-- Student List Table Inside Modal with Filter Pills -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-sizing: border-box;">
                <div style="background: #f8fafc; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
                    <!-- Filter Status Buttons Inside Modal -->
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <button type="button" onclick="filterModalStatus('ALL')" class="md-status-btn active" data-st="ALL" style="border: none; background: #384972; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Semua (<span id="cntModalAll">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('HADIR')" class="md-status-btn" data-st="HADIR" style="border: none; background: #f1f5f9; color: #166534; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Hadir (<span id="cntModalHadir">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('SAKIT')" class="md-status-btn" data-st="SAKIT" style="border: none; background: #f1f5f9; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Sakit (<span id="cntModalSakit">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('IZIN')" class="md-status-btn" data-st="IZIN" style="border: none; background: #f1f5f9; color: #92400e; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Izin (<span id="cntModalIzin">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('ALPA')" class="md-status-btn" data-st="ALPA" style="border: none; background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Alpa (<span id="cntModalAlpa">0</span>)</button>
                    </div>

                    <input type="text" id="modalStudentSearch" onkeyup="filterModalStudentList()" placeholder="Cari nama / NISN..." style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 12px; width: 180px; font-family: inherit; box-sizing: border-box;">
                </div>

                <div style="max-height: 280px; overflow-y: auto; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table id="tableModalSiswa" style="width: 100%; min-width: 500px; border-collapse: collapse; text-align: left; font-size: 12.5px;">
                        <thead style="position: sticky; top: 0; background: #f1f5f9; border-bottom: 1px solid #cbd5e1; z-index: 2;">
                            <tr>
                                <th style="padding: 10px 14px; width: 40px; text-align: center;">No</th>
                                <th style="padding: 10px 14px; min-width: 140px;">Nama Siswa</th>
                                <th style="padding: 10px 14px; min-width: 100px;">NISN</th>
                                <th style="padding: 10px 14px; text-align: center; width: 50px;">L/P</th>
                                <th style="padding: 10px 14px; text-align: center; min-width: 80px;">Status</th>
                                <th style="padding: 10px 14px; min-width: 110px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="mdSiswaTableBody">
                            <!-- Populated via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer-responsive" style="background: #f8fafc; padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
            <button id="btnCetakKelasIni" type="button" onclick="printSingleClass()" style="background: #2563eb; color: #ffffff; border: none; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit;">
                <i class="fa-solid fa-print"></i> Cetak Presensi Kelas Ini
            </button>
            <button onclick="closeModal('modalDetailKelasPresensi')" style="background: #384972; color: #ffffff; border: none; padding: 9px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: CETAK REKAP PRESENSI KELAS                                         -->
<!-- ========================================================================= -->
<div id="modalCetakKehadiran" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
    <div style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden; box-sizing: border-box;">
        <div style="background: #384972; padding: 18px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-print"></i> Cetak Dokumen Rekap Presensi
            </h3>
            <button onclick="closeModal('modalCetakKehadiran')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px; font-size: 13.5px; display: flex; flex-direction: column; gap: 14px; box-sizing: border-box;">
            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Tanggal Presensi:</label>
                <input type="date" id="printTanggalKehadiran" value="{{ $filterTanggal }}" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; box-sizing: border-box; font-family: inherit;">
            </div>

            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Cakupan Cetak:</label>
                <select id="printKelasSelect" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; box-sizing: border-box; font-family: inherit;">
                    <option value="">Semua Rombel Kelas (Rekap Global)</option>
                    @foreach($kelasList as $kls)
                        <option value="{{ $kls->id_kelas }}">{{ $kls->nama_kelas }} (Wali: {{ $kls->waliKelas->nama_guru ?? ($kls->wali_kelas ?? '-') }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="closeModal('modalCetakKehadiran')" style="background: #e2e8f0; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;">
                Batal
            </button>
            <button onclick="executePrintKehadiran()" style="background: #384972; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit;">
                <i class="fa-solid fa-print"></i> Buka Lembar Cetak
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT INTERACTIONS                                                  -->
<!-- ========================================================================= -->
<script>
let currentModalClassData = null;
let currentModalFilterStatus = 'ALL';

function openModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'flex';
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'none';
}

// Close modals on backdrop click
window.addEventListener('click', function(e) {
    ['modalDetailKelasPresensi', 'modalCetakKehadiran'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Clear Global Search
function clearSearchKelasGlobal() {
    const input = document.getElementById('searchKelasGlobal');
    if (input) {
        input.value = '';
        document.getElementById('filterFormKehadiran').submit();
    }
}

// Show Detail Presensi Kelas Modal
function showDetailPresensiKelas(data) {
    currentModalClassData = data;
    currentModalFilterStatus = 'ALL';

    document.getElementById('mdKelasTitle').textContent = `${data.nama_kelas} — Presensi ${data.tanggal}`;
    document.getElementById('mdKelasWali').textContent = `Wali Kelas: ${data.wali_kelas} (NIP: ${data.nip_wali_kelas})`;
    document.getElementById('mdKelasJurusan').textContent = `Program Keahlian: ${data.jurusan}`;
    document.getElementById('mdKelasPct').textContent = `${data.persentase}%`;

    document.getElementById('mdStatTotal').textContent = data.total_siswa;
    document.getElementById('mdStatHadir').textContent = data.hadir;
    document.getElementById('mdStatSakit').textContent = data.sakit;
    document.getElementById('mdStatIzin').textContent = data.izin;
    document.getElementById('mdStatAlpa').textContent = data.alpa;

    // Badges inside modal
    document.getElementById('cntModalAll').textContent = data.total_siswa;
    document.getElementById('cntModalHadir').textContent = data.hadir;
    document.getElementById('cntModalSakit').textContent = data.sakit;
    document.getElementById('cntModalIzin').textContent = data.izin;
    document.getElementById('cntModalAlpa').textContent = data.alpa;

    // Reset status buttons style
    document.querySelectorAll('.md-status-btn').forEach(btn => {
        if (btn.getAttribute('data-st') === 'ALL') {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = '#f1f5f9';
            btn.style.color = '#475569';
        }
    });

    document.getElementById('modalStudentSearch').value = '';
    renderModalStudentRows();
    openModal('modalDetailKelasPresensi');
}

// Render student rows inside modal with live filter & dynamic numbering
function renderModalStudentRows() {
    const tbody = document.getElementById('mdSiswaTableBody');
    tbody.innerHTML = '';

    if (!currentModalClassData || !currentModalClassData.siswas || currentModalClassData.siswas.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                    Belum ada data siswa terdaftar di kelas ini.
                </td>
            </tr>
        `;
        return;
    }

    const searchTxt = document.getElementById('modalStudentSearch').value.toLowerCase();
    let rowIdx = 1;

    currentModalClassData.siswas.forEach((s) => {
        const matchStatus = (currentModalFilterStatus === 'ALL') || (s.status_kehadiran === currentModalFilterStatus);
        const matchSearch = s.nama_siswa.toLowerCase().includes(searchTxt) || s.nisn.toLowerCase().includes(searchTxt);

        if (matchStatus && matchSearch) {
            let badgeBg = '#dcfce7';
            let badgeColor = '#166534';
            if (s.status_kehadiran === 'SAKIT') {
                badgeBg = '#fee2e2';
                badgeColor = '#991b1b';
            } else if (s.status_kehadiran === 'IZIN') {
                badgeBg = '#fef3c7';
                badgeColor = '#92400e';
            } else if (s.status_kehadiran === 'ALPA') {
                badgeBg = '#f1f5f9';
                badgeColor = '#475569';
            } else if (s.status_kehadiran === 'DISPEN') {
                badgeBg = '#e0e7ff';
                badgeColor = '#3730a3';
            }

            const tr = document.createElement('tr');
            tr.className = 'md-siswa-row';
            tr.style.borderBottom = '1px solid #f1f5f9';
            tr.innerHTML = `
                <td style="padding: 8px 14px; text-align: center; color: #64748b; font-weight: 700;">${rowIdx++}</td>
                <td style="padding: 8px 14px; font-weight: 800; color: #0f172a;">${s.nama_siswa}</td>
                <td style="padding: 8px 14px; color: #64748b; font-size: 11.5px;">${s.nisn}</td>
                <td style="padding: 8px 14px; text-align: center; font-weight: 700; color: #475569;">${s.jenis_kelamin}</td>
                <td style="padding: 8px 14px; text-align: center;">
                    <span style="background: ${badgeBg}; color: ${badgeColor}; padding: 3px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                        ${s.status_kehadiran}
                    </span>
                </td>
                <td style="padding: 8px 14px; color: #475569; font-size: 11.5px;">${s.keterangan}</td>
            `;
            tbody.appendChild(tr);
        }
    });

    if (rowIdx === 1) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                    Tidak ada siswa yang sesuai dengan filter atau kata kunci pencarian.
                </td>
            </tr>
        `;
    }
}

// Filter status inside modal
function filterModalStatus(status) {
    currentModalFilterStatus = status;
    document.querySelectorAll('.md-status-btn').forEach(btn => {
        if (btn.getAttribute('data-st') === status) {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = '#f1f5f9';
            btn.style.color = '#475569';
        }
    });
    renderModalStudentRows();
}

// Search student inside modal
function filterModalStudentList() {
    renderModalStudentRows();
}

// Print single class from modal
function printSingleClass() {
    if (!currentModalClassData) return;
    const url = `{{ route('kepala-sekolah.kehadiran-siswa') }}?print=true&tanggal=${currentModalClassData.tanggal_raw}&id_kelas=${currentModalClassData.id_kelas}`;
    window.open(url, '_blank');
}

// Open Global Cetak Modal
function openModalCetakKehadiran() {
    openModal('modalCetakKehadiran');
}

// Execute Print from modal
function executePrintKehadiran() {
    const tgl = document.getElementById('printTanggalKehadiran').value;
    const idKelas = document.getElementById('printKelasSelect').value;
    let url = `{{ route('kepala-sekolah.kehadiran-siswa') }}?print=true&tanggal=${tgl}`;
    if (idKelas) {
        url += `&id_kelas=${idKelas}`;
    }
    window.open(url, '_blank');
    closeModal('modalCetakKehadiran');
}

// Filter kelas tingkat pills with dynamic numbering & counter badge
function filterKelasTingkat(tingkat) {
    document.querySelectorAll('.tingkat-filter-btn').forEach(btn => {
        if (btn.getAttribute('data-tingkat') === tingkat) {
            btn.classList.add('active');
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.classList.remove('active');
            btn.style.background = 'transparent';
            btn.style.color = '#64748b';
        }
    });

    let visibleCount = 0;
    const desktopRows = document.querySelectorAll('#tableKelas .kelas-row');
    desktopRows.forEach(r => {
        const namaKelas = r.getAttribute('data-nama');
        const numCell = r.querySelector('.row-num');
        if (tingkat === 'all' || namaKelas.startsWith(tingkat)) {
            r.style.display = '';
            visibleCount++;
            if (numCell) numCell.textContent = visibleCount;
        } else {
            r.style.display = 'none';
        }
    });

    let mobileVisibleCount = 0;
    const mobileCards = document.querySelectorAll('.mobile-kelas-cards-wrapper .kelas-row');
    mobileCards.forEach(c => {
        const namaKelas = c.getAttribute('data-nama');
        const numBadge = c.querySelector('.row-num-badge');
        if (tingkat === 'all' || namaKelas.startsWith(tingkat)) {
            c.style.display = 'flex';
            mobileVisibleCount++;
            if (numBadge) numBadge.textContent = `#${mobileVisibleCount}`;
        } else {
            c.style.display = 'none';
        }
    });

    const badge = document.getElementById('kelasCounterBadge');
    if (badge) {
        badge.textContent = `${visibleCount || mobileVisibleCount} Kelas`;
    }
}

// Live search in kelas table with dynamic numbering
function searchKelasTableRows() {
    const input = document.getElementById('liveSearchKelasTable').value.toLowerCase();
    const btnReset = document.getElementById('btnResetLiveKelas');
    if (btnReset) {
        btnReset.style.display = input.length > 0 ? 'block' : 'none';
    }

    let visibleCount = 0;
    const desktopRows = document.querySelectorAll('#tableKelas .kelas-row');
    desktopRows.forEach(r => {
        const text = r.textContent.toLowerCase();
        const numCell = r.querySelector('.row-num');
        if (text.includes(input)) {
            r.style.display = '';
            visibleCount++;
            if (numCell) numCell.textContent = visibleCount;
        } else {
            r.style.display = 'none';
        }
    });

    let mobileVisibleCount = 0;
    const mobileCards = document.querySelectorAll('.mobile-kelas-cards-wrapper .kelas-row');
    mobileCards.forEach(c => {
        const text = c.textContent.toLowerCase();
        const numBadge = c.querySelector('.row-num-badge');
        if (text.includes(input)) {
            c.style.display = 'flex';
            mobileVisibleCount++;
            if (numBadge) numBadge.textContent = `#${mobileVisibleCount}`;
        } else {
            c.style.display = 'none';
        }
    });

    const badge = document.getElementById('kelasCounterBadge');
    if (badge) {
        badge.textContent = `${visibleCount || mobileVisibleCount} Kelas`;
    }
}

function clearLiveSearchKelas() {
    const input = document.getElementById('liveSearchKelasTable');
    input.value = '';
    searchKelasTableRows();
}
</script>
@endsection