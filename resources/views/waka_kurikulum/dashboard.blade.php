@extends('layouts.waka_kurikulum')

@section('title', 'Dashboard Wakil Kurikulum — EDU JOURNAL')

@section('styles')
<style>
    /* ─── Base Dashboard Container (Gray, White, Light Gray Palette) ─── */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ─── Page Header ─── */
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-main-title {
        font-size: 24px;
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

    /* ─── Primary 4 Stat Cards (Clean White & Soft Gray Border) ─── */
    .stat-cards-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .stat-box-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .stat-box-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }

    .stat-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-circle-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .icon-circle-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .icon-circle-purple { background: #faf5ff; color: #7c3aed; border: 1px solid #f3e8ff; }
    .icon-circle-orange { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
    .icon-circle-gray   { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    .stat-content {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .stat-label-text {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 1px;
    }

    .stat-number-text {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .stat-subtext {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* ─── Quick Summary Strip (Perizinan Guru & Pengganti) ─── */
    .quick-summary-strip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 16px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        align-items: center;
    }

    .quick-pill-item {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: inherit;
        padding: 6px 8px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .quick-pill-item:hover {
        background: #f8fafc;
    }

    .quick-pill-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .quick-pill-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
    }

    .quick-pill-val {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    /* ─── Card Panels (Abu-abu / Putih Bersih) ─── */
    .card-panel {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 10px;
    }

    .panel-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-subtitle {
        font-size: 11.5px;
        font-weight: 500;
        color: #64748b;
        margin-top: 2px;
    }

    /* ─── Tab Switcher (Abu-abu muda / Biru) ─── */
    .tabs-nav {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 10px;
        gap: 3px;
    }

    .tab-btn {
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .tab-btn.active {
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .tab-badge {
        padding: 1px 6px;
        border-radius: 10px;
        font-size: 10.5px;
        font-weight: 800;
    }

    .tab-badge-blue  { background: #eff6ff; color: #2563eb; }
    .tab-badge-gray  { background: #e2e8f0; color: #475569; }

    /* ─── Modern Tables ─── */
    .table-scroll-container {
        overflow-x: auto;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        position: relative;
        box-sizing: border-box;
    }

    /* Dual layout: on desktop show table, hide cards */
    .wk-desktop-table {
        display: block;
    }

    .wk-mobile-cards {
        display: none;
    }

    .batch-action-mobile {
        display: none;
    }

    .table-scroll-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .table-scroll-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 9px 10px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-scroll-container thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #f8fafc;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .custom-table td {
        padding: 9px 10px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    /* ─── Compact Status Badges ─── */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 7px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        line-height: 1.2;
    }

    .badge-status-approved { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-status-pending  { background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; }
    .badge-status-rejected { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-status-active   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-status-cuti     { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .badge-status-expired  { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    /* ─── Action Buttons ─── */
    .btn-action-group {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-action-approve { background: #16a34a; color: #ffffff; }
    .btn-action-approve:hover { background: #15803d; transform: translateY(-1px); color: #ffffff; }

    .btn-action-reject { background: #dc2626; color: #ffffff; }
    .btn-action-reject:hover { background: #b91c1c; transform: translateY(-1px); color: #ffffff; }

    .btn-action-detail { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-action-detail:hover { background: #dbeafe; color: #1d4ed8; }

    .btn-action-link { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .btn-action-link:hover { background: #e2e8f0; color: #0f172a; }

    /* Teacher Cell Layout */
    .teacher-profile-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        font-size: 12.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #cbd5e1;
    }

    /* Thumbnail Bukti */
    .thumb-preview-box {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        transition: transform 0.2s ease;
    }

    .thumb-preview-box:hover {
        transform: scale(1.08);
        border-color: #2563eb;
    }

    .thumb-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ─── Grid Dua Kolom (Live Monitoring & Capaian) ─── */
    .dashboard-main-grid {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 18px;
    }

    /* Weekly Chart */
    .weekly-chart-box {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 170px;
        padding-top: 16px;
        border-bottom: 1px solid #cbd5e1;
        margin-bottom: 10px;
        gap: 10px;
    }

    .chart-bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        height: 100%;
        justify-content: flex-end;
        position: relative;
    }

    .chart-bar-pillar {
        width: 34px;
        background: #e2e8f0;
        border-radius: 6px 6px 0 0;
        transition: height 0.4s ease, background-color 0.2s ease;
        position: relative;
    }

    .chart-bar-pillar.active-today {
        background: #2563eb;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
    }

    .chart-bar-pillar.has-realisasi {
        background: #3b82f6;
    }

    .chart-bar-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        margin-top: 6px;
    }

    .chart-bar-count {
        font-size: 10.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 3px;
    }

    /* Filter Pills for Monitoring Table */
    .filter-pills-row {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .pill-btn {
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pill-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* ─── Modal Backdrop & Dialog ─── */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(3px);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-backdrop-custom.show {
        display: flex;
    }

    .modal-dialog-custom {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 540px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: modalSlideUp 0.2s ease-out;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(15px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-dialog-custom.modal-lg {
        max-width: 740px;
    }

    .modal-header-custom {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
        padding: 2px;
        line-height: 1;
        transition: color 0.2s;
    }

    .modal-close-btn:hover {
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .modal-footer-custom {
        padding: 12px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    /* ─── Modern Responsive Styles ─── */
    @media (max-width: 1100px) {
        .stat-cards-row { grid-template-columns: repeat(2, 1fr); }
        .quick-summary-strip { grid-template-columns: repeat(2, 1fr); }
        .dashboard-main-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            gap: 14px;
        }

        /* Header Box */
        .page-header-box {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .page-main-title {
            font-size: 20px;
        }

        .page-sub-title {
            font-size: 12px;
            line-height: 1.4;
        }

        .header-action-btns {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
        }

        .header-action-btns .btn-table-action {
            flex: 1;
            padding: 8px 6px !important;
            font-size: 11px !important;
            height: 36px;
            justify-content: center;
            box-sizing: border-box;
            text-align: center;
        }

        /* 4 Stat Cards Row */
        .stat-cards-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .stat-box-card {
            padding: 12px 14px;
            border-radius: 12px;
            gap: 10px;
        }

        .stat-icon-circle {
            width: 40px;
            height: 40px;
            font-size: 16px;
            border-radius: 10px;
        }

        .stat-number-text {
            font-size: 18px;
        }

        .stat-label-text {
            font-size: 11px;
        }

        .stat-subtext {
            font-size: 10px;
        }

        /* Quick Summary Strip */
        .quick-summary-strip {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding: 10px;
            border-radius: 12px;
        }

        .quick-pill-item {
            padding: 6px 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            gap: 8px;
        }

        .quick-pill-icon {
            width: 28px;
            height: 28px;
            font-size: 11.5px;
            border-radius: 6px;
        }

        .quick-pill-label {
            font-size: 10px;
        }

        .quick-pill-val {
            font-size: 12px;
        }

        /* Card Panels */
        .card-panel {
            padding: 14px 12px;
            border-radius: 14px;
        }

        .panel-header {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            margin-bottom: 12px;
            padding-bottom: 10px;
        }

        .panel-header > div:first-child {
            width: 100%;
        }

        .panel-header-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 8px;
        }

        .panel-title {
            font-size: 14px;
        }

        .panel-subtitle {
            font-size: 11px;
            line-height: 1.35;
        }

        /* Tabs Nav Horizontal Scroll */
        .tabs-nav {
            width: 100%;
            display: flex;
            gap: 4px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 3px;
            box-sizing: border-box;
            background: #f1f5f9;
        }

        .tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            padding: 6px 10px;
            font-size: 11px;
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* ─── Dual Layout: Desktop Table / Mobile Cards ─── */
        .wk-desktop-table {
            display: none !important;
        }

        .wk-mobile-cards {
            display: block;
        }

        /* Mobile Card Base */
        .m-card-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 8px;
            overflow: hidden;
            box-sizing: border-box;
            width: 100%;
        }

        .m-card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-sizing: border-box;
            width: 100%;
        }

        .m-card-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            font-weight: 800;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid #bfdbfe;
        }

        .m-card-guru-name {
            font-size: 12.5px;
            font-weight: 800;
            color: #0f172a;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }

        .m-card-guru-sub {
            font-size: 10.5px;
            color: #64748b;
        }

        .m-card-body {
            padding: 8px 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            box-sizing: border-box;
            width: 100%;
        }

        .m-card-row {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            box-sizing: border-box;
            width: 100%;
        }

        .m-card-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #64748b;
            min-width: 80px;
            flex-shrink: 0;
        }

        .m-card-value {
            font-size: 11px;
            color: #1e293b;
            font-weight: 600;
            flex: 1;
            min-width: 0;
            word-break: break-word;
        }

        .m-card-actions {
            padding: 8px 10px;
            border-top: 1px solid #f1f5f9;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            box-sizing: border-box;
            width: 100%;
        }

        .m-card-actions .btn-table-action {
            flex: none;
            justify-content: center;
            padding: 6px 4px;
            font-size: 10.5px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .m-card-actions-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .m-card-actions-1 {
            grid-template-columns: 1fr;
        }

        /* Batch action on mobile */
        .batch-action-mobile {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 10px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-sizing: border-box;
            width: 100%;
        }

        /* KBM monitoring card */
        .m-kbm-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 8px;
            box-sizing: border-box;
            width: 100%;
        }

        .m-kbm-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .m-kbm-jam {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
        }

        .m-kbm-time {
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
        }

        .m-kbm-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 8px;
        }

        .m-kbm-field {
            box-sizing: border-box;
        }

        .m-kbm-field-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .m-kbm-field-value {
            font-size: 11.5px;
            font-weight: 700;
            color: #1e293b;
            word-break: break-word;
        }

        /* Table scroll on mobile: keep scrollable but also offer card layout */
        .table-scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            border-radius: 8px;
            margin-top: 6px;
        }

        /* Batch Action Row */
        .batch-action-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
        }

        .batch-action-row .btn-table-action {
            width: 100%;
            justify-content: center;
            padding: 8px 12px;
        }

        /* Live Monitoring KBM Section */
        .monitoring-filter-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
        }

        .filter-pills-row {
            width: 100%;
            display: flex;
            gap: 4px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 2px;
        }

        .filter-pills-row::-webkit-scrollbar {
            display: none;
        }

        .pill-btn {
            flex-shrink: 0;
            white-space: nowrap;
            padding: 5px 10px;
            font-size: 11px;
        }

        .monitoring-search-box {
            width: 100% !important;
        }

        .monitoring-search-box input {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Weekly Chart */
        .weekly-chart-box {
            height: 140px;
            gap: 6px;
            padding-top: 10px;
        }

        .chart-bar-pillar {
            width: 26px;
        }

        .chart-bar-label {
            font-size: 10.5px;
        }

        .chart-bar-count {
            font-size: 9.5px;
        }

        /* Modals */
        .modal-backdrop-custom {
            padding: 12px;
        }

        .modal-dialog-custom {
            max-width: 100%;
            border-radius: 14px;
            max-height: 92vh;
        }

        .modal-header-custom {
            padding: 12px 16px;
        }

        .modal-header-custom h3 {
            font-size: 14px;
        }

        .modal-body-custom {
            padding: 14px 16px;
            gap: 10px;
        }

        .modal-footer-custom {
            padding: 10px 16px;
        }

        .modal-grid-2 {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }
    }

    @media (max-width: 480px) {
        .page-main-title {
            font-size: 18px;
        }

        .header-action-btns {
            flex-direction: column;
        }

        .header-action-btns .btn-table-action {
            width: 100%;
        }

        .stat-cards-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .quick-summary-strip {
            grid-template-columns: 1fr;
            gap: 6px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Page Header -->
    <div class="page-header-box">
        <div>
            <h1 class="page-main-title">Wakil Kurikulum</h1>
            <p class="page-sub-title">Pusat monitoring kurikulum, persetujuan izin guru, pengelolaan jadwal KBM, dan pemantauan pembelajaran sekolah.</p>
        </div>
    </div>

    <!-- 4 Primary Stat Cards Row (Clean White & Gray/Blue Accents) -->
    <div class="stat-cards-row">
        <!-- Card 1: Total Jadwal KBM -->
        <a href="{{ route('waka-kurikulum.jadwal') }}" class="stat-box-card" title="Kelola Jadwal Pelajaran">
            <div class="stat-icon-circle icon-circle-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Total Jadwal KBM</span>
                <span class="stat-number-text">{{ number_format($totalJadwal, 0, ',', '.') }}</span>
                <span class="stat-subtext">Jadwal KBM Terjadwal</span>
            </div>
        </a>

        <!-- Card 2: Guru Mengajar -->
        <a href="{{ route('waka-kurikulum.jadwal', ['view_mode' => 'matriks_guru']) }}" class="stat-box-card" title="Lihat Matriks Guru Pengajar">
            <div class="stat-icon-circle icon-circle-green">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Guru Mengajar</span>
                <span class="stat-number-text">{{ number_format($totalGuruPengajar, 0, ',', '.') }}</span>
                <span class="stat-subtext" style="color: #16a34a;">Tenaga Pendidik Aktif</span>
            </div>
        </a>

        <!-- Card 3: Rombel / Kelas Aktif -->
        <a href="{{ route('waka-kurikulum.jadwal') }}" class="stat-box-card" title="Lihat Pembagian Rombel & Jadwal Kelas">
            <div class="stat-icon-circle icon-circle-purple">
                <i class="fa-solid fa-school"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Rombel / Kelas</span>
                <span class="stat-number-text">{{ number_format($totalKelas, 0, ',', '.') }}</span>
                <span class="stat-subtext" style="color: #7c3aed;">Kelas Belajar Aktif</span>
            </div>
        </a>

        <!-- Card 4: Keterisian KBM Hari Ini -->
        <a href="{{ route('waka-kurikulum.rekap-jurnal', ['tanggal' => $todayDate]) }}" class="stat-box-card" title="Lihat Jurnal Mengajar Hari Ini">
            <div class="stat-icon-circle icon-circle-orange">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label-text">Keterisian KBM Hari Ini</span>
                <span class="stat-number-text">{{ $persenKbmHariIni }}%</span>
                <span class="stat-subtext" style="color: #ea580c;">{{ $jurnalHariIniCount }} dari {{ $jadwalHariIniCount }} Sesi Terisi</span>
            </div>
        </a>
    </div>

    <!-- Quick Summary Strip (Perizinan Guru & Pengganti) -->
    <div class="quick-summary-strip">
        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'pending']) }}" class="quick-pill-item">
            <div class="quick-pill-icon icon-circle-blue">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="quick-pill-label">Menunggu Persetujuan</div>
                <div class="quick-pill-val" style="color: {{ $totalPendingIzinWaka > 0 ? '#2563eb' : '#0f172a' }};">
                    {{ $totalPendingIzinWaka }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Pengajuan</span>
                </div>
            </div>
        </a>

        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi']) }}" class="quick-pill-item">
            <div class="quick-pill-icon icon-circle-gray">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div>
                <div class="quick-pill-label">Guru Izin Hari Ini</div>
                <div class="quick-pill-val">{{ $totalIzinHariIni }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Pendidik</span></div>
            </div>
        </a>

        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi']) }}" class="quick-pill-item">
            <div class="quick-pill-icon icon-circle-orange">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <div class="quick-pill-label">Perlu Guru Pengganti</div>
                <div class="quick-pill-val" style="color: {{ $totalPerluPengganti > 0 ? '#ea580c' : '#0f172a' }};">
                    {{ $totalPerluPengganti }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Belum Ada Pengganti</span>
                </div>
            </div>
        </a>

        <a href="{{ route('waka-kurikulum.persetujuan-izin', ['tab' => 'resmi']) }}" class="quick-pill-item">
            <div class="quick-pill-icon icon-circle-green">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <div class="quick-pill-label">Pengganti Ditugaskan</div>
                <div class="quick-pill-val" style="color: #16a34a;">
                    {{ $totalPenggantiAktif }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Aktif Hari Ini</span>
                </div>
            </div>
        </a>
    </div>

    <!-- ========================================================================= -->
    <!-- UNIFIED PERIZINAN GURU HUB (Persetujuan & Monitoring Terpadu)             -->
    <!-- ========================================================================= -->
    <div class="card-panel" id="section-hub-perizinan">
        <div class="panel-header">
            <div>
                <div class="panel-title">
                    <i class="fa-solid fa-clipboard-check" style="color: #2563eb;"></i>
                    <span>Persetujuan &amp; Monitoring Izin Guru Pengampu</span>
                </div>
                <p class="panel-subtitle">Verifikasi izin mengajar dewan guru serta pantau status penugasan guru pengganti dari Guru Piket.</p>
            </div>

            <div class="panel-header-actions" style="display: flex; align-items: center; gap: 8px;">
                <a href="{{ route('waka-kurikulum.persetujuan-izin') }}" class="btn-table-action btn-action-detail" style="padding: 6px 12px;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Halaman Penuh
                </a>
            </div>

            <!-- Tab Switcher -->
            <div class="tabs-nav">
                <button type="button" class="tab-btn active" id="btnTabPending" onclick="switchIzinTab('pending', this)">
                    <i class="fa-solid fa-clock"></i>
                    <span>Menunggu Persetujuan</span>
                    <span class="tab-badge tab-badge-blue">{{ $pendingIzinList->count() }}</span>
                </button>
                <button type="button" class="tab-btn" id="btnTabResmi" onclick="switchIzinTab('resmi', this)">
                    <i class="fa-solid fa-user-check"></i>
                    <span>Izin Resmi Disetujui</span>
                    <span class="tab-badge tab-badge-gray">{{ $guruIzinResmiList->count() }}</span>
                </button>
                <button type="button" class="tab-btn" id="btnTabHistory" onclick="switchIzinTab('history', this)">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Keputusan</span>
                    <span class="tab-badge tab-badge-gray">{{ $historyIzinList->count() }}</span>
                </button>
                <button type="button" class="tab-btn" id="btnTabAll" onclick="switchIzinTab('all', this)">
                    <i class="fa-solid fa-list"></i>
                    <span>Semua</span>
                </button>
            </div>
        </div>

        <!-- ─── TAB 1: Menunggu Persetujuan Waka (Pending) ─── -->
        <div id="tab-content-pending" class="tab-pane-content">
            @if($pendingIzinList->isEmpty())
                <div style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 10px;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h4 style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 0 0 2px 0;">Tidak Ada Pengajuan Izin Menunggu</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Seluruh permohonan izin guru telah diverifikasi dan diproses oleh Waka Kurikulum.</p>
                </div>
            @else
                {{-- ── DESKTOP TABLE (hidden on mobile) ── --}}
                <div class="wk-desktop-table">
                <form action="{{ route('waka-kurikulum.izin.batch-approve') }}" method="POST" id="formBatchApprove">
                    @csrf
                    <div class="batch-action-row" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; padding: 8px 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; color: #334155; cursor: pointer;">
                            <input type="checkbox" id="selectAllPending" onchange="toggleSelectAllPending(this)" style="width: 15px; height: 15px; accent-color: #2563eb;">
                            <span>Pilih Semua Pengajuan Pending</span>
                        </label>
                        <button type="submit" class="btn-table-action btn-action-approve" onclick="return confirm('Apakah Anda yakin ingin menyetujui seluruh pengajuan izin yang dipilih sekaligus?')">
                            <i class="fa-solid fa-check-double"></i> Setujui Terpilih Sekaligus
                        </button>
                    </div>

                    <div class="table-scroll-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 30px; text-align: center;">#</th>
                                    <th>Guru yang Meminta Izin</th>
                                    <th>Tanggal &amp; Kategori</th>
                                    <th>Alasan &amp; Titipan Materi</th>
                                    <th style="text-align: center;">Bukti Surat</th>
                                    <th style="text-align: center;">Status Berjenjang</th>
                                    <th style="text-align: center;">Aksi Persetujuan Waka</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingIzinList as $izin)
                                    <tr>
                                        <td style="text-align: center;">
                                            <input type="checkbox" name="selected_ids[]" value="{{ $izin->id_guru_izin }}" class="pending-item-check" style="width: 14px; height: 14px; accent-color: #2563eb;">
                                        </td>
                                        <td>
                                            <div class="teacher-profile-cell">
                                                <div class="avatar-circle">
                                                    {{ strtoupper(substr($izin->guru->nama_guru ?? 'G', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 800; color: #0f172a; font-size: 12.5px;">
                                                        {{ $izin->guru->nama_guru ?? 'Guru' }}
                                                    </div>
                                                    <div style="font-size: 11px; color: #64748b;">
                                                        NIP: {{ $izin->guru->nip ?? '-' }}
                                                    </div>
                                                    <div style="font-size: 11px; color: #2563eb; font-weight: 600;">
                                                        {{ $izin->guru->mapel->nama_mapel ?? 'Pengampu KBM' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 12px;">
                                                {{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                                @if($izin->tanggal_selesai && $izin->tanggal_selesai !== $izin->tanggal_mulai)
                                                    <span style="color: #64748b;">s/d</span> {{ Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                                @endif
                                            </div>
                                            <div style="margin-top: 3px;">
                                                @if(strtolower($izin->kategori_izin ?? '') === 'cuti')
                                                    <span class="badge-status badge-status-cuti">
                                                        <i class="fa-solid fa-calendar-minus"></i> Cuti ({{ $izin->durasi_formatted }})
                                                    </span>
                                                @else
                                                    <span class="badge-status badge-status-active">
                                                        <i class="fa-solid fa-clock"></i> Izin Biasa ({{ $izin->durasi_formatted }})
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #0f172a; max-width: 220px;">
                                                {{ $izin->alasan ?? '-' }}
                                            </div>
                                            @if($izin->materi_dititipkan || $izin->tugas_dititipkan)
                                                <div style="font-size: 11px; color: #16a34a; font-weight: 700; margin-top: 2px;">
                                                    <i class="fa-solid fa-book-open"></i> Ada Materi Titipan
                                                </div>
                                            @endif
                                            @if($izin->file_tugas_url)
                                                <a href="{{ $izin->file_tugas_url }}" target="_blank" style="font-size: 11px; color: #2563eb; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-top: 2px; text-decoration: none;">
                                                    <i class="fa-solid fa-paperclip"></i> Unduh File Tugas
                                                </a>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if($izin->foto_url)
                                                <div class="thumb-preview-box" onclick="openLightbox('{{ $izin->foto_url }}', 'Surat Izin: {{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Klik untuk memperbesar bukti surat" style="margin: 0 auto;">
                                                    <img src="{{ $izin->foto_url }}" alt="Surat">
                                                </div>
                                            @else
                                                <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Tanpa Lampiran</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; flex-direction: column; gap: 2px; align-items: center;">
                                                <span class="badge-status badge-status-pending">
                                                    Waka: Menunggu
                                                </span>
                                                <span class="badge-status {{ $izin->status_kepsek === 'approved' ? 'badge-status-approved' : 'badge-status-pending' }}">
                                                    Kepsek: {{ ucfirst($izin->status_kepsek ?? 'Menunggu') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-action-group" style="justify-content: center;">
                                                <button type="button" class="btn-table-action btn-action-approve" onclick="openApproveModal({{ $izin->id_guru_izin }}, '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Setujui Izin Ini">
                                                    <i class="fa-solid fa-check"></i> Setujui
                                                </button>
                                                <button type="button" class="btn-table-action btn-action-reject" onclick="openRejectModal({{ $izin->id_guru_izin }}, '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" title="Tolak Pengajuan Izin Ini">
                                                    <i class="fa-solid fa-xmark"></i> Tolak
                                                </button>
                                                <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})" title="Lihat Detail & Jadwal Mengajar Terdampak">
                                                    <i class="fa-solid fa-circle-info"></i> Detail
                                                </button>
                                                @if($izin->token_approval)
                                                    <a href="{{ route('approval.guru-izin.show', $izin->token_approval) }}" target="_blank" class="btn-table-action btn-action-link" title="Buka Link Approval Resmi Publik">
                                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Link
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                </div>{{-- end wk-desktop-table --}}

                {{-- ── MOBILE CARDS (visible on mobile only) ── --}}
                <div class="wk-mobile-cards">
                    <div class="batch-action-mobile">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; color: #334155; cursor: pointer;">
                            <input type="checkbox" id="selectAllPendingMobile" onchange="toggleSelectAllPending(this)" style="width: 15px; height: 15px; accent-color: #2563eb;">
                            <span>Pilih Semua Pengajuan Pending</span>
                        </label>
                        <button type="button" class="btn-table-action btn-action-approve" style="width: 100%; justify-content: center;"
                            onclick="document.getElementById('formBatchApprove').submit()">
                            <i class="fa-solid fa-check-double"></i> Setujui Terpilih Sekaligus
                        </button>
                    </div>

                    @foreach($pendingIzinList as $izin)
                    <div class="m-card-item">
                        <div class="m-card-header">
                            <div class="m-card-avatar">
                                {{ strtoupper(substr($izin->guru->nama_guru ?? 'G', 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="m-card-guru-name">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="m-card-guru-sub">NIP: {{ $izin->guru->nip ?? '-' }} &bull; {{ $izin->guru->mapel->nama_mapel ?? 'Pengampu KBM' }}</div>
                            </div>
                            <input type="checkbox" name="selected_ids_mobile[]" value="{{ $izin->id_guru_izin }}" class="pending-item-check" style="width: 15px; height: 15px; accent-color: #2563eb; flex-shrink: 0;">
                        </div>
                        <div class="m-card-body">
                            <div class="m-card-row">
                                <span class="m-card-label">Tanggal</span>
                                <span class="m-card-value">
                                    {{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                    @if($izin->tanggal_selesai && $izin->tanggal_selesai !== $izin->tanggal_mulai)
                                        s/d {{ Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Kategori</span>
                                <span class="m-card-value">
                                    @if(strtolower($izin->kategori_izin ?? '') === 'cuti')
                                        <span class="badge-status badge-status-cuti">Cuti ({{ $izin->durasi_formatted }})</span>
                                    @else
                                        <span class="badge-status badge-status-active">Izin Biasa ({{ $izin->durasi_formatted }})</span>
                                    @endif
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Alasan</span>
                                <span class="m-card-value">{{ $izin->alasan ?? '-' }}</span>
                            </div>
                            @if($izin->materi_dititipkan || $izin->tugas_dititipkan)
                            <div class="m-card-row">
                                <span class="m-card-label">Titipan</span>
                                <span class="m-card-value" style="color: #16a34a; font-weight: 700;">Ada Materi Titipan</span>
                            </div>
                            @endif
                            <div class="m-card-row">
                                <span class="m-card-label">Status</span>
                                <span class="m-card-value" style="display: flex; flex-wrap: wrap; gap: 4px;">
                                    <span class="badge-status badge-status-pending">Waka: Menunggu</span>
                                    <span class="badge-status {{ $izin->status_kepsek === 'approved' ? 'badge-status-approved' : 'badge-status-pending' }}">Kepsek: {{ ucfirst($izin->status_kepsek ?? 'Menunggu') }}</span>
                                </span>
                            </div>
                            @if($izin->foto_url)
                            <div class="m-card-row">
                                <span class="m-card-label">Bukti</span>
                                <span class="m-card-value">
                                    <div class="thumb-preview-box" onclick="openLightbox('{{ $izin->foto_url }}', 'Surat Izin: {{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')" style="display: inline-flex; margin: 0;">
                                        <img src="{{ $izin->foto_url }}" alt="Surat">
                                    </div>
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="m-card-actions {{ $izin->token_approval ? 'm-card-actions-2' : '' }}">
                            <button type="button" class="btn-table-action btn-action-approve" onclick="openApproveModal({{ $izin->id_guru_izin }}, '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')">
                                <i class="fa-solid fa-check"></i> Setujui
                            </button>
                            <button type="button" class="btn-table-action btn-action-reject" onclick="openRejectModal({{ $izin->id_guru_izin }}, '{{ addslashes($izin->guru->nama_guru ?? 'Guru') }}')">
                                <i class="fa-solid fa-xmark"></i> Tolak
                            </button>
                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </button>
                            @if($izin->token_approval)
                            <a href="{{ route('approval.guru-izin.show', $izin->token_approval) }}" target="_blank" class="btn-table-action btn-action-link">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Link
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>{{-- end wk-mobile-cards --}}
            @endif
        </div>

        <!-- ─── TAB 2: Daftar Resmi Guru Izin Tidak Hadir (Sinkron Guru Piket) ─── -->
        <div id="tab-content-resmi" class="tab-pane-content" style="display: none;">
            @if($guruIzinResmiList->isEmpty())
                <div style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 10px;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h4 style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 0 0 2px 0;">Tidak Ada Data Izin Disetujui</h4>
                    <p style="font-size: 12px; color: #64748b; margin: 0;">Seluruh guru hadir mengajar sesuai alokasi KBM sekolah.</p>
                </div>
            @else
                {{-- DESKTOP TABLE --}}
                <div class="wk-desktop-table">
                <div class="table-scroll-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 32px; text-align: center;">NO</th>
                                <th>GURU TIDAK HADIR</th>
                                <th>TANGGAL &amp; KATEGORI</th>
                                <th>ALASAN &amp; TITIPAN MATERI</th>
                                <th style="text-align: center;">STATUS PERSETUJUAN</th>
                                <th style="text-align: center;">PENUGASAN PENGGANTI (PIKET)</th>
                                <th style="text-align: center;">STATUS BERLAKU</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guruIzinResmiList as $idx => $item)
                                <tr>
                                    <td style="text-align: center; font-weight: 800; color: #64748b;">
                                        {{ $idx + 1 }}
                                    </td>
                                    <td>
                                        <div class="teacher-profile-cell">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($item->guru->nama_guru ?? 'G', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 800; color: #0f172a; font-size: 12.5px;">
                                                    {{ $item->guru->nama_guru ?? 'Guru' }}
                                                </div>
                                                <div style="font-size: 11px; color: #64748b;">
                                                    NIP: {{ $item->guru->nip ?? '-' }}
                                                </div>
                                                <div style="font-size: 11px; color: #2563eb; font-weight: 600;">
                                                    {{ $item->guru->mapel->nama_mapel ?? 'Mata Pelajaran' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 12px;">
                                            {{ Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                                            @if($item->tanggal_selesai && $item->tanggal_selesai !== $item->tanggal_mulai)
                                                <span style="color: #64748b;">s/d</span> {{ Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                                            @endif
                                        </div>
                                        <div style="margin-top: 3px;">
                                            @if(strtolower($item->kategori_izin ?? '') === 'cuti')
                                                <span class="badge-status badge-status-cuti">
                                                    <i class="fa-solid fa-umbrella-beach"></i> Cuti / Khusus
                                                </span>
                                            @else
                                                <span class="badge-status badge-status-active">
                                                    <i class="fa-solid fa-clock"></i> Izin Biasa
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; max-width: 220px;">
                                            {{ $item->alasan ?? '-' }}
                                        </div>
                                        @if($item->materi_dititipkan || $item->tugas_dititipkan)
                                            <div style="font-size: 11px; color: #16a34a; font-weight: 700; margin-top: 2px;">
                                                <i class="fa-solid fa-book-bookmark"></i> Ada Titipan Materi/Tugas
                                            </div>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; flex-direction: column; gap: 2px; align-items: center;">
                                            <span class="badge-status badge-status-approved">
                                                <i class="fa-solid fa-check"></i> Waka: Disetujui
                                            </span>
                                            <span class="badge-status badge-status-approved">
                                                <i class="fa-solid fa-check"></i> Kepsek: Disetujui
                                            </span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($item->has_penugasan)
                                            <span class="badge-status badge-status-approved" title="Guru Pengganti ditugaskan oleh Guru Piket">
                                                <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                            </span>
                                            <div style="font-size: 11px; font-weight: 700; color: #16a34a; margin-top: 2px;">
                                                {{ $item->nama_guru_pengganti ?? 'Guru Pengganti' }}
                                            </div>
                                        @else
                                            <span class="badge-status badge-status-pending" title="Belum ada penugasan guru pengganti oleh Guru Piket">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Belum Ditugaskan
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($item->status_masa_berlaku === 'aktif')
                                            <span class="badge-status badge-status-active">
                                                <i class="fa-solid fa-bolt"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge-status badge-status-expired">
                                                <i class="fa-solid fa-check-double"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $item->id_guru_izin }})" title="Lihat Rincian Izin & Jadwal">
                                            <i class="fa-solid fa-circle-info"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>{{-- end wk-desktop-table --}}

                {{-- MOBILE CARDS --}}
                <div class="wk-mobile-cards">
                    @foreach($guruIzinResmiList as $idx => $item)
                    <div class="m-card-item">
                        <div class="m-card-header">
                            <div class="m-card-avatar">
                                {{ strtoupper(substr($item->guru->nama_guru ?? 'G', 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="m-card-guru-name">{{ $item->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="m-card-guru-sub">NIP: {{ $item->guru->nip ?? '-' }} &bull; {{ $item->guru->mapel->nama_mapel ?? 'Mata Pelajaran' }}</div>
                            </div>
                        </div>
                        <div class="m-card-body">
                            <div class="m-card-row">
                                <span class="m-card-label">Tanggal</span>
                                <span class="m-card-value">
                                    {{ Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                                    @if($item->tanggal_selesai && $item->tanggal_selesai !== $item->tanggal_mulai)
                                        s/d {{ Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Kategori</span>
                                <span class="m-card-value">
                                    @if(strtolower($item->kategori_izin ?? '') === 'cuti')
                                        <span class="badge-status badge-status-cuti">Cuti / Khusus</span>
                                    @else
                                        <span class="badge-status badge-status-active">Izin Biasa</span>
                                    @endif
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Alasan</span>
                                <span class="m-card-value">{{ $item->alasan ?? '-' }}</span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Persetujuan</span>
                                <span class="m-card-value" style="display: flex; flex-wrap: wrap; gap: 4px;">
                                    <span class="badge-status badge-status-approved">Waka: Disetujui</span>
                                    <span class="badge-status badge-status-approved">Kepsek: Disetujui</span>
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Pengganti</span>
                                <span class="m-card-value">
                                    @if($item->has_penugasan)
                                        <span class="badge-status badge-status-approved">Sudah Ditugaskan</span>
                                        <div style="font-size: 11px; color: #16a34a; font-weight: 700; margin-top: 2px;">{{ $item->nama_guru_pengganti ?? 'Guru Pengganti' }}</div>
                                    @else
                                        <span class="badge-status badge-status-pending">Belum Ditugaskan</span>
                                    @endif
                                </span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Berlaku</span>
                                <span class="m-card-value">
                                    @if($item->status_masa_berlaku === 'aktif')
                                        <span class="badge-status badge-status-active">Aktif</span>
                                    @else
                                        <span class="badge-status badge-status-expired">Selesai</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="m-card-actions m-card-actions-1">
                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $item->id_guru_izin }})">
                                <i class="fa-solid fa-circle-info"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>{{-- end wk-mobile-cards --}}
            @endif
        </div>

        <!-- ─── TAB 3: Riwayat Keputusan Waka Kurikulum ─── -->
        <div id="tab-content-history" class="tab-pane-content" style="display: none;">
            @if($historyIzinList->isEmpty())
                <div style="text-align: center; padding: 28px; color: #94a3b8;">
                    <p style="font-weight: 700;">Belum ada riwayat persetujuan atau penolakan izin oleh Waka Kurikulum.</p>
                </div>
            @else
                {{-- DESKTOP TABLE --}}
                <div class="wk-desktop-table">
                <div class="table-scroll-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Guru Pengampu</th>
                                <th>Tanggal &amp; Kategori</th>
                                <th>Alasan</th>
                                <th>Keputusan Waka</th>
                                <th>Catatan Waka</th>
                                <th style="text-align: center;">Status Final</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyIzinList as $izin)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">{{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}</div>
                                        <div style="font-size: 11px; color: #64748b;">{{ $izin->durasi_formatted }}</div>
                                    </td>
                                    <td style="max-width: 200px;">{{ $izin->alasan ?? '-' }}</td>
                                    <td>
                                        @if($izin->status_waka === 'approved')
                                            <span class="badge-status badge-status-approved">
                                                <i class="fa-solid fa-circle-check"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="badge-status badge-status-rejected">
                                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td style="font-size: 11.5px; color: #475569; max-width: 200px;">
                                        {{ $izin->catatan_waka ?? '-' }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if($izin->status_final === 'approved')
                                            <span class="badge-status badge-status-approved">Disetujui Resmi</span>
                                        @elseif($izin->status_final === 'rejected')
                                            <span class="badge-status badge-status-rejected">Ditolak</span>
                                        @else
                                            <span class="badge-status badge-status-pending">Menunggu Final</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                            <i class="fa-solid fa-circle-info"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>{{-- end wk-desktop-table --}}

                {{-- MOBILE CARDS --}}
                <div class="wk-mobile-cards">
                    @foreach($historyIzinList as $izin)
                    <div class="m-card-item">
                        <div class="m-card-header">
                            <div class="m-card-avatar">
                                {{ strtoupper(substr($izin->guru->nama_guru ?? 'G', 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="m-card-guru-name">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="m-card-guru-sub">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                            </div>
                            @if($izin->status_waka === 'approved')
                                <span class="badge-status badge-status-approved" style="flex-shrink: 0;">Disetujui</span>
                            @else
                                <span class="badge-status badge-status-rejected" style="flex-shrink: 0;">Ditolak</span>
                            @endif
                        </div>
                        <div class="m-card-body">
                            <div class="m-card-row">
                                <span class="m-card-label">Tanggal</span>
                                <span class="m-card-value">{{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }} &bull; {{ $izin->durasi_formatted }}</span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Alasan</span>
                                <span class="m-card-value">{{ $izin->alasan ?? '-' }}</span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Catatan</span>
                                <span class="m-card-value">{{ $izin->catatan_waka ?? '-' }}</span>
                            </div>
                            <div class="m-card-row">
                                <span class="m-card-label">Status Final</span>
                                <span class="m-card-value">
                                    @if($izin->status_final === 'approved')
                                        <span class="badge-status badge-status-approved">Disetujui Resmi</span>
                                    @elseif($izin->status_final === 'rejected')
                                        <span class="badge-status badge-status-rejected">Ditolak</span>
                                    @else
                                        <span class="badge-status badge-status-pending">Menunggu Final</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="m-card-actions m-card-actions-1">
                            <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                <i class="fa-solid fa-circle-info"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>{{-- end wk-mobile-cards --}}
            @endif
        </div>

        <!-- ─── TAB 4: Semua Pengajuan Izin ─── -->
        <div id="tab-content-all" class="tab-pane-content" style="display: none;">
            {{-- DESKTOP TABLE --}}
            <div class="wk-desktop-table">
            <div class="table-scroll-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Guru Pengampu</th>
                            <th>Tanggal &amp; Kategori</th>
                            <th>Alasan</th>
                            <th>Status Waka</th>
                            <th>Status Kepsek</th>
                            <th>Status Final</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semuaIzinList as $izin)
                            <tr>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a;">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                                    <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                </td>
                                <td>
                                    <div>{{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $izin->durasi_formatted }}</div>
                                </td>
                                <td style="max-width: 180px;">{{ $izin->alasan ?? '-' }}</td>
                                <td>
                                    @if($izin->status_waka === 'approved')
                                        <span class="badge-status badge-status-approved">Disetujui</span>
                                    @elseif($izin->status_waka === 'rejected')
                                        <span class="badge-status badge-status-rejected">Ditolak</span>
                                    @else
                                        <span class="badge-status badge-status-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->status_kepsek === 'approved')
                                        <span class="badge-status badge-status-approved">Disetujui</span>
                                    @elseif($izin->status_kepsek === 'rejected')
                                        <span class="badge-status badge-status-rejected">Ditolak</span>
                                    @else
                                        <span class="badge-status badge-status-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->status_final === 'approved')
                                        <span class="badge-status badge-status-approved">Disetujui</span>
                                    @elseif($izin->status_final === 'rejected')
                                        <span class="badge-status badge-status-rejected">Ditolak</span>
                                    @else
                                        <span class="badge-status badge-status-pending">Pending</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>{{-- end wk-desktop-table --}}

            {{-- MOBILE CARDS --}}
            <div class="wk-mobile-cards">
                @foreach($semuaIzinList as $izin)
                <div class="m-card-item">
                    <div class="m-card-header">
                        <div class="m-card-avatar">
                            {{ strtoupper(substr($izin->guru->nama_guru ?? 'G', 0, 1)) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div class="m-card-guru-name">{{ $izin->guru->nama_guru ?? 'Guru' }}</div>
                            <div class="m-card-guru-sub">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="m-card-body">
                        <div class="m-card-row">
                            <span class="m-card-label">Tanggal</span>
                            <span class="m-card-value">{{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }} &bull; {{ $izin->durasi_formatted }}</span>
                        </div>
                        <div class="m-card-row">
                            <span class="m-card-label">Alasan</span>
                            <span class="m-card-value">{{ $izin->alasan ?? '-' }}</span>
                        </div>
                        <div class="m-card-row">
                            <span class="m-card-label">Status Waka</span>
                            <span class="m-card-value">
                                @if($izin->status_waka === 'approved')
                                    <span class="badge-status badge-status-approved">Disetujui</span>
                                @elseif($izin->status_waka === 'rejected')
                                    <span class="badge-status badge-status-rejected">Ditolak</span>
                                @else
                                    <span class="badge-status badge-status-pending">Pending</span>
                                @endif
                            </span>
                        </div>
                        <div class="m-card-row">
                            <span class="m-card-label">Kepsek</span>
                            <span class="m-card-value">
                                @if($izin->status_kepsek === 'approved')
                                    <span class="badge-status badge-status-approved">Disetujui</span>
                                @elseif($izin->status_kepsek === 'rejected')
                                    <span class="badge-status badge-status-rejected">Ditolak</span>
                                @else
                                    <span class="badge-status badge-status-pending">Pending</span>
                                @endif
                            </span>
                        </div>
                        <div class="m-card-row">
                            <span class="m-card-label">Status Final</span>
                            <span class="m-card-value">
                                @if($izin->status_final === 'approved')
                                    <span class="badge-status badge-status-approved">Disetujui</span>
                                @elseif($izin->status_final === 'rejected')
                                    <span class="badge-status badge-status-rejected">Ditolak</span>
                                @else
                                    <span class="badge-status badge-status-pending">Pending</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="m-card-actions m-card-actions-1">
                        <button type="button" class="btn-table-action btn-action-detail" onclick="openDetailModal({{ $izin->id_guru_izin }})">
                            <i class="fa-solid fa-circle-info"></i> Lihat Detail
                        </button>
                    </div>
                </div>
                @endforeach
            </div>{{-- end wk-mobile-cards --}}
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- GRID DUA KOLOM: LIVE MONITORING KBM & CAPAIAN MINGGUAN                   -->
    <!-- ========================================================================= -->
    <div class="dashboard-main-grid">
        <!-- Panel Kiri: Live Monitoring KBM Hari Ini -->
        <div class="card-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">
                        <i class="fa-solid fa-tower-broadcast" style="color: #2563eb;"></i>
                        <span>Monitoring KBM Hari Ini ({{ $hariIni }}, {{ Carbon\Carbon::parse($todayDate)->translatedFormat('d F Y') }})</span>
                    </div>
                    <p class="panel-subtitle">Pantau seluruh jam pembelajaran aktif, kehadiran guru, dan pengisian jurnal mengajar.</p>
                </div>
                <div class="panel-header-actions">
                    <a href="{{ route('waka-kurikulum.rekap-jurnal', ['tanggal' => $todayDate]) }}" class="btn-table-action btn-action-detail" style="padding: 6px 12px; font-size: 11.5px; text-decoration: none;">
                        <i class="fa-solid fa-clipboard-list"></i> Lihat Rekap Jurnal &rarr;
                    </a>
                </div>
            </div>

            <!-- Quick Filter Bar -->
            <div class="monitoring-filter-bar" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div class="filter-pills-row">
                    <button type="button" class="pill-btn active" onclick="filterKbmTable('all', this)">
                        Semua Sesi ({{ $countSemuaSesi ?? $jadwalHariIniList->count() }})
                    </button>
                    <button type="button" class="pill-btn" onclick="filterKbmTable('terisi', this)">
                        Terisi ({{ $countTerisiSesi ?? $jurnalHariIniCount }})
                    </button>
                    <button type="button" class="pill-btn" onclick="filterKbmTable('belum', this)">
                        Belum Mengisi ({{ $countBelumSesi ?? max(0, $jadwalHariIniCount - $jurnalHariIniCount) }})
                    </button>
                    <button type="button" class="pill-btn" onclick="filterKbmTable('izin', this)">
                        Guru Izin ({{ $countIzinSesi ?? count($guruIzinTodayIds) }})
                    </button>
                </div>

                <div class="monitoring-search-box" style="position: relative;">
                    <input type="text" id="searchKbmLive" oninput="searchKbmTable()" placeholder="Cari kelas / guru / mapel..." style="padding: 6px 10px 6px 28px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 11.5px; width: 185px; outline: none;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 9px; top: 9px; font-size: 11px; color: #94a3b8;"></i>
                </div>
            </div>

            @if($jadwalHariIniList->isEmpty())
                <div style="text-align: center; padding: 32px 16px; color: #94a3b8;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 34px; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <p style="font-weight: 700; color: #64748b; font-size: 12.5px;">Tidak ada jadwal KBM aktif pada hari {{ $hariIni }}.</p>
                </div>
            @else
                {{-- DESKTOP TABLE --}}
                <div class="wk-desktop-table">
                <div class="table-scroll-container" style="max-height: 480px; overflow-y: auto; overflow-x: auto;">
                    <table class="custom-table" id="kbmLiveTable">
                        <thead>
                            <tr>
                                <th style="width: 130px;">Jam Ke</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengampu</th>
                                <th>Ruangan</th>
                                <th style="text-align: center;">Status KBM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalHariIniList as $j)
                                @php
                                    $rowCategory = $j->is_terisi ? 'terisi' : ($j->is_guru_izin ? 'izin' : 'belum');
                                @endphp
                                <tr class="kbm-row" data-category="{{ $rowCategory }}">
                                    <td style="font-weight: 700; color: #475569; white-space: nowrap;">
                                        <div>
                                            {{ $j->jam_mulai_ke == $j->jam_selesai_ke ? "Jam ke-{$j->jam_mulai_ke}" : "Jam ke-{$j->jam_mulai_ke} - {$j->jam_selesai_ke}" }}
                                        </div>
                                        @if($j->waktu_range && $j->waktu_range !== '-')
                                            <div style="font-size: 10px; color: #64748b; font-weight: 600; margin-top: 1px;">
                                                <i class="fa-regular fa-clock" style="font-size: 9.5px;"></i> {{ $j->waktu_range }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="font-weight: 800; color: #1e293b;">
                                        {{ $j->kelas->nama_kelas ?? '-' }}
                                    </td>
                                    <td style="font-weight: 700; color: #2563eb;">
                                        {{ $j->mapel->nama_mapel ?? '-' }}
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a;">
                                            {{ $j->guru->nama_guru ?? '-' }}
                                        </div>
                                        @if($j->guru_pengganti_piket)
                                            <div style="font-size: 10.5px; color: #16a34a; font-weight: 700; margin-top: 1px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-user-shield"></i> Pengganti: {{ $j->guru_pengganti_piket }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="color: #64748b; font-size: 11px; font-weight: 600;">
                                        {{ $j->ruangan->nama_ruangan ?? 'Kelas Reguler' }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if($j->is_terisi)
                                            @if($j->jurnal_diisi_pengganti)
                                                <span class="badge-status badge-status-approved" title="{{ $j->jurnal_materi ? 'Materi: '.$j->jurnal_materi.' | ' : '' }}Jurnal diisi oleh Guru Pengganti: {{ $j->jurnal_nama_pengisi }}">
                                                    <i class="fa-solid fa-circle-check"></i> Terisi (Pengganti)
                                                </span>
                                            @else
                                                <span class="badge-status badge-status-approved" title="{{ $j->jurnal_materi ? 'Materi: '.$j->jurnal_materi : 'Jurnal Terisi' }}">
                                                    <i class="fa-solid fa-circle-check"></i> Terisi
                                                </span>
                                            @endif
                                        @elseif($j->is_guru_izin)
                                            @if($j->guru_pengganti_piket)
                                                <span class="badge-status badge-status-active" title="Guru izin - Guru Piket telah menugaskan guru pengganti: {{ $j->guru_pengganti_piket }}">
                                                    <i class="fa-solid fa-user-clock"></i> Izin (Ada Pengganti)
                                                </span>
                                            @else
                                                <span class="badge-status badge-status-rejected" title="Guru mengajukan izin resmi (Belum ada guru pengganti)">
                                                    <i class="fa-solid fa-user-clock"></i> Guru Izin
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge-status badge-status-pending">
                                                <i class="fa-solid fa-clock"></i> Belum Mengisi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="emptyKbmSearchRow" style="display: none;">
                                <td colspan="6" style="text-align: center; padding: 28px 16px; color: #94a3b8;">
                                    <i class="fa-solid fa-magnifying-glass" style="font-size: 24px; color: #cbd5e1; margin-bottom: 6px;"></i>
                                    <div style="font-weight: 700; color: #64748b; font-size: 12.5px;">Tidak ada sesi KBM yang cocok dengan filter atau pencarian.</div>
                                    <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Coba gunakan kata kunci lain atau pilih filter "Semua Sesi".</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>{{-- end wk-desktop-table --}}

                {{-- MOBILE CARDS --}}
                <div class="wk-mobile-cards">
                    @foreach($jadwalHariIniList as $j)
                        @php
                            $rowCategory = $j->is_terisi ? 'terisi' : ($j->is_guru_izin ? 'izin' : 'belum');
                        @endphp
                        <div class="m-kbm-card kbm-row" data-category="{{ $rowCategory }}"
                             data-search="{{ strtolower(($j->kelas->nama_kelas ?? '') . ' ' . ($j->mapel->nama_mapel ?? '') . ' ' . ($j->guru->nama_guru ?? '')) }}">
                            <div class="m-kbm-card-top">
                                <div class="m-kbm-jam">
                                    <div>
                                        {{ $j->jam_mulai_ke == $j->jam_selesai_ke ? "Jam ke-{$j->jam_mulai_ke}" : "Jam ke-{$j->jam_mulai_ke}-{$j->jam_selesai_ke}" }}
                                    </div>
                                    @if($j->waktu_range && $j->waktu_range !== '-')
                                        <div class="m-kbm-time">{{ $j->waktu_range }}</div>
                                    @endif
                                </div>
                                <div>
                                    @if($j->is_terisi)
                                        @if($j->jurnal_diisi_pengganti)
                                            <span class="badge-status badge-status-approved">Terisi (Pengganti)</span>
                                        @else
                                            <span class="badge-status badge-status-approved">Terisi</span>
                                        @endif
                                    @elseif($j->is_guru_izin)
                                        @if($j->guru_pengganti_piket)
                                            <span class="badge-status badge-status-active">Izin (Ada Pengganti)</span>
                                        @else
                                            <span class="badge-status badge-status-rejected">Guru Izin</span>
                                        @endif
                                    @else
                                        <span class="badge-status badge-status-pending">Belum Mengisi</span>
                                    @endif
                                </div>
                            </div>
                            <div class="m-kbm-details">
                                <div class="m-kbm-field">
                                    <span class="m-kbm-field-label">Kelas</span>
                                    <span class="m-kbm-field-value">{{ $j->kelas->nama_kelas ?? '-' }}</span>
                                </div>
                                <div class="m-kbm-field">
                                    <span class="m-kbm-field-label">Mapel</span>
                                    <span class="m-kbm-field-value" style="color: #2563eb; font-weight: 700;">{{ $j->mapel->nama_mapel ?? '-' }}</span>
                                </div>
                                <div class="m-kbm-field">
                                    <span class="m-kbm-field-label">Guru</span>
                                    <span class="m-kbm-field-value">
                                        {{ $j->guru->nama_guru ?? '-' }}
                                        @if($j->guru_pengganti_piket)
                                            <br><span style="font-size: 10px; color: #16a34a; font-weight: 700;">Pengganti: {{ $j->guru_pengganti_piket }}</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="m-kbm-field">
                                    <span class="m-kbm-field-label">Ruangan</span>
                                    <span class="m-kbm-field-value">{{ $j->ruangan->nama_ruangan ?? 'Kelas Reguler' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="emptyKbmSearchRowMobile" style="display: none; text-align: center; padding: 28px 16px; color: #94a3b8;">
                        <div style="font-weight: 700; color: #64748b; font-size: 12.5px;">Tidak ada sesi KBM yang cocok dengan filter atau pencarian.</div>
                        <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Coba gunakan kata kunci lain atau pilih filter "Semua Sesi".</div>
                    </div>
                </div>{{-- end wk-mobile-cards --}}
            @endif
        </div>

        <!-- Panel Kanan: Grafik KBM Mingguan & Feed Jurnal -->
        <div class="card-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">
                        <i class="fa-solid fa-chart-column" style="color: #2563eb;"></i>
                        <span>Capaian KBM Mingguan</span>
                    </div>
                    <p class="panel-subtitle">Rasio ketercapaian jurnal mengajar Senin - Jumat.</p>
                </div>
                <span style="font-size: 11px; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 12px;">Senin - Jumat</span>
            </div>

            <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <div class="weekly-chart-box">
                @php
                    $maxTarget = max(array_column($rekapMingguan, 'target')) ?: 1;
                @endphp
                @foreach($rekapMingguan as $item)
                    @php
                        $targetHeight = min(100, max(15, round(($item['target'] / $maxTarget) * 100)));
                        $realisasiHeight = $item['target'] > 0 
                            ? min(100, round(($item['realisasi'] / $item['target']) * 100))
                            : 0;
                    @endphp
                    <div class="chart-bar-col">
                        <span class="chart-bar-count">{{ $item['realisasi'] }}/{{ $item['target'] }}</span>
                        <div class="chart-bar-pillar {{ $item['is_today'] ? 'active-today' : ($item['realisasi'] > 0 ? 'has-realisasi' : '') }}" 
                             style="height: {{ $targetHeight }}%;"
                             title="{{ $item['full_label'] }}: {{ $item['realisasi'] }} jurnal terisi dari target {{ $item['target'] }} sesi">
                        </div>
                        <span class="chart-bar-label">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
            </div>

            <div style="display: flex; justify-content: space-around; font-size: 11px; color: #64748b; font-weight: 700; margin-top: 8px; padding-top: 8px; border-top: 1px solid #f1f5f9;">
                <span><i class="fa-solid fa-square" style="color: #2563eb;"></i> Hari Ini</span>
                <span><i class="fa-solid fa-square" style="color: #3b82f6;"></i> Terlaksana</span>
                <span><i class="fa-solid fa-square" style="color: #e2e8f0;"></i> Terjadwal</span>
            </div>

            <!-- Feed Jurnal Terisi Terbaru -->
            <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <span style="font-size: 12.5px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-clock-rotate-left" style="color: #2563eb;"></i> Jurnal Terisi Terbaru
                    </span>
                    <a href="{{ route('waka-kurikulum.rekap-jurnal') }}" style="font-size: 11.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                        Semua &rarr;
                    </a>
                </div>

                @if($jurnalTerbaruList->isEmpty())
                    <p style="font-size: 11.5px; color: #94a3b8; text-align: center; margin: 10px 0;">Belum ada entri jurnal yang tercatat.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($jurnalTerbaruList->take(4) as $item)
                            <div style="display: flex; align-items: flex-start; gap: 10px; padding: 7px 9px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0;">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                        <span style="font-size: 12px; font-weight: 800; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                            {{ $item->jadwal->guru->nama_guru ?? 'Guru' }}
                                        </span>
                                        <span style="font-size: 10.5px; font-weight: 600; color: #94a3b8;">
                                            {{ Carbon\Carbon::parse($item->tanggal)->format('d/m') }}
                                        </span>
                                    </div>
                                    <div style="font-size: 11px; color: #475569; margin-top: 1px;">
                                        {{ $item->jadwal->kelas->nama_kelas ?? '-' }} • {{ $item->jadwal->mapel->nama_mapel ?? '-' }}
                                    </div>
                                    <div style="font-size: 10.5px; color: #64748b; font-style: italic; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px;">
                                        {{ $item->materi ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODALS INTERAKTIF (Clean White / Blue / Gray Styling)                     -->
<!-- ========================================================================= -->

<!-- 1. Modal Setujui Izin -->
<div class="modal-backdrop-custom" id="modalApprove">
    <div class="modal-dialog-custom">
        <form action="" method="POST" id="formApproveAction">
            @csrf
            <div class="modal-header-custom" style="background: #f0fdf4; border-bottom-color: #bbf7d0;">
                <h3 style="color: #166534;">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i> Konfirmasi Persetujuan Izin Guru
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalApprove')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13px; color: #334155; margin: 0; line-height: 1.5;">
                    Anda akan menyetujui permohonan izin dari guru: <strong id="approveTeacherName" style="color: #0f172a;"></strong>.
                </p>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155;">
                        Catatan Persetujuan Waka Kurikulum (Opsional):
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Tuliskan catatan kurikulum, instruksi materi titipan, atau pesan pengganti..." style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 12.5px; outline: none; box-sizing: border-box;">Disetujui oleh Waka Kurikulum. Tugas / materi pembelajaran telah ditinjau.</textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-table-action btn-action-link" onclick="closeModal('modalApprove')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-approve" style="padding: 7px 16px;">
                    <i class="fa-solid fa-check"></i> Setujui Izin Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Tolak Izin -->
<div class="modal-backdrop-custom" id="modalReject">
    <div class="modal-dialog-custom">
        <form action="" method="POST" id="formRejectAction">
            @csrf
            <div class="modal-header-custom" style="background: #fef2f2; border-bottom-color: #fecaca;">
                <h3 style="color: #991b1b;">
                    <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i> Tolak Permohonan Izin Guru
                </h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('modalReject')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <p style="font-size: 13px; color: #334155; margin: 0; line-height: 1.5;">
                    Anda akan menolak pengajuan izin dari guru: <strong id="rejectTeacherName" style="color: #0f172a;"></strong>.
                </p>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-size: 12px; font-weight: 700; color: #b91c1c;">
                        Alasan Penolakan Izin <span style="color: #ef4444;">* (Wajib Diisi)</span>:
                    </label>
                    <textarea name="catatan" rows="3" required placeholder="Tuliskan alasan penolakan izin mengajar ini agar guru bersangkutan mendapatkan kejelasan..." style="width: 100%; padding: 8px 10px; border-radius: 8px; border: 1.5px solid #f87171; font-family: inherit; font-size: 12.5px; outline: none; box-sizing: border-box;"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-table-action btn-action-link" onclick="closeModal('modalReject')">Batal</button>
                <button type="submit" class="btn-table-action btn-action-reject" style="padding: 7px 16px;">
                    <i class="fa-solid fa-xmark"></i> Tolak Pengajuan Izin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Detail Izin & Jadwal KBM Terdampak -->
<div class="modal-backdrop-custom" id="modalDetailIzin">
    <div class="modal-dialog-custom modal-lg">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-file-lines" style="color: #2563eb;"></i> Rincian Pengajuan Izin &amp; Jadwal Terdampak</h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalDetailIzin')">&times;</button>
        </div>
        <div class="modal-body-custom" id="detailIzinBody">
            <div style="text-align: center; padding: 20px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 22px; color: #2563eb;"></i>
                <p style="margin-top: 6px; font-weight: 600; font-size: 12px;">Memuat data rincian izin &amp; jadwal kurikulum...</p>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-table-action btn-action-link" onclick="closeModal('modalDetailIzin')">Tutup</button>
        </div>
    </div>
</div>

<!-- 4. Modal Lightbox Foto Bukti Surat -->
<div class="modal-backdrop-custom" id="modalLightbox" style="background: rgba(15, 23, 42, 0.85);" onclick="closeModal('modalLightbox')">
    <div style="position: relative; max-width: 90vw; max-height: 90vh;" onclick="event.stopPropagation();">
        <button type="button" onclick="closeModal('modalLightbox')" style="position: absolute; top: -32px; right: 0; background: transparent; border: none; color: #ffffff; font-size: 24px; cursor: pointer;">&times;</button>
        <img id="lightboxImg" src="" alt="Bukti Surat Izin" style="max-width: 100%; max-height: 85vh; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.4);">
        <div id="lightboxCaption" style="color: #ffffff; text-align: center; margin-top: 8px; font-weight: 700; font-size: 12px;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tab Switching
    function switchIzinTab(tabName, btn) {
        document.querySelectorAll('.tab-pane-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        const targetPane = document.getElementById('tab-content-' + tabName);
        if (targetPane) {
            targetPane.style.display = 'block';
        }
        if (btn) {
            btn.classList.add('active');
        }
    }

    // Select All Checkbox for Pending Izin
    function toggleSelectAllPending(master) {
        const checkboxes = document.querySelectorAll('.pending-item-check');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    // Filter KBM Live Table by category & search query
    let currentKbmFilter = 'all';

    function filterKbmTable(category, btn) {
        currentKbmFilter = category;
        document.querySelectorAll('.filter-pills-row .pill-btn').forEach(el => el.classList.remove('active'));
        if (btn) btn.classList.add('active');
        applyKbmFilters();
    }

    // Live search for KBM Table
    function searchKbmTable() {
        applyKbmFilters();
    }

    function applyKbmFilters() {
        const input = document.getElementById('searchKbmLive');
        const query = input ? input.value.toLowerCase().trim() : '';
        const rows = document.querySelectorAll('.kbm-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowCategory = row.getAttribute('data-category');
            // For mobile cards use data-search attr, for table rows use innerText
            const rowText = (row.getAttribute('data-search') || row.innerText).toLowerCase();

            const matchCategory = (currentKbmFilter === 'all') || (rowCategory === currentKbmFilter);
            const matchSearch = !query || rowText.includes(query);

            if (matchCategory && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyRow = document.getElementById('emptyKbmSearchRow');
        if (emptyRow) {
            emptyRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
        const emptyRowMobile = document.getElementById('emptyKbmSearchRowMobile');
        if (emptyRowMobile) {
            emptyRowMobile.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
        }
    }

    // Modal Control Functions
    function openModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.add('show');
    }

    function closeModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.remove('show');
    }

    // Open Approve Modal
    function openApproveModal(id, teacherName) {
        document.getElementById('approveTeacherName').innerText = teacherName;
        document.getElementById('formApproveAction').action = '{{ url("/waka-kurikulum/izin") }}/' + id + '/approve';
        openModal('modalApprove');
    }

    // Open Reject Modal
    function openRejectModal(id, teacherName) {
        document.getElementById('rejectTeacherName').innerText = teacherName;
        document.getElementById('formRejectAction').action = '{{ url("/waka-kurikulum/izin") }}/' + id + '/reject';
        openModal('modalReject');
    }

    // Open Lightbox Image Modal
    function openLightbox(imgUrl, caption) {
        document.getElementById('lightboxImg').src = imgUrl;
        document.getElementById('lightboxCaption').innerText = caption || 'Bukti Surat Izin Guru';
        openModal('modalLightbox');
    }

    // Open Detail Modal via AJAX JSON
    function openDetailModal(id) {
        openModal('modalDetailIzin');
        const container = document.getElementById('detailIzinBody');
        container.innerHTML = `
            <div style="text-align: center; padding: 20px; color: #64748b;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 22px; color: #2563eb;"></i>
                <p style="margin-top: 6px; font-weight: 600; font-size: 12px;">Mengambil rincian pengajuan izin & jadwal...</p>
            </div>
        `;

        fetch('{{ url("/waka-kurikulum/izin") }}/' + id + '/detail-json')
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    container.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 16px; font-size: 12px;">Gagal memuat data detail izin.</div>`;
                    return;
                }

                const d = res.data;
                let schedulesHtml = '';
                if (d.jadwals_terdampak && d.jadwals_terdampak.length > 0) {
                    schedulesHtml = `
                        <div class="table-scroll-container">
                            <table style="width: 100%; border-collapse: collapse; font-size: 11.5px; margin-top: 6px;">
                                <thead>
                                    <tr style="background: #f1f5f9; text-align: left;">
                                        <th style="padding: 5px 8px;">Hari</th>
                                        <th style="padding: 5px 8px;">Kelas</th>
                                        <th style="padding: 5px 8px;">Mata Pelajaran</th>
                                        <th style="padding: 5px 8px;">Jam / Waktu</th>
                                        <th style="padding: 5px 8px;">Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${d.jadwals_terdampak.map(j => `
                                        <tr style="border-bottom: 1px solid #e2e8f0;">
                                            <td style="padding: 5px 8px; font-weight: 700;">${j.hari}</td>
                                            <td style="padding: 5px 8px; font-weight: 800; color: #1e293b;">${j.kelas}</td>
                                            <td style="padding: 5px 8px; color: #2563eb; font-weight: 700;">${j.mapel}</td>
                                            <td style="padding: 5px 8px;">${j.jam_ke} (${j.waktu})</td>
                                            <td style="padding: 5px 8px; color: #64748b;">${j.ruangan}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                } else {
                    schedulesHtml = `<p style="font-size: 11.5px; color: #94a3b8; margin: 3px 0;">Tidak ada jadwal mengajar tetap yang terdaftar.</p>`;
                }

                let substituteHtml = '';
                if (d.penugasan_pengganti && d.penugasan_pengganti.length > 0) {
                    substituteHtml = `
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px; margin-top: 8px;">
                            <div style="font-size: 11.5px; font-weight: 800; color: #166534; margin-bottom: 3px;">
                                <i class="fa-solid fa-user-shield"></i> Guru Pengganti Ditugaskan oleh Guru Piket:
                            </div>
                            ${d.penugasan_pengganti.map(p => `
                                <div style="font-size: 11.5px; color: #166534;">
                                    • Tanggal: <strong>${p.tanggal}</strong> | Pengganti: <strong>${p.guru_pengganti}</strong> (NIP: ${p.nip_pengganti})
                                </div>
                            `).join('')}
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div>
                            <div style="font-size: 10.5px; font-weight: 700; color: #64748b;">NAMA GURU PENGAMPU</div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-top: 1px;">${d.nama_guru}</div>
                            <div style="font-size: 11.5px; color: #475569;">NIP: ${d.nip}</div>
                            <div style="font-size: 11.5px; color: #2563eb; font-weight: 700; margin-top: 1px;">${d.mapel}</div>
                        </div>
                        <div>
                            <div style="font-size: 10.5px; font-weight: 700; color: #64748b;">WAKTU & KATEGORI IZIN</div>
                            <div style="font-size: 12.5px; font-weight: 800; color: #0f172a; margin-top: 1px;">${d.tanggal_mulai} s/d ${d.tanggal_selesai}</div>
                            <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">Durasi: ${d.durasi} • Kategori: ${d.kategori_izin}</div>
                            <div style="font-size: 11px; color: #334155; margin-top: 2px;">Diproses oleh Piket: <strong>${d.nama_guru_piket}</strong></div>
                        </div>
                    </div>

                    <div style="padding: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div style="font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Alasan Ketidakhadiran:</div>
                        <div style="font-size: 12.5px; color: #334155;">${d.alasan}</div>
                        ${d.keterangan_khusus && d.keterangan_khusus !== '-' ? `<div style="font-size: 11.5px; color: #64748b; margin-top: 3px; font-style: italic;">Keterangan: ${d.keterangan_khusus}</div>` : ''}
                    </div>

                    <div style="padding: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div style="font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Titipan Materi & Tugas KBM:</div>
                        <div style="font-size: 12px; color: #334155;">${d.materi_dititipkan}</div>
                        ${d.file_tugas_url ? `
                            <div style="margin-top: 6px;">
                                <a href="${d.file_tugas_url}" target="_blank" class="btn-table-action btn-action-detail">
                                    <i class="fa-solid fa-download"></i> Unduh File Tugas Dititipkan
                                </a>
                            </div>
                        ` : ''}
                    </div>

                    ${d.foto_surat_url ? `
                        <div style="padding: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px;">
                            <div style="font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 5px;">Lampiran Bukti Surat / Keterangan Dokter:</div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="${d.foto_surat_url}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1; cursor: pointer;" onclick="openLightbox('${d.foto_surat_url}', 'Surat Bukti Izin: ${d.nama_guru}')" title="Klik untuk perbesar">
                                <div>
                                    <button type="button" class="btn-table-action btn-action-detail" onclick="openLightbox('${d.foto_surat_url}', 'Surat Bukti Izin: ${d.nama_guru}')">
                                        <i class="fa-solid fa-expand"></i> Buka Foto Bukti Penuh
                                    </button>
                                </div>
                            </div>
                        </div>
                    ` : ''}

                    <div style="padding: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div style="font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Jadwal Mengajar yang Terdampak Selama Izin:</div>
                        ${schedulesHtml}
                    </div>

                    ${substituteHtml}

                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 4px; flex-wrap: wrap; gap: 8px;">
                        <div style="font-size: 11.5px; color: #64748b;">
                            Status Persetujuan Waka: <strong style="color: #0f172a;">${d.status_waka.toUpperCase()}</strong>
                        </div>
                        <a href="${d.approval_url}" target="_blank" class="btn-table-action btn-action-link">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Halaman Link Approval
                        </a>
                    </div>
                `;
            })
            .catch(err => {
                container.innerHTML = `<div style="color: #dc2626; text-align: center; padding: 16px; font-size: 12px;">Terjadi kesalahan saat memuat rincian izin.</div>`;
            });
    }
</script>
@endsection
