@extends('layouts.guru')

@section('title', 'Log Aktivitas — Portal Satpam Jurnal SMEA')

@section('content')
<div class="log-aktivitas-page-wrapper">

    <!-- Header Page Title & Subtitle matching Portal Style -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Log Aktivitas Satpam</h1>
            <p>{{ $formattedDate ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} &nbsp;•&nbsp; Catatan dan riwayat perizinan siswa di pos satpam</p>
        </div>
        <div class="header-right-nav">
            <a href="{{ route('satpam.log-aktivitas') }}" class="btn-nav-tab active">
                <i class="fa-solid fa-clock-rotate-left"></i> Log Aktif
            </a>
            <a href="{{ route('satpam.log-aktivitas.trash') }}" class="btn-nav-tab btn-nav-trash">
                <i class="fa-solid fa-trash-can"></i> Sampah
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-trash-count">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Filter & Search Section Card -->
    <div class="dashboard-card filter-card" style="margin-bottom: 24px;">
        <form method="GET" action="{{ route('satpam.log-aktivitas') }}" class="filter-form">
            <div class="filter-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Kode Dispen / Nama Siswa / NISN...">
            </div>

            <div class="filter-select-box">
                <select name="status" class="filter-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Validasi Satpam</option>
                    <option value="pending_waka" {{ request('status') == 'pending_waka' ? 'selected' : '' }}>Menunggu Persetujuan Waka</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai Validasi</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn-filter-submit">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('satpam.log-aktivitas') }}" class="btn-filter-reset">
                    <i class="fa-solid fa-rotate-left" style="margin-right: 4px;"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Bulk Action Toolbar (Appears when items checked) -->
    <div class="bulk-action-bar" id="bulkActionBar" style="display: none;">
        <div class="bulk-info">
            <i class="fa-solid fa-circle-check" style="color: #2563eb; font-size: 16px;"></i>
            <span><strong id="selectedCountText">0</strong> log dispensasi dipilih</span>
        </div>
        <div class="bulk-actions">
            <button type="button" class="btn-bulk-delete" onclick="confirmBulkDelete()">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (Ke Sampah)
            </button>
            <button type="button" class="btn-bulk-cancel" onclick="deselectAll()">
                <i class="fa-solid fa-xmark"></i> Batal
            </button>
        </div>
    </div>

    <!-- Main Card: Log Aktivitas Terbaru -->
    <div class="dashboard-card activity-log-card">
        <div class="activity-log-header">
            <div>
                <h2 class="activity-log-title">Daftar Log Aktivitas Dispen</h2>
                <p class="activity-log-subtitle">
                    {{ \Carbon\Carbon::now()->translatedFormat('l') }}, {{ min($logs->count(), 15) }} dari {{ $logs->total() }} sesi ditampilkan
                </p>
            </div>
            <div class="header-tools-group">
                @if($logs->count() > 0)
                    <label class="select-all-label">
                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                        <span>Pilih Semua</span>
                    </label>
                @endif
                <a href="{{ route('satpam.log-aktivitas') }}" class="link-lihat-semua">
                    <i class="fa-solid fa-arrows-rotate"></i> Refresh
                </a>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('satpam.log-aktivitas.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="bulkDeleteIds">
        </form>

        <div class="activity-list" id="activityLogList">
            @forelse($logs as $d)
                @php
                    $isDone = ($d->status_satpam === 'sudah_kembali' || $d->status_satpam === 'dizinkan_keluar');
                    $isRejected = ($d->status_satpam === 'ditolak' || $d->status_waka === 'rejected' || $d->status_wali_kelas === 'rejected');
                    $isApprovedWaka = ($d->status_waka === 'approved' || $d->status_wali_kelas === 'approved');

                    $iconClass = 'icon-pending';
                    $iconSymbol = 'fa-clipboard-list';
                    $badgeText = 'MENUNGGU VALIDASI SATPAM';
                    $badgeClass = 'badge-yellow';

                    if ($d->status_satpam === 'sudah_kembali') {
                        $iconClass = 'icon-done';
                        $iconSymbol = 'fa-check-double';
                        $badgeText = 'SUDAH KEMBALI';
                        $badgeClass = 'badge-green';
                    } elseif ($d->status_satpam === 'dizinkan_keluar') {
                        $iconClass = 'icon-done';
                        $iconSymbol = 'fa-door-open';
                        $badgeText = 'DIZINKAN KELUAR';
                        $badgeClass = 'badge-blue';
                    } elseif ($isRejected) {
                        $iconClass = 'icon-rejected';
                        $iconSymbol = 'fa-xmark';
                        $badgeText = 'DITOLAK';
                        $badgeClass = 'badge-red';
                    } elseif (!$isApprovedWaka) {
                        $iconClass = 'icon-warning';
                        $iconSymbol = 'fa-clock';
                        $badgeText = 'MENUNGGU WAKA';
                        $badgeClass = 'badge-orange-subtle';
                    }
                    
                    $timeFormatted = $d->created_at ? $d->created_at->format('H.i') : '00.00';
                @endphp

                <div class="activity-item" id="item-row-{{ $d->id_siswa_dispen }}">
                    <div class="item-checkbox-wrapper">
                        <input type="checkbox" class="row-checkbox custom-check" value="{{ $d->id_siswa_dispen }}" onchange="handleRowCheckboxChange()">
                    </div>

                    <div class="activity-icon-wrapper {{ $iconClass }}">
                        <i class="fa-solid {{ $iconSymbol }}"></i>
                    </div>

                    <div class="activity-content-box">
                        <div class="activity-header-line">
                            <div class="student-info-left">
                                <h4 class="student-name">{{ $d->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan' }} <span class="student-class">({{ $d->kelas->nama_kelas ?? '-' }})</span></h4>
                                <span class="badge-code-inline">{{ $d->kode_dispen }}</span>
                            </div>
                            <span class="activity-time"><i class="fa-regular fa-clock"></i> {{ $timeFormatted }} WIB</span>
                        </div>

                        <div class="activity-detail-line">
                            <span class="detail-reason"><i class="fa-solid fa-tag" style="margin-right: 4px; color: #64748b;"></i> Izin Keluar &bull; {{ $d->alasan }}</span>
                            @if(!empty($d->tempat))
                                <span class="detail-tempat"><i class="fa-solid fa-location-dot" style="margin-right: 4px; color: #ef4444;"></i> {{ $d->tempat }}</span>
                            @endif
                        </div>

                        <div class="activity-footer-line">
                            <div class="status-badge-group">
                                <span class="status-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                @if($d->waktu_scan_satpam)
                                    <span class="scan-time-badge"><i class="fa-solid fa-qrcode"></i> Scan: {{ \Carbon\Carbon::parse($d->waktu_scan_satpam)->format('H:i') }}</span>
                                @endif
                            </div>

                            <div class="action-btn-group">
                                <button type="button" class="btn-detail-sm" onclick='openDetailModal(@json($d))' title="Lihat detail dispensasi & foto">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                @if($isApprovedWaka)
                                    <form action="{{ route('satpam.update-status', $d->id_siswa_dispen) }}" method="POST" class="inline-action-form">
                                        @csrf
                                        @if($d->status_satpam === 'belum_keluar')
                                            <button type="submit" name="status_satpam" value="dizinkan_keluar" class="btn-action-sm btn-action-blue" title="Izinkan siswa keluar gate">
                                                <i class="fa-solid fa-door-open"></i> Izinkan Keluar
                                            </button>
                                        @elseif($d->status_satpam === 'dizinkan_keluar')
                                            <button type="submit" name="status_satpam" value="sudah_kembali" class="btn-action-sm btn-action-navy" title="Konfirmasi siswa kembali">
                                                <i class="fa-solid fa-door-closed"></i> Konfirmasi Kembali
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <span class="text-warning-hold" title="Siswa belum bisa keluar gate karena izin belum disetujui Waka"><i class="fa-solid fa-clock"></i> Perlu Persetujuan Waka</span>
                                @endif

                                <!-- Soft Delete Button -->
                                <button type="button" class="btn-delete-sm" onclick="confirmSingleDelete({{ $d->id_siswa_dispen }}, '{{ addslashes($d->siswa->nama_siswa ?? 'Siswa') }}', '{{ $d->kode_dispen }}')" title="Pindahkan ke sampah">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-log-state">
                    <div class="empty-icon-wrap">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3>Tidak Ada Data Log Dispen</h3>
                    <p>Tidak ditemukan catatan log aktivitas dispensasi sesuai filter pencarian.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination Section with Clean Responsive View -->
        <div class="custom-pagination-wrapper">
            {{ $logs->withQueryString()->links('partials.custom-pagination') }}
        </div>
    </div>

</div>

<!-- Single Delete Form (Hidden) -->
<form id="singleDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Detail Dispen Overlay -->
<div id="modalDetailDispen" class="modal-backdrop-custom" onclick="if(event.target === this) closeDetailModal()">
    <div class="modal-card-detail">
        <div class="modal-detail-header">
            <h3><i class="fa-solid fa-id-card-clip"></i> Detail Presensi & Izin Siswa</h3>
            <button type="button" class="modal-detail-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-detail-body" id="modalDetailBody">
            <!-- Dynamic content populated via JS -->
        </div>
    </div>
</div>

<!-- Modal Confirmation Delete / Bulk Delete -->
<div id="modalConfirmDelete" class="modal-backdrop-custom" onclick="if(event.target === this) closeConfirmModal()">
    <div class="modal-card-confirm">
        <div class="modal-confirm-icon warning-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 id="confirmModalTitle">Pindahkan ke Sampah?</h3>
        <p id="confirmModalDesc">Data log dispensasi yang dipilih akan dipindahkan ke folder sampah dan dapat dipulihkan kapan saja.</p>
        <div class="modal-confirm-buttons">
            <button type="button" class="btn-cancel-modal" onclick="closeConfirmModal()">Batal</button>
            <button type="button" class="btn-confirm-delete" id="btnConfirmDeleteAction">Ya, Hapus ke Sampah</button>
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

    .btn-nav-trash {
        position: relative;
    }

    .btn-nav-trash:hover {
        border-color: #fca5a5;
        color: #dc2626;
        background: #fef2f2;
    }

    .badge-trash-count {
        background: #ef4444;
        color: #ffffff;
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
        min-width: 240px;
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

    .filter-select-box {
        width: 230px;
    }

    .filter-select {
        width: 100%;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        font-family: inherit;
        color: #1e293b;
    }

    .btn-filter-submit {
        background: #2563eb;
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
        background: #1d4ed8;
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

    /* Bulk Action Bar */
    .bulk-action-bar {
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        border-radius: 14px;
        padding: 12px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.08);
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
        color: #1e3a8a;
        font-weight: 600;
    }

    .bulk-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-bulk-delete {
        background: #ef4444;
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

    .btn-bulk-delete:hover {
        background: #dc2626;
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
        border-color: #93c5fd;
        background: #f8fbff;
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

    .icon-done {
        background: #f0fdf4;
        color: #059669;
        border: 1px solid #bbf7d0;
    }

    .icon-rejected {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    .icon-pending {
        background: #fefce8;
        color: #d97706;
        border: 1px solid #fef08a;
    }

    .icon-warning {
        background: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
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
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.06);
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

    .activity-time {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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
        flex-wrap: wrap;
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

    .badge-green {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .badge-red {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-orange-subtle {
        background: #ffedd5;
        color: #9a3412;
        border: 1px solid #fed7aa;
    }

    .scan-time-badge {
        font-size: 11px;
        font-weight: 700;
        color: #0284c7;
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        padding: 3px 8px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-detail-sm {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .btn-detail-sm:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .inline-action-form {
        display: inline-flex;
    }

    .btn-action-sm {
        border: none;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: opacity 0.2s ease;
    }

    .btn-action-sm:hover {
        opacity: 0.9;
    }

    .btn-action-blue {
        background: #2563eb;
        color: #ffffff;
    }

    .btn-action-navy {
        background: #0284c7;
        color: #ffffff;
    }

    .btn-delete-sm {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-delete-sm:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    .text-warning-hold {
        font-size: 11.5px;
        color: #c2410c;
        font-weight: 700;
    }

    .empty-log-state {
        text-align: center;
        padding: 48px 16px;
        color: #94a3b8;
    }

    .empty-icon-wrap {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .empty-log-state h3 {
        font-size: 16px;
        font-weight: 800;
        color: #334155;
        margin-bottom: 4px;
    }

    .empty-log-state p {
        font-size: 13px;
        color: #64748b;
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

    .modal-card-detail {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        animation: modalFadeIn 0.2s ease-out;
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

    .warning-icon {
        background: #fef2f2;
        color: #ef4444;
        border: 2px solid #fee2e2;
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

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-detail-header {
        padding: 18px 24px;
        background: #384972;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-detail-header h3 {
        font-size: 16.5px;
        font-weight: 800;
        margin: 0;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-detail-close {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }

    .modal-detail-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-detail-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }

    .detail-section-title {
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        margin: 16px 0 10px 0;
        padding-bottom: 4px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-section-title:first-child {
        margin-top: 0;
    }

    .detail-item-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 9px 0;
        font-size: 13px;
        border-bottom: 1px dashed #f1f5f9;
        gap: 12px;
    }

    .detail-item-row .lbl {
        color: #64748b;
        font-weight: 600;
        min-width: 140px;
    }

    .detail-item-row .val {
        color: #0f172a;
        font-weight: 700;
        text-align: right;
    }

    .badge-code {
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 12.5px;
        color: #1e293b;
        border: 1px solid #cbd5e1;
    }

    .detail-image-box {
        display: flex;
        gap: 12px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .detail-image-box img {
        max-width: 100%;
        max-height: 180px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        object-fit: cover;
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

        .filter-select-box {
            width: 100%;
        }

        .filter-input, .filter-select {
            font-size: 12.5px;
            padding: 9px 12px 9px 36px;
        }

        .filter-select {
            padding: 9px 12px;
        }

        .btn-filter-submit, .btn-filter-reset {
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
        }

        .btn-bulk-delete, .btn-bulk-cancel {
            flex: 1;
            justify-content: center;
            padding: 8px 10px;
            font-size: 12px;
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

        .activity-time {
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

        .detail-reason, .detail-tempat {
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

        .scan-time-badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        .action-btn-group {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            flex-wrap: wrap;
        }

        .btn-detail-sm {
            flex: 1;
            min-height: 32px;
            justify-content: center;
            font-size: 11.5px;
            padding: 5px 8px;
            white-space: nowrap;
        }

        .inline-action-form {
            flex: 1.5;
            display: flex;
        }

        .btn-action-sm {
            width: 100%;
            min-height: 32px;
            justify-content: center;
            font-size: 11.5px;
            padding: 5px 8px;
            white-space: nowrap;
        }

        .text-warning-hold {
            flex: 1.5;
            font-size: 10.5px;
            line-height: 1.2;
        }

        .btn-delete-sm {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Modal Detail Responsive */
        .modal-backdrop-custom {
            padding: 10px !important;
        }

        .modal-card-detail {
            max-width: 100%;
            width: 100%;
            border-radius: 16px;
            max-height: 90vh;
        }

        .modal-detail-header {
            padding: 14px 16px;
        }

        .modal-detail-header h3 {
            font-size: 15px;
        }

        .modal-detail-body {
            padding: 16px;
        }

        .detail-section-title {
            font-size: 11px;
            margin: 14px 0 8px 0;
        }

        .detail-item-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: 7px 0;
            width: 100%;
        }

        .detail-item-row .lbl {
            min-width: unset;
            width: 100%;
            font-size: 11.5px;
        }

        .detail-item-row .val {
            text-align: left;
            width: 100%;
            font-size: 12.5px;
            word-break: break-word;
        }

        .detail-image-box {
            gap: 8px;
        }

        .detail-image-box img {
            max-height: 140px;
        }

        /* Modal Confirm Responsive */
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

        .btn-cancel-modal, .btn-confirm-delete {
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
    // Helper untuk format URL gambar agar terhindar dari broken link
    function formatImageUrl(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://')) return path;
        if (path.startsWith('/')) return path;
        return '{{ asset("") }}' + path;
    }

    // Modal Detail Dispen
    function openDetailModal(item) {
        if (typeof item === 'string') {
            try { item = JSON.parse(item); } catch(e) {}
        }
        let isApprovedWaka = (item.status_waka === 'approved' || item.status_wali_kelas === 'approved');
        let wakaBadgeText = isApprovedWaka 
            ? '<span class="status-badge badge-green"><i class="fa-solid fa-check"></i> Disetujui Waka</span>' 
            : '<span class="status-badge badge-orange-subtle"><i class="fa-solid fa-clock"></i> Menunggu Persetujuan Waka</span>';
        
        let approverName = item.nama_waka || (item.waka_user ? item.waka_user.name : (item.nama_guru_piket || '-'));

        let satpamBadgeText = '';
        if (item.status_satpam === 'sudah_kembali') {
            satpamBadgeText = '<span class="status-badge badge-green"><i class="fa-solid fa-check-double"></i> Sudah Kembali</span>';
        } else if (item.status_satpam === 'dizinkan_keluar') {
            satpamBadgeText = '<span class="status-badge badge-blue"><i class="fa-solid fa-door-open"></i> Dizinkan Keluar</span>';
        } else if (item.status_satpam === 'ditolak') {
            satpamBadgeText = '<span class="status-badge badge-red"><i class="fa-solid fa-xmark"></i> Ditolak</span>';
        } else {
            satpamBadgeText = '<span class="status-badge badge-yellow"><i class="fa-solid fa-clock"></i> Belum Keluar (Menunggu Validasi Gate)</span>';
        }

        let fotoSiswaLiveSrc = item.foto_siswa_live ? formatImageUrl(item.foto_siswa_live) : (item.foto_siswa_live_url || null);
        let fotoKartuSrc = item.foto_kartu_identitas ? formatImageUrl(item.foto_kartu_identitas) : (item.foto_kartu_url || null);
        let fotoSuratSrc = item.foto_surat_dispen ? formatImageUrl(item.foto_surat_dispen) : (item.foto_surat_url || null);
        let fotoSiswaSrc = (item.siswa && item.siswa.foto) ? formatImageUrl('uploads/profile_photos/' + item.siswa.foto) : null;

        let bodyHtml = `
            <div class="detail-grid">
                <div class="detail-section-title"><i class="fa-solid fa-user-graduate"></i> Data Informasi Siswa</div>
                <div class="detail-item-row">
                    <span class="lbl">Nama Siswa</span>
                    <span class="val font-bold">${item.siswa ? item.siswa.nama_siswa : '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">NISN / Kelas</span>
                    <span class="val">${item.siswa ? item.siswa.nisn : '-'} &bull; ${item.kelas ? item.kelas.nama_kelas : '-'}</span>
                </div>

                <div class="detail-section-title"><i class="fa-solid fa-clipboard-list"></i> Detail Perizinan / Dispensasi</div>
                <div class="detail-item-row">
                    <span class="lbl">Kode Dispen</span>
                    <span class="val badge-code">${item.kode_dispen || '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Tanggal</span>
                    <span class="val">${item.tanggal || '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Rencana Keluar - Kembali</span>
                    <span class="val">${item.jam_keluar || '-'} s/d ${item.jam_kembali || '-'} WIB</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Alasan Izin</span>
                    <span class="val">${item.alasan || '-'}</span>
                </div>
                ${item.tempat ? `
                <div class="detail-item-row">
                    <span class="lbl">Tujuan / Tempat</span>
                    <span class="val">${item.tempat}</span>
                </div>` : ''}

                <div class="detail-section-title"><i class="fa-solid fa-user-check"></i> Status Approval & Validasi Gate</div>
                <div class="detail-item-row">
                    <span class="lbl">Persetujuan Waka</span>
                    <span class="val">${wakaBadgeText}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Nama Penyetuju Waka</span>
                    <span class="val">${approverName}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Status Satpam (Gate)</span>
                    <span class="val">${satpamBadgeText}</span>
                </div>
                ${item.waktu_scan_satpam ? `
                <div class="detail-item-row">
                    <span class="lbl">Waktu Scan Satpam</span>
                    <span class="val">${item.waktu_scan_satpam}</span>
                </div>` : ''}
                ${item.catatan_satpam ? `
                <div class="detail-item-row">
                    <span class="lbl">Catatan Satpam</span>
                    <span class="val">${item.catatan_satpam}</span>
                </div>` : ''}

                ${(fotoSiswaLiveSrc || fotoKartuSrc || fotoSuratSrc || fotoSiswaSrc) ? `
                <div class="detail-section-title"><i class="fa-solid fa-image"></i> Lampiran & Bukti Foto Pengajuan</div>
                <div class="detail-image-box">
                    ${fotoSiswaLiveSrc ? `<div><div style="font-size:11px; color:#1d4ed8; margin-bottom:4px; font-weight:800;"><i class="fa-solid fa-camera"></i> Foto Siswa (Live Kamera):</div><a href="${fotoSiswaLiveSrc}" target="_blank" title="Klik untuk perbesar Foto Live Siswa"><img src="${fotoSiswaLiveSrc}" alt="Foto Siswa Live" style="border: 2px solid #3b82f6; border-radius: 8px;" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Foto+Live';"></a></div>` : ''}
                    ${fotoKartuSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Kartu Identitas Siswa:</div><a href="${fotoKartuSrc}" target="_blank"><img src="${fotoKartuSrc}" alt="Foto Identitas" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Gambar+Identitas';"></a></div>` : ''}
                    ${fotoSuratSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Surat Dispen:</div><a href="${fotoSuratSrc}" target="_blank"><img src="${fotoSuratSrc}" alt="Surat Dispen" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Surat+Dispen';"></a></div>` : ''}
                    ${fotoSiswaSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Foto Profil Siswa:</div><a href="${fotoSiswaSrc}" target="_blank"><img src="${fotoSiswaSrc}" alt="Foto Profil Siswa" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Foto+Siswa';"></a></div>` : ''}
                </div>` : ''}
            </div>
        `;

        if (isApprovedWaka) {
            let updateUrl = `{{ url('/satpam/update-status') }}/${item.id_siswa_dispen}`;
            let csrfToken = `{{ csrf_token() }}`;
            
            if (item.status_satpam === 'belum_keluar') {
                bodyHtml += `
                    <form action="${updateUrl}" method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="status_satpam" value="dizinkan_keluar">
                        <button type="submit" class="btn-action-sm btn-action-blue" style="width: 100%; justify-content: center; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 10px;">
                            <i class="fa-solid fa-door-open"></i> Izinkan Keluar Sekolah
                        </button>
                    </form>
                `;
            } else if (item.status_satpam === 'dizinkan_keluar') {
                bodyHtml += `
                    <form action="${updateUrl}" method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="status_satpam" value="sudah_kembali">
                        <button type="submit" class="btn-action-sm btn-action-navy" style="width: 100%; justify-content: center; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 10px;">
                            <i class="fa-solid fa-door-closed"></i> Konfirmasi Sudah Kembali
                        </button>
                    </form>
                `;
            }
        }

        document.getElementById('modalDetailBody').innerHTML = bodyHtml;
        document.getElementById('modalDetailDispen').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailDispen').style.display = 'none';
    }

    // Checkbox and Bulk Delete Logic
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

    // Delete Confirmation Modals
    let pendingDeleteAction = null;

    function confirmSingleDelete(id, namaSiswa, kodeDispen) {
        let titleEl = document.getElementById('confirmModalTitle');
        let descEl = document.getElementById('confirmModalDesc');

        titleEl.innerText = 'Hapus Log Dispensasi?';
        descEl.innerHTML = `Data dispensasi <strong>${namaSiswa}</strong> (${kodeDispen}) akan dipindahkan ke folder <strong>Sampah</strong>.`;

        pendingDeleteAction = function() {
            let form = document.getElementById('singleDeleteForm');
            form.action = `{{ url('/satpam/log-aktivitas') }}/${id}`;
            form.submit();
        };

        document.getElementById('modalConfirmDelete').style.display = 'flex';
    }

    function confirmBulkDelete() {
        let checked = document.querySelectorAll('.row-checkbox:checked');
        if (checked.length === 0) return;

        let ids = Array.from(checked).map(cb => cb.value);
        let titleEl = document.getElementById('confirmModalTitle');
        let descEl = document.getElementById('confirmModalDesc');

        titleEl.innerText = 'Hapus Terpilih ke Sampah?';
        descEl.innerHTML = `Sebanyak <strong>${ids.length} data log dispensasi</strong> terpilih akan dipindahkan ke folder <strong>Sampah</strong>.`;

        pendingDeleteAction = function() {
            let form = document.getElementById('bulkDeleteForm');
            document.getElementById('bulkDeleteIds').value = ids.join(',');
            form.submit();
        };

        document.getElementById('modalConfirmDelete').style.display = 'flex';
    }

    document.getElementById('btnConfirmDeleteAction').addEventListener('click', function() {
        if (pendingDeleteAction) {
            pendingDeleteAction();
        }
    });

    function closeConfirmModal() {
        document.getElementById('modalConfirmDelete').style.display = 'none';
        pendingDeleteAction = null;
    }
</script>
@endsection