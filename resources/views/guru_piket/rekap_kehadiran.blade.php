@extends('layouts.guru')

@section('title', 'Rekap Kehadiran Guru — Guru Piket')
@section('header_title', 'Rekap Kehadiran')

@section('styles')
<style>
    /* ─── Global Scoped Styles untuk Rekap Kehadiran ─── */
    .rekap-page-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    /* ─── 1. Top 4 Stat Cards (Tanpa Chevron & Tanpa Persentase Palsu) ─── */
    .rekap-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 1024px) {
        .rekap-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .rekap-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .rekap-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .rekap-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }

    /* Gradient subtle tint di bagian bawah kartu */
    .rekap-stat-card.blue {
        background: linear-gradient(180deg, #ffffff 0%, #f0f7ff 100%);
    }
    .rekap-stat-card.orange {
        background: linear-gradient(180deg, #ffffff 0%, #fffbf0 100%);
    }
    .rekap-stat-card.red {
        background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
    }
    .rekap-stat-card.purple {
        background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);
    }

    .rekap-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .rekap-stat-icon.blue   { background: #dbeafe; color: #2563eb; }
    .rekap-stat-icon.orange { background: #ffedd5; color: #ea580c; }
    .rekap-stat-icon.red    { background: #fee2e2; color: #dc2626; }
    .rekap-stat-icon.purple { background: #ede9fe; color: #7c3aed; }

    .rekap-stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .rekap-stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: -0.01em;
    }

    .rekap-stat-number-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin: 3px 0 2px 0;
    }

    .rekap-stat-number {
        font-size: 26px;
        font-weight: 850;
        color: #1e293b;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .rekap-stat-unit {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
    }

    .rekap-stat-sub {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* ─── 2. Card Universal & Header ─── */
    .rekap-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .rekap-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rekap-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 850;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .rekap-card-title i {
        color: #2b3957;
        font-size: 18px;
    }

    .rekap-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-rekap-export {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 750;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-rekap-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .btn-rekap-cetak {
        background: #2b3957;
        border: 1px solid #2b3957;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 750;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-rekap-cetak:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* ─── 3. Filter Bar (2 Baris Rapi) ─── */
    .rekap-filter-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .rekap-filter-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rekap-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .rekap-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        font-size: 13.5px;
        pointer-events: none;
    }

    .rekap-filter-input {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 38px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        height: 42px;
        width: 100%;
    }

    .rekap-filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .rekap-filter-select {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 9px 14px 9px 38px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        height: 42px;
        min-width: 180px;
    }

    .rekap-filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-rekap-filter {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 9px 22px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        transition: background 0.2s ease, transform 0.1s ease;
    }

    .btn-rekap-filter:hover {
        background: #1d4ed8;
    }

    .btn-rekap-reset {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        height: 42px;
        transition: all 0.2s ease;
    }

    .btn-rekap-reset:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* ─── 4. Table Styling ─── */
    .rekap-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
    }

    .rekap-custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .rekap-custom-table thead tr {
        background: #f8fafc;
    }

    .rekap-custom-table th {
        padding: 14px 16px;
        font-weight: 750;
        color: #475569;
        font-size: 12px;
        letter-spacing: 0.02em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .rekap-custom-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
        font-weight: 600;
    }

    .rekap-custom-table tr:hover td {
        background: #f8fafc;
    }

    .rekap-custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Guru Avatar Inisial */
    .guru-cell-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .guru-avatar-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 850;
        flex-shrink: 0;
        letter-spacing: -0.02em;
    }

    .guru-nama-text {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Status Badges */
    .status-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-badge-pill i {
        font-size: 11.5px;
    }

    .badge-hadir {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-tidak-hadir {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-izin {
        background: #fef3c7;
        color: #b45309;
    }

    .badge-digantikan {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* Tombol Aksi Titik Tiga */
    .btn-action-dots {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-dots:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    /* ─── 5. Table Footer & Pagination ─── */
    .rekap-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rekap-pagination-info {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
    }

    .rekap-pagination-list {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rekap-page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 750;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .rekap-page-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .rekap-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* ─── 6. Bottom Alert Banner ─── */
    .rekap-bottom-banner {
        background: linear-gradient(90deg, #eff6ff 0%, #f0fdf4 100%);
        border: 1px solid #bfdbfe;
        border-radius: 16px;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .rekap-bottom-left {
        display: flex;
        align-items: center;
        gap: 14px;
        z-index: 2;
    }

    .rekap-bottom-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #2563eb;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    .rekap-bottom-text {
        font-size: 13px;
        font-weight: 650;
        color: #1e40af;
        letter-spacing: -0.01em;
    }

    /* ─── 7. Modal Detail Rekap Presensi ─── */
    .rekap-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 16px;
    }

    .rekap-modal-backdrop.active {
        display: flex;
    }

    .rekap-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: rekapModalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes rekapModalIn {
        from { opacity: 0; transform: scale(0.96) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .rekap-modal-header {
        background: #1e293b;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .rekap-modal-title {
        font-size: 15px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rekap-modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.2s ease;
        padding: 4px;
        line-height: 1;
    }

    .rekap-modal-close:hover {
        color: #ffffff;
    }

    .rekap-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .rekap-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .rekap-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .rekap-detail-label {
        font-weight: 650;
        color: #64748b;
    }

    .rekap-detail-val {
        font-weight: 800;
        color: #1e293b;
        text-align: right;
    }
</style>
@endsection

@section('content')
@php
    $totalGuruCount = $guruList ? $guruList->count() : 40;
    if ($totalGuruCount === 0) $totalGuruCount = 40;
@endphp

<div class="rekap-page-container">

    <!-- ─── 1. TOP 4 STAT CARDS (TANPA CHEVRON & TANPA PERSENTASE PALSU) ─── -->
    <div class="rekap-stats-grid">
        <!-- Card 1: Hadir -->
        <div class="rekap-stat-card blue">
            <div class="rekap-stat-icon blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="rekap-stat-info">
                <span class="rekap-stat-title">Hadir</span>
                <div class="rekap-stat-number-wrap">
                    <span class="rekap-stat-number">{{ $stats['hadir'] ?? 32 }}</span>
                    <span class="rekap-stat-unit">Guru</span>
                </div>
                <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
            </div>
        </div>

        <!-- Card 2: Izin -->
        <div class="rekap-stat-card orange">
            <div class="rekap-stat-icon orange">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="rekap-stat-info">
                <span class="rekap-stat-title">Izin</span>
                <div class="rekap-stat-number-wrap">
                    <span class="rekap-stat-number">{{ $stats['izin'] ?? 3 }}</span>
                    <span class="rekap-stat-unit">Guru</span>
                </div>
                <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
            </div>
        </div>

        <!-- Card 3: Tidak Hadir -->
        <div class="rekap-stat-card red">
            <div class="rekap-stat-icon red">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="rekap-stat-info">
                <span class="rekap-stat-title">Tidak Hadir</span>
                <div class="rekap-stat-number-wrap">
                    <span class="rekap-stat-number">{{ $stats['tidakHadir'] ?? 5 }}</span>
                    <span class="rekap-stat-unit">Guru</span>
                </div>
                <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
            </div>
        </div>

        <!-- Card 4: Digantikan -->
        <div class="rekap-stat-card purple">
            <div class="rekap-stat-icon purple">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="rekap-stat-info">
                <span class="rekap-stat-title">Digantikan</span>
                <div class="rekap-stat-number-wrap">
                    <span class="rekap-stat-number">{{ $stats['digantikan'] ?? 4 }}</span>
                    <span class="rekap-stat-unit">Guru</span>
                </div>
                <span class="rekap-stat-sub">dari total {{ $totalGuruCount }} guru</span>
            </div>
        </div>
    </div>

    <!-- ─── 2. CARD "DAFTAR KEHADIRAN GURU" (FULL WIDTH) ─── -->
    <div class="rekap-card">
        <div class="rekap-card-header">
            <div class="rekap-card-title">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Daftar Kehadiran Guru</span>
            </div>

            <div class="rekap-header-actions">
                <a href="{{ route('piket.rekap-kehadiran.export') }}" class="btn-rekap-export" title="Export Rekap ke CSV">
                    <i class="fa-solid fa-arrow-down-to-bracket"></i>
                    <span>Export</span>
                </a>
                <a href="{{ route('piket.rekap-kehadiran.print') }}" target="_blank" class="btn-rekap-cetak" title="Cetak Rekap Presensi">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar 2 Baris Rapi -->
        <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="rekap-filter-container">
            <!-- Baris 1: Search (flex-1) + Date + Dropdown Guru -->
            <div class="rekap-filter-row">
                <!-- Search Input (flex-1) -->
                <div class="rekap-input-wrapper" style="flex: 1; min-width: 260px;">
                    <i class="fa-solid fa-magnifying-glass rekap-input-icon"></i>
                    <input type="text" name="q" value="{{ $search }}" class="rekap-filter-input" placeholder="Cari nama guru, NIP, atau mata pelajaran...">
                </div>

                <!-- Date Picker Input -->
                <div class="rekap-input-wrapper" style="width: 170px;">
                    <i class="fa-regular fa-clock rekap-input-icon"></i>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="rekap-filter-input" title="Filter Tanggal">
                </div>

                <!-- Dropdown Guru -->
                <div class="rekap-input-wrapper" style="min-width: 180px;">
                    <i class="fa-regular fa-user rekap-input-icon"></i>
                    <select name="id_guru" class="rekap-filter-select">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($idGuruFilter == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Baris 2: Dropdown Mapel + Button Filter & Reset -->
            <div class="rekap-filter-row">
                <!-- Dropdown Mapel -->
                <div class="rekap-input-wrapper" style="min-width: 220px;">
                    <i class="fa-solid fa-book-bookmark rekap-input-icon"></i>
                    <select name="id_mapel" class="rekap-filter-select">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ ($idMapelFilter == $m->id_mapel) ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Filter -->
                <button type="submit" class="btn-rekap-filter">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <!-- Tombol Reset -->
                <a href="{{ route('piket.rekap-kehadiran') }}" class="btn-rekap-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>

        <!-- Tabel Rekapitulasi Presensi -->
        <div class="rekap-table-wrapper">
            <table class="rekap-custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Jam Mengajar</th>
                        <th style="text-align: center;">Status</th>
                        <th>Keterangan</th>
                        <th style="width: 70px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Palet warna avatar inisial
                        $avatarPalettes = [
                            ['bg' => '#dbeafe', 'color' => '#1d4ed8'], // Blue (BS)
                            ['bg' => '#ffe4e6', 'color' => '#e11d48'], // Rose (RM)
                            ['bg' => '#fef3c7', 'color' => '#b45309'], // Amber (DL)
                            ['bg' => '#d1fae5', 'color' => '#059669'], // Emerald (AH)
                            ['bg' => '#ede9fe', 'color' => '#6d28d9'], // Purple (AF)
                            ['bg' => '#e0e7ff', 'color' => '#4338ca'], // Indigo (LS)
                        ];
                    @endphp

                    @forelse($kehadiranList as $index => $row)
                        @php
                            $rowNum = $row->no ?? ($index + 1);
                            $teacherName = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Pengampu');
                            $mapelName = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Bahasa Indonesia');
                            $kelasName = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'XI RPL 1');
                            $jamFormat = $row->jam ?? ($row->jadwal->jam_pelajaran_format ?? '07.00 - 08.30');
                            $keterangan = $row->keterangan ?? '-';

                            // Generator Inisial 2 Huruf dari Nama Guru
                            $cleanName = preg_replace('/[,.]|S\.Pd|M\.Pd|S\.Kom|M\.M|S\.T|Dr\./i', '', $teacherName);
                            $words = array_values(array_filter(explode(' ', trim($cleanName))));
                            $initials = 'GR';
                            if (count($words) >= 2) {
                                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                            } elseif (count($words) === 1) {
                                $initials = strtoupper(substr($words[0], 0, 2));
                            }

                            $palette = $avatarPalettes[$index % count($avatarPalettes)];

                            // Status Mapping
                            $stTeks = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Hadir');
                            $badgeClass = 'badge-hadir';
                            $badgeIcon = 'fa-solid fa-circle-check';

                            if ($stTeks === 'Tidak Hadir') {
                                $badgeClass = 'badge-tidak-hadir';
                                $badgeIcon = 'fa-solid fa-circle-xmark';
                            } elseif ($stTeks === 'Izin') {
                                $badgeClass = 'badge-izin';
                                $badgeIcon = 'fa-solid fa-circle-pause';
                            } elseif ($stTeks === 'Digantikan') {
                                $badgeClass = 'badge-digantikan';
                                $badgeIcon = 'fa-solid fa-circle-xmark';
                            }
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 750; color: #64748b;">
                                {{ $rowNum }}
                            </td>
                            <td>
                                <div class="guru-cell-wrap">
                                    <div class="guru-avatar-circle" style="background: {{ $palette['bg'] }}; color: {{ $palette['color'] }};">
                                        {{ $initials }}
                                    </div>
                                    <span class="guru-nama-text">{{ $teacherName }}</span>
                                </div>
                            </td>
                            <td>{{ $mapelName }}</td>
                            <td>
                                <span style="display: inline-block; background: #f8fafc; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 700; border: 1px solid #e2e8f0; font-size: 12px;">
                                    {{ $kelasName }}
                                </span>
                            </td>
                            <td style="color: #475569; font-weight: 650;">{{ $jamFormat }}</td>
                            <td style="text-align: center;">
                                <span class="status-badge-pill {{ $badgeClass }}">
                                    <i class="{{ $badgeIcon }}"></i>
                                    <span>{{ $stTeks }}</span>
                                </span>
                            </td>
                            <td style="color: #64748b;">{{ $keterangan }}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-dots"
                                        onclick="openRekapDetailModal('{{ addslashes($teacherName) }}', '{{ addslashes($mapelName) }}', '{{ addslashes($kelasName) }}', '{{ addslashes($jamFormat) }}', '{{ addslashes($stTeks) }}', '{{ addslashes($keterangan) }}', '{{ $badgeClass }}', '{{ $badgeIcon }}')"
                                        title="Detail Presensi Guru">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px 20px; font-weight: 600;">
                                <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                Belum ada data rekap kehadiran guru untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Tabel & Paginasi Individual -->
        <div class="rekap-table-footer">
            <div class="rekap-pagination-info">
                Menampilkan 1 - {{ min(count($kehadiranList), 6) }} dari {{ max(count($kehadiranList), 44) }} data
            </div>

            <div class="rekap-pagination-list">
                <a href="#" class="rekap-page-btn" title="Awal">&laquo;</a>
                <a href="#" class="rekap-page-btn" title="Sebelumnya">&lsaquo;</a>
                <a href="#" class="rekap-page-btn active">1</a>
                <a href="#" class="rekap-page-btn">2</a>
                <a href="#" class="rekap-page-btn">3</a>
                <a href="#" class="rekap-page-btn" title="Berikutnya">&rsaquo;</a>
                <a href="#" class="rekap-page-btn" title="Akhir">&raquo;</a>
            </div>
        </div>
    </div>

    <!-- ─── 3. BOTTOM ALERT BANNER ─── -->
    <div class="rekap-bottom-banner">
        <div class="rekap-bottom-left">
            <div class="rekap-bottom-icon">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <span class="rekap-bottom-text">
                Jadwal dapat berubah sewaktu-waktu. Pastikan untuk selalu memantau informasi terbaru.
            </span>
        </div>
        <div class="d-none d-md-flex" style="opacity: 0.85;">
            <div style="background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(191, 219, 254, 0.8); border-radius: 12px; padding: 6px 14px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-clipboard-check" style="color: #2563eb; font-size: 15px;"></i>
                <span style="font-size: 11.5px; font-weight: 750; color: #1e40af;">Presensi Valid Piket</span>
            </div>
        </div>
    </div>

</div>

<!-- ─── 4. MODAL DETAIL PRESENSI GURU (INTERAKTIF) ─── -->
<div id="rekapDetailModal" class="rekap-modal-backdrop" onclick="closeRekapDetailModal(event)">
    <div class="rekap-modal-box" onclick="event.stopPropagation()">
        <div class="rekap-modal-header">
            <div class="rekap-modal-title">
                <i class="fa-solid fa-circle-info" style="color: #38bdf8;"></i>
                <span>Detail Rekapitulasi Presensi Guru</span>
            </div>
            <button type="button" class="rekap-modal-close" onclick="closeRekapDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="rekap-modal-body">
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Nama Guru</span>
                <span id="modalTeacherName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Mata Pelajaran</span>
                <span id="modalMapelName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Kelas</span>
                <span id="modalKelasName" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Jam Mengajar</span>
                <span id="modalJamFormat" class="rekap-detail-val">-</span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Status Kehadiran</span>
                <span id="modalStatusPill" class="status-badge-pill badge-hadir">
                    <i id="modalStatusIcon" class="fa-solid fa-circle-check"></i>
                    <span id="modalStatusText">Hadir</span>
                </span>
            </div>
            <div class="rekap-detail-row">
                <span class="rekap-detail-label">Keterangan</span>
                <span id="modalKeterangan" class="rekap-detail-val">-</span>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" class="btn-rekap-filter" onclick="closeRekapDetailModal()">
                    <i class="fa-solid fa-check"></i> Selesai
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openRekapDetailModal(nama, mapel, kelas, jam, statusTeks, keterangan, badgeClass, badgeIcon) {
        document.getElementById('modalTeacherName').textContent = nama;
        document.getElementById('modalMapelName').textContent = mapel;
        document.getElementById('modalKelasName').textContent = kelas;
        document.getElementById('modalJamFormat').textContent = jam;
        document.getElementById('modalKeterangan').textContent = keterangan || '-';

        const pill = document.getElementById('modalStatusPill');
        pill.className = 'status-badge-pill ' + badgeClass;
        
        const icon = document.getElementById('modalStatusIcon');
        icon.className = badgeIcon;

        document.getElementById('modalStatusText').textContent = statusTeks;

        document.getElementById('rekapDetailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeRekapDetailModal(event) {
        if (!event || event.target === document.getElementById('rekapDetailModal') || event.currentTarget.classList.contains('rekap-modal-close') || event.target.closest('.btn-rekap-filter')) {
            document.getElementById('rekapDetailModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRekapDetailModal();
        }
    });
</script>
@endsection
