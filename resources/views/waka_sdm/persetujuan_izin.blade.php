@extends('layouts.waka_sdm')

@section('title', 'Persetujuan Izin Guru — EduJournal')
@section('page-header', 'Persetujuan Izin Guru')
@section('page-subheader', 'Kelola, verifikasi, dan pantau pengajuan izin serta cuti pendidik terhubung dengan Guru Piket dan TU')

@section('styles')
<style>
    :root {
        --slate-dark: #1e293b;
        --slate-medium: #334155;
        --slate-light: #475569;
        --slate-muted: #64748b;
        --gray-bg: #f8fafc;
        --gray-surface: #f1f5f9;
        --gray-border: #e2e8f0;
        --gray-border-subtle: #cbd5e1;
        --primary-blue: #2563eb;
        --primary-blue-dark: #1d4ed8;
    }

    /* Top Summary Metric Cards (Gray & Blue & Light Gray) */
    .sdm-metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .sdm-metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease, border-color 0.2s;
    }

    .sdm-metric-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }

    .sdm-metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .sdm-metric-icon.slate { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
    .sdm-metric-icon.amber { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .sdm-metric-icon.blue  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .sdm-metric-icon.purple{ background: #faf5ff; color: #9333ea; border: 1px solid #f3e8ff; }

    .sdm-metric-info h4 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.1;
    }

    .sdm-metric-info p {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin: 4px 0 0 0;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
    }

    .filter-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .form-input-sm {
        padding: 8px 13px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12.5px;
        font-family: inherit;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s;
    }

    .form-input-sm:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Status Navigation Tabs */
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .tab-item {
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
    }

    .tab-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .tab-item.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
        box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
    }

    .tab-item .badge-count {
        background: #e2e8f0;
        color: #334155;
        padding: 2px 7px;
        border-radius: 12px;
        font-size: 10.5px;
        font-weight: 800;
    }

    .tab-item.active .badge-count {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    /* Main Table Container (No Horizontal Scrollbar on Standard Displays) */
    .main-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 0;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.02);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 13px 14px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 13px 14px;
        font-size: 12.5px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge {
        padding: 4px 9px;
        border-radius: 16px;
        font-size: 10.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        line-height: 1.2;
    }

    .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-approved { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-rejected { background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; }
    .badge-process { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .badge-final-approved { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border: 1px solid #1d4ed8; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.22); }
    .badge-slate { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }

    /* Compact Multi-Tier Approval Matrix */
    .approval-matrix {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .matrix-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
    }

    .matrix-label {
        width: 54px;
        color: #64748b;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
    }

    /* Action Buttons */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .btn-action {
        padding: 6px 11px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
        line-height: 1.2;
        white-space: nowrap;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .btn-approve {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        border: 1px solid #1d4ed8;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.25);
    }
    .btn-approve:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
        transform: translateY(-1.5px);
    }

    .btn-reject {
        background: #ffffff;
        color: #e11d48;
        border: 1.5px solid #fecdd3;
        box-shadow: 0 1px 3px rgba(225, 29, 72, 0.08);
    }
    .btn-reject:hover {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fda4af;
        transform: translateY(-1.5px);
    }

    .btn-detail-sm {
        background: #f8fafc;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .btn-detail-sm:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
        transform: translateY(-1.5px);
    }

    .btn-delete-soft {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .btn-delete-soft:hover {
        background: #fee2e2;
        color: #991b1b;
        transform: translateY(-1.5px);
    }

    .pagination-wrapper {
        padding: 16px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    /* Modal Styling */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 90%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.95);
        transition: transform 0.25s ease;
    }

    .modal-backdrop.active .modal-card {
        transform: scale(1);
    }

    .modal-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modal-body {
        padding: 22px 24px;
    }

    .modal-footer {
        padding: 14px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-radius: 0 0 20px 20px;
    }

    .btn-secondary {
        padding: 8px 16px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .info-label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .info-val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    @media (max-width: 1000px) {
        .sdm-metric-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .sdm-metric-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Top Summary Metric Cards -->
<div class="sdm-metric-grid">
    <div class="sdm-metric-card">
        <div class="sdm-metric-icon slate">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <div class="sdm-metric-info">
            <h4>{{ $totalPengajuan }}</h4>
            <p>Total Permohonan Izin</p>
        </div>
    </div>

    <div class="sdm-metric-card">
        <div class="sdm-metric-icon amber">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div class="sdm-metric-info">
            <h4>{{ $countPending }}</h4>
            <p>Menunggu Waka SDM</p>
        </div>
    </div>

    <div class="sdm-metric-card">
        <div class="sdm-metric-icon blue">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="sdm-metric-info">
            <h4>{{ $countDisetujuiResmi }}</h4>
            <p>Disetujui Resmi (Final)</p>
        </div>
    </div>

    <div class="sdm-metric-card">
        <div class="sdm-metric-icon purple">
            <i class="fa-solid fa-user-clock"></i>
        </div>
        <div class="sdm-metric-info">
            <h4>{{ $countIzinHariIni }}</h4>
            <p>Guru Izin Hari Ini</p>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="filter-card">
    <form action="{{ route('waka-sdm.persetujuan-izin') }}" method="GET" class="filter-form">
        <input type="hidden" name="status" value="{{ $filterStatus }}">

        <div class="filter-group">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama guru, NIP, mapel, alasan..." class="form-input-sm" style="width: 260px;">

            <select name="kategori" class="form-input-sm">
                <option value="all" {{ $kategori === 'all' || !$kategori ? 'selected' : '' }}>-- Semua Kategori Izin --</option>
                <option value="biasa" {{ $kategori === 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="cuti" {{ $kategori === 'cuti' ? 'selected' : '' }}>Cuti / Izin Khusus</option>
                <option value="dinas" {{ $kategori === 'dinas' ? 'selected' : '' }}>Tugas Dinas</option>
                <option value="sakit" {{ $kategori === 'sakit' ? 'selected' : '' }}>Sakit</option>
            </select>

            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-input-sm" title="Filter Tanggal Izin">

            <button type="submit" class="btn-action" style="background: #2563eb; color: #ffffff; padding: 8px 14px;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari & Filter
            </button>

            @if($search || ($kategori && $kategori !== 'all') || $tanggal)
                <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => $filterStatus]) }}" class="btn-action" style="background: #64748b; color: #ffffff; padding: 8px 12px;" title="Reset Pencarian & Filter">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </div>

        <div class="filter-group">
            <button type="button" id="btnBatchDelete" onclick="submitBatchDelete()" class="btn-action btn-reject" disabled style="opacity: 0.6; cursor: not-allowed; padding: 8px 14px;">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>

            <a href="{{ route('waka-sdm.izin.trash') }}" class="btn-action" style="background: #334155; color: #ffffff; padding: 8px 14px;" title="Lihat Fitur Sampah">
                <i class="fa-solid fa-trash-arrow-up"></i> Fitur Sampah ({{ $trashedCount }})
            </a>
        </div>
    </form>
</div>

<!-- Filter Status Tabs -->
<div class="filter-tabs">
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'all', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'all' ? 'active' : '' }}">
        <i class="fa-solid fa-list"></i>
        <span>Semua Pengajuan</span>
        <span class="badge-count">{{ $totalPengajuan }}</span>
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'pending', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'pending' ? 'active' : '' }}">
        <i class="fa-solid fa-hourglass-half"></i>
        <span>Menunggu Waka SDM</span>
        <span class="badge-count">{{ $countPending }}</span>
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'approved', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'approved' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-check"></i>
        <span>Disetujui SDM</span>
        <span class="badge-count">{{ $countApproved }}</span>
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'rejected', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'rejected' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-xmark"></i>
        <span>Ditolak SDM</span>
        <span class="badge-count">{{ $countRejected }}</span>
    </a>
