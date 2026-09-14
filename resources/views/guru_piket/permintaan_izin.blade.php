@extends('layouts.guru')

@section('title', 'Permintaan Izin Guru — Guru Piket')
@section('header_title', 'Permintaan Izin Guru')

@section('styles')
<!-- Select2 CSS for Searchable Teacher Select (NIP / Nama) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Root Page Layout */
    .permintaan-izin-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }

    /* 1. Header Card with Soft Blue Gradient & Airplane Illustration */
    .pi-header-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
        border: 1px solid #bfdbfe;
        border-radius: 20px;
        padding: 22px 28px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px -3px rgba(37, 99, 235, 0.06);
    }

    .pi-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 2;
    }

    .pi-header-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #ffffff;
        border: 1.5px solid #93c5fd;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
    }

    .pi-header-titles h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.25;
        margin: 0;
    }

    .pi-header-titles p {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .pi-header-illustration {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 1;
        opacity: 0.9;
    }

    /* Common Card Styles */
    .gp-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03);
    }

    /* Form Card Header (Clean Left-Aligned, No Doodle) */
    .gp-form-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .gp-header-icon-form {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
        color: #7c3aed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .gp-form-header-titles h2 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.25;
    }

    .gp-form-header-titles p {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
        margin-bottom: 0;
    }

    /* Form Fields & Grid */
    .gp-form-grid {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .gp-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .gp-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .gp-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .gp-label .req {
        color: #ef4444;
        font-weight: 800;
    }

    .gp-input, .gp-select, .gp-textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .gp-input:focus, .gp-select:focus, .gp-textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #ffffff;
    }

    .gp-textarea {
        resize: vertical;
        min-height: 72px;
        line-height: 1.5;
    }

    /* Select2 Custom Styling to Match Modern Theme */
    .select2-container--default .select2-selection--single {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        height: 42px !important;
        padding: 5px 8px !important;
        box-sizing: border-box !important;
        transition: border-color 0.2s ease;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 30px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }

    .select2-dropdown {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        z-index: 9999 !important;
    }

    /* Custom File Input Container */
    .gp-file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #ffffff;
        padding: 4px 8px;
        transition: border-color 0.2s ease;
    }

    .gp-file-input-wrapper:hover {
        border-color: #93c5fd;
    }

    .gp-file-input-wrapper input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .gp-file-btn {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        pointer-events: none;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .gp-file-name {
        margin-left: 10px;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Form Actions */
    .gp-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    /* Secondary Amber Button (Reset Form & Reset Filter) */
    .gp-btn-reset {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .gp-btn-reset:hover {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
        transform: translateY(-1px);
    }

    .gp-btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
        transition: all 0.2s ease;
    }

    .gp-btn-submit:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }

    /* 3. Stat Cards (4 Gradient Cards) */
    .gp-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .gp-stat-card {
        border-radius: 20px;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 94px;
        box-sizing: border-box;
        box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .gp-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.08);
    }

    /* 4 Distinct Soft Gradient Themes */
    .gp-stat-theme-blue {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid rgba(186, 230, 253, 0.7);
    }
    .gp-stat-theme-blue .gp-stat-circle-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
    .gp-stat-theme-blue .gp-stat-link {
        color: #2563eb;
    }
    .gp-stat-theme-blue .wave-theme {
        color: #0284c7;
    }

    .gp-stat-theme-green {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid rgba(167, 243, 208, 0.7);
    }
    .gp-stat-theme-green .gp-stat-circle-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }
    .gp-stat-theme-green .gp-stat-link {
        color: #059669;
    }
    .gp-stat-theme-green .wave-theme {
        color: #059669;
    }

    .gp-stat-theme-amber {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid rgba(253, 230, 138, 0.7);
    }
    .gp-stat-theme-amber .gp-stat-circle-icon {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }
    .gp-stat-theme-amber .gp-stat-link {
        color: #d97706;
    }
    .gp-stat-theme-amber .wave-theme {
        color: #d97706;
    }

    .gp-stat-theme-rose {
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        border: 1px solid rgba(254, 205, 211, 0.7);
    }
    .gp-stat-theme-rose .gp-stat-circle-icon {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        box-shadow: 0 4px 10px rgba(244, 63, 94, 0.3);
    }
    .gp-stat-theme-rose .gp-stat-link {
        color: #e11d48;
    }
    .gp-stat-theme-rose .wave-theme {
        color: #e11d48;
    }

    .gp-stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 2;
    }

    .gp-stat-circle-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .gp-stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 2px;
    }

    .gp-stat-val-group {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .gp-stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .gp-stat-unit {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
    }

    .gp-stat-link {
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        position: relative;
        z-index: 2;
        padding: 4px 8px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .gp-stat-link:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: translateX(2px);
    }

    /* Decorative Corner Elements (Sparkles) */
    .stat-corner-elem {
        position: absolute;
        top: 12px;
        right: 14px;
        z-index: 2;
        pointer-events: none;
    }

    /* Decorative Bottom-Right Wave */
    .stat-card-wave {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 90px;
        height: 48px;
        pointer-events: none;
        z-index: 1;
    }

    /* 4. Table Card & Filters */
    .gp-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03);
    }

    .gp-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .gp-table-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .gp-table-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .gp-table-title-group h2 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .gp-table-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .gp-total-badge {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        background: #f1f5f9;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .gp-btn-trash {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .gp-btn-trash:hover {
        background: #ffe4e6;
        color: #be123c;
    }

    /* Filter Bar */
    .gp-filter-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .gp-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .gp-filter-search-box {
        flex: 1;
        min-width: 240px;
        position: relative;
    }

    .gp-filter-search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .gp-filter-search-box input {
        width: 100%;
        padding: 9px 12px 9px 34px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
    }

    .gp-filter-search-box input:focus {
        border-color: #2563eb;
    }

    .gp-filter-date-box {
        min-width: 140px;
    }

    .gp-filter-date-box input {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
    }

    .gp-filter-select-box {
        min-width: 140px;
    }

    .gp-filter-select-box select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        color: #334155;
        font-weight: 600;
    }

    .gp-btn-filter-dark {
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: background 0.2s ease;
    }

    .gp-btn-filter-dark:hover {
        background: #0f172a;
    }

    .gp-btn-filter-reset {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .gp-btn-filter-reset:hover {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }

    .gp-btn-bulk-delete {
        background: #fee2e2;
        color: #ef4444;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        opacity: 0.5;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    /* Table Component */
    .gp-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .gp-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }

    .gp-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.03em;
    }

    .gp-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .gp-table tr:hover td {
        background-color: #f8fafc;
    }

    /* Table Status Badges with Colored Dots */
    .gp-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .gp-status-badge::before {
        content: "";
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .gp-status-disetujui {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }
    .gp-status-disetujui::before { background: #10b981; }

    .gp-status-menunggu {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
    }
    .gp-status-menunggu::before { background: #f59e0b; }

    .gp-status-ditolak {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #9f1239;
    }
    .gp-status-ditolak::before { background: #f43f5e; }

    .gp-badge-kategori {
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .gp-badge-biasa {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .gp-badge-cuti {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    /* Table Action Buttons */
    .gp-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .gp-action-btn:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .gp-action-wa {
        color: #16a34a;
        border-color: #bbf7d0;
        background: #f0fdf4;
    }
    .gp-action-wa:hover {
        background: #dcfce7;
        color: #15803d;
        border-color: #86efac;
    }

    .gp-action-copy {
        color: #2563eb;
        border-color: #bfdbfe;
        background: #eff6ff;
    }
    .gp-action-copy:hover {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #93c5fd;
    }

    .gp-action-edit:hover {
        color: #2563eb;
        border-color: #93c5fd;
        background: #eff6ff;
    }

    .gp-action-delete:hover {
        color: #ef4444;
        border-color: #fca5a5;
        background: #fef2f2;
    }

    /* Table Empty State */
    .gp-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 42px 16px;
        color: #94a3b8;
    }

    .gp-empty-state i {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .gp-empty-state p {
        font-size: 13.5px;
        font-weight: 600;
        margin: 0;
    }

    /* Table Footer & Pagination */
    .gp-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .gp-pagination-info {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .gp-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .gp-page-btn {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        border-radius: 7px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .gp-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    /* Modal Styles */
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

    .modal-content-custom {
        background: #ffffff;
        width: 100%;
        max-width: 680px;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .modal-title-custom {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Alerts */
    .gp-alert {
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .gp-alert-success {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .gp-alert-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }

    .mobile-pi-stat-carousel-wrap,
    .mobile-pi-section {
        display: none;
    }
    .gp-btn-text-full {
        display: inline;
    }

    @media (max-width: 1024px) {
        .gp-stat-grid { grid-template-columns: repeat(2, 1fr); }
        .pi-header-illustration { display: none; }
    }

    @media (max-width: 768px) {
        .gp-desktop-table-card,
        .gp-desktop-stat-grid {
            display: none !important;
        }
        .mobile-pi-stat-carousel-wrap,
        .mobile-pi-section {
            display: flex !important;
        }
        .permintaan-izin-wrapper {
            gap: 14px;
        }
        .pi-header-card {
            display: none !important;
        }
        .gp-card {
            padding: 16px;
            border-radius: 16px;
        }
        .gp-form-header {
            margin-bottom: 14px;
            padding-bottom: 12px;
        }
        .gp-header-icon-form {
            width: 38px;
            height: 38px;
            font-size: 17px;
            border-radius: 10px;
        }
        .gp-form-header-titles h2 {
            font-size: 15px;
        }
        .gp-form-header-titles p {
            font-size: 11.5px;
        }
        .gp-grid-2col {
            display: flex !important;
            flex-direction: column !important;
            gap: 14px !important;
        }
        .gp-input, .gp-select, .gp-textarea {
            font-size: 13px;
        }
        .gp-input, .gp-select {
            height: 42px;
            min-height: 42px;
        }
        .gp-file-input-wrapper {
            min-height: 42px;
        }
        .gp-form-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            width: 100%;
        }
        .gp-btn-reset, .gp-btn-submit {
            width: 100%;
            justify-content: center;
            height: 42px;
            min-height: 42px;
            padding: 0 10px;
            font-size: 12.5px;
            border-radius: 9px;
            gap: 6px;
            letter-spacing: 0.1px;
            white-space: nowrap;
        }
        .gp-btn-text-full {
            display: none;
        }
        .gp-btn-submit {
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }
        .gp-btn-reset {
            font-weight: 600;
            box-shadow: none;
        }
        .gp-btn-reset i, .gp-btn-submit i {
            font-size: 11.5px;
        }
        .modal-overlay {
            padding: 12px;
        }
        .modal-content-custom {
            padding: 16px;
            border-radius: 16px;
            max-height: 92vh;
        }
    }

    /* Mobile Stat Cards Carousel */
    .mobile-pi-stat-carousel-wrap {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .mobile-pi-stat-container {
        position: relative;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        touch-action: pan-y;
        background: transparent;
    }
    .mobile-pi-stat-track {
        display: flex;
        transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
        width: 100%;
    }
    .mobile-pi-stat-slide {
        flex: 0 0 100%;
        width: 100%;
        box-sizing: border-box;
    }
    .mobile-pi-stat-slide .gp-stat-card {
        width: 100%;
        margin: 0;
        border-radius: 20px;
        padding: 18px 20px;
    }
    .m-stat-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        z-index: 5;
        opacity: 0;
        pointer-events: none;
        visibility: hidden;
        transition: opacity 0.25s ease, transform 0.2s ease, visibility 0.25s ease;
    }
    .mobile-pi-stat-container:hover .m-stat-arrow,
    .mobile-pi-stat-container.is-hovered .m-stat-arrow {
        opacity: 1;
        pointer-events: auto;
        visibility: visible;
    }
    .m-stat-arrow:hover,
    .m-stat-arrow:active {
        color: #2563eb;
        background: #f8fafc;
        transform: translateY(-50%) scale(0.92);
    }
    .m-stat-prev { left: 8px; }
    .m-stat-next { right: 8px; }
    .mobile-pi-stat-dots {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    .m-stat-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #cbd5e1;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .m-stat-dot.active {
        width: 20px;
        height: 6px;
        border-radius: 9999px;
        background: #2563eb;
    }

    /* Mobile Permintaan Izin Section */
    .mobile-pi-section {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
    }
    .mobile-pi-filter-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 16px;
        padding: 14px 16px;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .mobile-pi-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .m-card-icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .m-btn-trash-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 700;
        color: #e11d48;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .m-btn-trash-pill:hover,
    .m-btn-trash-pill:active {
        background: #ffe4e6;
        border-color: #fda4af;
        color: #be123c;
    }
    .mobile-pi-search-row {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }
    .m-search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }
    .m-search-input-box {
        position: relative;
        flex: 1;
        min-width: 0;
    }
    .m-search-input-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }
    .m-search-input {
        width: 100%;
        height: 38px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 0 12px 0 34px;
        font-size: 12.5px;
        color: #1e293b;
        font-weight: 500;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .m-search-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .m-btn-filter-trigger {
        height: 38px;
        padding: 0 16px;
        border-radius: 10px;
        background: #2563eb;
        color: #ffffff;
        border: none;
        font-size: 12.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        flex-shrink: 0;
        transition: background 0.15s ease;
        position: relative;
    }
    .m-btn-filter-trigger:hover,
    .m-btn-filter-trigger:active {
        background: #1d4ed8;
    }
    .m-filter-active-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #34d399;
        border: 1.5px solid #ffffff;
        margin-left: 2px;
    }

    /* Mobile Cards List */
    .mobile-pi-cards-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }
    .mobile-pi-card-item {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: stretch;
        padding: 12px 14px 12px 10px;
        position: relative;
        overflow: hidden;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .mobile-pi-card-item.card-menunggu {
        border-color: #e2e8f0;
        background: #ffffff;
    }
    .mobile-pi-card-item.card-disetujui {
        border-color: #d1fae5;
        background: #fcfffd;
    }
    .mobile-pi-card-item.card-ditolak {
        border-color: #fee2e2;
        background: #fffcfc;
    }

    /* Left Tiered Date Column */
    .mobile-card-date-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 56px;
        padding: 2px 10px 2px 4px;
        border-right: 1px solid #f1f5f9;
        flex-shrink: 0;
    }
    .date-menunggu .m-date-day {
        font-size: 18px;
        font-weight: 800;
        color: #1e3a8a;
        line-height: 1.1;
        text-align: center;
    }
    .date-menunggu .m-date-month {
        font-size: 10px;
        font-weight: 800;
        color: #2563eb;
        margin-top: 2px;
        text-transform: uppercase;
    }
    .date-menunggu .m-date-year {
        font-size: 9.5px;
        font-weight: 600;
        color: #94a3b8;
    }

    .date-disetujui .m-date-day {
        font-size: 18px;
        font-weight: 800;
        color: #065f46;
        line-height: 1.1;
        text-align: center;
    }
    .date-disetujui .m-date-month {
        font-size: 10px;
        font-weight: 800;
        color: #059669;
        margin-top: 2px;
        text-transform: uppercase;
    }
    .date-disetujui .m-date-year {
        font-size: 9.5px;
        font-weight: 600;
        color: #94a3b8;
    }

    .date-ditolak .m-date-day {
        font-size: 18px;
        font-weight: 800;
        color: #991b1b;
        line-height: 1.1;
        text-align: center;
    }
    .date-ditolak .m-date-month {
        font-size: 10px;
        font-weight: 800;
        color: #dc2626;
        margin-top: 2px;
        text-transform: uppercase;
    }
    .date-ditolak .m-date-year {
        font-size: 9.5px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* Right Card Content */
    .mobile-card-content {
        flex: 1;
        min-width: 0;
        padding-left: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        justify-content: center;
    }
    .m-card-badges-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
    }
    .m-card-teacher-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
    }
    .m-card-sub-info {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }
    .m-card-reason-box {
        font-size: 11.5px;
        color: #334155;
        background: #f8fafc;
        padding: 5px 8px;
        border-radius: 6px;
        border: 1px solid #f1f5f9;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .m-card-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 4px;
        padding-top: 6px;
        border-top: 1px dashed #f1f5f9;
    }
    .m-card-quick-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .m-btn-card-wa {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #16a34a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        text-decoration: none;
    }
    .m-btn-card-copy {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
    }
    .m-btn-detail-link {
        font-size: 12px;
        font-weight: 700;
        color: #2563eb;
        background: none;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 6px;
        border-radius: 6px;
        transition: background 0.15s ease;
    }
    .m-btn-detail-link:hover {
        background: #eff6ff;
    }
    .m-btn-modal-delete {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .m-btn-modal-delete:hover {
        background: #ffe4e6;
        color: #be123c;
    }

    /* Mobile Pagination Card */
    .mobile-pagination-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 6px -1px rgba(0, 0, 0, 0.02);
    }
</style>
@endsection

@section('content')
<div class="permintaan-izin-wrapper">

    <!-- 1. Header Card with Soft Blue Gradient & Airplane Illustration -->
    <div class="pi-header-card">
        <div class="pi-header-left">
            <div class="pi-header-icon-box">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="pi-header-titles">
                <h1>Permintaan Izin Guru</h1>
                <p>Verifikasi dan persetujuan pengajuan izin ketidakhadiran guru harian.</p>
            </div>
        </div>

        <!-- Decorative Flight & Paper Plane Illustration -->
        <div class="pi-header-illustration">
            <svg width="180" height="70" viewBox="0 0 180 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Soft Clouds -->
                <path d="M22 52C18.6863 52 16 49.3137 16 46C16 43.2064 17.9082 40.8587 20.5284 40.1673C20.8471 36.1206 24.2359 33 28.3333 33C30.2435 33 31.9882 33.6917 33.3323 34.8398C34.4831 33.0963 36.4539 32 38.6667 32C42.1645 32 45 34.8355 45 38.3333C45 38.6854 44.9712 39.0308 44.9155 39.3672C46.7176 40.0834 48 41.8457 48 44C48 46.7614 45.7614 49 43 49L22 52Z" fill="#93c5fd" fill-opacity="0.45"/>
                <path d="M100 62C97.7909 62 96 60.2091 96 58C96 56.1376 97.2721 54.5725 99.0189 54.1115C99.2314 51.4137 101.491 49.3333 104.222 49.3333C105.496 49.3333 106.659 49.7945 107.555 50.5599C108.322 49.3975 109.636 48.6667 111.111 48.6667C113.443 48.6667 115.333 50.557 115.333 52.8889C115.333 53.1236 115.314 53.3539 115.277 53.5781C116.478 54.0556 117.333 55.2305 117.333 56.6667C117.333 58.5076 115.841 60 114 60L100 62Z" fill="#93c5fd" fill-opacity="0.35"/>
                <!-- Dotted Flight Path -->
                <path d="M35 48C70 52 110 40 145 20" stroke="#60a5fa" stroke-width="2.2" stroke-dasharray="4 4" stroke-linecap="round"/>
                <!-- Flying Paper Plane -->
                <g transform="translate(145, 6) rotate(-16)">
                    <path d="M0 13L26 0L15 26L11 15L0 13Z" fill="#2563eb"/>
                    <path d="M11 15L26 0L15 26L11 15Z" fill="#1d4ed8"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="gp-alert gp-alert-success">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>

        @if(session('approval_url'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 14px; padding: 16px 20px; margin-bottom: 6px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 800; color: #065f46;">
                        <i class="fa-brands fa-whatsapp"></i> Link Persetujuan Otomatis Siap Kirim
                    </h4>
                    <p style="margin: 0; font-size: 12.5px; color: #047857;">
                        Klik tombol Kirim WhatsApp atau Salin Link di bawah untuk meneruskan ke Waka & Kepsek:
                    </p>
                    <div style="margin-top: 8px; background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #a7f3d0; font-family: monospace; font-size: 12px; color: #0f172a; word-break: break-all; user-select: all;">
                        {{ session('approval_url') }}
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    @if(session('wa_url'))
                        <a href="{{ session('wa_url') }}" target="_blank" class="gp-btn-submit" style="background: #25d366; text-decoration: none;">
                            <i class="fa-brands fa-whatsapp"></i> Kirim WhatsApp
                        </a>
                    @endif
                    <button type="button" class="gp-btn-reset" onclick="copyToClipboard('{{ session('approval_url') }}')">
                        <i class="fa-regular fa-copy"></i> Salin Link
                    </button>
                </div>
            </div>
        </div>
        @endif
    @endif

    @if($errors->any())
        <div class="gp-alert gp-alert-danger">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
            <div>
                <strong>Terdapat kesalahan:</strong> {{ $errors->first() }}
            </div>
        </div>
    @endif

    <!-- Banner Permintaan Izin Guru Mengajar Baru (Incoming Pending Requests) -->
    @if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
        <div style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 16px; padding: 18px 22px; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.08);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: #f59e0b; color: #fff; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fa-solid fa-bell"></i>
                    </span>
                    <div>
                        <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #92400e;">
                            Ada <span id="pendingCountText">{{ $pendingRequests->count() }}</span> Permintaan Izin Guru Mengajar Baru yang Belum Diproses!
                        </h3>
                        <p style="margin: 2px 0 0 0; font-size: 12.5px; color: #b45309; font-weight: 500;">
                            Guru Mengajar mengirimkan data izin melalui web. Klik "Isi Otomatis ke Form & Proses" untuk memvalidasi.
                        </p>
                    </div>
                </div>
                <span style="background: #ffffff; border: 1px solid #fde68a; color: #b45309; font-size: 11.5px; font-weight: 800; padding: 5px 12px; border-radius: 20px;">
                    <i class="fa-solid fa-hourglass-start"></i> Menunggu Verifikasi Piket
                </span>
            </div>

            <!-- Search input for incoming requests -->
            <div style="background: #ffffff; border: 1px solid #fde68a; border-radius: 10px; padding: 8px 12px; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 220px; position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #d97706; font-size: 12.5px;"></i>
                    <input type="text" id="searchPendingInput" onkeyup="filterPendingRequests()" placeholder="Cari Nama Guru, NIP, Alasan..." style="width: 100%; padding: 6px 10px 6px 30px; border: 1px solid #fef3c7; border-radius: 6px; font-size: 12px; font-weight: 600; color: #1e293b; outline: none; background: #fffbeb;">
                </div>
                <button type="button" onclick="resetPendingFilter()" style="padding: 6px 12px; font-size: 11.5px; font-weight: 700; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; border-radius: 6px; cursor: pointer;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Cari
                </button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;" id="pendingRequestsContainer">
                @foreach($pendingRequests as $pReq)
                    <div class="pending-request-card" style="background: #ffffff; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">
                                <i class="fa-regular fa-user" style="color: #2563eb;"></i> {{ $pReq->guru->nama_guru ?? 'Guru' }} @if($pReq->guru->nip ?? null) <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">(NIP. {{ $pReq->guru->nip }})</span> @endif
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 3px;">
                                <strong>Kategori & Tanggal:</strong> 
                                <span class="gp-badge-kategori gp-badge-{{ $pReq->kategori_izin === 'cuti' ? 'cuti' : 'biasa' }}">{{ ucfirst($pReq->kategori_izin) }}</span>
                                ({{ \Carbon\Carbon::parse($pReq->tanggal_mulai)->format('d-m-Y') }} @if($pReq->tanggal_selesai && $pReq->tanggal_selesai !== $pReq->tanggal_mulai) s/d {{ \Carbon\Carbon::parse($pReq->tanggal_selesai)->format('d-m-Y') }} @endif)
                            </div>
                            <div style="font-size: 12px; color: #334155; margin-top: 3px;">
                                <strong>Alasan:</strong> "{{ $pReq->alasan }}"
                                @if($pReq->materi_dititipkan) | <strong>Materi:</strong> {{ $pReq->materi_dititipkan }} @endif
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="isiOtomatisForm({{ json_encode($pReq) }})" class="gp-btn-submit" style="padding: 8px 16px; font-size: 12px; background: #f59e0b; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);">
                                <i class="fa-solid fa-square-check"></i> Isi Otomatis ke Form & Proses
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 2. Form Card "Buat Permintaan Izin / Cuti Guru" (Clean Left-Aligned Header) -->
    <div class="gp-card">
        <div class="gp-form-header">
            <div class="gp-header-icon-form">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="gp-form-header-titles">
                <h2>Buat Permintaan Izin / Cuti Guru</h2>
                <p>Lengkapi data yang diperlukan untuk mengajukan izin ketidakhadiran.</p>
            </div>
        </div>

        <form action="{{ route('piket.permintaan-izin.store') }}" method="POST" enctype="multipart/form-data" id="formBuatIzin">
            @csrf
            <input type="hidden" name="id_guru_izin_pengajuan" id="id_guru_izin_pengajuan" value="">

            <div id="infoIsiOtomatis" style="display: none; background: #e0f2fe; border: 1px solid #7dd3fc; color: #0369a1; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 12.5px; font-weight: 700;">
            </div>

            <div class="gp-form-grid">
                
                <!-- ROW 1: Guru yang Meminta Izin & Kategori Izin -->
                <div class="gp-grid-2col">
                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-user" style="color: #2563eb;"></i>
                            <span>Guru yang meminta izin <span class="req">*</span></span>
                        </label>
                        <select name="id_guru" id="selectGuruSearch" class="gp-select" required style="width: 100%;">
                            <option value="">- Pilih Guru Mengajar -</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">
                                    {{ $g->nama_guru }} @if($g->nip) (NIP. {{ $g->nip }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <div style="font-size: 11px; color: #2563eb; font-weight: 600; margin-top: 2px;">
                            <i class="fa-solid fa-circle-info"></i> Pilih Guru Tidak Hadir (Tersedia Data Guru Izin/Sakit)
                        </div>
                    </div>

                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-solid fa-tags" style="color: #2563eb;"></i>
                            <span>Kategori Izin <span class="req">*</span></span>
                        </label>
                        <select name="kategori_izin" id="selectKategoriIzin" class="gp-select" onchange="checkDurationCategory()" required>
                            <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                            <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 2: Tanggal Mulai & Tanggal Selesai -->
                <div class="gp-grid-2col">
                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-calendar" style="color: #2563eb;"></i>
                            <span>Tanggal Mulai Izin <span class="req">*</span></span>
                        </label>
                        <input type="date" name="tanggal_mulai" id="inputTglMulai" class="gp-input" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()" required>
                    </div>

                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-calendar-check" style="color: #2563eb;"></i>
                            <span>Tanggal Selesai Izin <span class="req">*</span></span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="inputTglSelesai" class="gp-input" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()">
                    </div>
                </div>

                <!-- Banner Warning Cuti > 3 Hari -->
                <div id="bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 16px; color: #c2410c; font-size: 12.5px; font-weight: 700;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Catatan Tambahan/Keterangan Khusus & mengunggah Foto Bukti Surat Cuti!
                </div>

                <!-- ROW 3: Alasan Umum Izin -->
                <div class="gp-form-group">
                    <label class="gp-label">
                        <i class="fa-regular fa-comment-dots" style="color: #2563eb;"></i>
                        <span>Alasan Umum Izin <span class="req">*</span></span>
                    </label>
                    <textarea name="alasan" class="gp-textarea" rows="2" placeholder="Tuliskan alasan umum tidak dapat mengajar..." required></textarea>
                </div>

                <!-- ROW 4: Titipan Materi / Tugas & Upload Foto Surat / Bukti Izin -->
                <div class="gp-grid-2col">
                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-regular fa-bookmark" style="color: #2563eb;"></i>
                            <span>Titipan Materi / Tugas (Opsional)</span>
                        </label>
                        <textarea name="materi_dititipkan" class="gp-textarea" rows="2" placeholder="Tuliskan pokok bahasan / materi yang dititipkan oleh guru utama..."></textarea>
                    </div>

                    <div class="gp-form-group">
                        <label class="gp-label" id="labelFotoSurat">
                            <i class="fa-regular fa-image" style="color: #2563eb;"></i>
                            <span>Upload Foto Surat / Bukti Izin <span class="req">(Wajib Diunggah)</span></span>
                        </label>
                        <div class="gp-file-input-wrapper">
                            <button type="button" class="gp-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Pilih File
                            </button>
                            <span class="gp-file-name" id="fotoFileNameDisplay">Tidak ada file yang dipilih</span>
                            <input type="file" name="foto_surat" id="inputFotoSurat" accept="image/*" required onchange="updateFileName(this, 'fotoFileNameDisplay')">
                        </div>
                        <div id="previewFotoAutoFill" style="display: none;"></div>
                    </div>
                </div>

                <!-- ROW 5: Upload File Tugas & Catatan Tambahan Piket -->
                <div class="gp-grid-2col">
                    <div class="gp-form-group">
                        <label class="gp-label">
                            <i class="fa-solid fa-paperclip" style="color: #2563eb;"></i>
                            <span>Upload File Tugas (Opsional)</span>
                        </label>
                        <div class="gp-file-input-wrapper">
                            <button type="button" class="gp-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Pilih File
                            </button>
                            <span class="gp-file-name" id="taskFileNameDisplay">Tidak ada file yang dipilih</span>
                            <input type="file" name="file_tugas" id="inputFileTugas" onchange="updateFileName(this, 'taskFileNameDisplay')">
                        </div>
                        <div id="previewFileTugasAutoFill" style="display: none;"></div>
                    </div>

                    <div class="gp-form-group">
                        <label class="gp-label" id="labelCatatanPiket">
                            <i class="fa-regular fa-note-sticky" style="color: #2563eb;"></i>
                            <span>Catatan Tambahan Piket / Keterangan Cuti</span>
                        </label>
                        <input type="text" name="keterangan_khusus" id="inputKeteranganKhusus" class="gp-input" placeholder="Keterangan penugasan atau rincian khusus cuti...">
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="gp-form-actions">
                    <button type="button" onclick="resetFormBuatIzin()" class="gp-btn-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>
                    <button type="submit" class="gp-btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Simpan<span class="gp-btn-text-full"> Permintaan Izin Guru</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 3. 4 Kartu Statistik (Soft Gradient Cards) -->
    @php
        $totalIzin = $guruIzinList->count();
        $disetujuiCount = $guruIzinList->filter(function($i) {
            return $i->status_final === 'approved' || ($i->status_waka === 'approved' && $i->status_waka_sdm === 'approved' && $i->status_kepsek === 'approved');
        })->count();
        $ditolakCount = $guruIzinList->filter(function($i) {
            return $i->status_final === 'rejected' || $i->status_waka === 'rejected' || $i->status_waka_sdm === 'rejected' || $i->status_kepsek === 'rejected';
        })->count();
        $menungguCount = max(0, $totalIzin - $disetujuiCount - $ditolakCount);
    @endphp

    <div class="gp-stat-grid gp-desktop-stat-grid">
        <!-- Card 1: Total Permintaan (Blue) -->
        <div class="gp-stat-card gp-stat-theme-blue">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <div>
                    <div class="gp-stat-label">Total Permintaan</div>
                    <div class="gp-stat-val-group">
                        <div class="gp-stat-val">{{ $totalIzin }}</div>
                        <div class="gp-stat-unit">Permintaan</div>
                    </div>
                </div>
            </div>
            <a href="#daftarIzinTabel" class="gp-stat-link">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>
            <!-- Corner Sparkle -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#2563eb"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                <svg width="8" height="8" viewBox="0 0 24 24" fill="#2563eb" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            </div>
            <!-- Bottom Wave -->
            <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
            </svg>
        </div>

        <!-- Card 2: Disetujui (Green) -->
        <div class="gp-stat-card gp-stat-theme-green">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <div>
                    <div class="gp-stat-label">Disetujui</div>
                    <div class="gp-stat-val-group">
                        <div class="gp-stat-val">{{ $disetujuiCount }}</div>
                        <div class="gp-stat-unit">Permintaan</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('piket.permintaan-izin', ['status' => 'approved']) }}" class="gp-stat-link">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>
            <!-- Corner Sparkle -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#059669"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                <svg width="8" height="8" viewBox="0 0 24 24" fill="#059669" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            </div>
            <!-- Bottom Wave -->
            <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
            </svg>
        </div>

        <!-- Card 3: Menunggu (Amber) -->
        <div class="gp-stat-card gp-stat-theme-amber">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div>
                    <div class="gp-stat-label">Menunggu</div>
                    <div class="gp-stat-val-group">
                        <div class="gp-stat-val">{{ $menungguCount }}</div>
                        <div class="gp-stat-unit">Permintaan</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('piket.permintaan-izin', ['status' => 'pending']) }}" class="gp-stat-link">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>
            <!-- Corner Sparkle -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#d97706"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                <svg width="8" height="8" viewBox="0 0 24 24" fill="#d97706" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            </div>
            <!-- Bottom Wave -->
            <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
            </svg>
        </div>

        <!-- Card 4: Ditolak (Rose) -->
        <div class="gp-stat-card gp-stat-theme-rose">
            <div class="gp-stat-left">
                <div class="gp-stat-circle-icon">
                    <i class="fa-regular fa-circle-xmark"></i>
                </div>
                <div>
                    <div class="gp-stat-label">Ditolak</div>
                    <div class="gp-stat-val-group">
                        <div class="gp-stat-val">{{ $ditolakCount }}</div>
                        <div class="gp-stat-unit">Permintaan</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('piket.permintaan-izin', ['status' => 'rejected']) }}" class="gp-stat-link">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>
            <!-- Corner Sparkle -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#e11d48"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                <svg width="8" height="8" viewBox="0 0 24 24" fill="#e11d48" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
            </div>
            <!-- Bottom Wave -->
            <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
            </svg>
        </div>
    </div>

    <!-- 3b. Carousel 4 Kartu Statistik (Mobile View) -->
    <div class="mobile-pi-stat-carousel-wrap">
        <div class="mobile-pi-stat-container" id="mobileStatContainer">
            <div class="mobile-pi-stat-track" id="mobileStatTrack">
                
                <!-- Slide 1: Total Permintaan -->
                <div class="mobile-pi-stat-slide">
                    <div class="gp-stat-card gp-stat-theme-blue">
                        <div class="gp-stat-left">
                            <div class="gp-stat-circle-icon">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <div>
                                <div class="gp-stat-label">Total Permintaan</div>
                                <div class="gp-stat-val-group">
                                    <div class="gp-stat-val">{{ $totalIzin }}</div>
                                    <div class="gp-stat-unit">Permintaan</div>
                                </div>
                            </div>
                        </div>
                        <a href="#daftarIzinTabel" class="gp-stat-link">
                            Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#2563eb"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="#2563eb" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                            <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
                        </svg>
                    </div>
                </div>

                <!-- Slide 2: Disetujui -->
                <div class="mobile-pi-stat-slide">
                    <div class="gp-stat-card gp-stat-theme-green">
                        <div class="gp-stat-left">
                            <div class="gp-stat-circle-icon">
                                <i class="fa-regular fa-circle-check"></i>
                            </div>
                            <div>
                                <div class="gp-stat-label">Disetujui</div>
                                <div class="gp-stat-val-group">
                                    <div class="gp-stat-val">{{ $disetujuiCount }}</div>
                                    <div class="gp-stat-unit">Permintaan</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('piket.permintaan-izin', ['status' => 'approved']) }}" class="gp-stat-link">
                            Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#059669"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="#059669" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                            <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
                        </svg>
                    </div>
                </div>

                <!-- Slide 3: Menunggu -->
                <div class="mobile-pi-stat-slide">
                    <div class="gp-stat-card gp-stat-theme-amber">
                        <div class="gp-stat-left">
                            <div class="gp-stat-circle-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <div class="gp-stat-label">Menunggu</div>
                                <div class="gp-stat-val-group">
                                    <div class="gp-stat-val">{{ $menungguCount }}</div>
                                    <div class="gp-stat-unit">Permintaan</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('piket.permintaan-izin', ['status' => 'pending']) }}" class="gp-stat-link">
                            Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#d97706"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="#d97706" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                            <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
                        </svg>
                    </div>
                </div>

                <!-- Slide 4: Ditolak -->
                <div class="mobile-pi-stat-slide">
                    <div class="gp-stat-card gp-stat-theme-rose">
                        <div class="gp-stat-left">
                            <div class="gp-stat-circle-icon">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </div>
                            <div>
                                <div class="gp-stat-label">Ditolak</div>
                                <div class="gp-stat-val-group">
                                    <div class="gp-stat-val">{{ $ditolakCount }}</div>
                                    <div class="gp-stat-unit">Permintaan</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('piket.permintaan-izin', ['status' => 'rejected']) }}" class="gp-stat-link">
                            Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: center; opacity: 0.55;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#e11d48"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="#e11d48" style="margin-top: -6px;"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                        </div>
                        <svg class="stat-card-wave wave-theme" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 45C35 45 45 20 80 30C115 40 125 15 140 20V70H0V45Z" fill="currentColor" fill-opacity="0.08"/>
                            <path d="M0 55C40 55 55 35 90 42C125 49 130 30 140 35V70H0V55Z" fill="currentColor" fill-opacity="0.14"/>
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Navigation Arrows -->
            <button type="button" class="m-stat-arrow m-stat-prev" id="statPrevBtn" onclick="prevStatSlide()" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-stat-arrow m-stat-next" id="statNextBtn" onclick="nextStatSlide()" aria-label="Selanjutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Dot Indicators (4 Dots) -->
        <div class="mobile-pi-stat-dots" id="mobileStatDots">
            <span class="m-stat-dot active" onclick="goToStatSlide(0)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(1)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(2)"></span>
            <span class="m-stat-dot" onclick="goToStatSlide(3)"></span>
        </div>
    </div>

    <!-- 4. Table Card "Daftar Permintaan Izin Guru" (Desktop View) -->
    <div class="gp-table-card gp-desktop-table-card" id="daftarIzinTabel">
        <div class="gp-table-header">
            <div class="gp-table-title-group">
                <div class="gp-table-icon-box">
                    <i class="fa-regular fa-rectangle-list"></i>
                </div>
                <h2>Daftar Permintaan Izin Guru</h2>
            </div>
            <div class="gp-table-header-right">
                <span class="gp-total-badge">Total: {{ $guruIzinList->count() }} Pengajuan</span>
                <a href="{{ route('piket.permintaan-izin.trash') }}" class="gp-btn-trash" title="Lihat Data Sampah">
                    <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="gp-filter-bar">
            <form action="{{ route('piket.permintaan-izin') }}" method="GET" class="gp-filter-form">
                <!-- Search Input -->
                <div class="gp-filter-search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama Guru, NIP, Alasan...">
                </div>

                <!-- Status Filter -->
                <div class="gp-filter-select-box">
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div class="gp-filter-date-box">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" title="Filter Tanggal">
                </div>

                <button type="submit" class="gp-btn-filter-dark">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <a href="{{ route('piket.permintaan-izin') }}" class="gp-btn-filter-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <!-- Contextual Bulk Delete Button -->
                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="gp-btn-bulk-delete" title="Hapus Data Terpilih">
                    <i class="fa-regular fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </form>
        </div>

        <!-- Table Responsive -->
        <div class="gp-table-wrapper">
            <table class="gp-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer; accent-color: #2563eb;">
                        </th>
                        <th style="width: 50px; text-align: center;">NO</th>
                        <th>GURU</th>
                        <th>TANGGAL & WAKTU</th>
                        <th>KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>ALASAN</th>
                        <th>STATUS</th>
                        <th style="text-align: center; width: 180px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinList as $iz)
                        @php
                            $tokenUrl = url("/approval/guru-izin/{$iz->token_approval}");
                            $isCutiRow = ($iz->kategori_izin === 'cuti') || ($iz->tanggal_mulai && $iz->tanggal_selesai && \Carbon\Carbon::parse($iz->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($iz->tanggal_selesai)) + 1 > 3);

                            $waTextTable = rawurlencode("Assalamu'alaikum Wr. Wb. Bapak/Ibu Waka & Kepala Sekolah,\n\n"
                                . "Berikut pengajuan " . ($isCutiRow ? "CUTI / IZIN KHUSUS (> 3 HARI)" : "IZIN TIDAK HADIR") . " mengajar:\n"
                                . "• Guru: " . ($iz->guru->nama_guru ?? 'Guru') . "\n"
                                . "• Tanggal: " . ($iz->tanggal_mulai ?? '-') . "\n"
                                . "• Alasan: " . $iz->alasan . "\n\n"
                                . "Mohon dapat meninjau dan memilih persetujuan pada link berikut:\n\n"
                                . $tokenUrl . "\n\n"
                                . "Terima kasih.");
                            $waUrlTable = "https://api.whatsapp.com/send?text=" . $waTextTable;

                            $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                            $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved') || ($iz->status_final === 'approved');

                            $detailData = [
                                'id_guru_izin' => $iz->id_guru_izin,
                                'nama_guru' => $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                                'nip' => $iz->guru->nip ?? '-',
                                'tanggal' => ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y'),
                                'durasi' => $iz->durasi ?? '1 Hari Full',
                                'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                                'is_cuti' => $isCutiRow,
                                'alasan' => $iz->alasan,
                                'keterangan_khusus' => $iz->keterangan_khusus ?? '-',
                                'materi' => $iz->materi_dititipkan ?? '-',
                                'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                                'file_tugas_url' => $iz->file_tugas_url,
                                'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                                'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                                'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                                'catatan_waka' => $iz->catatan_waka ?? '-',
                                'catatan_kepsek' => $iz->catatan_kepsek ?? '-',
                                'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                                'link' => $tokenUrl,
                            ];

                            $editData = [
                                'id_guru_izin' => $iz->id_guru_izin,
                                'id_guru' => $iz->id_guru,
                                'tanggal_mulai' => $iz->tanggal_mulai,
                                'tanggal_selesai' => $iz->tanggal_selesai,
                                'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                                'alasan' => $iz->alasan,
                                'keterangan_khusus' => $iz->keterangan_khusus,
                                'materi_dititipkan' => $iz->materi_dititipkan,
                                'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                                'file_tugas_url' => $iz->file_tugas_url,
                            ];

                            // Resolve kelas if available via wali kelas or assignment
                            $kelasNama = '-';
                            if ($iz->guru && $iz->guru->kelasWali && $iz->guru->kelasWali->isNotEmpty()) {
                                $kelasNama = $iz->guru->kelasWali->first()->nama_kelas;
                            }
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="permintaan-izin-checkbox" value="{{ $iz->id_guru_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer; accent-color: #2563eb;">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 13px;">
                                    {{ $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}
                                </div>
                                @if($iz->guru && $iz->guru->nip)
                                    <div style="font-size: 11px; color: #64748b; margin-top: 1px;">NIP. {{ $iz->guru->nip }}</div>
                                @endif
                            </td>
                            <td style="white-space: nowrap; font-weight: 600; color: #475569;">
                                <div>
                                    @if($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d/m/Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d/m/Y') }}
                                    @endif
                                </div>
                                <div style="margin-top: 3px;">
                                    @if($isCutiRow)
                                        <span class="gp-badge-kategori gp-badge-cuti"><i class="fa-solid fa-ribbon"></i> Cuti (>3 Hari)</span>
                                    @else
                                        <span class="gp-badge-kategori gp-badge-biasa">Izin Biasa</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 11.5px; color: #334155;">
                                    {{ $kelasNama }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #0f172a;">
                                    {{ $iz->guru->mapel->nama_mapel ?? '-' }}
                                </span>
                            </td>
                            <td style="max-width: 220px;">
                                <div style="color: #334155; font-weight: 500; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $iz->alasan }}
                                </div>
                                @if($isCutiRow && $iz->keterangan_khusus)
                                    <div style="font-size: 11px; color: #c2410c; margin-top: 3px; background: #fff7ed; padding: 2px 6px; border-radius: 4px; border: 1px solid #fed7aa; display: inline-block;">
                                        <strong>Ket:</strong> {{ Str::limit($iz->keterangan_khusus, 40) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($isRejectedRow)
                                    <span class="gp-status-badge gp-status-ditolak">Ditolak</span>
                                @elseif($isApprovedFullRow)
                                    <span class="gp-status-badge gp-status-disetujui">Disetujui</span>
                                @else
                                    <span class="gp-status-badge gp-status-menunggu">Menunggu</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                    <a href="{{ $waUrlTable }}" target="_blank" class="gp-action-btn gp-action-wa" title="Kirim Link via WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                    <button type="button" class="gp-action-btn gp-action-copy" onclick="copyToClipboard('{{ $tokenUrl }}')" title="Salin Link Persetujuan">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <button type="button" class="gp-action-btn" onclick='openDetailModal({{ json_encode($detailData) }})' title="Lihat Detail">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <button type="button" class="gp-action-btn gp-action-edit" onclick='openEditModal({{ json_encode($editData) }})' title="Edit Permintaan Izin">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('piket.permintaan-izin.destroy', $iz->id_guru_izin) }}" method="POST" onsubmit="return confirm('Pindahkan data izin guru ini ke Sampah?');" style="display: inline; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="gp-action-btn gp-action-delete" title="Pindahkan ke Sampah">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="gp-empty-state">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <p>Belum ada data permintaan izin guru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="gp-table-footer">
            <div class="gp-pagination-info">
                Menampilkan {{ $guruIzinList->count() > 0 ? 1 : 0 }} - {{ $guruIzinList->count() }} dari {{ $guruIzinList->count() }} data
            </div>
            <div class="gp-pagination">
                <span class="gp-page-btn" style="opacity: 0.5;"><i class="fa-solid fa-angle-left"></i></span>
                <span class="gp-page-btn active">1</span>
                <span class="gp-page-btn" style="opacity: 0.5;"><i class="fa-solid fa-angle-right"></i></span>
            </div>
        </div>
    </div>

    <!-- 4b. Mobile Permintaan Izin Section (Filter Card + Cards List) -->
    <div class="mobile-pi-section">
        
        <!-- Filter Card Mobile -->
        <div class="mobile-pi-filter-card">
            <div class="mobile-pi-filter-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="m-card-icon-wrap">
                        <i class="fa-regular fa-rectangle-list"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Daftar Permintaan Izin</h2>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 1px;">
                            Total: {{ $guruIzinList->count() }} Pengajuan
                        </div>
                    </div>
                </div>
                <a href="{{ route('piket.permintaan-izin.trash') }}" class="m-btn-trash-pill" title="Lihat Data Sampah">
                    <i class="fa-regular fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>
            </div>

            <!-- Search Bar + Filter Trigger Button -->
            <div class="mobile-pi-search-row">
                <form action="{{ route('piket.permintaan-izin') }}" method="GET" class="m-search-form">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('tanggal'))
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    @endif
                    <div class="m-search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Guru / NIP / Alasan..." class="m-search-input">
                    </div>
                    <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()">
                        <i class="fa-solid fa-filter"></i> Filter
                        @if(request('status') || request('tanggal'))
                            <span class="m-filter-active-dot"></span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Cards List Mobile -->
        <div class="mobile-pi-cards-list">
            @forelse($guruIzinList as $iz)
                @php
                    $startDate = \Carbon\Carbon::parse($iz->tanggal_mulai);
                    $endDate = $iz->tanggal_selesai ? \Carbon\Carbon::parse($iz->tanggal_selesai) : $startDate;
                    $isMultiDay = ($iz->tanggal_selesai && $iz->tanggal_mulai !== $iz->tanggal_selesai);
                    
                    if (!$isMultiDay) {
                        $dayDisplay = $startDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } elseif ($startDate->format('m Y') === $endDate->format('m Y')) {
                        $dayDisplay = $startDate->format('d') . '-' . $endDate->format('d');
                        $monthDisplay = strtoupper($startDate->translatedFormat('M') ?: $startDate->format('M'));
                        $yearDisplay = $startDate->format('Y');
                    } else {
                        $dayDisplay = $startDate->format('d/m') . '-' . $endDate->format('d/m');
                        $monthDisplay = $startDate->format('Y');
                        $yearDisplay = '';
                    }

                    $isCutiRow = ($iz->kategori_izin === 'cuti') || ($iz->tanggal_mulai && $iz->tanggal_selesai && \Carbon\Carbon::parse($iz->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($iz->tanggal_selesai)) + 1 > 3);
                    $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                    $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved') || ($iz->status_final === 'approved');

                    $cardStatusClass = $isRejectedRow ? 'card-ditolak' : ($isApprovedFullRow ? 'card-disetujui' : 'card-menunggu');
                    $dateThemeClass = $isRejectedRow ? 'date-ditolak' : ($isApprovedFullRow ? 'date-disetujui' : 'date-menunggu');

                    $tokenUrl = url("/approval/guru-izin/{$iz->token_approval}");
                    $waTextCard = rawurlencode("Assalamu'alaikum Wr. Wb. Bapak/Ibu Waka & Kepala Sekolah,\n\n"
                        . "Berikut pengajuan " . ($isCutiRow ? "CUTI / IZIN KHUSUS (> 3 HARI)" : "IZIN TIDAK HADIR") . " mengajar:\n"
                        . "• Guru: " . ($iz->guru->nama_guru ?? 'Guru') . "\n"
                        . "• Tanggal: " . ($iz->tanggal_mulai ?? '-') . "\n"
                        . "• Alasan: " . $iz->alasan . "\n\n"
                        . "Mohon dapat meninjau dan memilih persetujuan pada link berikut:\n\n"
                        . $tokenUrl . "\n\n"
                        . "Terima kasih.");
                    $waUrlCard = "https://api.whatsapp.com/send?text=" . $waTextCard;

                    $detailData = [
                        'id_guru_izin' => $iz->id_guru_izin,
                        'nama_guru' => $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                        'nip' => $iz->guru->nip ?? '-',
                        'tanggal' => ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai) ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y'),
                        'durasi' => $iz->durasi ?? '1 Hari Full',
                        'kategori_izin' => $iz->kategori_izin ?? 'biasa',
                        'is_cuti' => $isCutiRow,
                        'alasan' => $iz->alasan,
                        'keterangan_khusus' => $iz->keterangan_khusus ?? '-',
                        'materi' => $iz->materi_dititipkan ?? '-',
                        'foto_url' => $iz->foto_surat ? asset('uploads/guru_izin/' . $iz->foto_surat) : null,
                        'file_tugas_url' => $iz->file_tugas_url,
                        'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                        'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                        'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                        'catatan_waka' => $iz->catatan_waka ?? '-',
                        'catatan_kepsek' => $iz->catatan_kepsek ?? '-',
                        'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                        'link' => $tokenUrl,
                        'delete_url' => route('piket.permintaan-izin.destroy', $iz->id_guru_izin),
                    ];
                @endphp

                <div class="mobile-pi-card-item {{ $cardStatusClass }}">
                    <!-- Left Tiered Date -->
                    <div class="mobile-card-date-col {{ $dateThemeClass }}">
                        <span class="m-date-day">{{ $dayDisplay }}</span>
                        <span class="m-date-month">{{ $monthDisplay }}</span>
                        @if($yearDisplay)
                            <span class="m-date-year">{{ $yearDisplay }}</span>
                        @endif
                    </div>

                    <!-- Right Card Content -->
                    <div class="mobile-card-content">
                        <!-- Badges Row -->
                        <div class="m-card-badges-row">
                            <div>
                                @if($isCutiRow)
                                    <span class="gp-badge-kategori gp-badge-cuti"><i class="fa-solid fa-ribbon"></i> Cuti</span>
                                @else
                                    <span class="gp-badge-kategori gp-badge-biasa">Izin Biasa</span>
                                @endif
                            </div>
                            <div>
                                @if($isRejectedRow)
                                    <span class="gp-status-badge gp-status-ditolak">Ditolak</span>
                                @elseif($isApprovedFullRow)
                                    <span class="gp-status-badge gp-status-disetujui">Disetujui</span>
                                @else
                                    <span class="gp-status-badge gp-status-menunggu">Menunggu</span>
                                @endif
                            </div>
                        </div>

                        <!-- Teacher Name & Info -->
                        <div>
                            <div class="m-card-teacher-name">
                                {{ $iz->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}
                            </div>
                            <div class="m-card-sub-info">
                                @if($iz->guru && $iz->guru->nip) NIP. {{ $iz->guru->nip }} • @endif {{ $iz->guru->mapel->nama_mapel ?? '-' }}
                            </div>
                        </div>

                        <!-- Reason Snippet -->
                        <div class="m-card-reason-box">
                            "{{ Str::limit($iz->alasan, 65) }}"
                        </div>

                        <!-- Footer Actions -->
                        <div class="m-card-footer-row">
                            <div class="m-card-quick-actions">
                                <a href="{{ $waUrlCard }}" target="_blank" class="m-btn-card-wa" title="Kirim Link via WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <button type="button" class="m-btn-card-copy" onclick="copyToClipboard('{{ $tokenUrl }}')" title="Salin Link Persetujuan">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                            <button type="button" class="m-btn-detail-link" onclick='openDetailModal({{ json_encode($detailData) }})'>
                                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="gp-card" style="text-align: center; padding: 36px 16px;">
                    <div class="gp-empty-state">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>Belum ada data permintaan izin guru.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Mobile Pagination Card -->
        @if($guruIzinList->count() > 0)
            <div class="mobile-pagination-card">
                <span style="font-size: 11.5px; font-weight: 600; color: #64748b;">
                    Total: {{ $guruIzinList->count() }} Data
                </span>
                <span class="gp-page-btn active" style="min-width: 28px; height: 28px;">1</span>
            </div>
        @endif
    </div>
</div>

<!-- Modal Filter Mobile -->
<div id="mobileFilterModal" class="modal-overlay">
    <div class="modal-content-custom" style="max-width: 420px;">
        <div class="modal-header-custom">
            <div class="modal-title-custom">
                <i class="fa-solid fa-filter" style="color: #2563eb;"></i>
                <span>Filter Permintaan Izin</span>
            </div>
            <button type="button" onclick="closeMobileFilterModal()" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('piket.permintaan-izin') }}" method="GET">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            <div class="gp-form-grid" style="gap: 12px;">
                <div class="gp-form-group">
                    <label class="gp-label"><i class="fa-solid fa-list-check" style="color: #2563eb;"></i> Status Permintaan</label>
                    <select name="status" class="gp-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="gp-form-group">
                    <label class="gp-label"><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> Tanggal Izin</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="gp-input">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; margin-top: 18px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('piket.permintaan-izin') }}" class="gp-btn-reset" style="text-decoration: none; justify-content: center; height: 42px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                <button type="submit" class="gp-btn-submit" style="justify-content: center; height: 42px;">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Lihat Detail Lengkap -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <div class="modal-title-custom">
                <i class="fa-regular fa-file-lines" style="color: #2563eb;"></i>
                <span>Detail Permintaan Izin Guru</span>
            </div>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body-custom">
            <div id="dt_cuti_badge_container" style="display: none; margin-bottom: 14px; background: #fff7ed; border: 1px solid #fed7aa; padding: 10px 14px; border-radius: 10px; color: #c2410c; font-weight: 800; font-size: 12.5px;">
                <i class="fa-solid fa-ribbon"></i> KATEGORI: CUTI / IZIN KHUSUS (> 3 HARI)
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">NAMA GURU</div>
                    <div id="dt_nama_guru" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;"></div>
                    <div id="dt_nip" style="font-size: 11.5px; color: #64748b;"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">TANGGAL & DURASI</div>
                    <div id="dt_tanggal_durasi" style="font-size: 13.5px; font-weight: 700; color: #2563eb; margin-top: 2px;"></div>
                </div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">ALASAN KETIDAKHADIRAN</div>
                <div id="dt_alasan" style="font-size: 13px; color: #1e293b; margin-top: 4px; background: #f8fafc; padding: 10px 12px; border-radius: 8px; border: 1px solid #e2e8f0;"></div>
            </div>

            <div id="dt_keterangan_khusus_container" style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; display: none;">
                <div style="font-size: 11px; font-weight: 700; color: #c2410c; text-transform: uppercase;">CATATAN KHUSUS CUTI (> 3 HARI)</div>
                <div id="dt_keterangan_khusus" style="font-size: 13px; color: #9a3412; margin-top: 4px; background: #fff7ed; padding: 10px 12px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">TITIPAN MATERI / TUGAS</div>
                <div id="dt_materi" style="font-size: 13px; color: #334155; margin-top: 3px;"></div>
            </div>

            <div id="dt_foto_container" style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; display: none;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">FOTO SURAT BUKTI IZIN</div>
                <div style="text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 6px;">
                    <img id="dt_foto_img" src="" alt="Foto Surat" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: contain;">
                </div>
                <div>
                    <a id="dt_foto_link" href="" target="_blank" style="color: #2563eb; font-size: 12.5px; font-weight: 700; text-decoration: underline;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Foto Ukuran Penuh
                    </a>
                </div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">STATUS PERSETUJUAN BERJENJANG</div>
                <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12.5px; color: #334155;">
                    <div><strong>Waka Kurikulum:</strong> <span id="dt_status_waka"></span></div>
                    <div><strong>Waka SDM:</strong> <span id="dt_status_waka_sdm"></span></div>
                    <div><strong>Kepala Sekolah:</strong> <span id="dt_status_kepsek"></span></div>
                </div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 12px;">
                <strong style="color: #475569;">Link Persetujuan Publik:</strong><br>
                <span id="dt_link_display" style="font-family: monospace; color: #2563eb; font-weight: 700; word-break: break-all; user-select: all; display: inline-block; margin-top: 3px;"></span>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px; padding-top: 14px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 8px;">
            <form id="formDeleteDetail" method="POST" onsubmit="return confirm('Pindahkan data izin guru ini ke Sampah?');" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-btn-modal-delete">
                    <i class="fa-regular fa-trash-can"></i> Pindahkan ke Sampah
                </button>
            </form>
            <button type="button" class="gp-btn-submit" onclick="closeDetailModal()">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit Data Permintaan Izin -->
