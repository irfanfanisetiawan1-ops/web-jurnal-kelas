@extends('layouts.admin')

@section('title', 'Akademik - Jurnal Mengajar — EDU JOURNAL')

@section('styles')
<style>
    .page-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header-title h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .page-header-title p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* Red / Pastel Card: Laporan Guru Alpa */
    .card-alpa {
        background: #fee2e2;
        border-radius: 20px;
        padding: 22px 24px;
        margin-bottom: 24px;
        border: 1px solid #fca5a5;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.05);
    }

    .card-alpa-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-alpa h2 {
        font-size: 19px;
        font-weight: 800;
        color: #991b1b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-alpa {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .table-alpa th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 12px 16px;
        text-align: left;
        background: #ffffff;
        border-bottom: 1px solid #fee2e2;
    }

    .table-alpa td {
        padding: 13px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #fecaca;
        vertical-align: middle;
    }

    /* Badges for Laporan Guru Alpa */
    .badge-alpa-red {
        background: #fee2e2;
        color: #991b1b;
        font-weight: 800;
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #fca5a5;
        display: inline-block;
    }

    .badge-alpa-amber {
        background: #fef3c7;
        color: #92400e;
        font-weight: 800;
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #fde68a;
        display: inline-block;
    }

    .badge-alpa-blue {
        background: #dbeafe;
        color: #1e40af;
        font-weight: 800;
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 10px;
        border: 1px solid #bfdbfe;
        display: inline-block;
    }

    /* Pagination for Laporan Guru Alpa */
    .alpa-pagination-wrapper {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed #fca5a5;
    }

    .alpa-pagination-container {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .alpa-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border: none;
        background: transparent;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        font-family: inherit;
    }

    .alpa-page-btn:hover:not(:disabled) {
        background: #f1f5f9;
        color: #0f172a;
    }

    .alpa-page-btn.active {
        background: #1e293b;
        color: #ffffff !important;
        box-shadow: 0 2px 5px rgba(30, 41, 59, 0.3);
    }

    .alpa-page-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    /* Dark Header Banner */
    .header-banner-dark {
        background: #384972;
        color: #ffffff;
        border-radius: 16px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-weight: 800;
        font-size: 15.5px;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.18);
    }

    .header-banner-dark i {
        font-size: 18px;
        color: #b6c5e3;
    }

    /* Filter Bar Component */
    .filter-section-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
    }

    .filter-control-date, .filter-select {
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s;
    }

    .filter-control-date:focus, .filter-select:focus {
        border-color: #384972;
        box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.12);
    }

    .btn-filter-blue {
        background: #384972;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .btn-filter-blue:hover {
        background: #2b395a;
    }

    .btn-today-orange {
        background: #fbbf24;
        color: #78350f;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .btn-today-orange:hover {
        background: #f59e0b;
    }

    .btn-filter-reset {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-reset:hover {
        background: #fecaca;
    }

    /* Actions Right in Filter (Export, Print, Trash) */
    .filter-action-buttons {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action-tool {
        padding: 9px 15px;
        border-radius: 12px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s;
        border: 1px solid transparent;
    }

    .btn-tool-trash {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    .btn-tool-trash:hover {
        background: #fde68a;
    }

    .btn-tool-trash .badge-trash {
        background: #ef4444;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 12px;
    }

    .btn-tool-export {
        background: #f1f5f9;
        color: #334155;
        border-color: #cbd5e1;
    }
    .btn-tool-export:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-tool-print {
        background: #10b981;
        color: #ffffff;
    }
    .btn-tool-print:hover {
        background: #059669;
    }

    /* 4 Stat Summary Cards Grid */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: transform 0.15s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-purple { background: #f3e8ff; color: #9333ea; }
    .stat-green  { background: #dcfce7; color: #16a34a; }
    .stat-orange { background: #fef3c7; color: #d97706; }
    .stat-blue   { background: #dbeafe; color: #2563eb; }

    .stat-content .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
    }

    .stat-content .stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Table Component (Jurnal Tersimpan) */
    .table-container-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-container-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-container-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    /* Batch Selection Bar */
    .batch-bar-container {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 10px 18px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .batch-bar-left {
        font-size: 13px;
        font-weight: 700;
        color: #384972;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-batch-delete {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-batch-delete:hover {
        background: #dc2626;
    }

    .table-saved-responsive {
        overflow-x: auto;
        min-height: 220px;
        padding-bottom: 12px;
    }

    .table-saved {
        width: 100%;
        border-collapse: collapse;
    }

    .table-saved th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 13px 14px;
        text-align: left;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-saved td {
        padding: 14px 14px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-saved tbody tr:hover {
        background: #f8fafc;
    }

    .custom-checkbox {
        width: 17px;
        height: 17px;
        accent-color: #384972;
        cursor: pointer;
    }

    .badge-hadir-green {
        background: #bbf7d0;
        color: #166534;
        font-weight: 800;
        font-size: 11.5px;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
    }

    .badge-absen-red {
        background: #fee2e2;
        color: #991b1b;
        font-weight: 800;
        font-size: 11.5px;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
    }

    .badge-izin-amber {
        background: #fef3c7;
        color: #92400e;
        font-weight: 800;
        font-size: 11.5px;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
    }

    /* Photo Thumbnail Component */
    .photo-thumb-box {
        width: 48px;
        height: 38px;
        background: #cbd5e1;
        border-radius: 8px;
        display: inline-block;
        object-fit: cover;
        cursor: pointer;
        border: 1px solid #cbd5e1;
        transition: transform 0.2s;
    }
    .photo-thumb-box:hover {
        transform: scale(1.08);
    }

    .photo-placeholder-box {
        width: 48px;
        height: 38px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 14px;
        border: 1px dashed #cbd5e1;
    }

    /* Action Buttons & Dropdown */
    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
    }

    .btn-action-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-action-icon:hover {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
    }

    /* 3-Dots Dropdown Menu */
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .action-dropdown-menu {
        position: absolute;
        right: 0;
        top: 110%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        min-width: 190px;
        z-index: 1000;
        display: none;
        overflow: hidden;
        padding: 6px 0;
    }

    .action-dropdown-menu.dropup {
        top: auto !important;
        bottom: calc(100% + 6px) !important;
        box-shadow: 0 -8px 25px rgba(0,0,0,0.12) !important;
    }

    .action-dropdown-menu.show {
        display: block;
    }

    .dropdown-menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.15s;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .dropdown-menu-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .dropdown-menu-item.danger-item {
        color: #dc2626;
    }

    .dropdown-menu-item.danger-item:hover {
        background: #fee2e2;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999 !important;
        padding: 24px 16px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    #photoPreviewModal {
        z-index: 100000 !important;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content-box {
        background: #ffffff;
        border-radius: 24px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 28px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
        animation: modalFadeIn 0.25s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 14px;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .btn-modal-close {
        background: transparent;
        border: none;
        font-size: 20px;
        color: #64748b;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
    }
    .btn-modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .modal-body-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .detail-item-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .detail-item-box span {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .detail-item-box strong {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .pagination-bar {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Desktop Custom Pagination Bar */
    .custom-pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        flex-wrap: wrap;
        gap: 12px;
    }

    .custom-pagination-bar .pagination-info {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .custom-pagination-bar .pagination-list {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    .custom-pagination-bar .page-item {
        display: inline-block;
    }

    .custom-pagination-bar .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .custom-pagination-bar .page-item:not(.active):not(.disabled) .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .custom-pagination-bar .page-item.active .page-link {
        background: #384972 !important;
        border-color: #384972 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(56, 73, 114, 0.25);
    }

    .custom-pagination-bar .page-item.disabled .page-link {
        opacity: 0.45;
        cursor: not-allowed;
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .alpa-row.alpa-row-hidden {
        display: none !important;
    }

    /* Desktop helper states */
    .mobile-select-all-bar { display: none; }
    .mobile-action-buttons { display: none; }
    .mobile-cell-label { display: none; }
    .desktop-action-group { display: flex; }
    .filter-submit-group { display: flex; gap: 8px; align-items: center; }
    .filter-selects-grid { display: contents; }
    .alpa-filter-row-grid { display: contents; }
    .alpa-btn-group { display: contents; }
    .jurnal-card-header-line { display: none; }
    .desktop-only-tanggal { display: block; }
    .desktop-only-cell { display: table-cell; }
    .col-foto-absen-wrap { display: none; }
    .mobile-only-inline { display: none; }
    .mobile-only-block { display: none; }
    .alpa-row-top { display: none; }
    .desktop-only-jam { display: block; }

    /* ════════════════════════════════════════════════════════════════
       RESPONSIVE MOBILE (HP) STYLES (Screen <= 768px)
       ════════════════════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .page-header-container {
            margin-bottom: 16px;
        }

        .page-header-title h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
        }

        .page-header-title p {
            font-size: 13px !important;
        }

        /* ── 1. Laporan Guru Tidak Mengisi Jurnal (.card-alpa) ── */
        .card-alpa {
            padding: 16px 14px;
            border-radius: 16px;
            margin-bottom: 18px;
        }

        .card-alpa-header h2 {
            font-size: 15.5px;
            line-height: 1.35;
        }

        .card-alpa-form-filter {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            margin-bottom: 14px !important;
        }

        .alpa-filter-search-box {
            width: 100% !important;
            min-width: 100% !important;
        }

        .alpa-filter-row-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
        }

        .alpa-filter-row-grid input,
        .alpa-filter-row-grid select {
            width: 100% !important;
            box-sizing: border-box;
        }

        .alpa-btn-group {
            display: flex !important;
            gap: 8px;
            width: 100%;
        }

        .alpa-btn-group .btn-filter-blue,
        .alpa-btn-group .btn-today-orange,
        .alpa-btn-group .btn-filter-reset {
            flex: 1;
            justify-content: center;
            padding: 10px 8px;
            font-size: 12.5px;
        }

        /* Table Alpa into Mobile Cards */
        .table-alpa-responsive {
            overflow: visible;
        }

        .table-alpa {
            display: block;
            width: 100%;
            background: transparent;
            box-shadow: none;
            border: none;
            border-radius: 0;
        }

        .table-alpa thead {
            display: none !important;
        }

        .table-alpa tbody {
            display: block;
            width: 100%;
        }

        .alpa-card-row {
            display: flex !important;
            flex-direction: column;
            gap: 8px;
            background: #ffffff;
            border: 1px solid #fca5a5;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.05);
        }

        .alpa-card-row.alpa-row-hidden {
            display: none !important;
        }

        .alpa-card-row td {
            display: block;
            padding: 0;
            border: none;
        }

        .alpa-row-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #fecaca;
        }

        .alpa-jam-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: #991b1b;
            background: #fee2e2;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .alpa-jam-time {
            font-size: 11.5px;
            color: #64748b;
            font-weight: 600;
        }

        .alpa-guru-name {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alpa-guru-meta {
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 3px;
        }

        .alpa-mapel-pill {
            background: #e0e7ff;
            color: #3730a3;
            font-weight: 700;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .alpa-kelas-badges {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .badge-alpa-kelas {
            background: #f1f5f9;
            color: #1e293b;
            font-weight: 800;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        .badge-alpa-ruang {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .alpa-empty-row td.alpa-empty-cell {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 20px 14px;
            text-align: center;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #bbf7d0;
            color: #166534;
            font-size: 13px;
            font-weight: 700;
        }

        .alpa-pagination-wrapper {
            justify-content: center;
            margin-top: 10px;
            padding-top: 10px;
        }

        /* ── 2. Banner & 4 KPI Stat Cards ── */
        .header-banner-dark {
            padding: 12px 16px;
            font-size: 14.5px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            margin-bottom: 16px !important;
        }

        .stat-card {
            padding: 12px 10px !important;
            border-radius: 14px !important;
            gap: 10px !important;
        }

        .stat-icon-wrapper {
            width: 38px !important;
            height: 38px !important;
            border-radius: 10px !important;
            font-size: 16px !important;
        }

        .stat-content .stat-label {
            font-size: 10.5px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .stat-content .stat-value {
            font-size: 14px !important;
        }

        /* ── 3. Filter Section Bar ── */
        .filter-section-bar {
            padding: 14px !important;
            border-radius: 16px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            margin-bottom: 18px !important;
        }

        .filter-search-wrapper {
            width: 100% !important;
            min-width: 100% !important;
        }

        .filter-input-date {
            width: 100% !important;
            box-sizing: border-box;
        }

        .filter-selects-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
        }

        .filter-selects-grid select {
            width: 100% !important;
            box-sizing: border-box;
        }

        .filter-submit-group {
            display: flex !important;
            gap: 8px;
            width: 100%;
        }

        .filter-submit-group .btn-filter-blue,
        .filter-submit-group .btn-filter-reset {
            flex: 1;
            justify-content: center;
            padding: 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .filter-action-buttons {
            margin-left: 0 !important;
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            margin-top: 4px !important;
            padding-top: 12px !important;
            border-top: 1px dashed #cbd5e1 !important;
        }

        .filter-action-buttons .btn-tool-trash {
            grid-column: span 2 !important;
            width: 100% !important;
            justify-content: center !important;
            padding: 10px !important;
            box-sizing: border-box !important;
        }

        .filter-action-buttons .btn-tool-export,
        .filter-action-buttons .btn-tool-print {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px !important;
            box-sizing: border-box !important;
        }

        /* ── 4. Table Container Card (Jurnal Tersimpan) ── */
        .table-container-card {
            padding: 16px 14px !important;
            border-radius: 18px !important;
        }

        .table-container-header h2 {
            font-size: 16px !important;
        }

        .batch-bar-container {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            padding: 12px !important;
            border-radius: 12px !important;
        }

        .batch-bar-right {
            width: 100% !important;
        }

        .btn-batch-delete {
            width: 100% !important;
            justify-content: center !important;
            padding: 10px !important;
        }

        /* Mobile Select All Bar */
        .mobile-select-all-bar {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 12px !important;
            padding: 10px 14px !important;
            margin-bottom: 12px !important;
        }

        .mobile-select-all-label {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #384972 !important;
            cursor: pointer !important;
            user-select: none !important;
        }

        .mobile-select-all-count {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #64748b !important;
        }

        /* Table Transformation into Cards */
        .table-saved-responsive {
            overflow: visible !important;
        }

        .table-saved {
            display: block !important;
            width: 100% !important;
            border: none !important;
        }

        .table-saved thead {
            display: none !important;
        }

        .table-saved tbody {
            display: block !important;
            width: 100% !important;
        }

        .jurnal-row-card {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 16px !important;
            padding: 14px !important;
            margin-bottom: 12px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
            position: relative !important;
        }

        .jurnal-row-card td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
        }

        /* Explicitly hide desktop-only table cells in mobile card mode */
        .jurnal-row-card td.desktop-only-cell,
        .jurnal-row-card td.col-kelas.desktop-only-cell,
        .jurnal-row-card td.col-status.desktop-only-cell,
        .jurnal-row-card td.col-foto.desktop-only-cell,
        .jurnal-row-card td.col-absen.desktop-only-cell,
        .jurnal-row-card td.desktop-only-tanggal,
        .desktop-only-tanggal,
        .desktop-only-cell,
        .desktop-only-jam {
            display: none !important;
        }

        .jurnal-row-card td.col-checkbox {
            position: absolute !important;
            top: 14px !important;
            left: 14px !important;
            width: auto !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            z-index: 5 !important;
        }

        .jurnal-row-card td.col-tanggal {
            display: block !important;
            padding-left: 28px !important;
        }

        .col-foto-absen-wrap { display: block !important; }
        .mobile-only-inline { display: inline-flex !important; }
        .mobile-only-block { display: block !important; }
        .alpa-row-top { display: flex !important; }

        .jurnal-card-header-line {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 8px !important;
            padding-bottom: 8px !important;
            border-bottom: 1px dashed #e2e8f0 !important;
        }

        .jurnal-header-left {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .jurnal-header-date {
            font-size: 13.5px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
        }

        .jurnal-header-date small {
            color: #64748b !important;
            font-weight: 600 !important;
            font-size: 12px !important;
        }

        .badge-kelas-pill {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            font-weight: 800 !important;
            font-size: 11.5px !important;
            padding: 4px 10px !important;
            border-radius: 8px !important;
            border: 1px solid #bfdbfe !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
        }

        .cell-guru-name {
            font-size: 14px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 4px !important;
        }

        .cell-guru-sub {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
        }

        .badge-mapel-pill {
            background: #f1f5f9 !important;
            color: #334155 !important;
            font-weight: 700 !important;
            font-size: 11.5px !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
        }

        .badge-jam-pill {
            background: #f8fafc !important;
            color: #475569 !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
            border: 1px solid #e2e8f0 !important;
        }

        .cell-materi-box {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 10px 12px !important;
            font-size: 12.5px !important;
            line-height: 1.45 !important;
        }

        .cell-materi-title {
            color: #0f172a !important;
            font-weight: 600 !important;
            margin-bottom: 2px !important;
        }

        .cell-materi-note {
            margin-top: 4px !important;
            padding-top: 4px !important;
            border-top: 1px dashed #e2e8f0 !important;
            color: #64748b !important;
        }

        .cell-foto-absen-grid {
            display: grid !important;
            grid-template-columns: auto 1fr !important;
            gap: 10px !important;
            align-items: center !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            padding: 8px 12px !important;
        }

        .cell-foto-wrapper {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .cell-absen-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
        }

        .mobile-cell-label {
            display: block !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.03em !important;
        }

        .absen-list-mobile {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }

        .badge-absen-tag {
            background: #fee2e2 !important;
            color: #991b1b !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 2px 8px !important;
            border-radius: 6px !important;
            border: 1px solid #fca5a5 !important;
        }

        .badge-nihil-pill {
            background: #dcfce7 !important;
            color: #166534 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 2px 8px !important;
            border-radius: 6px !important;
            border: 1px solid #86efac !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .desktop-action-group {
            display: none !important;
        }

        .mobile-action-buttons {
            display: flex !important;
            gap: 6px !important;
            width: 100% !important;
            margin-top: 4px !important;
            padding-top: 8px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        .btn-mob-act {
            flex: 1 !important;
            height: 38px !important;
            border-radius: 10px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.15s !important;
            border: 1px solid transparent !important;
            font-family: inherit !important;
        }

        .btn-mob-detail {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            border-color: #bfdbfe !important;
        }
        .btn-mob-detail:hover {
            background: #dbeafe !important;
        }

        .btn-mob-print {
            background: #ecfdf5 !important;
            color: #047857 !important;
            border-color: #a7f3d0 !important;
        }
        .btn-mob-print:hover {
            background: #d1fae5 !important;
        }

        .btn-mob-delete {
            background: #fef2f2 !important;
            color: #b91c1c !important;
            border-color: #fecaca !important;
            width: 100% !important;
        }
        .btn-mob-delete:hover {
            background: #fee2e2 !important;
        }

        .jurnal-empty-row td {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            border: 1px dashed #cbd5e1 !important;
            border-radius: 14px !important;
            padding: 30px 14px !important;
        }

        /* ── 5. Modal & Pagination Responsiveness ── */
        .modal-overlay {
            padding: 16px 12px !important;
            align-items: flex-start !important;
        }

        .modal-content-box {
            margin: auto !important;
            padding: 20px 16px !important;
            border-radius: 18px !important;
            max-width: 100% !important;
            width: 100% !important;
            max-height: calc(100vh - 36px) !important;
            overflow-y: auto !important;
        }

        .modal-header h3 {
            font-size: 17px !important;
        }

        .modal-body-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }

        .custom-pagination-bar {
            flex-direction: column !important;
            gap: 12px !important;
            align-items: center !important;
            text-align: center !important;
            width: 100% !important;
        }

        .custom-pagination-bar .pagination-info {
            font-size: 12px !important;
            text-align: center !important;
            width: 100% !important;
        }

        .custom-pagination-bar .pagination-list {
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .custom-pagination-bar .page-link {
            padding: 6px 10px !important;
            font-size: 12.5px !important;
            min-width: 34px !important;
            height: 34px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    }

    @media (max-width: 480px) {
        .page-header-title h1 {
            font-size: 25px !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
        }
    }

    @media (max-width: 420px) {
        .stat-cards-grid {
            grid-template-columns: 1fr !important;
        }
        .alpa-filter-row-grid,
        .filter-selects-grid {
            grid-template-columns: 1fr !important;
        }
        .filter-action-buttons {
            grid-template-columns: 1fr !important;
        }
        .filter-action-buttons .btn-tool-trash {
            grid-column: span 1 !important;
        }
        .cell-foto-absen-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Top Header Title (Export and Tambah Jurnal Buttons removed per request) -->
    <div class="page-header-container">
        <div class="page-header-title">
            <h1>Akademik - Jurnal Mengajar</h1>
            <p>Catatan dan monitoring kegiatan mengajar guru setiap pertemuan KBM</p>
        </div>
    </div>

    <!-- Container 1: Laporan Guru Tidak Mengisi Jurnal -->
    <div class="card-alpa">
        <div class="card-alpa-header">
            <h2>
                <i class="fa-solid fa-triangle-exclamation"></i>
                Laporan Guru Tidak Mengisi Jurnal - {{ \Carbon\Carbon::parse($targetTanggal ?? now())->translatedFormat('d F Y') }}
            </h2>
        </div>

        <!-- Filter & Pencarian Guru Tidak Mengisi Jurnal -->
        <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" class="card-alpa-form-filter" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px;">
            <!-- Preserve main table filter parameters if set -->
            @if(!empty($search)) <input type="hidden" name="search" value="{{ $search }}"> @endif
            @if(!empty($tanggal)) <input type="hidden" name="tanggal" value="{{ $tanggal }}"> @endif
            @if(!empty($tanggal_mulai)) <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}"> @endif
            @if(!empty($tanggal_selesai)) <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}"> @endif
            @if(!empty($idGuru)) <input type="hidden" name="id_guru" value="{{ $idGuru }}"> @endif
            @if(!empty($idKelas)) <input type="hidden" name="id_kelas" value="{{ $idKelas }}"> @endif
            @if(!empty($idMapel)) <input type="hidden" name="id_mapel" value="{{ $idMapel }}"> @endif
            @if(!empty($status)) <input type="hidden" name="status" value="{{ $status }}"> @endif

            <div class="alpa-filter-search-box" style="position: relative; flex: 1; min-width: 180px;">
                <input type="text" name="search_alpa" value="{{ $searchAlpa ?? '' }}" class="filter-control-date" style="width: 100%; padding-left: 36px; padding-top: 8px; padding-bottom: 8px; font-size: 13px;" placeholder="Cari Guru / Mapel / Kelas / NIP...">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
            </div>

            <div class="alpa-filter-row-grid">
                <input type="date" name="tanggal_alpa" value="{{ $targetTanggal ?? \Carbon\Carbon::today()->toDateString() }}" class="filter-control-date" style="padding: 8px 12px; font-size: 13px;" title="Pilih Tanggal Laporan">

                <select name="id_kelas_alpa" class="filter-select" style="padding: 8px 12px; font-size: 13px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ (($idKelasAlpa ?? '') == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="alpa-btn-group">
                <button type="submit" class="btn-filter-blue" style="padding: 8px 16px; font-size: 13px;">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                <a href="{{ route('admin.jurnal-mengajar', array_merge(request()->except(['search_alpa', 'id_kelas_alpa', 'tanggal_alpa']), ['tanggal_alpa' => \Carbon\Carbon::today()->toDateString()])) }}" class="btn-today-orange" style="padding: 8px 14px; font-size: 13px;">
                    <i class="fa-solid fa-calendar-day"></i>
                    <span>Hari Ini</span>
                </a>

                @if(!empty($searchAlpa) || !empty($idKelasAlpa) || ($targetTanggal != \Carbon\Carbon::today()->toDateString()))
                    <a href="{{ route('admin.jurnal-mengajar', request()->except(['search_alpa', 'id_kelas_alpa', 'tanggal_alpa'])) }}" class="btn-filter-reset" style="padding: 8px 14px; font-size: 13px;" title="Reset filter guru tidak mengisi jurnal">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <div class="table-alpa-responsive" style="overflow-x: auto;">
            <table class="table-alpa" id="tableGuruAlpa">
                <thead>
                    <tr>
                        <th style="width: 100px;">JAM</th>
                        <th>GURU & MAPEL</th>
                        <th>KELAS & RUANGAN</th>
                        <th>STATUS & KETERANGAN</th>
                    </tr>
                </thead>
                <tbody id="tbodyGuruAlpa">
                    @forelse($guruAlpaList as $alpa)
                        <tr class="alpa-row alpa-card-row">
                            <td class="alpa-cell-jam">
                                <div class="alpa-row-top">
                                    <div class="alpa-jam-badge">
                                        <i class="fa-solid fa-clock"></i>
                                        <strong>Jam Ke-{{ $alpa->jam_range ?? '-' }}</strong>
                                        <span class="alpa-jam-time">({{ $alpa->waktu_range ?? '' }})</span>
                                    </div>
                                    <div class="alpa-kelas-badges">
                                        <span class="badge-alpa-kelas"><i class="fa-solid fa-graduation-cap"></i> {{ $alpa->kelas->nama_kelas ?? '-' }}</span>
                                        <span class="badge-alpa-ruang"><i class="fa-solid fa-door-open"></i> {{ $alpa->ruangan->nama_ruangan ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="desktop-only-jam">
                                    <strong>Jam Ke-{{ $alpa->jam_range ?? '-' }}</strong><br>
                                    <small style="color: #64748b;">{{ $alpa->waktu_range ?? '' }}</small>
                                </div>
                            </td>
                            <td class="alpa-cell-guru">
                                <div class="alpa-guru-name">
                                    <i class="fa-solid fa-chalkboard-user" style="color: #991b1b;"></i>
                                    <strong>{{ $alpa->guru->nama_guru ?? '-' }}</strong>
                                </div>
                                <div class="alpa-guru-meta">
                                    <span>NIP: {{ $alpa->guru->nip ?? '-' }}</span>
                                    <span class="alpa-mapel-pill"><i class="fa-solid fa-book-open"></i> {{ $alpa->mapel->nama_mapel ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="alpa-cell-kelas desktop-only-cell">
                                <strong>{{ $alpa->kelas->nama_kelas ?? '-' }}</strong><br>
                                <small style="color: #64748b;">Ruang: {{ $alpa->ruangan->nama_ruangan ?? '-' }}</small>
                            </td>
                            <td class="alpa-cell-status">
                                <span class="{{ $alpa->status_badge_class ?? 'badge-alpa-red' }}">
                                    {{ $alpa->status_alpa_label ?? 'TIDAK MENGISI JURNAL (ALPA)' }}
                                </span>
                                @if(!empty($alpa->keterangan_alpa))
                                    <div class="alpa-keterangan-text" style="font-size: 11px; color: #64748b; margin-top: 3px; font-weight: 600;">
                                        <i class="fa-solid fa-circle-info"></i> {{ $alpa->keterangan_alpa }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="alpa-empty-row">
                            <td colspan="4" class="alpa-empty-cell" style="text-align: center; color: #166534; font-weight: 700; padding: 20px;">
                                <i class="fa-solid fa-circle-check" style="font-size: 20px; margin-right: 6px; vertical-align: middle;"></i>
                                Semua guru mengajar yang terjadwal telah mengisi jurnal pada tanggal ini!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Bar untuk Laporan Guru Tidak Mengisi Jurnal --}}
        <div class="alpa-pagination-wrapper" id="alpaPaginationWrapper">
            <div class="alpa-pagination-container">
                <button type="button" class="alpa-page-btn alpa-nav-btn" id="alpaPrevBtn" title="Halaman Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div id="alpaPageNumbers" style="display: inline-flex; gap: 4px;"></div>
                <button type="button" class="alpa-page-btn alpa-nav-btn" id="alpaNextBtn" title="Halaman Selanjutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Header Navy Banner -->
    <div class="header-banner-dark">
        <i class="fa-solid fa-clipboard-list"></i>
        <span>Daftar Jurnal Mengajar</span>
    </div>

    <!-- 4 Summary Stat Cards Grid (Dynamic & Synchronized) - Placed ABOVE Filter Bar -->
    <div class="stat-cards-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-purple">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Pertemuan</div>
                <div class="stat-value">{{ $totalPertemuan }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Terlaksana</div>
                <div class="stat-value">{{ $terlaksanaCount }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-orange">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Belum Terlaksana</div>
                <div class="stat-value">{{ $belumTerlaksanaCount }} Pertemuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-blue">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Guru Aktif</div>
                <div class="stat-value">{{ $guruAktifCount }} Guru</div>
            </div>
        </div>
    </div>

    <!-- Filter Section Bar (With Search, Dropdowns, Reset, and Action Tools) - Placed BELOW Stat Cards -->
    <form action="{{ route('admin.jurnal-mengajar') }}" method="GET" class="filter-section-bar">
        <!-- Preserve alpa filters if set -->
        @if(!empty($targetTanggal) && $targetTanggal !== \Carbon\Carbon::today()->toDateString()) <input type="hidden" name="tanggal_alpa" value="{{ $targetTanggal }}"> @endif
        @if(!empty($searchAlpa)) <input type="hidden" name="search_alpa" value="{{ $searchAlpa }}"> @endif
        @if(!empty($idKelasAlpa)) <input type="hidden" name="id_kelas_alpa" value="{{ $idKelasAlpa }}"> @endif

        <div class="filter-search-wrapper" style="position:relative; flex:1; min-width:180px;">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="filter-control-date" style="width:100%; padding-left:36px;" placeholder="Cari Materi / Catatan / Guru...">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
        </div>

        <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-control-date filter-input-date" title="Filter Tanggal Mengajar">

        <div class="filter-selects-grid">
            <select name="id_guru" class="filter-select">
                <option value="">Semua Guru</option>
                @foreach($guruList as $g)
                    <option value="{{ $g->id_guru }}" {{ ($idGuru == $g->id_guru) ? 'selected' : '' }}>
                        {{ $g->nama_guru }}
                    </option>
                @endforeach
            </select>

            <select name="id_kelas" class="filter-select">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ ($idKelas == $k->id_kelas) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <select name="id_mapel" class="filter-select">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $m)
                    <option value="{{ $m->id_mapel }}" {{ ($idMapel == $m->id_mapel) ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Terlaksana" {{ ($status == 'Terlaksana') ? 'selected' : '' }}>Terlaksana (Hadir)</option>
                <option value="Belum Terlaksana" {{ ($status == 'Belum Terlaksana') ? 'selected' : '' }}>Belum Terlaksana (Izin/Sakit/Alpa)</option>
            </select>
        </div>

        <div class="filter-submit-group">
            <button type="submit" class="btn-filter-blue">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </button>

            @if(!empty($search) || ($tanggal !== ($todayDate ?? \Carbon\Carbon::today()->toDateString())) || !empty($tanggal_mulai) || !empty($tanggal_selesai) || !empty($idGuru) || !empty($idKelas) || !empty($idMapel) || !empty($status))
                <a href="{{ route('admin.jurnal-mengajar') }}" class="btn-filter-reset" title="Reset semua filter ke hari ini">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset</span>
                </a>
            @endif
        </div>

        <div class="filter-action-buttons">
            <a href="{{ route('admin.jurnal-mengajar.trash') }}" class="btn-action-tool btn-tool-trash" title="Buka Tempat Sampah Jurnal">
                <i class="fa-solid fa-trash-can"></i>
                <span>Sampah Jurnal</span>
                @if($trashedCount > 0)
                    <span class="badge-trash">{{ $trashedCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.jurnal-mengajar.export', request()->query()) }}" class="btn-action-tool btn-tool-export" title="Unduh format file CSV">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor CSV</span>
            </a>

            <a href="{{ route('admin.jurnal-mengajar.print', request()->query()) }}" target="_blank" class="btn-action-tool btn-tool-print" title="Cetak Rekap Jurnal">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekap</span>
            </a>
        </div>
    </form>

    <!-- Data Table Container: Jurnal Tersimpan -->
    <div class="table-container-card">
        <div class="table-container-header">
            <h2>
                Jurnal Tersimpan - 
                @if(!empty($tanggal))
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                @elseif(!empty($tanggal_mulai) && !empty($tanggal_selesai))
                    {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}
                @else
                    Semua Tanggal
                @endif
            </h2>
        </div>

        <!-- Batch Action Bar (Appears when checkboxes are selected) -->
        <div class="batch-bar-container" id="batchActionBar" style="display: none;">
            <div class="batch-bar-left">
                <i class="fa-solid fa-check-double"></i>
                <span id="batchSelectedText">0 jurnal dipilih</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-batch-delete" onclick="submitBatchDelete()">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Hapus Terpilih ke Sampah</span>
                </button>
            </div>
        </div>

        <!-- Hidden Form for Batch Delete -->
        <form id="formBatchDelete" action="{{ route('admin.jurnal-mengajar.batch-delete') }}" method="POST" style="display: none;">
            @csrf
            <div id="batchDeleteInputs"></div>
        </form>

        <!-- Mobile Select All Bar (Shown only on mobile <= 768px) -->
        <div class="mobile-select-all-bar">
            <label class="mobile-select-all-label">
                <input type="checkbox" id="mobileSelectAllJurnal" class="custom-checkbox" onchange="toggleSelectAllJurnalsMobile(this)">
                <span>Pilih Semua Jurnal</span>
            </label>
            <span class="mobile-select-all-count" id="mobileSelectAllCount">Total: {{ $jurnals->total() }} Data</span>
        </div>

        <div class="table-saved-responsive" style="overflow-x: auto;">
            <table class="table-saved">
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;">
                            <input type="checkbox" id="selectAllJurnal" class="custom-checkbox" onchange="toggleSelectAllJurnals(this)" title="Pilih Semua">
                        </th>
                        <th style="width: 100px;">TANGGAL</th>
                        <th>GURU & MAPEL</th>
                        <th style="width: 90px;">KELAS</th>
                        <th style="width: 100px;">STATUS</th>
                        <th style="width: 80px;">BUKTI FOTO</th>
                        <th>MATERI / CATATAN</th>
                        <th>SISWA TIDAK HADIR</th>
                        <th style="width: 90px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                        @php
                            $isHadir = ($j->status_kehadiran_guru === 'Hadir');
                        @endphp
                        <tr class="jurnal-row-card">
                            <td class="col-checkbox" style="text-align: center;">
                                <input type="checkbox" class="custom-checkbox jurnal-item-cb" value="{{ $j->id_jurnal }}" onchange="handleJurnalCheck()">
                            </td>
                            <td class="col-tanggal">
                                <div class="jurnal-card-header-line">
                                    <div class="jurnal-header-left">
                                        <span class="jurnal-header-date">
                                            <i class="fa-regular fa-calendar" style="color: #384972; margin-right: 4px;"></i>
                                            <strong>{{ \Carbon\Carbon::parse($j->tanggal)->format('Y-m-d') }}</strong>
                                            <small>({{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l') }})</small>
                                        </span>
                                        <span class="badge-kelas-pill mobile-only-inline">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            {{ $j->jadwal->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="jurnal-header-right mobile-only-block">
                                        @if($isHadir)
                                            <span class="badge-hadir-green"><i class="fa-solid fa-check"></i> Hadir</span>
                                        @elseif($j->status_kehadiran_guru === 'Izin')
                                            <span class="badge-izin-amber"><i class="fa-solid fa-clock"></i> Izin</span>
                                        @else
                                            <span class="badge-absen-red"><i class="fa-solid fa-xmark"></i> {{ $j->status_kehadiran_guru }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="desktop-only-tanggal">
                                    <strong>{{ \Carbon\Carbon::parse($j->tanggal)->format('Y-m-d') }}</strong><br>
                                    <small style="color:#64748b;">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l') }}</small>
                                </div>
                            </td>
                            <td class="col-guru-mapel">
                                <div class="cell-guru-name">
                                    <i class="fa-solid fa-chalkboard-user" style="color: #384972; margin-right: 4px;"></i>
                                    <strong>{{ $j->jadwal->guru->nama_guru ?? ($j->guruPengganti->nama_guru ?? '-') }}</strong>
                                    @if($j->guruPengganti && $j->jadwal && $j->jadwal->guru && $j->jadwal->id_guru != $j->id_guru_pengganti)
                                        <small style="color: #2563eb; font-weight: 700;">(Pengganti: {{ $j->guruPengganti->nama_guru }})</small>
                                    @endif
                                </div>
                                <div class="cell-guru-sub">
                                    <span class="badge-mapel-pill"><i class="fa-solid fa-book-open"></i> {{ $j->jadwal->mapel->nama_mapel ?? '-' }}</span>
                                    <span class="badge-jam-pill"><i class="fa-solid fa-clock"></i> Jam ke-{{ $j->jadwal->jam_range ?? ($j->jam_ke ?? '-') }}</span>
                                </div>
                            </td>
                            <td class="col-kelas desktop-only-cell">
                                <strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong>
                            </td>
                            <td class="col-status desktop-only-cell">
                                @if($isHadir)
                                    <span class="badge-hadir-green">Hadir</span>
                                @elseif($j->status_kehadiran_guru === 'Izin')
                                    <span class="badge-izin-amber">Izin</span>
                                @else
                                    <span class="badge-absen-red">{{ $j->status_kehadiran_guru }}</span>
                                @endif
                            </td>
                            <td class="col-foto-absen-wrap">
                                <div class="cell-foto-absen-grid">
                                    <div class="cell-foto-wrapper">
                                        <span class="mobile-cell-label">Bukti Foto:</span>
                                        @if($j->dokumentasi_url)
                                            <img src="{{ $j->dokumentasi_url }}" class="photo-thumb-box" alt="Bukti Foto" onclick="openPhotoPreview('{{ $j->dokumentasi_url }}', '{{ addslashes($j->materi) }}')">
                                        @else
                                            <div class="photo-placeholder-box" title="Foto tidak diunggah">
                                                <i class="fa-regular fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cell-absen-wrapper">
                                        <span class="mobile-cell-label">Siswa Tidak Hadir:</span>
                                        @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                                            <div class="absen-list-mobile">
                                                @foreach($j->detailKetidakhadiran as $d)
                                                    <span class="badge-absen-tag">
                                                        {{ $d->siswa->nama_siswa ?? 'Siswa' }} <small>({{ strtolower($d->keterangan) }})</small>
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="badge-nihil-pill"><i class="fa-solid fa-check"></i> Nihil</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="col-foto desktop-only-cell">
                                @if($j->dokumentasi_url)
                                    <img src="{{ $j->dokumentasi_url }}" class="photo-thumb-box" alt="Bukti Foto" onclick="openPhotoPreview('{{ $j->dokumentasi_url }}', '{{ addslashes($j->materi) }}')">
                                @else
                                    <div class="photo-placeholder-box" title="Foto tidak diunggah">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="col-materi">
                                <div class="cell-materi-box">
                                    <div class="cell-materi-title">
                                        <i class="fa-solid fa-pen-nib" style="color: #384972; margin-right: 4px;"></i>
                                        <strong>Materi:</strong> {{ Str::limit($j->materi, 50) }}
                                    </div>
                                    @if($j->catatan)
                                        <div class="cell-materi-note">
                                            <i class="fa-regular fa-comment-dots" style="color: #64748b; margin-right: 4px;"></i>
                                            <small><strong>Catatan:</strong> {{ Str::limit($j->catatan, 35) }}</small>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="col-absen desktop-only-cell">
                                @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                                    @foreach($j->detailKetidakhadiran as $d)
                                        <span style="color:#dc2626; font-weight:700; display:block; font-size: 12px;">
                                            {{ $d->siswa->nama_siswa ?? 'Siswa' }} <span style="font-weight:600; color:#ef4444;">- {{ strtolower($d->keterangan) }}</span>
                                        </span>
                                    @endforeach
                                @else
                                    <span style="color:#166534; font-weight:700; font-size: 12px;">nihil</span>
                                @endif
                            </td>
                            <td class="col-aksi">
                                <!-- Desktop Action Group (Eye + 3-dots) -->
                                <div class="action-group desktop-action-group">
                                    <!-- Button 1: Eye Icon for Detail Modal -->
                                    <button type="button" class="btn-action-icon" onclick="openDetailModal({{ $j->id_jurnal }})" title="Lihat Detail Jurnal">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <!-- Button 2: 3-Dots Dropdown Menu -->
                                    <div class="action-dropdown">
                                        <button type="button" class="btn-action-icon" onclick="toggleActionDropdown(event, {{ $j->id_jurnal }})" title="Menu Opsi">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="action-dropdown-menu" id="dropdownMenu-{{ $j->id_jurnal }}">
                                            <button type="button" class="dropdown-menu-item" onclick="openDetailModal({{ $j->id_jurnal }})">
                                                <i class="fa-regular fa-eye" style="color: #2563eb;"></i>
                                                <span>Lihat Detail</span>
                                            </button>

                                            <a href="{{ route('admin.jurnal-mengajar.print-detail', $j->id_jurnal) }}" target="_blank" class="dropdown-menu-item">
                                                <i class="fa-solid fa-print" style="color: #059669;"></i>
                                                <span>Cetak PDF Detail</span>
                                            </a>

                                            <form action="{{ route('admin.jurnal-mengajar.destroy', $j->id_jurnal) }}" method="POST" onsubmit="return confirm('Pindahkan jurnal mengajar ini ke Kotak Sampah?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-menu-item danger-item">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                    <span>Hapus ke Sampah</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile Action Buttons (Full-width direct tap) -->
                                <div class="mobile-action-buttons">
                                    <button type="button" class="btn-mob-act btn-mob-detail" onclick="openDetailModal({{ $j->id_jurnal }})">
                                        <i class="fa-regular fa-eye"></i>
                                        <span>Detail</span>
                                    </button>
                                    <a href="{{ route('admin.jurnal-mengajar.print-detail', $j->id_jurnal) }}" target="_blank" class="btn-mob-act btn-mob-print">
                                        <i class="fa-solid fa-print"></i>
                                        <span>Cetak PDF</span>
                                    </a>
                                    <form action="{{ route('admin.jurnal-mengajar.destroy', $j->id_jurnal) }}" method="POST" onsubmit="return confirm('Pindahkan jurnal mengajar ini ke Kotak Sampah?')" style="margin: 0; flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-mob-act btn-mob-delete">
                                            <i class="fa-regular fa-trash-can"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="jurnal-empty-row">
                            <td colspan="9" style="text-align: center; padding: 40px; color: #64748b;">
                                <i class="fa-regular fa-folder-open" style="font-size: 36px; margin-bottom: 10px; display: block; color: #94a3b8;"></i>
                                Tidak ada data jurnal tersimpan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Bar -->
        @if($jurnals->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #ffffff;">
                {{ $jurnals->withQueryString()->links('partials.custom-pagination') }}
            </div>
        @endif
    </div>

    <!-- Modal 1: Detail Jurnal Popup -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content-box">
            <div class="modal-header">
                <h3>Detail Jurnal Mengajar</h3>
                <button type="button" class="btn-modal-close" onclick="closeDetailModal()">&times;</button>
            </div>

            <div id="modalDetailContent">
                <div style="text-align: center; padding: 30px; color: #64748b;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                    <p>Memuat detail jurnal...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Lightbox Preview Foto -->
    <div class="modal-overlay" id="photoPreviewModal" onclick="closePhotoPreview()">
        <div style="max-width: 800px; width: 90%; text-align: center; position: relative;" onclick="event.stopPropagation()">
            <img id="lightboxImg" src="" alt="Preview Dokumentasi" style="max-width: 100%; max-height: 80vh; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); object-fit: contain;">
            <div id="lightboxCaption" style="color: #ffffff; margin-top: 12px; font-size: 14px; font-weight: 700;"></div>
            <button type="button" onclick="closePhotoPreview()" style="position: absolute; top: -14px; right: -14px; background: #ffffff; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 18px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">&times;</button>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function toggleActionDropdown(event, idJurnal) {
        event.stopPropagation();
        const allMenus = document.querySelectorAll('.action-dropdown-menu');
        allMenus.forEach(m => {
            if (m.id !== `dropdownMenu-${idJurnal}`) {
                m.classList.remove('show', 'dropup');
            }
        });

        const targetMenu = document.getElementById(`dropdownMenu-${idJurnal}`);
        if (targetMenu) {
            const isShowing = targetMenu.classList.contains('show');
            if (!isShowing) {
                const btn = event.currentTarget;
                const rect = btn.getBoundingClientRect();
                const spaceBelow = window.innerHeight - rect.bottom;
                if (spaceBelow < 180) {
                    targetMenu.classList.add('dropup');
                } else {
                    targetMenu.classList.remove('dropup');
                }
                targetMenu.classList.add('show');
            } else {
                targetMenu.classList.remove('show', 'dropup');
            }
        }
    }

    document.addEventListener('click', function() {
        const allMenus = document.querySelectorAll('.action-dropdown-menu');
        allMenus.forEach(m => m.classList.remove('show', 'dropup'));
    });

    // ── Checkbox & Batch Delete Jurnal ──────────────────────────
    function toggleSelectAllJurnals(master) {
        const checkboxes = document.querySelectorAll('.jurnal-item-cb');
        checkboxes.forEach(cb => cb.checked = master.checked);
        const mobileMaster = document.getElementById('mobileSelectAllJurnal');
        if (mobileMaster && mobileMaster !== master) {
            mobileMaster.checked = master.checked;
        }
        const desktopMaster = document.getElementById('selectAllJurnal');
        if (desktopMaster && desktopMaster !== master) {
            desktopMaster.checked = master.checked;
        }
        updateBatchActionBar();
    }

    function toggleSelectAllJurnalsMobile(mobileMaster) {
        toggleSelectAllJurnals(mobileMaster);
    }

    function handleJurnalCheck() {
        const checkboxes = document.querySelectorAll('.jurnal-item-cb');
        const master = document.getElementById('selectAllJurnal');
        const mobileMaster = document.getElementById('mobileSelectAllJurnal');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        if (master) {
            master.checked = allChecked && checkboxes.length > 0;
        }
        if (mobileMaster) {
            mobileMaster.checked = allChecked && checkboxes.length > 0;
        }
        updateBatchActionBar();
    }

    function updateBatchActionBar() {
        const checkedItems = document.querySelectorAll('.jurnal-item-cb:checked');
        const count = checkedItems.length;
        const bar = document.getElementById('batchActionBar');
        const countText = document.getElementById('batchSelectedText');

        if (count > 0) {
            bar.style.display = 'flex';
            countText.textContent = `${count} data jurnal dipilih`;
        } else {
            bar.style.display = 'none';
        }
    }

    function submitBatchDelete() {
        const checkedItems = document.querySelectorAll('.jurnal-item-cb:checked');
        if (checkedItems.length === 0) return;

        if (!confirm(`Apakah Anda yakin ingin memindahkan ${checkedItems.length} data jurnal mengajar terpilih ke Kotak Sampah?`)) {
            return;
        }

        const container = document.getElementById('batchDeleteInputs');
        container.innerHTML = '';
        checkedItems.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('formBatchDelete').submit();
    }

    // ── Photo Lightbox Preview ──────────────────────────────────
    function openPhotoPreview(url, caption) {
        const modal = document.getElementById('photoPreviewModal');
        const img = document.getElementById('lightboxImg');
        const cap = document.getElementById('lightboxCaption');

        img.src = url;
        cap.textContent = caption || 'Foto Dokumentasi KBM';
        modal.classList.add('active');
    }

    function closePhotoPreview() {
        document.getElementById('photoPreviewModal').classList.remove('active');
    }

    // ── Detail Modal Fetch & Display ────────────────────────────
    function openDetailModal(idJurnal) {
        const modal = document.getElementById('detailModal');
        const container = document.getElementById('modalDetailContent');

        modal.classList.add('active');
        container.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p>Memuat detail jurnal...</p>
            </div>
        `;

        fetch(`{{ url('/admin/jurnal-mengajar-admin/detail') }}/${idJurnal}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const d = res.data;
                let absensiHtml = '';
                if (d.absensi_siswa && d.absensi_siswa.length > 0) {
                    absensiHtml = d.absensi_siswa.map((s, idx) => `
                        <tr>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;">${idx + 1}</td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;"><strong>${s.nama_siswa}</strong></td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0;">${s.nis}</td>
                            <td style="padding:8px 12px; border-bottom:1px solid #e2e8f0; font-weight:700; color:#dc2626;">${s.keterangan}</td>
                        </tr>
                    `).join('');
                } else {
                    absensiHtml = `<tr><td colspan="4" style="text-align:center; color:#166534; font-weight:700; padding:12px;">Semua siswa hadir (Nihil)</td></tr>`;
                }

                let photoHtml = '';
                if (d.dokumentasi_url) {
                    const safeMateri = (d.materi || 'Foto Dokumentasi KBM').replace(/[\r\n]+/g, ' ').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    photoHtml = `
                        <div style="margin-top:18px; text-align:center;">
                            <span style="display:block; font-size:11px; font-weight:800; color:#475569; text-transform:uppercase; margin-bottom:8px; letter-spacing:0.04em;">
                                <i class="fa-solid fa-camera" style="margin-right:4px; color:#384972;"></i> FOTO BUKTI DOKUMENTASI (Klik untuk memperbesar)
                            </span>
                            <div style="display:inline-block; position:relative; cursor:pointer;" onclick="openPhotoPreview('${d.dokumentasi_url}', '${safeMateri}')">
                                <img src="${d.dokumentasi_url}" style="max-width:100%; max-height:260px; border-radius:12px; border:1px solid #cbd5e1; object-fit:cover; display:block; margin:0 auto; box-shadow:0 4px 14px rgba(0,0,0,0.06); transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'" alt="Bukti Foto KBM" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\\'padding:14px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b; font-size:12px;\\'><i class=\\'fa-regular fa-image-slash\\'></i> Foto dokumentasi tidak dapat dimuat.</div>';">
                            </div>
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div class="modal-body-grid">
                        <div class="detail-item-box">
                            <span>TANGGAL</span>
                            <strong>${d.tanggal}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>STATUS GURU</span>
                            <strong style="color: ${d.status_kehadiran_guru === 'Hadir' ? '#166534' : '#dc2626'};">${d.status_kehadiran_guru}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>GURU PENGAJAR</span>
                            <strong>${d.guru}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>MATA PELAJARAN</span>
                            <strong>${d.mapel}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>KELAS & RUANGAN</span>
                            <strong>${d.kelas} — Ruang ${d.ruangan}</strong>
                        </div>
                        <div class="detail-item-box">
                            <span>JAM KE-</span>
                            <strong>Jam Ke-${d.jam_ke}</strong>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:4px;">MATERI PEMBELAJARAN</span>
                        <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:12px; font-size:13px; line-height:1.5;">${d.materi}</div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:4px;">CATATAN PEMBELAJARAN</span>
                        <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:12px; padding:12px; font-size:13px; color:#475569;">${d.catatan}</div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="display:block; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">DAFTAR SISWA TIDAK HADIR</span>
                        <table style="width:100%; border-collapse:collapse; background:#ffffff; border:1px solid #cbd5e1; border-radius:10px; overflow:hidden; font-size:12.5px;">
                            <thead>
                                <tr style="background:#f1f5f9; text-align:left; font-size:11px; color:#475569;">
                                    <th style="padding:8px 12px;">NO</th>
                                    <th style="padding:8px 12px;">NAMA SISWA</th>
                                    <th style="padding:8px 12px;">NISN</th>
                                    <th style="padding:8px 12px;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>${absensiHtml}</tbody>
                        </table>
                    </div>

                    ${photoHtml}

                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; border-top:1px solid #e2e8f0; padding-top:14px;">
                        <a href="{{ url('/admin/jurnal-mengajar-admin/print-detail') }}/${d.id_jurnal}" target="_blank" class="btn-filter-blue" style="border-radius:12px; text-decoration:none; background:#10b981;">
                            <i class="fa-solid fa-print"></i> Cetak Detail PDF
                        </a>
                    </div>
                `;
            }
        })
        .catch(err => {
            container.innerHTML = `<p style="color:#dc2626; text-align:center;">Gagal memuat detail jurnal.</p>`;
        });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    // ── Pagination for Laporan Guru Alpa Table ─────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 5;
        const rows = document.querySelectorAll('#tbodyGuruAlpa tr.alpa-row');
        const totalRows = rows.length;
        const paginationWrapper = document.getElementById('alpaPaginationWrapper');
        const pageNumbersContainer = document.getElementById('alpaPageNumbers');
        const prevBtn = document.getElementById('alpaPrevBtn');
        const nextBtn = document.getElementById('alpaNextBtn');

        if (!paginationWrapper) return;

        if (totalRows <= rowsPerPage) {
            paginationWrapper.style.display = 'none';
            return;
        }

        paginationWrapper.style.display = 'flex';
        let currentPage = 1;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                const isVisible = (index >= start && index < end);
                row.classList.toggle('alpa-row-hidden', !isVisible);
                if (isVisible) {
                    row.style.removeProperty('display');
                } else {
                    row.style.setProperty('display', 'none', 'important');
                }
            });

            renderPageNumbers();
            if (prevBtn) prevBtn.disabled = (currentPage === 1);
            if (nextBtn) nextBtn.disabled = (currentPage === totalPages);
        }

        function renderPageNumbers() {
            if (!pageNumbersContainer) return;
            pageNumbersContainer.innerHTML = '';

            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'alpa-page-btn' + (i === currentPage ? ' active' : '');
                btn.textContent = i;
                btn.addEventListener('click', function () {
                    showPage(i);
                });
                pageNumbersContainer.appendChild(btn);
            }
        }

        if (prevBtn) {
            prevBtn.onclick = function () {
                if (currentPage > 1) showPage(currentPage - 1);
            };
        }

        if (nextBtn) {
            nextBtn.onclick = function () {
                if (currentPage < totalPages) showPage(currentPage + 1);
            };
        }

        showPage(1);
    });
</script>
@endsection
