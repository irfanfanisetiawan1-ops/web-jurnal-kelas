@extends('layouts.guru')

@section('title', 'Dashboard Satpam — Jurnal SMEA')

@section('content')
<div class="satpam-dashboard-wrapper">

    <!-- Header Page Title & Subtitle matching TU style -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Dashboard Satpam</h1>
            <p>{{ $formattedDate ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} &nbsp;•&nbsp; Ringkasan operasional dan validasi presensi siswa hari ini</p>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="satpam-grid-layout">

        <!-- Left Column: Scan Barcode Siswa Card -->
        <div class="dashboard-card scanner-card">
            <div class="scanner-card-body">
                <div class="barcode-illustration">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                        <path d="M14 14h3v3h-3z"></path>
                        <path d="M18 18h3v3h-3z"></path>
                        <path d="M18 14h3"></path>
                        <path d="M14 18v3"></path>
                    </svg>
                </div>
                
                <h2 class="scanner-card-title">Scan Barcode Siswa</h2>
                <p class="scanner-card-desc">
                    Arahkan kamera ke barcode izin keluar/masuk siswa untuk melakukan validasi instan.
                </p>

                <button type="button" class="btn-buka-kamera" id="btnToggleCamera" onclick="toggleCameraScanner()">
                    <i class="fa-solid fa-camera"></i> BUKA KAMERA
                </button>

                <!-- Camera QR Scanner Container (Hidden by default, shown on click) -->
                <div id="cameraScannerBox" class="camera-scanner-container" style="display: none;">
                    <div id="reader"></div>
                    <div class="scanner-help-text"><i class="fa-solid fa-circle-info"></i> Posisikan kode QR di tengah bingkai kamera</div>
                </div>

                <!-- Search Input Form -->
                <form id="satpamSearchForm" onsubmit="handleManualSearch(event)" class="satpam-search-form">
                    <div class="search-input-wrapper">
                        <input type="text" id="satpamQueryInput" class="form-control-satpam" placeholder="Ketik Kode Dispen / NISN / Nama Siswa..." required>
                        <button type="submit" class="btn-search-satpam" title="Cari Data">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

                <!-- Dynamic Search Result Box -->
                <div id="satpamSearchResult" class="search-result-box" style="display: none;">
                    <div id="satpamResultContent"></div>
                </div>
            </div>
        </div>

        <!-- Right Column: Stat Cards -->
        <div class="stats-column">
            
            <!-- Stat Card 1: Izin Keluar Hari Ini -->
            <div class="dashboard-card stat-card">
                <div class="stat-header">
                    <span class="stat-title">IZIN KELUAR HARI INI</span>
                    <div class="stat-icon-badge badge-orange">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </div>
                </div>
                <div class="stat-value" id="statTotalIzin">{{ $totalIzinKeluarHariIni ?? 0 }}</div>
            </div>

            <!-- Stat Card 2: Menunggu Validasi -->
            <div class="dashboard-card stat-card">
                <div class="stat-header">
                    <span class="stat-title">MENUNGGU VALIDASI</span>
                    <div class="stat-icon-badge badge-red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="stat-value" id="statMenunggu">{{ $totalMenungguValidasi ?? 0 }}</div>
            </div>

        </div>

    </div>

    <!-- Bottom Section: Log Aktivitas Terbaru -->
    <div class="dashboard-card activity-log-card">
        <div class="activity-log-header">
            <div>
                <h3 class="activity-log-title">Log Aktivitas Terbaru</h3>
                <p class="activity-log-subtitle">
                    {{ \Carbon\Carbon::now()->translatedFormat('l') }} {{ min($dispenList->count(), 6) }} dari {{ $totalSesiHariIni ?? $dispenList->count() }} sesi ditampilkan
                </p>
            </div>
            <a href="{{ route('satpam.log-aktivitas') }}" class="link-lihat-semua">Lihat semua</a>
        </div>

        <div class="activity-list" id="activityLogList">
            @forelse($dispenList->take(6) as $d)
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
                                            <button type="submit" name="status_satpam" value="sudah_kembali" class="btn-action-sm btn-action-purple">
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
                    <p>Belum ada log aktivitas izin siswa hari ini.</p>
                </div>
            @endforelse
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

    /* Custom Styling Override untuk Camera Scanner & File Upload HTML5-QRCode */
    #reader {
        border: 2px dashed #3b82f6 !important;
        border-radius: 14px !important;
        background: #ffffff !important;
        padding: 16px !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03) !important;
    }
    #reader button {
        background: #2563eb !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 18px !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
        font-size: 13px !important;
        cursor: pointer !important;
        margin: 6px 4px !important;
        font-family: inherit !important;
        transition: background 0.15s ease !important;
    }
    #reader button:hover {
        background: #1d4ed8 !important;
    }
    #reader a {
        color: #2563eb !important;
        font-weight: 800 !important;
        text-decoration: none !important;
        font-size: 13px !important;
        display: inline-block !important;
        margin-top: 8px !important;
    }
    #reader select {
        padding: 8px 12px !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    /* Styling khusus Dashboard Satpam */
    .satpam-dashboard-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
    }

    /* Grid Layout - Fixed height stretching with align-items: flex-start */
    .satpam-grid-layout {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
        align-items: flex-start;
    }

    /* Base Card Style */
    .dashboard-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        padding: 24px;
    }

    /* Scanner Card */
    .scanner-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .scanner-card-body {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .barcode-illustration {
        color: #0f172a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .scanner-card-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
    }

    .scanner-card-desc {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
        margin: 0 0 20px 0;
        line-height: 1.5;
    }

    .btn-buka-kamera {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
        margin-bottom: 16px;
    }

    .btn-buka-kamera:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    }

    .camera-scanner-container {
        width: 100%;
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        padding: 10px;
    }

    .scanner-help-text {
        font-size: 11px;
        color: #64748b;
        margin-top: 8px;
        font-weight: 600;
    }

    .satpam-search-form {
        width: 100%;
    }

    .search-input-wrapper {
        display: flex;
        gap: 8px;
        width: 100%;
    }

    .form-control-satpam {
        flex: 1;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        font-family: inherit;
        color: #1e293b;
        transition: all 0.2s ease;
    }

    .form-control-satpam:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-search-satpam {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 0 16px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s ease;
    }

    .btn-search-satpam:hover {
        background: #2563eb;
    }

    .search-result-box {
        width: 100%;
        margin-top: 14px;
        text-align: left;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 14px;
    }

    /* Stats Column - Compact height without stretching */
    .stats-column {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
    }

    .stat-card {
        height: auto;
        min-height: 125px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px 22px;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-title {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #475569;
        text-transform: uppercase;
    }

    .stat-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #ffffff;
    }

    .badge-orange {
        background: #f97316;
    }

    .badge-red {
        background: #dc2626;
    }

    .stat-value {
        font-size: 38px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-top: 14px;
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
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0 0;
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
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-done {
        background: #a7f3d0;
        color: #047857;
    }

    .icon-rejected {
        background: #fecaca;
        color: #b91c1c;
    }

    .icon-pending {
        background: #fef08a;
        color: #a16207;
    }

    .icon-warning {
        background: #ffedd5;
        color: #c2410c;
    }

    .activity-content-box {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .activity-header-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .student-name {
        font-size: 14px;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .activity-time {
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
    }

    .activity-detail-line {
        font-size: 12px;
        color: #4b5563;
        font-weight: 600;
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

    .btn-action-purple {
        background: #7c3aed;
        color: #ffffff;
    }

    .text-warning-hold {
        font-size: 11.5px;
        color: #c2410c;
        font-weight: 700;
    }

    .empty-log-state {
        text-align: center;
        padding: 32px 16px;
        color: #94a3b8;
    }

    .empty-log-state i {
        font-size: 32px;
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

    @media (max-width: 992px) {
        .satpam-grid-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('scripts')
<!-- Include HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;
    let cameraActive = false;

    // Helper untuk format URL gambar agar terhindar dari broken link
    function formatImageUrl(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://')) return path;
        if (path.startsWith('/')) return path;
        return '{{ asset("") }}' + path;
    }

    function toggleCameraScanner() {
        const box = document.getElementById('cameraScannerBox');
        const btn = document.getElementById('btnToggleCamera');

        if (!cameraActive) {
            box.style.display = 'block';
            btn.innerHTML = '<i class="fa-solid fa-stop"></i> TUTUP KAMERA';
            btn.style.background = '#dc2626';

            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 } 
                }, false);
            }
            html5QrcodeScanner.render(onScanSuccess);
            startIndonesianScannerTranslation();
            cameraActive = true;
        } else {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            if (scannerTranslateTimer) clearInterval(scannerTranslateTimer);
            box.style.display = 'none';
            btn.innerHTML = '<i class="fa-solid fa-camera"></i> BUKA KAMERA';
            btn.style.background = '#2563eb';
            cameraActive = false;
        }
    }

    function triggerNativeCameraSatpam() {
        let nativeInput = document.getElementById('nativeCameraInputSatpam');
        if (!nativeInput) {
            nativeInput = document.createElement('input');
            nativeInput.type = 'file';
            nativeInput.id = 'nativeCameraInputSatpam';
            nativeInput.accept = 'image/*';
            nativeInput.setAttribute('capture', 'environment');
            nativeInput.style.display = 'none';
            nativeInput.onchange = handleNativeCameraUploadSatpam;
            document.body.appendChild(nativeInput);
        }
        nativeInput.click();
    }

    function handleNativeCameraUploadSatpam(event) {
        const file = event.target.files[0];
        if (!file) return;

        const resBox = document.getElementById('satpamSearchResult');
        const content = document.getElementById('satpamResultContent');
        if (resBox && content) {
            resBox.style.display = 'block';
            content.innerHTML = '<div style="color: #2563eb; font-weight: 700; padding: 14px; text-align: center;"><i class="fa-solid fa-spinner fa-spin"></i> Membaca data barcode dari kamera...</div>';
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.scanFile(file, true)
            .then(decodedText => {
                document.getElementById('satpamQueryInput').value = decodedText;
                doSearchQuery(decodedText);
            })
            .catch(err => {
                if (resBox && content) {
                    content.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 800; color: #dc2626; text-transform: uppercase;">Hasil Scan Kamera</span>
                            <button type="button" onclick="resetSatpamSearchResult()" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        </div>
                        <div style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> Barcode tidak dapat dibaca dari foto kamera. Pastikan posisi barcode terang & tidak buram, lalu coba foto kembali!</div>
                    `;
                }
            });
    }

    let scannerTranslateTimer = null;
    function startIndonesianScannerTranslation() {
        if (scannerTranslateTimer) clearInterval(scannerTranslateTimer);
        scannerTranslateTimer = setInterval(function() {
            const fileBtn = document.getElementById('html5-qrcode-button-file-selection');
            if (fileBtn && (fileBtn.innerText.includes('Choose Image') || fileBtn.innerText.includes('Choose Another') || fileBtn.innerText.includes('chosen'))) {
                fileBtn.innerText = '📁 Pilih Foto Barcode / QR Code';
            }

            const permBtn = document.getElementById('html5-qrcode-button-camera-permission');
            if (permBtn) {
                if (permBtn.innerText.includes('Request')) {
                    permBtn.innerText = '🎥 Izinkan Akses Kamera Satpam';
                }
                if (!window.isSecureContext) {
                    permBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        triggerNativeCameraSatpam();
                    };
                }
            }

            const startBtn = document.getElementById('html5-qrcode-button-camera-start');
            if (startBtn && startBtn.innerText.includes('Start')) {
                startBtn.innerText = '▶ Mulai Kamera Scanner';
            }

            const stopBtn = document.getElementById('html5-qrcode-button-camera-stop');
            if (stopBtn && stopBtn.innerText.includes('Stop')) {
                stopBtn.innerText = '⏹ Hentikan Kamera Scanner';
            }

            const anchor = document.getElementById('html5-qrcode-anchor-scan-type-change');
            if (anchor) {
                if (anchor.innerText.includes('camera directly') || anchor.innerText.includes('camera')) {
                    anchor.innerText = '📷 Ganti ke Mode Kamera Scanner Langsung';
                } else if (anchor.innerText.includes('file') || anchor.innerText.includes('image') || anchor.innerText.includes('Scan an Image File')) {
                    anchor.innerText = '🖼 Ganti ke Mode Upload File Foto Barcode';
                }
            }

            const readerDiv = document.getElementById('reader');
            if (readerDiv) {
                const allElements = readerDiv.querySelectorAll('div, span, p, label');
                allElements.forEach(el => {
                    if (el.children.length === 0 && el.innerText.includes('Or drop an image to scan')) {
                        el.innerText = 'Atau seret & lepas file gambar barcode di sini';
                    }
                    if (el.children.length === 0 && (el.innerText.includes('secure context') || el.innerText.includes('https or localhost'))) {
                        el.parentNode.innerHTML = `
                            <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 12px; text-align: center;">
                                <i class="fa-solid fa-camera-retro" style="color: #10b981; font-size: 18px; margin-bottom: 4px;"></i><br>
                                Mode Kamera Perangkat Siap Digunakan!<br>
                                <span style="font-size: 11.5px; font-weight: 600; color: #047857;">Sistem mendeteksi akses jaringan HTTP. Klik tombol hijau di bawah untuk mengambil foto barcode langsung dengan kamera HP/Perangkat.</span>
                            </div>
                            <button type="button" onclick="triggerNativeCameraSatpam()" style="width: 100%; background: #16a34a; color: white; border: none; padding: 12px 18px; border-radius: 12px; font-weight: 800; font-size: 13.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(22,163,74,0.3);">
                                <i class="fa-solid fa-camera-retro"></i> AMBIL FOTO BARCODE KAMERA
                            </button>
                        `;
                    }
                });
            }
        }, 150);
    }

    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('satpamQueryInput').value = decodedText;
        doSearchQuery(decodedText);
    }

    function handleManualSearch(e) {
        e.preventDefault();
        const query = document.getElementById('satpamQueryInput').value;
        doSearchQuery(query);
    }

    function resetSatpamSearchResult() {
        // 1. Reset input value
        const input = document.getElementById('satpamQueryInput');
        if (input) input.value = '';

        // 2. Sembunyikan & bersihkan kotak hasil pencarian
        const resBox = document.getElementById('satpamSearchResult');
        const resContent = document.getElementById('satpamResultContent');
        if (resBox) resBox.style.display = 'none';
        if (resContent) resContent.innerHTML = '';

        // 3. Reset input file foto barcode
        const fileInputs = document.querySelectorAll('#reader input[type="file"]');
        fileInputs.forEach(fileInput => { fileInput.value = ''; });

        // 4. Reset scanner DOM & re-render jika sedang aktif
        if (html5QrcodeScanner) {
            try {
                html5QrcodeScanner.clear().then(() => {
                    if (cameraActive) {
                        html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
                            fps: 10, 
                            qrbox: { width: 250, height: 250 } 
                        }, false);
                        html5QrcodeScanner.render(onScanSuccess);
                        startIndonesianScannerTranslation();
                    }
                }).catch(err => {
                    if (cameraActive) {
                        document.getElementById('reader').innerHTML = '';
                        html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
                            fps: 10, 
                            qrbox: { width: 250, height: 250 } 
                        }, false);
                        html5QrcodeScanner.render(onScanSuccess);
                        startIndonesianScannerTranslation();
                    }
                });
            } catch (e) {
                if (cameraActive) {
                    document.getElementById('reader').innerHTML = '';
                    html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
                        fps: 10, 
                        qrbox: { width: 250, height: 250 } 
                    }, false);
                    html5QrcodeScanner.render(onScanSuccess);
                    startIndonesianScannerTranslation();
                }
            }
        }

        if (input) input.focus();
    }

    function doSearchQuery(query) {
        fetch('{{ route("satpam.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ q: query })
        })
        .then(res => res.json())
        .then(data => {
            const resBox = document.getElementById('satpamSearchResult');
            const content = document.getElementById('satpamResultContent');
            resBox.style.display = 'block';

            if (!data.success) {
                content.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size: 11px; font-weight: 800; color: #dc2626; text-transform: uppercase;">Hasil Scan Barcode</span>
                        <button type="button" onclick="resetSatpamSearchResult()" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                    <div style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> ${data.message}</div>
                `;
                return;
            }

            const d = data.data;
            let barcodeBadge = '';
            if (d.barcode_status === 'aktif') {
                barcodeBadge = `
                    <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 10px 14px; border-radius: 10px; font-weight: 800; font-size: 12.5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
                        <div>
                            <div>BARCODE AKTIF (Bisa Di-scan & Diperiksa)</div>
                            <div style="font-size: 11px; font-weight: 600; color: #166534;">Telah disetujui Waka (${d.nama_waka}). Klik 'Validasi Data Sesuai' di bawah untuk memproses izin keluar.</div>
                        </div>
                    </div>
                `;
            } else {
                barcodeBadge = `
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 10px 14px; border-radius: 10px; font-weight: 800; font-size: 12.5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-lock" style="font-size: 18px; color: #dc2626;"></i>
                        <div>
                            <div>BARCODE TELAH DIVALIDASI & TIDAK DAPAT DIGUNAKAN LAGI</div>
                            <div style="font-size: 11px; font-weight: 600; color: #991b1b;">Waktu Validasi: ${d.waktu_scan_satpam || 'Sudah divalidasi Satpam'}. Barcode telah kadaluarsa.</div>
                        </div>
                    </div>
                `;
            }

            let fotoKartuHtml = '';
            let fotoKartuSrc = d.foto_kartu_identitas ? formatImageUrl(d.foto_kartu_identitas) : null;
            if (fotoKartuSrc) {
                fotoKartuHtml = `
                    <div style="margin-top: 10px; padding: 10px; background: #ffffff; border-radius: 10px; border: 1px solid #cbd5e1; text-align: center;">
                        <div style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;"><i class="fa-solid fa-address-card" style="color: #10b981;"></i> Foto Kartu Identitas / Pelajar Siswa:</div>
                        <a href="${fotoKartuSrc}" target="_blank">
                            <img src="${fotoKartuSrc}" style="max-width: 100%; max-height: 180px; object-fit: contain; border-radius: 6px;" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x180?text=Gambar+Identitas';">
                        </a>
                        <div style="font-size: 10.5px; color: #059669; margin-top: 4px; font-weight: 700;">Satpam: Periksa & cocokkan fisik kartu ini dengan siswa di pintu gerbang.</div>
                    </div>
                `;
            }

            let actionForm = '';
            if (d.barcode_status === 'aktif') {
                const updateUrl = `{{ url('/satpam/update-status') }}/${d.id_siswa_dispen}`;
                actionForm = `
                    <form action="${updateUrl}" method="POST" style="margin-top: 14px;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="status_satpam" value="dizinkan_keluar">
                        <button type="submit" style="width: 100%; background: #16a34a; color: white; border: none; padding: 12px 16px; border-radius: 12px; font-weight: 800; font-size: 13.5px; cursor: pointer; transition: background 0.15s ease;" onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                            <i class="fa-solid fa-shield-check"></i> VALIDASI DATA SESUAI & IZINKAN KELUAR
                        </button>
                    </form>
                `;
            }

            content.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #e2e8f0;">
                    <span style="font-size: 11.5px; font-weight: 800; color: #3b82f6; text-transform: uppercase;"><i class="fa-solid fa-qrcode"></i> Hasil Pemindaian Barcode</span>
                    <button type="button" onclick="resetSatpamSearchResult()" style="background: #e2e8f0; color: #475569; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Scan
                    </button>
                </div>
                ${barcodeBadge}
                <h4 style="margin: 0; color: #1e293b; font-size: 15px; font-weight: 800;">${d.nama_siswa} (${d.kelas})</h4>
                <p style="margin: 4px 0; font-size: 12.5px; color: #64748b;">Kode: <strong>${d.kode_dispen}</strong> | Tanggal: <strong>${d.tanggal || '-'}</strong></p>
                <p style="margin: 4px 0; font-size: 12.5px; color: #64748b;">Jam Keluar: <strong>${d.jam_keluar}</strong> s/d <strong>${d.jam_kembali}</strong></p>
                <p style="margin: 4px 0; font-size: 12.5px; color: #64748b;">Disetujui Waka: <strong>${d.nama_waka}</strong> (${d.waktu_approval_waka})</p>
                <p style="margin: 4px 0; font-size: 12.5px; color: #64748b;">Alasan Dispen: "${d.alasan}"</p>
                ${fotoKartuHtml}
                ${actionForm}
            `;
        });
    }

    // Detail Modal Functionality
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

                ${(fotoKartuSrc || fotoSuratSrc || fotoSiswaSrc) ? `
                <div class="detail-section-title"><i class="fa-solid fa-image"></i> Lampiran & Bukti Foto Pengajuan</div>
                <div class="detail-image-box">
                    ${fotoKartuSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Kartu Identitas Siswa:</div><a href="${fotoKartuSrc}" target="_blank"><img src="${fotoKartuSrc}" alt="Foto Identitas" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Gambar+Identitas';"></a></div>` : ''}
                    ${fotoSuratSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Surat Dispen:</div><a href="${fotoSuratSrc}" target="_blank"><img src="${fotoSuratSrc}" alt="Surat Dispen" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Surat+Dispen';"></a></div>` : ''}
                    ${fotoSiswaSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;">Foto Siswa:</div><a href="${fotoSiswaSrc}" target="_blank"><img src="${fotoSiswaSrc}" alt="Foto Profil Siswa" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Foto+Siswa';"></a></div>` : ''}
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
                        <button type="submit" class="btn-action-sm btn-action-purple" style="width: 100%; justify-content: center; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 10px;">
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

    // Realtime polling every 5 seconds for Satpam Dashboard stats
    setInterval(function() {
        fetch('{{ route("satpam.live-poll") }}')
            .then(res => res.json())
            .then(data => {
                if (data) {
                    const elIzin = document.getElementById('statTotalIzin');
                    const elMenunggu = document.getElementById('statMenunggu');
                    if (elIzin && data.total_izin_keluar !== undefined) elIzin.innerText = data.total_izin_keluar;
                    if (elMenunggu && data.total_menunggu !== undefined) elMenunggu.innerText = data.total_menunggu;
                }
            });
    }, 5000);
</script>
@endsection
