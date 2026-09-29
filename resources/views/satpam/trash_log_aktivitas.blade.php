@extends('layouts.guru')

@section('title', 'Sampah Log Aktivitas — Portal Satpam Jurnal SMEA')

@section('content')
<div class="log-aktivitas-page-wrapper">

    <!-- Header Page Title & Subtitle -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Sampah Log Aktivitas Satpam</h1>
            <p>{{ $formattedDate ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} &nbsp;•&nbsp; Daftar riwayat perizinan yang dipindahkan ke folder sampah</p>
        </div>
        <div class="header-right-nav">
            <a href="{{ route('satpam.log-aktivitas') }}" class="btn-nav-tab">
                <i class="fa-solid fa-clock-rotate-left"></i> Log Aktif
                @if(isset($activeCount) && $activeCount > 0)
                    <span class="badge-active-count">{{ $activeCount }}</span>
                @endif
            </a>
            <a href="{{ route('satpam.log-aktivitas.trash') }}" class="btn-nav-tab active btn-nav-trash-active">
                <i class="fa-solid fa-trash-can"></i> Sampah
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-trash-count">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Filter & Search Section Card -->
    <div class="dashboard-card filter-card" style="margin-bottom: 24px;">
        <form method="GET" action="{{ route('satpam.log-aktivitas.trash') }}" class="filter-form">
            <div class="filter-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari di Sampah (Kode Dispen / Nama Siswa / NISN)...">
            </div>

            <button type="submit" class="btn-filter-submit">
                <i class="fa-solid fa-filter"></i> Cari di Sampah
            </button>

            @if(request()->filled('q'))
                <a href="{{ route('satpam.log-aktivitas.trash') }}" class="btn-filter-reset">
                    <i class="fa-solid fa-rotate-left" style="margin-right: 4px;"></i> Reset
                </a>
            @endif

            @if($logs->total() > 0)
                <div style="margin-left: auto;">
                    <button type="button" class="btn-empty-trash" onclick="confirmEmptyTrash()">
                        <i class="fa-solid fa-dumpster-fire"></i> Kosongkan Sampah
                    </button>
                </div>
            @endif
        </form>
    </div>

    <!-- Bulk Action Toolbar (Appears when items checked) -->
    <div class="bulk-action-bar" id="bulkActionBar" style="display: none;">
        <div class="bulk-info">
            <i class="fa-solid fa-circle-check" style="color: #2563eb; font-size: 16px;"></i>
            <span><strong id="selectedCountText">0</strong> data sampah dipilih</span>
        </div>
        <div class="bulk-actions">
            <button type="button" class="btn-bulk-restore" onclick="confirmBulkRestore()">
                <i class="fa-solid fa-rotate-left"></i> Pulihkan Terpilih
            </button>
            <button type="button" class="btn-bulk-force" onclick="confirmBulkForceDelete()">
                <i class="fa-solid fa-trash-can"></i> Hapus Permanen Terpilih
            </button>
            <button type="button" class="btn-bulk-cancel" onclick="deselectAll()">
                <i class="fa-solid fa-xmark"></i> Batal
            </button>
        </div>
    </div>

    <!-- Main Card: Log Sampah -->
    <div class="dashboard-card activity-log-card">
        <div class="activity-log-header">
            <div>
                <h2 class="activity-log-title">Daftar Sampah Log Dispen</h2>
                <p class="activity-log-subtitle">
                    Menampilkan {{ min($logs->count(), 15) }} dari {{ $logs->total() }} data yang terhapus
                </p>
            </div>
            <div class="header-tools-group">
                @if($logs->count() > 0)
                    <label class="select-all-label">
                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                        <span>Pilih Semua</span>
                    </label>
                @endif
                <a href="{{ route('satpam.log-aktivitas.trash') }}" class="link-lihat-semua">
                    <i class="fa-solid fa-arrows-rotate"></i> Refresh
                </a>
            </div>
        </div>

        <form id="bulkRestoreForm" action="{{ route('satpam.log-aktivitas.bulk-restore') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="ids" id="bulkRestoreIds">
        </form>

        <form id="bulkForceDeleteForm" action="{{ route('satpam.log-aktivitas.bulk-force-delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="bulkForceIds">
        </form>

        <form id="emptyTrashForm" action="{{ route('satpam.log-aktivitas.empty-trash') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <form id="singleActionForm" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="_method" id="singleActionMethod" value="POST">
        </form>

        <div class="activity-list" id="trashList">
            @forelse($logs as $d)
                @php
                    $deletedTime = $d->deleted_at ? $d->deleted_at->translatedFormat('d M Y, H:i') : '-';
                @endphp

                <div class="activity-item" id="item-row-{{ $d->id_siswa_dispen }}">
                    <div class="item-checkbox-wrapper">
                        <input type="checkbox" class="row-checkbox custom-check" value="{{ $d->id_siswa_dispen }}" onchange="handleRowCheckboxChange()">
                    </div>

                    <div class="activity-icon-wrapper icon-trash-item">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>

                    <div class="activity-content-box">
                        <div class="activity-header-line">
                            <div class="student-info-left">
                                <h4 class="student-name">{{ $d->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan' }} <span class="student-class">({{ $d->kelas->nama_kelas ?? '-' }})</span></h4>
                                <span class="badge-code-inline">{{ $d->kode_dispen }}</span>
                            </div>
                            <span class="deleted-time-tag"><i class="fa-solid fa-clock-rotate-left"></i> Dihapus: {{ $deletedTime }}</span>
                        </div>

                        <div class="activity-detail-line">
                            <span class="detail-reason"><i class="fa-solid fa-tag" style="margin-right: 4px; color: #64748b;"></i> Izin Keluar &bull; {{ $d->alasan }}</span>
                            @if(!empty($d->tempat))
                                <span class="detail-tempat"><i class="fa-solid fa-location-dot" style="margin-right: 4px; color: #ef4444;"></i> {{ $d->tempat }}</span>
                            @endif
                            <span class="date-dispen-tag"><i class="fa-regular fa-calendar"></i> Tgl Izin: {{ $d->tanggal }}</span>
                        </div>

                        <div class="activity-footer-line">
                            <div class="status-badge-group">
                                <span class="status-badge badge-gray"><i class="fa-solid fa-trash"></i> DI SAMPAH</span>
                            </div>

                            <div class="action-btn-group">
                                <!-- Restore Single -->
                                <button type="button" class="btn-restore-sm" onclick="confirmSingleRestore({{ $d->id_siswa_dispen }}, '{{ addslashes($d->siswa->nama_siswa ?? 'Siswa') }}', '{{ $d->kode_dispen }}')" title="Pulihkan data kembali ke Log Aktif">
                                    <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                </button>

                                <!-- Force Delete Single -->
                                <button type="button" class="btn-force-delete-sm" onclick="confirmSingleForceDelete({{ $d->id_siswa_dispen }}, '{{ addslashes($d->siswa->nama_siswa ?? 'Siswa') }}', '{{ $d->kode_dispen }}')" title="Hapus secara permanen dari database">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Permanen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-log-state">
                    <div class="empty-icon-wrap" style="color: #10b981;">
                        <i class="fa-solid fa-trash-arrow-up"></i>
                    </div>
                    <h3>Folder Sampah Kosong</h3>
                    <p>Tidak ada data log dispensasi yang berada di folder sampah.</p>
                    <a href="{{ route('satpam.log-aktivitas') }}" class="btn-back-to-active">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Log Aktif
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination Section with Clean Responsive View -->
        <div class="custom-pagination-wrapper">
            {{ $logs->withQueryString()->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

<!-- Modal Confirmation Generic -->
<div id="modalConfirmAction" class="modal-backdrop-custom" onclick="if(event.target === this) closeConfirmModal()">
    <div class="modal-card-confirm">
        <div class="modal-confirm-icon" id="confirmIconWrapper">
            <i id="confirmIcon" class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 id="confirmModalTitle">Konfirmasi Tindakan</h3>
        <p id="confirmModalDesc">Deskripsi tindakan konfirmasi.</p>
        <div class="modal-confirm-buttons">
            <button type="button" class="btn-cancel-modal" onclick="closeConfirmModal()">Batal</button>
            <button type="button" class="btn-confirm-delete" id="btnConfirmActionSubmit">Ya, Lanjutkan</button>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .log-aktivitas-page-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
    }

    /* Custom Header Page Title Style */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .header-right-nav {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-nav-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s ease;
    }

    .btn-nav-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-nav-tab.active {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.2);
    }

    .btn-nav-trash-active {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25) !important;
    }

    .badge-trash-count {
        background: #ffffff;
        color: #dc2626;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 20px;
        line-height: 1;
    }

    .badge-active-count {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 20px;
        line-height: 1;
    }

    /* Alert Banner */
    .alert-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        animation: fadeIn 0.3s ease;
    }

    .alert-custom-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .alert-custom-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert-icon {
        font-size: 18px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-close {
        background: transparent;
        border: none;
        font-size: 20px;
        color: inherit;
        cursor: pointer;
        opacity: 0.7;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Base Card */
    .dashboard-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        padding: 24px;
    }

    /* Filter Form */
    .filter-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-search-box {
        position: relative;
        flex: 1;
        min-width: 260px;
    }

    .filter-search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .filter-input {
        width: 100%;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px 10px 38px;
        font-size: 13px;
        outline: none;
        font-family: inherit;
        color: #1e293b;
    }

    .filter-input:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-submit {
        background: #334155;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-filter-submit:hover {
        background: #1e293b;
    }

    .btn-filter-reset {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        transition: background 0.2s ease;
    }

    .btn-filter-reset:hover {
        background: #cbd5e1;
    }

    .btn-empty-trash {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-empty-trash:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* Bulk Action Bar */
    .bulk-action-bar {
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        border-radius: 14px;
        padding: 12px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.08);
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bulk-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #991b1b;
        font-weight: 600;
    }

    .bulk-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-bulk-restore {
        background: #059669;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-bulk-restore:hover {
        background: #047857;
    }

    .btn-bulk-force {
        background: #dc2626;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-bulk-force:hover {
        background: #b91c1c;
    }

    .btn-bulk-cancel {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-bulk-cancel:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Activity Log Card */
    .activity-log-card {
        padding: 24px;
    }

    .activity-log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .activity-log-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .activity-log-subtitle {
        font-size: 12.5px;
        color: #64748b;
        margin: 3px 0 0 0;
        font-weight: 600;
    }

    .header-tools-group {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .select-all-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.15s ease;
    }

    .select-all-label:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .link-lihat-semua {
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .link-lihat-semua:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* Custom Checkbox */
    .custom-check, #selectAllCheckbox {
        width: 17px;
        height: 17px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .item-checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-right: 4px;
    }

    /* Activity List Items */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.15s ease;
    }

    .activity-item.selected .activity-content-box {
        border-color: #fca5a5;
        background: #fffafa;
    }

    .activity-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        transition: all 0.15s ease;
    }

    .icon-trash-item {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .activity-content-box {
        flex: 1;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: all 0.15s ease;
    }

    .activity-content-box:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.06);
    }

    .activity-header-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .student-info-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .student-name {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .student-class {
        color: #2563eb;
        font-weight: 700;
        font-size: 13.5px;
    }

    .badge-code-inline {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 2px 6px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 11px;
        color: #475569;
        font-weight: 700;
    }

    .deleted-time-tag {
        font-size: 11.5px;
        font-weight: 700;
        color: #dc2626;
        background: #fef2f2;
        padding: 3px 9px;
        border-radius: 6px;
        border: 1px solid #fee2e2;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .date-dispen-tag {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .activity-detail-line {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 2px;
    }

    .detail-reason {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 3px 9px;
        border-radius: 7px;
        color: #334155;
        font-weight: 600;
        font-size: 12px;
    }

    .detail-tempat {
        display: inline-block;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        padding: 3px 9px;
        border-radius: 7px;
        color: #9f1239;
        font-weight: 600;
        font-size: 12px;
    }

    .activity-footer-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 6px;
        flex-wrap: wrap;
    }

    .status-badge-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        font-size: 10.5px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .badge-gray {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-restore-sm {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-restore-sm:hover {
        background: #059669;
        color: #ffffff;
        border-color: #059669;
    }

    .btn-force-delete-sm {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-force-delete-sm:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .empty-log-state {
        text-align: center;
        padding: 56px 16px;
        color: #94a3b8;
    }

    .empty-icon-wrap {
        font-size: 44px;
        margin-bottom: 12px;
    }

    .empty-log-state h3 {
        font-size: 17px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 6px;
    }

    .empty-log-state p {
        font-size: 13.5px;
        color: #64748b;
        margin-bottom: 20px;
    }

    .btn-back-to-active {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        color: #ffffff;
        text-decoration: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        transition: background 0.15s ease;
    }

    .btn-back-to-active:hover {
        background: #1d4ed8;
    }

    /* Custom Pagination Wrapper & Styles to Fix Huge SVG Arrow */
    .custom-pagination-wrapper {
        margin-top: 24px;
        display: block;
        width: 100%;
    }

    .custom-pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }

    .pagination-list {
        display: flex;
        align-items: center;
        list-style: none;
        gap: 4px;
        margin: 0;
        padding: 0;
    }

    .pagination-list .page-item {
        display: inline-block;
    }

    .pagination-list .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .pagination-list .page-link:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .pagination-list .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .pagination-list .page-item.disabled .page-link {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
    }

    /* Fallback constraint on all SVGs inside pagination to prevent giant arrow leakage */
    .custom-pagination-wrapper svg,
    .activity-log-card svg {
        max-width: 18px !important;
        max-height: 18px !important;
        width: 18px !important;
        height: 18px !important;
        display: inline-block;
        vertical-align: middle;
    }

    /* Modal Backdrop & Confirm Box */
    .modal-backdrop-custom {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999999 !important;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-card-confirm {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        padding: 28px 24px;
        text-align: center;
        animation: modalFadeIn 0.2s ease-out;
    }

    .modal-confirm-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }

    .modal-confirm-icon.danger-icon {
        background: #fef2f2;
        color: #ef4444;
        border: 2px solid #fee2e2;
    }

    .modal-confirm-icon.success-icon {
        background: #ecfdf5;
        color: #059669;
        border: 2px solid #a7f3d0;
    }

    .modal-card-confirm h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px 0;
    }

    .modal-card-confirm p {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 24px 0;
    }

    .modal-confirm-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-cancel-modal {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        flex: 1;
        transition: all 0.15s ease;
    }

    .btn-cancel-modal:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-confirm-delete {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        flex: 1.2;
        transition: background 0.15s ease;
    }

    .btn-confirm-delete:hover {
        background: #dc2626;
    }

    .btn-confirm-restore {
        background: #059669 !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 20px !important;
        border-radius: 10px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        flex: 1.2 !important;
        transition: background 0.15s ease !important;
    }

    .btn-confirm-restore:hover {
        background: #047857 !important;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .log-aktivitas-page-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        .dashboard-page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .header-left h1 {
            font-size: 20px;
        }

        .header-left p {
            font-size: 12px;
        }

        .header-right-nav {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .header-right-nav .btn-nav-tab {
            flex: 1;
            justify-content: center;
            padding: 8px 12px;
            font-size: 12.5px;
        }

        .filter-card {
            padding: 16px 14px;
            border-radius: 14px;
            margin-bottom: 16px !important;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            width: 100%;
        }

        .filter-search-box {
            min-width: 100%;
            width: 100%;
        }

        .filter-input {
            font-size: 12.5px;
            padding: 9px 12px 9px 36px;
        }

        .btn-filter-submit, .btn-filter-reset {
            width: 100%;
            justify-content: center;
            padding: 10px 14px;
            font-size: 13px;
        }

        .filter-card .filter-form > div[style*="margin-left: auto"] {
            margin-left: 0 !important;
            width: 100%;
        }

        .btn-empty-trash {
            width: 100%;
            justify-content: center;
            padding: 10px 14px;
            font-size: 13px;
        }

        .bulk-action-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 12px;
        }

        .bulk-info {
            font-size: 12.5px;
            justify-content: center;
        }

        .bulk-actions {
            width: 100%;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-bulk-restore, .btn-bulk-force, .btn-bulk-cancel {
            flex: 1;
            justify-content: center;
            padding: 8px 10px;
            font-size: 11.5px;
            text-align: center;
        }

        .activity-log-card {
            padding: 16px 12px;
            border-radius: 16px;
        }

        .activity-log-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
        }

        .activity-log-title {
            font-size: 16px;
        }

        .activity-log-subtitle {
            font-size: 11.5px;
        }

        .header-tools-group {
            width: 100%;
            justify-content: space-between;
            gap: 8px;
        }

        .select-all-label {
            padding: 5px 10px;
            font-size: 12px;
        }

        .link-lihat-semua {
            font-size: 12px;
        }

        .activity-list {
            gap: 10px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            width: 100%;
            min-width: 0;
        }

        .item-checkbox-wrapper {
            padding-top: 14px;
            padding-right: 0;
            flex-shrink: 0;
        }

        .activity-icon-wrapper {
            width: 36px;
            height: 36px;
            font-size: 14px;
            border-radius: 10px;
            margin-top: 6px;
            flex-shrink: 0;
        }

        .activity-content-box {
            flex: 1;
            min-width: 0;
            width: 100%;
            padding: 12px 10px;
            border-radius: 12px;
            box-sizing: border-box;
            gap: 8px;
        }

        .activity-header-line {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            width: 100%;
            min-width: 0;
        }

        .student-info-left {
            width: 100%;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            min-width: 0;
        }

        .student-name {
            font-size: 13.5px;
            line-height: 1.3;
            word-break: break-word;
            width: 100%;
        }

        .student-class {
            font-size: 12.5px;
        }

        .badge-code-inline {
            font-size: 10.5px;
            padding: 2px 6px;
        }

        .deleted-time-tag {
            font-size: 11px;
            padding: 2px 6px;
        }

        .activity-detail-line {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            width: 100%;
            min-width: 0;
        }

        .detail-reason, .detail-tempat, .date-dispen-tag {
            font-size: 11.5px;
            padding: 3px 7px;
            border-radius: 6px;
            word-break: break-word;
            max-width: 100%;
            box-sizing: border-box;
        }

        .activity-footer-line {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            margin-top: 4px;
            padding-top: 8px;
            border-top: 1px dashed #f1f5f9;
            width: 100%;
            min-width: 0;
        }

        .status-badge-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            width: 100%;
        }

        .status-badge {
            font-size: 9.5px;
            padding: 3px 8px;
            border-radius: 8px;
            white-space: normal;
            line-height: 1.2;
        }

        .action-btn-group {
            display: flex;
            gap: 6px;
            width: 100%;
            flex-wrap: wrap;
        }

        .btn-restore-sm, .btn-force-delete-sm {
            flex: 1;
            min-height: 32px;
            justify-content: center;
            padding: 6px 10px;
            font-size: 11.5px;
            text-align: center;
            white-space: nowrap;
        }

        /* Modal Confirm Responsive */
        .modal-backdrop-custom {
            padding: 10px !important;
        }

        .modal-card-confirm {
            padding: 20px 16px;
            border-radius: 16px;
            max-width: 100%;
        }

        .modal-confirm-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .modal-card-confirm h3 {
            font-size: 16px;
        }

        .modal-card-confirm p {
            font-size: 12.5px;
            margin-bottom: 18px;
        }

        .modal-confirm-buttons {
            gap: 8px;
            width: 100%;
        }

        .btn-cancel-modal, .btn-confirm-delete, .btn-confirm-restore {
            padding: 9px 12px;
            font-size: 12.5px;
        }

        /* Pagination Responsive */
        .custom-pagination-bar {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 12px;
            padding-top: 14px;
        }

        .pagination-info {
            font-size: 12px;
        }

        .pagination-list .page-link {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            font-size: 12px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Checkbox and Bulk Logic
    function handleRowCheckboxChange() {
        let checkboxes = document.querySelectorAll('.row-checkbox');
        let checked = document.querySelectorAll('.row-checkbox:checked');
        let selectAll = document.getElementById('selectAllCheckbox');
        let bulkBar = document.getElementById('bulkActionBar');
        let countText = document.getElementById('selectedCountText');

        if (selectAll) {
            selectAll.checked = (checkboxes.length > 0 && checked.length === checkboxes.length);
        }

        // Highlight selected rows
        checkboxes.forEach(cb => {
            let row = document.getElementById('item-row-' + cb.value);
            if (row) {
                if (cb.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }
        });

        if (checked.length > 0) {
            countText.innerText = checked.length;
            bulkBar.style.display = 'flex';
        } else {
            bulkBar.style.display = 'none';
        }
    }

    function toggleSelectAll(selectAllEl) {
        let checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = selectAllEl.checked;
        });
        handleRowCheckboxChange();
    }

    function deselectAll() {
        let selectAll = document.getElementById('selectAllCheckbox');
        if (selectAll) selectAll.checked = false;
        let checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = false;
        });
        handleRowCheckboxChange();
    }

    // Confirmation Action Logic
    let pendingAction = null;

    function openConfirmModal(options) {
        let iconWrap = document.getElementById('confirmIconWrapper');
        let icon = document.getElementById('confirmIcon');
        let title = document.getElementById('confirmModalTitle');
        let desc = document.getElementById('confirmModalDesc');
        let submitBtn = document.getElementById('btnConfirmActionSubmit');

        iconWrap.className = 'modal-confirm-icon ' + (options.isRestore ? 'success-icon' : 'danger-icon');
        icon.className = 'fa-solid ' + (options.isRestore ? 'fa-rotate-left' : 'fa-triangle-exclamation');
        title.innerText = options.title;
        desc.innerHTML = options.desc;
        submitBtn.className = options.isRestore ? 'btn-confirm-restore' : 'btn-confirm-delete';
        submitBtn.innerText = options.buttonText || 'Ya, Lanjutkan';

        pendingAction = options.action;
        document.getElementById('modalConfirmAction').style.display = 'flex';
    }

    function closeConfirmModal() {
        document.getElementById('modalConfirmAction').style.display = 'none';
        pendingAction = null;
    }

    document.getElementById('btnConfirmActionSubmit').addEventListener('click', function() {
        if (pendingAction) {
            pendingAction();
        }
    });

    // 1. Single Restore
    function confirmSingleRestore(id, namaSiswa, kodeDispen) {
        openConfirmModal({
            isRestore: true,
            title: 'Pulihkan Log Dispensasi?',
            desc: `Data dispensasi <strong>${namaSiswa}</strong> (${kodeDispen}) akan dikembalikan ke daftar <strong>Log Aktif</strong>.`,
            buttonText: 'Ya, Pulihkan Data',
            action: function() {
                let form = document.getElementById('singleActionForm');
                form.action = `{{ url('/satpam/log-aktivitas') }}/${id}/restore`;
                document.getElementById('singleActionMethod').value = 'POST';
                form.submit();
            }
        });
    }

    // 2. Single Force Delete
    function confirmSingleForceDelete(id, namaSiswa, kodeDispen) {
        openConfirmModal({
            isRestore: false,
            title: 'Hapus Permanen?',
            desc: `Data dispensasi <strong>${namaSiswa}</strong> (${kodeDispen}) akan <strong>dihapus secara permanen</strong> dari database dan tidak dapat dikembalikan lagi.`,
            buttonText: 'Ya, Hapus Permanen',
            action: function() {
                let form = document.getElementById('singleActionForm');
                form.action = `{{ url('/satpam/log-aktivitas') }}/${id}/force`;
                document.getElementById('singleActionMethod').value = 'DELETE';
                form.submit();
            }
        });
    }

    // 3. Bulk Restore
    function confirmBulkRestore() {
        let checked = document.querySelectorAll('.row-checkbox:checked');
        if (checked.length === 0) return;

        let ids = Array.from(checked).map(cb => cb.value);
        openConfirmModal({
            isRestore: true,
            title: 'Pulihkan Data Terpilih?',
            desc: `Sebanyak <strong>${ids.length} data log dispensasi</strong> terpilih akan dikembalikan ke daftar <strong>Log Aktif</strong>.`,
            buttonText: 'Ya, Pulihkan Terpilih',
            action: function() {
                let form = document.getElementById('bulkRestoreForm');
                document.getElementById('bulkRestoreIds').value = ids.join(',');
                form.submit();
            }
        });
    }

    // 4. Bulk Force Delete
    function confirmBulkForceDelete() {
        let checked = document.querySelectorAll('.row-checkbox:checked');
        if (checked.length === 0) return;

        let ids = Array.from(checked).map(cb => cb.value);
        openConfirmModal({
            isRestore: false,
            title: 'Hapus Permanen Terpilih?',
            desc: `Sebanyak <strong>${ids.length} data log dispensasi</strong> terpilih akan <strong>dihapus secara permanen</strong> dari database. Tindakan ini tidak dapat dibatalkan!`,
            buttonText: 'Ya, Hapus Permanen',
            action: function() {
                let form = document.getElementById('bulkForceDeleteForm');
                document.getElementById('bulkForceIds').value = ids.join(',');
                form.submit();
            }
        });
    }

    // 5. Empty Trash
    function confirmEmptyTrash() {
        openConfirmModal({
            isRestore: false,
            title: 'Kosongkan Seluruh Sampah?',
            desc: `Apakah Anda yakin ingin mengosongkan dan <strong>menghapus secara permanen semua data di folder Sampah</strong>? Data yang dihapus tidak dapat dipulihkan lagi.`,
            buttonText: 'Ya, Kosongkan Semua',
            action: function() {
                let form = document.getElementById('emptyTrashForm');
                form.submit();
            }
        });
    }
</script>
@endsection