@extends('layouts.guru')

@section('title', 'Rekap Kehadiran Guru — Guru Piket')
@section('header_title', 'Rekap Kehadiran Guru')

@section('styles')
<style>
    .rekap-kehadiran-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: -12px;
        margin-bottom: 4px;
    }

    /* Filter Bar */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1.5;
        min-width: 220px;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input-wrapper input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-family: inherit;
        outline: none;
    }

    .filter-item {
        flex: 1;
        min-width: 140px;
    }

    .filter-item select, .filter-item input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #334155;
        font-weight: 600;
    }

    .btn-filter-action {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .btn-filter-action:hover {
        background: #1e293b;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-orange { background: #ffedd5; color: #ea580c; }
    .stat-icon-red    { background: #fee2e2; color: #dc2626; }
    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-action-outline {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-action-solid {
        background: #2b3957;
        border: 1px solid #2b3957;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-action-solid:hover {
        background: #1e293b;
    }

    /* Table Styling */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-kehadiran-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-kehadiran-table th {
        background: #dfd8c8;
        color: #1e293b;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #d1c9b6;
        border-bottom: 1px solid #d1c9b6;
    }

    .custom-kehadiran-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; text-align: center; }
    .custom-kehadiran-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; }

    .custom-kehadiran-table td {
        padding: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-status-hadir {
        background: #d1fae5;
        color: #059669;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-tidak-hadir {
        background: #fee2e2;
        color: #dc2626;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-izin {
        background: #fef3c7;
        color: #d97706;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-digantikan {
        background: #dbeafe;
        color: #2563eb;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .btn-action-dots {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-dots:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    /* Table Footer & Pagination */
    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .page-btn.active {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .filter-grid { flex-direction: column; align-items: stretch; }
    }
</style>
@endsection

@section('content')
<div class="rekap-kehadiran-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Rekap Kehadiran Guru & Siswa</h1>
            <p>Laporan rekapitulasi presensi, statistik ketidakhadiran, dan jurnal piket</p>
        </div>
    </div>

    <!-- 1. Stat Cards Grid (4 Cards) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Hadir</span>
                <span class="stat-val">{{ $stats['hadir'] }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Izin</span>
                <span class="stat-val">{{ $stats['izin'] }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-red">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Tidak Hadir</span>
                <span class="stat-val">{{ $stats['tidakHadir'] }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Digantikan</span>
                <span class="stat-val">{{ $stats['digantikan'] }} Guru</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Table Panel (Daftar Kehadiran Guru) -->
    <div class="main-table-panel">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-chart-column" style="color: #2b3957;"></i>
                <span>Daftar Kehadiran Guru</span>
            </div>

            <div class="header-actions">
                <a href="{{ route('piket.rekap-kehadiran.export') }}" class="btn-action-outline">
                    <i class="fa-solid fa-download"></i> Export
                </a>
                <a href="{{ route('piket.rekap-kehadiran.print') }}" target="_blank" class="btn-action-solid">
                    <i class="fa-solid fa-print"></i> Cetak
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar (Di Atas Tabel) -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.rekap-kehadiran') }}" method="GET">
                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari nama guru..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">
                </div>

                <div>
                    <select name="id_guru" class="filter-input">
                        <option value="">👥 Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input">
                        <option value="">📖 Semua Mata Pelajaran</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <a href="{{ route('piket.rekap-kehadiran') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-container">
            <table class="custom-kehadiran-table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Tanggal</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Jam Mengajar</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiranList as $index => $row)
                        @php
                            $stTeks = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Hadir');
                            $stClass = 'badge-status-hadir';
                            if ($stTeks === 'Tidak Hadir') $stClass = 'badge-status-tidak-hadir';
                            elseif ($stTeks === 'Izin') $stClass = 'badge-status-izin';
                            elseif ($stTeks === 'Digantikan') $stClass = 'badge-status-digantikan';
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $row->no ?? ($index + 1) }}</td>
                            <td><strong>{{ $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru') }}</strong></td>
                            <td>{{ $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Bahasa Indonesia') }}</td>
                            <td>{{ $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'XI RPL 1') }}</td>
                            <td>{{ $row->jam ?? ($row->jadwal->jam_pelajaran_format ?? '07.00 - 08.30') }}</td>
                            <td>
                                <span class="{{ $stClass }}">{{ $stTeks }}</span>
                            </td>
                            <td>{{ $row->keterangan ?? '-' }}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-dots" onclick="alert('Detail Kehadiran: {{ $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru') }} - Status: {{ $stTeks }}')" title="Opsi Kehadiran">...</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 24px;">Belum ada data rekap kehadiran guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan 1 - {{ min(count($kehadiranList), 6) }} dari 44 data
            </div>

            <div class="custom-pagination">
                <a href="#" class="page-btn">&lt;&lt;</a>
                <a href="#" class="page-btn">&lt;</a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <a href="#" class="page-btn">&gt;</a>
                <a href="#" class="page-btn">&gt;&gt;</a>
            </div>
        </div>
    </div>

</div>
@endsection