</div>

<!-- Main Table Card (No Horizontal Overflow) -->
<div class="main-table-card">
    <form id="formBatchDelete" action="{{ route('waka-sdm.izin.batch-delete') }}" method="POST">
        @csrf
        <div style="width: 100%;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckboxes" onclick="toggleSelectAll(this)" style="cursor: pointer; width: 15px; height: 15px;" title="Pilih Semua">
                        </th>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th style="width: 25%;">Nama Pendidik & Mapel / NIP</th>
                        <th style="width: 20%;">Tanggal & Kategori</th>
                        <th style="width: 20%;">Alasan & Titipan</th>
                        <th style="width: 19%;">Persetujuan & Final</th>
                        <th style="width: 16%; text-align: center;">Aksi Waka SDM</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarIzin as $index => $izin)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" name="ids[]" value="{{ $izin->id_guru_izin }}" class="cb-izin-item" onchange="updateBatchDeleteButton()" style="cursor: pointer; width: 15px; height: 15px;">
                            </td>
                            <td style="text-align: center; color: #64748b; font-weight: 700;">
                                {{ $daftarIzin->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                    <span>NIP: {{ $izin->guru->nip ?? '-' }}</span>
                                    @if(optional($izin->guru)->mapel)
                                        <span> • {{ $izin->guru->mapel->nama_mapel }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    <i class="fa-solid fa-calendar-day" style="color: #94a3b8; font-size: 11px; margin-right: 3px;"></i>
                                    {{ $izin->tanggal_formatted }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px; margin-top: 4px;">
                                    <span class="badge badge-slate" style="text-transform: uppercase; font-size: 10px;">{{ $izin->kategori_izin ?? 'biasa' }}</span>
                                    <span style="font-size: 11px; color: #64748b;">{{ $izin->durasi_formatted }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b; font-size: 12.5px;">{{ Str::limit($izin->alasan, 45) }}</div>
                                @if($izin->materi_dititipkan)
                                    <div style="font-size: 11px; color: #2563eb; margin-top: 3px; font-weight: 600;">
                                        <i class="fa-solid fa-book-bookmark"></i> Ada Titipan Materi
                                    </div>
                                @endif
                                @if($izin->foto_surat)
                                    <div style="font-size: 10.5px; color: #059669; margin-top: 2px;">
                                        <i class="fa-solid fa-file-image"></i> Ada Lampiran Surat
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="approval-matrix">
                                    <div class="matrix-row">
                                        <span class="matrix-label">Kur:</span>
                                        @if($izin->status_waka === 'approved')
                                            <span class="badge badge-approved" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif($izin->status_waka === 'rejected')
                                            <span class="badge badge-rejected" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </div>
                                    <div class="matrix-row">
                                        <span class="matrix-label">SDM:</span>
                                        @if($izin->status_waka_sdm === 'approved')
                                            <span class="badge badge-approved" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif($izin->status_waka_sdm === 'rejected')
                                            <span class="badge badge-rejected" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </div>
                                    <div class="matrix-row">
                                        <span class="matrix-label">Kepsek:</span>
                                        @if($izin->status_kepsek === 'approved')
                                            <span class="badge badge-approved" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-check"></i> Approved</span>
                                        @elseif($izin->status_kepsek === 'rejected')
                                            <span class="badge badge-rejected" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-xmark"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-pending" style="padding: 2px 6px; font-size: 9.5px;"><i class="fa-solid fa-clock"></i> Pending</span>
                                        @endif
                                    </div>
                                    <div style="margin-top: 4px;">
                                        @php
                                            $isAllApproved = ($izin->status_waka === 'approved' && $izin->status_waka_sdm === 'approved' && $izin->status_kepsek === 'approved');
                                            $isAnyRejected = ($izin->status_waka === 'rejected' || $izin->status_waka_sdm === 'rejected' || $izin->status_kepsek === 'rejected' || $izin->status_final === 'rejected');
                                        @endphp
                                        @if($isAllApproved || $izin->status_final === 'approved')
                                            <span class="badge badge-final-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Resmi</span>
                                        @elseif($isAnyRejected)
                                            <span class="badge badge-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                        @else
                                            <span class="badge badge-process"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $sdmGiDetailData = [
                                        'nama_guru' => $izin->guru->nama_guru ?? 'Guru',
                                        'nip' => $izin->guru->nip ?? '-',
                                        'mapel' => optional($izin->guru)->mapel->nama_mapel ?? '-',
                                        'tanggal' => ($izin->tanggal_mulai === $izin->tanggal_selesai || !$izin->tanggal_selesai) ? \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-m-Y'),
                                        'durasi' => $izin->durasi_formatted ?? '1 Hari',
                                        'kategori_izin' => $izin->kategori_izin ?? 'biasa',
                                        'alasan' => $izin->alasan ?? '-',
                                        'keterangan_khusus' => $izin->keterangan_khusus ?? '-',
                                        'materi' => $izin->materi_dititipkan ?? '-',
                                        'file_tugas_url' => $izin->file_tugas ? asset('uploads/tugas_pengganti/' . $izin->file_tugas) : null,
                                        'foto_url' => $izin->foto_surat ? asset('uploads/guru_izin/' . $izin->foto_surat) : null,
                                        'status_waka' => ucfirst($izin->status_waka ?? 'pending'),
                                        'status_waka_sdm' => ucfirst($izin->status_waka_sdm ?? 'pending'),
                                        'status_kepsek' => ucfirst($izin->status_kepsek ?? 'pending'),
                                        'status_final' => ucfirst($izin->status_final ?? 'pending'),
                                        'catatan_waka' => $izin->catatan_waka ?? '-',
                                        'catatan_kepsek' => $izin->catatan_kepsek ?? '-',
                                    ];
                                @endphp
                                <div class="action-btn-group" style="justify-content: center;">
                                    <button type="button" class="btn-action btn-detail-sm" onclick='openDetailModal(@json($sdmGiDetailData))' title="Lihat Rincian Pengajuan">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    @if($izin->status_waka_sdm === 'pending')
                                        <button type="button" class="btn-action btn-approve" onclick="openApproveModal('{{ $izin->id_guru_izin }}', '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Setujui Pengajuan">
                                            <i class="fa-solid fa-check"></i> Setujui
                                        </button>
                                        <button type="button" class="btn-action btn-reject" onclick="openRejectModal('{{ $izin->id_guru_izin }}', '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Tolak Pengajuan">
                                            <i class="fa-solid fa-xmark"></i> Tolak
                                        </button>
                                    @endif

                                    <!-- Soft Delete Single -->
                                    <form action="{{ route('waka-sdm.izin.destroy', $izin->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Pindahkan data izin guru {{ $izin->guru->nama_guru ?? '' }} ke Sampah (Soft Delete)?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete-soft" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-inbox" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Tidak ada data pengajuan izin guru untuk kriteria filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    @if($daftarIzin->hasPages())
        <div class="pagination-wrapper">
            {{ $daftarIzin->links('partials.custom-pagination') }}
        </div>
    @endif
</div>

<!-- =========================================================================
     MODALS SECTION
     ========================================================================= -->

<!-- 1. Modal Setujui Izin Guru -->
<div id="approveModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-check-circle" style="color: #2563eb;"></i> Setujui Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <form id="approveForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 14px;">
                    Apakah Anda yakin ingin menyetujui pengajuan izin untuk guru: <strong id="approveGuruName" style="color: #0f172a;"></strong>?
                </p>
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">
                        Catatan Waka SDM (Opsional):
                    </label>
                    <textarea name="catatan" class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px;" placeholder="Contoh: Disetujui oleh Waka SDM. Koordinasikan materi dengan guru piket."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('approveModal')">Batal</button>
                <button type="submit" class="btn-action btn-approve" style="padding: 9px 20px; font-size: 13px;">
                    <i class="fa-solid fa-check"></i> Ya, Setujui Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Tolak Izin Guru -->
<div id="rejectModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-triangle-exclamation" style="color: #e11d48;"></i> Tolak Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p style="font-size: 13.5px; color: #334155; margin-bottom: 14px;">
                    Apakah Anda yakin ingin menolak pengajuan izin untuk guru: <strong id="rejectGuruName" style="color: #0f172a;"></strong>?
                </p>
                <div style="margin-bottom: 10px;">
                    <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">
                        Alasan Penolakan Waka SDM (Wajib):
                    </label>
                    <textarea name="catatan" required class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px;" placeholder="Contoh: Jadwal padat / materi ujian tidak dapat ditinggalkan."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('rejectModal')">Batal</button>
                <button type="submit" class="btn-action" style="padding: 9px 20px; font-size: 13px; background: #e11d48; color: #ffffff; border: 1px solid #be123c; box-shadow: 0 2px 6px rgba(225, 29, 72, 0.25);">
                    <i class="fa-solid fa-xmark"></i> Tolak Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Detail Izin Guru Lengkap -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 620px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-signature" style="color: #2563eb;"></i> Rincian Pengajuan Izin Guru</h3>
            <button type="button" class="modal-close" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="modal-body">
            <!-- Profil Guru -->
            <div style="background: #f8fafc; padding: 14px 16px; border-radius: 12px; margin-bottom: 14px; border: 1px solid #e2e8f0;">
                <div id="dt_nama_guru" style="font-size: 15px; font-weight: 800; color: #0f172a;"></div>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                    <span id="dt_nip"></span> • Mata Pelajaran: <span id="dt_mapel" style="font-weight: 700; color: #334155;"></span>
                </div>
            </div>

            <!-- Tanggal & Kategori -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <div class="info-label">Kategori Izin</div>
                    <div id="dt_kategori" class="info-val" style="text-transform: uppercase;"></div>
                </div>
                <div>
                    <div class="info-label">Durasi / Rentang</div>
                    <div id="dt_tanggal_durasi" class="info-val"></div>
                </div>
            </div>

            <!-- Alasan -->
            <div style="margin-bottom: 14px;">
                <div class="info-label">Alasan Izin</div>
                <div id="dt_alasan" style="font-size: 13px; color: #1e293b; background: #ffffff; border: 1px solid #e2e8f0; padding: 10px 12px; border-radius: 8px; margin-top: 4px; font-weight: 500;"></div>
            </div>

            <!-- Keterangan Khusus Cuti (Jika Ada) -->
            <div id="dt_ket_khusus_box" style="margin-bottom: 14px; display: none;">
                <div class="info-label" style="color: #c2410c;">Keterangan Khusus Cuti</div>
                <div id="dt_ket_khusus" style="font-size: 13px; color: #9a3412; background: #fff7ed; border: 1px solid #fed7aa; padding: 10px 12px; border-radius: 8px; margin-top: 4px; font-weight: 600;"></div>
            </div>

            <!-- Titipan Materi -->
            <div id="dt_materi_box" style="margin-bottom: 14px;">
                <div class="info-label">Materi / Tugas Dititipkan</div>
                <div id="dt_materi" style="font-size: 13px; color: #1e293b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 12px; border-radius: 8px; margin-top: 4px;"></div>
            </div>

            <!-- Lampiran Berkas Tugas & Foto Surat -->
            <div id="dt_berkas_box" style="margin-bottom: 14px; display: flex; flex-direction: column; gap: 8px;">
                <div id="dt_file_tugas_wrap" style="display: none;">
                    <div class="info-label">Berkas Tugas Titipan:</div>
                    <a id="dt_file_tugas_link" href="#" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #16a34a; font-weight: 700; text-decoration: none; margin-top: 2px;">
                        <i class="fa-solid fa-file-arrow-down"></i> Unduh Berkas Tugas Titipan &rarr;
                    </a>
                </div>
                <div id="dt_foto_wrap" style="display: none;">
                    <div class="info-label">Dokumen / Foto Surat Bukti:</div>
                    <div style="margin-top: 4px; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; text-align: center;">
                        <img id="dt_foto_img" src="" alt="Surat Izin" style="max-width: 100%; max-height: 220px; border-radius: 8px; object-fit: contain;">
                        <div style="margin-top: 6px;">
                            <a id="dt_foto_link" href="#" target="_blank" style="font-size: 12px; color: #2563eb; font-weight: 700; text-decoration: none;">
                                <i class="fa-solid fa-up-right-from-square"></i> Lihat Lampiran Surat Ukuran Penuh &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persetujuan Berjenjang -->
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                <div class="info-label">Status Persetujuan Berjenjang</div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 6px;">
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">WAKA KUR</div>
                        <div id="dt_st_waka" style="margin-top: 4px; font-size: 11px; font-weight: 800;"></div>
                    </div>
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">WAKA SDM</div>
                        <div id="dt_st_sdm" style="margin-top: 4px; font-size: 11px; font-weight: 800;"></div>
                    </div>
                    <div style="background: #f8fafc; padding: 8px 10px; border-radius: 8px; text-align: center; border: 1px solid #e2e8f0;">
                        <div style="font-size: 10.5px; color: #64748b; font-weight: 700;">KEPSEK</div>
                        <div id="dt_st_kepsek" style="margin-top: 4px; font-size: 11px; font-weight: 800;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('detailModal')">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal Handlers
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
        }
    }

    function openApproveModal(id, guruName) {
        document.getElementById('approveGuruName').innerText = guruName;
        document.getElementById('approveForm').action = "{{ url('waka-sdm/izin') }}/" + id + "/approve";
        openModal('approveModal');
    }

    function openRejectModal(id, guruName) {
        document.getElementById('rejectGuruName').innerText = guruName;
        document.getElementById('rejectForm').action = "{{ url('waka-sdm/izin') }}/" + id + "/reject";
        openModal('rejectModal');
    }

    function openDetailModal(data) {
        document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
        document.getElementById('dt_nip').innerText = 'NIP: ' + (data.nip || '-');
        document.getElementById('dt_mapel').innerText = data.mapel || '-';
        document.getElementById('dt_kategori').innerText = data.kategori_izin || 'biasa';
        document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari') + ')';
        document.getElementById('dt_alasan').innerText = data.alasan || '-';

        // Keterangan khusus cuti
        const ketKhususBox = document.getElementById('dt_ket_khusus_box');
        if (data.kategori_izin === 'cuti' && data.keterangan_khusus && data.keterangan_khusus !== '-') {
            document.getElementById('dt_ket_khusus').innerText = data.keterangan_khusus;
            ketKhususBox.style.display = 'block';
        } else {
            ketKhususBox.style.display = 'none';
        }

        // Materi / Tugas
        const materiBox = document.getElementById('dt_materi_box');
        if (data.materi && data.materi !== '-') {
            document.getElementById('dt_materi').innerText = data.materi;
            materiBox.style.display = 'block';
        } else {
            materiBox.style.display = 'none';
        }

        // File Tugas Link
        const fileTugasWrap = document.getElementById('dt_file_tugas_wrap');
        if (data.file_tugas_url) {
            document.getElementById('dt_file_tugas_link').href = data.file_tugas_url;
            fileTugasWrap.style.display = 'block';
        } else {
            fileTugasWrap.style.display = 'none';
        }

        // Foto Surat Preview
        const fotoWrap = document.getElementById('dt_foto_wrap');
        if (data.foto_url) {
            document.getElementById('dt_foto_img').src = data.foto_url;
            document.getElementById('dt_foto_link').href = data.foto_url;
            fotoWrap.style.display = 'block';
        } else {
            fotoWrap.style.display = 'none';
        }

        // Status Badges
        const renderBadge = (status) => {
            const st = (status || '').toLowerCase();
            if (st === 'approved' || st === 'disetujui') {
                return '<span class="badge badge-approved"><i class="fa-solid fa-check"></i> Approved</span>';
            } else if (st === 'rejected' || st === 'ditolak') {
                return '<span class="badge badge-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>';
            } else {
                return '<span class="badge badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>';
            }
        };

        document.getElementById('dt_st_waka').innerHTML = renderBadge(data.status_waka);
        document.getElementById('dt_st_sdm').innerHTML = renderBadge(data.status_waka_sdm);
        document.getElementById('dt_st_kepsek').innerHTML = renderBadge(data.status_kepsek);

        openModal('detailModal');
    }

    // Checkbox & Batch Delete Handlers
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.cb-izin-item');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBatchDeleteButton();
    }

    function updateBatchDeleteButton() {
        const checked = document.querySelectorAll('.cb-izin-item:checked');
        const btn = document.getElementById('btnBatchDelete');
        const countLabel = document.getElementById('selectedCount');
        
        countLabel.innerText = checked.length;
        if (checked.length > 0) {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        } else {
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
        }
    }

    function submitBatchDelete() {
        const checked = document.querySelectorAll('.cb-izin-item:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data yang ingin dihapus!');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data izin guru yang dipilih ke Sampah (Soft Delete)?')) {
            document.getElementById('formBatchDelete').submit();
        }
    }

    // Close on Backdrop Click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.classList.remove('active');
        }
    });
</script>
@endsection

