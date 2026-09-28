@extends('layouts.guru')

@section('title', 'Rekap Kehadiran Guru & Siswa — Guru Piket')
@section('header_title', 'Rekap Kehadiran')

@section('styles')
<style>
    :root {
        --color-navy: #2b3957;
        --color-navy-dark: #1e293b;
        --color-blue: #2563eb;
        --color-blue-light: #eff6ff;
        --color-bg-light: #f8fafc;
        --color-border: #e2e8f0;
        --color-text-main: #0f172a;
        --color-text-muted: #64748b;
    }

    .rekap-kehadiran-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding-bottom: 30px;
    }

    /* Page Header */
    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .page-title-group h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
        letter-spacing: -0.02em;
    }

    .page-title-group p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .header-actions-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action-outline {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-action-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .btn-action-solid {
        background: #2b3957;
        border: 1px solid #2b3957;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(43, 57, 87, 0.2);
    }

    .btn-action-solid:hover {
        background: #1e293b;
        border-color: #1e293b;
        transform: translateY(-1px);
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
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

    .stat-icon-green  { background: #dcfce7; color: #16a34a; }
    .stat-icon-orange { background: #fef3c7; color: #d97706; }
    .stat-icon-red    { background: #fee2e2; color: #dc2626; }
    .stat-icon-blue   { background: #dbeafe; color: #2563eb; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin: 2px 0;
    }

    .stat-subtext {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* Tab Switcher */
    .tab-nav-container {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #e2e8f0;
        padding: 5px;
        border-radius: 14px;
        width: fit-content;
    }

    .tab-btn {
        background: transparent;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn.active {
        background: #ffffff;
        color: #2b3957;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Filter Bar Container */
    .filter-panel-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 22px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .filter-form-grid {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-input-styled {
        padding: 9px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-input-styled:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-submit {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 9px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-filter-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
    }

    .btn-reset-light {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-reset-light:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .table-panel-title i {
        color: #2563eb;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-kehadiran-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    .custom-kehadiran-table th {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 800;
        padding: 12px 14px;
        text-align: left;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-kehadiran-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; text-align: center; }
    .custom-kehadiran-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; }

    .custom-kehadiran-table td {
        padding: 13px 14px;
        color: #334155;
        font-weight: 600;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-kehadiran-table tr:hover td {
        background: #f8fafc;
    }

    /* Badges */
    .badge-status-hadir {
        background: #dcfce7;
        color: #15803d;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-status-tidak-hadir {
        background: #fee2e2;
        color: #dc2626;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-status-izin {
        background: #fef3c7;
        color: #b45309;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-status-digantikan {
        background: #dbeafe;
        color: #1d4ed8;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-detail {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-action-detail:hover {
        background: #2b3957;
        color: #ffffff;
        border-color: #2b3957;
        transform: translateY(-1px);
    }

    /* Custom Pagination Styling */
    .custom-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .page-nav-btn, .page-num-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .page-nav-btn:hover, .page-num-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .page-num-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .page-nav-btn.disabled {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #e2e8f0;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .page-num-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 38px;
        color: #94a3b8;
        font-weight: 700;
        font-size: 14px;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 600px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-styled {
        padding: 18px 24px;
        background: #2b3957;
        color: #ffffff;
        border-radius: 20px 20px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body-styled {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .detail-row-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .detail-row-label {
        font-weight: 700;
        color: #64748b;
        width: 38%;
    }

    .detail-row-val {
        font-weight: 700;
        color: #0f172a;
        width: 62%;
        text-align: right;
    }

    /* Siswa Widgets Grid */
    .siswa-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .siswa-stat-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* Force constraint on any stray SVG icons in page */
    .rekap-kehadiran-container svg {
        max-width: 24px !important;
        max-height: 24px !important;
    }

    .filter-actions-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Desktop and Mobile display toggles */
    .desktop-table-container {
        display: block;
        width: 100%;
        overflow-x: auto;
    }

    .mobile-card-list {
        display: none;
    }

    .mobile-rekap-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .mobile-card-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
        gap: 8px;
        flex-wrap: wrap;
    }

    .mobile-card-body-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .mobile-card-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 8px;
        border-top: 1px dashed #e2e8f0;
        gap: 8px;
    }

    .mobile-item-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }

    .mobile-item-value {
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
    }

    /* Base Subpanel Actions on Desktop */
    .subpanel-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .subpanel-mini-search-form {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .subpanel-mini-search-form .filter-input-styled {
        padding: 6px 12px;
        font-size: 12px;
        width: 170px;
    }

    .subpanel-mini-search-form .btn-filter-submit,
    .subpanel-mini-search-form .btn-reset-light {
        padding: 6px 12px;
        font-size: 12px;
    }

    .subpanel-manage-btn {
        padding: 6px 12px;
        font-size: 11.5px;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .siswa-grid-3 { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .rekap-kehadiran-container {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            gap: 16px;
        }

        .page-header-container {
            padding: 16px 18px;
            border-radius: 16px;
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
        }

        .page-title-group h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
            margin-bottom: 6px !important;
        }

        .page-title-group p {
            font-size: 12.5px !important;
            line-height: 1.4 !important;
            flex-wrap: wrap;
        }

        .header-actions-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .header-actions-group .btn-action-outline,
        .header-actions-group .btn-action-solid {
            width: 100% !important;
            height: 42px !important;
            justify-content: center !important;
            font-size: 13px !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        .stat-grid-4 {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card {
            padding: 14px 16px;
            gap: 12px;
            border-radius: 14px;
        }

        .stat-icon-wrapper {
            width: 44px;
            height: 44px;
            font-size: 18px;
            border-radius: 12px;
        }

        .stat-val {
            font-size: 20px;
        }

        .stat-label {
            font-size: 11px;
        }

        .stat-subtext {
            font-size: 10.5px;
        }

        .tab-nav-container {
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            padding: 4px !important;
            border-radius: 12px !important;
            box-sizing: border-box !important;
        }

        .tab-btn {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 10px 6px !important;
            font-size: 12px !important;
            white-space: normal !important;
            line-height: 1.25 !important;
            gap: 6px !important;
        }

        .filter-panel-card {
            padding: 14px 16px;
            border-radius: 16px;
        }

        .filter-form-grid {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            width: 100%;
        }

        .filter-form-grid > div {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            flex: none !important;
        }

        .filter-form-grid .filter-input-styled {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            height: 42px !important;
            font-size: 13px !important;
        }

        .filter-actions-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .filter-actions-group .btn-filter-submit,
        .filter-actions-group .btn-reset-light {
            width: 100% !important;
            height: 42px !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            font-size: 13px !important;
            padding: 0 !important;
        }

        .main-table-panel {
            padding: 16px;
            border-radius: 16px;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .table-panel-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 14px;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-panel-title {
            font-size: 15px;
            flex-wrap: wrap;
        }

        /* Toggle desktop table off and show mobile cards */
        .desktop-table-container {
            display: none !important;
        }

        .mobile-card-list {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        .siswa-grid-3 {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .siswa-stat-box {
            padding: 14px 16px;
            border-radius: 14px;
        }

        /* Tab 2 Sub-panel Header Action Controls */
        .subpanel-header-actions {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .subpanel-mini-search-form {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 6px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .subpanel-mini-search-form .filter-input-styled {
            flex: 1 1 auto !important;
            width: 0 !important;
            min-width: 0 !important;
            max-width: none !important;
            height: 40px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
            border-radius: 12px !important;
            padding: 8px 14px !important;
        }

        .subpanel-mini-search-form .btn-filter-submit,
        .subpanel-mini-search-form .btn-reset-light {
            flex: 0 0 auto !important;
            width: 44px !important;
            min-width: 44px !important;
            max-width: 44px !important;
            height: 40px !important;
            padding: 0 !important;
            font-size: 14px !important;
            box-sizing: border-box !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 12px !important;
        }

        .subpanel-manage-btn {
            width: 100% !important;
            height: 40px !important;
            justify-content: center !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
            border-radius: 12px !important;
        }

        /* Modal Mobile */
        .modal-overlay {
            padding: 12px;
            z-index: 99999 !important;
        }

        .modal-card {
            max-width: 100%;
            border-radius: 16px;
            max-height: 90vh;
        }

        .modal-header-styled {
            padding: 14px 18px;
            border-radius: 16px 16px 0 0;
        }

        .modal-body-styled {
            padding: 16px;
            gap: 10px;
        }

        .detail-row-item {
            font-size: 12.5px;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 26px !important;
        }

        .stat-grid-4 {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .stat-card {
            padding: 12px 10px;
            gap: 8px;
            flex-direction: column;
            align-items: flex-start;
        }

        .stat-icon-wrapper {
            width: 36px;
            height: 36px;
            font-size: 15px;
            border-radius: 10px;
        }

        .stat-val {
            font-size: 18px;
        }

        .stat-label {
            font-size: 10px;
        }

        .stat-subtext {
            font-size: 9.5px;
        }

        .header-actions-group {
            grid-template-columns: 1fr !important;
        }

        .filter-actions-group {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('content')

@php
    $cDate = \Carbon\Carbon::parse($tanggalFilter);
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $dateTitleFormatted = $hariFilter . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
@endphp

<div class="rekap-kehadiran-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Rekap Kehadiran Guru & Siswa</h1>
            <p><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> {{ $dateTitleFormatted }} &nbsp;•&nbsp; Laporan rekapitulasi presensi, ketidakhadiran, guru pengganti, dan rekap siswa</p>
        </div>

        <div class="header-actions-group">
            <a href="{{ route('piket.rekap-kehadiran.export', request()->query()) }}" class="btn-action-outline">
                <i class="fa-solid fa-file-csv" style="color: #16a34a;"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('piket.rekap-kehadiran.print', request()->query()) }}" target="_blank" class="btn-action-solid">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekapitulasi</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards Grid (4 Cards 100% Real Database) -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Hadir</span>
                <span class="stat-val">{{ $stats['hadir'] }} Sesi</span>
                <span class="stat-subtext">Guru aktif mengajar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Izin / Dinas</span>
                <span class="stat-val">{{ $stats['izin'] }} Sesi</span>
                <span class="stat-subtext">Izin resmi disetujui</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Tidak Hadir / Sakit</span>
                <span class="stat-val">{{ $stats['tidakHadir'] }} Sesi</span>
                <span class="stat-subtext">Sakit / tanpa keterangan</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-arrows-rotate"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Digantikan</span>
                <span class="stat-val">{{ $stats['digantikan'] }} Sesi</span>
                <span class="stat-subtext">Diisi guru pengganti</span>
            </div>
        </div>
    </div>

    <!-- Tab Switcher -->
    <div class="tab-nav-container">
        <button type="button" class="tab-btn active" id="tabBtnGuru" onclick="switchRekapTab('guru')">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Rekap Kehadiran Guru ({{ $kehadiranList->total() }})</span>
        </button>
        <button type="button" class="tab-btn" id="tabBtnSiswa" onclick="switchRekapTab('siswa')">
            <i class="fa-solid fa-users"></i>
            <span>Rekap Ketidakhadiran Siswa ({{ $siswaStats['telat'] + $siswaStats['dispen'] + $siswaStats['suratIzin'] }})</span>
        </button>
    </div>

    <!-- TAB 1: REKAP KEHADIRAN GURU -->
    <div id="rekapGuruSection" style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Filter & Search Bar -->
        <div class="filter-panel-card">
            <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="filter-form-grid">
                <div style="flex: 1.5; min-width: 220px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input-styled" placeholder="Cari nama guru, mapel, kelas..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input-styled" title="Pilih Tanggal">
                </div>

                <div>
                    <select name="status_filter" class="filter-input-styled">
                        <option value="">🔘 Semua Status</option>
                        <option value="hadir" {{ $statusFilter == 'hadir' ? 'selected' : '' }}>🟢 Hadir</option>
                        <option value="izin" {{ $statusFilter == 'izin' ? 'selected' : '' }}>🟡 Izin</option>
                        <option value="tidak_hadir" {{ $statusFilter == 'tidak_hadir' ? 'selected' : '' }}>🔴 Tidak Hadir</option>
                        <option value="digantikan" {{ $statusFilter == 'digantikan' ? 'selected' : '' }}>🔵 Digantikan</option>
                    </select>
                </div>

                <div>
                    <select name="id_guru" class="filter-input-styled" style="max-width: 190px;">
                        <option value="">👥 Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_mapel" class="filter-input-styled" style="max-width: 180px;">
                        <option value="">📖 Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="id_kelas" class="filter-input-styled" style="max-width: 150px;">
                        <option value="">🏫 Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter-submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>

                    <a href="{{ route('piket.rekap-kehadiran') }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Table Panel -->
        <div class="main-table-panel">
            <div class="table-panel-header">
                <div class="table-panel-title">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Daftar Presensi & Kesiapan Guru ({{ $hariFilter }})</span>
                </div>

                <div style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                    Total: {{ $kehadiranList->total() }} Sesi Terjadwal
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="desktop-table-container">
                <table class="custom-kehadiran-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Jam Mengajar</th>
                            <th>Status Kehadiran</th>
                            <th>Keterangan / Pengganti</th>
                            <th style="width: 60px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiranList as $index => $row)
                            @php
                                $badgeClass = 'badge-status-hadir';
                                if ($row->status_key === 'tidak_hadir') $badgeClass = 'badge-status-tidak-hadir';
                                elseif ($row->status_key === 'izin') $badgeClass = 'badge-status-izin';
                                elseif ($row->status_key === 'digantikan') $badgeClass = 'badge-status-digantikan';
                            @endphp
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: #64748b;">
                                    {{ $kehadiranList->firstItem() + $index }}
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a;">{{ $row->guru_nama }}</div>
                                    <div style="font-size: 11px; color: #94a3b8;">NIP. {{ $row->guru_nip }}</div>
                                </td>
                                <td>
                                    <span style="font-weight: 700; color: #2563eb;">{{ $row->mapel_nama }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-graduation-cap" style="color: #64748b; font-size: 11px;"></i> {{ $row->kelas_nama }}</div>
                                    <div style="font-size: 11px; color: #94a3b8;"><i class="fa-solid fa-location-dot" style="font-size: 10px;"></i> {{ $row->ruangan_nama }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a;">{{ $row->jam }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $row->jam_ke }}</div>
                                </td>
                                <td>
                                    <span class="{{ $badgeClass }}">
                                        @if($row->status_key === 'hadir') <i class="fa-solid fa-circle-check"></i>
                                        @elseif($row->status_key === 'izin') <i class="fa-solid fa-clock"></i>
                                        @elseif($row->status_key === 'tidak_hadir') <i class="fa-solid fa-circle-xmark"></i>
                                        @else <i class="fa-solid fa-arrows-rotate"></i>
                                        @endif
                                        {{ $row->status_teks }}
                                    </span>
                                </td>
                                <td>
                                    @if($row->guru_pengganti_nama)
                                        <div style="font-weight: 700; color: #2563eb;">
                                            <i class="fa-solid fa-user-shield"></i> {{ $row->guru_pengganti_nama }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b;">{{ $row->keterangan }}</div>
                                    @else
                                        <span style="color: {{ $row->keterangan === '-' ? '#94a3b8' : '#334155' }}; font-weight: 600;">
                                            {{ $row->keterangan }}
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-detail" onclick="openDetailModal({{ json_encode($row) }})" title="Lihat Detail Sesi">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px 20px;">
                                    <i class="fa-regular fa-calendar-xmark" style="font-size: 38px; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                                    Tidak ada data kehadiran yang sesuai dengan kriteria pencarian / filter pada tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-list">
                @forelse($kehadiranList as $index => $row)
                    @php
                        $badgeClass = 'badge-status-hadir';
                        if ($row->status_key === 'tidak_hadir') $badgeClass = 'badge-status-tidak-hadir';
                        elseif ($row->status_key === 'izin') $badgeClass = 'badge-status-izin';
                        elseif ($row->status_key === 'digantikan') $badgeClass = 'badge-status-digantikan';
                    @endphp
                    <div class="mobile-rekap-card">
                        <div class="mobile-card-header-row">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 11px; font-weight: 800; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    #{{ $kehadiranList->firstItem() + $index }}
                                </span>
                                <span style="font-size: 11px; font-weight: 800; color: #2563eb; background: #eff6ff; padding: 2px 7px; border-radius: 6px; border: 1px solid #dbeafe;">
                                    {{ $row->jam_ke }}
                                </span>
                                <span style="font-size: 12px; font-weight: 800; color: #0f172a;">{{ $row->jam }}</span>
                            </div>
                            <span class="{{ $badgeClass }}">
                                @if($row->status_key === 'hadir') <i class="fa-solid fa-circle-check"></i>
                                @elseif($row->status_key === 'izin') <i class="fa-solid fa-clock"></i>
                                @elseif($row->status_key === 'tidak_hadir') <i class="fa-solid fa-circle-xmark"></i>
                                @else <i class="fa-solid fa-arrows-rotate"></i>
                                @endif
                                {{ $row->status_teks }}
                            </span>
                        </div>
                        <div class="mobile-card-body-row">
                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $row->guru_nama }}</div>
                            <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">NIP. {{ $row->guru_nip }}</div>
                            <div style="font-size: 13px; font-weight: 700; color: #2563eb; margin-top: 2px;">{{ $row->mapel_nama }}</div>
                            <div style="font-size: 12px; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span><i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i> {{ $row->kelas_nama }}</span>
                                <span>&bull;</span>
                                <span><i class="fa-solid fa-location-dot" style="color: #64748b;"></i> {{ $row->ruangan_nama }}</span>
                            </div>
                            @if($row->guru_pengganti_nama)
                                <div style="font-size: 12px; background: #fffbeb; border: 1px solid #fde68a; padding: 6px 10px; border-radius: 8px; margin-top: 4px;">
                                    <div style="font-weight: 700; color: #d97706;"><i class="fa-solid fa-user-shield"></i> Pengganti: {{ $row->guru_pengganti_nama }}</div>
                                    <div style="font-size: 11px; color: #78350f;">{{ $row->keterangan }}</div>
                                </div>
                            @elseif($row->keterangan && $row->keterangan !== '-')
                                <div style="font-size: 11.5px; color: #64748b; background: #f8fafc; padding: 4px 8px; border-radius: 6px; border: 1px solid #e2e8f0; margin-top: 2px;">
                                    <span style="font-weight: 700;">Ket:</span> {{ $row->keterangan }}
                                </div>
                            @endif
                        </div>
                        <div class="mobile-card-footer-row">
                            <span style="font-size: 11px; color: #94a3b8; font-weight: 600;">Sesi KBM Terjadwal</span>
                            <button type="button" class="btn-action-detail" style="width: auto; padding: 0 12px; height: 32px; gap: 6px; font-size: 12px; font-weight: 700;" onclick="openDetailModal({{ json_encode($row) }})">
                                <i class="fa-solid fa-eye"></i> <span>Detail</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 30px 16px; background: #f8fafc; border-radius: 14px; border: 1px dashed #cbd5e1;">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                        Tidak ada data kehadiran yang sesuai dengan kriteria pencarian / filter pada tanggal ini.
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            @if ($kehadiranList->hasPages())
                <div class="custom-pagination-wrapper">
                    {{-- Previous Page Link --}}
                    @if ($kehadiranList->onFirstPage())
                        <span class="page-nav-btn disabled" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $kehadiranList->previousPageUrl() }}" class="page-nav-btn" title="Halaman Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif

                    {{-- First Page & Leading Ellipsis --}}
                    @php
                        $start = max(1, $kehadiranList->currentPage() - 2);
                        $end = min($kehadiranList->lastPage(), $kehadiranList->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $kehadiranList->url(1) }}" class="page-num-btn">1</a>
                        @if ($start > 2)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $kehadiranList->currentPage())
                            <span class="page-num-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $kehadiranList->url($page) }}" class="page-num-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Trailing Ellipsis & Last Page --}}
                    @if ($end < $kehadiranList->lastPage())
                        @if ($end < $kehadiranList->lastPage() - 1)
                            <span class="page-num-ellipsis">&hellip;</span>
                        @endif
                        <a href="{{ $kehadiranList->url($kehadiranList->lastPage()) }}" class="page-num-btn">{{ $kehadiranList->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($kehadiranList->hasMorePages())
                        <a href="{{ $kehadiranList->nextPageUrl() }}" class="page-nav-btn" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span class="page-nav-btn disabled" title="Halaman Selanjutnya"><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
                <div style="text-align: center; font-size: 12px; color: #64748b; margin-top: 8px; font-weight: 600;">
                    Menampilkan {{ $kehadiranList->firstItem() ?? 0 }} - {{ $kehadiranList->lastItem() ?? 0 }} dari {{ $kehadiranList->total() }} sesi KBM
                </div>
            @endif

        </div>

    </div>

    <!-- TAB 2: REKAP KETIDAKHADIRAN SISWA -->
    <div id="rekapSiswaSection" style="display: none; flex-direction: column; gap: 20px;">

        <!-- 3 Stat Widgets Siswa -->
        <div class="siswa-grid-3">
            <div class="siswa-stat-box">
                <div class="stat-icon-wrapper stat-icon-orange">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div>
                    <div class="stat-label">Siswa Terlambat</div>
                    <div class="stat-val">{{ $siswaStats['telat'] }} Siswa</div>
                    <div class="stat-subtext">Tercatat di Piket hari ini</div>
                </div>
            </div>

            <div class="siswa-stat-box">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <div>
                    <div class="stat-label">Dispensasi Siswa</div>
                    <div class="stat-val">{{ $siswaStats['dispen'] }} Siswa</div>
                    <div class="stat-subtext">Surat tugas / dispen aktif</div>
                </div>
            </div>

            <div class="siswa-stat-box">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <div class="stat-label">Surat Izin Siswa</div>
                    <div class="stat-val">{{ $siswaStats['suratIzin'] }} Siswa</div>
                    <div class="stat-subtext">Izin / Sakit dari orang tua</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar Siswa (Global Tab 2 Filter) -->
        <div class="filter-panel-card">
            <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="filter-form-grid">
                <input type="hidden" name="tab" value="siswa">

                <div style="flex: 1.5; min-width: 220px;">
                    <input type="text" name="q" value="{{ $search }}" class="filter-input-styled" placeholder="Cari nama siswa, NISN, alasan..." style="width: 100%;">
                </div>

                <div>
                    <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input-styled" title="Pilih Tanggal Log Siswa">
                </div>

                <div>
                    <select name="id_kelas" class="filter-input-styled" style="max-width: 180px;">
                        <option value="">🏫 Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter-submit">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter Siswa
                    </button>

                    <a href="{{ route('piket.rekap-kehadiran', ['tab' => 'siswa']) }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Siswa Telat Hari Ini -->
        <div class="main-table-panel">
            <div class="table-panel-header">
                <div class="table-panel-title">
                    <i class="fa-solid fa-user-clock"></i>
                    <span>Log Siswa Terlambat ({{ $dateTitleFormatted }})</span>
                </div>

                <div class="subpanel-header-actions">
                    <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="subpanel-mini-search-form">
                        <input type="hidden" name="tab" value="siswa">
                        <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
                        @if($idKelasFilter)<input type="hidden" name="id_kelas" value="{{ $idKelasFilter }}">@endif
                        <input type="text" name="q_telat" value="{{ $qTelat }}" class="filter-input-styled" placeholder="Cari di siswa telat...">
                        <button type="submit" class="btn-filter-submit" title="Cari Siswa Telat">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if($qTelat)
                            <a href="{{ route('piket.rekap-kehadiran', array_merge(request()->except('q_telat'), ['tab' => 'siswa'])) }}" class="btn-reset-light" title="Reset Pencarian Telat">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('piket.siswa-telat') }}" class="btn-action-outline subpanel-manage-btn">
                        <span>Kelola di Siswa Telat &rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="desktop-table-container">
                <table class="custom-kehadiran-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jam Masuk</th>
                            <th>Alasan Terlambat</th>
                            <th>Tindakan / Sanksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaTelatList as $idx => $st)
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $idx + 1 }}</td>
                                <td><strong>{{ $st->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                                <td>{{ $st->kelas->nama_kelas ?? ($st->siswa->kelas->nama_kelas ?? '-') }}</td>
                                <td><span class="badge-status-tidak-hadir">{{ $st->jam_masuk ?? $st->jam_terlambat ?? '-' }}</span></td>
                                <td>{{ $st->alasan ?? '-' }}</td>
                                <td>{{ $st->tindakan ?? $st->tindakan_hukuman ?? 'Diberi Izin Masuk' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada siswa terlambat yang tercatat pada tanggal {{ $dateTitleFormatted }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-list">
                @forelse($siswaTelatList as $idx => $st)
                    <div class="mobile-rekap-card">
                        <div class="mobile-card-header-row">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 11px; font-weight: 800; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    #{{ $idx + 1 }}
                                </span>
                                <span style="font-size: 13.5px; font-weight: 800; color: #0f172a;">{{ $st->siswa->nama_siswa ?? 'Siswa' }}</span>
                            </div>
                            <span class="badge-status-tidak-hadir">
                                <i class="fa-solid fa-clock"></i> {{ $st->jam_masuk ?? $st->jam_terlambat ?? '-' }}
                            </span>
                        </div>
                        <div class="mobile-card-body-row">
                            <div style="font-size: 12px; font-weight: 700; color: #475569;">
                                <i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i> {{ $st->kelas->nama_kelas ?? ($st->siswa->kelas->nama_kelas ?? '-') }}
                            </div>
                            <div style="font-size: 12px; color: #334155; margin-top: 2px;">
                                <span class="mobile-item-label">Alasan:</span> {{ $st->alasan ?? '-' }}
                            </div>
                            <div style="font-size: 12px; color: #334155;">
                                <span class="mobile-item-label">Tindakan / Sanksi:</span> <strong>{{ $st->tindakan ?? $st->tindakan_hukuman ?? 'Diberi Izin Masuk' }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 24px 16px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        Tidak ada siswa terlambat yang tercatat pada tanggal {{ $dateTitleFormatted }}.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tabel Siswa Dispensasi Hari Ini -->
        <div class="main-table-panel">
            <div class="table-panel-header">
                <div class="table-panel-title">
                    <i class="fa-solid fa-id-card-clip"></i>
                    <span>Log Siswa Dispensasi Aktif ({{ $dateTitleFormatted }})</span>
                </div>

                <div class="subpanel-header-actions">
                    <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="subpanel-mini-search-form">
                        <input type="hidden" name="tab" value="siswa">
                        <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
                        @if($idKelasFilter)<input type="hidden" name="id_kelas" value="{{ $idKelasFilter }}">@endif
                        <input type="text" name="q_dispen" value="{{ $qDispen }}" class="filter-input-styled" placeholder="Cari di dispensasi...">
                        <button type="submit" class="btn-filter-submit" title="Cari Dispensasi">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if($qDispen)
                            <a href="{{ route('piket.rekap-kehadiran', array_merge(request()->except('q_dispen'), ['tab' => 'siswa'])) }}" class="btn-reset-light" title="Reset Pencarian Dispensasi">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('piket.dispensasi-siswa') }}" class="btn-action-outline subpanel-manage-btn">
                        <span>Kelola di Dispensasi &rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="desktop-table-container">
                <table class="custom-kehadiran-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Kegiatan Dispensasi</th>
                            <th>Waktu Dispensasi</th>
                            <th>Status Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaDispenList as $idx => $sd)
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $idx + 1 }}</td>
                                <td><strong>{{ $sd->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                                <td>{{ $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-') }}</td>
                                <td>{{ $sd->alasan ?? ($sd->tempat ?? '-') }}</td>
                                <td>{{ $sd->tanggal }} ({{ $sd->jam_keluar ?? '07:00' }} - {{ $sd->jam_kembali ?? 'Selesai' }})</td>
                                <td><span class="badge-status-hadir">{{ $sd->status_waka ?? 'Approved' }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada siswa yang dispensasi pada tanggal {{ $dateTitleFormatted }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-list">
                @forelse($siswaDispenList as $idx => $sd)
                    <div class="mobile-rekap-card">
                        <div class="mobile-card-header-row">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 11px; font-weight: 800; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    #{{ $idx + 1 }}
                                </span>
                                <span style="font-size: 13.5px; font-weight: 800; color: #0f172a;">{{ $sd->siswa->nama_siswa ?? 'Siswa' }}</span>
                            </div>
                            <span class="badge-status-hadir">
                                <i class="fa-solid fa-circle-check"></i> {{ $sd->status_waka ?? 'Approved' }}
                            </span>
                        </div>
                        <div class="mobile-card-body-row">
                            <div style="font-size: 12px; font-weight: 700; color: #475569;">
                                <i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i> {{ $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-') }}
                            </div>
                            <div style="font-size: 12px; color: #334155; margin-top: 2px;">
                                <span class="mobile-item-label">Kegiatan:</span> {{ $sd->alasan ?? ($sd->tempat ?? '-') }}
                            </div>
                            <div style="font-size: 12px; color: #2563eb; font-weight: 700;">
                                <i class="fa-regular fa-clock"></i> {{ $sd->tanggal }} ({{ $sd->jam_keluar ?? '07:00' }} - {{ $sd->jam_kembali ?? 'Selesai' }})
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 24px 16px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        Tidak ada siswa yang dispensasi pada tanggal {{ $dateTitleFormatted }}.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tabel Surat Izin Siswa Hari Ini -->
        <div class="main-table-panel">
            <div class="table-panel-header">
                <div class="table-panel-title">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <span>Log Surat Izin Siswa ({{ $dateTitleFormatted }})</span>
                </div>

                <div class="subpanel-header-actions">
                    <form action="{{ route('piket.rekap-kehadiran') }}" method="GET" class="subpanel-mini-search-form">
                        <input type="hidden" name="tab" value="siswa">
                        <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
                        @if($idKelasFilter)<input type="hidden" name="id_kelas" value="{{ $idKelasFilter }}">@endif
                        <input type="text" name="q_surat" value="{{ $qSurat }}" class="filter-input-styled" placeholder="Cari di surat izin...">
                        <button type="submit" class="btn-filter-submit" title="Cari Surat Izin">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if($qSurat)
                            <a href="{{ route('piket.rekap-kehadiran', array_merge(request()->except('q_surat'), ['tab' => 'siswa'])) }}" class="btn-reset-light" title="Reset Pencarian Surat Izin">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('piket.surat-izin-siswa') }}" class="btn-action-outline subpanel-manage-btn">
                        <span>Kelola di Surat Izin Siswa &rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="desktop-table-container">
                <table class="custom-kehadiran-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Kategori Izin</th>
                            <th>Rentang Tanggal</th>
                            <th>Keterangan / Alasan</th>
                            <th>Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaSuratIzinList as $idx => $si)
                            @php
                                $katBadgeClass = 'badge-status-izin';
                                if ($si->kategori === 'Sakit') $katBadgeClass = 'badge-status-tidak-hadir';
                                elseif ($si->kategori === 'Dispen Luar Sekolah') $katBadgeClass = 'badge-status-digantikan';

                                $statBadgeClass = 'badge-status-hadir';
                                if ($si->status === 'Menunggu') $statBadgeClass = 'badge-status-izin';
                                elseif ($si->status === 'Ditolak') $statBadgeClass = 'badge-status-tidak-hadir';
                            @endphp
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: #64748b;">{{ $idx + 1 }}</td>
                                <td>
                                    <strong>{{ $si->siswa->nama_siswa ?? 'Siswa' }}</strong>
                                    @if($si->siswa && ($si->siswa->nis || $si->siswa->nisn))
                                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">NIS: {{ $si->siswa->nis ?? $si->siswa->nisn }}</div>
                                    @endif
                                </td>
                                <td>{{ $si->kelas->nama_kelas ?? ($si->siswa->kelas->nama_kelas ?? '-') }}</td>
                                <td>
                                    <span class="{{ $katBadgeClass }}">{{ $si->kategori ?? 'Izin' }}</span>
                                </td>
                                <td>{{ $si->rentang_tanggal_text }}</td>
                                <td>{{ $si->keterangan ?? '-' }}</td>
                                <td>
                                    <span class="{{ $statBadgeClass }}">{{ $si->status ?? 'Terverifikasi' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada surat izin siswa yang tercatat pada tanggal {{ $dateTitleFormatted }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-list">
                @forelse($siswaSuratIzinList as $idx => $si)
                    @php
                        $katBadgeClass = 'badge-status-izin';
                        if ($si->kategori === 'Sakit') $katBadgeClass = 'badge-status-tidak-hadir';
                        elseif ($si->kategori === 'Dispen Luar Sekolah') $katBadgeClass = 'badge-status-digantikan';

                        $statBadgeClass = 'badge-status-hadir';
                        if ($si->status === 'Menunggu') $statBadgeClass = 'badge-status-izin';
                        elseif ($si->status === 'Ditolak') $statBadgeClass = 'badge-status-tidak-hadir';
                    @endphp
                    <div class="mobile-rekap-card">
                        <div class="mobile-card-header-row">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 11px; font-weight: 800; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    #{{ $idx + 1 }}
                                </span>
                                <span style="font-size: 13.5px; font-weight: 800; color: #0f172a;">{{ $si->siswa->nama_siswa ?? 'Siswa' }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                <span class="{{ $katBadgeClass }}">{{ $si->kategori ?? 'Izin' }}</span>
                                <span class="{{ $statBadgeClass }}">{{ $si->status ?? 'Terverifikasi' }}</span>
                            </div>
                        </div>
                        <div class="mobile-card-body-row">
                            <div style="font-size: 12px; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 8px;">
                                <span><i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i> {{ $si->kelas->nama_kelas ?? ($si->siswa->kelas->nama_kelas ?? '-') }}</span>
                                @if($si->siswa && ($si->siswa->nis || $si->siswa->nisn))
                                    <span style="font-size: 11px; color: #94a3b8; font-weight: 600;">NIS: {{ $si->siswa->nis ?? $si->siswa->nisn }}</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; color: #2563eb; font-weight: 700; margin-top: 2px;">
                                <i class="fa-regular fa-calendar-days"></i> {{ $si->rentang_tanggal_text }}
                            </div>
                            <div style="font-size: 12px; color: #334155;">
                                <span class="mobile-item-label">Alasan / Ket:</span> {{ $si->keterangan ?? '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 24px 16px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        Tidak ada surat izin siswa yang tercatat pada tanggal {{ $dateTitleFormatted }}.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- Modal Detail Sesi KBM & Kehadiran -->
<div id="modalDetailSesi" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-info" style="font-size: 18px;"></i>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Detail Presensi & Sesi KBM</h3>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: transparent; border: none; color: #ffffff; font-size: 18px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-styled">
            <div class="detail-row-item">
                <span class="detail-row-label">Nama Guru Utama:</span>
                <span class="detail-row-val" id="modalGuruNama">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">NIP Guru:</span>
                <span class="detail-row-val" id="modalGuruNip">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Mata Pelajaran:</span>
                <span class="detail-row-val" id="modalMapelNama" style="color: #2563eb;">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Kelas & Ruangan:</span>
                <span class="detail-row-val" id="modalKelasRuang">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Waktu Pelajaran:</span>
                <span class="detail-row-val" id="modalWaktu">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Status Kehadiran:</span>
                <span class="detail-row-val" id="modalStatus">-</span>
            </div>
            <div class="detail-row-item" id="modalRowPengganti" style="display: none;">
                <span class="detail-row-label">Guru Pengganti:</span>
                <span class="detail-row-val" id="modalPengganti" style="color: #2563eb; font-weight: 800;">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Keterangan / Alasan:</span>
                <span class="detail-row-val" id="modalKeterangan" style="text-align: right;">-</span>
            </div>
            <div class="detail-row-item">
                <span class="detail-row-label">Materi / Titipan:</span>
                <span class="detail-row-val" id="modalMateri" style="text-align: right;">-</span>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function switchRekapTab(tab) {
        var btnGuru = document.getElementById('tabBtnGuru');
        var btnSiswa = document.getElementById('tabBtnSiswa');
        var secGuru = document.getElementById('rekapGuruSection');
        var secSiswa = document.getElementById('rekapSiswaSection');

        if (tab === 'guru') {
            btnGuru.classList.add('active');
            btnSiswa.classList.remove('active');
            secGuru.style.display = 'flex';
            secSiswa.style.display = 'none';
        } else {
            btnSiswa.classList.add('active');
            btnGuru.classList.remove('active');
            secGuru.style.display = 'none';
            secSiswa.style.display = 'flex';
        }

        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || '{{ $activeTab ?? "guru" }}';
        if (activeTab === 'siswa') {
            switchRekapTab('siswa');
        }
    });

    function openDetailModal(data) {
        document.getElementById('modalGuruNama').textContent = data.guru_nama || '-';
        document.getElementById('modalGuruNip').textContent = data.guru_nip || '-';
        document.getElementById('modalMapelNama').textContent = data.mapel_nama || '-';
        document.getElementById('modalKelasRuang').textContent = (data.kelas_nama || '-') + ' (' + (data.ruangan_nama || '-') + ')';
        document.getElementById('modalWaktu').textContent = (data.jam_ke || '') + ' • ' + (data.jam || '');
        document.getElementById('modalStatus').textContent = data.status_teks || 'Hadir';
        document.getElementById('modalKeterangan').textContent = data.keterangan || '-';
        document.getElementById('modalMateri').textContent = data.materi || '-';

        var rowPengganti = document.getElementById('modalRowPengganti');
        if (data.guru_pengganti_nama) {
            rowPengganti.style.display = 'flex';
            document.getElementById('modalPengganti').textContent = data.guru_pengganti_nama;
        } else {
            rowPengganti.style.display = 'none';
        }

        document.getElementById('modalDetailSesi').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailSesi').style.display = 'none';
    }

    window.onclick = function(e) {
        var modal = document.getElementById('modalDetailSesi');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
@endsection