<div id="editModal" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <div class="modal-title-custom">
                <i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i>
                <span>Edit Permintaan Izin Guru</span>
            </div>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="gp-form-grid">
                <div class="gp-form-group">
                    <label class="gp-label">Guru Mengajar <span class="req">*</span></label>
                    <select name="id_guru" id="edit_id_guru" class="gp-select" required style="width: 100%;">
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} @if($g->nip) (NIP. {{ $g->nip }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Kategori Izin <span class="req">*</span></label>
                    <select name="kategori_izin" id="edit_kategori_izin" class="gp-select" onchange="checkEditDurationCategory()">
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>

                <div class="gp-grid-2col">
                    <div class="gp-form-group">
                        <label class="gp-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="gp-input" onchange="checkEditDurationCategory()" required>
                    </div>
                    <div class="gp-form-group">
                        <label class="gp-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="gp-input" onchange="checkEditDurationCategory()">
                    </div>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Alasan Izin <span class="req">*</span></label>
                    <textarea name="alasan" id="edit_alasan" class="gp-textarea" rows="2" required></textarea>
                </div>

                <div id="editKeteranganKhususContainer" style="display: none; background: #fff7ed; padding: 12px; border-radius: 10px; border: 1px solid #fed7aa;">
                    <label class="gp-label" style="color: #c2410c;">
                        <i class="fa-solid fa-note-sticky"></i> Keterangan Khusus Cuti (> 3 Hari) <span class="req">*Wajib Diisi</span>
                    </label>
                    <textarea name="keterangan_khusus" id="edit_keterangan_khusus" class="gp-textarea" rows="2" placeholder="Tuliskan keterangan khusus Cuti..."></textarea>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" id="edit_materi_dititipkan" class="gp-input">
                </div>

                <div class="gp-form-group">
                    <label class="gp-label" id="editLabelFotoSurat">Upload Foto Surat / Bukti Baru</label>
                    <div class="gp-file-input-wrapper">
                        <button type="button" class="gp-file-btn">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Pilih File
                        </button>
                        <span class="gp-file-name" id="editFotoFileNameDisplay">Pilih file foto jika ingin mengganti...</span>
                        <input type="file" name="foto_surat" id="edit_foto_surat" accept="image/*" onchange="updateFileName(this, 'editFotoFileNameDisplay')">
                    </div>
                    <div id="edit_piket_foto_preview_container" style="display: none; margin-top: 8px;">
                        <small style="font-size: 11.5px; font-weight: 700; color: #1e40af; display: block; margin-bottom: 4px;">Foto Bukti Saat Ini:</small>
                        <a id="edit_piket_foto_link" href="#" target="_blank">
                            <img id="edit_piket_foto_img" src="" alt="Pratinjau Foto" style="max-height: 100px; border-radius: 8px; border: 1px solid #93c5fd; object-fit: contain;">
                        </a>
                    </div>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Upload File Tugas Baru (Opsional)</label>
                    <div class="gp-file-input-wrapper">
                        <button type="button" class="gp-file-btn">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Pilih File
                        </button>
                        <span class="gp-file-name" id="editTaskFileNameDisplay">Pilih file jika ingin mengganti...</span>
                        <input type="file" name="file_tugas" id="edit_piket_file_tugas" onchange="updateFileName(this, 'editTaskFileNameDisplay')">
                    </div>
                    <div id="edit_piket_file_preview_container" style="display: none; margin-top: 6px;">
                        <small style="font-size: 11.5px; color: #2563eb; font-weight: 700;">
                            <i class="fa-solid fa-file-arrow-down"></i> <a id="edit_piket_file_link" href="#" target="_blank" style="color: #2563eb; text-decoration: underline;">Unduh File Tugas Saat Ini</a>
                        </small>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="gp-btn-reset" onclick="closeEditModal()">
                        Batal
                    </button>
                    <button type="submit" class="gp-btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Massal (Bulk Delete) -->
<div id="bulkDeleteModal" class="modal-overlay">
    <div class="modal-content-custom" style="max-width: 440px; text-align: center;">
        <div style="width: 56px; height: 56px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto; color: #ef4444; font-size: 24px;">
            <i class="fa-regular fa-trash-can"></i>
        </div>
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">Pindahkan ke Sampah?</h3>
        <p style="font-size: 13px; color: #64748b; font-weight: 500; margin: 0 0 20px 0; line-height: 1.5;">
            Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data permintaan izin guru terpilih ke Sampah?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" onclick="closeBulkDeleteModal()" class="gp-btn-reset">
                Batal
            </button>
            <button type="button" onclick="executeBulkDelete()" class="gp-btn-submit" style="background: #ef4444;">
                <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
            </button>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Bulk Delete -->
<form id="bulkDeleteForm" action="{{ route('piket.permintaan-izin.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
let currentStatSlide = 0;
const totalStatSlides = 4;

function updateStatCarousel() {
    const track = document.getElementById('mobileStatTrack');
    if (!track) return;
    track.style.transform = 'translateX(-' + (currentStatSlide * 100) + '%)';
    
    const dots = document.querySelectorAll('#mobileStatDots .m-stat-dot');
    dots.forEach((dot, idx) => {
        if (idx === currentStatSlide) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

function nextStatSlide() {
    currentStatSlide = (currentStatSlide + 1) % totalStatSlides;
    updateStatCarousel();
}

function prevStatSlide() {
    currentStatSlide = (currentStatSlide - 1 + totalStatSlides) % totalStatSlides;
    updateStatCarousel();
}

function goToStatSlide(index) {
    currentStatSlide = index;
    updateStatCarousel();
}

function initStatCarousel() {
    const container = document.getElementById('mobileStatContainer');
    if (!container) return;

    let touchStartX = 0;
    let touchEndX = 0;

    container.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    container.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleStatSwipe();
    }, { passive: true });

    function handleStatSwipe() {
        const swipeThreshold = 40;
        if (touchEndX < touchStartX - swipeThreshold) {
            nextStatSlide();
        } else if (touchEndX > touchStartX + swipeThreshold) {
            prevStatSlide();
        }
    }
}

function openMobileFilterModal() {
    const modal = document.getElementById('mobileFilterModal');
    if (modal) modal.style.display = 'flex';
}

function closeMobileFilterModal() {
    const modal = document.getElementById('mobileFilterModal');
    if (modal) modal.style.display = 'none';
}

$(document).ready(function() {
    $('#selectGuruSearch').select2({
        placeholder: "Cari NIP atau Nama Guru...",
        allowClear: true
    });
    initStatCarousel();
});

function updateFileName(input, targetId) {
    const display = document.getElementById(targetId);
    if (display) {
        if (input.files && input.files[0]) {
            display.textContent = input.files[0].name;
            display.style.color = '#0f172a';
            display.style.fontWeight = '700';
        } else {
            display.textContent = 'Tidak ada file yang dipilih';
            display.style.color = '#64748b';
            display.style.fontWeight = '500';
        }
    }
}

function checkDurationCategory() {
    const tglMulai = document.getElementById('inputTglMulai').value;
    let tglSelesai = document.getElementById('inputTglSelesai').value;
    const kategori = document.getElementById('selectKategoriIzin').value;

    if (tglMulai && tglSelesai && tglSelesai < tglMulai) {
        alert('Peringatan: Tanggal Selesai Izin (' + tglSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tglMulai + ')!');
        document.getElementById('inputTglSelesai').value = tglMulai;
        tglSelesai = tglMulai;
    }

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const banner = document.getElementById('bannerCutiWarning');
    const labelFoto = document.getElementById('labelFotoSurat');
    const inputFoto = document.getElementById('inputFotoSurat');
    const inputKet = document.getElementById('inputKeteranganKhusus');
    const hasAutoFillPhoto = document.getElementById('previewFotoAutoFill') && document.getElementById('previewFotoAutoFill').style.display !== 'none';

    if (isCuti) {
        document.getElementById('selectKategoriIzin').value = 'cuti';
        if (banner) banner.style.display = 'block';
        if (inputKet) inputKet.setAttribute('required', 'required');

        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = '<i class="fa-regular fa-image" style="color: #2563eb;"></i> <span>Upload Foto Surat Cuti <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span></span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = '<i class="fa-regular fa-image" style="color: #2563eb;"></i> <span>Upload Foto Surat Cuti <span class="req">*Wajib Diunggah</span></span>';
        }
    } else {
        if (banner) banner.style.display = 'none';
        if (inputKet) inputKet.removeAttribute('required');
        
        if (hasAutoFillPhoto) {
            inputFoto.removeAttribute('required');
            labelFoto.innerHTML = '<i class="fa-regular fa-image" style="color: #2563eb;"></i> <span>Upload Foto Surat / Bukti Izin <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span></span>';
        } else {
            inputFoto.setAttribute('required', 'required');
            labelFoto.innerHTML = '<i class="fa-regular fa-image" style="color: #2563eb;"></i> <span>Upload Foto Surat / Bukti Izin <span class="req">(Wajib Diunggah)</span></span>';
        }
    }
}

function checkEditDurationCategory() {
    const tglMulai = document.getElementById('edit_tanggal_mulai').value;
    let tglSelesai = document.getElementById('edit_tanggal_selesai').value || tglMulai;
    const kategori = document.getElementById('edit_kategori_izin').value;

    let isCuti = false;
    if (tglMulai && tglSelesai) {
        let start = new Date(tglMulai);
        let end = new Date(tglSelesai);
        let diffTime = end.getTime() - start.getTime();
        let diffDays = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

        if (diffDays > 3 || kategori === 'cuti') {
            isCuti = true;
        }
    }

    const container = document.getElementById('editKeteranganKhususContainer');
    const inputKet = document.getElementById('edit_keterangan_khusus');

    if (isCuti) {
        document.getElementById('edit_kategori_izin').value = 'cuti';
        if (container) container.style.display = 'block';
        if (inputKet) inputKet.setAttribute('required', 'required');
    } else {
        if (container) container.style.display = 'none';
        if (inputKet) inputKet.removeAttribute('required');
    }
}

function copyToClipboard(text) {
    let tempTextArea = document.createElement("textarea");
    tempTextArea.value = text;
    tempTextArea.style.position = "fixed";
    tempTextArea.style.left = "-9999px";
    document.body.appendChild(tempTextArea);
    tempTextArea.focus();
    tempTextArea.select();

    try {
        let successful = document.execCommand('copy');
        if (successful) {
            alert('Link approval persetujuan berhasil disalin ke clipboard!');
        } else {
            prompt('Salin link persetujuan berikut secara manual:', text);
        }
    } catch (err) {
        prompt('Salin link persetujuan berikut secara manual:', text);
    }
    document.body.removeChild(tempTextArea);
}

function openDetailModal(data) {
    document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
    document.getElementById('dt_nip').innerText = data.nip ? ('NIP. ' + data.nip) : '';
    document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari Full') + ')';
    document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
    document.getElementById('dt_materi').innerText = data.materi || '-';
    document.getElementById('dt_status_waka').innerText = (data.status_waka || 'Pending') + ' (' + (data.catatan_waka || '-') + ')';
    document.getElementById('dt_status_waka_sdm').innerText = data.status_waka_sdm || 'Pending';
    document.getElementById('dt_status_kepsek').innerText = (data.status_kepsek || 'Pending') + ' (' + (data.catatan_kepsek || '-') + ')';
    document.getElementById('dt_link_display').innerText = data.link || '-';

    const cutiBadge = document.getElementById('dt_cuti_badge_container');
    const ketKhususContainer = document.getElementById('dt_keterangan_khusus_container');

    if (data.is_cuti || data.kategori_izin === 'cuti') {
        if (cutiBadge) cutiBadge.style.display = 'block';
        if (data.keterangan_khusus && data.keterangan_khusus !== '-') {
            document.getElementById('dt_keterangan_khusus').innerText = data.keterangan_khusus;
            if (ketKhususContainer) ketKhususContainer.style.display = 'block';
        } else {
            if (ketKhususContainer) ketKhususContainer.style.display = 'none';
        }
    } else {
        if (cutiBadge) cutiBadge.style.display = 'none';
        if (ketKhususContainer) ketKhususContainer.style.display = 'none';
    }

    let fotoContainer = document.getElementById('dt_foto_container');
    if (data.foto_url) {
        document.getElementById('dt_foto_img').src = data.foto_url;
        document.getElementById('dt_foto_link').href = data.foto_url;
        if (fotoContainer) fotoContainer.style.display = 'block';
    } else {
        if (fotoContainer) fotoContainer.style.display = 'none';
    }

    if (data.delete_url) {
        const formDel = document.getElementById('formDeleteDetail');
        if (formDel) formDel.action = data.delete_url;
    }

    document.getElementById('detailModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function openEditModal(data) {
    document.getElementById('editForm').action = "{{ url('/guru-piket/permintaan-izin') }}/" + data.id_guru_izin;
    document.getElementById('edit_id_guru').value = data.id_guru;
    
    if (window.jQuery && $.fn.select2) {
        $('#edit_id_guru').trigger('change');
    }

    document.getElementById('edit_kategori_izin').value = data.kategori_izin || 'biasa';
    document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
    document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || data.tanggal_mulai;
    document.getElementById('edit_alasan').value = data.alasan;
    document.getElementById('edit_keterangan_khusus').value = data.keterangan_khusus || '';
    document.getElementById('edit_materi_dititipkan').value = data.materi_dititipkan || '';

    const fotoPreviewContainer = document.getElementById('edit_piket_foto_preview_container');
    const editFotoInput = document.getElementById('edit_foto_surat');

    if (data.foto_url) {
        document.getElementById('edit_piket_foto_img').src = data.foto_url;
        document.getElementById('edit_piket_foto_link').href = data.foto_url;
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'block';
        if (editFotoInput) editFotoInput.removeAttribute('required');
    } else {
        if (fotoPreviewContainer) fotoPreviewContainer.style.display = 'none';
    }

    checkEditDurationCategory();
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function isiOtomatisForm(pReq) {
    document.getElementById('id_guru_izin_pengajuan').value = pReq.id_guru_izin;
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val(pReq.id_guru).trigger('change');
    } else {
        document.getElementById('selectGuruSearch').value = pReq.id_guru;
    }
    
    document.getElementById('inputTglMulai').value = pReq.tanggal_mulai;
    document.getElementById('inputTglSelesai').value = pReq.tanggal_selesai || pReq.tanggal_mulai;
    document.getElementById('selectKategoriIzin').value = pReq.kategori_izin || 'biasa';

    if (document.getElementsByName('alasan')[0]) {
        document.getElementsByName('alasan')[0].value = pReq.alasan || '';
    }
    if (document.getElementById('inputKeteranganKhusus') && pReq.keterangan_khusus) {
        document.getElementById('inputKeteranganKhusus').value = pReq.keterangan_khusus;
    }
    if (document.getElementsByName('materi_dititipkan')[0]) {
        document.getElementsByName('materi_dititipkan')[0].value = pReq.materi_dititipkan || '';
    }

    const inputFoto = document.getElementById('inputFotoSurat');
    let previewBox = document.getElementById('previewFotoAutoFill');
    if (pReq.foto_surat) {
        const fotoUrl = "{{ asset('uploads/guru_izin') }}/" + pReq.foto_surat;
        previewBox.style.display = 'block';
        previewBox.innerHTML = `
            <div style="margin-top: 8px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 11.5px; font-weight: 700; color: #1e40af;"><i class="fa-solid fa-image"></i> Foto Pengajuan Terlampir</span>
                <a href="${fotoUrl}" target="_blank" style="font-size: 11.5px; font-weight: 700; color: #2563eb; text-decoration: underline;">Lihat Foto</a>
            </div>
        `;
        if (inputFoto) inputFoto.removeAttribute('required');
    } else {
        previewBox.style.display = 'none';
        previewBox.innerHTML = '';
    }

    checkDurationCategory();

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'block';
        infoBox.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Data pengajuan dari Guru Mengajar (' + (pReq.guru ? pReq.guru.nama_guru : 'Guru') + ') telah diisikan otomatis ke form. Silakan periksa dan simpan.';
    }

    document.getElementById('formBuatIzin').scrollIntoView({ behavior: 'smooth' });
}

function filterPendingRequests() {
    const input = document.getElementById('searchPendingInput');
    if (!input) return;
    const query = input.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.pending-request-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countSpan = document.getElementById('pendingCountText');
    if (countSpan) countSpan.innerText = visibleCount;
}

function resetPendingFilter() {
    const input = document.getElementById('searchPendingInput');
    if (input) {
        input.value = '';
        filterPendingRequests();
    }
}

function resetFormBuatIzin() {
    const form = document.getElementById('formBuatIzin');
    if (form) form.reset();
    
    document.getElementById('id_guru_izin_pengajuan').value = '';
    
    if (window.jQuery && $.fn.select2) {
        $('#selectGuruSearch').val('').trigger('change');
    } else if (document.getElementById('selectGuruSearch')) {
        document.getElementById('selectGuruSearch').value = '';
    }

    const todayStr = "{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}";
    document.getElementById('inputTglMulai').value = todayStr;
    document.getElementById('inputTglSelesai').value = todayStr;
    document.getElementById('selectKategoriIzin').value = 'biasa';

    document.getElementById('fotoFileNameDisplay').textContent = 'Tidak ada file yang dipilih';
    document.getElementById('taskFileNameDisplay').textContent = 'Tidak ada file yang dipilih';

    const infoBox = document.getElementById('infoIsiOtomatis');
    if (infoBox) {
        infoBox.style.display = 'none';
        infoBox.innerHTML = '';
    }

    const previewBox = document.getElementById('previewFotoAutoFill');
    if (previewBox) {
        previewBox.style.display = 'none';
        previewBox.innerHTML = '';
    }

    checkDurationCategory();
}

function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
    });
    updateSelectedState();
}

