@extends('layouts.waka')

@section('title', 'Kelola & Monitor Jadwal Pelajaran — Waka Portal')

@section('styles')
<style>
    .jadwal-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-emerald {
        background: #059669;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25);
    }
    .btn-emerald:hover {
        background: #047857;
        transform: translateY(-1px);
    }

    .btn-indigo {
        background: #4f46e5;
        color: #ffffff;
    }
    .btn-indigo:hover {
        background: #4338ca;
    }

    .btn-outline {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-trash {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .btn-trash:hover {
        background: #fecaca;
    }

    /* 4 Stat Cards Row */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        width: 100%;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 0;
    }

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue   { background: #eff6ff; color: #2563eb; }
    .icon-emerald{ background: #ecfdf5; color: #059669; }
    .icon-purple { background: #f5f3ff; color: #7c3aed; }
    .icon-amber  { background: #fffbeb; color: #d97706; }

    .stat-info-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-count {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* View Mode Switcher */
    .view-switcher-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f1f5f9;
        padding: 5px;
        border-radius: 12px;
        gap: 6px;
        flex-wrap: wrap;
    }

    .view-pills {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    .view-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        color: #475569;
        transition: all 0.2s ease;
    }

    .view-pill-btn:hover {
        color: #0f172a;
        background: rgba(255,255,255,0.6);
    }

    .view-pill-btn.active {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    /* Filter Panel */
    .filter-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filter-form-grid {
        display: grid;
        grid-template-columns: 2fr repeat(4, 1.2fr) auto auto;
        gap: 10px;
        align-items: center;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        font-family: inherit;
        background: #f8fafc;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
    }

    .filter-input:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .filter-select {
        width: 100%;
        padding: 9px 10px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        font-family: inherit;
        background: #f8fafc;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .btn-filter-submit {
        background: #1e293b;
        color: #ffffff;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-filter-reset {
        background: #f1f5f9;
        color: #64748b;
        padding: 9px 12px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Main Table Container */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-action-bar {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .table-scroll-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 850px;
    }

    .jadwal-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .jadwal-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .jadwal-table tr:hover td {
        background: #f8fafc;
    }

    .day-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
    }
    .day-Senin   { background: #eff6ff; color: #1d4ed8; }
    .day-Selasa  { background: #fdf2f8; color: #be185d; }
    .day-Rabu    { background: #f0fdf4; color: #15803d; }
    .day-Kamis   { background: #fefce8; color: #a16207; }
    .day-Jumat   { background: #faf5ff; color: #7e22ce; }
    .day-Sabtu   { background: #fff7ed; color: #c2410c; }

    .period-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 8px;
        background: #f1f5f9;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        color: #334155;
    }

    .class-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        font-weight: 800;
        font-size: 12.5px;
    }

    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 11.5px;
        font-weight: 600;
    }

    /* Actions buttons in table */
    .btn-row-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-row-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-row-action.edit-btn:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #2563eb;
    }

    .btn-row-action.delete-btn:hover {
        background: #fef2f2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* Matrix View Styles */
    .matrix-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .matrix-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .matrix-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        min-width: 900px;
    }

    .matrix-table th {
        background: #1e293b;
        color: #ffffff;
        padding: 10px 12px;
        text-align: center;
        font-weight: 700;
        border: 1px solid #334155;
    }

    .matrix-table td {
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
        vertical-align: top;
        font-size: 12px;
    }

    .matrix-cell-empty {
        background: #fafafa;
        color: #cbd5e1;
        text-align: center;
        font-style: italic;
        padding: 12px 6px;
    }

    .matrix-cell-filled {
        background: #f8fafc;
        border-radius: 6px;
        padding: 8px;
        border-left: 3px solid #2563eb;
    }

    .matrix-cell-break {
        background: #fef3c7;
        color: #92400e;
        text-align: center;
        font-weight: 800;
        font-size: 11.5px;
        padding: 6px;
    }

    /* Modals */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 16px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    }

    .modal-box.modal-lg {
        max-width: 800px;
    }

    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
    }
    .modal-close-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .modal-body {
        padding: 20px 22px;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    .form-group-modal {
        margin-bottom: 14px;
    }

    .form-group-modal label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }

    .modal-input, .modal-select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        font-size: 13px;
        font-family: inherit;
        background: #ffffff;
        color: #1e293b;
        box-sizing: border-box;
    }

    .modal-input:focus, .modal-select:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .kbm-ref-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 10px;
    }

    .kbm-ref-table th {
        background: #f1f5f9;
        padding: 8px 10px;
        text-align: left;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-weight: 700;
    }

    .kbm-ref-table td {
        padding: 7px 10px;
        border: 1px solid #e2e8f0;
    }

    .conflict-alert {
        display: none;
        padding: 10px 14px;
        background: #fee2e2;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        color: #991b1b;
        font-size: 12px;
        margin-bottom: 14px;
    }

    @media (max-width: 1024px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .filter-form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 640px) {
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
        .filter-form-grid {
            grid-template-columns: 1fr;
        }
        .header-actions {
            width: 100%;
        }
        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="jadwal-container">

    {{-- Breadcrumb & Page Header --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; <span style="color: #2563eb;">Master Jadwal Pelajaran</span>
            </div>
            <h1 class="page-main-title">Kelola &amp; Monitor Jadwal Pelajaran</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Sinkronisasi Kurikulum &amp; Alokasi KBM Semester Ganjil 2026/2027</p>
        </div>

        <div class="header-actions">
            <button type="button" class="btn-action btn-indigo" onclick="openKbmModal()">
                <i class="fa-solid fa-clock"></i> Alokasi KBM
            </button>
            <button type="button" class="btn-action btn-outline" onclick="openCetakModal()">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
            <a href="{{ route('waka.jadwal.export', request()->all()) }}" class="btn-action btn-outline">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- 4 Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Jadwal Aktif</span>
                <span class="stat-count">{{ number_format($stats['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Kelas Terjadwal</span>
                <span class="stat-count">{{ $stats['kelas_terjadwal'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Kelas</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Guru Mengajar</span>
                <span class="stat-count">{{ $stats['guru_mengajar'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Guru</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Ruangan Digunakan</span>
                <span class="stat-count">{{ $stats['ruangan_digunakan'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Ruang</span></span>
            </div>
        </div>
    </div>

    {{-- View Mode Switcher --}}
    <div class="view-switcher-bar">
        <div class="view-pills">
            <a href="{{ route('waka.jadwal', array_merge(request()->except(['view_mode']), ['view_mode' => 'table'])) }}" 
               class="view-pill-btn {{ $viewMode === 'table' ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Daftar Tabel (Master)
            </a>
            <a href="{{ route('waka.jadwal', array_merge(request()->except(['view_mode']), ['view_mode' => 'matriks_kelas'])) }}" 
               class="view-pill-btn {{ $viewMode === 'matriks_kelas' ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells"></i> Matriks Jadwal Per Kelas (Format PDF)
            </a>
            <a href="{{ route('waka.jadwal', array_merge(request()->except(['view_mode']), ['view_mode' => 'matriks_guru'])) }}" 
               class="view-pill-btn {{ $viewMode === 'matriks_guru' ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie"></i> Matriks Jadwal Per Guru
            </a>
        </div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; padding: 0 10px;">
            Mode Tampilan: <span style="color: #0f172a; font-weight: 800;">{{ $viewMode === 'matriks_kelas' ? 'Matriks Kelas' : ($viewMode === 'matriks_guru' ? 'Matriks Guru' : 'Tabel Master') }}</span>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-panel">
        <form method="GET" action="{{ route('waka.jadwal') }}" class="filter-form-grid" id="filterForm">
            <input type="hidden" name="view_mode" value="{{ $viewMode }}">
            
            <div class="search-input-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari mapel, guru, kode, ruang..." class="filter-input">
            </div>

            <select name="hari" class="filter-select">
                <option value="">-- Semua Hari --</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                    <option value="{{ $h }}" {{ $hariFilter === $h ? 'selected' : '' }}>Hari {{ $h }}</option>
                @endforeach
            </select>

            <select name="tingkat" class="filter-select">
                <option value="">-- Semua Tingkat --</option>
                @foreach(['X', 'XI', 'XII'] as $t)
                    <option value="{{ $t }}" {{ $tingkatFilter === $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
                @endforeach
            </select>

            <select name="id_kelas" class="filter-select">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $kelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <select name="id_guru" class="filter-select">
                <option value="">-- Semua Guru --</option>
                @foreach($guruList as $g)
                    <option value="{{ $g->id_guru }}" {{ $guruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter-submit">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>

            <a href="{{ route('waka.jadwal', ['view_mode' => $viewMode]) }}" class="btn-filter-reset" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </form>
    </div>

    {{-- VIEW 1: DAFTAR TABEL --}}
    @if($viewMode === 'table')
    <div class="table-card">
        <div class="table-action-bar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 13px; font-weight: 700; color: #1e293b;">
                    <i class="fa-solid fa-list-check" style="color: #2563eb; margin-right: 4px;"></i> Master Data Jadwal Pelajaran
                </span>
            </div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                Menampilkan <span style="color: #0f172a; font-weight: 800;">{{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }}</span> dari <span style="color: #0f172a; font-weight: 800;">{{ $jadwals->total() }}</span> jadwal
            </div>
        </div>

        <div class="table-scroll-wrapper">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Hari</th>
                        <th>Jam Pelajaran</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Ruangan</th>
                        <th style="text-align: center; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 12px;">
                                {{ $jadwals->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <span class="day-badge day-{{ $j->hari }}">
                                    <i class="fa-regular fa-calendar"></i> {{ $j->hari }}
                                </span>
                            </td>
                            <td>
                                <div class="period-badge">
                                    <i class="fa-regular fa-clock"></i>
                                    Jam ke-{{ $j->jam_mulai_ke }} - {{ $j->jam_selesai_ke }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 3px; font-weight: 600;">
                                    {{ substr($j->waktu_mulai_effective, 0, 5) }} - {{ substr($j->waktu_selesai_effective, 0, 5) }} WIB
                                </div>
                            </td>
                            <td>
                                <span class="class-chip">
                                    <i class="fa-solid fa-graduation-cap"></i> {{ $j->kelas->nama_kelas ?? 'Kelas -' }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">
                                    {{ $j->mapel->nama_mapel ?? 'Mapel -' }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    Kode: {{ $j->mapel->kode_mapel ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    {{ $j->guru->nama_guru ?? 'Guru -' }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    NIP: {{ $j->guru->nip ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="room-badge">
                                    <i class="fa-solid fa-door-open"></i> {{ $j->ruangan->nama_ruangan ?? ($j->kelas->nama_kelas ?? 'Ruang Kelas') }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <button type="button" class="btn-row-action" title="Detail Jadwal" 
                                            onclick='openDetailModal(@json($j))'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px 20px;">
                                <div style="color: #94a3b8; font-size: 32px; margin-bottom: 10px;">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                </div>
                                <div style="font-size: 15px; font-weight: 800; color: #475569;">Tidak ada data jadwal ditemukan</div>
                                <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Coba ubah kata kunci pencarian atau reset filter.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; background: #ffffff;">
            {{ $jadwals->links('partials.custom-pagination') }}
        </div>
    </div>
    @endif

    {{-- VIEW 2: MATRIKS KELAS (FORMAT PDF) --}}
    @if($viewMode === 'matriks_kelas')
    <div class="matrix-card">
        <div class="matrix-header-box">
            <div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chalkboard"></i>
                    Matriks Jadwal Mingguan: <span style="color: #2563eb;">{{ $selectedKelasObj->nama_kelas ?? 'Pilih Kelas' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    Format alokasi waktu &amp; jam KBM disesuaikan dengan kurikulum resmi SMKN 1 Boyolangu
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <form method="GET" action="{{ route('waka.jadwal') }}" style="display: flex; gap: 8px; align-items: center;">
                    <input type="hidden" name="view_mode" value="matriks_kelas">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Pilih Kelas:</label>
                    <select name="selected_kelas" class="filter-select" onchange="this.form.submit()" style="width: auto; min-width: 160px;">
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ ($selectedKelas == $k->id_kelas) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tingkat }})
                            </option>
                        @endforeach
                    </select>
                </form>

                @if($selectedKelas)
                <a href="{{ route('waka.jadwal.print-kelas', $selectedKelas) }}" target="_blank" class="btn-action btn-outline" style="padding: 7px 12px; font-size: 12px;">
                    <i class="fa-solid fa-print"></i> Cetak Jadwal Kelas Ini
                </a>
                @endif
            </div>
        </div>

        <div class="table-scroll-wrapper">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Jam</th>
                        <th style="width: 100px;">Waktu (Senin-Kamis)</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th style="width: 100px;">Waktu (Jumat)</th>
                        <th>Jumat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $timesSeninKamis = [
                            1 => '07:00 - 07:40',
                            2 => '07:40 - 08:20',
                            3 => '08:20 - 09:00',
                            4 => '09:00 - 09:40',
                            5 => '10:00 - 10:35',
                            6 => '10:35 - 11:10',
                            7 => '11:10 - 11:45',
                            8 => '13:15 - 13:50',
                            9 => '13:50 - 14:25',
                            10 => '14:25 - 15:00',
                        ];

                        $timesJumat = [
                            1 => '07:00 - 07:30',
                            2 => '07:30 - 08:00',
                            3 => '08:00 - 08:30',
                            4 => '08:30 - 09:00',
                            5 => '09:00 - 09:30',
                            6 => '09:50 - 10:20',
                            7 => '10:20 - 10:50',
                            8 => '10:50 - 11:20',
                            9 => '13:00 - 13:30',
                            10 => '13:30 - 14:00',
                            11 => '14:00 - 14:30',
                            12 => '14:30 - 15:00',
                            13 => '15:00 - 15:35',
                        ];
                    @endphp

                    @for($jam = 1; $jam <= $maxJamKelas; $jam++)
                        {{-- Istirahat 1 Notification --}}
                        @if($jam === 5)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-mug-hot"></i> ISTIRAHAT 1 (Senin–Kamis: 09:40 - 10:00 WIB)
                                </td>
                            </tr>
                        @endif

                        {{-- Istirahat 2 Notification --}}
                        @if($jam === 8)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-utensils"></i> ISTIRAHAT 2 / ISHOMA (Senin–Kamis: 11:45 - 13:15 WIB)
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td style="text-align: center; font-weight: 800; background: #f8fafc;">{{ $jam }}</td>
                            <td style="text-align: center; font-weight: 600; color: #475569; background: #f8fafc; font-size: 11.5px;">
                                {{ $timesSeninKamis[$jam] ?? '-' }}
                            </td>

                            {{-- Senin, Selasa, Rabu, Kamis --}}
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis'] as $day)
                                @php
                                    $cell = $matriksKelasData[$day][$jam] ?? null;
                                @endphp
                                @if($cell)
                                    <td class="matrix-cell-filled">
                                        <div style="font-weight: 800; color: #1e3a8a; font-size: 12.5px;">
                                            {{ $cell->mapel->nama_mapel ?? 'Mapel' }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #334155; font-weight: 600; margin-top: 2px;">
                                            <i class="fa-solid fa-chalkboard-user"></i> {{ $cell->guru->nama_guru ?? '-' }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <i class="fa-solid fa-door-open"></i> {{ $cell->ruangan->nama_ruangan ?? 'R. Kelas' }}
                                        </div>
                                    </td>
                                @else
                                    <td class="matrix-cell-empty">-</td>
                                @endif
                            @endforeach

                            {{-- Waktu Jumat --}}
                            <td style="text-align: center; font-weight: 600; color: #475569; background: #f8fafc; font-size: 11.5px;">
                                {{ $timesJumat[$jam] ?? '-' }}
                            </td>

                            {{-- Kolom Jumat --}}
                            @php
                                $cellJumat = $matriksKelasData['Jumat'][$jam] ?? null;
                            @endphp
                            @if($jam === 1 && !$cellJumat)
                                <td class="matrix-cell-filled" style="border-left-color: #059669;">
                                    <div style="font-weight: 800; color: #065f46; font-size: 12px;">
                                        <i class="fa-solid fa-mosque"></i> Pembiasaan Hari Jumat
                                    </div>
                                    <div style="font-size: 11px; color: #047857;">(Sholat Dhuha / Literasi)</div>
                                </td>
                            @elseif($cellJumat)
                                <td class="matrix-cell-filled" style="border-left-color: #7c3aed;">
                                    <div style="font-weight: 800; color: #581c87; font-size: 12.5px;">
                                        {{ $cellJumat->mapel->nama_mapel ?? 'Mapel' }}
                                    </div>
                                    <div style="font-size: 11.5px; color: #334155; font-weight: 600; margin-top: 2px;">
                                        <i class="fa-solid fa-chalkboard-user"></i> {{ $cellJumat->guru->nama_guru ?? '-' }}
                                    </div>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        <i class="fa-solid fa-door-open"></i> {{ $cellJumat->ruangan->nama_ruangan ?? 'R. Kelas' }}
                                    </div>
                                </td>
                            @else
                                <td class="matrix-cell-empty">-</td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- VIEW 3: MATRIKS GURU --}}
    @if($viewMode === 'matriks_guru')
    <div class="matrix-card">
        <div class="matrix-header-box">
            <div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-user-tie"></i>
                    Matriks Jadwal Mengajar Guru: <span style="color: #2563eb;">{{ $selectedGuruObj->nama_guru ?? 'Pilih Guru' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    NIP: {{ $selectedGuruObj->nip ?? '-' }} | Beban Mengajar &amp; Ruang KBM Terjadwal
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <form method="GET" action="{{ route('waka.jadwal') }}" style="display: flex; gap: 8px; align-items: center;">
                    <input type="hidden" name="view_mode" value="matriks_guru">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Pilih Guru:</label>
                    <select name="selected_guru" class="filter-select" onchange="this.form.submit()" style="width: auto; min-width: 200px;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($selectedGuru == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="table-scroll-wrapper">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Jam</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                    </tr>
                </thead>
                <tbody>
                    @for($jam = 1; $jam <= $maxJamGuru; $jam++)
                        <tr>
                            <td style="text-align: center; font-weight: 800; background: #f8fafc;">Jam ke-{{ $jam }}</td>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                                @php
                                    $cell = $matriksGuruData[$day][$jam] ?? null;
                                @endphp
                                @if($cell)
                                    <td class="matrix-cell-filled" style="border-left-color: #059669;">
                                        <div style="font-weight: 800; color: #065f46; font-size: 12.5px;">
                                            <i class="fa-solid fa-graduation-cap"></i> {{ $cell->kelas->nama_kelas ?? 'Kelas' }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #1e293b; font-weight: 700; margin-top: 2px;">
                                            {{ $cell->mapel->nama_mapel ?? 'Mapel' }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <i class="fa-solid fa-door-open"></i> {{ $cell->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                                        </div>
                                    </td>
                                @else
                                    <td class="matrix-cell-empty">-</td>
                                @endif
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

{{-- MODAL DETAIL JADWAL --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Jadwal Pelajaran</h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b; width: 35%;">Hari</td>
                    <td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_hari">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;">Jam Pelajaran</td>
                    <td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_jam">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;">Kelas Target</td>
                    <td style="padding: 10px; font-weight: 800; color: #2563eb;" id="det_kelas">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;">Mata Pelajaran</td>
                    <td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_mapel">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;">Guru Pengajar</td>
                    <td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_guru">-</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px; font-weight: 700; color: #64748b;">Ruangan Belajar</td>
                    <td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_ruangan">-</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL ALOKASI JAM KBM RESMI --}}
<div class="modal-overlay" id="modalKbm">
    <div class="modal-box modal-lg">
        <div class="modal-header">
            <h3><i class="fa-solid fa-clock" style="color: #4f46e5;"></i> Struktur Alokasi Waktu Jam KBM SMKN 1 Boyolangu</h3>
            <button type="button" class="modal-close-btn" onclick="closeKbmModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="font-size: 13px; color: #475569; margin-bottom: 14px;">
                Berdasarkan pedoman kurikulum KBM Semester Ganjil 2026/2027:
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0;">
                        <i class="fa-solid fa-calendar-week" style="color: #2563eb;"></i> Senin – Kamis (10 Jam Pelajaran)
                    </h4>
                    <table class="kbm-ref-table">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Alokasi Waktu</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>07.00 - 07.40</td><td>Upacara / Apel (Senin)</td></tr>
                            <tr><td>2</td><td>07.40 - 08.20</td><td>KBM</td></tr>
                            <tr><td>3</td><td>08.20 - 09.00</td><td>KBM</td></tr>
                            <tr><td>4</td><td>09.00 - 09.40</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>09.40 - 10.00</td><td>Istirahat 1 (20 Menit)</td></tr>
                            <tr><td>5</td><td>10.00 - 10.35</td><td>KBM</td></tr>
                            <tr><td>6</td><td>10.35 - 11.10</td><td>KBM</td></tr>
                            <tr><td>7</td><td>11.10 - 11.45</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>11.45 - 13.15</td><td>Istirahat 2 / ISHOMA</td></tr>
                            <tr><td>8</td><td>13.15 - 13.50</td><td>KBM</td></tr>
                            <tr><td>9</td><td>13.50 - 14.25</td><td>KBM</td></tr>
                            <tr><td>10</td><td>14.25 - 15.00</td><td>KBM / Pulang</td></tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0;">
                        <i class="fa-solid fa-mosque" style="color: #059669;"></i> Jumat (13 Jam Pelajaran)
                    </h4>
                    <table class="kbm-ref-table">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Alokasi Waktu</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>07.00 - 07.30</td><td>Pembiasaan Jumat</td></tr>
                            <tr><td>2</td><td>07.30 - 08.00</td><td>KBM</td></tr>
                            <tr><td>3</td><td>08.00 - 08.30</td><td>KBM</td></tr>
                            <tr><td>4</td><td>08.30 - 09.00</td><td>KBM</td></tr>
                            <tr><td>5</td><td>09.00 - 09.30</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>09.30 - 09.50</td><td>Istirahat 1 (20 Menit)</td></tr>
                            <tr><td>6</td><td>09.50 - 10.20</td><td>KBM</td></tr>
                            <tr><td>7</td><td>10.20 - 10.50</td><td>KBM</td></tr>
                            <tr><td>8</td><td>10.50 - 11.20</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>11.20 - 13.00</td><td>Sholat Jumat &amp; Ishoma</td></tr>
                            <tr><td>9</td><td>13.00 - 13.30</td><td>KBM</td></tr>
                            <tr><td>10</td><td>13.30 - 14.00</td><td>KBM</td></tr>
                            <tr><td>11</td><td>14.00 - 14.30</td><td>KBM</td></tr>
                            <tr><td>12</td><td>14.30 - 15.00</td><td>KBM</td></tr>
                            <tr><td>13</td><td>15.00 - 15.35</td><td>KBM / Pulang</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeKbmModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL CETAK --}}
<div class="modal-overlay" id="modalCetak">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-print" style="color: #0f172a;"></i> Pilihan Cetak Jadwal Pelajaran</h3>
            <button type="button" class="modal-close-btn" onclick="closeCetakModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('waka.jadwal.print', request()->all()) }}" target="_blank" class="btn-action btn-primary" style="padding: 12px; justify-content: center; text-decoration: none;">
                    <i class="fa-solid fa-table-list"></i> Cetak Master Jadwal (Sesuai Filter Aktif)
                </a>

                <div style="border-top: 1px solid #e2e8f0; padding-top: 12px;">
                    <label style="font-size: 13px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Cetak Matriks Jadwal Per Kelas:</label>
                    <div style="display: flex; gap: 8px;">
                        <select id="cetakKelasSelect" class="modal-select">
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-action btn-emerald" onclick="cetakPerKelas()" style="white-space: nowrap;">
                            <i class="fa-solid fa-print"></i> Cetak Kelas
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeCetakModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openDetailModal(jadwal) {
        document.getElementById('det_hari').textContent = 'Hari ' + (jadwal.hari || '-');
        document.getElementById('det_jam').textContent = 'Jam ke-' + (jadwal.jam_mulai_ke || '-') + ' s/d ' + (jadwal.jam_selesai_ke || '-') + ' (' + (jadwal.waktu_mulai_effective || '') + ' - ' + (jadwal.waktu_selesai_effective || '') + ' WIB)';
        document.getElementById('det_kelas').textContent = (jadwal.kelas ? jadwal.kelas.nama_kelas : '-');
        document.getElementById('det_mapel').textContent = (jadwal.mapel ? (jadwal.mapel.nama_mapel + ' (' + (jadwal.mapel.kode_mapel || '-') + ')') : '-');
        document.getElementById('det_guru').textContent = (jadwal.guru ? (jadwal.guru.nama_guru + ' (NIP: ' + (jadwal.guru.nip || '-') + ')') : '-');
        document.getElementById('det_ruangan').textContent = (jadwal.ruangan ? jadwal.ruangan.nama_ruangan : (jadwal.kelas ? jadwal.kelas.nama_kelas : 'Ruang Kelas'));
        document.getElementById('modalDetail').style.display = 'flex';
    }
    function closeDetailModal() { 
        document.getElementById('modalDetail').style.display = 'none'; 
    }

    function openKbmModal() { 
        document.getElementById('modalKbm').style.display = 'flex'; 
    }
    function closeKbmModal() { 
        document.getElementById('modalKbm').style.display = 'none'; 
    }

    function openCetakModal() { 
        document.getElementById('modalCetak').style.display = 'flex'; 
    }
    function closeCetakModal() { 
        document.getElementById('modalCetak').style.display = 'none'; 
    }

    function cetakPerKelas() {
        const idKelas = document.getElementById('cetakKelasSelect').value;
        if (idKelas) {
            window.open('/waka/jadwal/print-kelas/' + idKelas, '_blank');
        }
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection