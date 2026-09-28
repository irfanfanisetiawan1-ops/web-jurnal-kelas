@extends('layouts.admin')

@section('title', 'Dashboard Tata Usaha — EDU JOURNAL')

@section('styles')
<style>
    /* Pagination Bar Styles Matching Design Mockup */
    .table-pagination-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
        background: #ffffff;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }

    .table-pagination-footer .pagination-info {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .pagination-nav-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pg-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        user-select: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .pg-btn:hover:not(.active):not(.disabled) {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .pg-btn.active {
        background: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
        box-shadow: 0 3px 8px rgba(30, 41, 59, 0.25);
    }

    .pg-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Top Header Bar */
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

    .header-top-nav-bar {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        margin-bottom: 20px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .search-box-top {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box-top input {
        width: 100%;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 10px 16px 10px 42px;
        border-radius: 14px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .search-box-top i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .header-right-badges {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ta-badge {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 9px 18px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .time-pill-badge {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-ekspor-rekap {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-ekspor-rekap:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-tambah-jadwal {
        background: #252b42;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(37, 43, 66, 0.25);
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-tambah-jadwal:hover {
        background: #1a1e2e;
    }

    /* 6 Stat Cards Grid */
    .stat-6-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 26px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .stat-6-grid > * {
        min-width: 0;
        max-width: 100%;
        box-sizing: border-box;
    }

    .stat-box-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
        min-width: 0;
        box-sizing: border-box;
    }

    .stat-box-card:hover {
        transform: translateY(-2px);
    }

    .stat-box-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-box-label {
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .stat-box-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .stat-box-num {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-box-sub {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .stat-trend-tag {
        font-size: 10.5px;
        font-weight: 700;
        color: #10b981;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    /* 2 Main Section Grids */
    .master-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 24px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .master-dashboard-grid > * {
        min-width: 0;
        max-width: 100%;
        box-sizing: border-box;
    }

    .card-panel-master {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 22px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        min-width: 0;
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    /* Jadwal Search Header Classes */
    .jadwal-search-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .jadwal-search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0;
    }

    .jadwal-search-input-box {
        position: relative;
        width: 210px;
    }

    .jadwal-search-input-box input {
        width: 100%;
    }

    .card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        min-width: 0;
        max-width: 100%;
    }

    .card-header-flex h2, .card-header-flex h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .card-header-flex p {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .link-lihat-semua {
        font-size: 12.5px;
        color: #3b5490;
        font-weight: 700;
        text-decoration: none;
    }

    .link-lihat-semua:hover {
        text-decoration: underline;
    }

    /* Table Schedule */
    .table-schedule-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-schedule-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-schedule-custom td {
        padding: 13px 14px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-schedule-custom .waktu-text {
        font-weight: 700;
        color: #1e293b;
    }

    .table-schedule-custom .waktu-text i,
    .table-schedule-custom .guru-text-wrapper i {
        display: none;
    }

    .table-schedule-custom .col-guru strong {
        color: #0f172a;
    }

    .class-badge-pill {
        background: #e2e8f0;
        color: #1e293b;
        font-weight: 800;
        font-size: 11.5px;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .status-badge-pill {
        font-size: 11px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
    }

    .status-selesai { background: #d1fae5; color: #065f46; }
    .status-berlangsung { background: #dbeafe; color: #1e40af; }
    .status-terjadwal { background: #f1f5f9; color: #475569; }

    /* Bar Chart Custom Modern */
    .chart-container-bar {
        height: 220px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        padding-top: 30px;
        padding-bottom: 12px;
        padding-left: 8px;
        padding-right: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .bar-col-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .bar-col-item:hover {
        transform: translateY(-3px);
    }

    .bar-col-val {
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 2px 8px;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }

    .bar-col-val.active {
        color: #1e1b4b;
        background: #e0e7ff;
        border-color: #a5b4fc;
    }

    .bar-track {
        width: 100%;
        max-width: 42px;
        height: 100%;
        background: #f1f5f9;
        border-radius: 12px 12px 6px 6px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        position: relative;
    }

    .bar-fill {
        width: 100%;
        background: linear-gradient(180deg, #4f46e5 0%, #312e81 100%);
        border-radius: 12px 12px 4px 4px;
        transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bar-fill.today-fill {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 0 12px rgba(37, 99, 235, 0.4);
    }

    .bar-col-item.is-today .bar-track {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    .bar-col-label-sub {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    .bar-col-label-sub .day-name {
        font-size: 12px;
        font-weight: 800;
        color: #1e293b;
    }

    .bar-col-label-sub .day-date {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
    }

    /* Tooltip Custom */
    .bar-col-item[data-tooltip]::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        margin-bottom: 8px;
        background: #0f172a;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 8px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
    }

    .bar-col-item[data-tooltip]:hover::before {
        opacity: 1;
        visibility: visible;
    }

    /* Perlu Tindakan Cards */
    .action-alert-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .action-alert-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .action-alert-item .a-title {
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
    }

    .action-alert-item .a-sub {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
        font-weight: 600;
    }

    /* Progress per Kelas */
    .progress-class-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .progress-class-item .p-info {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .progress-class-bg {
        width: 100%;
        height: 7px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-class-fill {
        height: 100%;
        background: #252b42;
        border-radius: 10px;
    }

    /* Activity Feed */
    .feed-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .feed-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .feed-time {
        font-size: 12.5px;
        font-weight: 800;
        color: #0f172a;
        min-width: 44px;
    }

    .feed-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .feed-info .f-name {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .feed-info .f-meta {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 1px;
    }

    /* Rekap Donut Widget */
    .rekap-donut-container {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .donut-box {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .donut-box svg {
        transform: rotate(-90deg);
        width: 110px;
        height: 110px;
    }

    .donut-center-lbl {
        position: absolute;
        text-align: center;
    }

    .donut-center-lbl .pct { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1; }
    .donut-center-lbl .sub { font-size: 9px; font-weight: 700; color: #64748b; margin-top: 2px; }

    .rekap-mini-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        flex: 1;
    }

    .rekap-mini-card-sm {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rekap-mini-card-sm .icon-sm {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .icon-clock { background: #e2e8f0; color: #334155; }
    .icon-check { background: #d1fae5; color: #10b981; }
    .icon-warn  { background: #fef3c7; color: #d97706; }

    .rekap-mini-card-sm .txt-lbl { font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase; }
    .rekap-mini-card-sm .txt-val { font-size: 16px; font-weight: 800; color: #0f172a; line-height: 1.1; }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        padding: 16px;
        box-sizing: border-box;
    }

    .modal-backdrop-custom.show {
        display: flex !important;
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 600px;
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        animation: dashboardModalZoomIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes dashboardModalZoomIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
    }

    .modal-header-custom h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.3;
        word-break: break-word;
    }

    .modal-close-custom {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f1f5f9;
        border: none;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.15s ease;
        flex-shrink: 0;
        padding: 0;
    }

    .modal-close-custom:hover {
        background: #fee2e2;
        color: #ef4444;
        transform: rotate(90deg);
    }

    @media (max-width: 1200px) {
        .stat-6-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .master-dashboard-grid { grid-template-columns: minmax(0, 1fr) !important; width: 100%; max-width: 100%; }
    }

    @media (max-width: 768px) {
        .dashboard-page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            margin-bottom: 18px;
            width: 100%;
            max-width: 100%;
        }

        .header-left h1 {
            font-size: 24px !important;
            line-height: 1.25;
        }

        .header-left p {
            font-size: 12px;
            line-height: 1.4;
            margin-top: 3px;
        }

        .header-actions-group {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .btn-ekspor-rekap, .btn-tambah-jadwal {
            flex: 1;
            min-width: 0;
            justify-content: center;
            padding: 9px 12px;
            font-size: 12.5px;
            border-radius: 10px;
            text-align: center;
            white-space: nowrap;
        }

        .stat-6-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px;
            margin-bottom: 18px;
            width: 100%;
            max-width: 100%;
        }

        .master-dashboard-grid {
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 16px;
            width: 100%;
            max-width: 100%;
        }

        .master-dashboard-grid > * {
            min-width: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        .card-panel-master {
            padding: 16px 14px;
            border-radius: 16px;
            margin-bottom: 16px;
            min-width: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .card-header-flex {
            margin-bottom: 14px;
            width: 100%;
            max-width: 100%;
        }

        .card-header-flex h2, .card-header-flex h3 {
            font-size: 15px;
        }

        .card-header-flex p {
            font-size: 11.5px;
        }

        /* Jadwal Hari Ini header & search */
        .jadwal-header-content {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            align-items: stretch !important;
        }

        .jadwal-search-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .jadwal-search-form {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .jadwal-search-input-box {
            position: relative !important;
            flex: 1 !important;
            min-width: 0 !important;
            width: 100% !important;
        }

        .jadwal-search-input-box input {
            width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
            height: 38px;
            font-size: 12.5px;
        }

        .btn-filter, .btn-reset {
            height: 38px !important;
            padding: 0 12px !important;
            font-size: 12px !important;
            flex-shrink: 0 !important;
        }

        .table-responsive-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: visible !important;
            box-sizing: border-box !important;
        }

        .table-schedule-custom {
            min-width: 0 !important;
            display: block !important;
            width: 100% !important;
            border-collapse: separate !important;
        }

        .table-schedule-custom thead {
            display: none !important;
        }

        .table-schedule-custom tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .table-schedule-custom tr.jadwal-row {
            display: grid !important;
            grid-template-columns: auto 1fr auto !important;
            align-items: center !important;
            row-gap: 8px !important;
            column-gap: 8px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 12px 14px !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-schedule-custom tr.jadwal-row.jadwal-hidden {
            display: none !important;
        }

        .table-schedule-custom tr.jadwal-row td {
            padding: 0 !important;
            border: none !important;
        }

        .table-schedule-custom tr.jadwal-row .col-waktu {
            grid-column: 1 !important;
            grid-row: 1 !important;
        }

        .table-schedule-custom tr.jadwal-row .col-waktu .waktu-text {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #3b5490 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            white-space: nowrap !important;
        }

        .table-schedule-custom tr.jadwal-row .col-waktu .waktu-text i {
            display: inline-block !important;
            font-size: 11px !important;
            color: #64748b !important;
        }

        .table-schedule-custom tr.jadwal-row .col-kelas {
            grid-column: 2 !important;
            grid-row: 1 !important;
            display: flex !important;
            align-items: center !important;
        }

        .table-schedule-custom tr.jadwal-row .col-status {
            grid-column: 3 !important;
            grid-row: 1 !important;
            display: flex !important;
            justify-content: flex-end !important;
        }

        .table-schedule-custom tr.jadwal-row .col-mapel {
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            border-top: 1px dashed #e2e8f0 !important;
            padding-top: 8px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-mapel .mapel-text {
            font-size: 14px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.35 !important;
            display: block !important;
            word-break: break-word !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru {
            grid-column: 1 / -1 !important;
            grid-row: 3 !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru .guru-text-wrapper {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 12.5px !important;
            color: #475569 !important;
            word-break: break-word !important;
            white-space: normal !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru .guru-text-wrapper i {
            display: inline-block !important;
            font-size: 12px !important;
            color: #94a3b8 !important;
            flex-shrink: 0 !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru strong {
            font-weight: 600 !important;
            color: #475569 !important;
        }

        .table-schedule-custom tbody tr:not(.jadwal-row) {
            display: block !important;
            width: 100% !important;
        }

        .table-schedule-custom tbody tr:not(.jadwal-row) td {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Rekap Donut Widget Stack */
        .rekap-donut-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 16px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .donut-box {
            margin: 0 auto !important;
            flex-shrink: 0 !important;
        }

        .rekap-mini-grid {
            width: 100% !important;
            max-width: 100% !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 8px !important;
            box-sizing: border-box !important;
        }

        .rekap-mini-card-sm {
            min-width: 0 !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Right column items */
        .action-alert-list {
            width: 100% !important;
            max-width: 100% !important;
        }

        .action-alert-item {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .progress-class-list {
            width: 100% !important;
            max-width: 100% !important;
        }

        .progress-class-item {
            width: 100% !important;
            max-width: 100% !important;
        }

        .feed-list {
            width: 100% !important;
            max-width: 100% !important;
        }

        .feed-item {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .feed-info {
            flex: 1 !important;
            min-width: 0 !important;
            max-width: 100% !important;
            overflow: hidden !important;
        }

        .feed-info .f-name, .feed-info .f-meta {
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }

        .table-pagination-footer {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
            padding: 12px 14px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .pagination-info {
            font-size: 12px;
            text-align: center;
        }

        .pagination-nav-buttons {
            justify-content: center;
            flex-wrap: wrap;
            gap: 4px;
        }

        .pg-btn {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
            padding: 0 8px;
        }
    }

    @media (max-width: 640px) {
        .stat-6-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px;
            margin-bottom: 18px;
        }

        .stat-box-card {
            padding: 14px 12px;
            border-radius: 14px;
        }

        .stat-box-label {
            font-size: 9.5px;
        }

        .stat-box-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
            border-radius: 8px;
        }

        .stat-box-num {
            font-size: 20px;
        }

        .stat-box-sub {
            font-size: 10px;
        }

        .stat-trend-tag {
            font-size: 9.5px;
            margin-top: 6px;
        }

        .chart-container-bar {
            height: 180px;
            gap: 4px;
            padding-top: 20px;
            padding-bottom: 8px;
            padding-left: 2px;
            padding-right: 2px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .bar-col-item {
            min-width: 0;
            flex: 1;
        }

        .bar-track {
            max-width: 28px;
            border-radius: 8px 8px 4px 4px;
            width: 100%;
        }

        .bar-col-val {
            font-size: 9.5px;
            padding: 1px 4px;
            border-radius: 6px;
            margin-bottom: 4px;
        }

        .bar-col-label-sub {
            margin-top: 6px;
        }

        .bar-col-label-sub .day-name {
            font-size: 10.5px;
        }

        .bar-col-label-sub .day-date {
            font-size: 8.5px;
        }

        .modal-box-custom {
            width: calc(100% - 24px);
            margin: 12px;
            padding: 16px 14px;
            border-radius: 16px;
            max-height: 85vh;
        }

        .feed-item {
            gap: 10px;
        }

        .feed-time {
            font-size: 11px;
            min-width: 36px;
        }

        .feed-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .feed-info {
            flex: 1;
            min-width: 0;
        }

        .feed-info .f-name {
            font-size: 12.5px;
            white-space: normal;
            word-break: break-word;
        }

        .feed-info .f-meta {
            font-size: 10.5px;
            white-space: normal;
            word-break: break-word;
        }
    }

    @media (max-width: 480px) {
        .header-left h1 {
            font-size: 25px !important;
        }

        .table-schedule-custom tr.jadwal-row {
            padding: 10px 12px !important;
            row-gap: 6px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-waktu .waktu-text {
            font-size: 11px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-mapel .mapel-text {
            font-size: 13.5px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru .guru-text-wrapper {
            font-size: 12px !important;
        }

        .card-panel-master {
            padding: 14px 10px !important;
            border-radius: 14px !important;
            margin-bottom: 14px !important;
        }

        .stat-box-card {
            padding: 12px 10px !important;
            border-radius: 14px !important;
        }

        .stat-box-num {
            font-size: 19px !important;
        }

        .stat-box-label {
            font-size: 9px !important;
        }

        .stat-box-sub {
            font-size: 9.5px !important;
        }

        .stat-trend-tag {
            font-size: 8.5px !important;
            gap: 3px !important;
        }

        .rekap-mini-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 6px;
        }

        .rekap-mini-card-sm {
            padding: 8px 4px;
            flex-direction: column;
            text-align: center;
            gap: 4px;
        }

        .rekap-mini-card-sm .icon-sm {
            width: 26px;
            height: 26px;
            font-size: 11px;
            margin: 0 auto;
        }

        .rekap-mini-card-sm .txt-lbl {
            font-size: 7.5px;
            line-height: 1.1;
        }

        .rekap-mini-card-sm .txt-val {
            font-size: 12.5px !important;
            word-break: break-word;
        }

        .rekap-mini-card-sm .txt-val span {
            display: inline-block;
            font-size: 9px !important;
        }

        .header-actions-group {
            width: 100% !important;
            display: flex !important;
            gap: 6px !important;
        }

        .btn-ekspor-rekap, .btn-tambah-jadwal {
            flex: 1 1 0 !important;
            min-width: 0 !important;
            font-size: 11px !important;
            padding: 8px 6px !important;
            gap: 4px !important;
            text-align: center !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .jadwal-search-form {
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .jadwal-search-input-box {
            flex: 1 1 100% !important;
            width: 100% !important;
        }

        .jadwal-search-form .btn-filter,
        .jadwal-search-form .btn-reset {
            flex: 1 1 0 !important;
            text-align: center !important;
            justify-content: center !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        .jadwal-search-row .link-lihat-semua {
            text-align: center !important;
            display: block !important;
            width: 100% !important;
            margin-top: 4px;
        }

        .modal-box-custom {
            padding: 16px 14px !important;
            border-radius: 16px !important;
            max-height: 88vh !important;
        }

        .modal-header-custom h3 {
            font-size: 15px !important;
        }

        #modalBelum .feed-item {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
        }

        #modalBelum .feed-item button {
            width: 100% !important;
            text-align: center !important;
            padding: 7px 10px !important;
        }
    }

    @media (max-width: 380px) {
        .header-left h1 {
            font-size: 23.5px !important;
        }

        .table-schedule-custom tr.jadwal-row {
            padding: 9px 10px !important;
            row-gap: 5px !important;
            column-gap: 5px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-waktu .waktu-text {
            font-size: 10px !important;
            gap: 3px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-kelas .class-badge-pill {
            font-size: 9px !important;
            padding: 2px 5px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-status .status-badge-pill {
            font-size: 9px !important;
            padding: 2px 6px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-mapel .mapel-text {
            font-size: 13px !important;
        }

        .table-schedule-custom tr.jadwal-row .col-guru .guru-text-wrapper {
            font-size: 11.5px !important;
        }

        .btn-ekspor-rekap, .btn-tambah-jadwal {
            font-size: 10px !important;
            padding: 7px 4px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Page Title & Main Header Actions -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Dashboard Tata Usaha</h1>
            <p>{{ $formattedDate }} &nbsp;•&nbsp; Ringkasan operasional sekolah hari ini</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('admin.export-csv') }}" class="btn-ekspor-rekap">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor Rekap</span>
            </a>

            <a href="{{ route('jadwal.index') }}" class="btn-tambah-jadwal">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <!-- 6 Stat Cards Grid -->
    <div class="stat-6-grid">
        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">PENGGUNA</span>
                <div class="stat-box-icon"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalPengguna > 0 ? $totalPengguna : 128 }}</div>
            <div class="stat-box-sub">Total Akun System</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-check"></i> Aktif & Terverifikasi</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">SISWA AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-user-graduate"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalSiswa > 0 ? $totalSiswa : 32 }}</div>
            <div class="stat-box-sub">Total Siswa</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> +2 bulan ini</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">GURU AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-user-tie"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalGuru > 0 ? $totalGuru : 128 }}</div>
            <div class="stat-box-sub">Total Guru</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-check"></i> {{ $totalGuru > 0 ? $totalGuru : 128 }} Guru Terdaftar</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">KELAS</span>
                <div class="stat-box-icon"><i class="fa-solid fa-school"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalKelas > 0 ? $totalKelas : 32 }}</div>
            <div class="stat-box-sub">Total Rombel Kelas</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-layer-group"></i> {{ $totalMapel > 0 ? $totalMapel : 19 }} Mapel</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">SLOT AKTIF</span>
                <div class="stat-box-icon"><i class="fa-solid fa-calendar-days"></i></div>
            </div>
            <div class="stat-box-num">{{ $totalJadwal > 0 ? $totalJadwal : 970 }}</div>
            <div class="stat-box-sub">Jadwal Mengajar</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> 6 hari efektif</div>
        </div>

        <div class="stat-box-card">
            <div class="stat-box-top">
                <span class="stat-box-label">KEPATUHAN</span>
                <div class="stat-box-icon"><i class="fa-solid fa-chart-pie"></i></div>
            </div>
            <div class="stat-box-num">{{ $persentasePenyelesaian ?? 84 }}%</div>
            <div class="stat-box-sub">Jurnal Teknis Hari Ini</div>
            <div class="stat-trend-tag"><i class="fa-solid fa-arrow-up-right-dots"></i> {{ $sudahMengisi ?? 142 }} dari {{ $totalJadwalSesi ?? 169 }} sesi</div>
        </div>
    </div>

    <!-- Master Dashboard 2 Column Layout -->
    <div class="master-dashboard-grid">

        <!-- Left Main Column -->
        <div>
                     <!-- Table Card: Jadwal Hari Ini -->
            <div class="card-panel-master">
                <div class="card-header-flex jadwal-header-content" style="flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between; margin-bottom:16px;">
                    <div>
                        <h2>Jadwal Hari Ini</h2>
                        <p>{{ $hariIndo }} &bull; Total {{ count($jadwalHariIni) }} sesi (25 per halaman)</p>
                    </div>

                    <div class="jadwal-search-row">
                        <!-- Form Filter & Cari Jadwal Hari Ini -->
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="jadwal-search-form">
                            <div class="jadwal-search-input-box">
                                <input type="text" name="search_jadwal" value="{{ $searchJadwal ?? '' }}" class="form-control" style="padding-left:34px; height:38px; font-size:13px; border-radius:10px; border:1px solid #cbd5e1; background:#f8fafc;" placeholder="Cari Kelas / Guru / Mapel...">
                                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            </div>
                            <button type="submit" class="btn-filter" style="height:38px; padding:0 16px;">Cari</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn-reset" style="height:38px; padding:0 16px;">Reset</a>
                        </form>
                        <a href="{{ route('jadwal.index') }}" class="link-lihat-semua" style="white-space:nowrap;">Lihat semua master</a>
                    </div>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="table-schedule-custom">
                        <thead>
                            <tr>
                                <th>WAKTU</th>
                                <th>KELAS</th>
                                <th>GURU</th>
                                <th>MAPEL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-jadwal-hari-ini">
                            @forelse($jadwalHariIni as $index => $item)
                                @php
                                    $wMulai   = $item->waktu_mulai_effective;
                                    $wSelesai = $item->waktu_selesai_effective;
                                    $nowTime  = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                                    $sudahDiisi = $item->isDiisiHariIni();
                                @endphp
                                <tr class="jadwal-row">
                                    <td class="col-waktu">
                                        <span class="waktu-text">
                                            <i class="fa-regular fa-clock"></i>
                                            @if($item->jamPelajaran)
                                                {{ $item->jamPelajaran->range_format }}
                                            @else
                                                {{ $item->waktu_range }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="col-kelas">
                                        <span class="class-badge-pill">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                    </td>
                                    <td class="col-guru">
                                        <div class="guru-text-wrapper">
                                            <i class="fa-solid fa-user-tie"></i>
                                            <strong>{{ $item->guru->nama_guru ?? '-' }}</strong>
                                        </div>
                                    </td>
                                    <td class="col-mapel">
                                        <span class="mapel-text">{{ $item->mapel->nama_mapel ?? '-' }}</span>
                                    </td>
                                    <td class="col-status">
                                        @if($sudahDiisi)
                                            <span class="status-badge-pill status-selesai">Selesai</span>
                                        @elseif($nowTime >= $wMulai && $nowTime <= $wSelesai)
                                            <span class="status-badge-pill status-berlangsung">Berlangsung</span>
                                        @elseif($nowTime > $wSelesai)
                                            <span class="status-badge-pill status-selesai">Selesai</span>
                                        @else
                                            <span class="status-badge-pill status-terjadwal">Terjadwal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada jadwal KBM untuk hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Navigasi Halaman (Pagination 25 Per Halaman) -->
                <div class="table-pagination-footer" id="pagination-container-jadwal">
                    <div class="pagination-info" id="pagination-text-info-jadwal">
                        Menampilkan 1 - 25 dari {{ count($jadwalHariIni) }} jadwal
                    </div>
                    <div class="pagination-nav-buttons" id="pagination-buttons-jadwal">
                        <!-- Tombol Pagination JS (< 1 2 3 >) -->
                    </div>
                </div>
            </div>

            <!-- Card: Grafik Jurnal 7 Hari Terakhir -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h2>Grafik Jurnal Mengajar</h2>
                        <p>Tren pengisian jurnal 7 hari terakhir</p>
                    </div>
                    <div class="ta-badge" style="font-size:12px; padding:6px 12px;">
                        <i class="fa-solid fa-chart-column" style="color:#4f46e5;"></i> 7 Hari Terakhir
                    </div>
                </div>

                <div class="chart-container-bar">
                    @foreach($grafik7Hari as $g)
                        @php
                            $maxCount = isset($maxGrafikCount) && $maxGrafikCount > 0 ? $maxGrafikCount : 1;
                            $calcPct = round(($g['count'] / $maxCount) * 100);
                            $fillHeight = $g['count'] > 0 ? max(8, $calcPct) : 0;
                        @endphp
                        <div class="bar-col-item {{ $g['is_today'] ? 'is-today' : '' }}" data-tooltip="{{ $g['full_date'] }}: {{ $g['count'] }} Jurnal Diisi">
                            <span class="bar-col-val {{ $g['count'] > 0 ? 'active' : '' }}">{{ $g['count'] }}</span>
                            <div class="bar-track">
                                <div class="bar-fill {{ $g['is_today'] ? 'today-fill' : '' }}" style="height: {{ $fillHeight }}%;"></div>
                            </div>
                            <div class="bar-col-label-sub">
                                <span class="day-name">{{ $g['day_name'] }}</span>
                                <span class="day-date">{{ $g['tanggal'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card: Rekap Jurnal Mengajar Hari Ini (Donut Widget) -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h2>Rekap Jurnal Mengajar Hari Ini</h2>
                        <p>{{ $rekapStatusText ?? 'Status pengisian sesi hari ini' }}</p>
                    </div>
                    @if(isset($isHariLibur) && $isHariLibur)
                        <span class="status-badge-pill status-terjadwal"><i class="fa-solid fa-mug-hot"></i> Hari Libur</span>
                    @elseif(($persentasePenyelesaian ?? 0) >= 100)
                        <span class="status-badge-pill status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai 100%</span>
                    @else
                        <span class="status-badge-pill status-berlangsung"><i class="fa-solid fa-arrows-rotate fa-spin"></i> Berlangsung</span>
                    @endif
                </div>

                <div class="rekap-donut-container">
                    <div class="donut-box">
                        <svg viewBox="0 0 36 36" style="transform: rotate(-90deg); width: 110px; height: 110px;">
                            <path stroke="#f1f5f9" stroke-width="3.8" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path stroke="{{ ($persentasePenyelesaian ?? 0) >= 100 ? '#10b981' : '#4f46e5' }}" stroke-width="3.8" stroke-dasharray="{{ $persentasePenyelesaian ?? 0 }}, 100" stroke-linecap="round" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" style="transition: stroke-dasharray 0.6s ease;"/>
                        </svg>
                        <div class="donut-center-lbl">
                            <div class="pct">{{ $persentasePenyelesaian ?? 0 }}%</div>
                            <div class="sub">Penyelesaian</div>
                        </div>
                    </div>

                    <div class="rekap-mini-grid">
                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-clock"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <div class="txt-lbl">TOTAL JADWAL</div>
                                <div class="txt-val">{{ $totalJadwalSesi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>

                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-check"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <div class="txt-lbl">SUDAH MENGISI</div>
                                <div class="txt-val">{{ $sudahMengisi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>

                        <div class="rekap-mini-card-sm">
                            <div class="icon-sm icon-warn"><i class="fa-solid fa-triangle-exclamation"></i></div>
                            <div>
                                <div class="txt-lbl">BELUM MENGISI</div>
                                <div class="txt-val">{{ $belumMengisi ?? 0 }} <span style="font-size:11px; font-weight:600; color:#64748b;">Sesi</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Sidebar Column -->
        <div>
            
            <!-- Card: Perlu Tindakan -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Perlu Tindakan</h3>
                </div>

                <div class="action-alert-list">
                    @foreach($perluTindakan as $actAlert)
                        <a href="{{ $actAlert['url'] ?? '#' }}" class="action-alert-item" style="text-decoration: none; display: block; transition: transform 0.15s ease;">
                            <div class="a-title">{{ $actAlert['title'] }}</div>
                            <div class="a-sub">{{ $actAlert['subtitle'] }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Card: Pengisian Jurnal per Kelas (Minggu Ini) -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <div>
                        <h3>Pengisian Jurnal per Kelas</h3>
                        <p>Minggu ini</p>
                    </div>
                </div>

                <div class="progress-class-list">
                    @foreach($kepatuhanPerKelas as $itemKls)
                        <div class="progress-class-item">
                            <div class="p-info">
                                <span>{{ $itemKls['nama_kelas'] }}</span>
                                <span>{{ $itemKls['persen'] }}%</span>
                            </div>
                            <div class="progress-class-bg">
                                <div class="progress-class-fill" style="width: {{ $itemKls['persen'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card: Aktivitas Real-time -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Aktivitas</h3>
                    <a href="#modalAktivitas" onclick="openDashboardModal('modalAktivitas'); return false;" class="link-lihat-semua">Lihat Semua</a>
                </div>

                <div class="feed-list">
                    @forelse($aktivitasTerbaru->take(5) as $act)
                        <div class="feed-item">
                            <div class="feed-time">{{ \Carbon\Carbon::parse($act->dicatat_pada ?? $act->created_at)->format('H:i') }}</div>
                            <div class="feed-avatar">{{ strtoupper(substr($act->jadwal->guru->nama_guru ?? 'G', 0, 1)) }}</div>
                            <div class="feed-info">
                                <div class="f-name">{{ $act->jadwal->guru->nama_guru ?? 'Guru Pengajar' }}</div>
                                <div class="f-meta">{{ $act->jadwal->kelas->nama_kelas ?? 'Kelas' }} - {{ $act->jadwal->mapel->nama_mapel ?? 'Mapel' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="feed-item">
                            <div class="feed-time">07:03</div>
                            <div class="feed-avatar">T</div>
                            <div class="feed-info">
                                <div class="f-name">Trisno Wibowo, S.Pd., M.M.</div>
                                <div class="f-meta">XI RPL 1 - Konsentrasi RPL</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">07:05</div>
                            <div class="feed-avatar">K</div>
                            <div class="feed-info">
                                <div class="f-name">Kurnila Putri Islamawati, S.Pd</div>
                                <div class="f-meta">X RPL 1 - Informatika</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">07:05</div>
                            <div class="feed-avatar">B</div>
                            <div class="feed-info">
                                <div class="f-name">Budi Santoso, S.Kom</div>
                                <div class="f-meta">XI DKV 1 - Bahasa Inggris</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card: Guru Belum Mengisi Hari Ini -->
            <div class="card-panel-master">
                <div class="card-header-flex">
                    <h3>Guru belum mengisi hari ini</h3>
                    <a href="#modalBelum" onclick="openDashboardModal('modalBelum'); return false;" class="link-lihat-semua">Lihat Semua</a>
                </div>

                <div class="feed-list">
                    @forelse($guruBelumMengisi->take(4) as $unsub)
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">{{ $unsub->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="f-meta">{{ $unsub->mapel->nama_mapel ?? 'Mata Pelajaran' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">Dewi Lestari, S.Pd</div>
                                <div class="f-meta">Bahasa Inggris</div>
                            </div>
                        </div>
                        <div class="feed-item">
                            <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                            <div class="feed-info">
                                <div class="f-name">Hendra Wijaya, S.Kom</div>
                                <div class="f-meta">Bahasa Jepang</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <!-- Modal Lihat Semua Aktivitas -->
    <div id="modalAktivitas" class="modal-backdrop-custom">
        <div class="modal-box-custom">
            <div class="modal-header-custom">
                <h3>Riwayat Aktivitas Pengisian Jurnal</h3>
                <button type="button" class="modal-close-custom" onclick="closeDashboardModal('modalAktivitas');" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div style="overflow-y: auto; flex:1;">
                <div class="feed-list">
                    @foreach($aktivitasTerbaru as $act)
                        <div class="feed-item" style="padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                            <div class="feed-time">{{ \Carbon\Carbon::parse($act->dicatat_pada ?? $act->created_at)->format('H:i') }}</div>
                            <div class="feed-avatar">{{ strtoupper(substr($act->jadwal->guru->nama_guru ?? 'G', 0, 1)) }}</div>
                            <div class="feed-info">
                                <div class="f-name">{{ $act->jadwal->guru->nama_guru ?? 'Guru' }}</div>
                                <div class="f-meta">{{ $act->jadwal->kelas->nama_kelas ?? 'Kelas' }} - {{ $act->jadwal->mapel->nama_mapel ?? 'Mapel' }} | {{ $act->materi }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat Semua Guru Belum Mengisi -->
    <div id="modalBelum" class="modal-backdrop-custom">
        <div class="modal-box-custom">
            <div class="modal-header-custom">
                <h3>Daftar Guru Belum Mengisi Jurnal Hari Ini</h3>
                <button type="button" class="modal-close-custom" onclick="closeDashboardModal('modalBelum');" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div style="overflow-y: auto; flex:1;">
                <div class="feed-list">
                    @foreach($guruBelumMengisi as $unsub)
                        <div class="feed-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; justify-content: space-between; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
                                <div class="feed-avatar" style="background:#f1f5f9; color:#64748b;"><i class="fa-solid fa-user"></i></div>
                                <div class="feed-info" style="min-width: 0; flex: 1;">
                                    <div class="f-name" style="white-space: normal; word-break: break-word;">{{ $unsub->guru->nama_guru ?? 'Guru' }}</div>
                                    <div class="f-meta" style="white-space: normal; word-break: break-word;">{{ $unsub->kelas->nama_kelas ?? 'Kelas' }} - {{ $unsub->mapel->nama_mapel ?? 'Mapel' }}</div>
                                </div>
                            </div>
                            <button onclick="alert('Pemberitahuan pengingat berhasil dikirimkan ke {{ $unsub->guru->nama_guru ?? 'guru' }}!');" style="background:#fef3c7; color:#b45309; border:none; padding:6px 12px; border-radius:8px; font-weight:800; font-size:12px; cursor:pointer; flex-shrink: 0; white-space: nowrap;">
                                <i class="fa-solid fa-bell"></i> Ingatkan
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openDashboardModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDashboardModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-backdrop-custom').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDashboardModal(this.id);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-backdrop-custom.show, .modal-backdrop-custom[style*="display: flex"]').forEach(modal => {
                    closeDashboardModal(modal.id);
                });
            }
        });
    });

    (function() {
        const itemsPerPage = 25;
        let currentPage = 1;

        function initJadwalPagination() {
            const tbody = document.getElementById('tbody-jadwal-hari-ini');
            if (!tbody) return;

            const rows = Array.from(tbody.querySelectorAll('tr.jadwal-row'));
            const totalItems = rows.length;

            const container = document.getElementById('pagination-container-jadwal');
            if (totalItems === 0) {
                if (container) container.style.display = 'none';
                return;
            }

            const totalPages = Math.ceil(totalItems / itemsPerPage);

            function renderPage(page) {
                currentPage = page;
                const startIdx = (page - 1) * itemsPerPage;
                const endIdx = startIdx + itemsPerPage;

                rows.forEach((row, index) => {
                    if (index >= startIdx && index < endIdx) {
                        row.style.display = '';
                        row.classList.remove('jadwal-hidden');
                    } else {
                        row.style.display = 'none';
                        row.classList.add('jadwal-hidden');
                    }
                });

                const currentStart = startIdx + 1;
                const currentEnd = Math.min(endIdx, totalItems);
                const infoEl = document.getElementById('pagination-text-info-jadwal');
                if (infoEl) {
                    infoEl.textContent = `Menampilkan ${currentStart} - ${currentEnd} dari ${totalItems} jadwal`;
                }

                renderButtons(totalPages);
            }

            function renderButtons(totalPages) {
                const buttonsContainer = document.getElementById('pagination-buttons-jadwal');
                if (!buttonsContainer) return;

                if (totalPages <= 1) {
                    buttonsContainer.innerHTML = '';
                    return;
                }

                let html = '';

                // Prev Button
                const prevDisabled = currentPage === 1 ? 'disabled' : '';
                html += `<button type="button" class="pg-btn ${prevDisabled}" data-page="${currentPage - 1}" ${prevDisabled ? 'disabled' : ''}><i class="fa-solid fa-chevron-left"></i></button>`;

                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (totalPages > 7) {
                        if (i !== 1 && i !== totalPages && Math.abs(i - currentPage) > 2) {
                            if (i === 2 && currentPage > 4) {
                                html += `<span style="padding: 0 4px; color: #94a3b8;">...</span>`;
                            } else if (i === totalPages - 1 && currentPage < totalPages - 3) {
                                html += `<span style="padding: 0 4px; color: #94a3b8;">...</span>`;
                            }
                            continue;
                        }
                    }

                    const activeClass = i === currentPage ? 'active' : '';
                    html += `<button type="button" class="pg-btn ${activeClass}" data-page="${i}">${i}</button>`;
                }

                // Next Button
                const nextDisabled = currentPage === totalPages ? 'disabled' : '';
                html += `<button type="button" class="pg-btn ${nextDisabled}" data-page="${currentPage + 1}" ${nextDisabled ? 'disabled' : ''}><i class="fa-solid fa-chevron-right"></i></button>`;

                buttonsContainer.innerHTML = html;

                buttonsContainer.querySelectorAll('.pg-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const targetPage = parseInt(this.getAttribute('data-page'));
                        if (targetPage && targetPage >= 1 && targetPage <= totalPages && targetPage !== currentPage) {
                            renderPage(targetPage);
                        }
                    });
                });
            }

            renderPage(1);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initJadwalPagination);
        } else {
            initJadwalPagination();
        }
    })();
</script>
@endsection