function updateSelectedState() {
    const checkboxes = document.querySelectorAll('.permintaan-izin-checkbox');
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
    const btnBulk = document.getElementById('btnBulkDelete');
    const selectedCountSpan = document.getElementById('selectedCount');
    const selectAllCb = document.getElementById('selectAllCheckbox');

    const count = checkedBoxes.length;
    if (selectedCountSpan) selectedCountSpan.textContent = count;

    if (selectAllCb && checkboxes.length > 0) {
        selectAllCb.checked = (checkboxes.length === count);
    }

    if (btnBulk) {
        if (count > 0) {
            btnBulk.style.opacity = '1';
            btnBulk.style.pointerEvents = 'auto';
            btnBulk.style.background = '#ef4444';
            btnBulk.style.color = '#ffffff';
            btnBulk.style.borderColor = '#ef4444';
        } else {
            btnBulk.style.opacity = '0.5';
            btnBulk.style.pointerEvents = 'none';
            btnBulk.style.background = '#fee2e2';
            btnBulk.style.color = '#ef4444';
            btnBulk.style.borderColor = '#fca5a5';
        }
    }
}

function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan pilih minimal satu data permintaan izin yang ingin dihapus.');
        return;
    }

    document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
    document.getElementById('bulkDeleteModal').style.display = 'flex';
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').style.display = 'none';
}

function executeBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.permintaan-izin-checkbox:checked');
    const container = document.getElementById('bulkDeleteInputsContainer');
    container.innerHTML = '';

    checkedBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });

    document.getElementById('bulkDeleteForm').submit();
}
</script>
@endsection
