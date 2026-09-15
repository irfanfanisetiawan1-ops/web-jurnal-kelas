@extends('layouts.waka')

@section('title', 'Pengumuman & Instruksi Harian — Waka Portal')

@section('styles')
<style>
    .pengumuman-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Header Box */
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

    .btn-trash {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .btn-trash:hover {
        background: #fecaca;
    }

    /* 4 Stat Cards Grid */
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

    /* Table Container */
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

    .pengumuman-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 950px;
    }

    .pengumuman-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .pengumuman-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .pengumuman-table tr:hover td {
        background: #f8fafc;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    .cat-Umum        { background: #eff6ff; color: #1d4ed8; }
    .cat-Kesiswaan   { background: #ecfdf5; color: #047857; }
    .cat-Kurikulum   { background: #f0fdf4; color: #15803d; }
    .cat-Workshop    { background: #f5f3ff; color: #6d28d9; }
    .cat-Rapat       { background: #fffbeb; color: #b45309; }
    .cat-Perubahan   { background: #fff7ed; color: #c2410c; }
    .cat-Penugasan   { background: #fdf2f8; color: #be185d; }
    .cat-Ujian       { background: #fef2f2; color: #b91c1c; }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
    }
    .status-aktif   { background: #dcfce7; color: #15803d; }
    .status-selesai { background: #dbeafe; color: #1d4ed8; }
    .status-arsip   { background: #f1f5f9; color: #475569; }

    .class-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 8px;
        border-radius: 6px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-weight: 700;
        font-size: 12px;
    }

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

    /* Modal Styles */
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
        max-width: 650px;
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

    .modal-input, .modal-select, .modal-textarea {
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

    .modal-input:focus, .modal-select:focus, .modal-textarea:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
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
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-container">

    {{-- Page Header --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; <span style="color: #2563eb;">Pengumuman Sekolah</span>
            </div>
            <h1 class="page-main-title">Pengumuman &amp; Instruksi Harian</h1>
            <p class="page-sub-title">Pusat Informasi, Agenda Kegiatan, dan Instruksi Sekolah untuk Seluruh Guru &amp; Kelas SMKN 1 Boyolangu</p>
        </div>

        <div class="header-actions">
            <button type="button" class="btn-action btn-emerald" onclick="openTambahModal()">
                <i class="fa-solid fa-plus"></i> Tambah Pengumuman
            </button>
            <button type="button" class="btn-action btn-trash" onclick="openTrashModal()">
                <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashCount }})
            </button>
        </div>
    </div>

    {{-- 4 Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Pengumuman</span>
                <span class="stat-count">{{ number_format($stats['totalPengumuman'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-emerald">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Pengumuman Aktif</span>
                <span class="stat-count">{{ $stats['pengumumanAktif'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Aktif</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Pengumuman Selesai</span>
                <span class="stat-count">{{ $stats['pengumumanSelesai'] ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Selesai</span></span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Kotak Sampah</span>
                <span class="stat-count">{{ $trashCount ?? 0 }} <span style="font-size: 12px; color: #64748b; font-weight: 500;">Data</span></span>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-panel">
        <form method="GET" action="{{ route('waka.pengumuman') }}" class="filter-form-grid" id="filterForm">
            <div class="search-input-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul, isi, kategori..." class="filter-input">
            </div>

            <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-select" title="Filter Tanggal">

            <select name="id_kelas" class="filter-select">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ (string)$idKelasFilter === (string)$k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <select name="kategori" class="filter-select">
                <option value="">-- Semua Kategori --</option>
                @foreach(['Umum', 'Kesiswaan', 'Kurikulum', 'Workshop', 'Rapat', 'Perubahan Jadwal', 'Penugasan', 'Ujian / Asesmen', 'Kegiatan Sekolah'] as $cat)
                    <option value="{{ $cat }}" {{ $kategoriFilter === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <select name="status" class="filter-select">
                <option value="">-- Semua Status --</option>
                <option value="aktif" {{ strtolower($statusFilter) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ strtolower($statusFilter) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="arsip" {{ strtolower($statusFilter) === 'arsip' ? 'selected' : '' }}>Arsip</option>
            </select>

            <button type="submit" class="btn-filter-submit">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            <a href="{{ route('waka.pengumuman') }}" class="btn-filter-reset" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </form>
    </div>

    {{-- Main Table Card --}}
    <div class="table-card">
        <div class="table-action-bar">
            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-list-check" style="color: #2563eb;"></i>
                Daftar Pengumuman Sekolah
            </div>
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                Total <span style="color: #0f172a; font-weight: 800;">{{ count($pengumumanList) }}</span> pengumuman ditemukan
            </div>
        </div>

        <div class="table-scroll-wrapper">
            <table class="pengumuman-table">
                <thead>
                    <tr>
                        <th style="width: 35px; text-align: center;">#</th>
                        <th>Judul &amp; Isi Pengumuman</th>
                        <th>Kelas Target</th>
                        <th>Jam Mengajar / Waktu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pembuat &amp; Tanggal</th>
                        <th style="text-align: center; width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumanList as $index => $row)
                        @php
                            $st = strtolower($row->status ?? 'aktif');
                            $stClass = ($st === 'selesai') ? 'status-selesai' : (($st === 'arsip') ? 'status-arsip' : 'status-aktif');
                            $kelasNama = $row->kelas->nama_kelas ?? ($row->id_kelas ? 'Kelas #'.$row->id_kelas : 'Semua Kelas');
                            $pembuatNama = $row->pembuat->nama_guru ?? 'Waka Kesiswaan';
                            $tanggalFormatted = $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') : '-';
                            $catClean = preg_replace('/[^a-zA-Z]/', '', $row->kategori ?? 'Umum');
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #94a3b8;">{{ $index + 1 }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                    <span class="category-badge cat-{{ $catClean }}">{{ $row->kategori ?? 'Umum' }}</span>
                                    <span style="font-weight: 800; color: #0f172a; font-size: 13.5px;">{{ $row->judul }}</span>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px; line-height: 1.4; max-width: 320px;">
                                    {{ Str::limit($row->isi ?? '', 85) }}
                                </div>
                            </td>
                            <td>
                                <span class="class-chip">
                                    <i class="fa-solid fa-users"></i> {{ $kelasNama }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 12px; font-weight: 700; color: #334155;">
                                    <i class="fa-regular fa-clock" style="color: #94a3b8;"></i> {{ $row->jam_mengajar ?: '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-status {{ $stClass }}">
                                    {{ ucfirst($st) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #475569; font-weight: 600;">{{ $row->keterangan ?: '-' }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 12.5px;">{{ $pembuatNama }}</div>
                                <div style="font-size: 11px; color: #64748b; margin-top: 1px;">{{ $tanggalFormatted }}</div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <button type="button" class="btn-row-action" title="Detail Pengumuman"
                                            onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "{{ addslashes($pembuatNama) }}", "{{ $tanggalFormatted }}")'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-row-action edit-btn" title="Edit Pengumuman"
                                            onclick='openEditModal(@json($row))'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('waka.pengumuman.destroy', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Pindahkan pengumuman ini ke kotak sampah?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-row-action delete-btn" title="Hapus Pengumuman">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px 20px;">
                                <div style="color: #94a3b8; font-size: 32px; margin-bottom: 10px;">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <div style="font-size: 15px; font-weight: 800; color: #475569;">Tidak ada data pengumuman ditemukan</div>
                                <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Coba ubah kata kunci pencarian atau sesuaikan filter.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL TAMBAH PENGUMUMAN --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus-circle" style="color: #059669;"></i> Tambah Pengumuman Sekolah</h3>
            <button type="button" class="modal-close-btn" onclick="closeTambahModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('waka.pengumuman.store') }}" id="formTambah">
            @csrf
            <div class="modal-body">
                <div class="form-group-modal">
                    <label>Judul Pengumuman <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="judul" class="modal-input" placeholder="e.g. Rapat Koordinasi Kurikulum &amp; Kesiswaan" required>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Kategori <span style="color: #dc2626;">*</span></label>
                        <select name="kategori" class="modal-select" required>
                            <option value="Umum">Umum</option>
                            <option value="Kesiswaan">Kesiswaan</option>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Penugasan">Penugasan</option>
                            <option value="Ujian / Asesmen">Ujian / Asesmen</option>
                            <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Kelas Target</label>
                        <select name="id_kelas" class="modal-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Pilihan Jam / Waktu Mengajar</label>
                        <select name="jam_mengajar_select" id="addJamSelect" class="modal-select" onchange="toggleCustomJam(this, 'addJamCustomWrapper', 'addJamCustomInput')">
                            <option value="Sepanjang Hari">Sepanjang Hari / Kegiatan Bebas</option>
                            <option value="07.00 - 08.20">07.00 - 08.20 (Jam Ke 1 - 2)</option>
                            <option value="08.20 - 09.40">08.20 - 09.40 (Jam Ke 3 - 4)</option>
                            <option value="10.00 - 11.45">10.00 - 11.45 (Jam Ke 5 - 7)</option>
                            <option value="13.15 - 15.00">13.15 - 15.00 (Jam Ke 8 - 10)</option>
                            <option value="custom">-- Tulis Jam / Waktu Kustom --</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Status <span style="color: #dc2626;">*</span></label>
                        <select name="status" class="modal-select" required>
                            <option value="aktif">Aktif (Tampil Di Portal Guru &amp; Siswa)</option>
                            <option value="selesai">Selesai (Kegiatan Telah Berakhir)</option>
                            <option value="arsip">Arsip</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-modal" id="addJamCustomWrapper" style="display: none; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    <label>Waktu Kustom / Keterangan Waktu:</label>
                    <input type="text" name="jam_mengajar_custom" id="addJamCustomInput" placeholder="e.g. 07.30 - 09.00 WIB" class="modal-input">
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Tanggal Berlaku <span style="color: #dc2626;">*</span></label>
                        <input type="date" name="tanggal" value="{{ $todayDate }}" class="modal-input" required>
                    </div>

                    <div class="form-group-modal">
                        <label>Keterangan / Catatan Singkat <span style="color: #dc2626;">*</span></label>
                        <input type="text" name="keterangan" placeholder="e.g. Urusan Dinas / Wajib Hadir Tepat Waktu" class="modal-input" required>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label>Isi Pengumuman Lengkap <span style="color: #dc2626;">*</span></label>
                    <textarea name="isi" rows="4" placeholder="Tuliskan isi instruksi atau pengumuman secara rinci..." class="modal-textarea" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action btn-outline" onclick="closeTambahModal()">Batal</button>
                <button type="submit" class="btn-action btn-emerald"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT PENGUMUMAN --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> Edit Pengumuman Sekolah</h3>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" id="formEdit" action="">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group-modal">
                    <label>Judul Pengumuman <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="judul" id="editJudul" class="modal-input" required>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Kategori <span style="color: #dc2626;">*</span></label>
                        <select name="kategori" id="editKategori" class="modal-select" required>
                            <option value="Umum">Umum</option>
                            <option value="Kesiswaan">Kesiswaan</option>
                            <option value="Kurikulum">Kurikulum</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                            <option value="Penugasan">Penugasan</option>
                            <option value="Ujian / Asesmen">Ujian / Asesmen</option>
                            <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Kelas Target</label>
                        <select name="id_kelas" id="editKelas" class="modal-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Pilihan Jam / Waktu Mengajar</label>
                        <select name="jam_mengajar_select" id="editJamSelect" class="modal-select" onchange="toggleCustomJam(this, 'editJamCustomWrapper', 'editJamCustomInput')">
                            <option value="Sepanjang Hari">Sepanjang Hari / Kegiatan Bebas</option>
                            <option value="07.00 - 08.20">07.00 - 08.20 (Jam Ke 1 - 2)</option>
                            <option value="08.20 - 09.40">08.20 - 09.40 (Jam Ke 3 - 4)</option>
                            <option value="10.00 - 11.45">10.00 - 11.45 (Jam Ke 5 - 7)</option>
                            <option value="13.15 - 15.00">13.15 - 15.00 (Jam Ke 8 - 10)</option>
                            <option value="custom">-- Tulis Jam / Waktu Kustom --</option>
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label>Status <span style="color: #dc2626;">*</span></label>
                        <select name="status" id="editStatus" class="modal-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="arsip">Arsip</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-modal" id="editJamCustomWrapper" style="display: none; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    <label>Waktu Kustom / Keterangan Waktu:</label>
                    <input type="text" name="jam_mengajar_custom" id="editJamCustomInput" class="modal-input">
                </div>

                <div class="form-grid-2">
                    <div class="form-group-modal">
                        <label>Tanggal Berlaku <span style="color: #dc2626;">*</span></label>
                        <input type="date" name="tanggal" id="editTanggal" class="modal-input" required>
                    </div>

                    <div class="form-group-modal">
                        <label>Keterangan / Catatan Singkat <span style="color: #dc2626;">*</span></label>
                        <input type="text" name="keterangan" id="editKeterangan" class="modal-input" required>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label>Isi Pengumuman Lengkap <span style="color: #dc2626;">*</span></label>
                    <textarea name="isi" id="editIsi" rows="4" class="modal-textarea" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-action btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DETAIL PENGUMUMAN --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Rincian Pengumuman Sekolah</h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 12px;">
                <span class="category-badge cat-Umum" id="detKategori">Umum</span>
                <span class="badge-status status-aktif" id="detStatus">Aktif</span>
            </div>

            <h2 id="detJudul" style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 14px 0; line-height: 1.3;">-</h2>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px; margin-bottom: 16px;">
                <div><strong style="color: #64748b;">Sasaran Kelas:</strong> <span id="detKelas" style="font-weight: 700; color: #0f172a;">-</span></div>
                <div><strong style="color: #64748b;">Waktu / Jam:</strong> <span id="detJam" style="font-weight: 700; color: #0f172a;">-</span></div>
                <div><strong style="color: #64748b;">Pembuat:</strong> <span id="detPembuat" style="font-weight: 700; color: #0f172a;">-</span></div>
                <div><strong style="color: #64748b;">Tanggal:</strong> <span id="detTanggal" style="font-weight: 700; color: #0f172a;">-</span></div>
                <div style="grid-column: span 2;"><strong style="color: #64748b;">Keterangan:</strong> <span id="detKeterangan" style="font-weight: 700; color: #0f172a;">-</span></div>
            </div>

            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 6px;">ISI PENGUMUMAN:</div>
            <div id="detIsi" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 14px; font-size: 13.5px; line-height: 1.6; color: #1e293b; white-space: pre-line;">
                -
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL TRASH / KOTAK SAMPAH --}}
<div class="modal-overlay" id="modalTrash">
    <div class="modal-box modal-lg">
        <div class="modal-header">
            <h3><i class="fa-solid fa-trash-can" style="color: #b91c1c;"></i> Kotak Sampah Pengumuman</h3>
            <button type="button" class="modal-close-btn" onclick="closeTrashModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div style="font-size: 12.5px; color: #64748b;">
                    Daftar pengumuman yang dihapus sementara. Anda dapat memulihkan atau menghapus permanen.
                </div>
                @if($trashCount > 0)
                <form action="{{ route('waka.pengumuman.empty-trash') }}" method="POST" onsubmit="return confirm('Kosongkan SELURUH kotak sampah pengumuman? Tindakan tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-trash" style="padding: 6px 12px; font-size: 12px;">
                        <i class="fa-solid fa-trash-can-arrow-up"></i> Kosongkan Sampah
                    </button>
                </form>
                @endif
            </div>

            <div class="table-scroll-wrapper">
                <table class="pengumuman-table">
                    <thead>
                        <tr>
                            <th style="width: 30px; text-align: center;">#</th>
                            <th>Judul Pengumuman</th>
                            <th>Kelas Target</th>
                            <th>Pembuat</th>
                            <th>Waktu Dihapus</th>
                            <th style="text-align: center; width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashPengumuman as $tIdx => $tRow)
                            @php
                                $tKelas = $tRow->kelas->nama_kelas ?? ($tRow->id_kelas ? 'Kelas #'.$tRow->id_kelas : 'Semua Kelas');
                                $tPembuat = $tRow->pembuat->nama_guru ?? 'Waka Kesiswaan';
                            @endphp
                            <tr>
                                <td style="text-align: center; font-weight: 700; color: #94a3b8;">{{ $tIdx + 1 }}</td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a;">{{ $tRow->judul }}</div>
                                    <div style="font-size: 11.5px; color: #64748b;">{{ Str::limit($tRow->isi ?? '', 50) }}</div>
                                </td>
                                <td>{{ $tKelas }}</td>
                                <td>{{ $tPembuat }}</td>
                                <td>
                                    <span style="font-size: 11.5px; color: #dc2626; font-weight: 700;">
                                        {{ $tRow->deleted_at ? \Carbon\Carbon::parse($tRow->deleted_at)->translatedFormat('d M Y H:i') : '-' }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <form action="{{ route('waka.pengumuman.restore', $tRow->id_pengumuman) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-action btn-emerald" style="padding: 5px 10px; font-size: 11.5px;" title="Pulihkan Pengumuman">
                                                <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                            </button>
                                        </form>
                                        <form action="{{ route('waka.pengumuman.force-delete', $tRow->id_pengumuman) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN pengumuman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-trash" style="padding: 5px 10px; font-size: 11.5px;" title="Hapus Permanen">
                                                <i class="fa-solid fa-xmark"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px 20px; color: #94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 28px; margin-bottom: 6px;"></i>
                                    <div style="font-weight: 700; color: #475569;">Kotak sampah pengumuman kosong.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-action btn-outline" onclick="closeTrashModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function toggleCustomJam(selectElem, wrapperId, inputId) {
        var wrapper = document.getElementById(wrapperId);
        var input = document.getElementById(inputId);
        if (selectElem.value === 'custom') {
            wrapper.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            wrapper.style.display = 'none';
            input.required = false;
        }
    }

    function openTambahModal() {
        document.getElementById('modalTambah').style.display = 'flex';
    }
    function closeTambahModal() {
        document.getElementById('modalTambah').style.display = 'none';
    }

    function openDetailModal(data, kelasNama, pembuatNama, tanggalFormatted) {
        document.getElementById('detJudul').innerText = data.judul || '-';
        document.getElementById('detKategori').innerText = data.kategori || 'Umum';
        
        var catClean = (data.kategori || 'Umum').replace(/[^a-zA-Z]/g, '');
        document.getElementById('detKategori').className = 'category-badge cat-' + catClean;

        var st = (data.status || 'aktif').toLowerCase();
        document.getElementById('detStatus').innerText = st.toUpperCase();
        document.getElementById('detStatus').className = 'badge-status status-' + st;

        document.getElementById('detKelas').innerText = kelasNama;
        document.getElementById('detJam').innerText = data.jam_mengajar || '-';
        document.getElementById('detPembuat').innerText = pembuatNama;
        document.getElementById('detTanggal').innerText = tanggalFormatted;
        document.getElementById('detKeterangan').innerText = data.keterangan || '-';
        document.getElementById('detIsi').innerText = data.isi || '-';

        document.getElementById('modalDetail').style.display = 'flex';
    }
    function closeDetailModal() {
        document.getElementById('modalDetail').style.display = 'none';
    }

    function openEditModal(data) {
        var form = document.getElementById('formEdit');
        form.action = '/waka/pengumuman/' + data.id_pengumuman;

        document.getElementById('editJudul').value = data.judul || '';
        document.getElementById('editKategori').value = data.kategori || 'Umum';
        document.getElementById('editKelas').value = data.id_kelas || '';
        document.getElementById('editStatus').value = (data.status || 'aktif').toLowerCase();
        document.getElementById('editTanggal').value = data.tanggal ? data.tanggal.substring(0, 10) : '';
        document.getElementById('editKeterangan').value = data.keterangan || '';
        document.getElementById('editIsi').value = data.isi || '';

        var editSelect = document.getElementById('editJamSelect');
        var editWrapper = document.getElementById('editJamCustomWrapper');
        var editCustomInput = document.getElementById('editJamCustomInput');

        var valJam = data.jam_mengajar || '';
        var found = false;
        for (var i = 0; i < editSelect.options.length; i++) {
            if (editSelect.options[i].value === valJam) {
                editSelect.selectedIndex = i;
                found = true;
                break;
            }
        }

        if (found) {
            editWrapper.style.display = 'none';
            editCustomInput.required = false;
            editCustomInput.value = '';
        } else if (valJam !== '') {
            editSelect.value = 'custom';
            editWrapper.style.display = 'block';
            editCustomInput.required = true;
            editCustomInput.value = valJam;
        } else {
            editSelect.selectedIndex = 0;
            editWrapper.style.display = 'none';
            editCustomInput.required = false;
            editCustomInput.value = '';
        }

        document.getElementById('modalEdit').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('modalEdit').style.display = 'none';
    }

    function openTrashModal() {
        document.getElementById('modalTrash').style.display = 'flex';
    }
    function closeTrashModal() {
        document.getElementById('modalTrash').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>
@endsection