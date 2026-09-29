@extends('layouts.admin')

@section('title', 'Laporan Pengguna — EDU JOURNAL')

@section('styles')
<style>
    /* Stats Grid */
    .laporan-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .stat-card-lp {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .stat-card-lp:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -2px rgba(0,0,0,0.06);
    }

    .stat-icon-lp {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .stat-val-lp {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-lbl-lp {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Filter & Search Toolbar */
    .filter-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        margin-bottom: 18px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .filter-form-grid {
        display: grid;
        grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr auto;
        gap: 10px;
        align-items: center;
    }

    .filter-input, .filter-select {
        height: 40px;
        padding: 0 12px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        width: 100%;
        transition: border-color 0.2s;
    }

    .filter-input:focus, .filter-select:focus {
        border-color: #2563eb;
        background: #ffffff;
    }

    .btn-filter {
        height: 40px;
        padding: 0 16px;
        background: #2563eb;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .btn-filter:hover {
        background: #1d4ed8;
    }

    .btn-reset {
        height: 40px;
        padding: 0 12px;
        background: #f1f5f9;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Table Panel */
    .table-container-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .table-header-bar {
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-header-title {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-batch-del {
        height: 34px;
        padding: 0 12px;
        background: #fee2e2;
        color: #991b1b;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        cursor: pointer;
        display: none;
        align-items: center;
        gap: 5px;
    }

    .btn-batch-del:hover {
        background: #fecaca;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .custom-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 16px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tr:hover td {
        background: #fbfcfe;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .status-progress { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
    .status-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

    .kategori-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
    }

    .role-badge {
        display: inline-block;
        padding: 2px 6px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
    }

    .btn-wa-direct {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        background: #22c55e;
        color: #ffffff;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-wa-direct:hover {
        background: #16a34a;
        color: #ffffff;
    }

    .btn-action-view {
        padding: 5px 11px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-action-view:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Modal Detail Styles */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(3px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 18px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        border: 1px solid #e2e8f0;
    }

    .modal-header-custom {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }

    .modal-title-custom {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
    }

    .btn-modal-close:hover {
        color: #0f172a;
        background: #e2e8f0;
    }

    .modal-body-custom {
        padding: 22px;
    }

    .info-group-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
    }

    .info-item label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }

    .info-item span {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .desc-box-custom {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 12px;
        font-size: 13px;
        line-height: 1.45;
        color: #1e293b;
        margin-bottom: 16px;
    }

    /* Modal Photo Proof Box */
    .photo-proof-card {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .photo-proof-preview {
        max-width: 100%;
        max-height: 280px;
        border-radius: 8px;
        object-fit: contain;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        display: block;
        margin: 8px auto 0;
    }

    .live-alert-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
        display: none;
        align-items: center;
        gap: 10px;
        z-index: 999;
        font-size: 12.5px;
        border: 1px solid #334155;
    }

    /* Mobile-only and Desktop-only helpers */
    .mobile-select-all-bar { display: none; }
    .mobile-ticket-text { display: none; }
    .mobile-status-container { display: none; }
    .mobile-field-label { display: none; }
    .mobile-date-text { display: none; }
    .desktop-only-cell { display: table-cell; }
    .desktop-ticket-code { display: block; }

    @media (max-width: 992px) {
        .filter-form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ════════════════════════════════════════════════════════════════
       RESPONSIVE MOBILE (HP) STYLES (Screen <= 768px)
       ════════════════════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .page-header-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .page-title-group h1 {
            font-size: 25px !important;
            line-height: 1.25 !important;
        }

        .page-title-group p {
            font-size: 12px;
            line-height: 1.4;
        }

        .laporan-header-actions {
            width: 100%;
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .laporan-header-actions .btn-trash-header {
            grid-column: span 2;
            justify-content: center;
            padding: 10px 14px;
            font-size: 13px;
            box-sizing: border-box;
        }

        .laporan-header-actions .btn-secondary,
        .laporan-header-actions .btn-primary {
            justify-content: center;
            padding: 10px 12px;
            font-size: 12.5px;
            box-sizing: border-box;
        }

        /* 2-Column Clean Mobile Stats Grid */
        .laporan-stats-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }

        .stat-card-lp:first-child {
            grid-column: span 2 !important;
        }

        .stat-card-lp {
            padding: 12px 14px !important;
            border-radius: 12px !important;
            gap: 10px !important;
            box-sizing: border-box;
        }

        .stat-icon-lp {
            width: 36px !important;
            height: 36px !important;
            border-radius: 10px !important;
            font-size: 16px !important;
        }

        .stat-val-lp {
            font-size: 19px !important;
        }

        .stat-lbl-lp {
            font-size: 11px !important;
        }

        /* Filter Toolbar on Mobile */
        .filter-card {
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .filter-form-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 8px;
        }

        .filter-input, .filter-select {
            height: 42px;
            font-size: 13px;
        }

        .filter-btn-group {
            display: flex !important;
            gap: 8px;
            width: 100%;
        }

        .filter-btn-group .btn-filter {
            flex: 1;
            justify-content: center;
            height: 42px;
            font-size: 13px;
        }

        .filter-btn-group .btn-reset {
            width: 44px;
            height: 42px;
            flex-shrink: 0;
        }

        /* Table Container on Mobile */
        .table-container-card {
            background: #ffffff !important;
            border-radius: 16px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
            overflow: hidden !important;
            margin-bottom: 18px;
        }

        .table-header-bar {
            background: #ffffff !important;
            padding: 14px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .table-header-title {
            font-size: 14px;
        }

        .table-header-actions {
            width: 100%;
        }

        .table-header-actions form {
            width: 100%;
        }

        .btn-batch-del {
            width: 100%;
            justify-content: center;
            height: 38px;
            box-sizing: border-box;
        }

        .mobile-select-all-bar {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px !important;
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: none !important;
            margin-bottom: 0 !important;
            border-radius: 0 !important;
        }

        .custom-table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            padding: 12px 14px !important;
            box-sizing: border-box;
        }

        .custom-table thead {
            display: none !important;
        }

        .custom-table tbody {
            display: block !important;
            width: 100% !important;
        }

        .laporan-row-card td.desktop-only-cell,
        .desktop-only-cell {
            display: none !important;
        }

        .desktop-ticket-code {
            display: none !important;
        }

        .mobile-ticket-text {
            display: inline-block !important;
            font-family: monospace;
            font-weight: 800;
            font-size: 13px;
            color: #2563eb;
            margin-left: 8px;
        }

        .mobile-status-container {
            display: block !important;
        }

        .mobile-field-label {
            display: block !important;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .mobile-date-text {
            display: flex !important;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: #64748b;
            font-weight: 600;
        }

        .laporan-row-card {
            display: flex !important;
            flex-direction: column;
            gap: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .laporan-row-card:last-child {
            margin-bottom: 0 !important;
        }

        .laporan-row-card td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
        }

        .col-checkbox-container {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .mobile-cb-label {
            display: flex !important;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            margin: 0;
        }

        .report-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .col-kendala {
            max-width: 100% !important;
        }

        .kendala-title {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: clip !important;
            line-height: 1.4;
            font-size: 13px;
            margin-top: 2px;
        }

        .btn-wa-direct {
            display: inline-flex !important;
            width: 100%;
            justify-content: center;
            padding: 8px 12px;
            font-size: 12.5px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .col-aksi {
            text-align: left !important;
            margin-top: 4px;
            padding-top: 8px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        .action-buttons-wrap {
            display: flex !important;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .btn-action-view {
            flex: 1;
            height: 38px;
            justify-content: center;
            font-size: 12.5px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .action-buttons-wrap form {
            margin: 0;
        }

        .btn-action-del {
            height: 38px;
            width: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .custom-table tr td[colspan] {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box;
            text-align: center !important;
            padding: 30px 14px !important;
            background: #ffffff;
            border-radius: 14px;
            border: 1px dashed #cbd5e1;
        }

        /* Modal Detail Mobile */
        .modal-backdrop-custom {
            padding: 10px;
        }

        .modal-box-custom {
            max-width: 100% !important;
            width: 100% !important;
            max-height: 92vh !important;
            border-radius: 14px !important;
        }

        .modal-header-custom {
            padding: 12px 16px !important;
        }

        .modal-title-custom {
            font-size: 14px !important;
            flex-wrap: wrap;
        }

        .modal-body-custom {
            padding: 14px 16px !important;
        }

        .info-group-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
            padding: 12px !important;
        }

        .desc-box-custom {
            word-break: break-word;
            font-size: 12.5px;
        }

        .photo-proof-preview {
            max-height: 220px !important;
        }

        .modal-quick-action {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            text-align: center;
        }

        .modal-quick-action a {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box;
            text-align: center;
            display: inline-flex !important;
            align-items: center;
            padding: 8px 12px !important;
        }

        .modal-form-actions {
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .modal-form-actions button {
            width: 100% !important;
            justify-content: center !important;
            height: 42px !important;
            box-sizing: border-box;
        }

        .live-alert-toast {
            left: 12px;
            right: 12px;
            bottom: 12px;
            width: auto;
            max-width: none;
            border-radius: 12px;
            font-size: 12px;
        }

        /* Pagination Mobile */
        .custom-pagination-bar {
            flex-direction: column !important;
            gap: 12px !important;
            align-items: center !important;
            text-align: center !important;
        }

        .pagination-info {
            font-size: 12px !important;
        }

        .pagination-list {
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="content-body">

    <!-- Global Page Header -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Laporan Pengguna Masuk</h1>
            <p>Kelola pengaduan, permohonan akun, dan kendala pengguna yang dikirim ke Administrator Tata Usaha</p>
        </div>
        <div class="laporan-header-actions" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.laporan.trash') }}" class="btn-trash-header" style="background:#fef2f2; border:1.5px solid #fecaca; color:#b91c1c; font-size:12.5px; font-weight:700; padding:8px 14px; border-radius:9px; display:inline-flex; align-items:center; gap:6px; text-decoration:none; transition:all 0.2s;">
                <i class="fa-solid fa-trash-can"></i>
                <span>Kotak Sampah</span>
                @if($trashCount > 0)
                    <span style="background:#ef4444; color:#ffffff; font-size:10.5px; font-weight:800; padding:1px 6px; border-radius:12px;">{{ $trashCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.laporan.export', request()->query()) }}" class="btn-secondary" style="background:#ffffff; border:1.5px solid #cbd5e1; color:#334155; font-size:12.5px; font-weight:700; padding:8px 14px; border-radius:9px; display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
                <i class="fa-solid fa-file-excel" style="color:#16a34a;"></i> Ekspor CSV
            </a>
            <button type="button" onclick="location.reload()" class="btn-primary" style="background:#2563eb; color:#ffffff; font-size:12.5px; font-weight:700; padding:8px 14px; border-radius:9px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-rotate-right"></i> Refresh Data
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="laporan-stats-grid">
        <div class="stat-card-lp">
            <div class="stat-icon-lp" style="background:#eff6ff; color:#2563eb;">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
                <div class="stat-val-lp">{{ $stats['total'] }}</div>
                <div class="stat-lbl-lp">Total Laporan</div>
            </div>
        </div>

        <div class="stat-card-lp">
            <div class="stat-icon-lp" style="background:#fef3c7; color:#d97706;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="stat-val-lp">{{ $stats['pending'] }}</div>
                <div class="stat-lbl-lp">Menunggu Tindakan</div>
            </div>
        </div>

        <div class="stat-card-lp">
            <div class="stat-icon-lp" style="background:#e0f2fe; color:#0284c7;">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <div>
                <div class="stat-val-lp">{{ $stats['diproses'] }}</div>
                <div class="stat-lbl-lp">Sedang Diproses</div>
            </div>
        </div>

        <div class="stat-card-lp">
            <div class="stat-icon-lp" style="background:#d1fae5; color:#059669;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="stat-val-lp">{{ $stats['selesai'] }}</div>
                <div class="stat-lbl-lp">Laporan Selesai</div>
            </div>
        </div>

        <div class="stat-card-lp">
            <div class="stat-icon-lp" style="background:#fee2e2; color:#dc2626;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="stat-val-lp">{{ $stats['ditolak'] }}</div>
                <div class="stat-lbl-lp">Laporan Ditolak</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-card">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="filter-form-grid">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari nama, tiket, no WA, identitas, atau judul...">
            </div>

            <div>
                <select name="status" class="filter-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <select name="kategori" class="filter-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoriOptions as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="role" class="filter-select">
                    <option value="">-- Semua Role --</option>
                    @foreach($roleOptions as $rKey => $rVal)
                        <option value="{{ $rKey }}" {{ request('role') == $rKey ? 'selected' : '' }}>{{ $rVal }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-btn-group" style="display:flex; gap:6px;">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                @if(request()->anyFilled(['q', 'status', 'kategori', 'role']))
                <a href="{{ route('admin.laporan.index') }}" class="btn-reset" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container-card">
        <div class="table-header-bar">
            <div class="table-header-title">
                <i class="fa-solid fa-list-check" style="color:#2563eb;"></i>
                <span>Daftar Pengaduan Pengguna ({{ $laporans->total() }} Laporan)</span>
            </div>

            <div class="table-header-actions">
                <form id="batchDeleteForm" action="{{ route('admin.laporan.destroy-batch') }}" method="POST" onsubmit="return confirm('Pindahkan laporan terpilih ke kotak sampah?')">
                    @csrf
                    @method('DELETE')
                    <div id="batchIdsContainer"></div>
                    <button type="submit" id="btnBatchDelete" class="btn-batch-del">
                        <i class="fa-solid fa-trash-can"></i> Pindahkan ke Sampah (<span id="selectedCount">0</span>)
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Select All Bar -->
        <div class="mobile-select-all-bar">
            <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 12.5px; color: #475569; cursor: pointer; margin: 0;">
                <input type="checkbox" id="mobileCheckAll" onchange="toggleSelectAllMobile(this)">
                <span>Pilih Semua Laporan</span>
            </label>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;">
                            <input type="checkbox" id="checkAll" onchange="toggleSelectAll(this)">
                        </th>
                        <th>Tiket & Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kendala / Permohonan</th>
                        <th>Kontak WhatsApp</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $item)
                    <tr class="laporan-row-card">
                        <td class="col-checkbox" style="text-align: center;">
                            <div class="col-checkbox-container">
                                <label class="mobile-cb-label">
                                    <input type="checkbox" class="report-checkbox" value="{{ $item->id }}" onchange="updateSelectedCount()">
                                    <span class="mobile-ticket-text">{{ $item->ticket_code }}</span>
                                </label>
                                <div class="mobile-status-container">
                                    {!! $item->status_badge !!}
                                </div>
                            </div>
                        </td>
                        <td class="col-ticket">
                            <div class="desktop-ticket-code" style="font-weight: 800; color: #2563eb; font-family: monospace; font-size: 12.5px;">
                                {{ $item->ticket_code }}
                            </div>
                            <div class="mobile-date-text">
                                <i class="fa-regular fa-calendar" style="color: #64748b;"></i>
                                <span>{{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="desktop-only-cell" style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                {{ $item->created_at->format('d M Y, H:i') }} WIB
                            </div>
                        </td>
                        <td class="col-pelapor">
                            <div class="mobile-field-label">Pelapor:</div>
                            <div style="font-weight: 700; color: #0f172a;">{{ $item->nama_pelapor }}</div>
                            <div style="display: flex; align-items: center; gap: 6px; margin-top: 3px; flex-wrap: wrap;">
                                <span class="role-badge">{{ $item->role_label }}</span>
                                @if($item->nomor_identitas)
                                    <span style="font-size: 10.5px; color: #64748b;">ID: {{ $item->nomor_identitas }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="col-kendala" style="max-width: 280px;">
                            <div class="mobile-field-label">Kendala / Permohonan:</div>
                            <div style="margin-bottom: 3px;">
                                {!! $item->kategori_badge !!}
                            </div>
                            <div class="kendala-title" style="font-weight: 700; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->judul_laporan }}">
                                {{ $item->judul_laporan }}
                            </div>
                            @if($item->lampiran)
                                <div style="margin-top: 3px;">
                                    <a href="{{ $item->lampiran_url }}" target="_blank" style="font-size: 10.5px; background: #eff6ff; color: #2563eb; padding: 2px 6px; border-radius: 4px; border: 1px solid #bfdbfe; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                        <i class="fa-solid fa-paperclip"></i> Bukti Lampiran
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td class="col-wa">
                            <div class="mobile-field-label">Kontak WhatsApp:</div>
                            <a href="{{ $item->wa_link }}" target="_blank" class="btn-wa-direct" title="Chat langsung via WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>{{ $item->no_wa }}</span>
                            </a>
                        </td>
                        <td class="desktop-only-cell col-status">
                            {!! $item->status_badge !!}
                        </td>
                        <td class="col-aksi" style="text-align: right;">
                            <div class="action-buttons-wrap" style="display: inline-flex; align-items: center; gap: 5px;">
                                <button type="button" class="btn-action-view" onclick="openDetailModal({{ $item->id }})">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>
                                <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Pindahkan laporan [{{ $item->ticket_code }}] ke kotak sampah?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-del" style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:5px 9px; border-radius:7px; cursor:pointer;" title="Pindahkan ke Kotak Sampah">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                            <i class="fa-solid fa-inbox" style="font-size: 36px; margin-bottom: 10px; color: #cbd5e1;"></i>
                            <div style="font-size: 14.5px; font-weight: 700; color: #475569;">Belum Ada Laporan Pengguna</div>
                            <p style="font-size: 12.5px; margin-top: 2px;">Laporan dari halaman "Lapor Admin TU" akan otomatis masuk ke tabel ini secara real-time.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
        <div style="padding: 14px 18px; border-top: 1px solid #f1f5f9;">
            {{ $laporans->withQueryString()->links('partials.custom-pagination') }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Detail & Tindak Lanjut -->
<div class="modal-backdrop-custom" id="detailModal">
    <div class="modal-box-custom">
        <div class="modal-header-custom">
            <div class="modal-title-custom">
                <i class="fa-solid fa-clipboard-check" style="color: #2563eb;"></i>
                <span>Detail Laporan <span id="mTicketCode" style="color: #2563eb; font-family: monospace;"></span></span>
            </div>
            <button type="button" class="btn-modal-close" onclick="closeDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-body-custom">
            <!-- Pelapor Info Grid -->
            <div class="info-group-grid">
                <div class="info-item">
                    <label>Nama Pelapor</label>
                    <span id="mNamaPelapor">-</span>
                </div>
                <div class="info-item">
                    <label>Peran / Status</label>
                    <span id="mRolePelapor">-</span>
                </div>
                <div class="info-item">
                    <label>Nomor Identitas (NIP/NISN)</label>
                    <span id="mIdentitas">-</span>
                </div>
                <div class="info-item">
                    <label>Waktu Laporan</label>
                    <span id="mWaktuLapor">-</span>
                </div>
                <div class="info-item">
                    <label>Nomor WhatsApp</label>
                    <div>
                        <a href="#" id="mWaLink" target="_blank" class="btn-wa-direct" style="display: inline-flex; margin-top: 2px;">
                            <i class="fa-brands fa-whatsapp"></i> <span id="mNoWa">-</span>
                        </a>
                    </div>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <span id="mEmail">-</span>
                </div>
            </div>

            <!-- Subject & Category -->
            <div style="margin-bottom: 10px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Kategori Kendala:</div>
                <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mKategori">-</div>
            </div>

            <div style="margin-bottom: 10px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Judul Laporan:</div>
                <div style="font-size: 14.5px; font-weight: 800; color: #2563eb; margin-top: 2px;" id="mJudul">-</div>
            </div>

            <div style="margin-bottom: 14px;">
                <div style="font-size: 11.5px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Keterangan & Rincian:</div>
                <div class="desc-box-custom" id="mDeskripsi">-</div>
            </div>

            <!-- Foto Bukti / Lampiran Preview -->
            <div id="mLampiranSection" class="photo-proof-card" style="display: none;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 12px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-image" style="color: #2563eb;"></i> Foto Bukti / Tangkapan Layar Kendala
                    </div>
                    <a href="#" id="mLampiranLink" target="_blank" style="font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: underline;">
                        Buka Ukuran Penuh <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
                <img src="#" alt="Foto Bukti" id="mLampiranImagePreview" class="photo-proof-preview">
                <div id="mLampiranDocPreview" style="display: none; margin-top: 8px;">
                    <a href="#" id="mLampiranDocLink" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                        <i class="fa-solid fa-file-arrow-down"></i> <span id="mLampiranName">Unduh Berkas Lampiran</span>
                    </a>
                </div>
            </div>

            <!-- Shortcut Action to Manajemen Pengguna -->
            <div id="mQuickActionUser" class="modal-quick-action" style="margin-bottom: 18px; padding: 10px 14px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; display: flex; align-items: center; justify-content: space-between;">
                <div style="font-size: 12px; color: #1e40af; font-weight: 600;">
                    <i class="fa-solid fa-user-gear"></i> Butuh membuat atau mereset akun?
                </div>
                <a href="{{ route('admin.pengguna') }}" target="_blank" style="font-size: 11.5px; font-weight: 800; background: #2563eb; color: #ffffff; padding: 5px 10px; border-radius: 7px; text-decoration: none;">
                    Buka Data Pengguna <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>

            <!-- Form Update Status & Tanggapan Admin TU -->
            <form id="updateStatusForm" method="POST">
                @csrf
                <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
                        Tindak Lanjut Administrator TU
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Update Status Laporan:</label>
                            <select name="status" id="mStatusSelect" class="filter-select" required>
                                <option value="pending">Menunggu (Pending)</option>
                                <option value="diproses">Sedang Diproses</option>
                                <option value="selesai">Selesai (Terselesaikan)</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 4px;">Catatan / Tanggapan untuk Pelapor:</label>
                            <textarea name="tanggapan_admin" id="mTanggapan" rows="3" class="filter-input" style="height: auto; padding: 8px 10px; resize: vertical;" placeholder="Contoh: Akun telah dibuat / Password telah berhasil direset."></textarea>
                            <span style="font-size: 10.5px; color: #64748b; margin-top: 2px; display: block;">Tanggapan ini dapat dilihat oleh pelapor saat mengecek status tiket mereka.</span>
                        </div>
                    </div>

                    <div class="modal-form-actions" style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px;">
                        <button type="button" class="btn-reset" onclick="closeDetailModal()">Batal</button>
                        <button type="submit" class="btn-filter" style="background: #2563eb; padding: 0 18px;">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Tanggapan & Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Realtime Notification Toast -->
<div class="live-alert-toast" id="liveAlertToast">
    <i class="fa-solid fa-bell" style="color: #f59e0b; font-size: 16px;"></i>
    <div>
        <strong style="color: #ffffff;">Laporan Baru Masuk!</strong>
        <div style="font-size: 11px; color: #cbd5e1;" id="toastMsg">Ada pengaduan baru dari pengguna.</div>
    </div>
    <button type="button" onclick="location.reload()" style="background:#2563eb; color:#ffffff; border:none; padding:4px 9px; border-radius:5px; font-size:11px; font-weight:700; cursor:pointer; margin-left:6px;">
        Muat Ulang
    </button>
</div>

@endsection

@section('scripts')
<script>
    // Modal Management
    function openDetailModal(id) {
        fetch(`{{ url('admin/laporan') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                const d = res.data;
                document.getElementById('mTicketCode').textContent = `[${d.ticket_code}]`;
                document.getElementById('mNamaPelapor').textContent = d.nama_pelapor;
                document.getElementById('mRolePelapor').textContent = d.role_label;
                document.getElementById('mIdentitas').textContent = d.nomor_identitas;
                document.getElementById('mWaktuLapor').textContent = d.created_at;
                document.getElementById('mNoWa').textContent = d.no_wa;
                document.getElementById('mWaLink').href = d.wa_link;
                document.getElementById('mEmail').textContent = d.email;
                document.getElementById('mKategori').textContent = d.kategori_kendala;
                document.getElementById('mJudul').textContent = d.judul_laporan;
                document.getElementById('mDeskripsi').textContent = d.deskripsi_kendala;
                document.getElementById('mStatusSelect').value = d.status;
                document.getElementById('mTanggapan').value = d.tanggapan_admin;

                // Lampiran / Foto Bukti Preview
                const lampiranSec = document.getElementById('mLampiranSection');
                const imgPrev = document.getElementById('mLampiranImagePreview');
                const docPrev = document.getElementById('mLampiranDocPreview');

                if (d.lampiran_url) {
                    lampiranSec.style.display = 'block';
                    document.getElementById('mLampiranLink').href = d.lampiran_url;
                    
                    if (d.is_image) {
                        imgPrev.src = d.lampiran_url;
                        imgPrev.style.display = 'block';
                        docPrev.style.display = 'none';
                    } else {
                        imgPrev.style.display = 'none';
                        docPrev.style.display = 'block';
                        document.getElementById('mLampiranDocLink').href = d.lampiran_url;
                        document.getElementById('mLampiranName').textContent = `Unduh Berkas (${d.lampiran_name})`;
                    }
                } else {
                    lampiranSec.style.display = 'none';
                }

                // Update form action url
                document.getElementById('updateStatusForm').action = `{{ url('admin/laporan') }}/${id}/tanggapan`;

                document.getElementById('detailModal').style.display = 'flex';
            })
            .catch(err => {
                alert('Gagal memuat detail laporan.');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Close on backdrop click
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    // Checkbox Batch Delete
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.report-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        const mobileCheckAll = document.getElementById('mobileCheckAll');
        if (mobileCheckAll) mobileCheckAll.checked = master.checked;
        updateSelectedCount();
    }

    function toggleSelectAllMobile(master) {
        const checkAll = document.getElementById('checkAll');
        if (checkAll) checkAll.checked = master.checked;
        const checkboxes = document.querySelectorAll('.report-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.report-checkbox');
        const selected = document.querySelectorAll('.report-checkbox:checked');
        const count = selected.length;
        const btn = document.getElementById('btnBatchDelete');
        const countSpan = document.getElementById('selectedCount');
        const container = document.getElementById('batchIdsContainer');

        const checkAll = document.getElementById('checkAll');
        const mobileCheckAll = document.getElementById('mobileCheckAll');
        const allChecked = checkboxes.length > 0 && selected.length === checkboxes.length;
        if (checkAll) checkAll.checked = allChecked;
        if (mobileCheckAll) mobileCheckAll.checked = allChecked;

        countSpan.textContent = count;
        container.innerHTML = '';

        if (count > 0) {
            btn.style.display = 'inline-flex';
            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        } else {
            btn.style.display = 'none';
        }
    }

    // Real-Time Polling for New Incoming Reports
    let lastReportId = {{ $laporans->first()->id ?? 0 }};

    function checkNewReports() {
        fetch('{{ route('admin.laporan.realtime-count') }}')
            .then(res => res.json())
            .then(res => {
                if (res.latest_id > lastReportId && lastReportId !== 0) {
                    const toast = document.getElementById('liveAlertToast');
                    document.getElementById('toastMsg').textContent = `[${res.latest_ticket}] ${res.latest_title}`;
                    toast.style.display = 'flex';
                }
            })
            .catch(() => {});
    }

    // Poll every 15 seconds
    setInterval(checkNewReports, 15000);
</script>
@endsection
