@extends('layouts.waka_kurikulum')

@section('title', 'Kelola Jadwal Pelajaran — Waka Kurikulum')

@section('styles')
<style>
    .jadwal-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
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

    .btn-primary { background: #2563eb; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25); }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

    .btn-emerald { background: #059669; color: #ffffff; box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25); }
    .btn-emerald:hover { background: #047857; transform: translateY(-1px); }

    .btn-indigo { background: #4f46e5; color: #ffffff; }
    .btn-indigo:hover { background: #4338ca; }

    .btn-outline { background: #ffffff; color: #334155; border: 1px solid #cbd5e1; }
    .btn-outline:hover { background: #f8fafc; border-color: #94a3b8; }

    .btn-trash { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .btn-trash:hover { background: #fecaca; }

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
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
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

    .icon-blue    { background: #eff6ff; color: #2563eb; }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-purple  { background: #f5f3ff; color: #7c3aed; }
    .icon-amber   { background: #fffbeb; color: #d97706; }

    .stat-info-group {
        display: flex;
        flex-direction: column;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
    }

    .stat-count {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 1px;
    }

    /* Filter & View Mode Controls */
    .control-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .view-mode-tabs {
        display: flex;
        gap: 6px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
        overflow-x: auto;
    }

    .tab-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
    }

    .tab-btn:hover { background: #f1f5f9; color: #0f172a; }
    .tab-btn.active { background: #2563eb; color: #ffffff; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25); }

    .filter-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px;
        align-items: end;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .form-group-filter label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }

    .form-control-filter {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s ease;
        height: 38px;
    }

    .form-control-filter:focus {
        border-color: #2563eb;
    }

    /* Table Section */
    .table-wrapper-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
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
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 580px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-lg { max-width: 800px; }

    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
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

    .modal-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
    }

    .modal-body { padding: 20px; }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
        border-radius: 0 0 16px 16px;
    }

    .modal-input, .modal-select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        margin-top: 4px;
    }

    .modal-input:focus, .modal-select:focus {
        border-color: #2563eb;
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

    /* Action Buttons in Row */
    .btn-row-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.15s ease;
    }
    .btn-row-detail { background: #eff6ff; color: #2563eb; }
    .btn-row-detail:hover { background: #dbeafe; }
    .btn-row-edit   { background: #fef3c7; color: #b45309; }
    .btn-row-edit:hover   { background: #fde68a; }
    .btn-row-delete { background: #fee2e2; color: #dc2626; }
    .btn-row-delete:hover { background: #fca5a5; }

    @media (max-width: 1024px) {
        .stat-cards-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .filter-form-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 640px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
        .filter-form-grid { grid-template-columns: 1fr; }
        .header-actions { width: 100%; }
        .btn-action { flex: 1; justify-content: center; }
    }
</style>
@endsection

@section('content')
<div class="jadwal-container">

    <!-- Flash Alerts -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 12px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fecdd3; padding: 14px 18px; border-radius: 12px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header & Action Buttons --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; Portal Kurikulum &gt; <span style="color: #2563eb;">Master Jadwal Pelajaran</span>
            </div>
            <h1 class="page-main-title">Kelola Jadwal Pelajaran</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Pengelolaan Jadwal KBM, Pemetaan Guru &amp; Distribusi Jam Pembelajaran</p>
        </div>

        <div class="header-actions">
            <button type="button" class="btn-action btn-primary" onclick="openTambahModal()">
                <i class="fa-solid fa-plus"></i> Tambah Jadwal
            </button>
            <button type="button" class="btn-action btn-emerald" onclick="openBatchModal()">
                <i class="fa-solid fa-layer-group"></i> Input Batch
            </button>
            <button type="button" class="btn-action btn-indigo" onclick="openKbmModal()">
                <i class="fa-solid fa-clock"></i> Alokasi KBM
            </button>
            <button type="button" class="btn-action btn-outline" onclick="openCetakModal()">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
            <a href="{{ route('waka-kurikulum.jadwal.export', request()->all()) }}" class="btn-action btn-outline">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
            <a href="{{ route('waka-kurikulum.jadwal.trash') }}" class="btn-action btn-trash" title="Lihat Jadwal di Kotak Sampah">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $stats['trashed'] ?? 0 }})
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

    {{-- Control Panel: Filter & View Mode --}}
    <div class="control-card">
        <div class="view-mode-tabs">
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'table'])) }}" 
               class="tab-btn {{ ($viewMode === 'table') ? 'active' : '' }}">
                <i class="fa-solid fa-table-list"></i> Tabel Jadwal
            </a>
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'matriks_kelas'])) }}" 
               class="tab-btn {{ ($viewMode === 'matriks_kelas') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells"></i> Matriks Per Kelas
            </a>
            <a href="{{ route('waka-kurikulum.jadwal', array_merge(request()->except('view_mode'), ['view_mode' => 'matriks_guru'])) }}" 
               class="tab-btn {{ ($viewMode === 'matriks_guru') ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie"></i> Matriks Per Guru
            </a>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" class="filter-form-grid">
            <input type="hidden" name="view_mode" value="{{ $viewMode }}">

            <div class="form-group-filter">
                <label>Filter Hari</label>
                <select name="hari" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                        <option value="{{ $h }}" {{ ($hariFilter === $h) ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Kelas</label>
                <select name="id_kelas" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ ($kelasFilter == $k->id_kelas) ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Filter Guru Pengampu</label>
                <select name="id_guru" class="form-control-filter" onchange="this.form.submit()">
                    <option value="">-- Semua Guru --</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}" {{ ($guruFilter == $g->id_guru) ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-filter">
                <label>Cari Kata Kunci</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control-filter" placeholder="Mapel / Ruangan...">
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-action btn-primary" style="height: 38px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-kurikulum.jadwal', ['view_mode' => $viewMode]) }}" class="btn-action btn-outline" style="height: 38px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL VIEW --}}
    @if($viewMode === 'table')
    <form action="{{ route('waka-kurikulum.jadwal.batch-delete') }}" method="POST" id="batchDeleteForm">
        @csrf
        <div class="table-wrapper-card">
            <div style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" id="checkAll" style="width: 17px; height: 17px; cursor: pointer;" onclick="toggleCheckAll(this)">
                    <label for="checkAll" style="font-size: 13px; font-weight: 700; color: #475569; cursor: pointer;">Pilih Semua Data</label>
                </div>
                <button type="submit" id="btnBatchDelete" class="btn-action btn-trash" style="display: none; padding: 6px 12px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal yang dipilih ke kotak sampah?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="countSelected">0</span>)
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table class="jadwal-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>HARI</th>
                            <th>JAM KE</th>
                            <th>WAKTU KBM</th>
                            <th>KELAS</th>
                            <th>MATA PELAJARAN</th>
                            <th>GURU PENGAMPU</th>
                            <th>RUANGAN</th>
                            <th style="text-align: center; width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $jadwal)
                            @php
                                $waktuMulaiStr = $jadwal->jamMulai ? substr($jadwal->jamMulai->jam_mulai, 0, 5) : '-';
                                $waktuSelesaiStr = $jadwal->jamSelesai ? substr($jadwal->jamSelesai->jam_selesai, 0, 5) : '-';
                                $rangeWaktu = ($waktuMulaiStr !== '-' && $waktuSelesaiStr !== '-') ? "{$waktuMulaiStr} – {$waktuSelesaiStr} WIB" : '-';
                                $labelJamKe = $jadwal->jam_mulai_ke == $jadwal->jam_selesai_ke ? "Jam Ke-{$jadwal->jam_mulai_ke}" : "Jam Ke-{$jadwal->jam_mulai_ke} – {$jadwal->jam_selesai_ke}";
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_ids[]" value="{{ $jadwal->id_jadwal }}" class="row-checkbox" style="width: 16px; height: 16px; cursor: pointer;" onchange="updateBatchDeleteBtn()">
                                </td>
                                <td>
                                    <span class="day-badge day-{{ $jadwal->hari }}">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: #1d4ed8;">
                                    {{ $labelJamKe }}
                                </td>
                                <td style="font-size: 12px; color: #475569; font-weight: 600;">
                                    <i class="fa-regular fa-clock" style="color: #2563eb; margin-right: 3px;"></i> {{ $rangeWaktu }}
                                </td>
                                <td style="font-weight: 800; color: #0f172a;">
                                    {{ $jadwal->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td style="font-weight: 700; color: #2563eb;">
                                    {{ $jadwal->mapel->nama_mapel ?? '-' }}
                                    <div style="font-size: 11px; color: #64748b; font-weight: 600;">{{ $jadwal->mapel->kode_mapel ?? '' }}</div>
                                </td>
                                <td style="font-weight: 600; color: #334155;">
                                    {{ $jadwal->guru->nama_guru ?? '-' }}
                                </td>
                                <td style="font-size: 12px; color: #64748b;">
                                    {{ $jadwal->ruangan->nama_ruangan ?? 'Kelas Reguler' }}
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="btn-row-action btn-row-detail" title="Detail" data-json="{{ htmlspecialchars(json_encode($jadwal), ENT_QUOTES, 'UTF-8') }}" onclick="openDetailModalFromBtn(this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn-row-action btn-row-edit" title="Edit" data-json="{{ htmlspecialchars(json_encode($jadwal), ENT_QUOTES, 'UTF-8') }}" onclick="openEditModalFromBtn(this)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn-row-action btn-row-delete" title="Hapus" onclick="confirmDeleteJadwal({{ $jadwal->id_jadwal }})">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 36px 20px; color: #94a3b8;">
                                    <i class="fa-regular fa-calendar-xmark" style="font-size: 36px; margin-bottom: 8px;"></i>
                                    <p style="font-weight: 700;">Tidak ada data jadwal yang sesuai dengan filter pencarian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
                {{ $jadwals->links('partials.custom-pagination') }}
            </div>
        </div>
    </form>

    {{-- Form Single Delete --}}
    <form id="singleDeleteForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif

    {{-- VIEW 2: MATRIKS KELAS --}}
    @if($viewMode === 'matriks_kelas')
    <div class="matrix-card">
        <div class="matrix-header-box">
            <div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chalkboard" style="color: #2563eb;"></i>
                    Matriks Jadwal Mingguan: <span style="color: #2563eb;">{{ $selectedKelasObj->nama_kelas ?? 'Pilih Kelas' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    Format alokasi waktu &amp; jam KBM disesuaikan dengan kurikulum resmi SMKN 1 Boyolangu
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" style="display: flex; gap: 8px; align-items: center;">
                    <input type="hidden" name="view_mode" value="matriks_kelas">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Pilih Kelas:</label>
                    <select name="selected_kelas" class="form-control-filter" onchange="this.form.submit()" style="width: auto; min-width: 160px; height: 36px;">
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ ($selectedKelas == $k->id_kelas) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->tingkat }})
                            </option>
                        @endforeach
                    </select>
                </form>

                @if($selectedKelas)
                <a href="{{ route('waka-kurikulum.jadwal.print-kelas', $selectedKelas) }}" target="_blank" class="btn-action btn-outline" style="padding: 7px 12px; font-size: 12px;">
                    <i class="fa-solid fa-print"></i> Cetak Jadwal Kelas Ini
                </a>
                @endif
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Jam</th>
                        <th style="width: 110px;">Waktu (Senin–Kamis)</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th style="width: 110px;">Waktu (Jumat)</th>
                        <th>Jumat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $timesSeninKamis = [
                            1 => '07:00 – 07:40',
                            2 => '07:40 – 08:20',
                            3 => '08:20 – 09:00',
                            4 => '09:00 – 09:40',
                            5 => '10:00 – 10:35',
                            6 => '10:35 – 11:10',
                            7 => '11:10 – 11:45',
                            8 => '13:15 – 13:50',
                            9 => '13:50 – 14:25',
                            10 => '14:25 – 15:00',
                        ];

                        $timesJumat = [
                            1 => '07:00 – 07:30',
                            2 => '07:30 – 08:00',
                            3 => '08:00 – 08:30',
                            4 => '08:30 – 09:00',
                            5 => '09:00 – 09:30',
                            6 => '09:50 – 10:20',
                            7 => '10:20 – 10:50',
                            8 => '10:50 – 11:20',
                            9 => '13:00 – 13:30',
                            10 => '13:30 – 14:00',
                            11 => '14:00 – 14:30',
                            12 => '14:30 – 15:00',
                            13 => '15:00 – 15:35',
                        ];
                    @endphp

                    @for($jam = 1; $jam <= $maxJamKelas; $jam++)
                        {{-- Istirahat 1 Notification --}}
                        @if($jam === 5)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-mug-hot"></i> ISTIRAHAT 1 (Senin–Kamis: 09:40 – 10:00 WIB)
                                </td>
                            </tr>
                        @endif

                        {{-- Istirahat 2 Notification --}}
                        @if($jam === 8)
                            <tr>
                                <td colspan="8" class="matrix-cell-break">
                                    <i class="fa-solid fa-utensils"></i> ISTIRAHAT 2 / ISHOMA (Senin–Kamis: 11:45 – 13:15 WIB)
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
                                            <i class="fa-solid fa-chalkboard-user" style="color: #2563eb;"></i> {{ $cell->guru->nama_guru ?? '-' }}
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
                    <i class="fa-solid fa-user-tie" style="color: #2563eb;"></i>
                    Matriks Jadwal Mengajar Guru: <span style="color: #2563eb;">{{ $selectedGuruObj->nama_guru ?? 'Pilih Guru' }}</span>
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                    NIP: {{ $selectedGuruObj->nip ?? '-' }} | Beban Mengajar &amp; Ruang KBM Terjadwal
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <form method="GET" action="{{ route('waka-kurikulum.jadwal') }}" style="display: flex; gap: 8px; align-items: center;">
                    <input type="hidden" name="view_mode" value="matriks_guru">
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Pilih Guru:</label>
                    <select name="selected_guru" class="form-control-filter" onchange="this.form.submit()" style="width: auto; min-width: 200px; height: 36px;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($selectedGuru == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Jam</th>
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

{{-- MODAL TAMBAH JADWAL BARU --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus-circle" style="color: #2563eb;"></i> Tambah Jadwal Pelajaran Baru</h3>
            <button type="button" class="modal-close-btn" onclick="closeTambahModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('waka-kurikulum.jadwal.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Kelas Target <span style="color: #ef4444;">*</span></label>
                        <select name="id_kelas" class="modal-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Guru Pengampu <span style="color: #ef4444;">*</span></label>
                        <select name="id_guru" class="modal-select" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Mata Pelajaran <span style="color: #ef4444;">*</span></label>
                        <select name="id_mapel" class="modal-select" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }} ({{ $m->kode_mapel ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Hari <span style="color: #ef4444;">*</span></label>
                            <select name="hari" class="modal-select" required>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Ruangan Belajar</label>
                            <select name="id_ruangan" class="modal-select">
                                <option value="">-- Kelas Reguler --</option>
                                @foreach($ruanganList as $r)
                                    <option value="{{ $r->id_ruangan }}">{{ $r->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Jam Mulai <span style="color: #ef4444;">*</span></label>
                            <select name="id_jam_mulai" class="modal-select" required>
                                @foreach($jamList as $jm)
                                    <option value="{{ $jm->id_jam }}">Jam ke-{{ $jm->jam_ke }} ({{ $jm->jam_mulai }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Jam Selesai <span style="color: #ef4444;">*</span></label>
                            <select name="id_jam_selesai" class="modal-select" required>
                                @foreach($jamList as $jm)
                                    <option value="{{ $jm->id_jam }}">Jam ke-{{ $jm->jam_ke }} ({{ $jm->jam_selesai }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action btn-outline" onclick="closeTambahModal()">Batal</button>
                <button type="submit" class="btn-action btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT JADWAL --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Edit Data Jadwal Pelajaran</h3>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editJadwalForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Kelas Target</label>
                        <select name="id_kelas" id="edit_id_kelas" class="modal-select" required>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Guru Pengampu</label>
                        <select name="id_guru" id="edit_id_guru" class="modal-select" required>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Mata Pelajaran</label>
                        <select name="id_mapel" id="edit_id_mapel" class="modal-select" required>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Hari</label>
                            <select name="hari" id="edit_hari" class="modal-select" required>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Ruangan Belajar</label>
                            <select name="id_ruangan" id="edit_id_ruangan" class="modal-select">
                                <option value="">-- Kelas Reguler --</option>
                                @foreach($ruanganList as $r)
                                    <option value="{{ $r->id_ruangan }}">{{ $r->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Jam Mulai</label>
                            <select name="id_jam_mulai" id="edit_id_jam_mulai" class="modal-select" required>
                                @foreach($jamList as $jm)
                                    <option value="{{ $jm->id_jam }}">Jam ke-{{ $jm->jam_ke }} ({{ $jm->jam_mulai }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155;">Jam Selesai</label>
                            <select name="id_jam_selesai" id="edit_id_jam_selesai" class="modal-select" required>
                                @foreach($jamList as $jm)
                                    <option value="{{ $jm->id_jam }}">Jam ke-{{ $jm->jam_ke }} ({{ $jm->jam_selesai }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-action btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL INPUT BATCH JADWAL --}}
<div class="modal-overlay" id="modalBatch">
    <div class="modal-box modal-lg" style="max-width: 900px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-layer-group" style="color: #059669;"></i> Input Batch Jadwal Pelajaran (Multi-Baris)</h3>
            <button type="button" class="modal-close-btn" onclick="closeBatchModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('waka-kurikulum.jadwal.batch-store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div style="margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 13px; color: #64748b; font-weight: 600;">Masukkan beberapa sesi jadwal sekaligus untuk mempermudah alokasi KBM.</span>
                    <button type="button" class="btn-action btn-emerald" onclick="addBatchRow()" style="padding: 6px 12px; font-size: 12px;">
                        <i class="fa-solid fa-plus"></i> Tambah Baris
                    </button>
                </div>

                <div style="overflow-x: auto; max-height: 350px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;" id="batchTable">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 8px;">Kelas</th>
                                <th style="padding: 8px;">Guru</th>
                                <th style="padding: 8px;">Mapel</th>
                                <th style="padding: 8px; width: 100px;">Hari</th>
                                <th style="padding: 8px; width: 100px;">Jam Mulai</th>
                                <th style="padding: 8px; width: 100px;">Jam Selesai</th>
                                <th style="padding: 8px; width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="batchTableBody">
                            <!-- Row 1 Default -->
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][id_kelas]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelasList as $k)
                                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][id_guru]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($guruList as $g)
                                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][id_mapel]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        <option value="">Pilih Mapel</option>
                                        @foreach($mapelList as $m)
                                            <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][hari]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                            <option value="{{ $h }}">{{ $h }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][id_jam_mulai]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        @foreach($jamList as $jm)
                                            <option value="{{ $jm->id_jam }}">Jam {{ $jm->jam_ke }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px;">
                                    <select name="jadwals[0][id_jam_selesai]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                                        @foreach($jamList as $jm)
                                            <option value="{{ $jm->id_jam }}">Jam {{ $jm->jam_ke }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 6px; text-align: center;">
                                    <button type="button" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="removeBatchRow(this)"><i class="fa-solid fa-xmark"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action btn-outline" onclick="closeBatchModal()">Batal</button>
                <button type="submit" class="btn-action btn-emerald"><i class="fa-solid fa-layer-group"></i> Simpan Batch Jadwal</button>
            </div>
        </form>
    </div>
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
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b; width: 35%;">Hari</td><td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_hari">-</td></tr>
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b;">Jam Pelajaran</td><td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_jam">-</td></tr>
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b;">Kelas Target</td><td style="padding: 10px; font-weight: 800; color: #2563eb;" id="det_kelas">-</td></tr>
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b;">Mata Pelajaran</td><td style="padding: 10px; font-weight: 800; color: #0f172a;" id="det_mapel">-</td></tr>
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b;">Guru Pengajar</td><td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_guru">-</td></tr>
                <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px; font-weight: 700; color: #64748b;">Ruangan Belajar</td><td style="padding: 10px; font-weight: 700; color: #1e293b;" id="det_ruangan">-</td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL ALOKASI KBM --}}
<div class="modal-overlay" id="modalKbm">
    <div class="modal-box modal-lg">
        <div class="modal-header">
            <h3><i class="fa-solid fa-clock" style="color: #4f46e5;"></i> Struktur Alokasi Waktu Jam KBM SMKN 1 Boyolangu</h3>
            <button type="button" class="modal-close-btn" onclick="closeKbmModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0;">Senin – Kamis (10 Jam Pelajaran)</h4>
                    <table class="kbm-ref-table">
                        <thead><tr><th>Jam</th><th>Alokasi Waktu</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            <tr><td>1</td><td>07.00 - 07.40</td><td>Upacara / Apel</td></tr>
                            <tr><td>2</td><td>07.40 - 08.20</td><td>KBM</td></tr>
                            <tr><td>3</td><td>08.20 - 09.00</td><td>KBM</td></tr>
                            <tr><td>4</td><td>09.00 - 09.40</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>09.40 - 10.00</td><td>Istirahat 1 (20 Menit)</td></tr>
                            <tr><td>5</td><td>10.00 - 10.35</td><td>KBM</td></tr>
                            <tr><td>6</td><td>10.35 - 11.10</td><td>KBM</td></tr>
                            <tr><td>7</td><td>11.10 - 11.45</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>11.45 - 13.15</td><td>ISHOMA</td></tr>
                            <tr><td>8</td><td>13.15 - 13.50</td><td>KBM</td></tr>
                            <tr><td>9</td><td>13.50 - 14.25</td><td>KBM</td></tr>
                            <tr><td>10</td><td>14.25 - 15.00</td><td>KBM / Pulang</td></tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0;">Jumat (13 Jam Pelajaran)</h4>
                    <table class="kbm-ref-table">
                        <thead><tr><th>Jam</th><th>Alokasi Waktu</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            <tr><td>1</td><td>07.00 - 07.30</td><td>Pembiasaan</td></tr>
                            <tr><td>2-5</td><td>07.30 - 09.30</td><td>KBM Sesi Pagi</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>09.30 - 09.50</td><td>Istirahat 1</td></tr>
                            <tr><td>6-8</td><td>09.50 - 11.20</td><td>KBM</td></tr>
                            <tr style="background: #fef3c7; font-weight: 700;"><td>-</td><td>11.20 - 13.00</td><td>Sholat Jumat &amp; Ishoma</td></tr>
                            <tr><td>9-13</td><td>13.00 - 15.35</td><td>KBM Sesi Siang</td></tr>
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
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <a href="{{ route('waka-kurikulum.jadwal.print', request()->all()) }}" target="_blank" class="btn-action btn-primary" style="padding: 12px; justify-content: center; text-decoration: none;">
                    <i class="fa-solid fa-table-list"></i> Cetak Master Jadwal (Sesuai Filter)
                </a>

                <div style="border-top: 1px solid #e2e8f0; padding-top: 14px;">
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

@endsection

@section('scripts')
<script>
    let batchIndex = 1;

    function openTambahModal() { document.getElementById('modalTambah').style.display = 'flex'; }
    function closeTambahModal() { document.getElementById('modalTambah').style.display = 'none'; }

    function openDetailModalFromBtn(btn) {
        try {
            const data = JSON.parse(btn.getAttribute('data-json'));
            openDetailModal(data);
        } catch(e) {
            console.error("Error parsing JSON for detail modal:", e);
        }
    }

    function openEditModalFromBtn(btn) {
        try {
            const data = JSON.parse(btn.getAttribute('data-json'));
            openEditModal(data);
        } catch(e) {
            console.error("Error parsing JSON for edit modal:", e);
        }
    }

    function openEditModal(jadwal) {
        document.getElementById('editJadwalForm').action = '/waka-kurikulum/jadwal/' + jadwal.id_jadwal;
        document.getElementById('edit_id_kelas').value = jadwal.id_kelas;
        document.getElementById('edit_id_guru').value = jadwal.id_guru;
        document.getElementById('edit_id_mapel').value = jadwal.id_mapel;
        document.getElementById('edit_hari').value = jadwal.hari;
        document.getElementById('edit_id_ruangan').value = jadwal.id_ruangan || '';
        document.getElementById('edit_id_jam_mulai').value = jadwal.id_jam_mulai;
        document.getElementById('edit_id_jam_selesai').value = jadwal.id_jam_selesai;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('modalEdit').style.display = 'none'; }

    function openBatchModal() { document.getElementById('modalBatch').style.display = 'flex'; }
    function closeBatchModal() { document.getElementById('modalBatch').style.display = 'none'; }

    function addBatchRow() {
        const tbody = document.getElementById('batchTableBody');
        const tr = document.createElement('tr');
        tr.style.borderBottom = '1px solid #f1f5f9';
        tr.innerHTML = `
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][id_kelas]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][id_guru]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    <option value="">Pilih Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][id_mapel]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    <option value="">Pilih Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][hari]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                        <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][id_jam_mulai]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    @foreach($jamList as $jm)
                        <option value="{{ $jm->id_jam }}">Jam {{ $jm->jam_ke }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px;">
                <select name="jadwals[${batchIndex}][id_jam_selesai]" class="modal-select" style="font-size: 11.5px; padding: 6px;" required>
                    @foreach($jamList as $jm)
                        <option value="{{ $jm->id_jam }}">Jam {{ $jm->jam_ke }}</option>
                    @endforeach
                </select>
            </td>
            <td style="padding: 6px; text-align: center;">
                <button type="button" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="removeBatchRow(this)"><i class="fa-solid fa-xmark"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
        batchIndex++;
    }

    function removeBatchRow(btn) {
        const row = btn.closest('tr');
        if (row) row.remove();
    }

    function openDetailModal(jadwal) {
        const jamMulaiKe = jadwal.jam_mulai_ke || (jadwal.jam_mulai ? jadwal.jam_mulai.jam_ke : '-');
        const jamSelesaiKe = jadwal.jam_selesai_ke || (jadwal.jam_selesai ? jadwal.jam_selesai.jam_ke : '-');
        
        document.getElementById('det_hari').textContent = 'Hari ' + (jadwal.hari || '-');
        document.getElementById('det_jam').textContent = (jamMulaiKe === jamSelesaiKe ? 'Jam Ke-' + jamMulaiKe : 'Jam Ke-' + jamMulaiKe + ' s/d ' + jamSelesaiKe);
        document.getElementById('det_kelas').textContent = (jadwal.kelas ? jadwal.kelas.nama_kelas : '-');
        document.getElementById('det_mapel').textContent = (jadwal.mapel ? jadwal.mapel.nama_mapel : '-');
        document.getElementById('det_guru').textContent = (jadwal.guru ? jadwal.guru.nama_guru : '-');
        document.getElementById('det_ruangan').textContent = (jadwal.ruangan ? jadwal.ruangan.nama_ruangan : 'Kelas Reguler');
        document.getElementById('modalDetail').style.display = 'flex';
    }
    function closeDetailModal() { document.getElementById('modalDetail').style.display = 'none'; }

    function openKbmModal() { document.getElementById('modalKbm').style.display = 'flex'; }
    function closeKbmModal() { document.getElementById('modalKbm').style.display = 'none'; }

    function openCetakModal() { document.getElementById('modalCetak').style.display = 'flex'; }
    function closeCetakModal() { document.getElementById('modalCetak').style.display = 'none'; }

    function cetakPerKelas() {
        const idKelas = document.getElementById('cetakKelasSelect').value;
        if (idKelas) {
            window.open('/waka-kurikulum/jadwal/print-kelas/' + idKelas, '_blank');
        }
    }

    function confirmDeleteJadwal(id) {
        if (confirm('Apakah Anda yakin ingin memindahkan jadwal ini ke kotak sampah?')) {
            const form = document.getElementById('singleDeleteForm');
            form.action = '/waka-kurikulum/jadwal/' + id;
            form.submit();
        }
    }

    function toggleCheckAll(source) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
        updateBatchDeleteBtn();
    }

    function updateBatchDeleteBtn() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        const btn = document.getElementById('btnBatchDelete');
        const countSpan = document.getElementById('countSelected');
        if (checked.length > 0) {
            btn.style.display = 'inline-flex';
            countSpan.textContent = checked.length;
        } else {
            btn.style.display = 'none';
        }
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection

