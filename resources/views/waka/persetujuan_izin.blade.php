@extends('layouts.waka')

@section('title', 'Persetujuan Dispensasi Siswa — Jurnal SMEA')

@section('styles')
<style>
    /* Container & Layout */
    .persetujuan-container {
        display: flex;
        flex-direction: column;
        gap: 18px;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
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

    /* 4 Stat Cards Row - Fluid Grid */
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
    .icon-amber  { background: #fef3c7; color: #d97706; }
    .icon-green  { background: #dcfce7; color: #16a34a; }
    .icon-red    { background: #fee2e2; color: #dc2626; }

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
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-top: 2px;
    }

    /* Main Table Panel */
    .table-panel-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 18px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Quick Filter Period Tabs */
    .quick-period-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .tab-period-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.15s ease;
        font-family: inherit;
    }

    .tab-period-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .tab-period-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .tab-badge {
        background: rgba(0, 0, 0, 0.08);
        padding: 1px 6px;
        border-radius: 12px;
        font-size: 10.5px;
    }

    .tab-period-btn.active .tab-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .tab-badge-pulse {
        background: #ef4444;
        color: #ffffff;
        padding: 1px 6px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
    }

    /* Filter Toolbar - Flexible Responsive Layout */
    .filter-toolbar {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
        width: 100%;
    }

    .filter-row-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        width: 100%;
    }

    .filter-inputs-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        flex: 1;
        min-width: 0;
    }

    .form-control-custom {
        padding: 7px 11px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 12.5px;
        font-family: inherit;
        background: #ffffff;
        color: #1e293b;
        outline: none;
        transition: all 0.15s ease;
        box-sizing: border-box;
        height: 36px;
    }

    .form-control-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .input-search-box {
        flex: 1 1 180px;
        min-width: 150px;
        max-width: 260px;
    }

    .select-box-item {
        flex: 0 0 auto;
        min-width: 125px;
    }

    .input-date-box {
        flex: 0 0 auto;
        width: 135px;
    }

    .filter-actions-row {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Action Buttons */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 12px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.15s ease;
        font-family: inherit;
        height: 36px;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
    }
    .btn-primary:hover { background: #1d4ed8; }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }

    .btn-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecdd3;
    }
    .btn-danger:hover { background: #dc2626; color: #ffffff; }

    .btn-trash-view {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .btn-trash-view:hover { background: #fde68a; }

    .badge-counter {
        background: #d97706;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 20px;
        margin-left: 2px;
    }

    /* Active Filter Alert Bar */
    .active-filter-banner {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 12.5px;
        color: #0369a1;
        font-weight: 600;
    }

    /* Table Container - Isolated Smooth Scroll */
    .table-responsive-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    /* Custom Scrollbar */
    .table-responsive-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .table-responsive-wrapper::-webkit-scrollbar-track {
        background: #f8fafc;
    }
    .table-responsive-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-responsive-wrapper::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .custom-table {
        width: 100%;
        min-width: 980px;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .custom-table thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table th {
        padding: 10px 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        white-space: nowrap;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }

    .custom-table tbody tr:hover {
        background: #f8fafc;
    }

    .custom-table td {
        padding: 10px 12px;
        color: #1e293b;
        vertical-align: middle;
    }

    .kode-badge {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 11px;
        font-weight: 800;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 6px;
        border-radius: 5px;
        border: 1px solid #bfdbfe;
        white-space: nowrap;
    }

    .student-cell {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }

    .student-name {
        font-weight: 800;
        color: #0f172a;
        font-size: 12.5px;
    }

    .student-nisn {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    /* Status Badges */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
        line-height: 1.2;
    }

    .status-approved { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .status-pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fecdd3; }
    .status-neutral  { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    /* Action Buttons in Table */
    .table-actions {
        display: flex;
        align-items: center;
        gap: 4px;
        justify-content: flex-end;
        white-space: nowrap;
    }

    .btn-tbl {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-tbl-detail { background: #475569; color: #ffffff; }
    .btn-tbl-detail:hover { background: #334155; }

    .btn-tbl-approve { background: #16a34a; color: #ffffff; }
    .btn-tbl-approve:hover { background: #15803d; }

    .btn-tbl-reject { background: #ea580c; color: #ffffff; }
    .btn-tbl-reject:hover { background: #c2410c; }

    .btn-tbl-delete { background: #fee2e2; color: #dc2626; border: 1px solid #fecdd3; padding: 4px 6px; }
    .btn-tbl-delete:hover { background: #dc2626; color: #ffffff; }

    /* Modals */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-card {
        background: #ffffff;
        width: 100%;
        max-width: 620px;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        border: 1px solid #cbd5e1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        padding: 16px 20px;
        background: #2b3957;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 15.5px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: #cbd5e1;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.15s ease;
    }
    .modal-close-btn:hover { color: #ffffff; }

    .modal-body {
        padding: 18px 20px;
        overflow-y: auto;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .modal-footer {
        padding: 12px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .info-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .info-box-item {
        background: #f8fafc;
        padding: 9px 12px;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
    }

    .info-box-item .lbl {
        font-size: 10.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-box-item .val {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }

    .photo-preview-box {
        border-radius: 9px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        background: #0f172a;
        text-align: center;
        max-height: 220px;
    }

    .photo-preview-box img {
        max-width: 100%;
        max-height: 220px;
        object-fit: contain;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1200px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
        .filter-inputs-row {
            width: 100%;
        }
        .input-search-box {
            max-width: 100%;
        }
        .info-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="persetujuan-container">

    <!-- Flash Alert Success / Error -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 10px; font-weight: 700; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 8px; font-size: 13px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; font-weight: 700; border: 1px solid #fecdd3; display: flex; align-items: center; gap: 8px; font-size: 13px;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 16px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header-box">
        <div>
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 2px;">
                Jurnal SMEA &gt; Kesiswaan &gt; <span style="color: #2563eb;">Persetujuan Dispensasi Siswa</span>
            </div>
            <h1 class="page-main-title">Persetujuan Dispensasi Siswa</h1>
            <p class="page-sub-title">Kelola, verifikasi, setujui, dan tolak permohonan izin dispensasi keluar/masuk sekolah siswa secara real-time.</p>
        </div>
    </div>

    <!-- 4 Stat Cards Row -->
    <div class="stat-cards-grid">
        <!-- Total Dispen -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-id-card"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Total Permohonan</span>
                <span class="stat-count">{{ number_format($stats['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Menunggu Persetujuan Waka (Pending) -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-amber">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Menunggu Waka</span>
                <span class="stat-count" style="color: #d97706;">{{ number_format($stats['pending'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Disetujui Waka -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Disetujui Waka</span>
                <span class="stat-count" style="color: #16a34a;">{{ number_format($stats['approved'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Ditolak Waka -->
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="stat-info-group">
                <span class="stat-title">Ditolak Waka</span>
                <span class="stat-count" style="color: #dc2626;">{{ number_format($stats['rejected'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Table Panel Card -->
    <div class="table-panel-card">

        <!-- Quick Filter Period Tabs (Hari Ini / Terbaru / Bulan Ini / Semua) -->
        <div class="quick-period-tabs">
            <span style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-right: 4px;">
                <i class="fa-solid fa-filter"></i> Periode:
            </span>

            <a href="{{ route('waka.persetujuan-izin', array_merge(request()->except(['periode', 'tanggal_dispen']), ['periode' => 'all'])) }}"
               class="tab-period-btn {{ ($periode === 'all' || !$periode) && !$tanggalDispen ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Semua Data
                <span class="tab-badge">{{ $stats['total'] }}</span>
            </a>

            <a href="{{ route('waka.persetujuan-izin', array_merge(request()->except(['periode', 'tanggal_dispen']), ['periode' => 'hari_ini'])) }}"
               class="tab-period-btn {{ $periode === 'hari_ini' ? 'active' : '' }}">
                <i class="fa-solid fa-bolt-lightning" style="color: #f59e0b;"></i> Hari Ini (Saat Ini)
                <span class="tab-badge">{{ $stats['today_total'] }}</span>
                @if(($stats['today_pending'] ?? 0) > 0)
                    <span class="tab-badge-pulse" title="{{ $stats['today_pending'] }} dispensasi baru hari ini">{{ $stats['today_pending'] }} Baru</span>
                @endif
            </a>

            <a href="{{ route('waka.persetujuan-izin', array_merge(request()->except(['periode', 'tanggal_dispen']), ['periode' => 'terbaru'])) }}"
               class="tab-period-btn {{ $periode === 'terbaru' ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Terbaru (7 Hari)
            </a>

            <a href="{{ route('waka.persetujuan-izin', array_merge(request()->except(['periode', 'tanggal_dispen']), ['periode' => 'bulan_ini'])) }}"
               class="tab-period-btn {{ $periode === 'bulan_ini' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i> Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
            </a>
        </div>

        @if($periode === 'hari_ini')
            <div class="active-filter-banner">
                <div>
                    <i class="fa-solid fa-circle-info" style="color: #0284c7; margin-right: 4px;"></i>
                    Menampilkan data permohonan dispensasi siswa khusus <strong>Hari Ini ({{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }})</strong>
                </div>
                <a href="{{ route('waka.persetujuan-izin', array_merge(request()->except(['periode', 'tanggal_dispen']), ['periode' => 'all'])) }}" style="color: #0369a1; font-size: 11.5px; font-weight: 700; text-decoration: underline;">
                    Lihat Semua
                </a>
            </div>
        @elseif($tanggalDispen)
            <div class="active-filter-banner">
                <div>
                    <i class="fa-solid fa-calendar-day" style="color: #0284c7; margin-right: 4px;"></i>
                    Menampilkan data dispensasi pada tanggal <strong>{{ \Carbon\Carbon::parse($tanggalDispen)->translatedFormat('l, d F Y') }}</strong>
                </div>
                <a href="{{ route('waka.persetujuan-izin') }}" style="color: #0369a1; font-size: 11.5px; font-weight: 700; text-decoration: underline;">
                    Reset Filter Tanggal
                </a>
            </div>
        @endif

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="{{ route('waka.persetujuan-izin') }}" class="filter-toolbar">
            <input type="hidden" name="periode" value="{{ $periode }}">

            <div class="filter-row-container">
                <!-- Filter Inputs Group -->
                <div class="filter-inputs-row">
                    <input type="text" name="search_dispen" value="{{ $searchDispen }}" placeholder="Cari kode, nama siswa, NISN, alasan..." class="form-control-custom input-search-box">
                    
                    <select name="status_dispen" class="form-control-custom select-box-item">
                        <option value="all" {{ $statusDispen === 'all' || !$statusDispen ? 'selected' : '' }}>-- Status Persetujuan --</option>
                        <option value="pending" {{ $statusDispen === 'pending' ? 'selected' : '' }}>Menunggu Waka (Pending)</option>
                        <option value="approved" {{ $statusDispen === 'approved' ? 'selected' : '' }}>Disetujui Waka (Approved)</option>
                        <option value="rejected" {{ $statusDispen === 'rejected' ? 'selected' : '' }}>Ditolak Waka (Rejected)</option>
                    </select>

                    <select name="status_satpam" class="form-control-custom select-box-item">
                        <option value="all" {{ $statusSatpam === 'all' || !$statusSatpam ? 'selected' : '' }}>-- Status Pos Satpam --</option>
                        <option value="belum_keluar" {{ $statusSatpam === 'belum_keluar' ? 'selected' : '' }}>Belum Keluar</option>
                        <option value="dizinkan_keluar" {{ $statusSatpam === 'dizinkan_keluar' ? 'selected' : '' }}>Sedang di Luar</option>
                        <option value="sudah_kembali" {{ $statusSatpam === 'sudah_kembali' || $statusSatpam === 'kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                        <option value="ditolak" {{ $statusSatpam === 'ditolak' ? 'selected' : '' }}>Ditolak Satpam</option>
                    </select>

                    <select name="id_kelas" class="form-control-custom select-box-item">
                        <option value="all" {{ $idKelas === 'all' || !$idKelas ? 'selected' : '' }}>-- Semua Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelas == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="tanggal_dispen" value="{{ $tanggalDispen }}" class="form-control-custom input-date-box" title="Filter Tanggal Spesifik">

                    <button type="submit" class="btn-custom btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    @if($searchDispen || ($statusDispen && $statusDispen !== 'all') || ($statusSatpam && $statusSatpam !== 'all') || ($idKelas && $idKelas !== 'all') || $tanggalDispen || ($periode && $periode !== 'all'))
                        <a href="{{ route('waka.persetujuan-izin') }}" class="btn-custom btn-secondary" title="Kembalikan ke semua data">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    @endif
                </div>

                <!-- Action Buttons Group -->
                <div class="filter-actions-row">
                    <button type="button" class="btn-custom btn-danger" onclick="submitBatchDelete()">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
                    </button>
                    <a href="{{ route('waka.siswa-dispen.trash') }}" class="btn-custom btn-trash-view">
                        <i class="fa-solid fa-trash-can"></i> Sampah Dispen
                        @if(($trashedSiswaDispenCount ?? 0) > 0)
                            <span class="badge-counter">{{ $trashedSiswaDispenCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </form>

        <!-- Batch Delete Form & Responsive Table Wrapper -->
        <form id="formBatchDispen" method="POST" action="{{ route('waka.siswa-dispen.batch-delete') }}">
            @csrf
            <div class="table-responsive-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)" style="cursor: pointer;">
                            </th>
                            <th style="width: 115px;">Kode Dispen</th>
                            <th>Nama Siswa &amp; NISN</th>
                            <th style="width: 120px;">Kelas &amp; Wali Kelas</th>
                            <th style="width: 95px;">Tanggal</th>
                            <th style="width: 100px;">Waktu</th>
                            <th>Alasan / Tempat</th>
                            <th style="width: 120px;">Status Persetujuan</th>
                            <th style="width: 110px;">Status Satpam</th>
                            <th style="width: 120px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaDispenList as $sd)
                            @php
                                $detailPayload = [
                                    'id'                 => $sd->id_siswa_dispen,
                                    'kode_dispen'        => $sd->kode_dispen ?? '-',
                                    'nama_siswa'         => $sd->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan',
                                    'nisn'               => $sd->siswa->nisn ?? ($sd->siswa->nis ?? '-'),
                                    'kelas'              => $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-'),
                                    'wali_kelas'         => $sd->kelas->waliKelas->nama_guru ?? ($sd->siswa->kelas->waliKelas->nama_guru ?? '-'),
                                    'tanggal'            => \Carbon\Carbon::parse($sd->tanggal)->translatedFormat('d F Y'),
                                    'jam'                => ($sd->jam_keluar ?? '-') . ' s/d ' . ($sd->jam_kembali ?? '-'),
                                    'alasan'             => $sd->alasan ?? '-',
                                    'tempat'             => $sd->tempat ?? '-',
                                    'status_satpam'      => str_replace('_', ' ', ucfirst($sd->status_satpam ?? 'belum_keluar')),
                                    'status_waka'        => ucfirst($sd->status_waka ?? 'pending'),
                                    'catatan_waka'       => $sd->catatan_waka ?? '-',
                                    'waktu_approval_waka'=> $sd->waktu_approval_waka ? \Carbon\Carbon::parse($sd->waktu_approval_waka)->translatedFormat('d M Y H:i') . ' WIB' : '-',
                                    'nama_waka'          => $sd->nama_waka ?? '-',
                                    'foto_kartu_url'     => $sd->foto_kartu_identitas ? asset($sd->foto_kartu_identitas) : null,
                                    'foto_surat_url'     => $sd->foto_surat_dispen ? asset($sd->foto_surat_dispen) : null,
                                    'foto_siswa_live'    => $sd->foto_siswa_live ? asset($sd->foto_siswa_live) : null,
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $sd->id_siswa_dispen }}" class="cb-dispen" style="cursor: pointer;">
                                </td>
                                <td>
                                    <span class="kode-badge">{{ $sd->kode_dispen ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="student-cell">
                                        <span class="student-name">{{ $sd->siswa->nama_siswa ?? '-' }}</span>
                                        <span class="student-nisn">NISN: {{ $sd->siswa->nisn ?? ($sd->siswa->nis ?? '-') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #1e293b;">
                                        {{ $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-') }}
                                    </div>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        Wali: {{ $sd->kelas->waliKelas->nama_guru ?? ($sd->siswa->kelas->waliKelas->nama_guru ?? '-') }}
                                    </div>
                                </td>
                                <td>
                                    <span style="white-space: nowrap; font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($sd->tanggal)->translatedFormat('d M Y') }}
                                        @if($sd->tanggal === \Carbon\Carbon::today()->toDateString())
                                            <span style="display:inline-block; width: 6px; height: 6px; border-radius: 50%; background: #10b981; margin-left: 3px;" title="Hari Ini"></span>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span style="white-space: nowrap; font-weight: 700; color: #d97706; font-size: 11.5px;">
                                        {{ $sd->jam_keluar ?? '-' }} - {{ $sd->jam_kembali ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="max-width: 180px; font-weight: 600; color: #334155; line-height: 1.3;" title="{{ $sd->alasan }}">
                                        {{ Str::limit($sd->alasan ?? '-', 35) }}
                                    </div>
                                    @if($sd->tempat)
                                        <div style="font-size: 11px; color: #64748b;">Lokasi: {{ Str::limit($sd->tempat, 25) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($sd->status_waka === 'approved')
                                        <span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                                    @elseif($sd->status_waka === 'rejected')
                                        <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                    @else
                                        <span class="status-pill status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Waka</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sd->status_satpam === 'sudah_kembali' || $sd->status_satpam === 'kembali')
                                        <span class="status-pill status-approved"><i class="fa-solid fa-house-chimney-check"></i> Kembali</span>
                                    @elseif($sd->status_satpam === 'sedang_diluar' || $sd->status_satpam === 'dizinkan_keluar')
                                        <span class="status-pill status-pending" style="background: #e0f2fe; color: #0369a1; border-color: #bae6fd;"><i class="fa-solid fa-person-walking-arrow-right"></i> Sedang di Luar</span>
                                    @elseif($sd->status_satpam === 'ditolak')
                                        <span class="status-pill status-rejected"><i class="fa-solid fa-ban"></i> Ditolak</span>
                                    @else
                                        <span class="status-pill status-neutral"><i class="fa-solid fa-clock"></i> Belum Keluar</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="btn-tbl btn-tbl-detail" onclick='openDetailModal(@json($detailPayload))' title="Lihat Rincian & Bukti">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </button>

                                        @if($sd->status_waka === 'pending' || !$sd->status_waka)
                                            <button type="button" class="btn-tbl btn-tbl-approve" onclick="openApproveModal('{{ $sd->id_siswa_dispen }}', '{{ $sd->kode_dispen }}', '{{ addslashes($sd->siswa->nama_siswa ?? 'Siswa') }}')" title="Setujui Permohonan">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button type="button" class="btn-tbl btn-tbl-reject" onclick="openRejectModal('{{ $sd->id_siswa_dispen }}', '{{ $sd->kode_dispen }}', '{{ addslashes($sd->siswa->nama_siswa ?? 'Siswa') }}')" title="Tolak Permohonan">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        @endif

                                        <button type="button" class="btn-tbl btn-tbl-delete" onclick="deleteSingleDispen('{{ $sd->id_siswa_dispen }}', '{{ addslashes($sd->siswa->nama_siswa ?? 'Siswa') }}')" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 36px; color: #94a3b8;">
                                    <i class="fa-solid fa-id-card" style="font-size: 32px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                    <span style="font-weight: 700; font-size: 14px; color: #64748b; display: block; margin-bottom: 3px;">Tidak Ada Data Permohonan Dispensasi</span>
                                    <span style="font-size: 12.5px;">
                                        @if($periode === 'hari_ini')
                                            Belum ada permohonan dispensasi siswa yang diajukan untuk hari ini.
                                        @else
                                            Belum ada pengajuan dispensasi siswa yang sesuai dengan filter pencarian.
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</div>

<!-- Modal Detail Dispen Siswa -->
<div id="modalDetailDispen" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fa-solid fa-id-card"></i> Detail Dispensasi Siswa</h3>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="info-grid-2">
                <div class="info-box-item">
                    <div class="lbl">Kode Dispensasi</div>
                    <div class="val" id="dt_kode_dispen" style="color: #2563eb; font-family: monospace;">-</div>
                </div>
                <div class="info-box-item">
                    <div class="lbl">Tanggal Pengajuan</div>
                    <div class="val" id="dt_tanggal">-</div>
                </div>
            </div>

            <div class="info-grid-2">
                <div class="info-box-item">
                    <div class="lbl">Nama Siswa &amp; NISN</div>
                    <div class="val" id="dt_nama_siswa">-</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;" id="dt_nisn">-</div>
                </div>
                <div class="info-box-item">
                    <div class="lbl">Kelas &amp; Wali Kelas</div>
                    <div class="val" id="dt_kelas">-</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;" id="dt_wali_kelas">-</div>
                </div>
            </div>

            <div class="info-grid-2">
                <div class="info-box-item">
                    <div class="lbl">Jam Keluar s/d Kembali</div>
                    <div class="val" id="dt_jam" style="color: #d97706;">-</div>
                </div>
                <div class="info-box-item">
                    <div class="lbl">Lokasi / Tempat Tujuan</div>
                    <div class="val" id="dt_tempat">-</div>
                </div>
            </div>

            <div class="info-box-item">
                <div class="lbl">Alasan &amp; Keperluan Dispensasi</div>
                <div class="val" id="dt_alasan" style="font-weight: 500; line-height: 1.5; margin-top: 4px;">-</div>
            </div>

            <!-- Status Persetujuan & Pos Satpam -->
            <div class="info-grid-2">
                <div class="info-box-item" style="background: #f8fafc; border-color: #cbd5e1;">
                    <div class="lbl">Status Persetujuan Waka</div>
                    <div class="val" id="dt_status_waka" style="margin-top: 4px;">-</div>
                </div>
                <div class="info-box-item" style="background: #f8fafc; border-color: #cbd5e1;">
                    <div class="lbl">Status Pos Satpam (Gerbang)</div>
                    <div class="val" id="dt_status_satpam" style="margin-top: 4px;">-</div>
                </div>
            </div>

            <!-- Audit Trail Approval Waka -->
            <div id="dt_waka_audit_box" class="info-box-item" style="display: none; background: #f0fdf4; border-color: #bbf7d0;">
                <div class="lbl" style="color: #166534;">Catatan Verifikasi Waka Kesiswaan</div>
                <div class="val" id="dt_catatan_waka" style="color: #14532d; font-weight: 600; margin-top: 4px;">-</div>
                <div style="font-size: 11px; color: #166534; margin-top: 4px;" id="dt_waktu_approval">-</div>
            </div>

            <!-- Dokumen Bukti Lampiran -->
            <div>
                <div class="lbl" style="margin-bottom: 6px;">Foto Bukti Surat Dispen / Kartu Identitas</div>
                <div id="dt_photo_container" class="photo-preview-box" style="display: none;">
                    <img id="dt_photo_img" src="" alt="Bukti Dispensasi Siswa">
                </div>
                <div id="dt_no_photo_box" style="display: none; padding: 12px; text-align: center; background: #f8fafc; border-radius: 9px; border: 1px dashed #cbd5e1; color: #94a3b8; font-size: 12px;">
                    <i class="fa-solid fa-image" style="font-size: 18px; display: block; margin-bottom: 4px;"></i>
                    Tidak ada lampiran foto dokumen bukti yang diunggah.
                </div>
                <div id="dt_photo_link_wrapper" style="margin-top: 6px; text-align: right; display: none;">
                    <a id="dt_photo_link" href="#" target="_blank" style="color: #2563eb; font-size: 12px; font-weight: 700; text-decoration: none;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Gambar Ukuran Penuh
                    </a>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-custom btn-secondary" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Approve Form (Setujui Permohonan) -->
<div id="modalApproveDispen" class="modal-overlay">
    <div class="modal-card" style="max-width: 460px;">
        <form id="formApproveDispen" method="POST" action="">
            @csrf
            <div class="modal-header" style="background: #15803d;">
                <h3><i class="fa-solid fa-circle-check"></i> Setujui Dispensasi Siswa</h3>
                <button type="button" class="modal-close-btn" onclick="closeApproveModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #334155;">
                    Anda akan menyetujui permohonan dispensasi untuk siswa <strong id="ap_student_name" style="color: #0f172a;"></strong> (<span id="ap_code_dispen" style="font-family: monospace; color: #2563eb;"></span>).
                </p>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px; text-transform: uppercase;">
                        Catatan Persetujuan (Opsional):
                    </label>
                    <textarea name="catatan" class="form-control-custom" rows="3" style="width: 100%; height: auto; resize: vertical;" placeholder="Contoh: Disetujui oleh Waka Kesiswaan untuk mengikuti kegiatan resmi."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-custom btn-secondary" onclick="closeApproveModal()">Batal</button>
                <button type="submit" class="btn-custom btn-primary" style="background: #16a34a;">
                    <i class="fa-solid fa-check"></i> Ya, Setujui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reject Form (Tolak Permohonan) -->
<div id="modalRejectDispen" class="modal-overlay">
    <div class="modal-card" style="max-width: 460px;">
        <form id="formRejectDispen" method="POST" action="">
            @csrf
            <div class="modal-header" style="background: #c2410c;">
                <h3><i class="fa-solid fa-circle-xmark"></i> Tolak Dispensasi Siswa</h3>
                <button type="button" class="modal-close-btn" onclick="closeRejectModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #334155;">
                    Anda akan menolak permohonan dispensasi untuk siswa <strong id="rj_student_name" style="color: #0f172a;"></strong> (<span id="rj_code_dispen" style="font-family: monospace; color: #dc2626;"></span>).
                </p>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px; text-transform: uppercase;">
                        Alasan Penolakan <span style="color: #dc2626;">*</span>:
                    </label>
                    <textarea name="catatan" required class="form-control-custom" rows="3" style="width: 100%; height: auto; resize: vertical;" placeholder="Masukkan alasan penolakan dispensasi secara jelas..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-custom btn-secondary" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-custom btn-danger" style="background: #dc2626; color: #ffffff;">
                    <i class="fa-solid fa-ban"></i> Ya, Tolak Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Form Single Delete (Hidden) -->
<form id="singleDeleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('scripts')
<script>
    // 1. Detail Modal Logic
    function openDetailModal(data) {
        document.getElementById('dt_kode_dispen').innerText = data.kode_dispen || '-';
        document.getElementById('dt_tanggal').innerText = data.tanggal || '-';
        document.getElementById('dt_nama_siswa').innerText = data.nama_siswa || '-';
        document.getElementById('dt_nisn').innerText = 'NISN: ' + (data.nisn || '-');
        document.getElementById('dt_kelas').innerText = data.kelas || '-';
        document.getElementById('dt_wali_kelas').innerText = 'Wali Kelas: ' + (data.wali_kelas || '-');
        document.getElementById('dt_jam').innerText = data.jam || '-';
        document.getElementById('dt_tempat').innerText = data.tempat || '-';
        document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
        
        // Status Waka Badge
        const wakaStatusVal = (data.status_waka || 'pending').toLowerCase();
        let wakaBadgeHtml = '<span class="status-pill status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Waka</span>';
        if (wakaStatusVal === 'approved') {
            wakaBadgeHtml = '<span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka</span>';
        } else if (wakaStatusVal === 'rejected') {
            wakaBadgeHtml = '<span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak Waka</span>';
        }
        document.getElementById('dt_status_waka').innerHTML = wakaBadgeHtml;

        // Status Satpam Badge
        const satpamStatusVal = (data.status_satpam || 'belum_keluar').toLowerCase();
        let satpamBadgeHtml = '<span class="status-pill status-neutral"><i class="fa-solid fa-clock"></i> Belum Keluar</span>';
        if (satpamStatusVal.includes('kembali')) {
            satpamBadgeHtml = '<span class="status-pill status-approved"><i class="fa-solid fa-house-chimney-check"></i> Sudah Kembali</span>';
        } else if (satpamStatusVal.includes('luar') || satpamStatusVal.includes('keluar')) {
            satpamBadgeHtml = '<span class="status-pill status-pending" style="background: #e0f2fe; color: #0369a1; border-color: #bae6fd;"><i class="fa-solid fa-person-walking-arrow-right"></i> Sedang di Luar</span>';
        } else if (satpamStatusVal.includes('tolak')) {
            satpamBadgeHtml = '<span class="status-pill status-rejected"><i class="fa-solid fa-ban"></i> Ditolak Satpam</span>';
        }
        document.getElementById('dt_status_satpam').innerHTML = satpamBadgeHtml;

        // Audit Waka
        const wakaBox = document.getElementById('dt_waka_audit_box');
        if (data.catatan_waka && data.catatan_waka !== '-') {
            document.getElementById('dt_catatan_waka').innerText = data.catatan_waka;
            document.getElementById('dt_waktu_approval').innerText = 'Waktu: ' + (data.waktu_approval_waka || '-') + (data.nama_waka && data.nama_waka !== '-' ? ' oleh ' + data.nama_waka : '');
            wakaBox.style.display = 'block';
        } else {
            wakaBox.style.display = 'none';
        }

        // Photo Preview
        const targetPhoto = data.foto_kartu_url || data.foto_surat_url || data.foto_siswa_live;
        const photoContainer = document.getElementById('dt_photo_container');
        const noPhotoBox = document.getElementById('dt_no_photo_box');
        const linkWrapper = document.getElementById('dt_photo_link_wrapper');

        if (targetPhoto) {
            document.getElementById('dt_photo_img').src = targetPhoto;
            document.getElementById('dt_photo_link').href = targetPhoto;
            photoContainer.style.display = 'block';
            linkWrapper.style.display = 'block';
            noPhotoBox.style.display = 'none';
        } else {
            photoContainer.style.display = 'none';
            linkWrapper.style.display = 'none';
            noPhotoBox.style.display = 'block';
        }

        document.getElementById('modalDetailDispen').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailDispen').style.display = 'none';
    }

    // 2. Approve Modal Logic
    function openApproveModal(id, kode, nama) {
        document.getElementById('ap_student_name').innerText = nama;
        document.getElementById('ap_code_dispen').innerText = kode;
        const form = document.getElementById('formApproveDispen');
        form.action = "{{ route('waka.dispen.approve', 0) }}".replace('/0', '/' + id);
        document.getElementById('modalApproveDispen').style.display = 'flex';
    }

    function closeApproveModal() {
        document.getElementById('modalApproveDispen').style.display = 'none';
    }

    // 3. Reject Modal Logic
    function openRejectModal(id, kode, nama) {
        document.getElementById('rj_student_name').innerText = nama;
        document.getElementById('rj_code_dispen').innerText = kode;
        const form = document.getElementById('formRejectDispen');
        form.action = "{{ route('waka.dispen.reject', 0) }}".replace('/0', '/' + id);
        document.getElementById('modalRejectDispen').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('modalRejectDispen').style.display = 'none';
    }

    // 4. Batch Delete Logic
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.cb-dispen');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    function submitBatchDelete() {
        const checked = document.querySelectorAll('.cb-dispen:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu permohonan dispen siswa yang ingin dihapus!');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data dispen siswa yang dipilih ke Sampah (Soft Delete)?')) {
            document.getElementById('formBatchDispen').submit();
        }
    }

    // 5. Single Delete Logic
    function deleteSingleDispen(id, nama) {
        if (confirm('Apakah Anda yakin ingin memindahkan permohonan dispen siswa "' + nama + '" ke Sampah?')) {
            const form = document.getElementById('singleDeleteForm');
            form.action = "{{ route('waka.siswa-dispen.destroy', 0) }}".replace('/0', '/' + id);
            form.submit();
        }
    }

    // 6. Global Event Listeners (Backdrop Click & Escape Key)
    window.onclick = function(event) {
        const mDetail = document.getElementById('modalDetailDispen');
        const mApprove = document.getElementById('modalApproveDispen');
        const mReject = document.getElementById('modalRejectDispen');

        if (event.target === mDetail) mDetail.style.display = 'none';
        if (event.target === mApprove) mApprove.style.display = 'none';
        if (event.target === mReject) mReject.style.display = 'none';
    };

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDetailModal();
            closeApproveModal();
            closeRejectModal();
        }
    });
</script>
@endsection