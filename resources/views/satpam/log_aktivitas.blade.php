@extends('layouts.guru')

@section('title', 'Log Aktivitas — Portal Satpam Jurnal SMEA')

@section('content')
<div class="log-aktivitas-page-wrapper">

    <!-- Header Page Title & Subtitle matching TU style -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Log Aktivitas Satpam</h1>
            <p>{{ $formattedDate ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} &nbsp;•&nbsp; Catatan dan riwayat perizinan siswa di pos satpam</p>
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

    <!-- Main Card: Log Aktivitas Terbaru -->
    <div class="dashboard-card activity-log-card">
        <div class="activity-log-header">
            <div>
                <h2 class="activity-log-title">Daftar Log Aktivitas Dispen</h2>
                <p class="activity-log-subtitle">
                    {{ \Carbon\Carbon::now()->translatedFormat('l') }} {{ min($logs->count(), 15) }} dari {{ $logs->total() }} sesi ditampilkan
                </p>
            </div>
            <a href="{{ route('satpam.log-aktivitas') }}" class="link-lihat-semua">Refresh</a>
        </div>

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

                <div class="activity-item">
                    <div class="activity-icon-wrapper {{ $iconClass }}">
                        <i class="fa-solid {{ $iconSymbol }}"></i>
                    </div>

                    <div class="activity-content-box">
                        <div class="activity-header-line">
                            <h4 class="student-name">{{ $d->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan' }} ({{ $d->kelas->nama_kelas ?? '-' }})</h4>
                            <span class="activity-time">{{ $timeFormatted }}</span>
                        </div>

                        <div class="activity-detail-line">
                            <span class="detail-reason">Izin Keluar - {{ $d->alasan }}</span>
                        </div>

                        <div class="activity-footer-line">
                            <span class="status-badge {{ $badgeClass }}">{{ $badgeText }}</span>

                            <div class="action-btn-group">
                                <button type="button" class="btn-detail-sm" onclick='openDetailModal(@json($d))'>
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                @if($isApprovedWaka)
                                    <form action="{{ route('satpam.update-status', $d->id_siswa_dispen) }}" method="POST" class="inline-action-form">
                                        @csrf
                                        @if($d->status_satpam === 'belum_keluar')
                                            <button type="submit" name="status_satpam" value="dizinkan_keluar" class="btn-action-sm btn-action-blue">
                                                <i class="fa-solid fa-door-open"></i> Izinkan Keluar
                                            </button>
                                        @elseif($d->status_satpam === 'dizinkan_keluar')
                                            <button type="submit" name="status_satpam" value="sudah_kembali" class="btn-action-sm btn-action-navy">
                                                <i class="fa-solid fa-door-closed"></i> Konfirmasi Kembali
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <span class="text-warning-hold" title="Siswa belum bisa keluar gate karena izin belum disetujui Waka"><i class="fa-solid fa-clock"></i> Perlu Persetujuan Waka</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-log-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <p>Tidak ditemukan data log aktivitas dispen.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper" style="margin-top: 24px;">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>

</div>

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
@endsection

@section('styles')
<style>
    .log-aktivitas-page-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
    }

    /* Custom Header Page Title Style (Matching TU Style) */
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

    /* Activity Log Card */
    .activity-log-card {
        padding: 24px;
    }

    .activity-log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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

    .link-lihat-semua {
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .link-lihat-semua:hover {
        color: #1d4ed8;
        text-decoration: underline;
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
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: all 0.15s ease;
    }

    .activity-content-box:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.05);
    }

    .activity-header-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .student-name {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .activity-time {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    .activity-detail-line {
        font-size: 12.5px;
        color: #4b5563;
        font-weight: 600;
    }

    .detail-reason {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 8px;
        color: #334155;
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

    .text-warning-hold {
        font-size: 11.5px;
        color: #c2410c;
        font-weight: 700;
    }

    .empty-log-state {
        text-align: center;
        padding: 36px 16px;
        color: #94a3b8;
    }

    .empty-log-state i {
        font-size: 36px;
        margin-bottom: 8px;
    }

    /* Modal Detail Dispen Custom Overlay */
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

        let fotoSiswaLiveSrc = item.foto_siswa_live ? formatImageUrl(item.foto_siswa_live) : null;
        let fotoKartuSrc = item.foto_kartu_identitas ? formatImageUrl(item.foto_kartu_identitas) : null;
        let fotoSuratSrc = item.foto_surat_dispen ? formatImageUrl(item.foto_surat_dispen) : null;
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
</script>
@endsection
