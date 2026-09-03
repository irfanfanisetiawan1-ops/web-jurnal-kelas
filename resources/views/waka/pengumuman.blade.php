@extends('layouts.waka')

@section('title', 'Pengumuman Untuk Guru Mengajar — Waka')
@section('header_title', 'Pengumuman')

@section('styles')
<style>
    .pengumuman-container {
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

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        margin-bottom: 18px;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #2b3957;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-filter-dark:hover { background: #1e293b; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-trash-pink {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    .btn-add-pengumuman {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }
    .btn-add-pengumuman:hover { background: #059669; }

    .btn-trash-view {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-trash-view:hover {
        background: #ffe4e6;
        color: #be123c;
    }

    /* 3 Stat Cards Grid */
    .stat-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-gold   { background: #fef3c7; color: #d97706; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-link {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stat-link:hover { color: #2b3957; }

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

    /* Table Styling */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-pengumuman-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-pengumuman-table th {
        background: #dfd8c8;
        color: #1e293b;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #d1c9b6;
        border-bottom: 1px solid #d1c9b6;
    }

    .custom-pengumuman-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; text-align: center; }
    .custom-pengumuman-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; }

    .custom-pengumuman-table td {
        padding: 14px;
        color: #1e293b;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .announcement-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #1e293b;
    }

    .announcement-preview {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .badge-status-aktif {
        background: #d1fae5;
        color: #059669;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-selesai {
        background: #dbeafe;
        color: #2563eb;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-status-secondary {
        background: #fee2e2;
        color: #991b1b;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-block;
    }

    .btn-action-outline-pill {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-outline-pill:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
    }

    .btn-action-outline-pill.danger:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    .btn-action-outline-pill.success:hover {
        background: #10b981;
        color: #ffffff;
        border-color: #10b981;
    }

    /* Modal Form Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .modal-content {
        background: #ffffff;
        width: 100%;
        max-width: 620px;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content-large {
        max-width: 850px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 4px;
        display: block;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
    }

    .alert-success {
        background: #d1fae5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-danger {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    @media (max-width: 992px) {
        .stat-grid-3 { grid-template-columns: 1fr; }
        .filter-grid { flex-direction: column; align-items: stretch; }
        .form-row-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="pengumuman-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Pengumuman Untuk Guru Mengajar</h1>
            <p>Informasi pengumuman penting, catatan kegiatan, dan instruksi harian sekolah untuk seluruh guru mengajar</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. Stat Cards Grid (3 Cards) -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Pengumuman</span>
                    <span class="stat-val">{{ $stats['totalPengumuman'] }} Data</span>
                </div>
            </div>
            <a href="{{ route('waka.pengumuman') }}" class="stat-link">Lihat Semua</a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Aktif</span>
                    <span class="stat-val">{{ $stats['pengumumanAktif'] }} Pengumuman</span>
                </div>
            </div>
            <a href="{{ route('waka.pengumuman', ['status' => 'aktif']) }}" class="stat-link">Lihat Detail</a>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-gold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Pengumuman Selesai</span>
                    <span class="stat-val">{{ $stats['pengumumanSelesai'] }} Selesai</span>
                </div>
            </div>
            <a href="{{ route('waka.pengumuman', ['status' => 'selesai']) }}" class="stat-link">Lihat Detail</a>
        </div>
    </div>

    <!-- 2. Main Table Panel (Daftar Pengumuman) -->
    <div class="main-table-panel">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-list-check" style="color: #2b3957;"></i>
                <span>Daftar Pengumuman Sekolah</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-filter-dark" style="background: #10b981;" onclick="openAddPengumumanModal()">
                    <i class="fa-solid fa-plus"></i> Tambah Pengumuman
                </button>
                <button type="button" class="btn-trash-pink" onclick="openTrashModal()" title="Lihat Sampah Pengumuman">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashCount }})
                </button>
            </div>
        </div>

        <!-- Filter & Search Bar (Di Atas Tabel) -->
        <div class="filter-bar-container">
            <form action="{{ route('waka.pengumuman') }}" method="GET">
                <div style="flex: 1.5; min-width: 200px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input" placeholder="Cari Judul / Pengumuman / Kategori..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input" title="Filter Tanggal">
                </div>

                <div>
                    <select name="id_kelas" class="filter-input">
                        <option value="">Kelas: Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ (string)$idKelasFilter === (string)$k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="kategori" class="filter-input">
                        <option value="">Kategori: Semua</option>
                        <option value="Rapat" {{ $kategoriFilter === 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="Workshop" {{ $kategoriFilter === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="Kurikulum" {{ $kategoriFilter === 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                        <option value="Perubahan Jadwal" {{ $kategoriFilter === 'Perubahan Jadwal' ? 'selected' : '' }}>Perubahan Jadwal</option>
                        <option value="Penugasan" {{ $kategoriFilter === 'Penugasan' ? 'selected' : '' }}>Penugasan</option>
                        <option value="Umum" {{ $kategoriFilter === 'Umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>

                <div>
                    <select name="status" class="filter-input">
                        <option value="">Status: Semua Status</option>
                        <option value="aktif" {{ strtolower($statusFilter) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ strtolower($statusFilter) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="arsip" {{ strtolower($statusFilter) === 'arsip' ? 'selected' : '' }}>Arsip</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <a href="{{ route('waka.pengumuman') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <div class="table-container">
            <table class="custom-pengumuman-table">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 50px;">No</th>
                        <th>Judul & Isi Pengumuman</th>
                        <th>Kelas Target</th>
                        <th>Jam Mengajar</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pembuat / Tanggal</th>
                        <th style="text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumanList as $index => $row)
                        @php
                            $stTeks = ucfirst($row->status ?? 'aktif');
                            $stClass = 'badge-status-aktif';
                            if (strtolower($row->status) === 'selesai') $stClass = 'badge-status-selesai';
                            elseif (strtolower($row->status) === 'arsip') $stClass = 'badge-status-secondary';
                            
                            $kelasNama = $row->kelas->nama_kelas ?? ($row->id_kelas ? 'Kelas #'.$row->id_kelas : 'Semua Kelas');
                            $pembuatNama = $row->pembuat->nama_guru ?? 'Waka Kurikulum';
                            $tanggalFormated = \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y');
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $index + 1 }}</td>
                            <td>
                                <div class="announcement-title">
                                    <span style="font-size: 11px; background: #e2e8f0; color: #475569; padding: 2px 6px; border-radius: 4px; margin-right: 4px;">{{ $row->kategori ?? 'Umum' }}</span>
                                    {{ $row->judul }}
                                </div>
                                <div class="announcement-preview">{{ Str::limit($row->isi ?? '', 70) }}</div>
                            </td>
                            <td><i class="fa-solid fa-users" style="color: #94a3b8; font-size: 11px; margin-right: 4px;"></i> {{ $kelasNama }}</td>
                            <td><i class="fa-regular fa-clock" style="color: #94a3b8; font-size: 11px; margin-right: 4px;"></i> {{ $row->jam_mengajar ?? '-' }}</td>
                            <td>
                                <span class="{{ $stClass }}">{{ $stTeks }}</span>
                            </td>
                            <td>{{ $row->keterangan ?? '-' }}</td>
                            <td>
                                <div style="font-size: 12px; font-weight: 700; color: #334155;">{{ $pembuatNama }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">{{ $tanggalFormated }}</div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <!-- Detail Button -->
                                    <button type="button" class="btn-action-outline-pill" 
                                            onclick='openDetailModal(@json($row), "{{ addslashes($kelasNama) }}", "{{ addslashes($pembuatNama) }}", "{{ $tanggalFormated }}")' 
                                            title="Detail Pengumuman">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Edit Button -->
                                    <button type="button" class="btn-action-outline-pill" 
                                            onclick='openEditModal(@json($row))' 
                                            title="Edit Pengumuman">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- Soft Delete Form -->
                                    <form action="{{ route('waka.pengumuman.destroy', $row->id_pengumuman) }}" method="POST" onsubmit="return confirm('Pindahkan pengumuman ini ke sampah?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-outline-pill danger" title="Hapus (Soft Delete)">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 24px;">Belum ada pengumuman yang sesuai kriteria pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- 1. Modal Tambah Pengumuman Baru -->
<div id="addPengumumanModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-plus-circle" style="color: #2b3957;"></i> Tambah Pengumuman Baru</h4>
            <button type="button" onclick="closeAddPengumumanModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('waka.pengumuman.store') }}" method="POST" onsubmit="return validateAddForm(this)">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Pengumuman <span style="color: #ef4444;">*</span></label>
                <input type="text" name="judul" placeholder="e.g. Rapat Evaluasi Akhir Semester" class="form-input" required>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
                    <select name="kategori" class="form-select" required>
                        <option value="Umum">Umum</option>
                        <option value="Rapat">Rapat</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Kurikulum">Kurikulum</option>
                        <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                        <option value="Penugasan">Penugasan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas Target <span style="color: #ef4444;">*</span></label>
                    <select name="id_kelas" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Pilihan Jam / Waktu Mengajar <span style="color: #ef4444;">*</span></label>
                    <select name="jam_mengajar_select" id="addJamSelect" class="form-select" onchange="handleJamSelectChange(this, 'addJamCustomWrapper', 'addJamCustomInput')" required>
                        <option value="">-- Pilih Dari Jadwal Pelajaran --</option>
                        <option value="07.00 - 08.30">07.00 - 08.30 (Jam Ke 1 - 2)</option>
                        <option value="08.00 - 09.30">08.00 - 09.30 (Jam Ke 2 - 3)</option>
                        <option value="09.30 - 10.30">09.30 - 10.30 (Jam Ke 4 - 5)</option>
                        <option value="10.30 - 12.00">10.30 - 12.00 (Jam Ke 6 - 7)</option>
                        <option value="12.30 - 14.00">12.30 - 14.00 (Jam Ke 8 - 9)</option>
                        @foreach($jamPelajaranList as $jp)
                            @php $wkt = $jp->waktu_senin_kamis; @endphp
                            @if($wkt !== '-' && !in_array($wkt, ['07.00 - 08.30','08.00 - 09.30','09.30 - 10.30','10.30 - 12.00','12.30 - 14.00']))
                                <option value="{{ $wkt }}">{{ $wkt }} (Jam Ke {{ $jp->jam_ke }})</option>
                            @endif
                        @endforeach
                        <option value="custom">-- Tulis Waktu Kustom / Manual --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color: #ef4444;">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="aktif">Aktif (Aktif Di Portal Guru & Notifikasi Badge)</option>
                        <option value="selesai">Selesai (Pengumuman Berakhir / Selesai)</option>
                        <option value="arsip">Arsip (Diarsipkan Ke Rekam Medis / Database)</option>
                    </select>
                    <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">
                        <i class="fa-solid fa-circle-info"></i> <strong>Aktif:</strong> Kirim ke Guru & Notifikasi. <strong>Selesai:</strong> Kegiatan Berakhir. <strong>Arsip:</strong> Arsipkan.
                    </small>
                </div>
            </div>

            <!-- Field Kustom Jam Waktu -->
            <div class="form-group" id="addJamCustomWrapper" style="display: none; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; margin-top: 6px; margin-bottom: 14px;">
                <label class="form-label" style="font-weight: 800; color: #2b3957; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-regular fa-clock"></i> Atur Waktu Kustom (Pilih Jam atau Tulis Teks Manual) <span style="color: #ef4444;">*</span>
                </label>

                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 120px;">
                        <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Jam Mulai</span>
                        <input type="time" id="addJamMulaiPicker" class="form-input" onchange="syncJamTimePicker('addJamMulaiPicker', 'addJamSelesaiPicker', 'addJamCustomInput')">
                    </div>
                    <span style="font-weight: 800; color: #64748b; margin-top: 14px;">s/d</span>
                    <div style="flex: 1; min-width: 120px;">
                        <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Jam Selesai</span>
                        <input type="time" id="addJamSelesaiPicker" class="form-input" onchange="syncJamTimePicker('addJamMulaiPicker', 'addJamSelesaiPicker', 'addJamCustomInput')">
                    </div>
                </div>

                <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Waktu Kustom / Keterangan Jam:</span>
                <input type="text" name="jam_mengajar_custom" id="addJamCustomInput" placeholder="e.g. 07.30 - 09.00 WIB" class="form-input">
            </div>
            <input type="hidden" name="jam_mengajar" id="addJamMengajarFinal">

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Berlaku <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal" value="{{ $todayDate }}" min="{{ $todayDate }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Catatan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="keterangan" placeholder="e.g. Sakit / Urusan Keluarga / Oleh: Bagas P." class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Isi Pengumuman <span style="color: #ef4444;">*</span></label>
                <textarea name="isi" rows="4" placeholder="Tuliskan isi pengumuman secara lengkap..." class="form-textarea" required></textarea>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAddPengumumanModal()" class="btn-action-outline-pill" style="width: auto; padding: 8px 18px;">Batal</button>
                <button type="submit" class="btn-add-pengumuman">Simpan Pengumuman</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Detail Pengumuman -->
<div id="detailPengumumanModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-circle-info" style="color: #2b3957;"></i> Detail Pengumuman</h4>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div>
                <span id="detailKategori" style="font-size: 11px; background: #e2e8f0; color: #475569; padding: 3px 8px; border-radius: 6px; font-weight: 800;"></span>
                <span id="detailStatus" style="margin-left: 6px;"></span>
                <h3 id="detailJudul" style="font-size: 18px; font-weight: 800; color: #1e293b; margin-top: 8px; margin-bottom: 4px;"></h3>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px;">
                <div><strong>Kelas Target:</strong> <span id="detailKelas"></span></div>
                <div><strong>Jam Mengajar:</strong> <span id="detailJam"></span></div>
                <div><strong>Pembuat:</strong> <span id="detailPembuat"></span></div>
                <div><strong>Tanggal:</strong> <span id="detailTanggal"></span></div>
                <div style="grid-column: span 2;"><strong>Keterangan:</strong> <span id="detailKeterangan"></span></div>
            </div>

            <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 16px; font-size: 13.5px; line-height: 1.6; color: #334155; white-space: pre-line;" id="detailIsi">
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeDetailModal()" class="btn-action-outline-pill" style="width: auto; padding: 8px 20px;">Tutup</button>
        </div>
    </div>
</div>

<!-- 3. Modal Edit Pengumuman -->
<div id="editPengumumanModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-pen-to-square" style="color: #2b3957;"></i> Edit Pengumuman</h4>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form id="editPengumumanForm" action="" method="POST" onsubmit="return validateEditForm(this)">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Pengumuman <span style="color: #ef4444;">*</span></label>
                <input type="text" name="judul" id="editJudul" class="form-input" required>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
                    <select name="kategori" id="editKategoriSelect" class="form-select" required>
                        <option value="Umum">Umum</option>
                        <option value="Rapat">Rapat</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Kurikulum">Kurikulum</option>
                        <option value="Perubahan Jadwal">Perubahan Jadwal</option>
                        <option value="Penugasan">Penugasan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas Target <span style="color: #ef4444;">*</span></label>
                    <select name="id_kelas" id="editKelasSelect" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Pilihan Jam / Waktu Mengajar <span style="color: #ef4444;">*</span></label>
                    <select name="jam_mengajar_select" id="editJamSelect" class="form-select" onchange="handleJamSelectChange(this, 'editJamCustomWrapper', 'editJamCustomInput')" required>
                        <option value="">-- Pilih Dari Jadwal Pelajaran --</option>
                        <option value="07.00 - 08.30">07.00 - 08.30 (Jam Ke 1 - 2)</option>
                        <option value="08.00 - 09.30">08.00 - 09.30 (Jam Ke 2 - 3)</option>
                        <option value="09.30 - 10.30">09.30 - 10.30 (Jam Ke 4 - 5)</option>
                        <option value="10.30 - 12.00">10.30 - 12.00 (Jam Ke 6 - 7)</option>
                        <option value="12.30 - 14.00">12.30 - 14.00 (Jam Ke 8 - 9)</option>
                        @foreach($jamPelajaranList as $jp)
                            @php $wkt = $jp->waktu_senin_kamis; @endphp
                            @if($wkt !== '-' && !in_array($wkt, ['07.00 - 08.30','08.00 - 09.30','09.30 - 10.30','10.30 - 12.00','12.30 - 14.00']))
                                <option value="{{ $wkt }}">{{ $wkt }} (Jam Ke {{ $jp->jam_ke }})</option>
                            @endif
                        @endforeach
                        <option value="custom">-- Tulis Waktu Kustom / Manual --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color: #ef4444;">*</span></label>
                    <select name="status" id="editStatusSelect" class="form-select" required>
                        <option value="aktif">Aktif (Aktif Di Portal Guru & Notifikasi Badge)</option>
                        <option value="selesai">Selesai (Pengumuman Berakhir / Selesai)</option>
                        <option value="arsip">Arsip (Diarsipkan Ke Rekam Medis / Database)</option>
                    </select>
                    <small style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">
                        <i class="fa-solid fa-circle-info"></i> <strong>Aktif:</strong> Kirim ke Guru & Notifikasi. <strong>Selesai:</strong> Kegiatan Berakhir. <strong>Arsip:</strong> Arsipkan.
                    </small>
                </div>
            </div>

            <!-- Field Kustom Jam Waktu (Edit) -->
            <div class="form-group" id="editJamCustomWrapper" style="display: none; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px; padding: 14px; margin-top: 6px; margin-bottom: 14px;">
                <label class="form-label" style="font-weight: 800; color: #2b3957; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-regular fa-clock"></i> Atur Waktu Kustom (Pilih Jam atau Tulis Teks Manual) <span style="color: #ef4444;">*</span>
                </label>

                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 120px;">
                        <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Jam Mulai</span>
                        <input type="time" id="editJamMulaiPicker" class="form-input" onchange="syncJamTimePicker('editJamMulaiPicker', 'editJamSelesaiPicker', 'editJamCustomInput')">
                    </div>
                    <span style="font-weight: 800; color: #64748b; margin-top: 14px;">s/d</span>
                    <div style="flex: 1; min-width: 120px;">
                        <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Jam Selesai</span>
                        <input type="time" id="editJamSelesaiPicker" class="form-input" onchange="syncJamTimePicker('editJamMulaiPicker', 'editJamSelesaiPicker', 'editJamCustomInput')">
                    </div>
                </div>

                <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block; margin-bottom: 3px;">Waktu Kustom / Keterangan Jam:</span>
                <input type="text" name="jam_mengajar_custom" id="editJamCustomInput" placeholder="e.g. 07.30 - 09.00 WIB" class="form-input">
            </div>
            <input type="hidden" name="jam_mengajar" id="editJamMengajarFinal">

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Tanggal Berlaku <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal" id="editTanggal" min="{{ $todayDate }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Catatan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="keterangan" id="editKeterangan" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Isi Pengumuman <span style="color: #ef4444;">*</span></label>
                <textarea name="isi" id="editIsi" rows="4" class="form-textarea" required></textarea>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditModal()" class="btn-action-outline-pill" style="width: auto; padding: 8px 18px;">Batal</button>
                <button type="submit" class="btn-add-pengumuman">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Modal Sampah / Soft Delete -->
<div id="trashPengumumanModal" class="modal-overlay">
    <div class="modal-content modal-content-large">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa-solid fa-trash-can" style="color: #e11d48;"></i> Sampah Pengumuman (Terhapus Sementara)</h4>
            <button type="button" onclick="closeTrashModal()" style="background: none; border: none; font-size: 18px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <p style="font-size: 12.5px; color: #64748b; margin: 0;">Pengumuman yang dihapus dapat dipulihkan kembali atau dihapus permanen.</p>
            @if($trashCount > 0)
                <form action="{{ route('waka.pengumuman.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh sampah pengumuman? Data yang dihapus permanen tidak dapat dikembalikan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-trash-pink" style="font-size: 12px; padding: 6px 12px;">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>

        <div class="table-container">
            <table class="custom-pengumuman-table">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 40px;">No</th>
                        <th>Judul & Isi Pengumuman</th>
                        <th>Kelas Target</th>
                        <th>Pembuat</th>
                        <th>Dihapus Pada</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashPengumuman as $tIdx => $tRow)
                        @php
                            $tKelasNama = $tRow->kelas->nama_kelas ?? ($tRow->id_kelas ? 'Kelas #'.$tRow->id_kelas : 'Semua Kelas');
                            $tPembuat = $tRow->pembuat->nama_guru ?? 'Waka Kurikulum';
                            $tDeletedAt = \Carbon\Carbon::parse($tRow->deleted_at)->translatedFormat('d M Y H:i');
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $tIdx + 1 }}</td>
                            <td>
                                <div class="announcement-title">{{ $tRow->judul }}</div>
                                <div class="announcement-preview">{{ Str::limit($tRow->isi ?? '', 60) }}</div>
                            </td>
                            <td>{{ $tKelasNama }}</td>
                            <td>{{ $tPembuat }}</td>
                            <td><span style="font-size: 11.5px; color: #ef4444; font-weight: 700;">{{ $tDeletedAt }}</span></td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <!-- Restore Form -->
                                    <form action="{{ route('waka.pengumuman.restore', $tRow->id_pengumuman) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action-outline-pill success" title="Pulihkan Pengumuman">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </form>

                                    <!-- Force Delete Form -->
                                    <form action="{{ route('waka.pengumuman.force-delete', $tRow->id_pengumuman) }}" method="POST" onsubmit="return confirm('Hapus permanen pengumuman ini? Data tidak dapat dikembalikan.');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-outline-pill danger" title="Hapus Permanen">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada sampah pengumuman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeTrashModal()" class="btn-action-outline-pill" style="width: auto; padding: 8px 20px;">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function handleJamSelectChange(selectElem, wrapperId, inputId) {
        var wrapper = document.getElementById(wrapperId);
        var input = document.getElementById(inputId);
        if (selectElem.value === 'custom') {
            wrapper.style.display = 'block';
            input.required = true;
        } else {
            wrapper.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }

    function syncJamTimePicker(mulaiId, selesaiId, targetInputId) {
        var mulaiVal = document.getElementById(mulaiId).value;
        var selesaiVal = document.getElementById(selesaiId).value;
        var targetInput = document.getElementById(targetInputId);

        if (mulaiVal && selesaiVal) {
            var mF = mulaiVal.replace(':', '.');
            var sF = selesaiVal.replace(':', '.');
            targetInput.value = mF + ' - ' + sF + ' WIB';
        } else if (mulaiVal) {
            var mF = mulaiVal.replace(':', '.');
            targetInput.value = mF + ' WIB';
        } else if (selesaiVal) {
            var sF = selesaiVal.replace(':', '.');
            targetInput.value = 's/d ' + sF + ' WIB';
        }
    }

    function openAddPengumumanModal() {
        document.getElementById('addPengumumanModal').style.display = 'flex';
    }

    function closeAddPengumumanModal() {
        document.getElementById('addPengumumanModal').style.display = 'none';
    }

    function validateAddForm(form) {
        var judul = form.elements['judul'].value.trim();
        var kategori = form.elements['kategori'].value;
        var jamSelect = document.getElementById('addJamSelect').value;
        var jamCustom = document.getElementById('addJamCustomInput').value.trim();
        var finalHidden = document.getElementById('addJamMengajarFinal');
        var status = form.elements['status'].value;
        var tanggal = form.elements['tanggal'].value;
        var keterangan = form.elements['keterangan'].value.trim();
        var isi = form.elements['isi'].value.trim();
        var todayStr = '{{ $todayDate }}';

        if (!judul) { alert('Judul pengumuman wajib diisi!'); form.elements['judul'].focus(); return false; }
        if (!kategori) { alert('Kategori pengumuman wajib dipilih!'); form.elements['kategori'].focus(); return false; }
        if (!jamSelect) { alert('Pilihan jam / waktu mengajar wajib dipilih!'); document.getElementById('addJamSelect').focus(); return false; }
        if (jamSelect === 'custom') {
            if (!jamCustom) { alert('Silakan tuliskan Waktu Kustom / Keterangan Jam terlebih dahulu!'); document.getElementById('addJamCustomInput').focus(); return false; }
            finalHidden.value = jamCustom;
        } else {
            finalHidden.value = jamSelect;
        }
        if (!status) { alert('Status pengumuman wajib dipilih!'); form.elements['status'].focus(); return false; }
        if (!tanggal) { alert('Tanggal berlaku wajib diisi!'); form.elements['tanggal'].focus(); return false; }
        if (tanggal < todayStr) {
            alert('Tanggal berlaku tidak boleh sebelum tanggal hari ini (' + todayStr + ')!');
            form.elements['tanggal'].focus();
            return false;
        }
        if (!keterangan) { alert('Keterangan / Catatan wajib diisi!'); form.elements['keterangan'].focus(); return false; }
        if (!isi) { alert('Isi pengumuman wajib diisi!'); form.elements['isi'].focus(); return false; }

        return true;
    }

    function openDetailModal(data, kelasNama, pembuatNama, tanggalFormated) {
        document.getElementById('detailJudul').innerText = data.judul || '-';
        document.getElementById('detailKategori').innerText = data.kategori || 'Umum';
        document.getElementById('detailStatus').innerHTML = '<span class="badge-status-' + (data.status ? data.status.toLowerCase() : 'aktif') + '">' + (data.status ? data.status.toUpperCase() : 'AKTIF') + '</span>';
        document.getElementById('detailKelas').innerText = kelasNama;
        document.getElementById('detailJam').innerText = data.jam_mengajar || '-';
        document.getElementById('detailPembuat').innerText = pembuatNama;
        document.getElementById('detailTanggal').innerText = tanggalFormated;
        document.getElementById('detailKeterangan').innerText = data.keterangan || '-';
        document.getElementById('detailIsi').innerText = data.isi || '-';

        document.getElementById('detailPengumumanModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailPengumumanModal').style.display = 'none';
    }

    function openEditModal(data) {
        var form = document.getElementById('editPengumumanForm');
        form.action = "{{ url('/waka/pengumuman') }}/" + data.id_pengumuman;

        document.getElementById('editJudul').value = data.judul || '';
        document.getElementById('editKategoriSelect').value = data.kategori || 'Umum';
        document.getElementById('editKelasSelect').value = data.id_kelas || '';
        document.getElementById('editStatusSelect').value = (data.status || 'aktif').toLowerCase();
        document.getElementById('editTanggal').value = data.tanggal ? data.tanggal.substring(0, 10) : '';
        document.getElementById('editKeterangan').value = data.keterangan || '';
        document.getElementById('editIsi').value = data.isi || '';

        var editSelect = document.getElementById('editJamSelect');
        var editWrapper = document.getElementById('editJamCustomWrapper');
        var editCustomInput = document.getElementById('editJamCustomInput');

        var valJam = data.jam_mengajar || '';
        var optionExists = false;
        for (var i = 0; i < editSelect.options.length; i++) {
            if (editSelect.options[i].value === valJam) {
                optionExists = true;
                break;
            }
        }

        if (optionExists && valJam !== '') {
            editSelect.value = valJam;
            editWrapper.style.display = 'none';
            editCustomInput.value = '';
        } else if (valJam !== '') {
            editSelect.value = 'custom';
            editWrapper.style.display = 'block';
            editCustomInput.value = valJam;
        } else {
            editSelect.value = '';
            editWrapper.style.display = 'none';
            editCustomInput.value = '';
        }

        document.getElementById('editPengumumanModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editPengumumanModal').style.display = 'none';
    }

    function validateEditForm(form) {
        var judul = document.getElementById('editJudul').value.trim();
        var kategori = document.getElementById('editKategoriSelect').value;
        var jamSelect = document.getElementById('editJamSelect').value;
        var jamCustom = document.getElementById('editJamCustomInput').value.trim();
        var finalHidden = document.getElementById('editJamMengajarFinal');
        var status = document.getElementById('editStatusSelect').value;
        var tanggal = document.getElementById('editTanggal').value;
        var keterangan = document.getElementById('editKeterangan').value.trim();
        var isi = document.getElementById('editIsi').value.trim();
        var todayStr = '{{ $todayDate }}';

        if (!judul) { alert('Judul pengumuman wajib diisi!'); document.getElementById('editJudul').focus(); return false; }
        if (!kategori) { alert('Kategori pengumuman wajib dipilih!'); document.getElementById('editKategoriSelect').focus(); return false; }
        if (!jamSelect) { alert('Pilihan jam / waktu mengajar wajib dipilih!'); document.getElementById('editJamSelect').focus(); return false; }
        if (jamSelect === 'custom') {
            if (!jamCustom) { alert('Silakan tuliskan Waktu Kustom / Keterangan Jam terlebih dahulu!'); document.getElementById('editJamCustomInput').focus(); return false; }
            finalHidden.value = jamCustom;
        } else {
            finalHidden.value = jamSelect;
        }
        if (!status) { alert('Status pengumuman wajib dipilih!'); document.getElementById('editStatusSelect').focus(); return false; }
        if (!tanggal) { alert('Tanggal berlaku wajib diisi!'); document.getElementById('editTanggal').focus(); return false; }
        if (tanggal < todayStr) {
            alert('Tanggal berlaku tidak boleh sebelum tanggal hari ini (' + todayStr + ')!');
            document.getElementById('editTanggal').focus();
            return false;
        }
        if (!keterangan) { alert('Keterangan / Catatan wajib diisi!'); document.getElementById('editKeterangan').focus(); return false; }
        if (!isi) { alert('Isi pengumuman wajib diisi!'); document.getElementById('editIsi').focus(); return false; }

        return true;
    }

    function openTrashModal() {
        document.getElementById('trashPengumumanModal').style.display = 'flex';
    }

    function closeTrashModal() {
        document.getElementById('trashPengumumanModal').style.display = 'none';
    }

    // Close Modals when clicking outside content
    window.onclick = function(event) {
        var addM = document.getElementById('addPengumumanModal');
        var detailM = document.getElementById('detailPengumumanModal');
        var editM = document.getElementById('editPengumumanModal');
        var trashM = document.getElementById('trashPengumumanModal');

        if (event.target === addM) closeAddPengumumanModal();
        if (event.target === detailM) closeDetailModal();
        if (event.target === editM) closeEditModal();
        if (event.target === trashM) closeTrashModal();
    }
</script>
@endsection
